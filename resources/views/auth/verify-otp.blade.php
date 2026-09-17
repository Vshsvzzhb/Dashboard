<!DOCTYPE html>
<html lang="id">
<head>
<script>
    if (localStorage.theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - Verifikasi OTP</title>
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
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow: 0 25px 60px -15px rgba(15, 35, 75, 0.12), 
                        0 10px 25px -10px rgba(15, 35, 75, 0.06);
            border: none !important;
            outline: none !important;
        }

        .otp-input {
            letter-spacing: 12px;
            font-family: 'Outfit', monospace;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            border: none !important;
            outline: none !important;
            box-shadow: 0 4px 14px -2px rgba(15, 35, 75, 0.05);
            transition: all 0.2s ease-in-out;
        }

        .otp-input:focus {
            box-shadow: 0 8px 24px -4px rgba(47, 107, 253, 0.18), 0 0 0 1px rgba(47, 107, 253, 0.08) !important;
            background-color: #ffffff !important;
        }

        /* Dark Mode */
        html.dark body { background-color: #070d1f !important; color: #f1f5f9 !important; }
        html.dark .min-h-screen { background: linear-gradient(to bottom right, #070d1f, #0c1638, #12182e) !important; }
        html.dark .auth-container {
            background: rgba(18, 24, 46, 0.95) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7) !important;
        }
        html.dark .text-slate-800 { color: #f8fafc !important; }
        html.dark .text-slate-700 { color: #cbd5e1 !important; }
        html.dark .text-slate-500 { color: #94a3b8 !important; }
        html.dark input {
            background-color: #0d152e !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
        html.dark input::placeholder { color: #64748b !important; }
        html.dark .otp-input:focus { background-color: #111b38 !important; }
    </style>
</head>
<body class="bg-[#edf2f7] text-slate-800 antialiased selection:bg-blue-500 selection:text-white">

    {{-- Main Wrapper --}}
    <div class="min-h-screen bg-gradient-to-br from-[#f0f4f9] via-[#e8eef6] to-[#dbe8f8] flex items-center justify-center p-6 md:p-12 relative overflow-hidden">
        
        {{-- Watermark Logo Veten Jumbo di Kiri Bawah (Blur) --}}
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" 
             class="absolute -bottom-48 -left-48 w-[850px] max-w-none pointer-events-none select-none z-0"
             style="filter: blur(6px);">

        <div class="max-w-md w-full auth-container p-8 sm:p-10 relative z-10 space-y-6">
            
            {{-- Header with Logo & Brand --}}
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-2.5 justify-center">
                    <img src="{{ asset('images/VetenAplikasi.png') }}" alt="VetenCall Logo" class="h-9 w-auto object-contain drop-shadow-sm">
                    <span class="text-2xl font-bold tracking-tight text-[#2f6bfd]">VetenCall</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Verifikasi Akun</h2>
                    <p class="text-xs text-slate-500 mt-1.5 font-normal leading-relaxed">
                        Masukkan 6 digit kode OTP yang telah dikirimkan ke:
                    </p>
                    <div class="mt-2.5 flex flex-wrap items-center justify-center gap-2">
                        @if(session('pending_user.phone'))
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-slate-700 bg-white/90 shadow-[0_2px_8px_-2px_rgba(15,35,75,0.08)] px-3 py-1.5 rounded-xl">
                                <svg class="w-3.5 h-3.5 text-[#2f6bfd]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ session('pending_user.phone') }}
                            </span>
                        @endif
                        @if(session('pending_user.email'))
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-slate-700 bg-white/90 shadow-[0_2px_8px_-2px_rgba(15,35,75,0.08)] px-3 py-1.5 rounded-xl">
                                <svg class="w-3.5 h-3.5 text-[#2f6bfd]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ session('pending_user.email') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="p-3.5 rounded-xl bg-emerald-500/10 text-emerald-700 text-xs font-medium shadow-[0_2px_10px_-2px_rgba(16,185,129,0.15)] flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="p-3.5 rounded-xl bg-red-500/10 text-red-600 text-xs font-medium shadow-[0_2px_10px_-2px_rgba(239,68,68,0.15)]">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(app()->isLocal() && session('pending_user.otp'))
                <div class="p-3 rounded-2xl bg-white/90 shadow-[0_4px_16px_-4px_rgba(15,35,75,0.08)] text-slate-600 text-xs flex items-center justify-between">
                    <span class="text-[11px] font-medium text-slate-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                        Demo OTP: <strong class="text-[#2f6bfd] font-mono font-bold tracking-wider text-xs ml-1">{{ session('pending_user.otp') }}</strong>
                    </span>
                    <button type="button" onclick="document.querySelector('input[name=otp]').value='{{ session('pending_user.otp') }}'" class="px-3 py-1 bg-[#2f6bfd] hover:bg-blue-600 text-white rounded-xl font-semibold text-[10px] shadow-sm hover:shadow transition cursor-pointer">Auto Fill</button>
                </div>
            @endif

            {{-- Verification Form --}}
            <form action="{{ route('verify-otp.process') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-2 text-center">Kode OTP (6 Digit)</label>
                    <input type="text" name="otp" maxlength="6" pattern="[0-9]{6}" required autocomplete="one-time-code" autofocus
                        placeholder="••••••"
                        class="w-full py-3.5 px-4 rounded-2xl bg-slate-100/90 text-slate-800 placeholder-slate-400 otp-input transition">
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/25 hover:shadow-blue-600/35 transition cursor-pointer" style="border: none !important;">
                    Verifikasi & Masuk
                </button>
            </form>

            {{-- Resend Section & Back Link --}}
            <div class="pt-2 text-center space-y-2">
                <form action="{{ route('resend-otp') }}" method="POST">
                    @csrf
                    <p class="text-xs text-slate-500">
                        Tidak menerima kode? 
                        <button type="submit" class="text-[#2f6bfd] hover:underline font-semibold bg-transparent border-none p-0 cursor-pointer">Kirim Ulang OTP</button>
                    </p>
                </form>

                <p class="text-[11px] text-slate-400">
                    Salah data? <a href="{{ route('login.page') }}" class="text-[#2f6bfd] font-semibold hover:underline">Daftar ulang</a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>
