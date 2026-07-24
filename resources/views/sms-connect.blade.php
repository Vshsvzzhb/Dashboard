<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - Connect SMS</title>
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
                    <h1 class="text-xl font-bold text-white tracking-tight">Connect SMS Gateway</h1>
                    <p class="text-xs text-slate-300">Connect your Android device or third-party SMS API gateway.</p>
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

            <div class="p-6 md:p-10 space-y-8 max-w-4xl w-full mx-auto pb-20">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-6">
                        <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl space-y-4">
                            <h2 class="text-lg font-bold text-white">SMS Gateway Configuration</h2>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1">Gateway Provider</label>
                                    <select class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                                        <option value="android">Android SMS Gateway (Local App)</option>
                                        <option value="twilio">Twilio API</option>
                                        <option value="zenziva">Zenziva SMS Indonesia</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1">Gateway Server IP / URL</label>
                                    <input type="text" value="192.168.1.100:8080" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1">API Key / Token</label>
                                    <input type="password" value="••••••••••••••••••••••••••••••••" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-2">
                                <button class="px-5 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg transition">Save Configuration</button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl space-y-4 text-center">
                            <h2 class="text-sm font-bold text-white">Connection Status</h2>
                            
                            <div class="flex flex-col items-center justify-center p-4">
                                <div class="w-16 h-16 rounded-full bg-red-500/20 border border-red-500/30 flex items-center justify-center text-red-400 mb-3 animate-pulse">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" x2="12" y1="2" y2="12"/></svg>
                                </div>
                                <span class="text-xs font-bold text-red-400">Disconnected</span>
                                <span class="text-[10px] text-slate-400 mt-1">Last checked: Just now</span>
                            </div>

                            <button class="w-full px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-xs text-slate-300 font-semibold transition">Test Connection</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
