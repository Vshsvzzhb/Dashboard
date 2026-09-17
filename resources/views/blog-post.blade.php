<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <script>
    function applyTheme() {
        var isDark = localStorage.theme === 'dark';
        var html = document.documentElement;
        var btnIcons = document.querySelectorAll('.theme-toggle-icon');
        if (isDark) {
            html.classList.add('dark');
            btnIcons.forEach(function(icon) {
                icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
            });
        } else {
            html.classList.remove('dark');
            btnIcons.forEach(function(icon) {
                icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';
            });
        }
    }
    function toggleTheme() {
        var isCurrentlyDark = document.documentElement.classList.contains('dark') || localStorage.theme === 'dark';
        localStorage.setItem('theme', isCurrentlyDark ? 'light' : 'dark');
        applyTheme();
    }
    if (localStorage.theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    document.addEventListener('DOMContentLoaded', applyTheme);
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post['title'] }} — VetenCall Blog</title>
    <meta name="description" content="{{ $post['excerpt'] }}">
    <link rel="icon" type="image/png" href="{{ asset('images/VetenAplikasi.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif !important; background-color: #f8fafc !important; color: #0F172A; }
        .prose-content h2 { font-size: 1.25rem; font-weight: 800; color: #0F172A; margin-top: 2rem; margin-bottom: 0.75rem; }
        .prose-content p  { font-size: 0.9375rem; color: #475569; line-height: 1.8; margin-bottom: 1.25rem; }
        .prose-content .tip {
            background: #f0f9ff;
            border-left: 3px solid #1E3A8A;
            padding: 1rem 1.25rem;
            border-radius: 0 0.75rem 0.75rem 0;
            font-size: 0.875rem;
            color: #1e3a8a;
            font-weight: 600;
            margin-top: 1.5rem;
        }
        .prose-content .lead {
            font-size: 1.0625rem;
            color: #334155;
            font-weight: 500;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }
        .navbar-capsule {
            background: rgba(255,255,255,0.9) !important;
            backdrop-filter: blur(20px) !important;
            box-shadow: 0 4px 20px -2px rgba(15,23,42,0.06) !important;
            border-radius: 9999px !important;
        }

        /* Dark Mode */
        html.dark body { background-color: #070d1f !important; color: #f1f5f9 !important; }
        html.dark .prose-content h2 { color: #f8fafc !important; }
        html.dark .prose-content p { color: #94a3b8 !important; }
        html.dark .prose-content .tip { background: rgba(30, 58, 138, 0.25) !important; border-left-color: #3b82f6 !important; color: #93c5fd !important; }
        html.dark .prose-content .lead { color: #cbd5e1 !important; }
        html.dark .navbar-capsule { background: rgba(18, 24, 46, 0.9) !important; border: 1px solid rgba(255, 255, 255, 0.08) !important; box-shadow: 0 4px 25px -2px rgba(0,0,0,0.6) !important; }
        html.dark .navbar-capsule a:not(.btn-dashboard-pill), html.dark .navbar-capsule span:not(.text-\[\#1E3A8A\]) { color: #f8fafc !important; }
        html.dark .bg-white { background-color: #12182e !important; border-color: rgba(255, 255, 255, 0.06) !important; }
        html.dark .text-\[\#0F172A\] { color: #f8fafc !important; }
        html.dark .text-slate-600, html.dark .text-slate-700 { color: #94a3b8 !important; }
        html.dark .border-slate-100 { border-color: rgba(255, 255, 255, 0.06) !important; }
        html.dark .theme-toggle-btn { background: rgba(255, 255, 255, 0.08) !important; border: 1px solid rgba(255, 255, 255, 0.1) !important; color: #f8fafc !important; }
        html.dark .theme-toggle-btn:hover { background: rgba(255, 255, 255, 0.15) !important; }
    </style>
</head>
<body class="antialiased">

    {{-- Sticky Navbar --}}
    <header class="sticky top-4 sm:top-5 z-50 px-4 sm:px-6 max-w-7xl mx-auto mb-8" style="background:transparent !important; box-shadow:none !important; border:none !important;">
        <div class="navbar-capsule px-5 sm:px-8 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}#home" class="flex items-center gap-3 group shrink-0">
                <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall" class="h-8 w-auto object-contain drop-shadow-sm group-hover:scale-105 transition-transform">
                <div class="leading-tight">
                    <span class="text-xl font-black text-[#0F172A] tracking-tight block">VetenCall</span>
                    <span class="text-[9px] uppercase tracking-widest text-[#1E3A8A] font-extrabold block">WA Gateway &amp; VoIP</span>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-8 text-[13px] font-semibold text-slate-700">
                <a href="{{ url('/') }}#fitur" class="hover:text-blue-700 transition-colors">Fitur Gateway</a>
                <a href="{{ url('/') }}#blog" class="hover:text-blue-700 transition-colors">Panduan</a>
                <a href="{{ url('/') }}#faq" class="hover:text-blue-700 transition-colors">FAQ</a>
            </div>
            <div class="hidden sm:flex items-center gap-2.5">
                <button onclick="toggleTheme()" type="button" aria-label="Ganti Tema" class="theme-toggle-btn flex items-center justify-center w-8 h-8 rounded-full transition-all border border-black/10 text-slate-700 hover:bg-slate-100 cursor-pointer">
                    <span class="theme-toggle-icon flex items-center">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                    </span>
                </button>
                <a href="{{ route('login.page') }}" class="btn-dashboard-pill px-5 py-2 text-xs font-bold rounded-full bg-[#1E3A8A] text-white hover:bg-blue-700 transition-colors shadow-sm">
                    Masuk Dashboard
                </a>
            </div>
        </div>
    </header>

    {{-- Article --}}
    <main class="max-w-3xl mx-auto px-6 pb-24">

        {{-- Back link --}}
        <a href="{{ url('/') }}#blog" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#1E3A8A] transition-colors mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Panduan
        </a>

        {{-- Hero image --}}
        <div class="w-full aspect-[16/7] rounded-2xl overflow-hidden mb-8 shadow-sm bg-slate-100">
            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover">
        </div>

        {{-- Meta --}}
        <div class="flex items-center gap-3 mb-4">
            <span class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-bold text-[#1E3A8A]">{{ $post['tag'] }}</span>
            <span class="text-slate-400 text-xs">•</span>
            <span class="text-slate-500 text-xs font-medium">{{ $post['date'] }}</span>
            <span class="text-slate-400 text-xs">•</span>
            <span class="text-slate-500 text-xs font-medium">{{ $post['read_time'] }} baca</span>
        </div>

        {{-- Title --}}
        <h1 class="text-2xl sm:text-3xl font-black text-[#0F172A] tracking-tight leading-snug mb-4">
            {{ $post['title'] }}
        </h1>

        <p class="text-sm text-slate-500 mb-8 font-medium">Oleh <strong class="text-[#1E3A8A]">Tim VetenCall</strong></p>

        <hr class="border-slate-100 mb-8">

        {{-- Article body --}}
        <div class="prose-content">
            @foreach($post['content'] as $block)
                @if($block['type'] === 'lead')
                    <p class="lead">{{ $block['text'] }}</p>
                @elseif($block['type'] === 'h2')
                    <h2>{{ $block['text'] }}</h2>
                @elseif($block['type'] === 'p')
                    <p>{{ $block['text'] }}</p>
                @elseif($block['type'] === 'tip')
                    <div class="tip">{{ $block['text'] }}</div>
                @endif
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="mt-12 p-8 bg-white rounded-2xl shadow-sm text-center">
            <h3 class="text-lg font-black text-[#0F172A] mb-2">Siap mencoba VetenCall?</h3>
            <p class="text-sm text-slate-500 mb-5 font-normal">Daftar gratis dan mulai otomatisasi komunikasi bisnis Anda sekarang.</p>
            <a href="{{ route('login.page') }}" class="inline-flex items-center gap-2 px-7 py-3 rounded-xl bg-[#1E3A8A] text-white text-sm font-bold hover:bg-blue-700 transition-colors shadow-sm">
                Coba Gratis Sekarang
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        {{-- Related posts --}}
        @if(count($related) > 0)
        <div class="mt-14">
            <h3 class="text-base font-black text-[#0F172A] mb-6">Artikel Lainnya</h3>
            <div class="grid grid-cols-1 sm:grid-cols-{{ min(count($related), 2) }} gap-5">
                @foreach($related as $rel)
                <a href="{{ url('/blog/' . $rel['slug']) }}" class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="aspect-[16/9] overflow-hidden bg-slate-100">
                        <img src="{{ $rel['image'] }}" alt="{{ $rel['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[10px] font-bold text-[#1E3A8A]">{{ $rel['tag'] }}</span>
                            <span class="text-slate-400 text-[10px]">{{ $rel['date'] }}</span>
                        </div>
                        <h4 class="text-sm font-bold text-[#0F172A] leading-snug group-hover:text-[#1E3A8A] transition-colors">{{ $rel['title'] }}</h4>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </main>

    {{-- Simple footer --}}
    <footer class="w-full bg-white py-6 mt-8" style="border:none !important; border-top:none !important; box-shadow: 0 -1px 0 0 rgba(226,232,240,0.6);">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <p>&copy; 2026 <strong class="text-[#0F172A]">VetenCall</strong> &bull; PT. Vetencode Pradani Abadi</p>
            <a href="{{ url('/') }}#blog" class="font-bold text-[#1E3A8A] hover:underline">Lihat Semua Artikel</a>
        </div>
    </footer>

</body>
</html>
