@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">WebRTC Softphone</h1>
            <p style="color: var(--text-secondary); margin-top: 8px; font-size: 1.05rem;">Web-based VoIP client for RPL Team.</p>
        </div>
    </div>

    {{-- Mic Permission Banner --}}
    <div id="mic_banner" style="display:none; background: #fef3c7; border: 1px solid #f59e0b; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
        <span style="font-size: 1.4rem;"></span>
        <div style="flex: 1;">
            <div style="font-weight: 700; color: #92400e; font-size: 0.9rem;">Izin Mikrofon Diperlukan</div>
            <div style="color: #78350f; font-size: 0.82rem; margin-top: 2px;">Klik tombol di bawah atau klik ikon lock di address bar → Microphone → Allow</div>
        </div>
        <button onclick="requestMicPermission()" style="background: #f59e0b; color: white; border: none; border-radius: 8px; padding: 8px 16px; font-weight: 700; cursor: pointer; font-size: 0.85rem; white-space: nowrap;">Izinkan Mikrofon</button>
    </div>

    <div style="display: flex; gap: 32px; align-items: flex-start; justify-content: center;">
        
        {{-- Settings Panel --}}
        <div class="glass-panel" style="width: 350px; padding: 24px; background: #ffffff;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #111827; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="settings" style="width: 18px; height: 18px; color: var(--text-secondary);"></i> SIP Configuration
            </h3>
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px;">WebSocket URI</label>
                <input type="text" id="sip_ws" value="ws://52.2.21.5:8088/ws" style="width: 100%; border: 1px solid var(--surface-border); border-radius: 8px; padding: 10px; font-size: 0.9rem; font-weight: 600;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px;">SIP Domain/Host</label>
                <input type="text" id="sip_domain" value="52.2.21.5" style="width: 100%; border: 1px solid var(--surface-border); border-radius: 8px; padding: 10px; font-size: 0.9rem; font-weight: 600;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px;">Extension</label>
                <input type="text" id="sip_extension" value="101" style="width: 100%; border: 1px solid var(--surface-border); border-radius: 8px; padding: 10px; font-size: 0.9rem; font-weight: 600;">
            </div>
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px;">Password</label>
                <input type="password" id="sip_password" value="Rahasia101" style="width: 100%; border: 1px solid var(--surface-border); border-radius: 8px; padding: 10px; font-size: 0.9rem; font-weight: 600;">
            </div>

            <button id="btn_register" style="width: 100%; padding: 12px; background: #0066FF; color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s;">
                <i data-lucide="log-in" style="width: 18px; height: 18px;"></i> Connect & Register
            </button>
            <div id="reg_status" style="margin-top: 16px; text-align: center; font-size: 0.85rem; font-weight: 700; color: var(--text-secondary);">Offline</div>
        </div>

        {{-- Dialpad Panel --}}
        <div class="glass-panel" style="width: 350px; padding: 32px 24px; background: #111827; color: white; border-radius: 32px; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
            
            <div style="text-align: center; margin-bottom: 24px;">
                <input type="text" id="target_ext" placeholder="102" style="width: 100%; background: transparent; border: none; color: white; font-size: 3rem; font-weight: 300; text-align: center; outline: none; letter-spacing: 2px;">
                <div id="call_status" style="font-size: 0.85rem; color: #9CA3AF; margin-top: 8px; font-weight: 500; min-height: 20px;">Ready to call</div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px; padding: 0 16px;">
                @foreach(['1','2','3','4','5','6','7','8','9','*','0','#'] as $key)
                <button class="dial-btn" onclick="document.getElementById('target_ext').value += '{{ $key }}'" style="background: rgba(255,255,255,0.1); border: none; border-radius: 50%; aspect-ratio: 1; color: white; font-size: 1.5rem; font-weight: 400; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                    {{ $key }}
                </button>
                @endforeach
            </div>

            <div style="display: flex; justify-content: center; gap: 24px;">
                <button id="btn_call" style="width: 72px; height: 72px; border-radius: 50%; background: #10b981; border: none; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <i data-lucide="phone" style="width: 28px; height: 28px; fill: white;"></i>
                </button>
                <button id="btn_hangup" style="width: 72px; height: 72px; border-radius: 50%; background: #ef4444; border: none; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3); opacity: 0.5; pointer-events: none; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <i data-lucide="phone-off" style="width: 28px; height: 28px; fill: white;"></i>
                </button>
            </div>
            
            <audio id="remoteAudio" autoplay></audio>
        </div>
    </div>

    {{-- TTS Call Panel --}}
    <div class="glass-panel" style="margin-top: 28px; padding: 28px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border: 1px solid #bae6fd;">
        <h3 style="font-size: 1.1rem; font-weight: 800; color: #0c4a6e; margin-bottom: 6px; display: flex; align-items: center; gap: 10px;">
            <span style="background: #0284c7; color: white; border-radius: 8px; padding: 6px 10px; font-size: 1.2rem;">TTS</span>
            Text-to-Speech Auto Call
        </h3>
        <p style="color: #0369a1; font-size: 0.85rem; margin-bottom: 20px;">Ketik pesan → sistem otomatis menelepon ekstensi tujuan dan memperdengarkan suara TTS.</p>

        <div style="display: grid; grid-template-columns: 1fr 180px; gap: 16px; align-items: start;">
            {{-- Text area --}}
            <div>
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #0369a1; margin-bottom: 6px;">Pesan yang akan diucapkan</label>
                <textarea id="tts_text" rows="3" placeholder="Contoh: Halo, ini adalah pesan otomatis dari sistem VetenCall. Mohon segera menghubungi admin." style="width: 100%; border: 1.5px solid #7dd3fc; border-radius: 10px; padding: 12px; font-size: 0.9rem; resize: vertical; background: white; color: #0c4a6e; font-family: inherit; line-height: 1.5; box-sizing: border-box;"></textarea>
            </div>
            {{-- Right controls --}}
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #0369a1; margin-bottom: 6px;">Ekstensi Tujuan</label>
                    <input type="text" id="tts_target" value="102" style="width: 100%; border: 1.5px solid #7dd3fc; border-radius: 10px; padding: 10px 12px; font-size: 1.1rem; font-weight: 700; text-align: center; background: white; color: #0c4a6e; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #0369a1; margin-bottom: 6px;">Bahasa</label>
                    <select id="tts_lang" style="width: 100%; border: 1.5px solid #7dd3fc; border-radius: 10px; padding: 10px 12px; font-size: 0.85rem; font-weight: 600; background: white; color: #0c4a6e; box-sizing: border-box;">
                        <option value="id">Indonesia</option>
                        <option value="en">English</option>
                        <option value="jv">Jawa</option>
                        <option value="su">Sunda</option>
                    </select>
                </div>
                <button id="btn_tts_call" onclick="startTTSCall()" style="width: 100%; padding: 12px; background: linear-gradient(135deg, #0284c7, #0ea5e9); color: white; border: none; border-radius: 10px; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(2,132,199,0.4); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <span>Call</span> TTS Call
                </button>
            </div>
        </div>

        <div id="tts_status" style="margin-top: 14px; padding: 10px 14px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; display: none;"></div>
    </div>


    {{-- Debug Log Panel --}}
    <div style="margin-top: 24px; background: #111827; border-radius: 12px; padding: 16px; font-family: monospace;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span style="color: #9ca3af; font-size: 0.8rem; font-weight: 700;">SIP Debug Log</span>
            <button onclick="document.getElementById('sip_log').innerHTML=''" style="background: #374151; border: none; color: #9ca3af; padding: 4px 10px; border-radius: 6px; cursor: pointer; font-size: 0.75rem;">Clear</button>
        </div>
        <div id="sip_log" style="height: 160px; overflow-y: auto; font-size: 0.72rem; color: #86efac; line-height: 1.5;"></div>
    </div>
