<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - Blast History</title>
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
                    <h1 class="text-xl font-bold text-white tracking-tight">Blast History</h1>
                    <p class="text-xs text-slate-300">Complete log of all WhatsApp and SMS messages sent.</p>
                </div>
                
                <div class="flex items-center gap-4">
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
                
                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                    <h3 class="text-base font-bold text-white">Recent Logs</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-300">
                            <thead class="text-[10px] uppercase bg-white/5 text-slate-400 rounded-xl">
                                <tr>
                                    <th class="p-3.5">Type</th>
                                    <th class="p-3.5">Recipient</th>
                                    <th class="p-3.5">Message Preview</th>
                                    <th class="p-3.5">Status</th>
                                    <th class="p-3.5">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <tr>
                                    <td class="p-3.5"><span class="px-2 py-1 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-bold">WhatsApp</span></td>
                                    <td class="p-3.5 font-mono text-white">+62 812-3456-7890</td>
                                    <td class="p-3.5 truncate max-w-xs">Halo, terima kasih telah menjadi pelanggan VIP kami...</td>
                                    <td class="p-3.5"><span class="text-emerald-400 font-medium">Delivered</span></td>
                                    <td class="p-3.5 text-slate-400">Jul 23, 2026 10:15</td>
                                </tr>
                                <tr>
                                    <td class="p-3.5"><span class="px-2 py-1 rounded bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 text-[10px] font-bold">SMS</span></td>
                                    <td class="p-3.5 font-mono text-white">+62 857-1122-3344</td>
                                    <td class="p-3.5 truncate max-w-xs">Kode OTP Anda adalah 849201. Berlaku 5 menit.</td>
                                    <td class="p-3.5"><span class="text-emerald-400 font-medium">Sent</span></td>
                                    <td class="p-3.5 text-slate-400">Jul 23, 2026 09:40</td>
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