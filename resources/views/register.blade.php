<!DOCTYPE html>
<html lang="en">
<head>
<script>
    function applyTheme() {
        var isDark = localStorage.theme === 'dark';
        var html = document.documentElement;
        var btnIcon = document.getElementById('theme-icon');
        var btnText = document.getElementById('theme-text');

        if (isDark) {
            html.classList.add('dark');
            if (btnIcon) btnIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
            if (btnText) btnText.textContent = 'Dark';
        } else {
            html.classList.remove('dark');
            if (btnIcon) btnIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';
            if (btnText) btnText.textContent = 'Light';
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
    <title>VetenCall - Register</title>
    <link rel="icon" type="image/png" href="{{ asset('images/VetenAplikasi.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/VetenAplikasi.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/VetenAplikasi.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f1f5f9;
        }

        /* Glassmorphism & Natural Shadow Auth Container */
        .auth-container {
            position: relative;
            overflow: hidden;
            border-radius: 2rem;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow: 0 25px 60px -15px rgba(15, 35, 75, 0.12), 
                        0 10px 25px -10px rgba(15, 35, 75, 0.06);
            border: none !important;
            outline: none !important;
        }

        /* Frosted Glass Feature Cards */
        .feature-card {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 1.25rem;
            box-shadow: 0 12px 30px -8px rgba(15, 35, 75, 0.08), 
                        0 4px 10px -2px rgba(15, 35, 75, 0.04);
            border: none !important;
            outline: none !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.65);
            box-shadow: 0 20px 40px -10px rgba(15, 35, 75, 0.14);
        }

        /* ── Dark Mode Theme matching Veten Dashboard Neumorphism ── */
        html.dark body {
            background-color: #070d1f !important;
            color: #f1f5f9 !important;
        }

        html.dark .min-h-screen {
            background: linear-gradient(to bottom right, #070d1f 0%, #0c1638 50%, #12182e 100%) !important;
        }

        html.dark .auth-container {
            background: rgba(18, 24, 46, 0.95) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7), 0 10px 25px -10px rgba(0, 0, 0, 0.5) !important;
        }

        html.dark .feature-card {
            background: rgba(18, 24, 46, 0.55) !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            box-shadow: 0 12px 30px -8px rgba(0, 0, 0, 0.4) !important;
        }

        html.dark .feature-card:hover {
            background: rgba(24, 32, 60, 0.8) !important;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.6) !important;
        }

        html.dark .feature-card img {
            filter: brightness(0) saturate(100%) invert(56%) sepia(90%) saturate(1750%) hue-rotate(196deg) brightness(101%) contrast(99%) !important;
        }

        html.dark .feature-card span {
            color: #cbd5e1 !important;
        }

        html.dark .watermark-logo {
            opacity: 0.10 !important;
        }

        html.dark .auth-heading-main {
            color: #f8fafc !important;
        }

        html.dark .auth-heading-sub {
            color: #60a5fa !important;
        }

        html.dark .auth-text-muted {
            color: #94a3b8 !important;
        }

        html.dark .auth-card-title {
            color: #f8fafc !important;
        }

        html.dark .auth-card-label {
            color: #cbd5e1 !important;
        }

        html.dark input.auth-input-field {
            background: #0d152e !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        html.dark input.auth-input-field::placeholder {
            color: #64748b !important;
        }

        html.dark input.auth-input-field:focus {
            background: #111b38 !important;
            border-color: #2f6bfd !important;
            box-shadow: 0 0 0 3px rgba(47, 107, 253, 0.25) !important;
        }
    </style>
