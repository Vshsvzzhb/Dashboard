const {
  default: makeWASocket,
  useMultiFileAuthState,
  DisconnectReason,
  fetchLatestBaileysVersion,
  delay,
} = require('@whiskeysockets/baileys');
const express = require('express');
const cors    = require('cors');
const pino    = require('pino');
const qrcode  = require('qrcode');
const fs      = require('fs');
const path    = require('path');

const app  = express();
const PORT = process.env.WA_PORT || 4000;

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// ─── State ──────────────────────────────────────────────────────────────────
// Map of sessions: sessionId -> { sock, connectionState, latestQR }
const sessions = new Map();
const AUTH_DIR_BASE = path.join(__dirname, 'wa_auth');

if (!fs.existsSync(AUTH_DIR_BASE)) {
  fs.mkdirSync(AUTH_DIR_BASE, { recursive: true });
}

// ─── Load Existing Sessions ──────────────────────────────────────────────────
function loadExistingSessions() {
  const dirs = fs.readdirSync(AUTH_DIR_BASE);
  let hasDefault = false;
  for (const dir of dirs) {
    const dirPath = path.join(AUTH_DIR_BASE, dir);
    if (fs.statSync(dirPath).isDirectory()) {
      connectToWA(dir);
      if (dir === 'default') hasDefault = true;
    }
  }
  if (!hasDefault) {
    connectToWA('default');
  }
}

// ─── Connect to WhatsApp ─────────────────────────────────────────────────────
async function connectToWA(sessionId = 'default') {
  console.log(`[WA-Engine] 🔄 Connecting to WhatsApp for session: ${sessionId}...`);
  
  if (!sessions.has(sessionId)) {
    sessions.set(sessionId, {
      sock: null,
      connectionState: 'connecting',
      latestQR: null
    });
  }
  const session = sessions.get(sessionId);
  session.connectionState = 'connecting';

  const sessionAuthDir = path.join(AUTH_DIR_BASE, sessionId);
  const { state, saveCreds } = await useMultiFileAuthState(sessionAuthDir);
  const { version }          = await fetchLatestBaileysVersion();

  session.sock = makeWASocket({
    version,
    logger: pino({ level: 'silent' }),
    printQRInTerminal: true,
    auth: state,
    browser: ['WAGateway', 'Chrome', '120.0.0'],
    generateHighQualityLinkPreview: false,
  });

  // ── Connection Update ──────────────────────────────────────────────────────
  session.sock.ev.on('connection.update', async (update) => {
    const { connection, lastDisconnect, qr } = update;

    if (qr) {
      session.latestQR = await qrcode.toDataURL(qr);
      console.log(`[WA-Engine] [${sessionId}] QR Code ready`);
    }

    if (connection === 'open') {
      session.connectionState = 'open';
      session.latestQR        = null;
      console.log(`[WA-Engine] [${sessionId}] WhatsApp CONNECTED!`);
    }

    if (connection === 'close') {
      session.connectionState = 'close';
      const statusCode    = lastDisconnect?.error?.output?.statusCode;
      const shouldReconnect = statusCode !== DisconnectReason.loggedOut;

      console.log(`[WA-Engine] [${sessionId}] ❌ Disconnected. Code: ${statusCode} | Reconnect: ${shouldReconnect}`);

      if (shouldReconnect) {
        console.log(`[WA-Engine] [${sessionId}] 🔁 Reconnecting in 5 seconds...`);
        setTimeout(() => connectToWA(sessionId), 5000);
      } else {
        if (statusCode === DisconnectReason.loggedOut) {
          console.log(`[WA-Engine] [${sessionId}] 🚪 Logged out. Auto-clearing wa_auth folder...`);
          fs.rmSync(sessionAuthDir, { recursive: true, force: true });
          
          if (sessionId === 'default') {
             console.log(`[WA-Engine] [${sessionId}] 🔄 Restarting connection in 3 seconds to generate new QR...`);
             setTimeout(() => connectToWA(sessionId), 3000);
          } else {
             sessions.delete(sessionId);
             console.log(`[WA-Engine] [${sessionId}] 🛑 Session removed.`);
          }
        } else {
          console.log(`[WA-Engine] [${sessionId}] 🛑 Disconnected completely.`);
        }
      }
    }
  });

  session.sock.ev.on('creds.update', saveCreds);

  // Handle incoming messages
  session.sock.ev.on('messages.upsert', async ({ messages }) => {
    for (const msg of messages) {
      if (!msg.key.fromMe && msg.message) {
        const from = msg.key.remoteJid;
        if (from.endsWith('@g.us')) continue; 
        
        const text = (msg.message?.conversation || msg.message?.extendedTextMessage?.text || '').trim().toLowerCase();
        console.log(`[WA-Engine] [${sessionId}] 📩 Incoming from ${from}: ${text}`);

        if (['halo', 'hallo', 'menu', 'help', 'bantuan', 'info', 'ping'].includes(text)) {
           const menuMsg = `Halo! 👋 Selamat datang di Layanan Otomatis VetenCall.\n\nSilakan balas dengan *ANGKA* pilihan menu di bawah ini:\n\n*1.* ℹ️ Info Layanan & Fitur\n*2.* 📞 Hubungi Customer Service\n*3.* 📅 Cek Jam Operasional\n*4.* 📍 Lokasi Kantor Kami\n\n_Ketik *MENU* kapan saja untuk kembali ke daftar ini._`;
           await session.sock.sendMessage(from, { text: menuMsg });
        }
        else if (text === '1') {
           await session.sock.sendMessage(from, { text: `*Info Layanan VetenCall* 🚀\n\nKami menyediakan layanan WhatsApp Gateway Blasting & PBX VoIP terintegrasi untuk memaksimalkan efisiensi komunikasi korporat Anda.` });
        }
        else if (text === '2') {
           await session.sock.sendMessage(from, { text: `*Hubungi Customer Service* 📞\n\nSilakan gunakan aplikasi VetenCall Anda untuk menelpon Ekstensi CS kami di: *1001*\nAtau kirimkan email ke: support@vetencall.com` });
        }
        else if (text === '3') {
           await session.sock.sendMessage(from, { text: `*Jam Operasional* 📅\n\nSenin - Jumat: 08:00 - 17:00 WIB\nSabtu - Minggu: Offline (Hanya layanan darurat)` });
        }
        else if (text === '4') {
           await session.sock.sendMessage(from, { text: `*Lokasi Kantor* 📍\n\nJl. Inovasi Digital No. 99\nSCBD, Jakarta Selatan, Indonesia.` });
        }
      }
    }
  });
}

