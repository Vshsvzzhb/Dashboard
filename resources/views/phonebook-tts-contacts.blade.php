@extends('layouts.app')

@section('title', 'VetenCall - ' . $phonebook->name . ' VoIP Contacts')
@section('page-title', $phonebook->name . ' Contacts')

@section('content')
<div class="space-y-6 max-w-7xl w-full mx-auto pb-10">

    {{-- Header / Action --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('tts.phonebook') }}" class="nm-btn p-2.5 rounded-xl opacity-70 hover:opacity-100 transition flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h2 class="text-lg font-bold text-slate-800 dark:text-white">{{ $phonebook->name }}</h2>
                <p class="text-xs opacity-50 mt-0.5">{{ $contacts->count() }} kontak / ekstensi VoIP terdaftar</p>
            </div>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('tts.phonebook.contacts.export', $phonebook) }}" class="px-4 py-2 rounded-xl bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:hover:bg-white/10 border border-black/10 dark:border-white/10 text-slate-700 dark:text-slate-200 text-xs font-semibold flex items-center gap-1.5 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Export CSV
            </a>
            <button onclick="document.getElementById('import-contact-modal').classList.remove('hidden')" class="px-4 py-2 rounded-xl bg-violet-500/10 hover:bg-violet-500/20 border border-violet-500/20 text-violet-600 dark:text-violet-400 text-xs font-bold flex items-center gap-1.5 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                Import CSV
            </button>
            <button onclick="document.getElementById('add-contact-modal').classList.remove('hidden')"
                    class="nm-btn-brand px-5 py-2.5 rounded-xl font-bold text-xs text-white transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14m-7-7h14"/></svg>
                + Tambah Kontak / Ekstensi
            </button>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="px-5 py-3 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-xs"> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="px-5 py-3 rounded-2xl bg-red-500/15 border border-red-500/30 text-red-600 dark:text-red-400 text-xs"> {{ session('error') }}</div>
    @endif
    @if(isset($errors) && $errors->any())
    <div class="px-5 py-3 rounded-2xl bg-red-500/15 border border-red-500/30 text-red-600 dark:text-red-400 text-xs"> {{ $errors->first() }}</div>
    @endif

    <div class="nm-card p-6 sm:p-8 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Daftar Kontak & Ekstensi VoIP</h3>
            <span class="text-xs opacity-50">{{ $contacts->count() }} kontak</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs mt-1 border-collapse">
                <thead class="text-[10px] uppercase bg-black/5 dark:bg-white/5 opacity-60">
                    <tr>
                        <th class="p-3.5 rounded-l-xl">#</th>
                        <th class="p-3.5">Nama</th>
                        <th class="p-3.5">Nomor / Ekstensi</th>
                        <th class="p-3.5">Ditambahkan</th>
                        <th class="p-3.5 rounded-r-xl text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $i => $contact)
                    <tr class="hover:bg-black/[0.02] dark:hover:bg-white/[0.02] transition border-b border-black/[0.02] dark:border-white/[0.02]">
                        <td class="p-3.5 opacity-40">{{ $i + 1 }}</td>
                        <td class="p-3.5 font-semibold text-slate-800 dark:text-white">{{ $contact->name }}</td>
                        <td class="p-3.5 font-mono text-violet-600 dark:text-violet-400 font-bold">
                            <span class="px-2 py-0.5 bg-violet-500/10 rounded-md border border-violet-500/20">
                                {{ $contact->phone }}
                            </span>
                        </td>
                        <td class="p-3.5 opacity-50">{{ $contact->created_at?->format('d M Y') }}</td>
                        <td class="p-3.5 text-right">
                            <form action="{{ route('tts.phonebook.contacts.destroy', [$phonebook->id, $contact->id]) }}" method="POST" onsubmit="return confirm('Hapus kontak ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <div class="w-12 h-12 rounded-full bg-black/5 dark:bg-white/5 flex items-center justify-center mx-auto mb-3 opacity-60">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <p class="font-semibold text-slate-700 dark:text-slate-300">Belum ada kontak atau ekstensi</p>
                            <p class="text-xs opacity-50 mt-1">Klik "+ Tambah Kontak / Ekstensi" untuk menambahkan ekstensi (contoh: 9999, 101) atau nomor tujuan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Add Contact Modal --}}
<div id="add-contact-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden p-4">
    <div class="nm-card max-w-md w-full p-6 sm:p-8 space-y-5">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-bold">Tambah Kontak / Ekstensi VoIP</h3>
            <button type="button" onclick="document.getElementById('add-contact-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">&times;</button>
        </div>
        <form action="{{ route('tts.phonebook.contacts.store', $phonebook->id) }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-semibold mb-1 opacity-70">Nama / Label</label>
                <input type="text" name="name" placeholder="Contoh: Softphone Supervisor / Ext 9999" 
                       class="w-full px-4 py-2.5 rounded-xl border border-black/10 dark:border-white/10 bg-black/5 dark:bg-white/5 focus:outline-none focus:ring-1 focus:ring-violet-500 text-xs">
            </div>
            <div>
                <label class="block font-semibold mb-1 opacity-70">Nomor Ekstensi / Telepon <span class="text-red-500">*</span></label>
                <input type="text" name="phone" required placeholder="Contoh: 9999 atau 101 atau 08123456789" 
                       class="w-full px-4 py-2.5 rounded-xl border border-black/10 dark:border-white/10 bg-black/5 dark:bg-white/5 focus:outline-none focus:ring-1 focus:ring-violet-500 text-xs font-mono">
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Bisa berupa nomor ekstensi VoIP internal (contoh: <strong>9999</strong>, <strong>101</strong>, <strong>3030</strong>) atau nomor telepon (minimal 3 digit).</p>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('add-contact-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl border border-black/10 dark:border-white/10 opacity-70 hover:opacity-100 font-semibold">Batal</button>
                <button type="submit" class="nm-btn-brand px-5 py-2 rounded-xl text-white font-bold">Simpan Kontak</button>
            </div>
        </form>
    </div>
</div>

{{-- Import Modal --}}
<div id="import-contact-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden p-4">
    <div class="nm-card max-w-md w-full p-6 sm:p-8 space-y-5">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-bold">Import Kontak via CSV</h3>
            <button type="button" onclick="document.getElementById('import-contact-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">&times;</button>
        </div>
        <form action="{{ route('tts.phonebook.contacts.import', $phonebook->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-semibold mb-1 opacity-70">Pilih File CSV (.csv / .txt)</label>
                <input type="file" name="file" required accept=".csv,.txt"
                       class="w-full px-3 py-2 rounded-xl border border-black/10 dark:border-white/10 bg-black/5 dark:bg-white/5 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-violet-500/20 file:text-violet-500">
                <p class="text-[11px] opacity-50 mt-1">Format kolom: <code>Nama, Nomor/Ekstensi</code></p>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('import-contact-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl border border-black/10 dark:border-white/10 opacity-70 hover:opacity-100 font-semibold">Batal</button>
                <button type="submit" class="nm-btn-brand px-5 py-2 rounded-xl text-white font-bold">Upload & Import</button>
            </div>
        </form>
    </div>
</div>
@endsection
