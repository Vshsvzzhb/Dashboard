<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - Phonebook Manager</title>
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
                    <h1 class="text-xl font-bold text-white tracking-tight">Phonebook Manager</h1>
                    <p class="text-xs text-slate-300">Manage your contact groups for WhatsApp & SMS campaigns.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="hidden lg:flex items-center bg-[#0c1638]/60 border border-white/10 rounded-xl px-3 py-2 w-64 text-xs text-slate-300">
                        <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" placeholder="Search phonebook..." class="bg-transparent border-none focus:outline-none w-full text-white placeholder-slate-400 text-xs">
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
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-white">Contact Groups</h2>
                        <p class="text-xs text-slate-300">Total 2 phonebook groups available.</p>
                    </div>

                    <button onclick="toggleAddModal()" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition">
                        + Add Phonebook
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="w-4 h-4 rounded border-white/20 bg-white/5 text-blue-600 focus:ring-0 cursor-pointer">
                                <div class="w-10 h-10 rounded-2xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center text-blue-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                            </div>
                            <button class="text-slate-400 hover:text-white font-bold px-2 py-1">⋮</button>
                        </div>
                        
                        <div class="space-y-1">
                            <h3 class="text-base font-bold text-white">VIP CUST</h3>
                            <p class="text-xs text-emerald-400 font-medium">2 contacts registered</p>
                            <p class="text-[11px] text-slate-400 pt-1">Owner: VetenCall (Me)</p>
                        </div>

                        <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                            <a href="#" class="text-blue-400 hover:underline font-semibold">Manage Contacts →</a>
                            <span class="text-[10px] text-slate-400">Omnichannel Group</span>
                        </div>
                    </div>

                    <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="w-4 h-4 rounded border-white/20 bg-white/5 text-blue-600 focus:ring-0 cursor-pointer">
                                <div class="w-10 h-10 rounded-2xl bg-indigo-500/20 border border-indigo-400/30 flex items-center justify-center text-indigo-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                            </div>
                            <button class="text-slate-400 hover:text-white font-bold px-2 py-1">⋮</button>
                        </div>
                        
                        <div class="space-y-1">
                            <h3 class="text-base font-bold text-white">VIP CUST 1</h3>
                            <p class="text-xs text-emerald-400 font-medium">1 contact registered</p>
                            <p class="text-[11px] text-slate-400 pt-1">Owner: VetenCall (Me)</p>
                        </div>

                        <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                            <a href="#" class="text-blue-400 hover:underline font-semibold">Manage Contacts →</a>
                            <span class="text-[10px] text-slate-400">Omnichannel Group</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- MODAL ADD PHONEBOOK --}}
    <div id="add-modal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-50 flex items-center justify-center hidden">
        <div class="bg-[#0c1638] border border-white/15 rounded-3xl p-8 max-w-md w-full space-y-5 shadow-2xl relative">
            <button onclick="toggleAddModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white font-bold text-sm">✕</button>
            
            <div>
                <h3 class="text-lg font-bold text-white">Add New Phonebook</h3>
                <p class="text-xs text-slate-300 mt-1">Buat grup kontak baru untuk target campaign WhatsApp & SMS.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Group Name</label>
                    <input type="text" placeholder="e.g. Reseller VIP" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Description</label>
                    <textarea rows="3" placeholder="Keterangan grup kontak..." class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button onclick="toggleAddModal()" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-xs text-slate-300 font-semibold transition">Cancel</button>
                <button onclick="toggleAddModal()" class="px-5 py-2 rounded-xl bg-[#2f6bfd] hover:bg-blue-600 text-xs text-white font-semibold shadow-lg transition">Save Group</button>
            </div>
        </div>
    </div>

    <script>
        function toggleAddModal() {
            document.getElementById('add-modal').classList.toggle('hidden');
        }
    </script>
</body>
</html>