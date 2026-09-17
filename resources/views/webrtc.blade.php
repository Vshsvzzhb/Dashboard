@extends('layouts.app')

@section('title', 'WebRTC Softphone — VetenCall')
@section('page-title', 'WebRTC Softphone')

@push('scripts')
<script src="{{ asset('js/jssip.min.js') }}"></script>
@endpush

@section('content')
<style>
    /* Dedicated Softphone Tactile Dialpad Styling */
    .nm-dial-key {
        width: 68px !important;
        height: 68px !important;
        border-radius: 9999px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        user-select: none !important;
        transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1) !important;
        margin: 0 auto !important;
    }
    @media (min-width: 640px) {
        .nm-dial-key {
            width: 74px !important;
            height: 74px !important;
        }
    }
    .nm-dial-key:hover {
        transform: translateY(-2px);
    }
    .nm-dial-key:active {
        transform: scale(0.92) !important;
    }
    .nm-call-action-btn {
        width: 68px !important;
        height: 68px !important;
        border-radius: 9999px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
    }
    @media (min-width: 640px) {
        .nm-call-action-btn {
            width: 74px !important;
            height: 74px !important;
        }
    }
    .nm-call-action-btn:hover {
        transform: translateY(-2px);
    }
    .nm-call-action-btn:active {
        transform: scale(0.92) !important;
    }
