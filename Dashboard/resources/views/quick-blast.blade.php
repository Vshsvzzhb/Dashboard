@extends('layouts.app')

@section('content')
<div class="page-container">

    @if(session('success'))
    <div style="background: #E6FBF5; border: 1px solid #A7F3D0; color: var(--accent-green); padding: 16px 24px; border-radius: 16px; margin-bottom: 28px; display: flex; align-items: center; gap: 12px;">
        <i data-lucide="zap" style="color: var(--accent-green); flex-shrink: 0;"></i>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif
    @if($errors->any())
    <div style="background: #FEECEB; border: 1px solid #FECACA; color: var(--accent-pink); padding: 16px 24px; border-radius: 16px; margin-bottom: 28px;">
        @foreach($errors->all() as $e) <p style="margin: 0; font-weight: 600;">⚠️ {{ $e }}</p> @endforeach
    </div>
    @endif

    <div class="page-header">
        <div>
            <h1 class="page-title">Quick Blast</h1>
            <p style="color: var(--text-secondary); margin-top: 8px; font-size: 1.05rem;">Send a WhatsApp message instantly — no scheduling needed.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 28px; align-items: start;">

        {{-- LEFT: Compose Panel --}}
        <form action="/quick-blast" method="POST" id="blastForm">
            @csrf
            <div class="glass-panel" style="padding: 32px; display: flex; flex-direction: column; gap: 24px;">
                
                {{-- Message Box --}}
                <div>
                    <label style="display: block; margin-bottom: 10px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                        <i data-lucide="message-square" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"></i>
                        Message
                    </label>
                    <div style="position: relative;">
                        <textarea name="message" id="msgInput" required rows="6" placeholder="Type your broadcast message here...&#10;&#10;Use {name} to personalize with contact name."
                            style="width: 100%; background: #ffffff; border: 2px solid var(--surface-border); border-radius: 16px; padding: 18px; color: var(--text-primary); outline: none; font-family: inherit; font-size: 1rem; resize: vertical; transition: all 0.3s; line-height: 1.6; font-weight: 500;"
                            onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(67, 24, 255, 0.1)';" onblur="this.style.borderColor='var(--surface-border)'; this.style.boxShadow='none';" oninput="updateCharCount(this)"></textarea>
                        <div id="charCount" style="position: absolute; bottom: 12px; right: 16px; font-size: 0.75rem; color: var(--text-secondary); font-weight: 700;">0 chars</div>
                    </div>
                    {{-- Quick text + variable buttons --}}
                    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 12px;">
                        @foreach(['Halo!', 'Info:', 'Penting:', 'Promo:', 'Terima Kasih'] as $textSnippet)
                        <button type="button" onclick="insertText('{{ $textSnippet }} ')" style="background: #F4F7FE; border: none; color: var(--text-primary); padding: 8px 14px; border-radius: 8px; cursor: pointer; font-size: 0.9rem; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F4F7FE'">{{ $textSnippet }}</button>
                        @endforeach
                        <button type="button" onclick="insertText('{name}')" style="background: #E0F2FE; border: none; color: #0284C7; padding: 8px 14px; border-radius: 8px; cursor: pointer; font-size: 0.85rem; font-weight: 700; transition: all 0.2s;" onmouseover="this.style.background='#BAE6FD'" onmouseout="this.style.background='#E0F2FE'">{name}</button>
                    </div>
                </div>

                {{-- Recipient Selector --}}
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <label style="color: var(--text-secondary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                            <i data-lucide="users" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"></i>
                            Recipients
                        </label>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" onclick="selectAll()" style="background: #E0F2FE; border: none; color: #0284C7; padding: 6px 14px; border-radius: 8px; cursor: pointer; font-size: 0.8rem; font-weight: 700; transition: all 0.2s;">Select All</button>
                            <button type="button" onclick="clearAll()" style="background: #F4F7FE; border: none; color: var(--text-secondary); padding: 6px 14px; border-radius: 8px; cursor: pointer; font-size: 0.8rem; font-weight: 700; transition: all 0.2s;">Clear</button>
                        </div>
                    </div>

                    {{-- Search contacts --}}
                    <div style="background: #ffffff; border: 2px solid var(--surface-border); border-radius: 12px; padding: 12px 16px; display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <i data-lucide="search" style="width: 18px; height: 18px; color: var(--text-secondary); flex-shrink: 0;"></i>
                        <input type="text" id="contactSearch" placeholder="Search contacts or groups..." oninput="filterContacts(this.value)"
                            style="background: transparent; border: none; color: var(--text-primary); outline: none; font-family: inherit; font-size: 0.95rem; font-weight: 600; width: 100%;">
                    </div>

                    {{-- Contact list --}}
                    <div id="contactList" style="max-height: 280px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px; padding-right: 6px;">
                        @forelse($contacts as $contact)
                        <label id="contact-{{ $contact->id }}" class="contact-item" style="display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: #F4F7FE; border: 1px solid transparent; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                            <input type="checkbox" name="recipients[]" value="{{ $contact->phone }}" style="width: 18px; height: 18px; accent-color: var(--primary); cursor: pointer;" onchange="updateSelectedCount()">
                            <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; color: white; flex-shrink: 0;">
                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 700; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $contact->name }}</div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary); font-family: monospace; font-weight: 600;">{{ $contact->phone }}</div>
                            </div>
                            @php $labels = json_decode($contact->labels, true) ?? []; @endphp
                            @if($labels)
                            <span style="background: #E0F2FE; color: #0284C7; padding: 4px 12px; border-radius: 100px; font-size: 0.75rem; font-weight: 800; white-space: nowrap;">{{ $labels[0] }}</span>
                            @endif
                        </label>
                        @empty
                        <div id="noContactsMsg" style="text-align: center; padding: 32px; color: var(--text-secondary); font-weight: 500;">
                            <p>No contacts yet. <a href="/phonebook" style="color: var(--primary); font-weight: 700;">Add contacts →</a></p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Send Button --}}
                <div style="padding-top: 16px; border-top: 1px solid var(--surface-border); display: flex; align-items: center; justify-content: space-between;">
                    <div id="selectedCount" style="color: var(--text-primary); font-size: 0.95rem; font-weight: 700;">0 recipients selected</div>
                    <button type="submit" class="btn btn-primary" style="padding: 16px 40px; font-size: 1.05rem;" id="sendBtn">
                        <i data-lucide="zap" style="width: 20px; height: 20px;"></i>
                        Send Now
                    </button>
                </div>
            </div>
        </form>

        {{-- RIGHT: Preview + History --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">

            {{-- WA Preview --}}
            <div class="glass-panel" style="padding: 28px;">
                <h3 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 20px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    <i data-lucide="eye" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"></i>
                    WA Preview
                </h3>
                {{-- Phone mockup --}}
                <div style="background: #F4F7FE; border-radius: 20px; padding: 20px; min-height: 200px; position: relative;">
                    <div style="background: #E6FBF5; border-radius: 16px 16px 4px 16px; padding: 14px 18px; max-width: 85%; margin-left: auto; position: relative; box-shadow: 0 4px 12px rgba(5,205,153,0.1);">
                        <p id="previewText" style="margin: 0; color: var(--text-primary); font-size: 0.95rem; line-height: 1.6; word-break: break-word; white-space: pre-wrap; font-family: inherit; min-height: 20px; font-weight: 500;">Your message will appear here...</p>
                        <div style="font-size: 0.75rem; color: var(--accent-green); text-align: right; margin-top: 8px; font-weight: 700;">{{ now()->format('H:i') }} ✓✓</div>
                    </div>
                </div>
            </div>

            {{-- Blast History --}}
            <div class="glass-panel" style="padding: 28px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.9rem; font-weight: 800; margin: 0; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                        <i data-lucide="clock" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"></i>
                        Blast History
                    </h3>
                    <a href="/blast-history" style="color: var(--primary); font-size: 0.8rem; font-weight: 700; text-decoration: none;">Lihat Semua →</a>
                </div>
                @forelse($history as $blast)
                @php
                    $statusClass = ['queued'=>'badge warning','sending'=>'badge primary','done'=>'badge success','failed'=>'badge danger'];
                    $sc = $statusClass[$blast->status] ?? 'badge warning';
                @endphp
                <div style="padding: 16px; background: #F4F7FE; border-radius: 12px; margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                        <p style="margin: 0; color: var(--text-primary); font-size: 0.9rem; font-weight: 700; flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit($blast->message, 60) }}</p>
                        <span class="{{ $sc }}">{{ ucfirst($blast->status) }}</span>
                    </div>
                    <div style="display: flex; gap: 16px; margin-top: 10px;">
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-secondary);">{{ $blast->total }} recipients</span>
                        <span style="font-size: 0.8rem; font-weight: 700; color: var(--accent-green);">✓ {{ $blast->sent }} sent</span>
                        @if($blast->failed > 0)
                        <span style="font-size: 0.8rem; font-weight: 700; color: var(--accent-pink);">✗ {{ $blast->failed }} failed</span>
                        @endif
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-left: auto;">{{ $blast->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 28px; color: var(--text-secondary); font-size: 0.95rem; font-weight: 500;">
                    No blast history yet.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.contact-item:hover { background: #E2E8F0 !important; }
</style>

<script>
function updateCharCount(el) {
    document.getElementById('charCount').textContent = el.value.length + ' chars';
    document.getElementById('previewText').textContent = el.value || 'Your message will appear here...';
}

function insertText(text) {
    const ta = document.getElementById('msgInput');
    const start = ta.selectionStart;
    const end = ta.selectionEnd;
    ta.value = ta.value.slice(0, start) + text + ta.value.slice(end);
    ta.selectionStart = ta.selectionEnd = start + text.length;
    ta.focus();
    updateCharCount(ta);
}

function updateSelectedCount() {
    const checked = document.querySelectorAll('input[name="recipients[]"]:checked').length;
    document.getElementById('selectedCount').textContent = checked + ' recipient' + (checked !== 1 ? 's' : '') + ' selected';
}

function selectAll() {
    document.querySelectorAll('input[name="recipients[]"]').forEach(cb => cb.checked = true);
    updateSelectedCount();
}

function clearAll() {
    document.querySelectorAll('input[name="recipients[]"]').forEach(cb => cb.checked = false);
    updateSelectedCount();
}

function filterContacts(query) {
    const q = query.toLowerCase();
    document.querySelectorAll('.contact-item').forEach(label => {
        const text = label.textContent.toLowerCase();
        label.style.display = text.includes(q) ? 'flex' : 'none';
    });
}

// Fetch WhatsApp Groups from Engine API
async function fetchGroups() {
    const btn = event.currentTarget;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i data-lucide="loader" class="spin" style="width:12px;height:12px;vertical-align:middle;margin-right:4px;"></i> Fetching...';
    lucide.createIcons();
    
    try {
        const waEngineUrl = '{{ rtrim($apiUrl, "/") }}';
        // Make sure to remove /api if it exists to get the root wa-engine url
        const engineRoot = waEngineUrl.endsWith('/api') ? waEngineUrl.slice(0, -4) : waEngineUrl;
        
        const res = await fetch(engineRoot + '/groups');
        const data = await res.json();
        
        if (data.success && data.data) {
            const list = document.getElementById('contactList');
            const noMsg = document.getElementById('noContactsMsg');
            if(noMsg) noMsg.style.display = 'none';

            data.data.forEach(group => {
                // Prevent duplicate groups
                if(document.getElementById('group-' + group.id)) return;
                
                const label = document.createElement('label');
                label.id = 'group-' + group.id;
                label.className = 'contact-item';
                label.style.cssText = 'display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: #FFF7D8; border: 1px solid transparent; border-radius: 12px; cursor: pointer; transition: all 0.2s; margin-top: 8px;';
                
                const initial = group.name ? group.name.substring(0, 1).toUpperCase() : 'G';
                
                label.innerHTML = \`
                    <input type="checkbox" name="recipients[]" value="\${group.id}" style="width: 18px; height: 18px; accent-color: var(--accent-orange); cursor: pointer;" onchange="updateSelectedCount()">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--accent-orange); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; color: white; flex-shrink: 0;">
                        \${initial}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-weight: 700; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">\${group.name}</div>
                        <div style="font-size: 0.85rem; color: var(--text-secondary); font-family: monospace; font-weight: 600;">\${group.id}</div>
                    </div>
                    <span style="background: rgba(255,255,255,0.6); color: var(--accent-orange); padding: 4px 12px; border-radius: 100px; font-size: 0.75rem; font-weight: 800; white-space: nowrap;">
                        <i data-lucide="users" style="width:10px;height:10px;"></i> \${group.participants_count} Members
                    </span>
                \`;
                // Insert at top
                list.insertBefore(label, list.firstChild);
            });
            lucide.createIcons();
            alert(\`Successfully fetched \${data.count} groups!\`);
        } else {
            alert('Error fetching groups: ' + (data.error || 'Unknown error'));
        }
    } catch (e) {
        alert('Failed to connect to WA Engine at {{ $apiUrl }}. Make sure the Node server is running.');
    } finally {
        btn.innerHTML = originalText;
    }
}

// Confirm before sending
document.getElementById('blastForm').addEventListener('submit', function(e) {
    const count = document.querySelectorAll('input[name="recipients[]"]:checked').length;
    if (count === 0) {
        e.preventDefault();
        alert('Please select at least one recipient!');
        return;
    }
    const msg = document.getElementById('msgInput').value;
    if (!confirm(\`Send message to \${count} target(s)?\\n\\nMessage: "\${msg.slice(0,80)}..."\`)) {
        e.preventDefault();
    }
});
</script>
<style>
@keyframes spin { 100% { transform: rotate(360deg); } }
.spin { animation: spin 2s linear infinite; }
</style>
@endsection
