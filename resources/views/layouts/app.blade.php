<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VetenCall')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
        
        {{-- Ambient Background Effects --}}
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" class="absolute -bottom-48 -left-48 w-[850px] max-w-none opacity-10 pointer-events-none select-none z-0">
        <div class="absolute -bottom-24 -right-24 w-[600px] h-[600px] bg-blue-600/30 rounded-full blur-[160px] pointer-events-none"></div>

        {{-- SIDEBAR TERPUSAT --}}
        @include('layouts.sidebar')

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            
            {{-- HEADER BAR TERPUSAT --}}
            <header class="h-20 border-b border-white/10 px-6 md:px-10 flex items-center justify-between bg-white/[0.02] backdrop-blur-xl sticky top-0 z-30">
                <div class="flex-1"></div>
                <div class="flex items-center gap-4">
                    {{-- Search Input --}}
                    <div class="hidden lg:flex items-center bg-[#070d1f]/60 border border-white/10 rounded-xl px-3.5 py-2 w-64 text-xs text-slate-300">
                        <svg class="w-4 h-4 text-slate-400 mr-2 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" placeholder="Search Campaigns, SMS, WA...." class="bg-transparent border-none focus:outline-none w-full text-white placeholder-slate-400 text-xs">
                    </div>

                    {{-- User Profile --}}
                    <div class="flex items-center gap-3 pl-3 border-l border-white/10">
                        <div class="text-right hidden sm:block">
                            <span class="block text-xs font-bold text-white leading-none">Username</span>
                            <span class="text-[10px] text-emerald-400 font-medium">Online</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-600/30 border border-blue-400/30 flex items-center justify-center font-bold text-xs text-white shadow-md">
                            SU
                        </div>
                    </div>
                </div>
            </header>

            {{-- CONTENT DYNAMIC --}}
            <div class="p-6 md:p-10 space-y-6 max-w-[1600px] w-full mx-auto pb-20">
                @yield('content')
            </div>

        </main>
    </div>

    @stack('scripts')
</body>
</html>