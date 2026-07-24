<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - Gateway Settings</title>
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
        
        {{-- Watermark Logo Veten di Kiri Bawah --}}
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" 
             class="absolute -bottom-48 -left-48 w-[850px] max-w-none opacity-10 pointer-events-none select-none z-0">

        {{-- Glow Effect --}}
        <div class="absolute -bottom-24 -right-24 w-[600px] h-[600px] bg-blue-600/30 rounded-full blur-[160px] pointer-events-none"></div>

        {{-- 1. SIDEBAR NAVIGATION --}}
        @include('layouts.sidebar')

        {{-- 2. MAIN CONTENT AREA --}}
        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            
            {{-- Top Navbar --}}
            <header class="h-20 border-b border-white/10 px-6 md:px-10 flex items-center justify-between bg-white/[0.02] backdrop-blur-xl sticky top-0 z-30">
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">Gateway Settings</h1>
                    <p class="text-xs text-slate-300">Configure WhatsApp multi-device instances & SMS API credentials.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="hidden lg:flex items-center bg-[#0c1638]/60 border border-white/10 rounded-xl px-3 py-2 w-64 text-xs text-slate-300 focus-within:border-blue-400 transition">
                        <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" placeholder="Search settings..." class="bg-transparent border-none focus:outline-none w-full text-white placeholder-slate-400 text-xs">
                    </div>

                    <div class="flex items-center gap-3 pl-3 border-l border-white/10">
                        <div class="text-right hidden sm:block">
                            <span class="block text-xs font-bold text-white leading-none">Super User</span>
                            <span class="text-[10px] text-emerald-400 font-medium">Online</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-600/40 border border-blue-400/30 flex items-center justify-center font-bold text-xs text-white shadow-md">
                            SU
                        </div>
                    </div>
                </div>
            </header>

            {{-- Settings Body Content --}}
            <div class="p-6 md:p-10 space-y-8 max-w-5xl w-full mx-auto pb-20">
                
                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <div>
                            <h3 class="text-base font-bold text-white flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span> WhatsApp Instance Manager
                            </h3>
                            <p class="text-xs text-slate-300 mt-0.5">Kelola sesi perangkat dan webhook WhatsApp.</p>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[11px] font-semibold">
                            Connected (+62 813-8899-2211)
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Device Name / Session ID</label>
                            <input type="text" value="VetenCall-Primary-Instance" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Webhook URL Endpoint</label>
                            <input type="text" value="https://vetencall.duckdns.org/api/wa/webhook" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 font-mono">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <button onclick="alert('Session synced successfully!')" class="px-4 py-2 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/40 text-emerald-300 text-xs font-semibold transition">
                            Test Connection
                        </button>
                        <button class="px-5 py-2.5 rounded-xl bg-[#2f6bfd] hover:bg-blue-600 text-xs text-white font-semibold shadow-lg transition">
                            Save WA Settings
                        </button>
                    </div>
                </div>

                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <div>
                            <h3 class="text-base font-bold text-white flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-cyan-400"></span> SMS Gateway API Configuration
                            </h3>
                            <p class="text-xs text-slate-300 mt-0.5">Pengaturan kredensial provider SMS Bulk.</p>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[11px] font-semibold">
                            Provider Active
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">SMS Gateway Provider</label>
                            <select class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                                <option>Twilio Bulk SMS API</option>
                                <option selected>VetenCall Custom SMS Gateway Engine</option>
                                <option>Zenvia / Infobip Provider</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1.5">API Token / Secret Key</label>
                                <input type="password" value="vtn_live_9837482910384756" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 font-mono">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1.5">Sender ID / Masking Name</label>
                                <input type="text" value="VETENCALL" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 font-mono uppercase">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <button onclick="alert('SMS API tested successfully!')" class="px-4 py-2 rounded-xl bg-cyan-500/20 hover:bg-cyan-500/30 border border-cyan-500/40 text-cyan-300 text-xs font-semibold transition">
                            Verify API Token
                        </button>
                        <button class="px-5 py-2.5 rounded-xl bg-[#2f6bfd] hover:bg-blue-600 text-xs text-white font-semibold shadow-lg transition">
                            Save SMS Settings
                        </button>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>