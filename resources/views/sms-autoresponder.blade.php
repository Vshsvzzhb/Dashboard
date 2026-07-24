<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - SMS Auto Responder</title>
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
                    <h1 class="text-xl font-bold text-white tracking-tight">SMS Auto Responder</h1>
                    <p class="text-xs text-slate-300">Set automatic replies for incoming SMS keywords.</p>
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
                        <h2 class="text-lg font-bold text-white">Auto Responder Rules</h2>
                        <p class="text-xs text-slate-300">Total 3 rules registered.</p>
                    </div>

                    <button onclick="toggleAddModal()" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition">
                        + Add Rule
                    </button>
                </div>

                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-white/10 bg-white/[0.02] text-slate-300 uppercase tracking-wider font-semibold">
                                    <th class="p-5">Keyword</th>
                                    <th class="p-5">Response Message</th>
                                    <th class="p-5">Status</th>
                                    <th class="p-5 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <tr>
                                    <td class="p-5 font-bold text-emerald-400">HELP</td>
                                    <td class="p-5 text-slate-300 max-w-md truncate">Halo! Ada yang bisa kami bantu? Silakan kunjungi website kami di www.vetencall.com.</td>
                                    <td class="p-5">
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-semibold text-[10px]">Active</span>
                                    </td>
                                    <td class="p-5 text-right">
                                        <button class="text-slate-400 hover:text-white mr-3 font-semibold">Edit</button>
                                        <button class="text-red-400 hover:text-red-300 font-semibold">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-5 font-bold text-emerald-400">PROMO</td>
                                    <td class="p-5 text-slate-300 max-w-md truncate">Dapatkan diskon menarik up to 50% untuk transaksi hari ini! Kode: VETEN50.</td>
                                    <td class="p-5">
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-semibold text-[10px]">Active</span>
                                    </td>
                                    <td class="p-5 text-right">
                                        <button class="text-slate-400 hover:text-white mr-3 font-semibold">Edit</button>
                                        <button class="text-red-400 hover:text-red-300 font-semibold">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-5 font-bold text-emerald-400">REG</td>
                                    <td class="p-5 text-slate-300 max-w-md truncate">Terima kasih telah mendaftar. Akun Anda sedang diverifikasi oleh admin.</td>
                                    <td class="p-5">
                                        <span class="px-2.5 py-1 rounded-full bg-white/5 border border-white/10 text-slate-400 font-semibold text-[10px]">Inactive</span>
                                    </td>
                                    <td class="p-5 text-right">
                                        <button class="text-slate-400 hover:text-white mr-3 font-semibold">Edit</button>
                                        <button class="text-red-400 hover:text-red-300 font-semibold">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- MODAL ADD RULE --}}
    <div id="add-modal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-50 flex items-center justify-center hidden">
        <div class="bg-[#0c1638] border border-white/15 rounded-3xl p-8 max-w-md w-full space-y-5 shadow-2xl relative">
            <button onclick="toggleAddModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white font-bold text-sm">✕</button>
            
            <div>
                <h3 class="text-lg font-bold text-white">Add Auto Responder Rule</h3>
                <p class="text-xs text-slate-300 mt-1">Buat aturan balasan otomatis untuk kata kunci SMS tertentu.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Trigger Keyword</label>
                    <input type="text" placeholder="e.g. HELP" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 uppercase">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Response Message</label>
                    <textarea rows="4" placeholder="Tulis balasan otomatis di sini..." class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Status</label>
                    <select class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button onclick="toggleAddModal()" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-xs text-slate-300 font-semibold transition">Cancel</button>
                <button onclick="toggleAddModal()" class="px-5 py-2 rounded-xl bg-[#2f6bfd] hover:bg-blue-600 text-xs text-white font-semibold shadow-lg transition">Save Rule</button>
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
