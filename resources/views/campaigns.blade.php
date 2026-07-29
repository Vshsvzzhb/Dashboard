<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - WA Campaigns</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }::-webkit-scrollbar{width:5px;height:5px}::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:10px}</style>
</head>
<body class="bg-[#0c1638] text-white antialiased selection:bg-blue-500 selection:text-white">

    <div class="min-h-screen bg-gradient-to-br from-[#0c1638] via-[#0d1844] to-[#1a2f8a] flex relative overflow-hidden">
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" class="absolute -bottom-48 -left-48 w-[850px] max-w-none opacity-10 pointer-events-none select-none z-0">
        <div class="absolute -bottom-24 -right-24 w-[600px] h-[600px] bg-blue-600/30 rounded-full blur-[160px] pointer-events-none"></div>

        @include('layouts.sidebar')

        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            <header class="h-20 border-b border-white/10 px-6 md:px-10 flex items-center justify-between bg-white/[0.02] backdrop-blur-xl sticky top-0 z-30">
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">Campaigns</h1>
                    <p class="text-xs text-slate-300">Manage & schedule your WhatsApp broadcasts.</p>
                </div>
                <div class="flex items-center gap-3 pl-3 border-l border-white/10">
                    <div class="text-right hidden sm:block">
                        <span class="block text-xs font-bold text-white leading-none">Super User</span>
                        <span class="text-[10px] text-emerald-400 font-medium">Online</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-600/40 border border-blue-400/30 flex items-center justify-center font-bold text-xs text-white shadow-md">SU</div>
                </div>
            </header>

            <div class="p-6 md:p-10 space-y-6 max-w-7xl w-full mx-auto pb-20">

                {{-- Alerts --}}
                @if(session('success'))
                <div class="px-5 py-3 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs">✅ {{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="px-5 py-3 rounded-2xl bg-red-500/15 border border-red-500/30 text-red-300 text-xs">❌ {{ session('error') }}</div>
                @endif
                @if($errors->any())
                <div class="px-5 py-3 rounded-2xl bg-red-500/15 border border-red-500/30 text-red-300 text-xs">❌ {{ $errors->first() }}</div>
                @endif

                {{-- Overview + Create Button --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-white">Broadcast Overview</h2>
                        <p class="text-xs text-slate-300">Monitor active and completed WhatsApp broadcasts.</p>
                    </div>
                    <button onclick="document.getElementById('create-modal').classList.remove('hidden')"
                            class="flex items-center gap-2 px-5 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition">
                        + Create Campaign
                    </button>
                </div>

                {{-- Stats --}}
                @php
                    $total     = $campaigns->count();
                    $running   = $campaigns->where('status', 'running')->count();
                    $completed = $campaigns->where('status', 'completed')->count();
                    $paused    = $campaigns->where('status', 'paused')->count();
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach([
                        ['TOTAL', $total, 'blue', '<svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>'],
                        ['RUNNING', $running, 'cyan', '<svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>'],
                        ['COMPLETED', $completed, 'emerald', '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'],
                        ['PAUSED', $paused, 'amber', '<svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>']
                    ] as [$label, $val, $color, $icon])
                    <div class="bg-white/[0.05] border border-white/10 rounded-2xl p-5 space-y-2">
                        <p class="text-[10px] uppercase text-slate-400 font-semibold tracking-wider">{{ $label }}</p>
                        <div class="flex items-end justify-between">
                            <p class="text-3xl font-bold text-white">{{ $val }}</p>
                            <span class="text-2xl flex items-center justify-center">{!! $icon !!}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Campaign List --}}
                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-4">
                    <h3 class="text-base font-bold text-white">Campaign History & Status</h3>

                    @forelse($campaigns as $campaign)
                    @php
                        $progress = $campaign->total_count > 0
                            ? round(($campaign->sent_count / $campaign->total_count) * 100)
                            : 0;
                        $statusColor = match($campaign->status) {
                            'running'   => 'text-cyan-400 bg-cyan-500/15 border-cyan-500/30',
                            'completed' => 'text-emerald-400 bg-emerald-500/15 border-emerald-500/30',
                            'failed'    => 'text-red-400 bg-red-500/15 border-red-500/30',
                            default     => 'text-amber-400 bg-amber-500/15 border-amber-500/30',
                        };
                        $progressColor = match($campaign->status) {
                            'running'   => 'bg-cyan-500',
                            'completed' => 'bg-emerald-500',
                            'failed'    => 'bg-red-500',
                            default     => 'bg-amber-500',
                        };
                    @endphp
                    <div class="group relative flex flex-col md:flex-row md:items-center justify-between gap-5 p-5 bg-white/[0.02] hover:bg-white/[0.04] border border-white/10 rounded-2xl transition duration-300">
                        {{-- Info --}}
                        <div class="flex-1 min-w-0 space-y-2">
                            <div class="flex items-center gap-3">
                                <h4 class="text-sm font-bold text-white truncate max-w-[200px] sm:max-w-xs">{{ $campaign->name ?: 'Unnamed Campaign' }}</h4>
                                <span class="px-2.5 py-0.5 rounded-full border text-[10px] font-bold {{ $statusColor }} uppercase tracking-wide">
                                    {{ $campaign->status }}
                                </span>
                            </div>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-slate-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span class="text-blue-400 font-semibold">{{ $campaign->target_audience ?? 'No Target' }}</span>
                                </span>
                                @if($campaign->scheduled_at)
                                <span class="flex items-center gap-1">
                                    <span class="text-slate-600">•</span>
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $campaign->scheduled_at->format('d M Y, H:i') }}
                                </span>
                                @endif
                                @if($campaign->session)
                                <span class="flex items-center gap-1">
                                    <span class="text-slate-600">•</span>
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    {{ $campaign->session }}
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- Progress --}}
                        <div class="w-full md:w-56 shrink-0">
                            <div class="flex items-center justify-between text-[10px] text-slate-400 mb-1.5 font-medium">
                                <span>{{ $campaign->sent_count }} / {{ $campaign->total_count }} sent</span>
                                <span class="text-white">{{ $progress }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full {{ $progressColor }} rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 shrink-0 md:ml-4">
                            @if(in_array($campaign->status, ['paused', 'running']))
                            <form method="POST" action="{{ route('campaigns.toggle', $campaign) }}" class="m-0 p-0">
                                @csrf @method('PATCH')
                                <button type="submit" title="{{ $campaign->status === 'paused' ? 'Resume' : 'Pause' }}"
                                        class="w-9 h-9 rounded-xl flex items-center justify-center bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 transition-colors">
                                    @if($campaign->status === 'paused')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @endif
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}" class="m-0 p-0" onsubmit="return confirm('Hapus campaign \'{{ $campaign->name }}\'?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-xl flex items-center justify-center bg-red-500/10 hover:bg-red-500/20 text-red-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="py-14 text-center text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-600/50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014-8.81c-2.28 2.87-5.405 5.06-8.97 6.13M21.03 9A18.913 18.913 0 0019 12a18.913 18.913 0 002.03 3m-2.25-3h.008v.008H18.78V12z"></path></svg>
                        <p class="text-sm font-medium">Belum ada campaign</p>
                        <p class="text-xs mt-1">Klik <strong>+ Create Campaign</strong> untuk menjadwalkan broadcast pertama</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </main>
    </div>

    {{-- MODAL CREATE CAMPAIGN --}}
    <div id="create-modal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-50 flex items-center justify-center hidden p-4">
        <div class="bg-[#0c1638] border border-white/15 rounded-3xl p-8 max-w-lg w-full space-y-5 shadow-2xl relative max-h-[90vh] overflow-y-auto">
            <button onclick="document.getElementById('create-modal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-white font-bold text-sm">✕</button>
            <div>
                <h3 class="text-lg font-bold text-white">Buat Campaign Baru</h3>
                <p class="text-xs text-slate-300 mt-1">Jadwalkan pengiriman pesan ke seluruh kontak dalam phonebook.</p>
            </div>

            <form method="POST" action="{{ route('campaigns.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Campaign <span class="text-red-400">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Promo Ramadan 2026"
                           class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Perangkat WhatsApp <span class="text-red-400">*</span></label>
                    @if(empty($waDevices))
                    <div class="px-4 py-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs">
                        ⚠ WA Engine tidak terhubung. Pastikan wa-engine jalan dan ada device connected.
                    </div>
                    @endif
                    <select name="session" required class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 mt-1">
                        @forelse($waDevices as $d)
                            <option value="{{ $d['id'] }}">📱 {{ $d['phone'] ? '+'.$d['phone'] : $d['id'] }} — {{ $d['id'] }}</option>
                        @empty
                            <option value="">— Tidak ada perangkat —</option>
                        @endforelse
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Target Phonebook <span class="text-red-400">*</span></label>
                    <select name="phonebook_id" required class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        <option value="">— Pilih phonebook —</option>
                        @foreach($phonebooks as $pb)
                        <option value="{{ $pb->id }}">{{ $pb->name }} ({{ $pb->contacts_count }} kontak)</option>
                        @endforeach
                    </select>
                    @if($phonebooks->isEmpty())
                    <p class="text-[10px] text-amber-400 mt-1">⚠ Belum ada phonebook. <a href="{{ route('phonebook') }}" class="underline">Buat dulu</a>.</p>
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Jadwal Kirim <span class="text-red-400">*</span></label>
                    <input type="datetime-local" name="scheduled_at" required
                           min="{{ now()->addMinutes(1)->format('Y-m-d\TH:i') }}"
                           class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                    <p class="text-[10px] text-slate-400 mt-1">Minimal 1 menit dari sekarang. Scheduler berjalan tiap menit.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Isi Pesan <span class="text-red-400">*</span></label>
                    <textarea name="message" rows="4" required placeholder="Halo {nama}, pesan promosi kami untuk Anda..."
                              class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500"></textarea>
                    <p class="text-[10px] text-slate-400 mt-1">Gunakan *bold* dan _italic_ untuk format WhatsApp.</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')"
                            class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-xs text-slate-300 font-semibold transition">Cancel</button>
                    <button type="submit" class="flex items-center gap-2 px-5 py-2 rounded-xl bg-[#2f6bfd] hover:bg-blue-600 text-xs text-white font-semibold shadow-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M21 5.05l-4.5 4.5M16.5 5.05l4.5 4.5"></path></svg>
                        Jadwalkan Campaign
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($errors->any())
    <script>document.getElementById('create-modal').classList.remove('hidden');</script>
    @endif
</body>
</html>