</div>

<script src="{{ asset('js/jssip.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- Check library loaded ---
    if (typeof JsSIP === 'undefined') {
        document.getElementById('reg_status').innerHTML = '<span style="color:#ef4444">ERROR: Library JsSIP gagal dimuat. Periksa koneksi internet.</span>';
        return;
    }

    // --- Cek & minta izin mikrofon saat halaman dibuka ---
    async function requestMicPermission() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true, video: false });
            stream.getTracks().forEach(t => t.stop()); // langsung stop, cukup minta izin
            document.getElementById('mic_banner').style.display = 'none';
            console.log('[MIC] Izin mikrofon diberikan');
        } catch (err) {
            document.getElementById('mic_banner').style.display = 'flex';
            console.warn('[MIC] Izin mikrofon ditolak:', err.message);
        }
    }
    // Expose ke global agar bisa dipanggil dari onclick HTML
    window.requestMicPermission = requestMicPermission;
    // Auto-request saat halaman load
    requestMicPermission();

    let ua = null;
    let activeSession = null;
    let registered = false;

    // STUN servers + pre-gather ICE candidates untuk kurangi delay
    // Kosongkan iceServers agar browser tidak freeze cari IP publik (sesuai permintaan TKJ)
    const pcConfig = {
        iceServers: [],
        bundlePolicy: 'max-bundle',
        rtcpMuxPolicy: 'require'
    };

    const btnReg     = document.getElementById('btn_register');
    const statusText = document.getElementById('reg_status');
    const callStatus = document.getElementById('call_status');
    const btnCall    = document.getElementById('btn_call');
    const btnHangup  = document.getElementById('btn_hangup');
    const remoteAudio = document.getElementById('remoteAudio');

    // Gunakan Web Audio API untuk ringtone agar tidak ada delay loading
    let audioCtx = null;
    let ringtoneInterval = null;

    function playRingtone() {
        if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        ringtoneInterval = setInterval(() => {
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.type = 'sine';
            osc.frequency.setValueAtTime(440, audioCtx.currentTime);
            osc.frequency.setValueAtTime(480, audioCtx.currentTime + 0.5);
            gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 1.0);
            osc.start(audioCtx.currentTime);
            osc.stop(audioCtx.currentTime + 1.0);
        }, 1500);
    }

    function stopRingtone() {
        if (ringtoneInterval) { clearInterval(ringtoneInterval); ringtoneInterval = null; }
    }

    // Enable JsSIP verbose logs for debugging
    JsSIP.debug.enable('JsSIP:*');
    // Override console.log to show on page
    const logArea = document.getElementById('sip_log');
    const origLog = console.log.bind(console);
    const origError = console.error.bind(console);
    function appendLog(type, args) {
        const msg = Array.from(args).map(a => (typeof a === 'object' ? JSON.stringify(a) : String(a))).join(' ');
        if (msg.includes('JsSIP') || msg.includes('SIP') || msg.includes('DEBUG')) {
            const line = document.createElement('div');
            line.style.borderBottom = '1px solid #374151';
            line.style.padding = '2px 0';
            line.style.color = type === 'error' ? '#f87171' : '#86efac';
            line.textContent = '[' + type + '] ' + msg.substring(0, 300);
            logArea.appendChild(line);
            logArea.scrollTop = logArea.scrollHeight;
        }
    }
    console.log  = (...args) => { origLog(...args);   appendLog('log', args); };
    console.error = (...args) => { origError(...args); appendLog('ERR', args); };

    function setStatus(msg, color) {
        statusText.innerHTML = '<span style="color:' + color + '">' + msg + '</span>';
    }

    btnReg.addEventListener('click', () => {
        if (registered) {
            ua.stop();
            registered = false;
            setStatus('Offline', '#64748b');
            btnReg.textContent = 'Connect & Register';
            btnReg.style.background = '#0066FF';
            return;
        }

        const ws     = document.getElementById('sip_ws').value.trim();
        const domain = document.getElementById('sip_domain').value.trim();
        const ext    = document.getElementById('sip_extension').value.trim();
        const pass   = document.getElementById('sip_password').value.trim();

        if (!ws || !domain || !ext || !pass) {
            setStatus('Isi semua kolom terlebih dahulu!', '#ef4444');
            return;
        }

        setStatus('Mencoba koneksi ke WebSocket...', '#eab308');
        btnReg.disabled = true;
        btnReg.textContent = 'Connecting...';

        try {
            const socket = new JsSIP.WebSocketInterface(ws);

            const configuration = {
                sockets      : [socket],
                uri          : 'sip:' + ext + '@' + domain,
                authorization_user: ext,
                display_name : ext,
                password     : pass,
                realm        : domain,   // ← eksplisit realm sesuai permintaan TKJ
                register     : true,
                register_expires : 300,
                connection_recovery_min_interval: 2,
                connection_recovery_max_interval: 30,
                pcConfig     : pcConfig,
            };

            ua = new JsSIP.UA(configuration);

            ua.on('connecting', () => {
                setStatus('Menghubungkan ke WebSocket...', '#eab308');
            });

            ua.on('connected', () => {
                setStatus('WebSocket terhubung! Mendaftarkan ekstensi...', '#eab308');
            });

            ua.on('disconnected', (e) => {
                registered = false;
                const reason = e.error ? ('Error: ' + e.error) : 'WebSocket terputus.';
                const detail = e.code ? ' (Code ' + e.code + ')' : '';
                setStatus(reason + detail + ' Pastikan port 8088 terbuka di firewall AWS.', '#ef4444');
                btnReg.disabled = false;
                btnReg.textContent = 'Connect & Register';
                btnReg.style.background = '#0066FF';
            });

            ua.on('registered', () => {
                registered = true;
                btnReg.disabled = false;
                setStatus('Terhubung sebagai ekstensi ' + ext, '#10b981');
                btnReg.textContent = 'Disconnect';
                btnReg.style.background = '#ef4444';
            });

            ua.on('unregistered', () => {
                registered = false;
                setStatus('Registrasi dibatalkan.', '#64748b');
                btnReg.disabled = false;
                btnReg.textContent = 'Connect & Register';
                btnReg.style.background = '#0066FF';
            });

            ua.on('registrationFailed', (e) => {
                registered = false;
                const cause = e.cause || 'Unknown';
                const status = e.response ? e.response.status_code : '';

                // --- DEBUG: Expose realm dari WWW-Authenticate header ---
                let debugInfo = '';
                if (e.response) {
                    const wwwAuth = e.response.getHeader('www-authenticate') || e.response.getHeader('WWW-Authenticate') || '';
                    const proxyAuth = e.response.getHeader('proxy-authenticate') || '';
                    const realmMatch = (wwwAuth + proxyAuth).match(/realm="([^"]+)"/i);
                    const realm = realmMatch ? realmMatch[1] : '(tidak terdeteksi)';
                    debugInfo = '<br><small style="font-size:0.75rem; color:#f59e0b;">DEBUG → Realm server: <b>' + realm + '</b> | Auth user dikirim: <b>' + ext + '</b></small>';
                    console.error('[SIP DEBUG] WWW-Authenticate:', wwwAuth);
                    console.error('[SIP DEBUG] Cause:', cause, '| Status:', status);
                    console.error('[SIP DEBUG] Realm terdeteksi:', realm);
                    console.error('[SIP DEBUG] Auth user yg dikirim:', ext, '| Domain:', domain);
                }

                setStatus('Registrasi GAGAL: ' + cause + (status ? ' (HTTP ' + status + ')' : '') + '. Periksa Extension & Password.' + debugInfo, '#ef4444');
                btnReg.disabled = false;
                btnReg.textContent = 'Connect & Register';
                btnReg.style.background = '#0066FF';
            });

            ua.on('newRTCSession', (data) => {
                const session = data.session;

                // --- FIX: Filter mDNS (.local/.invalid) ICE candidates ---
                // Chrome menyembunyikan IP lokal dengan mDNS, Asterisk tidak bisa resolve
                // sehingga terjadi delay 60 detik. Filter kandidat ini agar tidak dikirim.
                session.on('peerconnection', (pcData) => {
                    const pc = pcData.peerconnection;
                    pc.addEventListener('icecandidate', (event) => {
                        if (event.candidate && (
                            event.candidate.candidate.indexOf('.local') !== -1 ||
                            event.candidate.candidate.indexOf('.invalid') !== -1
                        )) {
                            event.stopImmediatePropagation();
                        }
                    }, true); // capture phase untuk intercept sebelum JsSIP
                });

                if (session.direction === 'incoming') {
                    callStatus.textContent = 'Panggilan masuk dari ' + session.remote_identity.uri.user;
                    playRingtone();

                    btnCall.onclick = () => {
                        session.answer({
                            mediaConstraints: { audio: true, video: false },
                            pcConfig: pcConfig
                        });
                        stopRingtone();
                    };
                    btnHangup.onclick = () => {
                        session.terminate();
                        stopRingtone();
                    };
                    btnCall.style.opacity = '1';
                    btnCall.style.pointerEvents = 'auto';
                    btnHangup.style.opacity = '1';
                    btnHangup.style.pointerEvents = 'auto';
                }

                session.on('accepted',  () => { callStatus.textContent = 'Panggilan berlangsung...'; stopRingtone(); });
                session.on('confirmed', () => { callStatus.textContent = 'Panggilan berlangsung...'; stopRingtone(); });
                session.on('ended',     () => { callStatus.textContent = 'Panggilan berakhir.'; stopRingtone(); resetButtons(); activeSession = null; });
                session.on('failed',    (e) => {
                    const code   = (e.message && e.message.status_code) ? e.message.status_code : '';
                    const reason = (e.message && e.message.reason_phrase) ? e.message.reason_phrase : (e.cause || 'Unknown');
                    callStatus.textContent = 'Panggilan gagal: ' + (code ? '[' + code + '] ' : '') + reason;
                    stopRingtone(); resetButtons(); activeSession = null;
                });

                if (session.connection) {
                    session.connection.addEventListener('track', (e) => {
                        remoteAudio.srcObject = e.streams[0];
                        remoteAudio.play().catch(() => {});
                    });
                }

                activeSession = session;
            });

            ua.start();

        } catch (err) {
            setStatus('ERROR: ' + err.message, '#ef4444');
            btnReg.disabled = false;
            btnReg.textContent = 'Connect & Register';
        }
    });

    btnCall.addEventListener('click', () => {
        if (!registered) { alert('Daftarkan ekstensi terlebih dahulu!'); return; }

        // Bersihkan sesi lama yang mungkin masih stuck
        if (activeSession) {
            try { activeSession.terminate(); } catch(e) {}
            activeSession = null;
            resetButtons();
            callStatus.textContent = 'Sesi lama dibersihkan. Tekan Call lagi.';
            return;
        }

        const target = document.getElementById('target_ext').value.trim();
        // Strip port jika ada (misal: 52.2.21.5:5070 -> 52.2.21.5)
        const domain = document.getElementById('sip_domain').value.trim().split(':')[0];
        if (!target) { alert('Masukkan nomor ekstensi tujuan!'); return; }

        callStatus.textContent = 'Mengirim INVITE ke ' + target + '...';
        try {
            activeSession = ua.call('sip:' + target + '@' + domain, {
                mediaConstraints: { audio: true, video: false },
                pcConfig: pcConfig
            });
            btnCall.style.opacity = '0.5';
            btnCall.style.pointerEvents = 'none';
            btnHangup.style.opacity = '1';
            btnHangup.style.pointerEvents = 'auto';
            btnHangup.onclick = () => { if (activeSession) activeSession.terminate(); };
        } catch (err) {
            callStatus.textContent = 'Gagal memanggil: ' + err.message;
            activeSession = null;
        }
    });

    function resetButtons() {
        btnCall.style.opacity = '1';
        btnCall.style.pointerEvents = 'auto';
        btnCall.onclick = null;
        btnHangup.style.opacity = '0.5';
        btnHangup.style.pointerEvents = 'none';
    }

    // =============================================
    // TTS AUTO CALL — Server-side AMI Originate
    // =============================================
    window.startTTSCall = async function () {
        const text   = document.getElementById('tts_text').value.trim();
        const target = document.getElementById('tts_target').value.trim();
        const lang   = document.getElementById('tts_lang').value;
        const btn    = document.getElementById('btn_tts_call');
        const status = document.getElementById('tts_status');

        function setTTSStatus(msg, color, bg) {
            status.style.display  = 'block';
            status.style.color    = color;
            status.style.background = bg;
            status.innerHTML = msg;
        }

        if (!text)   return setTTSStatus('Isi pesan terlebih dahulu!', '#92400e', '#fef3c7');
        if (!target) return setTTSStatus('Isi ekstensi tujuan!', '#92400e', '#fef3c7');

        btn.disabled = true;
        btn.innerHTML = '<span>Wait</span> Memproses TTS Call...';
        setTTSStatus('Menghubungi server untuk originate call...', '#1e40af', '#dbeafe');

        try {
            // Panggil API Laravel yang akan handle komunikasi AMI ke Asterisk
            const response = await fetch('/tts-call', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ text, target, lang })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                setTTSStatus('OK: ' + data.message, '#065f46', '#d1fae5');
                console.log('[TTS-AMI]', data);
            } else {
                throw new Error(data.error || 'Server error saat mengirim TTS Call');
            }
        } catch (err) {
            setTTSStatus('Error: ' + err.message, '#991b1b', '#fee2e2');
            console.error('[TTS-AMI Error]', err);
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span>Call</span> TTS Call';
        }
    };

});
</script>
@endsection

