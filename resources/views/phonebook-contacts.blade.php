<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetenCall - {{ $phonebook->name }} Contacts</title>
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
                <div class="flex items-center gap-3">
                    <a href="{{ route('phonebook') }}" class="text-slate-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-white tracking-tight">{{ $phonebook->name }}</h1>
                        <p class="text-xs text-slate-300">{{ $contacts->count() }} kontak terdaftar{{ $phonebook->description ? ' · '.$phonebook->description : '' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="document.getElementById('add-contact-modal').classList.remove('hidden')"
                            class="flex items-center gap-2 px-4 py-2.5 bg-[#2f6bfd] hover:bg-blue-600 rounded-xl font-semibold text-xs text-white shadow-lg shadow-blue-600/30 transition">
                        + Add Contact
                    </button>
                    <div class="text-right hidden sm:block">
                        <span class="block text-xs font-bold text-white leading-none">Super User</span>
                        <span class="text-[10px] text-emerald-400 font-medium">Online</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-600/40 border border-blue-400/30 flex items-center justify-center font-bold text-xs text-white shadow-md">SU</div>
                </div>
            </header>

            <div class="p-6 md:p-10 space-y-6 max-w-5xl w-full mx-auto pb-20">

                {{-- Alerts --}}
                @if(session('success'))
                <div class="px-5 py-3 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs">✅ {{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="px-5 py-3 rounded-2xl bg-red-500/15 border border-red-500/30 text-red-300 text-xs">❌ {{ session('error') }}</div>
                @endif
                @if($errors->any())
                <div class="px-5 py-3 rounded-2xl bg-red-500/15 border border-red-500/30 text-red-300 text-xs">❌ {{ $errors->first() }}</div>
                @endif

                <div class="bg-white/[0.05] backdrop-blur-2xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-bold text-white">Daftar Kontak</h3>
                        <span class="text-xs text-slate-400">{{ $contacts->count() }} kontak</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-300">
                            <thead class="text-[10px] uppercase bg-white/5 text-slate-400">
                                <tr>
                                    <th class="p-3.5">#</th>
                                    <th class="p-3.5">Nama</th>
                                    <th class="p-3.5">Nomor HP</th>
                                    <th class="p-3.5">Ditambahkan</th>
                                    <th class="p-3.5">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($contacts as $i => $contact)
                                <tr class="hover:bg-white/[0.02] transition">
                                    <td class="p-3.5 text-slate-500">{{ $i + 1 }}</td>
                                    <td class="p-3.5 font-medium text-white">{{ $contact->name }}</td>
                                    <td class="p-3.5 font-mono text-emerald-300">+{{ $contact->phone }}</td>
                                    <td class="p-3.5 text-slate-400">{{ $contact->created_at?->format('d M Y') }}</td>
                                    <td class="p-3.5">
                                        <form method="POST" action="{{ route('phonebook.contacts.destroy', [$phonebook, $contact]) }}"
                                              onsubmit="return confirm('Hapus kontak {{ $contact->name }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 text-[10px] font-semibold transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-slate-500">
                                        <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                        <p class="text-sm font-medium">Belum ada kontak</p>
                                        <p class="text-xs mt-1">Klik <strong>+ Add Contact</strong> untuk menambahkan kontak</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- MODAL ADD CONTACT --}}
    <div id="add-contact-modal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-50 flex items-center justify-center hidden">
        <div class="bg-[#0c1638] border border-white/15 rounded-3xl p-8 max-w-md w-full space-y-5 shadow-2xl relative">
            <button onclick="document.getElementById('add-contact-modal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-white font-bold text-sm">✕</button>
            <div>
                <h3 class="text-lg font-bold text-white">Tambah Kontak</h3>
                <p class="text-xs text-slate-300 mt-1">Tambahkan kontak ke grup <strong>{{ $phonebook->name }}</strong>.</p>
            </div>
            <form method="POST" action="{{ route('phonebook.contacts.store', $phonebook) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nama <span class="text-red-400">*</span></label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Nama kontak"
                           class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                    @error('name')
                        <span class="text-[10px] text-red-400 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nomor HP <span class="text-red-400">*</span></label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="Contoh: 6281234567890"
                           class="w-full bg-[#070d1f] border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                    <span class="text-[10px] text-slate-400 mt-1 block">Format: kode negara tanpa + atau strip. Contoh: 628123456789</span>
                    @error('phone')
                        <span class="text-[10px] text-red-400 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('add-contact-modal').classList.add('hidden')"
                            class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-xs text-slate-300 font-semibold transition">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#2f6bfd] hover:bg-blue-600 text-xs text-white font-semibold shadow-lg transition">
                        Simpan Kontak
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($errors->any())
    <script>document.getElementById('add-contact-modal').classList.remove('hidden');</script>
    @endif
</body>
</html>
