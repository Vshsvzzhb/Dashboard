<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - WebRTC Call History</title>
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

        {{-- MEMANGGIL SIDEBAR TERPUSAT --}}
        @include('layouts.sidebar')

        {{-- 2. MAIN CONTENT AREA --}}
        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            
            <header class="h-20 border-b border-white/10 px-6 md:px-10 flex items-center justify-between bg-white/[0.02] backdrop-blur-xl sticky top-0 z-30">
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">Call History</h1>
                    <p class="text-xs text-slate-300">View and manage your recent WebRTC phone call logs.</p>
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
            </header>

            <div class="p-6 md:p-10 space-y-8 max-w-7xl w-full mx-auto pb-20">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-white">Recent Calls</h2>
                        <p class="text-xs text-slate-300">Total 4 recent call records available.</p>
                    </div>

                    <button class="flex items-center justify-center gap-2 px-5 py-2.5 bg-white/5 hover:bg-white/10 rounded-xl font-semibold text-xs text-white border border-white/10 transition">
                        Clear History
                    </button>
                </div>

                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-white/10 bg-white/[0.02] text-slate-300 uppercase tracking-wider font-semibold">
                                    <th class="p-5">Caller (Ext)</th>
                                    <th class="p-5">Recipient</th>
                                    <th class="p-5">Duration</th>
                                    <th class="p-5">Time</th>
                                    <th class="p-5">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <tr>
                                    <td class="p-5 font-bold text-white">Ext 1001 (SU)</td>
                                    <td class="p-5 text-slate-300">+6281234567890</td>
                                    <td class="p-5 text-slate-300">03:45</td>
                                    <td class="p-5 text-slate-400">Today, 08:30 AM</td>
                                    <td class="p-5">
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-semibold text-[10px]">Answered</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-5 font-bold text-white">Ext 1002 (Agent)</td>
                                    <td class="p-5 text-slate-300">+6287765432101</td>
                                    <td class="p-5 text-slate-300">01:12</td>
                                    <td class="p-5 text-slate-400">Today, 07:15 AM</td>
                                    <td class="p-5">
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-semibold text-[10px]">Answered</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-5 font-bold text-white">Ext 1001 (SU)</td>
                                    <td class="p-5 text-slate-300">+6289988776655</td>
                                    <td class="p-5 text-slate-300">00:00</td>
                                    <td class="p-5 text-slate-400">Yesterday, 04:45 PM</td>
                                    <td class="p-5">
                                        <span class="px-2.5 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 font-semibold text-[10px]">No Answer</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-5 font-bold text-white">Ext 1003 (Support)</td>
                                    <td class="p-5 text-slate-300">+6281122334455</td>
                                    <td class="p-5 text-slate-300">00:00</td>
                                    <td class="p-5 text-slate-400">Yesterday, 10:20 AM</td>
                                    <td class="p-5">
                                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 font-semibold text-[10px]">Busy</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
