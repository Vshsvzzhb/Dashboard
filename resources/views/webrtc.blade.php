<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - WebRTC Phone</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    </style>
</head>
<body class="bg-[#0c1638] text-white antialiased selection:bg-blue-500 selection:text-white">

    <div class="min-h-screen bg-gradient-to-br from-[#0c1638] via-[#0d1844] to-[#1a2f8a] flex relative overflow-hidden">
        
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" class="absolute -bottom-48 -left-48 w-[850px] max-w-none opacity-10 pointer-events-none select-none z-0">
        <div class="absolute -bottom-24 -right-24 w-[600px] h-[600px] bg-purple-600/20 rounded-full blur-[160px] pointer-events-none"></div>

        @include('layouts.sidebar')

        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            
            <header class="h-20 border-b border-white/10 px-6 md:px-10 flex items-center justify-between bg-white/[0.02] backdrop-blur-xl sticky top-0 z-30">
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">WebRTC Softphone</h1>
                    <p class="text-xs text-slate-300">Web-based VoIP client for RPL Team.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> LIVE SYNC
                    </div>
                    <div class="flex items-center gap-3 pl-3 border-l border-white/10">
                        <div class="w-10 h-10 rounded-xl bg-purple-600/40 border border-purple-400/30 flex items-center justify-center font-bold text-xs text-white shadow-md">
                            SU
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-6 md:p-10 space-y-6 max-w-7xl w-full mx-auto pb-20">
                
                {{-- Microphone Alert --}}
                <div class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-4 flex items-center justify-between shadow-lg">
                    <div>
                        <h4 class="text-amber-400 font-bold text-sm">Izin Mikrofon Diperlukan</h4>
                        <p class="text-amber-200/70 text-xs mt-0.5">Klik tombol di sebelah kanan atau klik ikon lock di address bar → Microphone → Allow</p>
                    </div>
                    <button class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-black font-bold text-xs rounded-xl transition">
                        Izinkan Mikrofon
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    {{-- SIP Configuration Box --}}
                    <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-6">
                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                            <h3 class="text-base font-bold text-white">SIP Configuration</h3>
                        </div>

                        <form class="space-y-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400 mb-1">WebSocket URI</label>
                                <input type="text" value="ws://52.2.21.5:8088/ws" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400 mb-1">SIP Domain/Host</label>
                                <input type="text" value="52.2.21.5" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400 mb-1">Extension</label>
                                <input type="text" value="101" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400 mb-1">Password</label>
                                <input type="password" value="*********" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                            </div>

                            <div class="pt-2">
                                <button type="button" class="w-full py-3 bg-[#2f6bfd] hover:bg-blue-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                                    Connect & Register
                                </button>
                                <p class="text-center text-[10px] text-slate-500 font-bold uppercase mt-3">Offline</p>
                            </div>
                        </form>
                    </div>

                    {{-- Dialpad Box --}}
                    <div class="bg-[#0b1228] border border-white/10 rounded-[40px] p-8 max-w-[320px] w-full mx-auto shadow-2xl flex flex-col items-center">
                        <div class="text-center w-full mb-6">
                            <h2 class="text-5xl font-light text-white tracking-widest h-14">102</h2>
                            <p class="text-xs text-slate-400 mt-2">Ready to call</p>
                        </div>

                        <div class="grid grid-cols-3 gap-5 w-full">
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-white transition">1</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-white transition">2</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-white transition">3</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-white transition">4</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-white transition">5</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-white transition">6</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-white transition">7</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-white transition">8</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-white transition">9</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-slate-400 transition">*</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-white transition">0</button>
                            <button class="w-[70px] h-[70px] rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-2xl font-light text-slate-400 transition">#</button>
                        </div>

                        <div class="flex gap-6 mt-8">
                            <button class="w-[70px] h-[70px] rounded-full bg-emerald-500 hover:bg-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20 transition">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </button>
                            <button class="w-[70px] h-[70px] rounded-full bg-red-500/20 text-red-500 flex items-center justify-center shadow-lg transition pointer-events-none opacity-50">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.68 13.31a16 16 0 0 0 3.41 2.6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7 2 2 0 0 1 1.72 2v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.42 19.42 0 0 1-3.33-2.67m-2.67-3.34a19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/><line x1="22" x2="2" y1="2" y2="22"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- TTS Section --}}
                <div class="bg-[#0077ff]/10 border border-[#0077ff]/30 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#0077ff]/10 rounded-full blur-[80px] pointer-events-none"></div>
                    
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-2 py-1 rounded bg-[#0077ff] text-white text-[10px] font-black tracking-wider">TTS</span>
                        <h3 class="text-base font-bold text-white">Text-to-Speech Auto Call</h3>
                    </div>
                    <p class="text-xs text-blue-200/70 mb-6">Ketik pesan → sistem otomatis menelepon ekstensi tujuan dan memperdengarkan suara TTS.</p>

                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-1 space-y-2">
                            <label class="block text-[11px] font-semibold text-blue-300">Pesan yang akan diucapkan</label>
                            <textarea rows="4" class="w-full bg-[#070d1f]/80 border border-[#0077ff]/30 rounded-xl px-4 py-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-400" placeholder="Contoh: Halo, ini adalah pesan otomatis dari sistem VetenCall. Mohon segera menghubungi admin."></textarea>
                        </div>
                        
                        <div class="w-full md:w-64 space-y-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-blue-300 mb-1">Ekstensi Tujuan</label>
                                <input type="text" value="102" class="w-full bg-[#070d1f]/80 border border-[#0077ff]/30 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-400 text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-blue-300 mb-1">Bahasa</label>
                                <select class="w-full bg-[#070d1f]/80 border border-[#0077ff]/30 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-400">
                                    <option value="id">Indonesia</option>
                                    <option value="en">English (US)</option>
                                </select>
                            </div>
                            <button class="w-full py-3 bg-[#0077ff] hover:bg-blue-600 text-white text-xs font-bold rounded-xl shadow-lg transition">
                                Call TTS Call
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Debug Log --}}
                <div class="bg-[#050914] border border-white/10 rounded-2xl relative shadow-inner h-48 flex flex-col">
                    <div class="flex items-center justify-between px-4 py-2 border-b border-white/5">
                        <span class="text-[10px] font-mono text-slate-500">SIP Debug Log</span>
                        <button class="text-[10px] bg-white/5 hover:bg-white/10 px-2 py-1 rounded text-slate-400 transition">Clear</button>
                    </div>
                    <div class="p-4 flex-1 overflow-y-auto font-mono text-xs text-slate-500 space-y-1">
                        <p>> System initialized.</p>
                        <p>> Waiting for configuration and microphone permissions...</p>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>