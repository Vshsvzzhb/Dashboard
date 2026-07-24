import React, { useState } from 'react';
import { 
  Search, 
  Plus, 
  Send, 
  TrendingUp, 
  UserPlus, 
  CheckCircle2, 
  Clock, 
  ChevronDown 
} from 'lucide-react';

export default function Dashboard() {
  const [timeRange, setTimeRange] = useState('Minggu Ini');

  // Sample data untuk chart
  const weeklyData = [
    { day: 'S', value: 50 },
    { day: 'M', value: 40 },
    { day: 'T', value: 90, active: true },
    { day: 'W', value: 25 },
    { day: 'T', value: 60 },
    { day: 'F', value: 55 },
    { day: 'S', value: 80 },
  ];

  return (
    <div class="min-h-screen bg-slate-950 text-slate-100 p-4 md:p-6 antialiased font-sans">
      <div class="max-w-7xl mx-auto space-y-6">

        {/* --- HEADER --- */}
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-800">
          <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Dashboard</h1>
            <p class="text-xs text-slate-400 mt-1">
              Realtime Monitoring for WhatsApp & SMS Campaigns
            </p>
          </div>

          <div class="flex flex-wrap items-center gap-3">
            {/* Search Input */}
            <div class="relative w-full sm:w-64">
              <Search class="w-4 h-4 absolute left-2.5 top-2.5 text-slate-500" />
              <input
                type="text"
                placeholder="Cari Campaign, SMS, WA..."
                class="w-full bg-slate-900 border border-slate-800 rounded-lg text-xs py-2 pl-8 pr-3 text-slate-200 placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition"
              />
            </div>

            {/* Action Buttons */}
            <div class="flex items-center gap-2">
              <button class="flex items-center gap-1.5 bg-slate-800 hover:bg-slate-700 text-slate-200 px-3 py-2 rounded-lg text-xs font-semibold border border-slate-700 transition">
                <Send class="w-3.5 h-3.5" />
                SMS Blast
              </button>
              <button class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500 text-white px-3 py-2 rounded-lg text-xs font-semibold shadow-lg shadow-indigo-500/20 transition">
                <Plus class="w-3.5 h-3.5" />
                WA Campaign
              </button>
            </div>

            {/* User Profile */}
            <div class="flex items-center gap-2.5 pl-2 border-l border-slate-800">
              <div class="relative">
                <div class="w-8 h-8 rounded-full bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center font-bold text-xs">
                  SU
                </div>
                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-slate-950"></span>
              </div>
              <div class="text-left hidden sm:block">
                <p class="text-xs font-semibold leading-none">Username</p>
                <span class="text-[10px] text-emerald-400 font-medium">Online</span>
              </div>
            </div>
          </div>
        </header>

        {/* --- MAIN GRID --- */}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          {/* LEFT COLUMN */}
          <div class="lg:col-span-2 space-y-6">

            {/* TOP STAT CARDS */}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              {/* Card 1 */}
              <div class="bg-slate-900/80 backdrop-blur-sm border border-slate-800 p-4 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-2">
                  <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">
                    Total Contacts
                  </span>
                  <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-400 bg-emerald-500/10 px-1.5 py-0.5 rounded">
                    <TrendingUp class="w-3 h-3" />
                    +12%
                  </span>
                </div>
                <p class="text-2xl font-bold text-white">120</p>
              </div>

              {/* Card 2 */}
              <div class="bg-slate-900/80 backdrop-blur-sm border border-slate-800 p-4 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-2">
                  <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">
                    Contacts WA
                  </span>
                  <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-400 bg-emerald-500/10 px-1.5 py-0.5 rounded">
                    <TrendingUp class="w-3 h-3" />
                    +8%
                  </span>
                </div>
                <p class="text-2xl font-bold text-white">60</p>
              </div>

              {/* Card 3 */}
              <div class="bg-slate-900/80 backdrop-blur-sm border border-slate-800 p-4 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-2">
                  <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">
                    Contacts SMS
                  </span>
                  <span class="text-[10px] font-semibold text-slate-400 bg-slate-800 px-1.5 py-0.5 rounded">
                    0%
                  </span>
                </div>
                <p class="text-2xl font-bold text-white">60</p>
              </div>
            </div>

            {/* CHART SECTION */}
            <div class="bg-slate-900/80 backdrop-blur-sm border border-slate-800 p-5 rounded-xl">
              <div class="flex justify-between items-center mb-6">
                <div>
                  <h3 class="text-sm font-semibold text-white">Aktivitas Mingguan</h3>
                  <p class="text-xs text-slate-400">Jumlah pesan terkirim per hari</p>
                </div>
                <div class="relative">
                  <select
                    value={timeRange}
                    onChange={(e) => setTimeRange(e.target.value)}
                    class="bg-slate-800 border border-slate-700 text-xs text-slate-300 rounded-md pl-2.5 pr-7 py-1 focus:outline-none appearance-none cursor-pointer"
                  >
                    <option>Minggu Ini</option>
                    <option>Minggu Lalu</option>
                  </select>
                  <ChevronDown class="w-3.5 h-3.5 text-slate-400 absolute right-2 top-1.5 pointer-events-none" />
                </div>
              </div>

              {/* Bar Chart Visual */}
              <div class="h-48 flex items-end justify-between gap-3 pt-6 border-b border-slate-800 px-2">
                {weeklyData.map((item, index) => (
                  <div key={index} class="flex-1 flex flex-col items-center gap-2 group h-full justify-end">
                    <div
                      style={{ height: `${item.value}%` }}
                      class={`w-full rounded-t-md transition-all duration-300 relative ${
                        item.active
                          ? 'bg-indigo-500 shadow-lg shadow-indigo-500/20 group-hover:bg-indigo-400'
                          : 'bg-indigo-600/30 group-hover:bg-indigo-500'
                      }`}
                    >
                      {/* Tooltip Hover */}
                      <div class="opacity-0 group-hover:opacity-100 transition-opacity absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-slate-200 text-[10px] font-semibold px-2 py-0.5 rounded shadow border border-slate-700 pointer-events-none">
                        {item.value}
                      </div>
                    </div>
                    <span
                      class={`text-xs ${
                        item.active ? 'font-semibold text-indigo-400' : 'text-slate-400'
                      }`}
                    >
                      {item.day}
                    </span>
                  </div>
                ))}
              </div>
            </div>

            {/* TEAM COLLABORATION */}
            <div class="bg-slate-900/80 backdrop-blur-sm border border-slate-800 p-5 rounded-xl">
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-semibold text-white">Team Collaboration</h3>
                <button class="flex items-center gap-1.5 bg-slate-800 hover:bg-slate-700 text-xs font-semibold px-3 py-1.5 rounded-md border border-slate-700 transition">
                  <UserPlus class="w-3.5 h-3.5 text-slate-400" />
                  Add Member
                </button>
              </div>
              <div class="flex flex-col items-center justify-center py-6 border border-dashed border-slate-800 rounded-lg">
                <p class="text-xs text-slate-400">Belum ada tim ditambahkan.</p>
                <button class="mt-2 text-xs text-indigo-400 hover:underline font-medium">
                  Undang rekan kerja
                </button>
              </div>
            </div>

          </div>

          {/* RIGHT COLUMN (HISTORY LOG) */}
          <div class="bg-slate-900/80 backdrop-blur-sm border border-slate-800 p-5 rounded-xl flex flex-col justify-between">
            <div>
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-semibold text-white">History & Log</h3>
                <button class="text-xs text-indigo-400 hover:text-indigo-300 font-medium transition">
                  Lihat Semua
                </button>
              </div>

              {/* Timeline List */}
              <div class="space-y-3">
                <div class="flex items-start gap-3 p-3 rounded-lg bg-slate-950/50 border border-slate-800/60 hover:border-slate-700 transition">
                  <CheckCircle2 class="w-4 h-4 text-emerald-400 mt-0.5 shrink-0" />
                  <div>
                    <p class="text-xs font-medium text-slate-200">
                      Campaign WA "Promo Juli" Terkirim
                    </p>
                    <p class="text-[10px] text-slate-500 mt-0.5">
                      60 kontak • Hari ini, 14:30
                    </p>
                  </div>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-lg bg-slate-950/50 border border-slate-800/60 hover:border-slate-700 transition">
                  <CheckCircle2 class="w-4 h-4 text-indigo-400 mt-0.5 shrink-0" />
                  <div>
                    <p class="text-xs font-medium text-slate-200">
                      Broadcast SMS Selesai
                    </p>
                    <p class="text-[10px] text-slate-500 mt-0.5">
                      60 kontak • Kemarin, 09:15
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-800/80 flex items-center justify-center gap-1.5 text-slate-500 text-[11px]">
              <Clock class="w-3.5 h-3.5" />
              <span>Riwayat sinkronisasi secara realtime</span>
            </div>
          </div>

        </div>
      </div>
    </div>
  );
}