@extends('layouts.app')

@section('title', 'VetenCall - TTS Voice Campaigns')
@section('page-title', 'TTS Voice Campaigns')

@section('content')
    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-xs px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight" style="letter-spacing:-0.02em;">TTS Voice Broadcast Overview</h1>
            <p class="text-xs mt-1 opacity-50">Jadwalkan dan broadcast panggilan suara otomatis (Text-to-Speech) ke daftar kontak.</p>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap">
            <button type="button" onclick="testCallSoftphone('9999')" id="btn_quick_test_call" class="nm-btn px-4 py-2.5 rounded-2xl font-bold text-xs transition flex items-center gap-2 cursor-pointer text-emerald-600 dark:text-emerald-400 hover:scale-105 border border-emerald-500/30 shadow-sm" title="Uji coba panggilan suara instan ke softphone 9999">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <span>Test Call ke Softphone (9999)</span>
            </button>
            <button onclick="toggleCampaignModal()" class="nm-btn-brand px-5 py-2.5 rounded-2xl font-bold text-xs shadow-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14m-7-7h14"/></svg>
                + Buat TTS Auto-Call
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="nm-card p-4 flex flex-col justify-between">
            <span class="text-[11px] font-semibold opacity-60">Total Campaigns</span>
            <span class="text-2xl font-bold mt-2 text-slate-800 dark:text-white">{{ $campaigns->count() }}</span>
        </div>
        <div class="nm-card p-4 flex flex-col justify-between">
            <span class="text-[11px] font-semibold text-cyan-500">Sedang Berjalan</span>
            <span class="text-2xl font-bold mt-2 text-cyan-600 dark:text-cyan-400">{{ $campaigns->where('status', 'running')->count() }}</span>
        </div>
        <div class="nm-card p-4 flex flex-col justify-between">
            <span class="text-[11px] font-semibold text-emerald-500">Selesai (100%)</span>
            <span class="text-2xl font-bold mt-2 text-emerald-600 dark:text-emerald-400">{{ $campaigns->where('status', 'completed')->count() }}</span>
        </div>
        <div class="nm-card p-4 flex flex-col justify-between">
            <span class="text-[11px] font-semibold text-blue-500">Total Panggilan</span>
            <span class="text-2xl font-bold mt-2 text-blue-600 dark:text-blue-400">{{ $campaigns->sum('sent_count') }}</span>
        </div>
    </div>

    {{-- Campaigns List Card --}}
    <div class="nm-card p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-[#2f6bfd]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Daftar TTS Voice Broadcast
            </h3>
            <div class="flex items-center bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 rounded-xl px-4 py-2 w-64 text-xs">
                <svg class="w-4 h-4 opacity-50 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" id="searchInput" placeholder="Cari TTS campaign..." class="bg-transparent border-none focus:outline-none w-full placeholder-slate-400 text-xs" style="background: transparent !important; color: inherit !important; border: none !important; box-shadow: none !important;">
            </div>
        </div>

        <div class="space-y-4">
            @forelse($campaigns as $c)
            @php
                $pct = $c->total_count > 0 ? round($c->sent_count / $c->total_count * 100) : 0;
                $statusColor = match($c->status) {
                    'completed' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/25',
                    'running'   => 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border-cyan-500/25',
                    'paused'    => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/25',
                    default     => 'bg-slate-500/10 text-slate-600 dark:text-slate-400 border-slate-500/25',
                };
                $barGradient = match($c->status) {
                    'completed' => 'bg-gradient-to-r from-emerald-600 to-teal-400 dark:from-emerald-500 dark:to-teal-400 shadow-sm shadow-emerald-500/30',
                    'running'   => 'bg-gradient-to-r from-blue-600 to-cyan-400 dark:from-blue-500 dark:to-cyan-400 shadow-sm shadow-cyan-500/30',
                    'paused'    => 'bg-gradient-to-r from-amber-500 to-yellow-400 shadow-sm shadow-amber-500/30',
                    default     => 'bg-slate-500',
                };
                $badgeColor = match($c->status) {
                    'completed' => 'text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 border-emerald-500/25',
                    'running'   => 'text-cyan-600 dark:text-cyan-400 bg-cyan-500/10 border-cyan-500/25',
                    'paused'    => 'text-amber-600 dark:text-amber-400 bg-amber-500/10 border-amber-500/25',
                    default     => 'text-slate-600 dark:text-slate-400 bg-slate-500/10 border-slate-500/25',
                };
            @endphp
            <div class="campaign-card nm-card-sm p-4 flex flex-col md:flex-row md:items-center justify-between gap-4 text-xs" data-name="{{ strtolower($c->name) }}">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-lg bg-blue-500/10 text-[#2f6bfd] font-bold text-[10px] flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" x2="12" y1="19" y2="22"/></svg>
                            TTS
                        </span>
                        <h4 class="font-bold text-sm">{{ $c->name }}</h4>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $statusColor }} uppercase tracking-wide">{{ ucfirst($c->status) }}</span>
                    </div>
                    <p class="opacity-60 text-[11px]">
                        Target: <span class="text-blue-500 dark:text-cyan-400 font-semibold">{{ $c->phonebook->name ?? 'Semua Kontak' }}</span>
                        • Bahasa: <span class="uppercase font-mono">{{ $c->session ?: 'ID' }}</span>
                        • {{ $c->total_count }} Nomor
                        @if($c->scheduled_at)
                            • <span class="text-amber-500">Jadwal: {{ $c->scheduled_at->format('d M Y H:i') }}</span>
                        @else
                            • {{ $c->created_at->format('d M Y H:i') }}
                        @endif
                    </p>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate max-w-md italic">"{{ $c->message }}"</p>
                </div>
                <div class="w-full md:w-60 shrink-0">
                    <div class="flex items-center justify-between text-xs font-semibold mb-2">
                        <span class="text-slate-500 dark:text-slate-400 text-[11px] font-medium flex items-center gap-1.5">
                            <span class="font-bold text-slate-800 dark:text-slate-100">{{ $c->sent_count }}</span>
                            <span class="opacity-40">/</span>
                            <span class="text-slate-600 dark:text-slate-300 font-medium">{{ $c->total_count }}</span>
                            <span class="text-[10px] opacity-60 font-normal">terpanggil</span>
                        </span>
                        <span class="text-[11px] font-extrabold px-2.5 py-0.5 rounded-full border {{ $badgeColor }}">{{ $pct }}%</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200/90 dark:bg-black/40 rounded-full p-[2px] border border-black/5 dark:border-white/5 shadow-inner overflow-hidden flex items-center">
                        <div class="{{ $barGradient }} h-full rounded-full transition-all duration-500 ease-out" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 flex-wrap">
                    <button type="button" onclick="playCampaignMessage('{{ addslashes($c->message) }}', '{{ $c->session ?: 'id' }}')" title="Dengarkan Suara Pesan Ini" class="bg-blue-500/10 hover:bg-blue-500/20 text-blue-500 px-2.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
                        <span>Dengar</span>
                    </button>

                    <form method="POST" action="{{ route('tts.campaigns.toggle', $c->id) }}" onsubmit="return confirm('Ubah status campaign ini?');">
                        @csrf @method('PATCH')
                        @if($c->status === 'paused')
                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Start</button>
                        @elseif($c->status === 'running')
                            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Pause</button>
                        @endif
                    </form>

                    <form method="POST" action="{{ route('tts.campaigns.resend', $c->id) }}" onsubmit="return confirm('Panggil ulang semua kontak pada campaign ini?');">
                        @csrf
                        <button type="submit" title="Panggil Ulang" class="bg-blue-500/10 hover:bg-blue-500/20 text-blue-500 px-3 py-1.5 rounded-lg text-xs font-bold transition">Panggil Ulang</button>
                    </form>
                    
                    <form method="POST" action="{{ route('tts.campaigns.destroy', $c->id) }}" onsubmit="return confirm('Hapus campaign TTS ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500/10 hover:bg-red-500/20 text-red-500 px-3 py-1.5 rounded-lg text-xs font-bold transition">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center opacity-50 text-sm py-10">
                Belum ada TTS Voice Broadcast. Klik "+ Buat TTS Auto-Call" untuk mulai.
            </div>
            @endforelse
        </div>
    </div>