// ─── Helper: Format nomor telepon & grup ─────────────────────────────────────
function formatPhone(phone) {
  let p = String(phone);
  if (p.endsWith('@g.us') || p.endsWith('@lid')) return p;
  
  p = p.replace(/\D/g, '');
  if (p.startsWith('0')) p = '62' + p.slice(1);
  if (!p.endsWith('@s.whatsapp.net')) p = p + '@s.whatsapp.net';
  return p;
}

function getActiveSession(req) {
  let sessionId = req.query.session || req.body.session || 'default';
  if (!sessions.has(sessionId)) {
    // Fallback to first connected session if requested one is missing
    const connected = Array.from(sessions.entries()).find(([_, s]) => s.connectionState === 'open');
    if (connected) return { id: connected[0], session: connected[1] };
    return { id: sessionId, session: sessions.get('default') };
  }
  return { id: sessionId, session: sessions.get(sessionId) };
}

// ─── API Routes ──────────────────────────────────────────────────────────────

// GET / — Health check
app.get('/', (req, res) => {
  const { session } = getActiveSession(req);
  res.json({
    app:       'WAGateway Engine v3 (Multi-Device)',
    status:    session?.connectionState || 'close',
    connected: session?.connectionState === 'open',
    qr_ready:  !!session?.latestQR,
    active_sessions: sessions.size,
    time:      new Date().toISOString(),
  });
});

