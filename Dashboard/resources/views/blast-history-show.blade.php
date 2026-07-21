@extends('layouts.app')

@section('content')
<div class="page-container">

    <div class="page-header">
        <div>
            <a href="/blast-history" style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 600; text-decoration: none;">← Kembali ke Riwayat</a>
            <h1 class="page-title" style="margin-top: 8px;">Detail Blast #{{ $blast->id }}</h1>
            <p style="color: var(--text-secondary); margin-top: 8px; font-size: 1rem;">
                {{ $blast->created_at->format('d F Y, H:i') }} · {{ $blast->created_at->diffForHumans() }}
            </p>
        </div>
        @php
            $statusClass = ['queued'=>'badge warning','sending'=>'badge primary','done'=>'badge success','failed'=>'badge danger'];
            $sc = $statusClass[$blast->status] ?? 'badge warning';
        @endphp
        <span class="{{ $sc }}" style="font-size: 0.95rem; padding: 10px 20px;">{{ ucfirst($blast->status) }}</span>
    </div>

    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 28px; align-items: start;">

        <div class="glass-panel" style="padding: 32px;">
            <h3 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 16px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Isi Pesan</h3>
            <div style="background: #F4F7FE; border-radius: 16px; padding: 20px; white-space: pre-wrap; line-height: 1.7; font-weight: 500; color: var(--text-primary);">{{ $blast->message }}</div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="glass-panel" style="padding: 28px;">
                <h3 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 20px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Statistik</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div style="background: #F4F7FE; border-radius: 12px; padding: 16px; text-align: center;">
                        <div style="font-size: 1.8rem; font-weight: 800;">{{ $blast->total }}</div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Total</div>
                    </div>
                    <div style="background: #E6FBF5; border-radius: 12px; padding: 16px; text-align: center;">
                        <div style="font-size: 1.8rem; font-weight: 800; color: var(--accent-green);">{{ $blast->sent }}</div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Terkirim</div>
                    </div>
                    @if($blast->failed > 0)
                    <div style="background: #FEECEB; border-radius: 12px; padding: 16px; text-align: center; grid-column: span 2;">
                        <div style="font-size: 1.8rem; font-weight: 800; color: var(--accent-pink);">{{ $blast->failed }}</div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Gagal</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="glass-panel" style="padding: 32px; margin-top: 28px;">
        <h3 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 20px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
            Daftar Penerima ({{ count($blast->recipients ?? []) }})
        </h3>
        @if(empty($blast->recipients))
        <p style="color: var(--text-secondary); font-weight: 500;">Tidak ada data penerima.</p>
        @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 10px;">
            @foreach($blast->recipients as $phone)
            <div style="background: #F4F7FE; border-radius: 10px; padding: 12px 16px; font-family: monospace; font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">
                {{ $phone }}
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