@endsection

@push('modals')
    {{-- Modal Create TTS Campaign --}}
    <div id="campaignModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="toggleCampaignModal()"></div>
        <div class="relative nm-modal p-6 sm:p-8 w-full max-w-xl space-y-5 z-10 shadow-2xl rounded-3xl">
            <div class="flex items-center justify-between border-b border-black/10 dark:border-white/10 pb-4">
                <div class="flex items-center gap-2">
                    <span class="p-2 rounded-xl bg-blue-500/10 text-[#2f6bfd] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" x2="12" y1="19" y2="22"/></svg>
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-slate-800 dark:text-white">Buat TTS Voice Broadcast Terjadwal</h3>
                        <p class="text-[11px] opacity-60">Sistem otomatis menelepon target dan mengucapkan pesan suara.</p>
                    </div>
                </div>
                <button type="button" onclick="toggleCampaignModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('tts.campaigns.store') }}" method="POST" onsubmit="return confirmTtsSubmit(event)" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="block text-xs font-semibold">Nama Campaign</label>
                    <input type="text" name="name" required placeholder="Contoh: Pengingat Tagihan Bulanan" class="w-full bg-white dark:bg-[#070d1f] border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-[#2f6bfd]">
                </div>

                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-semibold">Target Phonebook (Kontak / Ekstensi)</label>
                        <a href="{{ route('tts.phonebook') }}" target="_blank" class="text-[11px] text-[#2f6bfd] dark:text-blue-400 hover:underline font-semibold flex items-center gap-1">
                            + Kelola Phonebook VoIP
                        </a>
                    </div>
                    <select name="phonebook_id" id="phonebookSelect" required class="w-full bg-white dark:bg-[#070d1f] border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-[#2f6bfd]">
                        <option value="">-- Pilih Phonebook --</option>
                        @foreach($phonebooks as $pb)
                            <option value="{{ $pb->id }}">{{ $pb->name }} ({{ $pb->contacts_count }} kontak) {{ $pb->type === 'tts' ? '• [VoIP/TTS]' : '• [' . strtoupper($pb->type) . ']' }}</option>
                        @endforeach
                    </select>
                </div>

                @if(isset($templates) && $templates->isNotEmpty())
                <div class="space-y-1">
                    <label class="block text-xs font-semibold">Gunakan Template Pesan (Opsional)</label>
                    <select id="templateSelect" onchange="applyTemplate(this)" class="w-full bg-white dark:bg-[#070d1f] border border-black/10 dark:border-white/10 rounded-xl px-4 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-[#2f6bfd]">
                        <option value="">-- Pilih Template Tersimpan --</option>
                        @foreach($templates as $tpl)
                            <option value="{{ $tpl->message }}">{{ $tpl->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-semibold">Teks Pesan Suara</label>
                        <div class="flex flex-wrap gap-1 text-[10px]">
                            <button type="button" onclick="insertTag('{nama}')" class="px-2 py-0.5 rounded bg-blue-500/10 text-blue-500 font-mono hover:bg-blue-500/20 transition">+ {nama}</button>
                            <button type="button" onclick="insertTag('{nomor}')" class="px-2 py-0.5 rounded bg-blue-500/10 text-blue-500 font-mono hover:bg-blue-500/20 transition">+ {nomor}</button>
                            <button type="button" onclick="insertTag('[uang] ')" class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-500 font-mono hover:bg-emerald-500/20 transition" title="Contoh: [uang] 50000 -> lima puluh ribu rupiah">+ [uang]</button>
                            <button type="button" onclick="insertTag('[digit] ')" class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-500 font-mono hover:bg-amber-500/20 transition" title="Contoh: [digit] 1234 -> satu dua tiga empat">+ [digit]</button>
                            <button type="button" onclick="insertTag('[terbilang] ')" class="px-2 py-0.5 rounded bg-purple-500/10 text-purple-500 font-mono hover:bg-purple-500/20 transition">+ [terbilang]</button>
                        </div>
                    </div>
                    <textarea name="message" id="messageInput" required rows="4" placeholder="Halo {nama}, ini adalah panggilan suara otomatis dari sistem..." class="w-full bg-white dark:bg-[#070d1f] border border-black/10 dark:border-white/10 rounded-xl p-3 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-[#2f6bfd] resize-none"></textarea>
                    
                    <div class="flex items-center gap-2 pt-1 flex-wrap">
                        <button type="button" onclick="previewCampaignAudio()" id="btn_modal_preview" class="nm-btn px-3 py-1.5 rounded-xl text-xs font-bold text-blue-600 dark:text-blue-400 flex items-center gap-1.5 transition cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
                            <span>Dengarkan Preview Suara</span>
                        </button>
                        <button type="button" onclick="testModalCallSoftphone()" id="btn_modal_test_call" class="nm-btn px-3 py-1.5 rounded-xl text-xs font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5 transition cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <span>Uji Panggil ke Softphone (9999)</span>
                        </button>
                    </div>
                    <div id="modal_audio_container" class="hidden pt-1">
                        <audio id="modal_audio_player" controls class="w-full h-8 rounded-lg"></audio>
                    </div>
                    <div id="modal_test_toast" class="hidden p-2 rounded-xl text-xs font-semibold"></div>
                    <p class="text-[10px] opacity-60">Gunakan tag {nama} atau {nomor} untuk personalisasi, dan [uang] atau [digit] untuk ucapan angka natural.</p>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold">Bahasa / Aksen Suara (Voice Locale)</label>
                    <select name="lang" class="w-full bg-white dark:bg-[#070d1f] border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-[#2f6bfd]">
                        <option value="id" selected>Bahasa Indonesia (id-ID) — Suara Natural</option>
                        <option value="en">English (en-US) — Natural Accent</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold">Jadwalkan Pengiriman (Opsional)</label>
                    <input type="datetime-local" name="scheduled_at" class="w-full bg-white dark:bg-[#070d1f] border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-[#2f6bfd]">
                    <p class="text-[10px] opacity-60 mt-1">Kosongkan jika ingin broadcast suara langsung dikirimkan sekarang juga.</p>
                </div>

                <div class="pt-3 flex items-center justify-end gap-3 border-t border-black/10 dark:border-white/10">
                    <button type="button" onclick="toggleCampaignModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-black/5 dark:hover:bg-white/5 transition">
                        Batal
                    </button>
                    <button type="submit" class="nm-btn-brand px-6 py-2.5 rounded-xl text-xs font-bold shadow-lg transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                        Jalankan TTS Broadcast
                    </button>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
<script>
    function confirmTtsSubmit(e) {
        const pbSelect = document.getElementById('phonebookSelect');
        const pbName = pbSelect?.options[pbSelect.selectedIndex]?.text || 'Phonebook Target';
        if (!confirm(`PERINGATAN BROADCAST SUARA (TTS):\n\nTarget: ${pbName}\nSistem akan menelepon nomor target secara otomatis.\nApakah Anda yakin ingin memulai broadcast suara ini?`)) {
            e.preventDefault();
            return false;
        }
        return true;
    }

    function toggleCampaignModal() {
        const modal = document.getElementById('campaignModal');
        if (modal) modal.classList.toggle('hidden');
    }

    function applyTemplate(select) {
        if (!select || !select.value) return;
        const input = document.getElementById('messageInput');
        if (input) {
            input.value = select.value;
            input.focus();
        }
    }

    function insertTag(tag) {
        const input = document.getElementById('messageInput');
        if (!input) return;
        const start = input.selectionStart;
        const end = input.selectionEnd;
        const text = input.value;
        input.value = text.substring(0, start) + tag + text.substring(end);
        input.focus();
        input.selectionStart = input.selectionEnd = start + tag.length;
    }

    // Audio Preview and Softphone Call Testing
    let globalAudioPlayer = null;

    function playCampaignMessage(msg, lang) {
        if (!msg) return;
        const url = '/tts-preview?text=' + encodeURIComponent(msg) + '&lang=' + encodeURIComponent(lang || 'id') + '&t=' + Date.now();
        if (!globalAudioPlayer) {
            globalAudioPlayer = new Audio();
        }
        globalAudioPlayer.src = url;
        globalAudioPlayer.play().catch(e => {
            alert('Silakan klik di halaman terlebih dahulu agar browser mengizinkan audio.');
        });
    }

    async function previewCampaignAudio() {
        const msgInput = document.getElementById('messageInput');
        const langSelect = document.querySelector('select[name="lang"]');
        const container = document.getElementById('modal_audio_container');
        const player = document.getElementById('modal_audio_player');
        const btn = document.getElementById('btn_modal_preview');

        if (!msgInput || !msgInput.value.trim()) {
            showModalToast('Ketik teks pesan suara terlebih dahulu!', 'error');
            return;
        }

        const origBtn = btn ? btn.innerHTML : '';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span>Memuat audio...</span>';
        }

        try {
            const text = msgInput.value.trim().replace(/{nama}|{name}/g, 'Bapak Ibu').replace(/{nomor}|{phone}/g, '08123456789');
            const lang = langSelect ? langSelect.value : 'id';
            const url = '/tts-preview?text=' + encodeURIComponent(text) + '&lang=' + encodeURIComponent(lang) + '&t=' + Date.now();

            if (player) {
                player.src = url;
                if (container) container.classList.remove('hidden');
                await player.play();
                showModalToast('Memutar suara...', 'success');
            }
        } catch(e) {
            showModalToast('Gagal memutar audio: ' + e.message, 'error');
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = origBtn;
            }
        }
    }

    async function testModalCallSoftphone() {
        const msgInput = document.getElementById('messageInput');
        const langSelect = document.querySelector('select[name="lang"]');
        const btn = document.getElementById('btn_modal_test_call');

        let text = msgInput ? msgInput.value.trim() : '';
        if (!text) {
            text = 'Halo, ini adalah pengujian suara otomatis ke softphone Anda.';
        }
        text = text.replace(/{nama}|{name}/g, 'Bapak Ibu').replace(/{nomor}|{phone}/g, '08123456789');
        const lang = langSelect ? langSelect.value : 'id';

        const orig = btn ? btn.innerHTML : '';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span>Memanggil 9999...</span>';
        }

        try {
            const res = await fetch('/tts-call', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ text, target: '9999', lang })
            });
            const d = await res.json();
            if (d.success) {
                showModalToast('Panggilan terkirim ke 9999! Buka tab Softphone untuk mendengarkan.', 'success');
            } else {
                showModalToast('Gagal: ' + (d.error || 'Server error'), 'error');
            }
        } catch(e) {
            showModalToast('Error: ' + e.message, 'error');
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = orig;
            }
        }
    }

    async function testCallSoftphone(target) {
        const btn = document.getElementById('btn_quick_test_call');
        const orig = btn ? btn.innerHTML : '';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span>Memanggil 9999...</span>';
        }
        try {
            const res = await fetch('/tts-call', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    text: 'Halo! Ini adalah uji coba broadcast suara text to speech, sistem softphone berfungsi dengan baik.',
                    target: target || '9999',
                    lang: 'id'
                })
            });
            const d = await res.json();
            if (d.success) {
                alert('Panggilan TTS berhasil dikirim ke ekstensi ' + target + '!\n\nBuka tab Softphone (9999) — panggilan akan otomatis dijawab dan dibacakan suaranya.');
            } else {
                alert('Gagal: ' + (d.error || 'Server error'));
            }
        } catch(e) {
            alert('Error: ' + e.message);
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = orig;
            }
        }
    }

    function showModalToast(msg, type) {
        const toast = document.getElementById('modal_test_toast');
        if (!toast) return;
        toast.textContent = msg;
        toast.className = 'p-2.5 rounded-xl text-xs font-semibold ' + 
            (type === 'success' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'bg-red-500/10 text-red-500 border border-red-500/20');
        toast.classList.remove('hidden');
        setTimeout(() => { toast.classList.add('hidden'); }, 5000);
    }

    // Search filter & Auto Polling
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const val = e.target.value.toLowerCase().trim();
                document.querySelectorAll('.campaign-card').forEach(card => {
                    const name = card.getAttribute('data-name') || '';
                    card.style.display = name.includes(val) ? 'flex' : 'none';
                });
            });
        }

        // Cek apakah ada campaign yang berstatus running/sedang berjalan
        const runningCards = document.querySelectorAll('.campaign-card [class*="text-cyan-600"], .campaign-card [class*="border-cyan-500"]');
        if (runningCards.length > 0) {
            setTimeout(() => {
                window.location.reload();
            }, 6000);
        }
    });
</script>
@endpush