// GET /status
app.get('/status', (req, res) => {
  const { session } = getActiveSession(req);
  res.json({
    status:    session?.connectionState || 'close',
    connected: session?.connectionState === 'open',
    qr_ready:  !!session?.latestQR,
    active_sessions: sessions.size,
  });
});

// POST /create-session
app.post('/create-session', (req, res) => {
  const newSessionId = 'device_' + Math.floor(Math.random() * 10000);
  connectToWA(newSessionId);
  // Redirect back to QR page with new session
  setTimeout(() => res.redirect('/qr?session=' + newSessionId), 500);
});

// GET /qr — Halaman scan QR via browser
app.get('/qr', (req, res) => {
  let currentSessionId = req.query.session || 'default';
  
  if (!sessions.has(currentSessionId) && currentSessionId !== 'default') {
     return res.redirect('/qr');
  }

  const allSessions = Array.from(sessions.keys());
  
  const sessionSelectorHtml = `
    <div style="margin-bottom: 20px; display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; background: #f8fafc; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0;">
      <div style="width: 100%; text-align: left; font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Select Device:</div>
      ${allSessions.map(id => {
        const s = sessions.get(id);
        const icon = s.connectionState === 'open' ? '<span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#10b981;"></span>' : (s.latestQR ? '<span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#eab308;"></span>' : '<span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#ef4444;"></span>');
        return `<a href="/qr?session=${id}" style="padding: 6px 12px; border-radius: 20px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 4px; ${id === currentSessionId ? 'background: #2563eb; color: white; box-shadow: 0 2px 4px rgba(37,99,235,0.2);' : 'background: #ffffff; color: #475569; border: 1px solid #cbd5e1;'}">${icon} ${id}</a>`;
      }).join('')}
      <form method="POST" action="/create-session" style="display:inline; margin: 0;">
        <button type="submit" style="padding: 6px 12px; border-radius: 20px; border: 1px dashed #94a3b8; background: transparent; color: #475569; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px;"><i data-lucide="plus" style="width:14px;height:14px;"></i> Add Device</button>
      </form>
    </div>
  `;

  const session = sessions.get(currentSessionId);
  const state = session ? session.connectionState : 'close';
  const qr = session ? session.latestQR : null;

  if (state === 'open') {
    return res.send(`
      <!DOCTYPE html>
      <html>
      <head><title>WAGateway - Connected</title>
      <script src="https://unpkg.com/lucide@latest"></script>
      <style>body{font-family:'Segoe UI',sans-serif;background:transparent;color:#0f172a;text-align:center;padding:10px;} .icon { width: 48px; height: 48px; margin-bottom: 16px; color: #10b981; }</style>
      </head>
      <body>
        ${sessionSelectorHtml}
        <i data-lucide="check-circle-2" class="icon"></i>
        <h1 style="color:#10b981; margin-bottom: 4px; font-size: 1.5rem;">WhatsApp Connected!</h1>
        <p style="color:#64748b">Device: <strong>${currentSessionId}</strong><br>Session aktif. Engine berjalan normal.</p>
        
        <div style="margin-top: 24px; display: flex; gap: 12px; justify-content: center;">
            <a href="/status?session=${currentSessionId}" target="_blank" style="color:#2563eb; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600; background: #eff6ff; padding: 8px 16px; border-radius: 8px;"><i data-lucide="activity" style="width:16px;height:16px;"></i> API Status</a>
            <form method="POST" action="/logout?session=${currentSessionId}" style="display:inline; margin: 0;">
                <button type="submit" style="color:#ef4444; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600; background: #fef2f2; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-family: inherit;"><i data-lucide="log-out" style="width:16px;height:16px;"></i> Disconnect</button>
            </form>
        </div>
        <script>lucide.createIcons();</script>
      </body></html>
    `);
  }

  if (!qr) {
    return res.send(`
      <!DOCTYPE html>
      <html>
      <head>
        <title>WAGateway - Loading QR</title>
        <meta http-equiv="refresh" content="3">
        <script src="https://unpkg.com/lucide@latest"></script>
        <style>body{font-family:'Segoe UI',sans-serif;background:transparent;color:#0f172a;text-align:center;padding:10px;} .icon { width: 48px; height: 48px; margin-bottom: 16px; color: #2563eb; animation: spin 2s linear infinite; } @keyframes spin { 100% { transform: rotate(360deg); } }</style>
      </head>
      <body>
        ${sessionSelectorHtml}
        <i data-lucide="loader-2" class="icon"></i>
        <h1 style="color:#0f172a; font-size: 1.5rem; margin-bottom: 4px;">Generating QR Code...</h1>
        <p style="color:#64748b">Halaman otomatis refresh dalam 3 detik...</p>
        <script>lucide.createIcons();</script>
      </body></html>
    `);
  }

  res.send(`
    <!DOCTYPE html>
    <html>
    <head>
      <title>WAGateway — Scan QR</title>
      <meta http-equiv="refresh" content="30">
      <script src="https://unpkg.com/lucide@latest"></script>
      <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: transparent; color: #0f172a; display: flex; flex-direction: column; align-items: center; padding: 10px; }
        .card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; text-align: center; max-width: 400px; width: 100%; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); margin-top: 10px; }
        h1 { font-size: 1.25rem; color: #0f172a; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 700; }
        p  { color: #64748b; font-size: 0.9rem; line-height: 1.6; margin-bottom: 16px; }
        img { border: 2px solid #e2e8f0; border-radius: 12px; max-width: 100%; height: auto; }
        .badge { background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb; padding: 6px 16px; border-radius: 100px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; margin-top: 16px; }
      </style>
    </head>
    <body>
      <div style="width: 100%; max-width: 400px;">
        ${sessionSelectorHtml}
      </div>
      <div class="card">
        <h1><i data-lucide="zap" style="color: #2563eb; width: 20px; height: 20px;"></i> WAGateway Engine</h1>
        <p>Device: <strong>${currentSessionId}</strong><br>
           Buka WhatsApp di HP Anda<br>
           <strong style="color:#0f172a; display:inline-flex; align-items:center; gap:4px; margin-top:6px; margin-bottom:6px;"><i data-lucide="settings" style="width:14px;height:14px;"></i> Settings → Linked Devices → Link a Device</strong><br>
           kemudian scan QR di bawah ini:</p>
        <img src="${qr}" width="240" height="240">
        <div class="badge"><i data-lucide="refresh-cw" style="width:12px;height:12px;"></i> Auto-refresh 30s</div>
      </div>
      <script>lucide.createIcons();</script>
    </body>
    </html>
  `);
});

