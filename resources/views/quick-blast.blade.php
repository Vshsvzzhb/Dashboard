<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - Quick Blast</title>
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
                    <h1 class="text-xl font-bold text-white tracking-tight">Quick Blast</h1>
                    <p class="text-xs text-slate-300">Kirim pesan instan langsung ke nomor tujuan tanpa membuat campaign.</p>
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

            <div class="p-6 md:p-10 space-y-8 max-w-4xl w-full mx-auto pb-20">
                
                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                    <div>
                        <h2 class="text-base font-bold text-white">Form Kirim Pesan Instan</h2>
                        <p class="text-xs text-slate-300 mt-0.5">Pilih nomor perangkat pengirim dan masukkan nomor tujuan beserta isi pesan.</p>
                    </div>

                    <form action="#" method="POST" class="space-y-5" onsubmit="event.preventDefault(); alert('Pesan Quick Blast berhasil dikirim!');">
                        @csrf
                        
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-300">Pilih Perangkat WhatsApp</label>
                            <select class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-blue-500">
                                <option value="1">+62 813-8899-2211 (WhatsApp Client #1 - Connected)</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-300">Nomor Tujuan (Phone Number)</label>
                            <input type="text" placeholder="Contoh: 6281234567890" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                            <span class="text-[10px] text-slate-400">Gunakan format kode negara, tanpa tanda plus (+) atau strip (-).</span>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-300">Isi Pesan (Message Body)</label>
                            <textarea rows="5" placeholder="Tulis pesan WhatsApp di sini..." class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500"></textarea>
                        </div>

                        <div class="pt-2 flex items-center justify-end gap-3">
                            <button type="reset" class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-xs text-slate-300 font-semibold transition">Reset</button>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#2f6bfd] hover:bg-blue-600 text-xs text-white font-semibold shadow-lg shadow-blue-600/30 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                Kirim Pesan Sekarang
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>
</body>
</html>