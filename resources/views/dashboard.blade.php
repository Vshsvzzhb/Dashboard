<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - Dashboard</title>
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
        
        {{-- Watermark Background --}}
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" class="absolute -bottom-48 -left-48 w-[850px] max-w-none opacity-10 pointer-events-none select-none z-0">
        <div class="absolute -bottom-24 -right-24 w-[600px] h-[600px] bg-blue-600/30 rounded-full blur-[160px] pointer-events-none"></div>

        {{-- MEMANGGIL SIDEBAR TERPUSAT --}}
        @include('layouts.sidebar')

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            
            {{-- HEADER BAR --}}
            <header class="h-20 border-b border-white/10 px-6 md:px-10 flex items-center justify-between bg-white/[0.02] backdrop-blur-xl sticky top-0 z-30">
                <div class="flex-1"></div>
                <div class="flex items-center gap-4">
                    {{-- Search Input --}}
                    <div class="hidden lg:flex items-center bg-[#070d1f]/60 border border-white/10 rounded-xl px-3 py-2 w-64 text-xs text-slate-300">
                        <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
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

            {{-- DASHBOARD CONTENT --}}
            <div class="p-6 md:p-10 space-y-6 max-w-[1600px] w-full mx-auto pb-20">
                
                {{-- PAGE TITLE & TOP ACTION BUTTONS --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-white tracking-tight">Dashboard</h1>
                        <p class="text-xs text-slate-400 mt-1">Realtime Monitoring for WhatsApp & SMS</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('sms.campaigns') }}" class="px-5 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-600/30 transition text-center">
                            SMS Blast
                        </a>
                        <a href="{{ route('campaigns') }}" class="px-5 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-600/30 transition text-center">
                            WA Campaign
                        </a>
                    </div>
                </div>

                {{-- MAIN GRID LAYOUT --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    {{-- LEFT COLUMN --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        {{-- 3 STAT CARDS --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div class="bg-white/[0.04] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between space-y-2">
                                <h3 class="text-lg font-bold text-slate-200">Contacts</h3>
                                <span class="text-5xl font-black text-white tracking-tight">{{ $totalContacts ?? 0 }}</span>
                            </div>

                            <div class="bg-white/[0.04] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between space-y-2">
                                <h3 class="text-lg font-bold text-slate-200">Contacts WA</h3>
                                <span class="text-5xl font-black text-white tracking-tight">{{ $waContacts ?? 0 }}</span>
                            </div>

                            <div class="bg-white/[0.04] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between space-y-2">
                                <h3 class="text-lg font-bold text-slate-200">Contacts SMS</h3>
                                <span class="text-5xl font-black text-white tracking-tight">{{ $smsContacts ?? 0 }}</span>
                            </div>
                        </div>

                        {{-- CHART.JS BAR CHART CONTAINER --}}
                        <div class="bg-white/[0.04] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl">
                            <div class="h-60 w-full relative">
                                <canvas id="weeklyChart"></canvas>
                            </div>
                        </div>

                        {{-- TEAM COLLABORATION PANEL --}}
                        <div class="bg-white/[0.04] backdrop-blur-2xl border border-white/10 rounded-3xl p-8 shadow-2xl min-h-[260px] flex flex-col justify-between">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-bold text-white">Team Collaboration</h2>
                                <button class="px-5 py-2 border border-blue-500/40 text-blue-300 hover:bg-blue-600/20 rounded-full font-semibold text-xs transition">
                                    Add
                                </button>
                            </div>

                            <div class="flex items-center justify-center py-10 text-slate-500 text-xs font-medium">
                                Belum ada tim ditambahkan. Klik "Add" untuk menambahkan anggota.
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT COLUMN (HISTORY PANEL) --}}
                    <div class="bg-white/[0.04] backdrop-blur-2xl border border-white/10 rounded-3xl p-8 shadow-2xl flex flex-col justify-between min-h-[500px]">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-white tracking-tight">History</h2>
                            <button class="px-5 py-2 border border-blue-500/40 text-blue-300 hover:bg-blue-600/20 rounded-full font-semibold text-xs transition">
                                New
                            </button>
                        </div>

                        <div class="flex-1 flex items-center justify-center text-slate-500 text-xs font-medium">
                            Riwayat aktivitas akan muncul di sini.
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    {{-- CHART.JS INITIALIZATION --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('weeklyChart').getContext('2d');
            
            // Menggunakan json_encode PHP secara langsung agar terbebas dari ParseError Blade
            const rawData = <?php echo json_encode($weeklyData ?? [120, 80, 180, 40, 100, 90, 150]); ?>;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
                    datasets: [{
                        label: 'Messages Sent',
                        data: rawData,
                        backgroundColor: '#ffffff',
                        borderSkipped: false,
                        borderRadius: 12,
                        barThickness: 36
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0c1638',
                            borderColor: 'rgba(255, 255, 255, 0.2)',
                            borderWidth: 1,
                            titleColor: '#ffffff',
                            bodyColor: '#38bdf8'
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#cbd5e1', font: { family: 'Inter', weight: 'bold' } }
                        },
                        y: {
                            display: false,
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>