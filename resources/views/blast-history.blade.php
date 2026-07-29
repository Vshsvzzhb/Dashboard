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
                    <p class="text-xs text-slate-300">Log lengkap semua pesan WhatsApp yang dikirim via Quick Blast.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('quick.blast') }}" class="px-4 py-2 rounded-xl bg-[#2f6bfd] hover:bg-blue-600 text-xs text-white font-semibold transition flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Quick Blast
                    </a>
                    <div class="flex items-center gap-3 pl-3 border-l border-white/10">
                        <div class="text-right hidden sm:block">
                            <span class="block text-xs font-bold text-white leading-none">Super User</span>
                            <span class="text-[10px] text-emerald-400 font-medium">Online</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-600/40 border border-blue-400/30 flex items-center justify-center font-bold text-xs text-white shadow-md">SU</div>
                    </div>
                </div>
            </header>

            <div class="p-6 md:p-10 space-y-6 max-w-7xl w-full mx-auto pb-20">

                {{-- Summary Cards --}}
                @php
                    $total   = $blasts->total();
                    $sent    = \App\Models\Blast::where('status', 'done')->count();
                    $failed  = \App\Models\Blast::where('status', 'failed')->count();
                @endphp
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white/[0.05] border border-white/10 rounded-2xl p-5">
                        <p class="text-[10px] uppercase text-slate-400 font-semibold tracking-wider mb-1">Total Blast</p>
                        <p class="text-2xl font-bold text-white">{{ $total }}</p>
                    </div>
                    <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-5">
                        <p class="text-[10px] uppercase text-emerald-400 font-semibold tracking-wider mb-1">Terkirim</p>
                        <p class="text-2xl font-bold text-emerald-300">{{ $sent }}</p>
                    </div>
                    <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-5">
                        <p class="text-[10px] uppercase text-red-400 font-semibold tracking-wider mb-1">Gagal</p>
                        <p class="text-2xl font-bold text-red-300">{{ $failed }}</p>
                    </div>
                </div>

                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-bold text-white">Recent Logs</h3>
                        <span class="text-xs text-slate-400">{{ $blasts->total() }} total pesan</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-300">
                            <thead class="text-[10px] uppercase bg-white/5 text-slate-400">
                                <tr>
                                    <th class="p-3.5">Type</th>
                                    <th class="p-3.5">Recipient</th>
                                    <th class="p-3.5">Message Preview</th>
                                    <th class="p-3.5">Session</th>
                                    <th class="p-3.5">Status</th>
                                    <th class="p-3.5">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($blasts as $blast)
                                @php
                                    $recipients = is_array($blast->recipients) ? $blast->recipients : json_decode($blast->recipients ?? '[]', true);
                                    $recipient  = $recipients[0] ?? '-';
                                @endphp
                                <tr class="hover:bg-white/[0.02] transition">
                                    <td class="p-3.5">
                                        @if($blast->type === 'sms')
                                            <span class="px-2 py-1 rounded bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 text-[10px] font-bold">SMS</span>
                                        @else
                                            <span class="px-2 py-1 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-bold">WhatsApp</span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 font-mono text-white">+{{ $recipient }}</td>
                                    <td class="p-3.5 truncate max-w-xs text-slate-300">{{ Str::limit($blast->message, 60) }}</td>
                                    <td class="p-3.5 text-slate-400 text-[10px]">{{ $blast->session ?? 'default' }}</td>
                                    <td class="p-3.5">
                                        @if($blast->status === 'done')
                                            <span class="text-emerald-400 font-semibold">✅ Terkirim</span>
                                        @elseif($blast->status === 'failed')
                                            <span class="text-red-400 font-semibold">❌ Gagal</span>
                                        @elseif($blast->status === 'sending')
                                            <span class="text-yellow-400 font-semibold">⏳ Mengirim</span>
                                        @else
                                            <span class="text-slate-400 font-semibold">🕐 Antrian</span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-slate-400 whitespace-nowrap">{{ $blast->created_at?->format('M d, Y H:i') ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="p-10 text-center text-slate-500">
                                        <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                                        <p class="text-sm font-medium">Belum ada riwayat blast</p>
                                        <p class="text-xs mt-1">Kirim pesan pertama kamu via <a href="{{ route('quick.blast') }}" class="text-blue-400 underline">Quick Blast</a></p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($blasts->hasPages())
                    <div class="pt-2 flex justify-end">
                        {{ $blasts->links('pagination::simple-tailwind') }}
                    </div>
                    @endif
                </div>

            </div>
        </main>
    </div>
</body>
</html>