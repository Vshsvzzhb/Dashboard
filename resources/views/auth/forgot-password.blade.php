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
    <title>VetenCall - Lupa Password</title>
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
                    <h2 class="text-2xl font-bold text-slate-800">Lupa Password?</h2>
                    <p class="text-xs text-slate-500 mt-1.5 font-normal leading-relaxed">
                        Masukkan email akun Anda. Kami akan mengirimkan 6 digit kode OTP ke email untuk mereset password Anda.
                    </p>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('status'))
                <div class="p-3.5 rounded-xl bg-emerald-500/10 text-emerald-700 text-xs font-medium shadow-[0_2px_10px_-2px_rgba(16,185,129,0.15)] flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="p-3.5 rounded-xl bg-red-500/10 text-red-600 text-xs font-medium shadow-[0_2px_10px_-2px_rgba(239,68,68,0.15)]">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form Request OTP --}}
            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Alamat Email Terdaftar</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="contoh: user@gmail.com"
                        class="w-full py-3 px-4 rounded-xl bg-slate-100/90 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-[#2f6bfd]/30 focus:bg-white transition"
                        style="border: none !important;">
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/25 hover:shadow-blue-600/35 transition cursor-pointer" style="border: none !important;">
                    Kirim Kode OTP ke Email
                </button>
            </form>

            {{-- Back Link --}}
            <div class="pt-2 text-center">
                <a href="{{ route('login.page') }}" class="text-xs text-[#2f6bfd] font-semibold hover:underline inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Halaman Login
                </a>
            </div>

        </div>
    </div>

</body>
</html>
