@extends('layouts.app')

@section('title', 'VetenCall - VoIP & TTS Phonebook Manager')
@section('page-title', 'VoIP / TTS Phonebook Manager')

@section('content')
<div class="space-y-8 max-w-7xl w-full mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold">Daftar Phonebook VoIP / TTS</h2>
            <p class="text-xs opacity-50">Total {{ $phonebooks->count() }} grup kontak khusus ekstensi VoIP dan panggilan suara (TTS).</p>
        </div>

        <button onclick="toggleAddModal()" class="nm-btn-brand px-5 py-2.5 rounded-xl font-semibold text-xs text-white flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14m-7-7h14"/></svg>
            + Buat Phonebook VoIP
        </button>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 p-4 rounded-xl text-sm">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 p-4 rounded-xl text-sm">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($phonebooks as $pb)
        <div class="nm-card p-6 flex flex-col justify-between space-y-4">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="nm-card-sm w-10 h-10 flex items-center justify-center text-violet-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                    </div>
                </div>
                <form action="{{ route('tts.phonebook.destroy', $pb->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Phonebook VoIP ini beserta semua kontaknya?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-slate-400 hover:text-red-500 font-bold px-2 py-1 transition" title="Hapus Phonebook">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    </button>
                </form>
            </div>
            
            <div class="space-y-1">
                <h3 class="text-base font-bold text-slate-800 dark:text-white">{{ $pb->name }}</h3>
                <p class="text-xs text-violet-500 font-medium">{{ $pb->contacts_count }} kontak / ekstensi</p>
                @if($pb->description)
                <p class="text-xs opacity-50 pt-1">{{ Str::limit($pb->description, 60) }}</p>
                @endif
            </div>

            <div class="pt-4 border-t border-black/5 dark:border-white/5 flex items-center justify-between text-xs">
                <a href="{{ route('tts.phonebook.contacts', $pb->id) }}" class="text-[#2f6bfd] dark:text-blue-400 hover:underline font-semibold flex items-center gap-1">
                    Kelola Kontak &rarr;
                </a>
                <span class="text-[10px] font-semibold px-2 py-0.5 bg-violet-500/10 text-violet-500 border border-violet-500/20 rounded-md">VoIP / TTS</span>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-black/[0.02] dark:bg-white/[0.02] rounded-3xl border border-dashed border-black/10 dark:border-white/10">
            <div class="w-16 h-16 rounded-full bg-violet-500/10 flex items-center justify-center text-violet-500 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
            </div>
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Belum Ada Phonebook VoIP / TTS</h3>
            <p class="text-xs opacity-50 mt-1 max-w-sm">Buat grup phonebook khusus untuk menyimpan ekstensi VoIP internal (contoh: 9999, 101) atau nomor target voice broadcast.</p>
            <button onclick="toggleAddModal()" class="mt-4 nm-btn-brand px-4 py-2 rounded-xl text-xs font-semibold text-white">
                + Buat Phonebook Sekarang
            </button>
        </div>
        @endforelse
    </div>
</div>

{{-- Add Modal --}}
<div id="add-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden p-4">
    <div class="nm-card max-w-md w-full p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-bold">Buat Phonebook VoIP / TTS</h3>
            <button type="button" onclick="toggleAddModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">&times;</button>
        </div>
        <form action="{{ route('tts.phonebook.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-semibold mb-1 opacity-70">Nama Phonebook <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Ekstensi Sales / Internal Support" 
                       class="w-full px-4 py-2.5 rounded-xl border border-black/10 dark:border-white/10 bg-black/5 dark:bg-white/5 focus:outline-none focus:ring-1 focus:ring-blue-500 text-xs">
            </div>
            <div>
                <label class="block font-semibold mb-1 opacity-70">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3" placeholder="Keterangan grup kontak VoIP..." 
                          class="w-full px-4 py-2.5 rounded-xl border border-black/10 dark:border-white/10 bg-black/5 dark:bg-white/5 focus:outline-none focus:ring-1 focus:ring-blue-500 text-xs"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="toggleAddModal()" class="px-4 py-2 rounded-xl border border-black/10 dark:border-white/10 opacity-70 hover:opacity-100 font-semibold">Batal</button>
                <button type="submit" class="nm-btn-brand px-5 py-2 rounded-xl text-white font-bold">Simpan Phonebook</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleAddModal() {
        document.getElementById('add-modal').classList.toggle('hidden');
    }
</script>
@endsection
