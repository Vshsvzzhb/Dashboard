<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - Auth</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Core Animation Style */
        .auth-container {
            position: relative;
            overflow: hidden;
        }

        /* Dekstop / Layar Lebar (>768px) */
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

            /* Single Gradient Background Tanpa Garis Pembatas */
            .overlay {
                background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%);
                position: relative;
                left: -100%;
                height: 100%;
                width: 200%;
                transform: translateX(0);
                transition: transform 0.6s ease-in-out;
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
                box-shadow: none !important;
            }

            .overlay-left { transform: translateX(-20%); }
            .auth-container.right-panel-active .overlay-left { transform: translateX(0); }

            .overlay-right { right: 0; transform: translateX(0); }
            .auth-container.right-panel-active .overlay-right { transform: translateX(20%); }
        }

        /* Mobile / Layar HP (<768px) */
        @media (max-width: 767px) {
            .overlay-container { display: none; }
            .form-container { width: 100% !important; position: relative; }
            .sign-up-container { display: none; }
            
            .auth-container.right-panel-active .sign-in-container { display: none; }
            .auth-container.right-panel-active .sign-up-container { display: block !important; opacity: 1; }
        }
    </style>
</head>
<body class="bg-[#0a1128] text-white antialiased">

    {{-- Main Wrapper --}}
    <div class="min-h-screen bg-gradient-to-br from-[#0c1638] via-[#0d1844] to-[#1a2f8a] flex items-center justify-center p-4 sm:p-6 md:p-12 relative overflow-hidden">
        
        {{-- Watermark Logo Veten di Kiri Bawah --}}
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" 
             class="absolute -bottom-48 -left-48 w-[850px] max-w-none opacity-10 pointer-events-none select-none z-0">

        {{-- Glow Effect Main Background --}}
        <div class="absolute -bottom-24 -right-24 w-[600px] h-[600px] bg-blue-600/30 rounded-full blur-[160px] pointer-events-none"></div>

        <div class="max-w-7xl w-full grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center z-10 my-auto relative">
            
            {{-- KIRI: BRANDING & 3 FEATURE CARDS --}}
            <div class="lg:col-span-5 space-y-6 lg:space-y-10">
                
                {{-- Logo VetenCall --}}
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall Logo" class="h-9 md:h-10 w-auto object-contain">
                    <span class="text-xl md:text-2xl font-bold tracking-tight text-white">VetenCall</span>
                </div>

                {{-- Heading & Subtitle --}}
                <div class="space-y-2 lg:space-y-4">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.12]">
                        One Dashboard<br>
                        <span class="text-white">WhatsApp & SMS</span>
                    </h1>
                    <p class="text-slate-300/80 text-xs md:text-sm leading-relaxed max-w-sm">
                        Effortlessly manage, automate, and track your WhatsApp and SMS campaigns from a single, powerful platform.
                    </p>
                </div>

                {{-- 3 Feature Boxes --}}
                <div class="grid grid-cols-3 gap-2 sm:gap-4 pt-1">
                    
                    <div class="p-3 sm:p-5 rounded-2xl bg-white/[0.06] backdrop-blur-md border border-white/10 flex flex-col items-center text-center space-y-2 sm:space-y-4 hover:bg-white/[0.1] transition">
                        <img src="{{ asset('images/Kalender.png') }}" alt="Schedule Campaigns" class="w-10 h-10 sm:w-16 sm:h-16 object-contain">
                        <span class="text-[10px] sm:text-xs font-semibold text-slate-200 leading-tight">Schedule<br>Campaigns</span>
                    </div>

                    <div class="p-3 sm:p-5 rounded-2xl bg-white/[0.06] backdrop-blur-md border border-white/10 flex flex-col items-center text-center space-y-2 sm:space-y-4 hover:bg-white/[0.1] transition">
                        <img src="{{ asset('images/Pesan.png') }}" alt="Automate Responses" class="w-10 h-10 sm:w-16 sm:h-16 object-contain">
                        <span class="text-[10px] sm:text-xs font-semibold text-slate-200 leading-tight">Automate<br>Responses</span>
                    </div>

                    <div class="p-3 sm:p-5 rounded-2xl bg-white/[0.06] backdrop-blur-md border border-white/10 flex flex-col items-center text-center space-y-2 sm:space-y-4 hover:bg-white/[0.1] transition">
                        <img src="{{ asset('images/Tangan.png') }}" alt="Build Partnerships" class="w-10 h-10 sm:w-16 sm:h-16 object-contain">
                        <span class="text-[10px] sm:text-xs font-semibold text-slate-200 leading-tight">Build<br>Partnerships</span>
                    </div>

                </div>
            </div>

            {{-- KANAN: GLASSMORPHIC CARD UTAMA --}}
            <div class="lg:col-span-7">
                <div id="container" class="auth-container bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl min-h-[480px] md:min-h-[540px] shadow-2xl">
                    
                    {{-- 1. FORM REGISTER --}}
                    <div class="form-container sign-up-container p-6 sm:p-8 flex flex-col justify-center">
                        <form action="{{ route('register') }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <h2 class="text-xl sm:text-2xl font-bold text-white">Create Account</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Register to get started</p>
                            </div>

                            <div>
                                <label class="block text-[11px] font-medium text-slate-300 mb-1">Full Name</label>
                                <input type="text" name="name" required placeholder="Enter your full name" class="w-full px-3 py-2 rounded-xl bg-[#0c1638]/60 border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-blue-400 transition">
                            </div>

                            <div>
                                <label class="block text-[11px] font-medium text-slate-300 mb-1">Email</label>
                                <input type="email" name="email" required placeholder="Enter your email" class="w-full px-3 py-2 rounded-xl bg-[#0c1638]/60 border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-blue-400 transition">
                            </div>

                            <div>
                                <label class="block text-[11px] font-medium text-slate-300 mb-1">Password</label>
                                <input type="password" name="password" required placeholder="Create password" class="w-full px-3 py-2 rounded-xl bg-[#0c1638]/60 border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-blue-400 transition">
                            </div>

                            <div>
                                <label class="block text-[11px] font-medium text-slate-300 mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" required placeholder="Confirm password" class="w-full px-3 py-2 rounded-xl bg-[#0c1638]/60 border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-blue-400 transition">
                            </div>

                            <button type="submit" class="w-full py-2.5 px-4 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition mt-2">
                                Register
                            </button>
                        </form>

                        <p class="md:hidden text-[11px] text-center text-slate-400 pt-3">
                            Already have an account? 
                            <button type="button" class="btn-toggle text-blue-400 font-medium underline">Login here</button>
                        </p>
                    </div>

                    {{-- 2. FORM LOGIN --}}
                    <div class="form-container sign-in-container p-6 sm:p-8 flex flex-col justify-center space-y-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-white">Welcome Back!</h2>
                            <p class="text-xs text-slate-400 mt-1">Login to continue to your account</p>
                        </div>

                        <form action="{{ route('login') }}" method="POST" class="space-y-3.5">
                            @csrf
                            <div>
                                <label class="block text-xs font-medium text-slate-300 mb-1">Email</label>
                                <input type="email" name="email" required placeholder="Enter your email" class="w-full px-3.5 py-2.5 rounded-xl bg-[#0c1638]/60 border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-blue-400 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-300 mb-1">Password</label>
                                <input type="password" name="password" required placeholder="Enter password" class="w-full px-3.5 py-2.5 rounded-xl bg-[#0c1638]/60 border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-blue-400 transition">
                            </div>

                            <div class="flex items-center justify-between text-[11px]">
                                <label class="flex items-center gap-2 text-slate-300 cursor-pointer">
                                    <input type="checkbox" name="remember" class="rounded bg-[#0c1638] border-white/20 text-blue-500">
                                    <span>Remember me</span>
                                </label>
                                <a href="#" class="text-slate-400 hover:text-white transition">Forgot password?</a>
                            </div>

                            <button type="submit" class="w-full py-2.5 px-4 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition">
                                Login
                            </button>
                        </form>

                        <div class="space-y-3 pt-1">
                            <div class="relative flex py-1 items-center">
                                <div class="flex-grow border-t border-white/10"></div>
                                <span class="flex-shrink mx-3 text-[10px] text-slate-400">or continue with</span>
                                <div class="flex-grow border-t border-white/10"></div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" class="py-2 px-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-[11px] text-white flex items-center justify-center gap-2 transition">
                                    <img src="{{ asset('images/Google.png') }}" alt="Google Logo" class="w-4 h-4 object-contain">
                                    <span>Google</span>
                                </button>
                                <button type="button" class="py-2 px-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-[11px] text-white flex items-center justify-center gap-2 transition">
                                    <img src="{{ asset('images/Email.png') }}" alt="Email Logo" class="w-4 h-4 object-contain">
                                    <span>Email</span>
                                </button>
                            </div>
                        </div>

                        <p class="md:hidden text-[11px] text-center text-slate-400 pt-2">
                            Don't have an account? 
                            <button type="button" class="btn-toggle text-blue-400 font-medium underline">Register here</button>
                        </p>
                    </div>

                    {{-- 3. OVERLAY SLIDING PANEL --}}
                    <div class="overlay-container">
                        <div class="overlay">
                            
                            {{-- Panel Kiri (Terlihat saat di Mode Register) --}}
                            <div class="overlay-panel overlay-left">
                                <h2 class="text-2xl font-extrabold text-white">Already Have An Account?</h2>
                                <p class="text-xs text-slate-200 mt-2 mb-6 max-w-[200px] mx-auto leading-relaxed">Login with your personal info to stay connected with us</p>
                                <button type="button" class="btn-toggle px-6 py-2.5 rounded-xl border border-white/30 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs backdrop-blur-md transition">
                                    Login Here
                                </button>
                            </div>

                            {{-- Panel Kanan (Terlihat saat di Mode Login) --}}
                            <div class="overlay-panel overlay-right">
                                <h2 class="text-2xl font-extrabold text-white">Hello, Friend!</h2>
                                <p class="text-xs text-slate-200 mt-2 mb-6 max-w-[200px] mx-auto leading-relaxed">Enter your personal details and start your journey with VetenCall</p>
                                <button type="button" class="btn-toggle px-6 py-2.5 rounded-xl border border-white/30 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs backdrop-blur-md transition">
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