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

        @include('layouts.sidebar')

        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            
            <header class="h-20 border-b border-white/10 px-6 md:px-10 flex items-center justify-between bg-white/[0.02] backdrop-blur-xl sticky top-0 z-30">
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">Quick Blast</h1>
                    <p class="text-xs text-slate-300">Kirim pesan instan langsung ke nomor tujuan tanpa membuat campaign.</p>
                </div>
                <div class="flex items-center gap-3 pl-3 border-l border-white/10">
                    <div class="text-right hidden sm:block">
                        <span class="block text-xs font-bold text-white leading-none">Super User</span>
                        <span class="text-[10px] text-emerald-400 font-medium">Online</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-600/40 border border-blue-400/30 flex items-center justify-center font-bold text-xs text-white shadow-md">SU</div>
                </div>
            </header>

            <div class="p-6 md:p-10 space-y-6 max-w-4xl w-full mx-auto pb-20">

                {{-- Notifikasi Sukses --}}
                @if(session('success'))
                <div id="alert-success" class="flex items-start gap-3 px-5 py-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-sm">
                    <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="font-semibold">Berhasil!</p>
                        <p class="text-xs text-emerald-400 mt-0.5">{{ session('success') }}</p>
                    </div>
                    <button onclick="document.getElementById('alert-success').remove()" class="ml-auto text-emerald-400 hover:text-white">✕</button>
                </div>
                @endif

                {{-- Notifikasi Error --}}
                @if(session('error'))
                <div id="alert-error" class="flex items-start gap-3 px-5 py-4 rounded-2xl bg-red-500/15 border border-red-500/30 text-red-300 text-sm">
                    <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="font-semibold">Gagal Mengirim</p>
                        <p class="text-xs text-red-400 mt-0.5">{{ session('error') }}</p>
                    </div>
                    <button onclick="document.getElementById('alert-error').remove()" class="ml-auto text-red-400 hover:text-white">✕</button>
                </div>
                @endif

                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                    <div>
                        <h2 class="text-base font-bold text-white">Form Kirim Pesan Instan</h2>
                        <p class="text-xs text-slate-300 mt-0.5">Pilih nomor perangkat pengirim dan masukkan nomor tujuan beserta isi pesan.</p>
                    </div>

                    <form action="{{ route('quick.blast.send') }}" method="POST" class="space-y-5" id="quickBlastForm">
                        @csrf

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-300">Pilih Perangkat WhatsApp</label>

                            @php
                                $connectedDevices = array_filter($waDevices ?? [], fn($d) => $d['connected'] ?? false);
                            @endphp

                            @if(empty($waDevices))
                                <div class="flex items-center gap-2 px-4 py-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                                    WA Engine tidak berjalan. Jalankan <code class="font-mono bg-black/30 px-1 rounded">node index.js</code> di folder wa-engine.
                                </div>
                            @elseif(empty($connectedDevices))
                                <div class="flex items-center gap-2 px-4 py-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                                    Tidak ada perangkat yang terhubung. <a href="{{ route('wa.connect') }}" target="_blank" class="underline hover:text-white">Scan QR dulu</a>.
                                </div>
                            @endif

                            <select name="session" class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-blue-500 {{ empty($connectedDevices) ? 'opacity-50' : '' }}" {{ empty($connectedDevices) ? 'disabled' : '' }}>
                                @forelse($connectedDevices as $device)
                                    <option value="{{ $device['id'] }}">
                                        {{ $device['phone'] ? '+'. $device['phone'] : $device['id'] }} — {{ $device['id'] }} ✅ Connected
                                    </option>
                                @empty
                                    <option value="">— Tidak ada perangkat terhubung —</option>
                                @endforelse
                            </select>
                        </div>


                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-300">Nomor Tujuan (Phone Number)</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                   placeholder="Contoh: 6281234567890"
                                   class="w-full bg-[#070d1f] border {{ $errors->has('phone') ? 'border-red-500/60' : 'border-white/10' }} rounded-xl px-4 py-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                            <span class="text-[10px] text-slate-400">Gunakan format kode negara, tanpa tanda plus (+) atau strip (-). Contoh: 628123456789</span>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-300">Isi Pesan (Message Body)</label>
                            <textarea rows="5" name="message" required
                                      placeholder="Tulis pesan WhatsApp di sini..."
                                      class="w-full bg-[#070d1f] border {{ $errors->has('message') ? 'border-red-500/60' : 'border-white/10' }} rounded-xl px-4 py-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">{{ old('message') }}</textarea>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-slate-400">Gunakan *teks* untuk bold, _teks_ untuk italic.</span>
                                <span class="text-[10px] text-slate-500" id="charCount">0 karakter</span>
                            </div>
                        </div>

                        <div class="pt-2 flex items-center justify-end gap-3">
                            <button type="reset" onclick="document.getElementById('charCount').textContent='0 karakter'"
                                    class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-xs text-slate-300 font-semibold transition">
                                Reset
                            </button>
                            <button type="submit" id="submitBtn"
                                    class="px-6 py-2.5 rounded-xl bg-[#2f6bfd] hover:bg-blue-600 text-xs text-white font-semibold shadow-lg shadow-blue-600/30 transition flex items-center gap-2">
                                <svg class="w-4 h-4" id="sendIcon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                <svg class="w-4 h-4 hidden animate-spin" id="loadingIcon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                                <span id="btnText">Kirim Pesan Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

    <script>
        const textarea = document.querySelector('textarea[name="message"]');
        const charCount = document.getElementById('charCount');
        textarea.addEventListener('input', () => {
            charCount.textContent = textarea.value.length + ' karakter';
        });
        if (textarea.value) charCount.textContent = textarea.value.length + ' karakter';

        document.getElementById('quickBlastForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            document.getElementById('sendIcon').classList.add('hidden');
            document.getElementById('loadingIcon').classList.remove('hidden');
            document.getElementById('btnText').textContent = 'Mengirim...';
        });
    </script>
</body>
</html>