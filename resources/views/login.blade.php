<!DOCTYPE html>
<html lang="en">
<head>
<script>
    // Wipe active session sentinel on login
    sessionStorage.removeItem('auth_active');

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
    <title>VetenCall - Login</title>
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

        /* Desktop (>768px) */
        @media (min-width: 768px) {
            .form-container {
                position: absolute;
                top: 0;
                height: 100%;
                transition: all 0.6s ease-in-out;
            }

            .sign-in-container {
                left: 0;
                width: 50%;
                z-index: 2;
            }

            .sign-up-container {
                left: 0;
                width: 50%;
                opacity: 0;
                z-index: 1;
            }

            .auth-container.right-panel-active .sign-in-container {
                transform: translateX(100%);
                opacity: 0;
            }

            .auth-container.right-panel-active .sign-up-container {
                transform: translateX(100%);
                opacity: 1;
                z-index: 5;
                animation: show 0.6s;
            }

            @keyframes show {
                0%, 49.99% { opacity: 0; z-index: 1; }
                50%, 100% { opacity: 1; z-index: 5; }
            }

            .overlay-container {
                position: absolute;
                top: 0;
                left: 50%;
                width: 50%;
                height: 100%;
                overflow: hidden;
                transition: transform 0.6s ease-in-out;
                z-index: 100;
            }

            .auth-container.right-panel-active .overlay-container {
                transform: translateX(-100%);
            }

            .overlay {
                background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%);
                position: relative;
                left: -100%;
                height: 100%;
                width: 200%;
                transform: translateX(0);
                transition: transform 0.6s ease-in-out;
                box-shadow: 0 0 40px rgba(29, 78, 216, 0.25);
            }

            .auth-container.right-panel-active .overlay {
                transform: translateX(50%);
            }

            .overlay-panel {
                position: absolute;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                padding: 0 40px;
                text-align: center;
                top: 0;
                height: 100%;
                width: 50%;
                transform: translateX(0);
                transition: transform 0.6s ease-in-out;
                background: transparent !important;
                border: none !important;
            }

            .overlay-left { transform: translateX(-20%); }
            .auth-container.right-panel-active .overlay-left { transform: translateX(0); }

            .overlay-right { right: 0; transform: translateX(0); }
            .auth-container.right-panel-active .overlay-right { transform: translateX(20%); }
        }

        /* Mobile (<768px) */
        @media (max-width: 767px) {
            .overlay-container { display: none; }
            .form-container { width: 100% !important; position: relative; }
            .sign-up-container { display: none; }
            
            .auth-container.right-panel-active .sign-in-container { display: none; }
            .auth-container.right-panel-active .sign-up-container { display: block !important; opacity: 1; }
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
    <div class="min-h-screen bg-gradient-to-br from-[#f0f4f9] via-[#e8eef6] to-[#dbe8f8] flex items-center justify-center p-4 sm:p-6 md:p-12 relative overflow-hidden">
        
        {{-- Watermark Logo Veten Jumbo di Kiri Bawah (Blur Dikit) --}}
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" 
             class="watermark-logo absolute -bottom-48 -left-48 w-[850px] max-w-none pointer-events-none select-none z-0"
             style="filter: blur(6px);">

        <div class="max-w-7xl w-full grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center my-auto relative z-10">
            
            {{-- KIRI: BRANDING & 3 FEATURE CARDS --}}
            <div class="lg:col-span-5 space-y-6 lg:space-y-8">
                
                {{-- Logo VetenCall --}}
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall Logo" class="h-9 md:h-10 w-auto object-contain drop-shadow-sm">
                    <span class="text-2xl md:text-3xl font-bold tracking-tight text-[#2f6bfd]">VetenCall</span>
                </div>

                {{-- Heading & Subtitle --}}
                <div class="space-y-3">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-[1.15]">
                        <span class="text-[#0c1638] auth-heading-main">One Dashboard</span><br>
                        <span class="text-[#1d4ed8] auth-heading-sub">WhatsApp &amp; SMS</span>
                    </h1>
                    <p class="text-slate-600 auth-text-muted text-xs md:text-sm leading-relaxed max-w-sm font-normal">
                        Effortlessly manage, automate, and track your WhatsApp and SMS campaigns from a single, powerful platform.
                    </p>
                </div>

                {{-- 3 Feature Boxes dengan Frosted Glass Blur over Background Logo --}}
                <div class="grid grid-cols-3 gap-3 sm:gap-4 pt-1">
                    
                    <div class="feature-card p-4 sm:p-5 flex flex-col items-center text-center space-y-3">
                        <img src="{{ asset('images/Kalender.png') }}" alt="Schedule Campaigns" class="w-10 h-10 sm:w-14 sm:h-14 object-contain drop-shadow-sm" style="filter: brightness(0) saturate(100%) invert(29%) sepia(93%) saturate(1352%) hue-rotate(199deg) brightness(97%) contrast(96%);">
                        <span class="text-[10px] sm:text-xs font-semibold text-slate-700 leading-tight">Schedule<br>Campaigns</span>
                    </div>

                    <div class="feature-card p-4 sm:p-5 flex flex-col items-center text-center space-y-3">
                        <img src="{{ asset('images/Pesan.png') }}" alt="Automate Responses" class="w-10 h-10 sm:w-14 sm:h-14 object-contain drop-shadow-sm" style="filter: brightness(0) saturate(100%) invert(29%) sepia(93%) saturate(1352%) hue-rotate(199deg) brightness(97%) contrast(96%);">
                        <span class="text-[10px] sm:text-xs font-semibold text-slate-700 leading-tight">Automate<br>Responses</span>
                    </div>

                    <div class="feature-card p-4 sm:p-5 flex flex-col items-center text-center space-y-3">
                        <img src="{{ asset('images/Tangan.png') }}" alt="Build Partnerships" class="w-10 h-10 sm:w-14 sm:h-14 object-contain drop-shadow-sm" style="filter: brightness(0) saturate(100%) invert(29%) sepia(93%) saturate(1352%) hue-rotate(199deg) brightness(97%) contrast(96%);">
                        <span class="text-[10px] sm:text-xs font-semibold text-slate-700 leading-tight">Build<br>Partnerships</span>
                    </div>

                </div>
            </div>

            {{-- KANAN: AUTH CARD CONTAINER WITH NATURAL SHADOW & GLASSMORPHISM --}}
            <div class="lg:col-span-7">
                <div id="container" class="auth-container min-h-[480px] md:min-h-[540px] {{ (isset($errors) && $errors->any() && (old('name') || old('phone'))) ? 'right-panel-active' : '' }}">
                    
                    {{-- 1. FORM REGISTER --}}
                    <div class="form-container sign-up-container p-6 sm:p-8 md:p-10 flex flex-col justify-center bg-transparent">
                        <form action="{{ route('register') }}" method="POST" class="space-y-3" autocomplete="off">
                            @csrf
                            <div>
                                <h2 class="text-xl sm:text-2xl font-bold text-slate-800 auth-card-title">Create Account</h2>
                                <p class="text-xs text-slate-500 auth-text-muted mt-0.5 font-normal">Register to get started</p>
                            </div>

                            @if (isset($errors) && $errors->any() && (old('name') || old('phone')))
                                <div class="px-3.5 py-2 rounded-xl bg-red-500/10 text-red-600 text-[11px] font-medium">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 auth-card-label mb-1">Full Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Enter your full name" autocomplete="off" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                            </div>

                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 auth-card-label mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('name') ? old('email') : '' }}" required placeholder="Enter your email" autocomplete="new-password" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                            </div>

                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 auth-card-label mb-1">Phone Number (untuk OTP SMS)</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxx / +628xxxxxxxx" autocomplete="off" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                            </div>

                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 auth-card-label mb-1">Password</label>
                                <input type="password" name="password" required placeholder="Create password" autocomplete="new-password" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                            </div>

                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 auth-card-label mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" required placeholder="Confirm password" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                            </div>

                            <button type="submit" class="w-full py-2.5 px-4 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/25 hover:shadow-blue-600/35 transition mt-2 cursor-pointer" style="border: none !important;">
                                Register
                            </button>
                        </form>

                        <p class="md:hidden text-[11px] text-center text-slate-500 auth-text-muted pt-3">
                            Already have an account? 
                            <button type="button" class="btn-toggle text-[#2f6bfd] font-semibold underline cursor-pointer">Login here</button>
                        </p>
                    </div>

                    {{-- 2. FORM LOGIN --}}
                    <div class="form-container sign-in-container p-6 sm:p-8 md:p-10 flex flex-col justify-center space-y-4 bg-transparent">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 auth-card-title">Welcome Back!</h2>
                            <p class="text-xs text-slate-500 auth-text-muted mt-1 font-normal">Login to continue to your account</p>
                        </div>

                        <form action="{{ route('login') }}" method="POST" class="space-y-3.5" autocomplete="off">
                            @csrf

                            {{-- Status message (e.g. password reset success) --}}
                            @if (session('status'))
                                <div class="px-3.5 py-2.5 rounded-xl bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 text-xs font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ session('status') }}</span>
                                </div>
                            @endif

                            {{-- Error message --}}
                            @if (isset($errors) && $errors->any() && !old('phone') && !old('name'))
                                <div class="px-3.5 py-2.5 rounded-xl bg-red-500/10 text-red-600 text-xs font-medium">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div>
                                <label class="block text-xs font-medium text-slate-700 auth-card-label mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Enter your email" autocomplete="new-password" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-700 auth-card-label mb-1">Password</label>
                                <input type="password" name="password" required placeholder="Enter password" autocomplete="new-password" class="auth-input-field w-full px-3.5 py-2.5 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition" style="border: none !important;">
                            </div>

                            <div class="flex items-center justify-between text-[11px]">
                                <label class="flex items-center gap-2 text-slate-600 auth-text-muted cursor-pointer font-normal">
                                    <input type="checkbox" name="remember" class="rounded bg-slate-200 dark:bg-slate-700 border-none text-[#2f6bfd]">
                                    <span>Remember me</span>
                                </label>
                                <a href="{{ route('password.request') }}" class="text-[#2f6bfd] hover:underline font-medium transition">Forgot password?</a>
                            </div>

                            <button type="submit" class="w-full py-2.5 px-4 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/25 hover:shadow-blue-600/35 transition cursor-pointer" style="border: none !important;">
                                Login
                            </button>
                        </form>

                        <p class="md:hidden text-[11px] text-center text-slate-500 auth-text-muted pt-2">
                            Don't have an account? 
                            <button type="button" class="btn-toggle text-[#2f6bfd] font-semibold underline cursor-pointer">Register here</button>
                        </p>
                    </div>

                    {{-- 3. OVERLAY SLIDING PANEL (BLUE GRADIENT WITH WHITE TEXT) --}}
                    <div class="overlay-container">
                        <div class="overlay">
                            
                            {{-- Panel Kiri (Terlihat saat di Mode Register) --}}
                            <div class="overlay-panel overlay-left">
                                <h2 class="text-2xl font-bold text-white">Already Have An Account?</h2>
                                <p class="text-xs text-white/90 mt-2 mb-6 max-w-[200px] mx-auto leading-relaxed font-normal">Login with your personal info to stay connected with us</p>
                                <button type="button" class="btn-toggle px-6 py-2.5 rounded-xl border border-white/40 bg-white/15 hover:bg-white/25 text-white font-semibold text-xs backdrop-blur-md transition shadow-md cursor-pointer">
                                    Login Here
                                </button>
                            </div>

                            {{-- Panel Kanan (Terlihat saat di Mode Login) --}}
                            <div class="overlay-panel overlay-right">
                                <h2 class="text-2xl font-bold text-white">Hello, Friend!</h2>
                                <p class="text-xs text-white/90 mt-2 mb-6 max-w-[200px] mx-auto leading-relaxed font-normal">Enter your personal details and start your journey with VetenCall</p>
                                <button type="button" class="btn-toggle px-6 py-2.5 rounded-xl border border-white/40 bg-white/15 hover:bg-white/25 text-white font-semibold text-xs backdrop-blur-md transition shadow-md cursor-pointer">
                                    Register Here
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Script Trigger Slider & Mobile Toggle --}}
    <script>
        const container = document.getElementById('container');
        const toggleButtons = document.querySelectorAll('.btn-toggle');

        toggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                container.classList.toggle("right-panel-active");
            });
        });
    </script>
</body>
</html>
