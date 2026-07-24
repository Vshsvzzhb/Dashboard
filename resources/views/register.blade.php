<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - Create Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#0a1128] text-white antialiased">

    {{-- Main Wrapper dengan Gradient & Glow Effect --}}
    <div class="min-h-screen bg-gradient-to-br from-[#0c1638] via-[#0d1844] to-[#1a2f8a] flex items-center justify-center p-6 md:p-12 relative overflow-hidden">
        
        {{-- Watermark Logo Veten Jumbo & Setengah Terpotong di Kiri Bawah --}}
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" 
             class="absolute -bottom-48 -left-48 w-[850px] max-w-none opacity-10 pointer-events-none select-none z-0">

        {{-- Glow Effect Pojok Kanan Bawah --}}
        <div class="absolute -bottom-24 -right-24 w-[600px] h-[600px] bg-blue-600/30 rounded-full blur-[160px] pointer-events-none"></div>

        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center z-10 my-auto relative">
            
            {{-- KIRI: BRANDING & 3 FEATURE CARDS --}}
            <div class="lg:col-span-6 space-y-10">
                
                {{-- Logo VetenCall --}}
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall Logo" class="h-10 w-auto object-contain">
                    <span class="text-2xl font-bold tracking-tight text-white">VetenCall</span>
                </div>

                {{-- Heading & Subtitle --}}
                <div class="space-y-4">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-[1.12]">
                        One Dashboard<br>
                        <span class="text-white">WhatsApp & SMS</span>
                    </h1>
                    <p class="text-slate-300/80 text-sm leading-relaxed max-w-sm">
                        Effortlessly manage, automate, and track your WhatsApp and SMS campaigns from a single, powerful platform.
                    </p>
                </div>

                {{-- 3 Feature Boxes --}}
                <div class="grid grid-cols-3 gap-4 pt-2">
                    
                    <div class="p-5 rounded-2xl bg-white/[0.06] backdrop-blur-md border border-white/10 flex flex-col items-center text-center space-y-4 hover:bg-white/[0.1] transition">
                        <img src="{{ asset('images/Kalender.png') }}" alt="Schedule Campaigns" class="w-16 h-16 object-contain">
                        <span class="text-xs font-semibold text-slate-200 leading-tight">Schedule<br>Campaigns</span>
                    </div>

                    <div class="p-5 rounded-2xl bg-white/[0.06] backdrop-blur-md border border-white/10 flex flex-col items-center text-center space-y-4 hover:bg-white/[0.1] transition">
                        <img src="{{ asset('images/Pesan.png') }}" alt="Automate Responses" class="w-16 h-16 object-contain">
                        <span class="text-xs font-semibold text-slate-200 leading-tight">Automate<br>Responses</span>
                    </div>

                    <div class="p-5 rounded-2xl bg-white/[0.06] backdrop-blur-md border border-white/10 flex flex-col items-center text-center space-y-4 hover:bg-white/[0.1] transition">
                        <img src="{{ asset('images/Tangan.png') }}" alt="Build Partnerships" class="w-16 h-16 object-contain">
                        <span class="text-xs font-semibold text-slate-200 leading-tight">Build<br>Partnerships</span>
                    </div>

                </div>
            </div>

            {{-- KANAN: FORM REGISTER ONLY --}}
            <div class="lg:col-span-6 bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-8 sm:p-10 shadow-2xl">
                <div class="space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Create Account</h2>
                        <p class="text-xs text-slate-400 mt-1">Register to get started</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Full Name</label>
                            <input type="text" name="name" required placeholder="Enter your full name" class="w-full px-3.5 py-2.5 rounded-xl bg-[#0c1638]/60 border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-blue-400 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Email</label>
                            <input type="email" name="email" required placeholder="Enter your email" class="w-full px-3.5 py-2.5 rounded-xl bg-[#0c1638]/60 border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-blue-400 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Password</label>
                            <input type="password" name="password" required placeholder="Create a password" class="w-full px-3.5 py-2.5 rounded-xl bg-[#0c1638]/60 border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-blue-400 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" required placeholder="Confirm your password" class="w-full px-3.5 py-2.5 rounded-xl bg-[#0c1638]/60 border border-white/10 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-blue-400 transition">
                        </div>

                        <div class="flex items-start gap-2 pt-1">
                            <input type="checkbox" name="terms" required class="mt-0.5 rounded bg-[#0c1638] border-white/20 text-blue-500">
                            <span class="text-[10px] text-slate-400 leading-tight">
                                I agree to the <a href="#" class="text-blue-400 underline">Terms of Service</a> and <a href="#" class="text-blue-400 underline">Privacy Policy</a>
                            </span>
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition">
                            Register
                        </button>
                    </form>

                    <p class="text-[11px] text-center text-slate-400 pt-1">
                        Already have an account? <a href="{{ route('login.page') }}" class="text-blue-400 font-medium hover:underline">Login here</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>