</head>
<body class="bg-[#edf2f7] dark:bg-[#070d1f] text-slate-800 dark:text-slate-200 antialiased selection:bg-blue-500 selection:text-white">

    {{-- Top Utility Bar (Theme Toggle & Back Link) --}}
    <div class="fixed top-4 right-4 z-50 flex items-center gap-2">
        <a href="{{ route('landing') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold backdrop-blur-md transition shadow-xs border border-black/10 dark:border-white/10 bg-white/80 dark:bg-slate-800/80 text-slate-700 dark:text-slate-200 hover:bg-white dark:hover:bg-slate-700">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span class="hidden sm:inline">Landing</span>
        </a>
        <button onclick="toggleTheme()" type="button" aria-label="Ganti Tema" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold backdrop-blur-md transition shadow-xs border border-black/10 dark:border-white/10 bg-white/80 dark:bg-slate-800/80 text-slate-700 dark:text-slate-200 hover:bg-white dark:hover:bg-slate-700 cursor-pointer">
            <span id="theme-icon" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
            </span>
            <span id="theme-text" class="hidden sm:inline">Theme</span>
        </button>
    </div>

    {{-- Main Wrapper --}}
    <div class="min-h-screen bg-gradient-to-br from-[#f0f4f9] via-[#e8eef6] to-[#dbe8f8] flex items-center justify-center p-6 md:p-12 relative overflow-hidden">
        
        {{-- Watermark Logo Veten Jumbo di Kiri Bawah (Blur Dikit) --}}
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" 
             class="watermark-logo absolute -bottom-48 -left-48 w-[850px] max-w-none pointer-events-none select-none z-0"
             style="filter: blur(6px);">

        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center my-auto relative z-10">
            
            {{-- KIRI: BRANDING & 3 FEATURE CARDS --}}
            <div class="lg:col-span-6 space-y-8">
                
                {{-- Logo VetenCall --}}
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall Logo" class="h-10 w-auto object-contain drop-shadow-sm">
                    <span class="text-2xl font-bold tracking-tight text-[#2f6bfd]">VetenCall</span>
                </div>

                {{-- Heading & Subtitle --}}
                <div class="space-y-3">
                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-[1.15]">
                        <span class="text-[#0c1638] auth-heading-main">One Dashboard</span><br>
                        <span class="text-[#1d4ed8] auth-heading-sub">WhatsApp &amp; SMS</span>
                    </h1>
                    <p class="text-slate-600 auth-text-muted text-sm leading-relaxed max-w-sm font-normal">
                        Effortlessly manage, automate, and track your WhatsApp and SMS campaigns from a single, powerful platform.
                    </p>
                </div>

                {{-- 3 Feature Boxes --}}
                <div class="grid grid-cols-3 gap-4 pt-2">
                    
                    <div class="feature-card p-5 flex flex-col items-center text-center space-y-4">
                        <img src="{{ asset('images/Kalender.png') }}" alt="Schedule Campaigns" class="w-16 h-16 object-contain drop-shadow-sm" style="filter: brightness(0) saturate(100%) invert(29%) sepia(93%) saturate(1352%) hue-rotate(199deg) brightness(97%) contrast(96%);">
                        <span class="text-xs font-semibold text-slate-700 leading-tight">Schedule<br>Campaigns</span>
                    </div>

                    <div class="feature-card p-5 flex flex-col items-center text-center space-y-4">
                        <img src="{{ asset('images/Pesan.png') }}" alt="Automate Responses" class="w-16 h-16 object-contain drop-shadow-sm" style="filter: brightness(0) saturate(100%) invert(29%) sepia(93%) saturate(1352%) hue-rotate(199deg) brightness(97%) contrast(96%);">
                        <span class="text-xs font-semibold text-slate-700 leading-tight">Automate<br>Responses</span>
                    </div>

                    <div class="feature-card p-5 flex flex-col items-center text-center space-y-4">
                        <img src="{{ asset('images/Tangan.png') }}" alt="Build Partnerships" class="w-16 h-16 object-contain drop-shadow-sm" style="filter: brightness(0) saturate(100%) invert(29%) sepia(93%) saturate(1352%) hue-rotate(199deg) brightness(97%) contrast(96%);">
                        <span class="text-xs font-semibold text-slate-700 leading-tight">Build<br>Partnerships</span>
                    </div>

                </div>
            </div>

            {{-- KANAN: FORM REGISTER ONLY --}}
            <div class="lg:col-span-6 auth-container p-8 sm:p-10">
                <div class="space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 auth-card-title">Create Account</h2>
                        <p class="text-xs text-slate-500 auth-text-muted mt-1 font-normal">Register to get started</p>
                    </div>

                    @if(isset($errors) && $errors->any())
                        <div class="p-3 rounded-xl bg-red-500/10 text-red-600 text-xs font-medium">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-slate-700 auth-card-label mb-1">Full Name</label>
                            <input type="text" name="name" required placeholder="Enter your full name" value="{{ old('name') }}" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-700 auth-card-label mb-1">Email</label>
                            <input type="email" name="email" required placeholder="Enter your email" value="{{ old('email') }}" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-700 auth-card-label mb-1">No. HP (untuk OTP SMS)</label>
                            <input type="tel" name="phone" required placeholder="+628xx / 08xx" value="{{ old('phone') }}" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-700 auth-card-label mb-1">Password</label>
                            <input type="password" name="password" required placeholder="Create a password" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-700 auth-card-label mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" required placeholder="Confirm your password" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                        </div>

                        <div class="flex items-start gap-2 pt-1">
                            <input type="checkbox" name="terms" required class="mt-0.5 rounded bg-slate-200 dark:bg-slate-700 border-none text-[#2f6bfd]">
                            <span class="text-[10px] text-slate-500 auth-text-muted leading-tight">
                                I agree to the <a href="#" class="text-[#2f6bfd] font-semibold underline">Terms of Service</a> and <a href="#" class="text-[#2f6bfd] font-semibold underline">Privacy Policy</a>
                            </span>
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/25 hover:shadow-blue-600/35 transition cursor-pointer" style="border: none !important;">
                            Register
                        </button>
                    </form>

                    <p class="text-[11px] text-center text-slate-500 auth-text-muted pt-1">
                        Already have an account? <a href="{{ route('login.page') }}" class="text-[#2f6bfd] font-semibold hover:underline">Login here</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
