<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - WhatsApp Phonebook</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#0c1638] text-white antialiased">

    <div class="min-h-screen bg-gradient-to-br from-[#0c1638] via-[#0d1844] to-[#1a2f8a] flex relative overflow-hidden">
        <img src="{{ asset('images/VetenAplikasi.png') }}" alt="" class="absolute -bottom-48 -left-48 w-[850px] max-w-none opacity-10 pointer-events-none select-none z-0">
        <div class="absolute -bottom-24 -right-24 w-[600px] h-[600px] bg-blue-600/30 rounded-full blur-[160px] pointer-events-none"></div>

        @include('layouts.sidebar')

        <main class="flex-1 flex flex-col min-w-0 z-10 overflow-y-auto">
            <header class="h-20 border-b border-white/10 px-6 md:px-10 flex items-center justify-between bg-white/[0.02] backdrop-blur-xl sticky top-0 z-30">
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">WhatsApp Phonebook Manager</h1>
                    <p class="text-xs text-slate-300">Manage your contact groups for WhatsApp campaigns.</p>
                </div>
                <div class="flex items-center gap-3 pl-3 border-l border-white/10">
                    <div class="text-right hidden sm:block">
                        <span class="block text-xs font-bold text-white leading-none">Super User</span>
                        <span class="text-[10px] text-emerald-400 font-medium">Online</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-600/40 border border-blue-400/30 flex items-center justify-center font-bold text-xs text-white shadow-md">SU</div>
                </div>
            </header>

            <div class="p-6 md:p-10 space-y-6 max-w-7xl w-full mx-auto pb-20">

                {{-- Alerts --}}
                @if(session('success'))
                <div class="px-5 py-3 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-2">
                    ✅ {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="px-5 py-3 rounded-2xl bg-red-500/15 border border-red-500/30 text-red-300 text-xs flex items-center gap-2">
                    ❌ {{ session('error') }}
                </div>
                @endif

                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-white">Contact Groups</h2>
                        <p class="text-xs text-slate-300">Total {{ $phonebooks->count() }} phonebook groups available.</p>
                    </div>
                    <button onclick="document.getElementById('add-modal').classList.remove('hidden')"
                            class="flex items-center gap-2 px-5 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition">
                        + Add Phonebook
                    </button>
                </div>

                {{-- Grid Phonebooks --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($phonebooks as $pb)
                    <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="w-10 h-10 rounded-2xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            {{-- Delete button --}}
                            <form method="POST" action="{{ route('phonebook.destroy', $pb) }}"
                                  onsubmit="return confirm('Hapus phonebook \'{{ $pb->name }}\' beserta semua kontaknya?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-500 hover:text-red-400 transition px-2 py-1 text-xs">✕</button>
                            </form>
                        </div>

                        <div class="space-y-1">
                            <h3 class="text-base font-bold text-white">{{ $pb->name }}</h3>
                            @if($pb->description)
                                <p class="text-[10px] text-slate-400">{{ $pb->description }}</p>
                            @endif
                            <p class="text-xs text-emerald-400 font-medium">{{ $pb->contacts_count }} contact{{ $pb->contacts_count != 1 ? 's' : '' }} registered</p>
                            <p class="text-[11px] text-slate-400 pt-1">Owner: VetenCall (Me)</p>
                        </div>

                        <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                            <a href="{{ route('phonebook.contacts', $pb) }}" class="text-blue-400 hover:underline font-semibold">Manage Contacts →</a>
                            <span class="text-[10px] text-slate-400">WhatsApp Group</span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 py-16 text-center text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                        <p class="text-sm font-medium">Belum ada phonebook</p>
                        <p class="text-xs mt-1">Klik <strong>+ Add Phonebook</strong> untuk membuat grup kontak pertama</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    {{-- MODAL ADD PHONEBOOK --}}
    <div id="add-modal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-50 flex items-center justify-center hidden">
        <div class="bg-[#0c1638] border border-white/15 rounded-3xl p-8 max-w-md w-full space-y-5 shadow-2xl relative">
            <button onclick="document.getElementById('add-modal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-white font-bold text-sm">✕</button>
            <div>
                <h3 class="text-lg font-bold text-white">Add New Phonebook Group</h3>
                <p class="text-xs text-slate-300 mt-1">Buat grup kontak baru untuk campaign WhatsApp.</p>
            </div>
            <form method="POST" action="{{ route('phonebook.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Group Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Reseller VIP"
                           class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Description</label>
                    <textarea name="description" rows="2" placeholder="Keterangan grup kontak..."
                              class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')"
                            class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-xs text-slate-300 font-semibold transition">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#2f6bfd] hover:bg-blue-600 text-xs text-white font-semibold shadow-lg transition">
                        Save Group
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>