</style>

    {{-- Audio Element for WebRTC Stream --}}
    <audio id="remoteAudio" autoplay playsinline></audio>

    {{-- Title & Header Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight" style="letter-spacing:-0.02em;">WebRTC Softphone</h1>
            <p class="text-xs mt-1 opacity-50">Browser VoIP Softphone & In-Call Voice Workspace</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" onclick="quickDial('*43')" class="nm-btn px-4 py-2.5 rounded-2xl font-bold text-xs flex items-center gap-2 transition hover:text-[#2f6bfd]">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 003-3V5a3 3 0 10-6 0v6a3 3 0 003 3z"/></svg>
                <span>Echo Test (*43)</span>
            </button>
        </div>
    </div>

    {{-- Microphone Permission Banner --}}
    <div id="mic_banner" class="nm-inset border border-amber-500/30 rounded-2xl p-4 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 transition-all">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
            </div>
            <div>
                <h4 id="mic_title" class="text-amber-600 dark:text-amber-400 font-bold text-xs sm:text-sm">Izin Mikrofon Diperlukan</h4>
                <p id="mic_desc" class="text-amber-700/70 dark:text-amber-200/70 text-[11px] mt-0.5">Izinkan akses mikrofon browser agar panggilan suara dua arah dapat berjalan jernih.</p>
            </div>
        </div>
        <button type="button" id="btn_request_mic" class="shrink-0 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-black font-bold text-xs rounded-xl shadow-md transition cursor-pointer">
            Izinkan Mikrofon
        </button>
    </div>

    {{-- Perfectly Balanced 2-Column Responsive Grid (6 cols left / 6 cols right or 7/5) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- LEFT COLUMN: SIP Config & Speed Dial Directory (lg:col-span-7) --}}
        <div class="lg:col-span-7 space-y-6">

            {{-- Card 1: SIP Account Configuration --}}
            <div class="nm-card p-6 sm:p-7 space-y-4">
                <div class="flex items-center justify-between border-b border-black/5 dark:border-white/5 pb-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold">SIP Account Configuration</h3>
                            <p class="text-[11px] opacity-50">Koneksi WebSocket Asterisk WebRTC</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span id="reg_dot" class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                        <span id="reg_status" class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Offline</span>
                    </div>
                </div>

                <form class="space-y-3.5" onsubmit="return false;">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-[11px] font-semibold opacity-60 mb-1">WebSocket URI</label>
                            <input type="text" id="sip_ws" value="{{ auth()->user()->asterisk_ws_url ?? (request()->isSecure() ? 'wss://' . request()->getHost() . '/ws' : 'ws://' . request()->getHost() . ':8089/ws') }}" class="w-full bg-transparent border border-black/10 dark:border-white/10 rounded-xl px-3.5 py-2 text-xs focus:outline-none focus:border-[#2f6bfd] transition font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold opacity-60 mb-1">SIP Domain / Host</label>
                            <input type="text" id="sip_domain" value="{{ auth()->user()->asterisk_domain ?? request()->getHost() }}" class="w-full bg-transparent border border-black/10 dark:border-white/10 rounded-xl px-3.5 py-2 text-xs focus:outline-none focus:border-[#2f6bfd] transition font-mono">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-[11px] font-semibold opacity-60 mb-1">Extension / Username</label>
                            <input type="text" id="sip_extension" value="{{ auth()->user()->asterisk_exten ?? '9999' }}" class="w-full bg-transparent border border-black/10 dark:border-white/10 rounded-xl px-3.5 py-2 text-xs font-mono font-bold focus:outline-none focus:border-[#2f6bfd] transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold opacity-60 mb-1">SIP Secret / Password</label>
                            <div class="relative">
                                <input type="password" id="sip_password" value="{{ auth()->user()->asterisk_password ?? 'Dashboard9999' }}" class="w-full bg-transparent border border-black/10 dark:border-white/10 rounded-xl px-3.5 py-2 pr-10 text-xs focus:outline-none focus:border-[#2f6bfd] transition">
                                <button type="button" id="toggle_password" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white transition cursor-pointer">
                                    <svg id="eye_icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-1">
                        <button type="button" id="btn_register" class="nm-btn-brand w-full py-2.5 text-xs font-bold transition flex items-center justify-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                            <span>Connect & Register</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Card 2: Speed Dial & Extension Directory --}}
            <div class="nm-card p-6 sm:p-7 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-black/5 dark:border-white/5 pb-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold">Speed Dial Ekstensi</h3>
                            <p class="text-[11px] opacity-50">Klik tombol Call untuk langsung memanggil</p>
                        </div>
                    </div>
                    
                    {{-- Search Filter --}}
                    <div class="w-full sm:w-48">
                        <input type="text" id="search_ext_input" oninput="filterSpeedDial(this.value)" placeholder="Cari nama / nomor..." class="w-full bg-transparent border border-black/10 dark:border-white/10 rounded-xl px-3 py-1.5 text-xs focus:outline-none focus:border-[#2f6bfd] transition">
                    </div>
                </div>

                @php
                    $defaultList = [
                        ['ext' => '3030', 'name' => 'Linphone Android (3030)', 'type' => 'SIP UDP'],
                        ['ext' => '4040', 'name' => 'Linphone Mobile (4040)', 'type' => 'SIP UDP'],
                        ['ext' => '102',  'name' => 'VoIP Client (102)', 'type' => 'SIP UDP'],
                        ['ext' => '1010', 'name' => 'Agent Support (1010)', 'type' => 'WebRTC'],
                        ['ext' => '2020', 'name' => 'Office Line (2020)', 'type' => 'WebRTC'],
                        ['ext' => '9999', 'name' => 'Supervisor (9999)', 'type' => 'WebRTC'],
                    ];
                    $mergedUsers = collect($defaultList);
                    if (isset($voipUsers) && $voipUsers->count() > 0) {
                        foreach ($voipUsers as $vu) {
                            if (!$mergedUsers->contains('ext', $vu->phone_number)) {
                                $mergedUsers->push([
                                    'ext' => $vu->phone_number,
                                    'name' => $vu->username ?? ('Ekstensi ' . $vu->phone_number),
                                    'type' => 'SIP UDP'
                                ]);
                            }
                        }
                    }
                @endphp

                <div id="speed_dial_list" class="space-y-2.5 max-h-[460px] overflow-y-auto pr-1">
                    @foreach($mergedUsers as $contact)
                        <div class="speed-dial-item flex items-center justify-between p-3 rounded-2xl bg-black/[0.02] dark:bg-white/[0.02] border border-black/5 dark:border-white/5 hover:border-blue-500/30 transition" data-search="{{ strtolower($contact['name'] . ' ' . $contact['ext']) }}">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ substr($contact['ext'], 0, 2) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="font-bold text-xs">{{ $contact['name'] }}</p>
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-black/5 dark:bg-white/10 font-mono opacity-70">{{ $contact['type'] }}</span>
                                    </div>
                                    <p class="text-[10px] opacity-50 font-mono mt-0.5">Ext: {{ $contact['ext'] }}</p>
                                </div>
                            </div>
                            <button type="button" onclick="quickDial('{{ $contact['ext'] }}')" class="nm-btn px-3.5 py-1.5 rounded-xl font-bold text-xs text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5 transition hover:scale-105 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span>Call</span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: Softphone Dialpad, TTS Auto Call & Live Console (lg:col-span-5) --}}
        <div class="lg:col-span-5 space-y-6">

            {{-- Card 1: Softphone Dialpad Unit --}}
            <div class="nm-card p-6 sm:p-7 flex flex-col items-center justify-between space-y-5">
                
                {{-- Card Header --}}
                <div class="flex items-center justify-between w-full border-b border-black/5 dark:border-white/5 pb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold">Veten Softphone</h3>
                    </div>
                    <div class="flex items-center gap-1.5 flex-wrap justify-end">
                        <button type="button" id="btn_toggle_auto_answer" onclick="toggleAutoAnswer()" 
                                class="flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20 hover:bg-blue-500/20" 
                                title="Jawab otomatis saat Asterisk / TTS campaign menelepon ekstensi ini">
                            <span id="auto_answer_dot" class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                            <span id="auto_answer_label">Auto-Answer: AKTIF</span>
                        </button>
                        <button type="button" id="btn_toggle_noise" onclick="toggleNoiseSuppression()" 
                                class="flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20" 
                                title="Klik untuk mengubah mode peredam suara latar / noise cancellation">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span id="noise_label">Peredam Bising: AKTIF</span>
                        </button>
                        <span id="call_status_badge" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-200/60 dark:bg-white/10 text-slate-600 dark:text-slate-300">Ready</span>
                    </div>
                </div>

                {{-- Phone Screen Display (Clean Inset Box) --}}
                <div class="nm-inset w-full p-4 rounded-2xl flex flex-col items-center justify-center relative">
                    <div class="flex items-center justify-center relative w-full px-8">
                        <input type="text" id="target_ext" value="3030" placeholder="Ketik nomor..." 
                               class="w-full text-center text-3xl sm:text-4xl font-semibold tracking-wider text-slate-800 dark:text-white focus:outline-none placeholder-slate-300 dark:placeholder-slate-600 font-mono"
                               style="border: none !important; box-shadow: none !important; background: transparent !important; outline: none !important;">
                        
                        <button type="button" id="btn_backspace" class="absolute right-0 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 dark:hover:text-red-400 p-2 transition active:scale-90 cursor-pointer" title="Hapus Digit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"/><line x1="18" y1="9" x2="12" y2="15"/><line x1="12" y1="9" x2="18" y2="15"/></svg>
                        </button>
                    </div>

                    <p id="call_status" class="text-[11px] text-slate-400 font-medium mt-1">Ready to call</p>
                    <span id="call_timer" class="font-mono text-xs font-bold text-emerald-500 mt-0.5 hidden">00:00</span>

                    {{-- Live Studio Voice Activity & Noise Gate Visualizer --}}
                    <div id="mic_meter_wrapper" class="flex items-center gap-2 mt-2 px-3 py-1 rounded-full bg-black/5 dark:bg-white/5 border border-black/5 dark:border-white/10 transition-all select-none" title="Studio Voice Gate & Noise Suppression">
                        <span class="relative flex h-2 w-2">
                            <span id="gate_ping" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 hidden"></span>
                            <span id="gate_dot" class="relative inline-flex rounded-full h-2 w-2 bg-slate-400"></span>
                        </span>
                        <div class="w-20 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden relative">
                            <div id="mic_meter_bar" class="h-full bg-emerald-500 rounded-full transition-all duration-75 w-0"></div>
                        </div>
                        <span id="gate_badge" class="text-[9px] font-mono font-bold tracking-wider text-slate-400 uppercase">SIAP</span>
                    </div>

                    {{-- In-Call Action Bar (Mute, Hold, Noise Filter & Volume) --}}
                    <div id="incall_controls" class="flex flex-col items-center justify-center gap-2 mt-2.5 w-full hidden">
                        <div class="flex items-center justify-center gap-2 flex-wrap">
                            <button type="button" id="btn_toggle_mute" onclick="toggleMute()" class="nm-btn px-3 py-1 rounded-xl text-[11px] font-bold flex items-center gap-1.5 transition cursor-pointer">
                                <span id="mute_label">Mute Mic</span>
                            </button>
                            <button type="button" id="btn_toggle_hold" onclick="toggleHold()" class="nm-btn px-3 py-1 rounded-xl text-[11px] font-bold flex items-center gap-1.5 transition cursor-pointer">
                                <span id="hold_label">Hold</span>
                            </button>
                            <button type="button" id="btn_incall_noise" onclick="toggleNoiseSuppression()" class="nm-btn px-3 py-1 rounded-xl text-[11px] font-bold flex items-center gap-1.5 transition cursor-pointer text-emerald-600 dark:text-emerald-400" title="Peredam Suara Latar / Background Noise">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span id="incall_noise_label">Peredam ON</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                            <input type="range" id="vol_slider" min="0.1" max="1" step="0.05" value="0.60" oninput="setAudioVolume(this.value)" class="w-28 accent-blue-500 cursor-pointer" title="Volume Suara">
                            <span id="vol_val" class="text-[10px] font-mono text-slate-400 font-bold">60%</span>
                        </div>
                    </div>
                </div>

                {{-- 3x4 Neumorphic Keypad Buttons Grid --}}
                <div class="grid grid-cols-3 gap-y-3.5 gap-x-4 w-full max-w-[270px] mx-auto select-none justify-center">
                    <button type="button" onclick="dialDigit('1')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none">1</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-medium tracking-widest leading-none mt-1">&nbsp;</span>
                    </button>
                    <button type="button" onclick="dialDigit('2')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none">2</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest leading-none mt-1">ABC</span>
                    </button>
                    <button type="button" onclick="dialDigit('3')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none">3</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest leading-none mt-1">DEF</span>
                    </button>
                    
                    <button type="button" onclick="dialDigit('4')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none">4</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest leading-none mt-1">GHI</span>
                    </button>
                    <button type="button" onclick="dialDigit('5')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none">5</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest leading-none mt-1">JKL</span>
                    </button>
                    <button type="button" onclick="dialDigit('6')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none">6</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest leading-none mt-1">MNO</span>
                    </button>
                    
                    <button type="button" onclick="dialDigit('7')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none">7</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest leading-none mt-1">PQRS</span>
                    </button>
                    <button type="button" onclick="dialDigit('8')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none">8</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest leading-none mt-1">TUV</span>
                    </button>
                    <button type="button" onclick="dialDigit('9')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none">9</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest leading-none mt-1">WXYZ</span>
                    </button>
                    
                    <button type="button" onclick="dialDigit('*')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none text-slate-400 dark:text-slate-400">*</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-medium tracking-widest leading-none mt-1">&nbsp;</span>
                    </button>
                    <button type="button" onclick="dialDigit('0')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none">0</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest leading-none mt-1">+</span>
                    </button>
                    <button type="button" onclick="dialDigit('#')" class="nm-btn nm-dial-key">
                        <span class="text-2xl font-semibold leading-none text-slate-400 dark:text-slate-400">#</span>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 font-medium tracking-widest leading-none mt-1">&nbsp;</span>
                    </button>
                </div>

                {{-- Action Buttons: Green Call & Red End Call --}}
                <div class="flex items-center justify-center gap-8 pt-2 w-full">
                    <button type="button" id="btn_call" class="nm-call-action-btn bg-emerald-500 hover:bg-emerald-600 text-white shadow-lg shadow-emerald-500/30" style="background-color: #10b981 !important; color: #ffffff !important; border: none !important;" title="Panggil (Enter)">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </button>
                    <button type="button" id="btn_hangup" class="nm-call-action-btn bg-red-500 hover:bg-red-600 text-white shadow-lg shadow-red-500/30 opacity-30 pointer-events-none" style="background-color: #ef4444 !important; color: #ffffff !important; border: none !important;" title="Akhiri Panggilan">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M10.68 13.31a16 16 0 0 0 3.41 2.6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7 2 2 0 0 1 1.72 2v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.42 19.42 0 0 1-3.33-2.67m-2.67-3.34a19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/><line x1="22" x2="2" y1="2" y2="22"/></svg>
                    </button>
                </div>
            </div>

            {{-- Card 2: Text-to-Speech (TTS) Auto Call --}}
            <div class="nm-card p-6 sm:p-7 space-y-4">
                <div class="flex items-center gap-2.5 border-b border-black/5 dark:border-white/5 pb-3">
                    <span class="px-2 py-0.5 rounded-lg bg-[#2f6bfd] text-white text-[10px] font-black tracking-wider">TTS</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold">Text-to-Speech Auto Call</h3>
                        <p class="text-[11px] opacity-50">Sistem otomatis menelepon target dan membacakan pesan suara</p>
                    </div>
                </div>

                <div class="space-y-3.5">
                    <div>
                        <label class="block text-[11px] font-semibold opacity-60 mb-1">Pesan Suara</label>
                        <textarea id="tts_text" rows="2" class="w-full bg-transparent border border-black/10 dark:border-white/10 rounded-xl px-3.5 py-2.5 text-xs focus:outline-none focus:border-[#2f6bfd] transition" placeholder="Ketik pesan yang akan diucapkan oleh robot ke target...">Halo! Ini adalah uji coba broadcast suara text to speech, sistem softphone berfungsi normal.</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold opacity-60 mb-1">Target Ekstensi</label>
                            <input type="text" id="tts_target" value="9999" class="w-full bg-transparent border border-black/10 dark:border-white/10 rounded-xl px-3 py-2 text-xs text-center font-bold focus:outline-none focus:border-[#2f6bfd] transition" title="Gunakan 9999 untuk langsung memanggil softphone ini">
                            <p class="text-[9px] opacity-50 mt-0.5 text-center">Gunakan 9999 (softphone ini)</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold opacity-60 mb-1">Bahasa</label>
                            <select id="tts_lang" class="w-full bg-transparent border border-black/10 dark:border-white/10 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-[#2f6bfd] transition">
                                <option class="text-black" value="id">Indonesia (id-ID) Neural</option>
                                <option class="text-black" value="en">English (US) Neural</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                        <button type="button" onclick="previewTTSAudio()" id="btn_tts_preview" class="nm-btn py-2.5 px-3 text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer text-blue-600 dark:text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
                            <span>Dengarkan Preview</span>
                        </button>
                        <button type="button" id="btn_tts_call" onclick="startTTSCall()" class="nm-btn-brand py-2.5 px-3 text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <span>Kirim TTS Call</span>
                        </button>
                    </div>

                    <div id="tts_preview_player" class="hidden pt-1">
                        <audio id="tts_audio_element" controls class="w-full h-8 rounded-lg"></audio>
                    </div>
                    <div id="tts_status_toast" class="hidden p-2.5 rounded-xl text-xs font-semibold"></div>
                </div>
            </div>

            {{-- Card 3: SIP Live Console & Diagnostics Card --}}
            <div class="nm-card p-5 space-y-2.5">
                <div class="flex items-center justify-between border-b border-black/5 dark:border-white/5 pb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        <span class="text-xs font-bold">SIP Live Console</span>
                    </div>
                    <button type="button" onclick="document.getElementById('sip_log').innerHTML=''" class="text-[10px] nm-btn px-2.5 py-1 rounded-lg font-bold opacity-60 hover:opacity-100 transition cursor-pointer">
                        Clear Log
                    </button>
                </div>
                <div id="sip_log" class="nm-inset p-3.5 rounded-xl h-32 overflow-y-auto font-mono text-[10px] opacity-75 space-y-1">
                    <p class="text-emerald-500">> System softphone ready.</p>
                    <p class="text-slate-400">> Click "Connect & Register" to activate SIP connection.</p>
                </div>
            </div>

        </div>

    </div>

    {{-- High-Priority Incoming Call Modal Alert --}}
    <div id="incoming_call_modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-md"></div>
        <div class="relative nm-modal p-6 sm:p-7 w-full max-w-sm space-y-5 z-10 shadow-2xl rounded-3xl border border-emerald-500/30 text-center animate-bounce-short">
            {{-- Pulsing Ring Avatar --}}
            <div class="relative w-20 h-20 mx-auto">
                <div class="absolute inset-0 rounded-full bg-emerald-500/30 animate-ping"></div>
                <div class="relative w-20 h-20 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center text-white shadow-xl shadow-emerald-500/40">
                    <svg class="w-10 h-10 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
            </div>
            
            <div>
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 mb-1">
                    Panggilan Masuk
                </span>
                <h3 id="incoming_caller_name" class="text-lg font-black text-slate-800 dark:text-white">TTS Bot (Broadcast)</h3>
                <p id="incoming_countdown_text" class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Menjawab otomatis dalam 1 detik...</p>
            </div>

            <div class="flex items-center justify-center gap-3 pt-2">
                <button type="button" id="btn_modal_answer" onclick="acceptIncomingCall()" class="flex-1 py-3 px-4 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs shadow-lg shadow-emerald-500/30 flex items-center justify-center gap-2 cursor-pointer transition hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <span>Jawab Panggilan</span>
                </button>
                <button type="button" id="btn_modal_reject" onclick="rejectIncomingCall()" class="py-3 px-4 rounded-2xl bg-red-500/10 hover:bg-red-500/20 text-red-500 font-bold text-xs border border-red-500/20 flex items-center justify-center gap-1 cursor-pointer transition hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    <span>Tolak</span>
                </button>
            </div>
            
            <div class="pt-1 flex items-center justify-center gap-2 text-[11px] opacity-70">
                <input type="checkbox" id="modal_cb_auto_answer" onchange="toggleAutoAnswerCheckbox(this.checked)" class="rounded text-blue-600 focus:ring-0 cursor-pointer">
                <label for="modal_cb_auto_answer" class="cursor-pointer select-none">Jawab otomatis di masa mendatang</label>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const csrfToken = '{{ csrf_token() }}';

        // Set remote audio playback volume
        window.setAudioVolume = function(vol) {
            const v = parseFloat(vol) || 0.60;
            const remoteAudio = document.getElementById('remoteAudio');
            if (remoteAudio) remoteAudio.volume = v;
            const valEl = document.getElementById('vol_val');
            if (valEl) valEl.textContent = Math.round(v * 100) + '%';
        };

        // Filter Speed Dial Directory
        function filterSpeedDial(query) {
            const q = query.toLowerCase().trim();
            const items = document.querySelectorAll('.speed-dial-item');
            items.forEach(item => {
                const text = item.getAttribute('data-search') || '';
                if (!q || text.includes(q)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function dialDigit(d) {
            const el = document.getElementById('target_ext');
            if (el) el.value += d;
            playDTMFTone(d);

            if (window.activeSipSession && typeof window.activeSipSession.sendDTMF === 'function') {
                try { window.activeSipSession.sendDTMF(d); } catch(e) {}
            }
        }

        function quickDial(number) {
            const el = document.getElementById('target_ext');
            if (el) el.value = number;
            const btnCall = document.getElementById('btn_call');
            if (btnCall && !btnCall.disabled) {
                btnCall.click();
            }
        }

        // --- DTMF SOUND SYNTHESIS (Gentle Subtle Feedback) ---
        let dtmfAudioCtx = null;
        function playDTMFTone(digit) {
            try {
                if (!dtmfAudioCtx) dtmfAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
                if (dtmfAudioCtx.state === 'suspended') dtmfAudioCtx.resume();
                
                const freqs = {
                    '1': [697, 1209], '2': [697, 1336], '3': [697, 1477],
                    '4': [770, 1209], '5': [770, 1336], '6': [770, 1477],
                    '7': [852, 1209], '8': [852, 1336], '9': [852, 1477],
                    '*': [941, 1209], '0': [941, 1336], '#': [941, 1477]
                };
                const pair = freqs[digit];
                if (!pair) return;

                const osc1 = dtmfAudioCtx.createOscillator();
                const osc2 = dtmfAudioCtx.createOscillator();
                const gain = dtmfAudioCtx.createGain();

                osc1.frequency.value = pair[0];
                osc2.frequency.value = pair[1];
                gain.gain.setValueAtTime(0.015, dtmfAudioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.0001, dtmfAudioCtx.currentTime + 0.08);

                osc1.connect(gain);
                osc2.connect(gain);
                gain.connect(dtmfAudioCtx.destination);

                osc1.start();
                osc2.start();
                osc1.stop(dtmfAudioCtx.currentTime + 0.08);
                osc2.stop(dtmfAudioCtx.currentTime + 0.08);
            } catch(e) {}
        }

        // --- TTS AUDIO PREVIEW FUNCTION ---
        async function previewTTSAudio() {
            const textEl = document.querySelector('textarea#tts_text');
            const langEl = document.querySelector('select#tts_lang');
            const btn = document.getElementById('btn_tts_preview');
            const playerBox = document.getElementById('tts_preview_player');
            const audioEl = document.getElementById('tts_audio_element');

            if (!textEl || !langEl) return;
            const text = textEl.value.trim();
            const lang = langEl.value || 'id';

            if (!text) {
                showTtsToast('Silakan ketik pesan suara terlebih dahulu!', 'error');
                return;
            }

            const originalBtn = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span>Memuat audio...</span>';
            }

            try {
                const url = '/tts-preview?text=' + encodeURIComponent(text) + '&lang=' + encodeURIComponent(lang) + '&t=' + Date.now();
                if (audioEl) {
                    audioEl.src = url;
                    if (playerBox) playerBox.classList.remove('hidden');
                    await audioEl.play();
                    showTtsToast('Memutar preview suara...', 'success');
                }
            } catch (err) {
                showTtsToast('Gagal memutar audio: ' + err.message, 'error');
            } finally {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalBtn;
                }
            }
        }

        // --- TTS CALL FUNCTION ---
        async function startTTSCall() {
            const textEl   = document.querySelector('textarea#tts_text');
            const targetEl = document.querySelector('input#tts_target');
            const langEl   = document.querySelector('select#tts_lang');
            const btn      = document.getElementById('btn_tts_call');

            if (!textEl || !targetEl || !langEl || !btn) return;

            let text = textEl.value.trim();
            const target = targetEl.value.trim() || '9999';
            const lang   = langEl.value || 'id';

            if (!text) { 
                showTtsToast('Silakan isi pesan suara TTS terlebih dahulu!', 'error');
                return; 
            }
            if (!target) { 
                showTtsToast('Silakan isi ekstensi target!', 'error');
                return; 
            }

            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span>Memanggil ' + target + '...</span>';

            try {
                const response = await fetch('/tts-call', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ text, target, lang })
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    showTtsToast('Berhasil! Panggilan suara dikirim ke ekstensi ' + target, 'success');
                } else {
                    throw new Error(data.error || 'Terjadi kesalahan pada server');
                }
            } catch (err) {
                showTtsToast('Gagal kirim panggilan: ' + err.message, 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
            }
        }

        function showTtsToast(msg, type) {
            const toast = document.getElementById('tts_status_toast');
            if (!toast) return;
            toast.textContent = msg;
            toast.className = 'p-2.5 rounded-xl text-xs font-semibold ' + 
                (type === 'success' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'bg-red-500/10 text-red-500 border border-red-500/20');
            toast.classList.remove('hidden');
            setTimeout(() => { toast.classList.add('hidden'); }, 5000);
        }

        // --- AUTO-ANSWER & MODAL STATE ---
        let isAutoAnswer = localStorage.getItem('webrtc_auto_answer') !== 'false'; // Default TRUE untuk kemudahan testing
        let autoAnswerTimer = null;

        window.toggleAutoAnswer = function() {
            isAutoAnswer = !isAutoAnswer;
            localStorage.setItem('webrtc_auto_answer', isAutoAnswer ? 'true' : 'false');
            updateAutoAnswerUI();
        };

        window.toggleAutoAnswerCheckbox = function(val) {
            isAutoAnswer = !!val;
            localStorage.setItem('webrtc_auto_answer', isAutoAnswer ? 'true' : 'false');
            updateAutoAnswerUI();
        };

        function updateAutoAnswerUI() {
            const btn = document.getElementById('btn_toggle_auto_answer');
            const dot = document.getElementById('auto_answer_dot');
            const label = document.getElementById('auto_answer_label');
            const cb = document.getElementById('modal_cb_auto_answer');

            if (cb) cb.checked = isAutoAnswer;

            if (isAutoAnswer) {
                if (btn) {
                    btn.className = 'flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20 hover:bg-blue-500/20';
                }
                if (dot) dot.className = 'w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse';
                if (label) label.textContent = 'Auto-Answer: AKTIF';
            } else {
                if (btn) {
                    btn.className = 'flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer bg-slate-200/60 dark:bg-white/10 text-slate-500 border border-slate-300 dark:border-white/10 hover:bg-slate-200';
                }
                if (dot) dot.className = 'w-1.5 h-1.5 rounded-full bg-slate-400';
                if (label) label.textContent = 'Auto-Answer: NONAKTIF';
            }
        }

        function showIncomingModal(caller) {
            const modal = document.getElementById('incoming_call_modal');
            const nameEl = document.getElementById('incoming_caller_name');
            const cdEl = document.getElementById('incoming_countdown_text');
            const cb = document.getElementById('modal_cb_auto_answer');
            if (cb) cb.checked = isAutoAnswer;

            if (nameEl) nameEl.textContent = caller || 'TTS Bot (Broadcast)';
            if (modal) modal.classList.remove('hidden');

            if (isAutoAnswer) {
                if (cdEl) cdEl.textContent = 'Menjawab otomatis dalam 1 detik...';
                if (autoAnswerTimer) clearTimeout(autoAnswerTimer);
                autoAnswerTimer = setTimeout(() => {
                    acceptIncomingCall();
                }, 750);
            } else {
                if (cdEl) cdEl.textContent = 'Klik "Jawab Panggilan" untuk mendengarkan';
            }
        }

        function hideIncomingModal() {
            if (autoAnswerTimer) {
                clearTimeout(autoAnswerTimer);
                autoAnswerTimer = null;
            }
            const modal = document.getElementById('incoming_call_modal');
            if (modal) modal.classList.add('hidden');
        }

        window.acceptIncomingCall = function() {
            hideIncomingModal();
            stopIncomingChime();
            unlockAudioContext();
            if (window.activeSipSession && window.activeSipSession.direction === 'incoming') {
                window.activeSipSession.answer({
                    mediaConstraints: { audio: true, video: false },
                    pcConfig: { iceServers: [], iceCandidatePoolSize: 0, bundlePolicy: 'max-bundle', rtcpMuxPolicy: 'require' }
                });
            }
        };

        window.rejectIncomingCall = function() {
            hideIncomingModal();
            stopIncomingChime();
            if (window.activeSipSession) {
                window.activeSipSession.terminate();
            }
            if (typeof resetCallUI === 'function') resetCallUI();
        };

        // --- MAIN WEBRTC & SIP ENGINE ---
        document.addEventListener('DOMContentLoaded', () => {
            let ua = null;
            let activeSession = null;
            let registered = false;
            let callTimerInterval = null;
            let callSeconds = 0;
            let incomingChimeInterval = null;
            let audioCtx = null;
            let isMuted = false;
            let isHeld = false;

            window.activeSipSession = null;

            const btnReg      = document.getElementById('btn_register');
            const statusText  = document.getElementById('reg_status');
            const statusDot   = document.getElementById('reg_dot');
            const callStatus  = document.getElementById('call_status');
            const callTimer   = document.getElementById('call_timer');
            const btnCall     = document.getElementById('btn_call');
            const btnHangup   = document.getElementById('btn_hangup');
            const targetExt   = document.getElementById('target_ext');
            const btnBksp     = document.getElementById('btn_backspace');
            const remoteAudio = document.getElementById('remoteAudio');
            const incallCtrls = document.getElementById('incall_controls');

            // Microphone permission & pre-warming stream
            const micBanner = document.getElementById('mic_banner');
            const micTitle  = document.getElementById('mic_title');
            const micDesc   = document.getElementById('mic_desc');
            const btnMic    = document.getElementById('btn_request_mic');

            let isNoiseSuppressionActive = true;
            let statsVisualizerTimer = null;

            // Standard Clean WebRTC Voice Constraints with Full Native Acoustic Echo Cancellation (AEC)
            // Critical: Uses browser native AEC3 directly to completely eliminate feedback screeching (nyaring)
            const audioMediaConstraints = {
                audio: {
                    echoCancellation: true,
                    noiseSuppression: true,
                    autoGainControl: true
                },
                video: false
            };

            // Non-intrusive Live Studio Voice Visualizer using WebRTC Native Stats (0-Interference with AEC)
            function startStatsVisualizer(session) {
                stopStatsVisualizer();
                const micMeterBar = document.getElementById('mic_meter_bar');
                const gateBadge = document.getElementById('gate_badge');
                const gateDot = document.getElementById('gate_dot');
                const gatePing = document.getElementById('gate_ping');

                statsVisualizerTimer = setInterval(async () => {
                    if (!session || !session.connection || session.connection.connectionState === 'closed') {
                        stopStatsVisualizer();
                        return;
                    }
                    try {
                        const stats = await session.connection.getStats();
                        let audioLevel = 0;
                        stats.forEach(report => {
                            if (report.type === 'media-source' && report.kind === 'audio' && typeof report.audioLevel === 'number') {
                                audioLevel = Math.max(audioLevel, report.audioLevel);
                            } else if (report.type === 'outbound-rtp' && report.kind === 'audio' && typeof report.audioLevel === 'number') {
                                audioLevel = Math.max(audioLevel, report.audioLevel);
                            }
                        });

                        const percent = Math.min(100, Math.round(audioLevel * 100 * 2.5));
                        if (micMeterBar) micMeterBar.style.width = percent + '%';

                        if (isNoiseSuppressionActive) {
                            if (percent > 10) {
                                if (gateBadge) gateBadge.innerHTML = '<span class="text-emerald-500 font-bold">SUARA JELAS</span>';
                                if (gateDot) gateDot.className = 'relative inline-flex rounded-full h-2 w-2 bg-emerald-500';
                                if (gatePing) gatePing.classList.remove('hidden');
                                if (micMeterBar) micMeterBar.className = 'h-full bg-emerald-500 rounded-full transition-all duration-75';
                            } else {
                                if (gateBadge) gateBadge.innerHTML = '<span class="text-slate-400">TEREDAM</span>';
                                if (gateDot) gateDot.className = 'relative inline-flex rounded-full h-2 w-2 bg-slate-400';
                                if (gatePing) gatePing.classList.add('hidden');
                                if (micMeterBar) micMeterBar.className = 'h-full bg-slate-300 dark:bg-slate-600 rounded-full transition-all duration-75';
                            }
                        } else {
                            if (gateBadge) gateBadge.innerHTML = '<span class="text-amber-500 font-bold">MODE ASLI</span>';
                            if (gateDot) gateDot.className = 'relative inline-flex rounded-full h-2 w-2 bg-amber-500';
                            if (gatePing) gatePing.classList.add('hidden');
                            if (micMeterBar) micMeterBar.className = 'h-full bg-amber-500 rounded-full transition-all duration-75';
                        }
                    } catch(e) {}
                }, 150);
            }

            function stopStatsVisualizer() {
                if (statsVisualizerTimer) {
                    clearInterval(statsVisualizerTimer);
                    statsVisualizerTimer = null;
                }
                const micMeterBar = document.getElementById('mic_meter_bar');
                const gateBadge = document.getElementById('gate_badge');
                const gateDot = document.getElementById('gate_dot');
                const gatePing = document.getElementById('gate_ping');
                if (micMeterBar) micMeterBar.style.width = '0%';
                if (gateBadge) gateBadge.textContent = 'SIAP';
                if (gateDot) gateDot.className = 'relative inline-flex rounded-full h-2 w-2 bg-slate-400';
                if (gatePing) gatePing.classList.add('hidden');
            }

            window.toggleNoiseSuppression = async function() {
                isNoiseSuppressionActive = !isNoiseSuppressionActive;
                updateNoiseSuppressionUI();

                if (activeSession && activeSession.connection) {
                    const senders = activeSession.connection.getSenders();
                    for (const sender of senders) {
                        if (sender.track && sender.track.kind === 'audio') {
                            try {
                                await sender.track.applyConstraints({
                                    echoCancellation: true,
                                    noiseSuppression: isNoiseSuppressionActive,
                                    autoGainControl: true
                                });
                            } catch(e) {}
                        }
                    }
                }
            };

            function updateNoiseSuppressionUI() {
                const btnBadge = document.getElementById('btn_toggle_noise');
                const incallBtn = document.getElementById('btn_incall_noise');
                const incallLabel = document.getElementById('incall_noise_label');

                if (isNoiseSuppressionActive) {
                    if (btnBadge) {
                        btnBadge.className = 'flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20';
                        btnBadge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> <span id="noise_label">Peredam Bising: AKTIF</span>';
                    }
                    if (incallBtn) {
                        incallBtn.classList.add('text-emerald-600', 'dark:text-emerald-400');
                        incallBtn.classList.remove('text-slate-400');
                        if (incallLabel) incallLabel.textContent = 'Peredam ON';
                    }
                } else {
                    if (btnBadge) {
                        btnBadge.className = 'flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer bg-slate-200/60 dark:bg-white/10 text-slate-500 border border-slate-300 dark:border-white/10 hover:bg-slate-200';
                        btnBadge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> <span id="noise_label">Peredam: MATI</span>';
                    }
                    if (incallBtn) {
                        incallBtn.classList.remove('text-emerald-600', 'dark:text-emerald-400');
                        incallBtn.classList.add('text-slate-400');
                        if (incallLabel) incallLabel.textContent = 'Peredam OFF';
                    }
                }
            }

            if (btnMic) {
                btnMic.addEventListener('click', async () => {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia(audioMediaConstraints);
                        stream.getTracks().forEach(t => t.stop());
                        if (micBanner) micBanner.style.display = 'none';
                    } catch (err) {
                        if (micTitle) micTitle.textContent = 'Izin Mikrofon Ditolak Browser';
                        if (micDesc) micDesc.textContent = 'Silakan klik icon gembok di URL browser untuk mengizinkan akses microphone.';
                    }
                });
            }

            if (btnBksp && targetExt) {
                btnBksp.addEventListener('click', () => {
                    targetExt.value = targetExt.value.slice(0, -1);
                });
            }

            // Keyboard support (Press 0-9, Backspace, Enter to call)
            document.addEventListener('keydown', (e) => {
                if (['INPUT', 'TEXTAREA'].includes(document.activeElement?.tagName) && document.activeElement !== targetExt) {
                    return;
                }
                if (e.key >= '0' && e.key <= '9' || e.key === '*' || e.key === '#') {
                    dialDigit(e.key);
                } else if (e.key === 'Backspace' && document.activeElement !== targetExt) {
                    targetExt.value = targetExt.value.slice(0, -1);
                } else if (e.key === 'Enter') {
                    if (activeSession) {
                        // In call
                    } else if (btnCall && !btnCall.disabled) {
                        btnCall.click();
                    }
                }
            });

            // Instant 0ms ICE Candidate gathering (Direct Host to Asterisk, no STUN timeout)
            const pcConfig = {
                iceServers: [],
                iceCandidatePoolSize: 0,
                bundlePolicy: 'max-bundle',
                rtcpMuxPolicy: 'require'
            };

            function unlockAudioContext() {
                try {
                    if (!audioCtx) {
                        audioCtx = new (window.AudioContext || window.webkitAudioContext)({ latencyHint: 'interactive' });
                    }
                    if (audioCtx.state === 'suspended') {
                        audioCtx.resume();
                    }
                    if (remoteAudio) {
                        remoteAudio.muted = false;
                        const volSlider = document.getElementById('vol_slider');
                        remoteAudio.volume = volSlider ? parseFloat(volSlider.value) : 1.0;
                    }
                } catch(e) {}
            }

            // In-Call Controls
            window.toggleMute = function() {
                if (!activeSession) return;
                const muteLabel = document.getElementById('mute_label');

                if (isMuted) {
                    activeSession.unmute({ audio: true });
                    isMuted = false;
                    if (muteLabel) muteLabel.textContent = 'Mute Mic';
                } else {
                    activeSession.mute({ audio: true });
                    isMuted = true;
                    if (muteLabel) muteLabel.textContent = 'Unmute Mic';
                }
            };

            window.toggleHold = function() {
                if (!activeSession) return;
                const holdLabel = document.getElementById('hold_label');

                if (isHeld) {
                    activeSession.unhold();
                    isHeld = false;
                    if (holdLabel) holdLabel.textContent = 'Hold';
                    if (callStatus) callStatus.textContent = 'Panggilan Berlangsung';
                } else {
                    activeSession.hold();
                    isHeld = true;
                    if (holdLabel) holdLabel.textContent = 'Resume';
                    if (callStatus) callStatus.textContent = 'Panggilan Ditahan (On Hold)';
                }
            };

            // Debug Logging Hook
            if (window.JsSIP) {
                JsSIP.debug.enable('JsSIP:*');
            }
            const logArea = document.getElementById('sip_log');
            const origLog = console.log.bind(console);
            const origErr = console.error.bind(console);

            function appendLog(type, args) {
                if (!logArea) return;
                const msg = Array.from(args).map(a => (typeof a === 'object' ? JSON.stringify(a) : String(a))).join(' ');
                if (msg.includes('JsSIP') || msg.includes('SIP') || msg.includes('WEBRTC')) {
                    const line = document.createElement('p');
                    line.style.color = type === 'error' ? '#ef4444' : (type === 'warn' ? '#eab308' : '#10b981');
                    line.textContent = '> [' + type + '] ' + msg.substring(0, 180);
                    logArea.appendChild(line);
                    logArea.scrollTop = logArea.scrollHeight;
                }
            }
            console.log   = (...args) => { origLog(...args); appendLog('log', args); };
            console.error = (...args) => { origErr(...args); appendLog('error', args); };

            function setRegStatus(text, color, dotColor) {
                if (statusText) {
                    statusText.textContent = text;
                    statusText.style.color = color;
                }
                if (statusDot) {
                    statusDot.style.backgroundColor = dotColor || color;
                }
            }

            // Gentle melodious chime for INCOMING calls only (no loud screaming tones)
            function playIncomingChime() {
                try {
                    unlockAudioContext();
                    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    if (incomingChimeInterval) return;

                    const playChime = () => {
                        if (!audioCtx) return;
                        const t = audioCtx.currentTime;
                        const osc = audioCtx.createOscillator();
                        const gain = audioCtx.createGain();
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(523.25, t); // C5 note
                        osc.frequency.setValueAtTime(659.25, t + 0.15); // E5 note
                        gain.gain.setValueAtTime(0.03, t);
                        gain.gain.exponentialRampToValueAtTime(0.0001, t + 0.6);
                        osc.connect(gain);
                        gain.connect(audioCtx.destination);
                        osc.start(t);
                        osc.stop(t + 0.6);
                    };

                    playChime();
                    incomingChimeInterval = setInterval(playChime, 2500);
                } catch(e) {}
            }

            function stopIncomingChime() {
                if (incomingChimeInterval) {
                    clearInterval(incomingChimeInterval);
                    incomingChimeInterval = null;
                }
            }

            function startTimer() {
                stopTimer();
                callSeconds = 0;
                if (callTimer) {
                    callTimer.classList.remove('hidden');
                    callTimer.textContent = '00:00';
                }
                callTimerInterval = setInterval(() => {
                    callSeconds++;
                    const m = String(Math.floor(callSeconds / 60)).padStart(2, '0');
                    const s = String(callSeconds % 60).padStart(2, '0');
                    if (callTimer) callTimer.textContent = `${m}:${s}`;
                }, 1000);
            }

            function stopTimer() {
                if (callTimerInterval) {
                    clearInterval(callTimerInterval);
                    callTimerInterval = null;
                }
                if (callTimer) callTimer.classList.add('hidden');
            }

            function logWebRtcCall(caller, recipient, duration, status) {
                try {
                    fetch('{{ route("webrtc.history.log") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            caller: caller || 'Unknown',
                            recipient: recipient || 'Unknown',
                            duration: duration || '00:00',
                            status: status || 'Answered'
                        })
                    }).catch(() => {});
                } catch(e) {}
            }

            let boundStreamId = null;

            function stopAllAudioStreams() {
                stopStatsVisualizer();
            }

            function resetCallUI() {
                stopTimer();
                stopIncomingChime();
                stopStatsVisualizer();
                isMuted = false;
                isHeld = false;

                if (incallCtrls) incallCtrls.classList.add('hidden');
                if (remoteAudio) {
                    try {
                        remoteAudio.pause();
                        remoteAudio.srcObject = null;
                    } catch(e) {}
                }

                const badge = document.getElementById('call_status_badge');
                if (badge) {
                    badge.textContent = registered ? 'Ready' : 'Offline';
                    badge.className = registered ? 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-200/60 dark:bg-white/10 text-slate-600 dark:text-slate-300';
                }

                if (callStatus) callStatus.textContent = registered ? 'Ready to call' : 'Offline';
                if (btnCall) {
                    btnCall.style.opacity = '1';
                    btnCall.style.pointerEvents = 'auto';
                }
                if (btnHangup) {
                    btnHangup.style.opacity = '0.3';
                    btnHangup.style.pointerEvents = 'none';
                }
            }

            // Register & Connect Action
            btnReg.addEventListener('click', () => {
                unlockAudioContext();

                if (registered && ua) {
                    try { ua.stop(); } catch(e) {}
                    registered = false;
                    stopAllAudioStreams();
                    setRegStatus('Offline', '#64748b', '#64748b');
                    btnReg.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg> <span>Connect & Register</span>';
                    resetCallUI();
                    return;
                }

                const ws     = document.getElementById('sip_ws').value.trim();
                const domain = document.getElementById('sip_domain').value.trim();
                const ext    = document.getElementById('sip_extension').value.trim();
                const pass   = document.getElementById('sip_password').value.trim();

                if (!ws || !domain || !ext || !pass) {
                    setRegStatus('Isi data lengkap!', '#ef4444', '#ef4444');
                    return;
                }

                setRegStatus('Connecting...', '#eab308', '#eab308');
                btnReg.disabled = true;
                btnReg.innerHTML = '<span>Connecting...</span>';

                try {
                    const socket = new JsSIP.WebSocketInterface(ws);
                    const configuration = {
                        sockets            : [socket],
                        uri                : 'sip:' + ext + '@' + domain,
                        authorization_user : ext,
                        display_name       : ext,
                        password           : pass,
                        register           : true,
                        register_expires   : 120,
                        connection_recovery_min_interval: 2,
                        connection_recovery_max_interval: 30,
                        pcConfig           : pcConfig,
                    };

                    if (ua) { try { ua.stop(); } catch(e) {} }

                    ua = new JsSIP.UA(configuration);
                    window.sipUA = ua;

                    ua.on('connecting', () => setRegStatus('Connecting WS...', '#eab308', '#eab308'));
                    ua.on('connected',  () => setRegStatus('WS OK! Registering...', '#eab308', '#eab308'));

                    ua.on('disconnected', (e) => {
                        registered = false;
                        setRegStatus(e.error ? ('Error: ' + e.error) : 'WS Terputus', '#ef4444', '#ef4444');
                        btnReg.disabled = false;
                        btnReg.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg> <span>Connect & Register</span>';
                        resetCallUI();
                    });

                    ua.on('registered', () => {
                        registered = true;
                        btnReg.disabled = false;
                        setRegStatus('Connected: ' + ext, '#10b981', '#10b981');
                        btnReg.innerHTML = '<span>Disconnect</span>';
                        if (callStatus) callStatus.textContent = 'Ready to call';
                        const badge = document.getElementById('call_status_badge');
                        if (badge) {
                            badge.textContent = 'Ready';
                            badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400';
                        }
                    });

                    ua.on('unregistered', () => {
                        registered = false;
                        setRegStatus('Offline', '#64748b', '#64748b');
                        btnReg.disabled = false;
                        btnReg.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg> <span>Connect & Register</span>';
                        resetCallUI();
                    });

                    ua.on('registrationFailed', (e) => {
                        registered = false;
                        setRegStatus('Gagal: ' + (e.cause || 'Auth Failed'), '#ef4444', '#ef4444');
                        btnReg.disabled = false;
                        btnReg.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg> <span>Connect & Register</span>';
                        resetCallUI();
                    });

                    // Inbound / Outbound Calls
                    ua.on('newRTCSession', (data) => {
                        const session = data.session;
                        unlockAudioContext();
                        window.activeSipSession = session;

                        // Clean, stable WebRTC Remote Audio Stream Binding
                        // Attached once to preserve Chrome's native AEC3 acoustic echo cancellation pipeline
                        function setupRemoteAudio(pc) {
                            if (!pc || pc.__audioHooked) return;
                            pc.__audioHooked = true;

                            pc.ontrack = (event) => {
                                if (!remoteAudio) return;
                                const stream = (event.streams && event.streams[0]) ? event.streams[0] : new MediaStream([event.track]);
                                if (remoteAudio.srcObject !== stream) {
                                    remoteAudio.srcObject = stream;
                                    remoteAudio.muted = false;
                                    const volSlider = document.getElementById('vol_slider');
                                    remoteAudio.volume = volSlider ? parseFloat(volSlider.value) : 0.65;
                                    remoteAudio.play().catch(() => {});
                                }
                            };
                        }

                        session.on('peerconnection', (pcData) => {
                            setupRemoteAudio(pcData.peerconnection);
                        });

                        if (session.connection) {
                            setupRemoteAudio(session.connection);
                        }

                        if (session.direction === 'incoming') {
                            const caller = session.remote_identity ? session.remote_identity.uri.user : 'Unknown';
                            if (callStatus) callStatus.textContent = 'Panggilan masuk dari ' + caller + '...';
                            const badge = document.getElementById('call_status_badge');
                            if (badge) {
                                badge.textContent = 'Incoming Call';
                                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white animate-pulse';
                            }
                            playIncomingChime();
                            showIncomingModal(caller);

                            btnCall.style.opacity = '1';
                            btnCall.style.pointerEvents = 'auto';
                            btnHangup.style.opacity = '1';
                            btnHangup.style.pointerEvents = 'auto';

                            btnCall.onclick = () => acceptIncomingCall();
                            btnHangup.onclick = () => rejectIncomingCall();
                        }

                        session.on('connecting', () => {
                            if (session.direction === 'outgoing') {
                                if (callStatus) callStatus.textContent = 'Mengirim sinyal panggil ke ' + (targetExt?.value.trim() || 'tujuan') + '...';
                            }
                        });

                        session.on('progress', () => {
                            if (session.direction === 'outgoing') {
                                if (callStatus) callStatus.textContent = 'Berdering (Ringing)...';
                                const badge = document.getElementById('call_status_badge');
                                if (badge) {
                                    badge.textContent = 'Ringing...';
                                    badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-500 text-white animate-pulse';
                                }
                            }
                        });

                        session.on('accepted', () => {
                            hideIncomingModal();
                            stopIncomingChime();
                            unlockAudioContext();
                            if (remoteAudio && remoteAudio.paused) {
                                remoteAudio.play().catch(() => {});
                            }
                            if (callStatus) callStatus.textContent = 'Panggilan Berlangsung';
                            const badge = document.getElementById('call_status_badge');
                            if (badge) {
                                badge.textContent = 'In Call';
                                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500 text-white';
                            }
                            if (incallCtrls) incallCtrls.classList.remove('hidden');
                            startTimer();
                            startStatsVisualizer(session);

                            btnCall.style.opacity = '0.3';
                            btnCall.style.pointerEvents = 'none';
                            btnHangup.style.opacity = '1';
                            btnHangup.style.pointerEvents = 'auto';
                            btnHangup.onclick = () => {
                                session.terminate();
                            };
                        });

                        session.on('confirmed', () => {
                            hideIncomingModal();
                            stopIncomingChime();
                            unlockAudioContext();
                            if (remoteAudio && remoteAudio.paused) {
                                remoteAudio.play().catch(() => {});
                            }
                            startStatsVisualizer(session);
                        });

                        session.on('ended', () => {
                            hideIncomingModal();
                            stopStatsVisualizer();
                            if (callStatus) callStatus.textContent = 'Panggilan Berakhir';
                            const m = String(Math.floor(callSeconds / 60)).padStart(2, '0');
                            const s = String(callSeconds % 60).padStart(2, '0');
                            const finalDuration = `${m}:${s}`;
                            const myExt = document.getElementById('sip_extension')?.value.trim() || '{{ auth()->user()->asterisk_exten ?? "User" }}';
                            const remoteUser = (session.remote_identity && session.remote_identity.uri) ? session.remote_identity.uri.user : (targetExt?.value.trim() || 'Unknown');
                            const caller = session.direction === 'incoming' ? remoteUser : myExt;
                            const recipient = session.direction === 'incoming' ? myExt : remoteUser;
                            logWebRtcCall(caller, recipient, finalDuration, 'Answered');

                            resetCallUI();
                            activeSession = null;
                            window.activeSipSession = null;
                        });

                        session.on('failed', (e) => {
                            hideIncomingModal();
                            stopStatsVisualizer();
                            let reason = e.cause || 'Gagal Terhubung';
                            if (reason === 'Unavailable' || reason === 'Temporarily Unavailable') reason = 'Tujuan Offline / Tidak Aktif';
                            else if (reason === 'Busy') reason = 'Tujuan Sedang Sibuk';
                            else if (reason === 'Rejected') reason = 'Panggilan Ditolak';
                            else if (reason === 'Not Found') reason = 'Nomor Tidak Terdaftar';

                            const myExt = document.getElementById('sip_extension')?.value.trim() || '{{ auth()->user()->asterisk_exten ?? "User" }}';
                            const remoteUser = (session.remote_identity && session.remote_identity.uri) ? session.remote_identity.uri.user : (targetExt?.value.trim() || 'Unknown');
                            const caller = session.direction === 'incoming' ? remoteUser : myExt;
                            const recipient = session.direction === 'incoming' ? myExt : remoteUser;
                            logWebRtcCall(caller, recipient, '00:00', reason);

                            if (callStatus) callStatus.textContent = reason;
                            const badge = document.getElementById('call_status_badge');
                            if (badge) {
                                badge.textContent = reason;
                                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-500 text-white';
                            }

                            setTimeout(() => { resetCallUI(); }, 3500);
                            activeSession = null;
                            window.activeSipSession = null;
                        });

                        activeSession = session;
                    });

                    ua.start();

                } catch (err) {
                    setRegStatus('Error: ' + err.message, '#ef4444', '#ef4444');
                    btnReg.disabled = false;
                    btnReg.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg> <span>Connect & Register</span>';
                }
            });

            // Call Button Click (Direct Instant Call with Native WebRTC Constraints)
            btnCall.addEventListener('click', () => {
                unlockAudioContext();
                if (!registered || !ua) {
                    btnReg.click();
                    setTimeout(() => {
                        if (registered) btnCall.click();
                    }, 1200);
                    return;
                }

                const target = targetExt ? targetExt.value.trim() : '';
                if (!target) {
                    if (callStatus) callStatus.textContent = 'Ketik nomor tujuan terlebih dahulu!';
                    return;
                }

                const domain = document.getElementById('sip_domain').value.trim();
                const targetURI = 'sip:' + target + '@' + domain;

                if (callStatus) callStatus.textContent = 'Menghubungkan ke ' + target + '...';
                const badge = document.getElementById('call_status_badge');
                if (badge) {
                    badge.textContent = 'Calling...';
                    badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-500 text-white';
                }

                btnCall.style.opacity = '0.3';
                btnCall.style.pointerEvents = 'none';
                btnHangup.style.opacity = '1';
                btnHangup.style.pointerEvents = 'auto';

                const options = {
                    mediaConstraints: audioMediaConstraints,
                    pcConfig: pcConfig,
                    rtcOfferConstraints: {
                        offerToReceiveAudio: 1,
                        offerToReceiveVideo: 0
                    }
                };

                try {
                    const session = ua.call(targetURI, options);
                    activeSession = session;
                    window.activeSipSession = session;

                    btnHangup.onclick = () => {
                        session.terminate();
                        resetCallUI();
                    };
                } catch (err) {
                    if (callStatus) callStatus.textContent = 'Error: ' + err.message;
                    resetCallUI();
                }
            });

            // Password eye toggle
            const togglePassBtn = document.getElementById('toggle_password');
            const passInput = document.getElementById('sip_password');
            if (togglePassBtn && passInput) {
                togglePassBtn.addEventListener('click', () => {
                    passInput.type = passInput.type === 'password' ? 'text' : 'password';
                });
            }

            // Pre-warm audio on first user gesture anywhere on keypad or document
            const prewarmHandler = () => {
                unlockAudioContext();
                document.removeEventListener('click', prewarmHandler);
                document.removeEventListener('keydown', prewarmHandler);
            };
            document.addEventListener('click', prewarmHandler, { once: true });
            document.addEventListener('keydown', prewarmHandler, { once: true });

            // Auto-connect SIP on page load if credentials exist
            setTimeout(() => {
                updateAutoAnswerUI();
                if (!registered && btnReg && !btnReg.disabled) {
                    const ws = document.getElementById('sip_ws')?.value.trim();
                    const ext = document.getElementById('sip_extension')?.value.trim();
                    const pass = document.getElementById('sip_password')?.value.trim();
                    if (ws && ext && pass) {
                        btnReg.click();
                    }
                }
            }, 600);
        });
    </script>
@endpush