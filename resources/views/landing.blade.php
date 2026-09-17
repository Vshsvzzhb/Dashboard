<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <script>
        function applyTheme() {
            var isDark = localStorage.theme === 'dark';
            var html = document.documentElement;
            var btnIcons = document.querySelectorAll('.theme-toggle-icon');
            var btnTexts = document.querySelectorAll('.theme-toggle-text');

            if (isDark) {
                html.classList.add('dark');
                btnIcons.forEach(function(icon) {
                    icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
                });
                btnTexts.forEach(function(txt) {
                    txt.textContent = 'Dark Mode';
                });
            } else {
                html.classList.remove('dark');
                btnIcons.forEach(function(icon) {
                    icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';
                });
                btnTexts.forEach(function(txt) {
                    txt.textContent = 'Light Mode';
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
    <title>VetenCall - WhatsApp Gateway SaaS, SMS Multi-Provider & Cloud VoIP</title>
    <meta name="description" content="Platform WhatsApp Gateway API Indonesia, WhatsApp Blast massal anti-banned, SMS Gateway multi-provider, dan Cloud VoIP WebRTC terpadu untuk bisnis.">
    <link rel="icon" type="image/png" href="{{ asset('images/VetenAplikasi.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/VetenAplikasi.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/VetenAplikasi.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --card-bg:          #ffffff;
            --navy-dark:        #0F172A;
            --navy-primary:     #1E3A8A;
            --navy-accent:      #2563EB;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            overflow-x: hidden !important;
            max-width: 100vw !important;
            width: 100% !important;
        }

        body {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
            background-color: #f8fafc !important;
            background-image: 
                radial-gradient(at 15% 10%, rgba(219, 234, 254, 0.7) 0px, transparent 45%),
                radial-gradient(at 85% 15%, rgba(224, 231, 255, 0.5) 0px, transparent 40%),
                radial-gradient(at 50% 55%, rgba(241, 245, 249, 0.8) 0px, transparent 50%),
                radial-gradient(at 20% 85%, rgba(219, 234, 254, 0.45) 0px, transparent 45%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            color: var(--navy-dark);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ── 1. Modern Clean Card ── */
        .nm-card {
            background: #ffffff !important;
            border-radius: 18px !important;
            box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.05), 0 1px 2px -1px rgba(15, 23, 42, 0.03) !important;
            border: none !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }
        .nm-card:hover {
            transform: translateY(-2px) !important;
            border: none !important;
            box-shadow: 0 8px 20px -3px rgba(15, 23, 42, 0.07), 0 3px 8px -2px rgba(15, 23, 42, 0.03) !important;
        }

        /* ── 2. Modern Clean Badge & Pill ── */
        .nm-inset {
            background: #f1f5f9 !important;
            border-radius: 9999px !important;
            box-shadow: none !important;
            border: none !important;
            color: #1e3a8a !important;
        }

        /* ── 3. Modern Clean Button ── */
        .nm-btn {
            background: #ffffff !important;
            border-radius: 12px !important;
            box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.05) !important;
            border: none !important;
            transition: transform 0.15s ease, background-color 0.15s ease, box-shadow 0.15s ease !important;
            color: #1e3a8a !important;
            font-weight: 600 !important;
        }
        .nm-btn:hover {
            transform: translateY(-1px) !important;
            background: #f8fafc !important;
            border: none !important;
            color: #0f172a !important;
            box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.08) !important;
        }
        .nm-btn:active {
            transform: translateY(0) !important;
            background: #f1f5f9 !important;
        }

        /* ── 4. Clean White Surface Card Panel ── */
        .glass-panel {
            background: #ffffff !important;
            border: none !important;
            box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.03) !important;
            border-radius: 18px !important;
        }

        header,
        header.landing-header {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        /* ── 4b. Pristine Floating Navbar Pill ── */
        .navbar-capsule {
            background: rgba(255, 255, 255, 0.94) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: none !important;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.03) !important;
            border-radius: 9999px !important;
        }

        .btn-primary-pill {
            background: linear-gradient(135deg, #1E3A8A 0%, #0F172A 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px 0 rgba(15, 23, 42, 0.14) !important;
            border-radius: 9999px !important;
            border: none !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: transform 0.15s ease, box-shadow 0.15s ease !important;
        }
        .btn-primary-pill:hover {
            transform: translateY(-1.5px) !important;
            box-shadow: 0 4px 14px 0 rgba(15, 23, 42, 0.2) !important;
            background: linear-gradient(135deg, #2563EB 0%, #1E3A8A 100%) !important;
            color: #ffffff !important;
        }
        .btn-ghost-pill {
            color: #1E3A8A !important;
            font-weight: 700 !important;
            border-radius: 9999px !important;
            border: none !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: background-color 0.15s ease, color 0.15s ease !important;
        }
        .btn-ghost-pill:hover {
            color: #2563EB !important;
            background-color: rgba(37, 99, 235, 0.08) !important;
        }

        /* ── 5. Dark Blue Button ── */
        .glass-navy-btn,
        a.glass-navy-btn,
        button.glass-navy-btn {
            background: linear-gradient(135deg, #1E3A8A 0%, #0F172A 100%) !important;
            border: none !important;
            box-shadow: 0 4px 14px 0 rgba(15, 23, 42, 0.15) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
            text-decoration: none !important;
        }
        .glass-navy-btn *,
        .glass-navy-btn span,
        .glass-navy-btn svg,
        .glass-navy-btn a,
        .glass-navy-btn p,
        .glass-navy-btn strong {
            color: #ffffff !important;
            fill: currentColor !important;
            stroke: currentColor !important;
        }
        .glass-navy-btn:hover,
        a.glass-navy-btn:hover,
        button.glass-navy-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px -2px rgba(15, 23, 42, 0.2) !important;
            background: linear-gradient(135deg, #2563EB 0%, #1E3A8A 100%) !important;
            color: #ffffff !important;
        }
        .glass-navy-btn:hover * {
            color: #ffffff !important;
        }

        /* ── 6. 3D Isometric Desktop Mockup (Desktop only) ── */
        .mockup-container-3d {
            perspective: 1600px;
        }
        .isometric-desktop {
            transform: rotateX(10deg) rotateY(-14deg) rotateZ(3deg);
            transform-style: preserve-3d;
            box-shadow: -16px 24px 45px -10px rgba(15, 23, 42, 0.15), 
                        -6px 10px 20px -4px rgba(15, 23, 42, 0.08);
            border: none !important;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .mockup-container-3d:hover .isometric-desktop {
            transform: rotateX(4deg) rotateY(-4deg) rotateZ(1deg) translateY(-4px) scale(1.01);
            box-shadow: -20px 30px 55px -12px rgba(15, 23, 42, 0.20), 
                        -8px 12px 24px -5px rgba(15, 23, 42, 0.10);
        }

        /* ── 7. Mobile Performance Optimizations (Zero lag on Phone) ── */
        @media (max-width: 768px) {
            .mockup-container-3d {
                perspective: none !important;
            }
            .isometric-desktop {
                transform: none !important;
                transform-style: flat !important;
                box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04) !important;
                transition: none !important;
            }
            .mockup-container-3d:hover .isometric-desktop {
                transform: none !important;
            }
            .navbar-capsule {
                background: rgba(255, 255, 255, 0.96) !important;
                backdrop-filter: blur(6px) !important;
                -webkit-backdrop-filter: blur(6px) !important;
            }
            .nm-card, .nm-btn, .glass-navy-btn {
                transition: transform 0.1s ease !important;
            }
        }

        /* ── 8. Sticky Header Offset Clearance ── */
        section[id] {
            scroll-margin-top: 6.5rem !important;
        }

        /* ── 9. Robust Footer Grid ── */
        .footer-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
            align-items: start;
        }
        @media (min-width: 640px) {
            .footer-layout {
                grid-template-columns: repeat(2, 1fr);
                gap: 2.5rem;
            }
        }
        @media (min-width: 1024px) {
            .footer-layout {
                grid-template-columns: 2.3fr 1.3fr 1.1fr 1.6fr;
                gap: 2.5rem;
            }
        }

        /* ── 10. Smooth FAQ Accordion ── */
        .faq-collapse {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .faq-collapse.open {
            grid-template-rows: 1fr;
        }
        .faq-collapse-inner {
            min-height: 0;
            overflow: hidden;
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            opacity: 0;
            transform: translateY(-8px);
        }
        .faq-collapse.open .faq-collapse-inner {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── 11. Feature Card Icon Hover Effect ── */
        .feature-icon-box {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .feature-icon-box svg {
            transition: stroke 0.3s cubic-bezier(0.16, 1, 0.3, 1), color 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .group:hover .feature-icon-box {
            background-color: #1E3A8A !important;
            color: #ffffff !important;
        }
        .group:hover .feature-icon-box svg,
        .group:hover .feature-icon-box svg path {
            stroke: #ffffff !important;
            color: #ffffff !important;
        }

        /* ── VETEN DASHBOARD SINKRON DARK MODE SYSTEM ── */
        html.dark body {
            background-color: #070d1f !important;
            background-image: 
                radial-gradient(at 15% 10%, rgba(30, 58, 138, 0.3) 0px, transparent 50%),
                radial-gradient(at 85% 15%, rgba(47, 107, 253, 0.2) 0px, transparent 45%),
                radial-gradient(at 50% 55%, rgba(15, 23, 42, 0.7) 0px, transparent 50%),
                radial-gradient(at 20% 85%, rgba(30, 58, 138, 0.25) 0px, transparent 50%) !important;
            color: #e2e8f0 !important;
        }

        html.dark .navbar-capsule {
            background: rgba(18, 24, 46, 0.90) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 25px -2px rgba(0, 0, 0, 0.6) !important;
        }

        html.dark .navbar-capsule a:not(.btn-primary-pill),
        html.dark .navbar-capsule span:not(.text-\[\#1E3A8A\]) {
            color: #f8fafc !important;
        }

        html.dark .navbar-capsule nav a {
            color: #cbd5e1 !important;
        }

        html.dark .navbar-capsule nav a:hover {
            color: #60a5fa !important;
        }

        html.dark .theme-toggle-btn {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
        }

        html.dark .theme-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            color: #60a5fa !important;
        }

        html.dark .nm-card,
        html.dark .glass-panel,
        html.dark section .bg-white {
            background: #12182e !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            box-shadow: 6px 6px 18px #080c1a, -4px -4px 14px #1b2342 !important;
        }

        html.dark .nm-card:hover,
        html.dark section .bg-white:hover {
            border-color: rgba(47, 107, 253, 0.3) !important;
            box-shadow: 8px 8px 24px #080c1a, -6px -6px 18px #1b2342 !important;
        }

        html.dark .nm-inset,
        html.dark .bg-slate-50,
        html.dark .bg-slate-100,
        html.dark .bg-slate-100\/90 {
            background: rgba(255, 255, 255, 0.04) !important;
            color: #93c5fd !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        html.dark .feature-icon-box {
            background: rgba(47, 107, 253, 0.18) !important;
            color: #60a5fa !important;
        }

        html.dark .text-\[\#0F172A\] {
            color: #f8fafc !important;
        }

        html.dark .text-\[\#1E3A8A\] {
            color: #60a5fa !important;
        }

        html.dark .text-slate-600,
        html.dark .text-slate-700 {
            color: #94a3b8 !important;
        }

        html.dark .border-slate-100,
        html.dark .border-slate-100\/80 {
            border-color: rgba(255, 255, 255, 0.06) !important;
        }

        html.dark .isometric-desktop {
            background: #12182e !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: -16px 24px 45px -10px rgba(0, 0, 0, 0.7) !important;
        }

        html.dark .isometric-desktop .bg-slate-50\/80 {
            background: #0d152e !important;
        }

        html.dark .isometric-desktop .bg-white {
            background: rgba(255, 255, 255, 0.06) !important;
            color: #cbd5e1 !important;
        }

        html.dark .isometric-desktop .bg-slate-100 {
            background: #090e21 !important;
        }

        html.dark .faq-chevron {
            color: #94a3b8 !important;
        }

        html.dark footer {
            background: #070d1f !important;
            border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        }

        html.dark footer .text-\[\#0F172A\] {
            color: #f8fafc !important;
        }

        html.dark footer .text-\[\#1E3A8A\] {
            color: #60a5fa !important;
        }

        html.dark footer .text-slate-600,
        html.dark footer .text-slate-700 {
            color: #94a3b8 !important;
        }

        html.dark footer .bg-slate-100 {
            background: rgba(255, 255, 255, 0.06) !important;
        }

        html.dark footer .nm-btn {
            background: #12182e !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            color: #94a3b8 !important;
        }

        html.dark footer .nm-btn:hover {
            color: #ffffff !important;
            background: #1e293b !important;
        }

        html.dark footer .bg-emerald-50 {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
        }
    </style>
</head>
<body class="text-[#0F172A] antialiased selection:bg-blue-600 selection:text-white relative">

    <!-- ========================================================= -->
    <header class="landing-header sticky top-4 sm:top-5 z-50 px-4 sm:px-6 max-w-7xl mx-auto mb-6 sm:mb-8" style="background: transparent !important; box-shadow: none !important; border: none !important;">
        <div class="navbar-capsule px-5 sm:px-8 py-3 flex items-center justify-between transition-all duration-300">
            
            {{-- Logo: Dark Blue text & VetenCall identity --}}
            <a href="#home" class="flex items-center gap-3 group shrink-0">
                <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall" class="h-8 sm:h-9 w-auto object-contain drop-shadow-sm group-hover:scale-105 transition-transform" width="36" height="36" decoding="async">
                <div class="leading-tight">
                    <span class="text-xl sm:text-2xl font-black text-[#0F172A] tracking-tight block">VetenCall</span>
                    <span class="text-[9px] uppercase tracking-widest text-[#1E3A8A] font-extrabold block">WA Gateway &amp; VoIP</span>
                </div>
            </a>

            {{-- Desktop Navigation Links --}}
            <nav class="hidden md:flex items-center gap-8 lg:gap-10 text-[13px] font-semibold text-slate-700">
                <a href="#fitur" class="hover:text-blue-700 transition-colors whitespace-nowrap">Fitur Gateway</a>
                <a href="#faq" class="hover:text-blue-700 transition-colors whitespace-nowrap">FAQ</a>
                <a href="#blog" class="hover:text-blue-700 transition-colors whitespace-nowrap">Panduan</a>
            </nav>

            {{-- Action Buttons --}}
            <div class="hidden sm:flex items-center gap-2.5 shrink-0">
                <button onclick="toggleTheme()" type="button" aria-label="Ganti Tema" class="theme-toggle-btn flex items-center justify-center w-9 h-9 rounded-full transition-all border border-black/10 text-slate-700 hover:bg-slate-100 cursor-pointer" title="Ganti Mode Tampilan (Dark/Light)">
                    <span class="theme-toggle-icon flex items-center">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                    </span>
                </button>
                <a href="{{ route('login.page') }}" class="px-5 py-2 text-xs btn-primary-pill">
                    Masuk Dashboard
                </a>
            </div>

            {{-- Mobile Menu Trigger --}}
            <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 rounded-full text-slate-700 hover:bg-slate-100 transition" aria-label="Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>

        {{-- Mobile Dropdown Menu --}}
        <div id="mobile-menu" class="hidden md:hidden mt-2 glass-panel p-5 space-y-3 shadow-xl">
            <a href="#fitur" class="block text-xs font-bold text-[#0F172A] hover:text-[#1E3A8A]">Fitur Gateway</a>
            <a href="#faq" class="block text-xs font-bold text-[#0F172A] hover:text-[#1E3A8A]">FAQ</a>
            <a href="#blog" class="block text-xs font-bold text-[#0F172A] hover:text-[#1E3A8A]">Panduan</a>
            <div class="pt-2 flex flex-col gap-2">
                <button onclick="toggleTheme()" type="button" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-bold nm-btn cursor-pointer">
                    <span class="theme-toggle-icon flex items-center">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                    </span>
                    <span class="theme-toggle-text">Toggle Mode</span>
                </button>
                <a href="{{ route('login.page') }}" class="w-full text-center py-2.5 rounded-xl text-xs glass-navy-btn" style="color: #ffffff !important;">
                    <span style="color: #ffffff !important; font-weight: 700;">Masuk Dashboard</span>
                </a>
            </div>
        </div>
    </header>

    <!-- ========================================================= -->
    <!-- 2. HERO SECTION (Headline + 3D Isometric Phone Mockup)    -->
    <!-- ========================================================= -->
    <section id="home" class="pb-20 px-6 max-w-7xl mx-auto" style="padding-top: 3.5rem !important; scroll-margin-top: 9rem !important;">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            {{-- Left Side: Bold Dark Blue Headline & CTA Buttons --}}
            <div class="lg:col-span-6 space-y-6 text-center lg:text-left">
                

                {{-- Bold Dark Blue Headline --}}
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-[#0F172A] tracking-tight leading-[1.12]">
                    Automate Your <br class="hidden sm:inline">
                    <span class="text-[#1E3A8A] underline decoration-blue-500/30 decoration-wavy">WhatsApp Messaging</span> &amp; Business Outreach
                </h1>

                {{-- Subtext --}}
                <p class="text-xs sm:text-base text-slate-600 font-medium leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Kirim pesan massal anti-banned dengan jeda acak alami, otomatisasi balasan bot 24/7, dan kelola kampanye broadcast serta komunikasi bisnis langsung dari dashboard.
                </p>

                {{-- Action Button --}}
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 pt-2">
                    <a href="{{ route('login.page') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-xs sm:text-sm glass-navy-btn text-center flex items-center justify-center gap-2" style="color: #ffffff !important;">
                        <span style="color: #ffffff !important; font-weight: 700;">Masuk ke Dashboard</span>
                        <svg class="w-4 h-4" style="color: #ffffff !important;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>



            </div>

            {{-- Right Side: Interactive Dashboard Workspace 3D Mockup --}}
            <div class="lg:col-span-6 relative flex items-center justify-center pt-8 lg:pt-0 mockup-container-3d">
                {{-- Ambient Background Glow --}}
                <div class="absolute -inset-4 bg-gradient-to-tr from-slate-200/40 via-blue-900/5 to-slate-200/30 rounded-3xl blur-3xl -z-10 opacity-70"></div>

                {{-- Modern Desktop Browser/App Frame (3D Isometric, Borderless with Smooth Shadow) --}}
                <div class="w-full max-w-[560px] rounded-2xl bg-white p-2.5 sm:p-3 isometric-desktop">
                    
                    {{-- Window Header / Controls --}}
                    <div class="flex items-center justify-between px-3 py-2 mb-2.5 bg-slate-50/80 rounded-xl">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#ff5f56] inline-block"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#ffbd2e] inline-block"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#27c93f] inline-block"></span>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-0.5 rounded-md bg-white text-[11px] font-medium text-slate-500 shadow-xs">
                            <svg class="w-3 h-3 text-emerald-500 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            <span>vetencall.app/workspace</span>
                        </div>
                        <div class="flex items-center gap-1 text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Live
                        </div>
                    </div>

                    {{-- Mockup Image Container --}}
                    <div class="relative rounded-xl overflow-hidden shadow-xs bg-slate-100 group">
                        <img src="{{ asset('images/dashboard-preview.png') }}" 
                             alt="VetenCall Workspace Dashboard" 
                             class="w-full h-auto object-cover block transition-transform duration-500 group-hover:scale-[1.01]" 
                             loading="eager"
                             decoding="async"
                             width="560"
                             height="350">
                        
                        {{-- Subtle Glass Sheen Overlay on Hover --}}
                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-white/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 3. FEATURES SECTION (card-18 Modern Card Styling)         -->
    <!-- ========================================================= -->
    <section id="fitur" class="py-20 px-6 max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-14">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white text-[#1E3A8A] shadow-xs">
                Fitur Unggulan
            </span>
            <h2 class="text-3xl sm:text-4xl font-black text-[#0F172A] tracking-tight">
                Arsitektur Gateway Cerdas untuk Skala Enterprise
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
                Dirancang khusus untuk menjaga pengiriman pesan tetap lancar, cepat, dan aman dari pemblokiran.
            </p>
        </div>

        {{-- 4 Clean Modern Cards Grid (card-18 Pattern, Borderless with Smooth Shadow) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-7">
            
            {{-- Feature Card 1: Bulk Blast --}}
            <div class="group relative flex flex-col overflow-hidden rounded-2xl bg-white p-6 sm:p-7 shadow-sm transition-all duration-300 ease-in-out hover:shadow-md hover:-translate-y-1 justify-between space-y-5">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="feature-icon-box w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-[#1E3A8A] transition-all duration-300 shadow-xs">
                            <svg class="w-6 h-6 transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </div>
                        <span class="rounded-full bg-slate-100/90 px-2.5 py-1 text-[10px] font-bold text-[#1E3A8A] shadow-2xs">Anti-Banned</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#0F172A]">
                            <span class="bg-gradient-to-r from-[#1E3A8A] to-[#1E3A8A] bg-[length:0%_2px] bg-left-bottom bg-no-repeat transition-[background-size] duration-500 group-hover:bg-[length:100%_2px]">
                                WhatsApp Blast Cerdas
                            </span>
                        </h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed font-normal">
                            Kirim promosi massal ke ribuan pelanggan dengan jeda acak alami (human-like interval) dan rotasi multi-device otomatis.
                        </p>
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-100/80">
                    <span class="text-xs font-bold text-[#1E3A8A] inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Personal Tag {name} &rarr;
                    </span>
                </div>
            </div>

            {{-- Feature Card 2: Auto-Reply & Chatbot --}}
            <div class="group relative flex flex-col overflow-hidden rounded-2xl bg-white p-6 sm:p-7 shadow-sm transition-all duration-300 ease-in-out hover:shadow-md hover:-translate-y-1 justify-between space-y-5">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="feature-icon-box w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-[#1E3A8A] transition-all duration-300 shadow-xs">
                            <svg class="w-6 h-6 transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <span class="rounded-full bg-slate-100/90 px-2.5 py-1 text-[10px] font-bold text-[#1E3A8A] shadow-2xs">Otomasi 24/7</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#0F172A]">
                            <span class="bg-gradient-to-r from-[#1E3A8A] to-[#1E3A8A] bg-[length:0%_2px] bg-left-bottom bg-no-repeat transition-[background-size] duration-500 group-hover:bg-[length:100%_2px]">
                                Auto-Reply &amp; Bot Cerdas
                            </span>
                        </h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed font-normal">
                            Respon otomatis berbasis kata kunci promo, menu interaktif alur percakapan cerdas tanpa perlu standby operator manual.
                        </p>
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-100/80">
                    <span class="text-xs font-bold text-[#1E3A8A] inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Trigger Kata Kunci &rarr;
                    </span>
                </div>
            </div>

            {{-- Feature Card 3: Link Tracker & Analytics --}}
            <div class="group relative flex flex-col overflow-hidden rounded-2xl bg-white p-6 sm:p-7 shadow-sm transition-all duration-300 ease-in-out hover:shadow-md hover:-translate-y-1 justify-between space-y-5">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="feature-icon-box w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-[#1E3A8A] transition-all duration-300 shadow-xs">
                            <svg class="w-6 h-6 transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </div>
                        <span class="rounded-full bg-slate-100/90 px-2.5 py-1 text-[10px] font-bold text-[#1E3A8A] shadow-2xs">Real-Time</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#0F172A]">
                            <span class="bg-gradient-to-r from-[#1E3A8A] to-[#1E3A8A] bg-[length:0%_2px] bg-left-bottom bg-no-repeat transition-[background-size] duration-500 group-hover:bg-[length:100%_2px]">
                                Link Tracker &amp; Kampanye
                            </span>
                        </h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed font-normal">
                            Pantau efektivitas broadcast dengan pemendek tautan otomatis, analitik klik real-time, dan manajemen template pesan siap pakai.
                        </p>
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-100/80">
                    <span class="text-xs font-bold text-[#1E3A8A] inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Tracking Real-Time &rarr;
                    </span>
                </div>
            </div>

            {{-- Feature Card 4: Multi-Provider SMS & VoIP Fallback --}}
            <div class="group relative flex flex-col overflow-hidden rounded-2xl bg-white p-6 sm:p-7 shadow-sm transition-all duration-300 ease-in-out hover:shadow-md hover:-translate-y-1 justify-between space-y-5">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="feature-icon-box w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-[#1E3A8A] transition-all duration-300 shadow-xs">
                            <svg class="w-6 h-6 transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <span class="rounded-full bg-slate-100/90 px-2.5 py-1 text-[10px] font-bold text-[#1E3A8A] shadow-2xs">Omni-Channel</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#0F172A]">
                            <span class="bg-gradient-to-r from-[#1E3A8A] to-[#1E3A8A] bg-[length:0%_2px] bg-left-bottom bg-no-repeat transition-[background-size] duration-500 group-hover:bg-[length:100%_2px]">
                                SMS &amp; Cloud VoIP HD
                            </span>
                        </h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed font-normal">
                            Failover otomatis ke SMS Gateway multi-provider serta panggilan suara Asterisk WebRTC langsung dari web browser.
                        </p>
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-100/80">
                    <span class="text-xs font-bold text-[#1E3A8A] inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Omni-Channel Suite &rarr;
                    </span>
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 6. BLOG / PANDUAN BISNIS (card-18 Featured + Grid Layout)  -->
    <!-- ========================================================= -->
    <section id="blog" class="py-20 px-6 max-w-6xl mx-auto">
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-14">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white text-[#1E3A8A] shadow-xs">
                Artikel Terbaru
            </span>
            <h2 class="text-3xl sm:text-4xl font-black text-[#0F172A] tracking-tight">
                Tips &amp; Panduan Bisnis
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 font-normal">
                Panduan praktis menggunakan VetenCall untuk meningkatkan efisiensi komunikasi bisnis Anda.
            </p>
        </div>

        {{-- 1. Featured Post (card-18 Featured Variant, Borderless with Soft Shadow) --}}
        <a href="{{ route('blog.post', 'cara-kirim-whatsapp-blast-10000-kontak-tanpa-kena-ban') }}" class="group relative flex flex-col md:flex-row overflow-hidden rounded-2xl bg-white shadow-sm transition-all duration-300 ease-in-out hover:shadow-md hover:-translate-y-1 mb-8 md:mb-10 no-underline">
            <div class="relative w-full overflow-hidden md:w-1/2 lg:w-3/5 bg-slate-100 min-h-[260px] md:min-h-full">
                <img
                    src="https://images.unsplash.com/photo-1611746872915-64382b5c76da?w=720&auto=format&fit=crop&q=75"
                    alt="Cara Kirim WhatsApp Blast 10.000 Kontak Tanpa Kena Ban"
                    class="h-full w-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-105"
                    loading="lazy"
                    decoding="async"
                    width="720"
                    height="450"
                />
            </div>

            <div class="flex flex-1 flex-col justify-between p-6 md:p-8">
                <div>
                    <div class="mb-4 flex items-center gap-3 text-xs font-semibold uppercase text-slate-500">
                        <span class="rounded-full bg-slate-100/90 px-3 py-1 text-[11px] font-bold text-[#1E3A8A] shadow-2xs">Unggulan</span>
                        <span class="text-slate-400">&bull;</span>
                        <span>10 Sep 2026</span>
                    </div>

                    <h3 class="mb-3 text-xl font-bold leading-tight text-[#0F172A] lg:text-2xl">
                        <span class="bg-gradient-to-r from-[#1E3A8A] to-[#1E3A8A] bg-[length:0%_2px] bg-left-bottom bg-no-repeat transition-[background-size] duration-500 group-hover:bg-[length:100%_2px]">
                            Cara Kirim WhatsApp Blast 10.000 Kontak Tanpa Kena Ban
                        </span>
                    </h3>
                    
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        Pelajari strategi pengiriman pesan massal yang aman menggunakan interval acak alami, blacklist filter otomatis, dan teknik rotasi multi-device agar akun WhatsApp bisnis Anda tetap terlindungi dengan optimal.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100/80 flex items-center justify-between">
                    <span class="inline-flex items-center justify-center rounded-xl text-xs font-bold bg-[#1E3A8A] text-white px-5 py-2.5 shadow-sm group-hover:bg-blue-700 transition-colors">
                        Baca Artikel Lengkap
                        <svg class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </span>
                    <span class="text-xs text-slate-400 font-medium">Tim VetenCall</span>
                </div>
            </div>
        </a>

        {{-- 2. Grid of Default Posts (card-18 Grid, Borderless with Soft Shadow) --}}
        <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
            
            {{-- Post 1 --}}
            <a href="{{ route('blog.post', 'panduan-setup-cloud-voip-webrtc-untuk-tim-sales') }}" class="group relative flex flex-col overflow-hidden rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 ease-in-out hover:shadow-md hover:-translate-y-1 justify-between no-underline">
                <div>
                    <div class="w-full aspect-[16/9] rounded-xl overflow-hidden mb-5 bg-slate-100">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=70"
                             alt="Cloud VoIP WebRTC" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy" decoding="async" width="500" height="280">
                    </div>
                    <div class="mb-3 flex items-center gap-3 text-xs font-semibold uppercase text-slate-500">
                        <span class="rounded-full bg-slate-100/90 px-2.5 py-1 text-[10px] font-bold text-[#1E3A8A] shadow-2xs">VoIP</span>
                        <span class="text-slate-400">&bull;</span>
                        <span>10 Sep 2026</span>
                    </div>

                    <h3 class="mb-2.5 text-base font-bold leading-snug text-[#0F172A]">
                        <span class="bg-gradient-to-r from-[#1E3A8A] to-[#1E3A8A] bg-[length:0%_2px] bg-left-bottom bg-no-repeat transition-[background-size] duration-500 group-hover:bg-[length:100%_2px]">
                            Panduan Setup Cloud VoIP WebRTC untuk Tim Sales
                        </span>
                    </h3>
                    
                    <p class="text-xs text-slate-600 leading-relaxed font-normal">
                        Mulai panggilan suara HD langsung dari browser tanpa perangkat fisik. Konfigurasi ekstensi SIP Asterisk dan integrasi pipeline sales.
                    </p>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100/80 flex items-center justify-between text-xs text-slate-400">
                    <span class="font-medium">Tim VetenCall</span>
                    <span class="text-[#1E3A8A] font-bold flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                        Baca Selengkapnya &rarr;
                    </span>
                </div>
            </a>

            {{-- Post 2 --}}
            <a href="{{ route('blog.post', 'optimalkan-konversi-dengan-tts-voice-broadcast-otomatis') }}" class="group relative flex flex-col overflow-hidden rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 ease-in-out hover:shadow-md hover:-translate-y-1 justify-between no-underline">
                <div>
                    <div class="w-full aspect-[16/9] rounded-xl overflow-hidden mb-5 bg-slate-100">
                        <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?w=500&auto=format&fit=crop&q=70"
                             alt="TTS Voice Broadcast" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy" decoding="async" width="500" height="280">
                    </div>
                    <div class="mb-3 flex items-center gap-3 text-xs font-semibold uppercase text-slate-500">
                        <span class="rounded-full bg-slate-100/90 px-2.5 py-1 text-[10px] font-bold text-[#1E3A8A] shadow-2xs">Otomasi</span>
                        <span class="text-slate-400">&bull;</span>
                        <span>10 Sep 2026</span>
                    </div>

                    <h3 class="mb-2.5 text-base font-bold leading-snug text-[#0F172A]">
                        <span class="bg-gradient-to-r from-[#1E3A8A] to-[#1E3A8A] bg-[length:0%_2px] bg-left-bottom bg-no-repeat transition-[background-size] duration-500 group-hover:bg-[length:100%_2px]">
                            Optimalkan Konversi dengan TTS Voice Broadcast Otomatis
                        </span>
                    </h3>
                    
                    <p class="text-xs text-slate-600 leading-relaxed font-normal">
                        Text-to-Speech mengubah pesan promosi Anda menjadi panggilan suara otomatis ke ribuan nomor pelanggan dalam sekejap.
                    </p>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100/80 flex items-center justify-between text-xs text-slate-400">
                    <span class="font-medium">Tim VetenCall</span>
                    <span class="text-[#1E3A8A] font-bold flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                        Baca Selengkapnya &rarr;
                    </span>
                </div>
            </a>

            {{-- Post 3 --}}
            <a href="{{ route('blog.post', 'meningkatkan-click-through-rate-menggunakan-smart-link-tracker') }}" class="group relative flex flex-col overflow-hidden rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 ease-in-out hover:shadow-md hover:-translate-y-1 justify-between no-underline">
                <div>
                    <div class="w-full aspect-[16/9] rounded-xl overflow-hidden mb-5 bg-slate-100">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&auto=format&fit=crop&q=70"
                             alt="Link Tracker Analytics" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy" decoding="async" width="500" height="280">
                    </div>
                    <div class="mb-3 flex items-center gap-3 text-xs font-semibold uppercase text-slate-500">
                        <span class="rounded-full bg-slate-100/90 px-2.5 py-1 text-[10px] font-bold text-[#1E3A8A] shadow-2xs">Analytics</span>
                        <span class="text-slate-400">&bull;</span>
                        <span>10 Sep 2026</span>
                    </div>

                    <h3 class="mb-2.5 text-base font-bold leading-snug text-[#0F172A]">
                        <span class="bg-gradient-to-r from-[#1E3A8A] to-[#1E3A8A] bg-[length:0%_2px] bg-left-bottom bg-no-repeat transition-[background-size] duration-500 group-hover:bg-[length:100%_2px]">
                            Meningkatkan Click-Through Rate Menggunakan Smart Link Tracker
                        </span>
                    </h3>
                    
                    <p class="text-xs text-slate-600 leading-relaxed font-normal">
                        Analisis data klik kampanye secara real-time, pantau konversi penerima pesan, dan uji A/B testing copy iklan WhatsApp.
                    </p>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100/80 flex items-center justify-between text-xs text-slate-400">
                    <span class="font-medium">Tim VetenCall</span>
                    <span class="text-[#1E3A8A] font-bold flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                        Baca Selengkapnya &rarr;
                    </span>
                </div>
            </a>

        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 7. FAQ ACCORDION SECTION (Clean Modern Accordion Cards)   -->
    <!-- ========================================================= -->
    <section id="faq" class="py-20 px-6 max-w-4xl mx-auto">
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-12">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white text-[#1E3A8A] shadow-xs">
                Tanya Jawab
            </span>
            <h2 class="text-3xl sm:text-4xl font-black text-[#0F172A] tracking-tight">
                Pertanyaan yang Sering Diajukan
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 font-normal">
                Punya pertanyaan seputar integrasi, nomor, atau keamanan? Temukan jawabannya di bawah ini.
            </p>
        </div>

        <div class="space-y-3.5 sm:space-y-4">
            {{-- FAQ 1 --}}
            <div class="nm-card p-5 sm:p-6 rounded-2xl group">
                <button type="button" class="w-full flex items-center justify-between gap-4 text-left focus:outline-none cursor-pointer" onclick="toggleFaq(this)">
                    <span class="text-sm sm:text-base font-bold text-[#0F172A] group-hover:text-[#1E3A8A] transition-colors">
                        Apakah pengiriman WhatsApp blast di VetenCall aman dari blokir nomor?
                    </span>
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0 text-slate-600 group-hover:text-[#1E3A8A] group-hover:bg-slate-200/70 transition-colors shadow-2xs">
                        <svg class="w-4 h-4 transition-transform duration-300 faq-chevron rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </button>
                <div class="faq-collapse open">
                    <div class="faq-collapse-inner">
                        <div class="pt-3.5 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Sangat aman. Sistem VetenCall dilengkapi fitur jeda acak natural (human-like delay), blacklist filter otomatis, dan opsi multi-device rotation yang mendistribusikan volume pesan secara proporsional.
                        </div>
                    </div>
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="nm-card p-5 sm:p-6 rounded-2xl group">
                <button type="button" class="w-full flex items-center justify-between gap-4 text-left focus:outline-none cursor-pointer" onclick="toggleFaq(this)">
                    <span class="text-sm sm:text-base font-bold text-[#0F172A] group-hover:text-[#1E3A8A] transition-colors">
                        Apakah saya memerlukan kartu SIM khusus atau modem pool untuk menggunakan layanan?
                    </span>
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0 text-slate-600 group-hover:text-[#1E3A8A] group-hover:bg-slate-200/70 transition-colors shadow-2xs">
                        <svg class="w-4 h-4 transition-transform duration-300 faq-chevron" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </button>
                <div class="faq-collapse">
                    <div class="faq-collapse-inner">
                        <div class="pt-3.5 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Tidak perlu modem pool atau perangkat keras tambahan. Anda cukup menautkan nomor WhatsApp Anda melalui scan QR code web di dashboard secara instan.
                        </div>
                    </div>
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="nm-card p-5 sm:p-6 rounded-2xl group">
                <button type="button" class="w-full flex items-center justify-between gap-4 text-left focus:outline-none cursor-pointer" onclick="toggleFaq(this)">
                    <span class="text-sm sm:text-base font-bold text-[#0F172A] group-hover:text-[#1E3A8A] transition-colors">
                        Bagaimana cara kerja Cloud VoIP WebRTC di VetenCall?
                    </span>
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0 text-slate-600 group-hover:text-[#1E3A8A] group-hover:bg-slate-200/70 transition-colors shadow-2xs">
                        <svg class="w-4 h-4 transition-transform duration-300 faq-chevron" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </button>
                <div class="faq-collapse">
                    <div class="faq-collapse-inner">
                        <div class="pt-3.5 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Setiap akun mendapatkan ekstensi SIP Asterisk yang terhubung langsung di web browser via teknologi WebRTC. Anda bisa melakukan dan menerima panggilan suara berkejernihan HD tanpa perangkat IP Phone fisik.
                        </div>
                    </div>
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="nm-card p-5 sm:p-6 rounded-2xl group">
                <button type="button" class="w-full flex items-center justify-between gap-4 text-left focus:outline-none cursor-pointer" onclick="toggleFaq(this)">
                    <span class="text-sm sm:text-base font-bold text-[#0F172A] group-hover:text-[#1E3A8A] transition-colors">
                        Berapa kuota kontak yang bisa saya simpan di dalam Phonebook?
                    </span>
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0 text-slate-600 group-hover:text-[#1E3A8A] group-hover:bg-slate-200/70 transition-colors shadow-2xs">
                        <svg class="w-4 h-4 transition-transform duration-300 faq-chevron" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </button>
                <div class="faq-collapse">
                    <div class="faq-collapse-inner">
                        <div class="pt-3.5 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Anda dapat menyimpan puluhan hingga ratusan ribu kontak melalui import file Excel (.xlsx) atau CSV dengan mudah. Kontak dapat dikelompokkan ke grup dan tag kampanye.
                        </div>
                    </div>
                </div>
            </div>

            {{-- FAQ 5 --}}
            <div class="nm-card p-5 sm:p-6 rounded-2xl group">
                <button type="button" class="w-full flex items-center justify-between gap-4 text-left focus:outline-none cursor-pointer" onclick="toggleFaq(this)">
                    <span class="text-sm sm:text-base font-bold text-[#0F172A] group-hover:text-[#1E3A8A] transition-colors">
                        Apakah saya bisa mencoba layanannya terlebih dahulu secara gratis?
                    </span>
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0 text-slate-600 group-hover:text-[#1E3A8A] group-hover:bg-slate-200/70 transition-colors shadow-2xs">
                        <svg class="w-4 h-4 transition-transform duration-300 faq-chevron" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </button>
                <div class="faq-collapse">
                    <div class="faq-collapse-inner">
                        <div class="pt-3.5 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Tentu saja! Anda dapat mendaftar akun baru dan langsung mencoba fitur uji coba gratis untuk eksplorasi dashboard, manajemen kontak, dan kirim pesan broadcast.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 8. FOOTER (Full-Width Edge-to-Edge Clean SaaS Footer)     -->
    <!-- ========================================================= -->
    <footer class="w-full bg-white pt-16 pb-12 mt-24" style="border: none !important; border-top: none !important; box-shadow: none !important;">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 space-y-12">
            
            {{-- Footer Main Columns --}}
            <div class="footer-layout">
                
                {{-- Col 1: Brand & Status --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall" class="h-9 w-auto object-contain" width="36" height="36" loading="lazy" decoding="async">
                        <div class="leading-tight">
                            <span class="text-xl font-black text-[#0F172A] tracking-tight block">VetenCall</span>
                            <span class="text-[9px] uppercase tracking-widest text-[#1E3A8A] font-extrabold block">WA Gateway &amp; VoIP</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed font-normal" style="max-width: 320px; line-height: 1.6;">
                        Platform komunikasi omni-channel WhatsApp Gateway API, SMS multi-provider, dan Cloud VoIP WebRTC terpadu untuk akselerasi bisnis di Indonesia.
                    </p>
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold shadow-2xs" style="width: fit-content; max-width: 100%;">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse flex-shrink-0"></span>
                        <span style="white-space: nowrap;">Seluruh Sistem Operasional Normal (99.9% Uptime)</span>
                    </div>
                    
                    {{-- Social Chips --}}
                    <div class="pt-1 flex items-center gap-2.5">
                        <a href="https://s.id/wbXMS" target="_blank" title="WhatsApp" class="w-8 h-8 rounded-xl nm-btn flex items-center justify-center text-slate-700 hover:text-emerald-600 transition">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                        <a href="mailto:support@vetencode.com" title="Email" class="w-8 h-8 rounded-xl nm-btn flex items-center justify-center text-slate-700 hover:text-[#1E3A8A] transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </a>
                        <a href="https://www.vetencode.com/" target="_blank" title="Website Resmi" class="w-8 h-8 rounded-xl nm-btn flex items-center justify-center text-slate-700 hover:text-[#1E3A8A] transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Col 2: Product --}}
                <div class="space-y-4">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#1E3A8A]">Produk &amp; Fitur</h4>
                    <ul class="space-y-2 text-xs font-bold text-[#0F172A]">
                        <li><a href="#fitur" class="hover:text-[#1E3A8A] transition">WhatsApp Blast Massal</a></li>
                        <li><a href="#fitur" class="hover:text-[#1E3A8A] transition">Autoresponder &amp; Chatbot</a></li>
                        <li><a href="#fitur" class="hover:text-[#1E3A8A] transition">Link Tracker &amp; Kampanye</a></li>
                        <li><a href="#fitur" class="hover:text-[#1E3A8A] transition">Cloud VoIP WebRTC HD</a></li>
                        <li><a href="#fitur" class="hover:text-[#1E3A8A] transition">SMS Gateway Multi-Provider</a></li>
                    </ul>
                </div>

                {{-- Col 3: Company & Navigation --}}
                <div class="space-y-4">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#1E3A8A]">Navigasi</h4>
                    <ul class="space-y-2 text-xs font-bold text-[#0F172A]">
                        <li><a href="{{ route('login.page') }}" class="hover:text-[#1E3A8A] transition">Masuk Akun</a></li>
                        <li><a href="{{ route('login.page') }}" class="hover:text-[#1E3A8A] transition">Pendaftaran Baru</a></li>
                        <li><a href="#faq" class="hover:text-[#1E3A8A] transition">Tanya Jawab (FAQ)</a></li>
                        <li><a href="#blog" class="hover:text-[#1E3A8A] transition">Panduan Bisnis</a></li>
                    </ul>
                </div>

                {{-- Col 4: Headquarters / Office --}}
                <div class="space-y-4">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#1E3A8A]">Kantor Pusat</h4>
                    <div class="text-xs text-slate-700 space-y-2">
                        <p class="font-extrabold text-[#0F172A]">PT. Vetencode Pradani Abadi</p>
                        <p class="leading-relaxed text-slate-600 font-normal">
                            Jl. Arwinda Asri, Sindanglaka, Cianjur, Jawa Barat 43281
                        </p>
                        <div class="pt-1 space-y-1.5 font-bold text-[#1E3A8A]">
                            <a href="https://s.id/wbXMS" target="_blank" class="flex items-center gap-2 hover:underline">
                                <span>WA: +62 851-8700-0136</span>
                            </a>
                            <a href="mailto:support@vetencode.com" class="flex items-center gap-2 hover:underline">
                                <span>support@vetencode.com</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Divider --}}
            <div class="w-full h-px bg-slate-100" style="margin: 2.5rem 0 1.5rem 0 !important;"></div>

            {{-- Bottom Bar: Copyright & Legal --}}
            <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 font-medium gap-4" style="display: flex !important; justify-content: space-between !important; align-items: center !important; flex-wrap: wrap !important;">
                <p>&copy; 2026 <strong class="text-[#0F172A]">VetenCall WA Gateway</strong> &bull; PT. Vetencode Pradani Abadi. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center gap-5 text-[#0F172A] font-semibold" style="display: flex !important; align-items: center !important; gap: 1.25rem !important;">
                    <a href="#" class="hover:text-[#1E3A8A] transition-colors">Kebijakan Privasi</a>
                    <span class="text-slate-300">&bull;</span>
                    <a href="#" class="hover:text-[#1E3A8A] transition-colors">Syarat &amp; Ketentuan</a>
                    <span class="text-slate-300">&bull;</span>
                    <a href="#" class="hover:text-[#1E3A8A] transition-colors">Keamanan Data &amp; SLA</a>
                </div>
            </div>

        </div>
    </footer>


    <script>
        function toggleFaq(btn) {
            const collapse = btn.nextElementSibling;
            const chevron = btn.querySelector('.faq-chevron');
            if (!collapse) return;
            const isOpen = collapse.classList.toggle('open');
            if (chevron) {
                chevron.classList.toggle('rotate-180', isOpen);
            }
        }
    </script>
</body>
</html>
