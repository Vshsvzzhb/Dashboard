<!DOCTYPE html>
<html lang="id">
<head>
<script>
    function applyTheme() {
        var isDark = localStorage.theme === 'dark';
        var html = document.documentElement;
        var btnIcon = document.getElementById('theme-icon');
        var btnText = document.getElementById('theme-text');
        var iframe = document.getElementById('qr-iframe');

        if (isDark) {
            html.classList.add('dark');
            if (btnIcon) btnIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
            if (btnText) btnText.textContent = 'Dark Mode';
            if (iframe) {
                var url = new URL(iframe.src);
                url.searchParams.set('theme', 'dark');
                iframe.src = url.toString();
            }
        } else {
            html.classList.remove('dark');
            if (btnIcon) btnIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';
            if (btnText) btnText.textContent = 'Light Mode';
            if (iframe) {
                var url = new URL(iframe.src);
                url.searchParams.set('theme', 'light');
                iframe.src = url.toString();
            }
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

    // Instant Security Sentinel for Back Button & BFcache
    @auth
        sessionStorage.setItem('auth_active', '1');
    @else
        sessionStorage.removeItem('auth_active');
        document.documentElement.style.display = 'none';
        window.location.replace('/');
    @endauth

    window.addEventListener('pageshow', function (event) {
        if (event.persisted || !sessionStorage.getItem('auth_active')) {
            document.documentElement.style.display = 'none';
            window.location.replace('/');
        }
    });
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VetenCall')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/VetenAplikasi.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/VetenAplikasi.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/VetenAplikasi.png') }}">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html { 
            font-size: 15px; 
            -webkit-font-smoothing: antialiased; 
            -moz-osx-font-smoothing: grayscale; 
        }
        body { 
            font-family: 'Outfit', sans-serif; 
            overscroll-behavior: none; 
        }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    </style>
    <meta name="view-transition" content="same-origin">
    <script>
        // High-Speed Instant Pre-fetching for silky smooth, instant navigation
        document.addEventListener('DOMContentLoaded', function() {
            var preloaded = new Set();
            function prefetch(url) {
                if (!url || preloaded.has(url) || url.startsWith('#') || url.startsWith('javascript:') || url.includes('/logout') || url.includes('api')) return;
                preloaded.add(url);
                var link = document.createElement('link');
                link.rel = 'prefetch';
                link.href = url;
                document.head.appendChild(link);
            }
            document.addEventListener('mouseover', function(e) {
                var a = e.target.closest('a');
                if (a && a.href && a.origin === window.location.origin) prefetch(a.href);
            }, { passive: true });
            document.addEventListener('touchstart', function(e) {
                var a = e.target.closest('a');
                if (a && a.href && a.origin === window.location.origin) prefetch(a.href);
            }, { passive: true });
        });
    </script>
</head>
<body class="antialiased text-slate-800 dark:text-slate-200">

    <div class="nm-root min-h-screen flex relative overflow-hidden">
        
        @include('layouts.sidebar')

        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            
            {{-- HEADER BAR --}}
            <header class="h-16 sm:h-20 px-4 sm:px-6 md:px-10 flex items-center justify-between sticky top-0 z-30 bg-slate-50/70 dark:bg-[#070d1f]/70 backdrop-blur-md border-b border-black/5 dark:border-white/5">
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5 transition" aria-label="Toggle Navigation">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="flex flex-col min-w-0">
                        <div class="text-[9px] sm:text-[10px] uppercase tracking-widest opacity-50 font-bold mb-0.5">VetenCall Workspace</div>
                        <h1 id="layout-page-title" class="text-xs sm:text-sm font-bold truncate">@yield('page-title', 'Dashboard')</h1>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                    {{-- User Profile --}}
                    <a href="{{ route('profile.edit') }}" title="Pengaturan Profil & Keamanan" class="flex items-center gap-2.5 sm:gap-3 pl-3 sm:pl-4 border-l border-black/5 dark:border-white/5 hover:opacity-80 transition group">
                        <div class="text-right hidden sm:block">
                            <span class="block text-xs font-bold leading-none group-hover:text-[#2f6bfd] transition-colors">{{ auth()->user()->name ?? 'User' }}</span>
                            <span class="text-[10px] text-emerald-400 font-medium">Online</span>
                        </div>
                        <div class="nm-card-sm w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center font-bold text-xs shadow-md group-hover:scale-105 transition-transform"
                             style="background:linear-gradient(135deg,#2f6bfd,#4a7eff);color:#fff;border-radius:10px;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        </div>
                    </a>
                </div>
            </header>

            {{-- CONTENT WRAPPER --}}
            <div class="relative flex-1 flex flex-col min-h-0">
                <div id="dynamic-content-wrapper" class="p-4 sm:p-6 md:p-10 space-y-6 max-w-[1600px] w-full mx-auto pb-20 animate-fade-in-up">
                    @yield('content')
                </div>
            </div>

        </main>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(35px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.42s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        
        /* Force loader text colors dynamically to prevent FOUC / styling flashes */
        html.dark #content-loader-spinner span.loader-text {
            color: #ffffff !important;
        }
        html:not(.dark) #content-loader-spinner > div {
            background: var(--nm-bg-light) !important;
            box-shadow: 6px 6px 20px rgba(0,0,0,0.1) !important;
            border: none !important;
        }
        html:not(.dark) #content-loader-spinner span.loader-text {
            color: #1e3a8a !important;
        }
    </style>

    @stack('modals')
    <script>
        function toggleMobileMenu() {
            var sidebar = document.getElementById('mobile-sidebar');
            var backdrop = document.getElementById('mobile-sidebar-backdrop');
            if (!sidebar || !backdrop) return;
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
