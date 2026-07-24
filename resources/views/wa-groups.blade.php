<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - WA Groups</title>
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
                    <h1 class="text-xl font-bold text-white tracking-tight">WA Groups</h1>
                    <p class="text-xs text-slate-300">Manage your synced WhatsApp Groups.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="hidden lg:flex items-center bg-[#0c1638]/60 border border-white/10 rounded-xl px-3 py-2 w-64 text-xs text-slate-300">
                        <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" placeholder="Search groups..." class="bg-transparent border-none focus:outline-none w-full text-white placeholder-slate-400 text-xs">
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
                        <h2 class="text-lg font-bold text-white">Synced Groups List</h2>
                        <p class="text-xs text-slate-300">Extract contacts directly from your connected WhatsApp groups.</p>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <label class="flex items-center gap-2 px-4 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white cursor-pointer transition shadow-lg shadow-blue-600/30">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            Import PDF
                            <input type="file" accept=".pdf" class="hidden" onchange="alert('PDF groups imported successfully!')">
                        </label>

                        <button onclick="alert('Exporting WA groups to PDF...')" class="flex items-center gap-2 px-4 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white transition shadow-lg shadow-blue-600/30">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            Export PDF
                        </button>

                        <button onclick="alert('Syncing WhatsApp groups...')" class="flex items-center gap-2 px-5 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.66-5.66"/></svg>
                            Sync WA Groups
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-bold">Synced</span>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-base font-bold text-white">Badminton Smkzie</h3>
                            <p class="text-xs text-slate-400 font-mono">ID: 120363481017878795@g.us</p>
                        </div>
                        <button class="w-full py-2.5 rounded-xl bg-blue-600/20 hover:bg-blue-600/30 border border-blue-400/30 text-blue-300 font-semibold text-xs transition">
                            Extract Contacts
                        </button>
                    </div>

                    <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-bold">Synced</span>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-base font-bold text-white">Panitia reuni Akbar SMP alianah 2025</h3>
                            <p class="text-xs text-slate-400 font-mono">ID: 120363315784024533@g.us</p>
                        </div>
                        <button class="w-full py-2.5 rounded-xl bg-blue-600/20 hover:bg-blue-600/30 border border-blue-400/30 text-blue-300 font-semibold text-xs transition">
                            Extract Contacts
                        </button>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>