// GET /groups — Ambil daftar semua Grup WA di mana nomor bot bergabung
app.get('/groups', async (req, res) => {
  const { id, session } = getActiveSession(req);
  if (!session || session.connectionState !== 'open') {
    return res.status(503).json({ success: false, error: 'WhatsApp not connected.' });
  }
  try {
    const groups = await session.sock.groupFetchAllParticipating();
    const groupList = Object.values(groups).map(g => ({
      id: g.id,
      name: g.subject,
      participants_count: g.participants.length
    }));
    res.json({ success: true, session: id, count: groupList.length, data: groupList });
  } catch (err) {
    console.error(`[WA-Engine] [${id}] Error fetching groups:`, err.message);
    res.status(500).json({ success: false, error: err.message });
  }
});

// GET /groups/:id/members — Ambil daftar member dari sebuah grup
app.get('/groups/:id/members', async (req, res) => {
  const { id: sessionId, session } = getActiveSession(req);
  if (!session || session.connectionState !== 'open') {
    return res.status(503).json({ success: false, error: 'WhatsApp not connected.' });
  }
  try {
    let groupId = req.params.id;
    if (!groupId.endsWith('@g.us')) groupId += '@g.us';
    const metadata = await session.sock.groupMetadata(groupId);
    const members = metadata.participants.map(p => {
      if (p.id.includes('@lid')) return p.id;
      let num = p.id.split('@')[0];
      return num.split(':')[0];
    });
    res.json({ success: true, session: sessionId, group: metadata.subject, count: members.length, data: members });
  } catch (err) {
    console.error(`[WA-Engine] [${sessionId}] Error fetching members for ${req.params.id}:`, err.message);
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /send-message — Kirim ke satu nomor
app.post('/send-message', async (req, res) => {
  const { id: sessionId, session } = getActiveSession(req);
  if (!session || session.connectionState !== 'open') {
    return res.status(503).json({ success: false, error: 'WhatsApp not connected.' });
  }

  const { phone, message } = req.body;
  if (!phone || !message) {
    return res.status(400).json({ success: false, error: 'phone and message are required.' });
  }

  try {
    const jid = formatPhone(phone);
    await session.sock.sendMessage(jid, { text: message });
    console.log(`[WA-Engine] [${sessionId}] ✉️ Sent to ${jid}: "${message.slice(0, 40)}..."`);
    res.json({ success: true, session: sessionId, to: jid });
  } catch (err) {
    console.error(`[WA-Engine] [${sessionId}] Send error:`, err.message);
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /send-bulk — Kirim ke banyak nomor
app.post('/send-bulk', async (req, res) => {
  const { id: sessionId, session } = getActiveSession(req);
  if (!session || session.connectionState !== 'open') {
    return res.status(503).json({ success: false, error: 'WhatsApp not connected.' });
  }

  const { recipients, message, delay_ms = 3000 } = req.body;

  if (!recipients || !Array.isArray(recipients) || recipients.length === 0) {
    return res.status(400).json({ success: false, error: 'recipients (array) and message are required.' });
  }

  res.json({
    success: true,
    session: sessionId,
    queued:  recipients.length,
    message: `Bulk send started via ${sessionId}. ${recipients.length} messages queued with ${delay_ms}ms delay.`,
  });

  (async () => {
    let sent = 0, failed = 0;
    console.log(`[WA-Engine] [${sessionId}] Starting bulk send to ${recipients.length} recipients...`);

    for (const phone of recipients) {
      try {
        const jid = formatPhone(phone);
        await session.sock.sendMessage(jid, { text: message });
        sent++;
        console.log(`[WA-Engine] [${sessionId}]  [${sent}/${recipients.length}] Sent to ${jid}`);
      } catch (e) {
        failed++;
        console.error(`[WA-Engine] [${sessionId}] Failed to ${phone}:`, e.message);
      }
      if (delay_ms > 0) await delay(delay_ms);
    }

    console.log(`[WA-Engine] [${sessionId}] Bulk done! Sent: ${sent} | Failed: ${failed}`);
  })();
});

// POST /logout — Hapus sesi & reconnect
app.post('/logout', async (req, res) => {
  const logoutSessionId = req.query.session || 'default';
  
  if (!sessions.has(logoutSessionId)) {
    return res.redirect('/qr');
  }
  
  const session = sessions.get(logoutSessionId);
  try {
    await session.sock?.logout();
  } catch (e) {
    console.error(`[WA-Engine] [${logoutSessionId}] Logout error:`, e.message);
  }
  
  const sessionAuthDir = path.join(AUTH_DIR_BASE, logoutSessionId);
  if (fs.existsSync(sessionAuthDir)) {
    fs.rmSync(sessionAuthDir, { recursive: true, force: true });
  }
  
  if (logoutSessionId === 'default') {
     session.connectionState = 'close';
     session.latestQR = null;
     setTimeout(() => connectToWA('default'), 2000);
     res.redirect('/qr?session=default');
  } else {
     sessions.delete(logoutSessionId);
     res.redirect('/qr'); // Redirect back to default or available sessions
  }
});

// ─── Start Server ─────────────────────────────────────────────────────────────
app.listen(PORT, '0.0.0.0', () => {
  console.log('\n╔══════════════════════════════════════╗');
  console.log('║        WAGateway Engine v3           ║');
  console.log('║       (Multi-Device Support)         ║');
  console.log(`║  Running on port ${PORT}                ║`);
  console.log(`║  Scan QR → http://localhost:${PORT}/qr  ║`);
  console.log('╚══════════════════════════════════════╝\n');
});

loadExistingSessions();
