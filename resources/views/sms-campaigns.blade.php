<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - SMS Campaigns</title>
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

        @include('layouts.sidebar')

        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            
            <header class="h-20 border-b border-white/10 px-6 md:px-10 flex items-center justify-between bg-white/[0.02] backdrop-blur-xl sticky top-0 z-30">
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">SMS Campaigns</h1>
                    <p class="text-xs text-slate-300">Manage & schedule your SMS messaging broadcasts.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="hidden lg:flex items-center bg-[#0c1638]/60 border border-white/10 rounded-xl px-3 py-2 w-64 text-xs text-slate-300">
                        <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" placeholder="Search SMS campaigns..." class="bg-transparent border-none focus:outline-none w-full text-white placeholder-slate-400 text-xs">
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
                        <h2 class="text-lg font-bold text-white">SMS Broadcast Overview</h2>
                        <p class="text-xs text-slate-300">Monitor API queue and SMS blast history.</p>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <button class="flex items-center gap-2 px-5 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition">
                            + New SMS Campaign
                        </button>
                    </div>
                </div>

                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                    <h3 class="text-base font-bold text-white">Active & Past SMS Broadcasts</h3>

                    <div class="space-y-4">
                        <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 flex flex-col md:flex-row md:items-center justify-between gap-4 text-xs">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-white text-sm">OTP Verification Blast</h4>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Completed</span>
                                </div>
                                <p class="text-slate-400">Target Audience: <span class="text-cyan-400 font-semibold">ALL USERS</span> • 334 Contacts</p>
                            </div>
                            <div class="space-y-1 w-48">
                                <div class="flex justify-between text-[11px] text-slate-300 font-medium">
                                    <span>334 / 334 sent</span>
                                    <span>100%</span>
                                </div>
                                <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                                    <div class="bg-cyan-500 h-full w-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>