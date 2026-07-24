<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - WA Campaigns</title>
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
        
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" 
             class="absolute -bottom-48 -left-48 w-[850px] max-w-none opacity-10 pointer-events-none select-none z-0">

        <div class="absolute -bottom-24 -right-24 w-[600px] h-[600px] bg-blue-600/30 rounded-full blur-[160px] pointer-events-none"></div>

        {{-- MEMANGGIL SIDEBAR TERPUSAT --}}
        @include('layouts.sidebar')

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            
            <header class="h-20 border-b border-white/10 px-6 md:px-10 flex items-center justify-between bg-white/[0.02] backdrop-blur-xl sticky top-0 z-30">
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">Campaigns</h1>
                    <p class="text-xs text-slate-300">Manage & schedule your WhatsApp broadcasts.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="hidden lg:flex items-center bg-[#0c1638]/60 border border-white/10 rounded-xl px-3 py-2 w-64 text-xs text-slate-300">
                        <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" placeholder="Search campaigns..." class="bg-transparent border-none focus:outline-none w-full text-white placeholder-slate-400 text-xs">
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

            <div class="p-6 md:p-10 space-y-8 max-w-7xl w-full mx-auto pb-20">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-white">Broadcast Overview</h2>
                        <p class="text-xs text-slate-300">Monitor active and completed WhatsApp broadcasts.</p>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <label class="flex items-center gap-2 px-4 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white cursor-pointer transition shadow-lg shadow-blue-600/30">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            Import PDF
                            <input type="file" accept=".pdf" class="hidden" onchange="alert('PDF campaigns imported successfully!')">
                        </label>

                        <button onclick="alert('Exporting campaigns list to PDF...')" class="flex items-center gap-2 px-4 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white transition shadow-lg shadow-blue-600/30">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            Export PDF
                        </button>

                        <button class="flex items-center gap-2 px-5 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition">
                            + Create Campaign
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-300 uppercase tracking-wider font-semibold">Total</span>
                            <h3 class="text-3xl font-black text-white mt-1">3</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-500/25 border border-blue-400/30 flex items-center justify-center text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        </div>
                    </div>

                    <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-300 uppercase tracking-wider font-semibold">Running</span>
                            <h3 class="text-3xl font-black text-white mt-1">0</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-cyan-500/25 border border-cyan-400/30 flex items-center justify-center text-cyan-400">
                            <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                        </div>
                    </div>

                    <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-300 uppercase tracking-wider font-semibold">Completed</span>
                            <h3 class="text-3xl font-black text-white mt-1">2</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/25 border border-emerald-400/30 flex items-center justify-center text-emerald-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                    </div>

                    <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-300 uppercase tracking-wider font-semibold">Paused</span>
                            <h3 class="text-3xl font-black text-white mt-1">1</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/25 border border-amber-400/30 flex items-center justify-center text-amber-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                    <h3 class="text-base font-bold text-white">Campaign History & Status</h3>

                    <div class="space-y-4">
                        <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 flex flex-col md:flex-row md:items-center justify-between gap-4 text-xs">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-white text-sm">Gilang Ojol</h4>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">Paused</span>
                                </div>
                                <p class="text-slate-400">Target Audience: <span class="text-blue-400 font-semibold">VIP CUST</span></p>
                            </div>
                            <div class="space-y-1 w-48">
                                <div class="flex justify-between text-[11px] text-slate-300 font-medium">
                                    <span>0 / 2 sent</span>
                                    <span>0%</span>
                                </div>
                                <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full w-[0%]"></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="p-2 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 transition">▶</button>
                                <button class="p-2 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 transition">🗑</button>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 flex flex-col md:flex-row md:items-center justify-between gap-4 text-xs">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-white text-sm">Nabil</h4>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Completed</span>
                                </div>
                                <p class="text-slate-400">Target Audience: <span class="text-blue-400 font-semibold">VIP CUST</span> • Jul 22, 2026 08:30</p>
                            </div>
                            <div class="space-y-1 w-48">
                                <div class="flex justify-between text-[11px] text-slate-300 font-medium">
                                    <span>2 / 2 sent</span>
                                    <span>100%</span>
                                </div>
                                <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full w-full"></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="p-2 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 transition">▶</button>
                                <button class="p-2 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 transition">🗑</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>