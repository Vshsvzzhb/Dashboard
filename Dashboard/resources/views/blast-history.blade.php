@extends('layouts.app')

@section('content')
<div class="page-container">

    <div class="page-header">
        <div>
            <h1 class="page-title">Blast History</h1>
            <p style="color: var(--text-secondary); margin-top: 8px; font-size: 1.05rem;">Riwayat semua pesan Quick Blast yang pernah dikirim.</p>
        </div>
        <a href="/quick-blast" class="btn btn-primary">
            <i data-lucide="zap" style="width: 20px; height: 20px;"></i>
            New Blast
        </a>
    </div>

    <div class="bento-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 32px; gap: 24px;">
        <div class="glass-panel" style="padding: 24px 32px; display: flex; align-items: center; gap: 24px;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #F4F0FF; display: flex; align-items: center; justify-content: center; color: #6D28D9;">
                <i data-lucide="send" style="width: 26px; height: 26px;"></i>
            </div>
            <div>
                <div style="font-size: 2rem; font-weight: 800; line-height: 1;">{{ number_format($stats['total']) }}</div>
                <div style="color: var(--text-secondary); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-top: 6px;">Total Blast</div>
            </div>
        </div>
        <div class="glass-panel" style="padding: 24px 32px; display: flex; align-items: center; gap: 24px;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #E6FBF5; display: flex; align-items: center; justify-content: center; color: #059669;">
                <i data-lucide="check-circle-2" style="width: 26px; height: 26px;"></i>
            </div>
            <div>
                <div style="font-size: 2rem; font-weight: 800; line-height: 1;">{{ number_format($stats['done']) }}</div>
                <div style="color: var(--text-secondary); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-top: 6px;">Selesai</div>
            </div>
        </div>
        <div class="glass-panel" style="padding: 24px 32px; display: flex; align-items: center; gap: 24px;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #FEECEB; display: flex; align-items: center; justify-content: center; color: #DC2626;">
                <i data-lucide="x-circle" style="width: 26px; height: 26px;"></i>
            </div>
            <div>
                <div style="font-size: 2rem; font-weight: 800; line-height: 1;">{{ number_format($stats['failed']) }}</div>
                <div style="color: var(--text-secondary); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-top: 6px;">Gagal</div>
            </div>
        </div>
        <div class="glass-panel" style="padding: 24px 32px; display: flex; align-items: center; gap: 24px;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #E0F2FE; display: flex; align-items: center; justify-content: center; color: #0284C7;">
                <i data-lucide="users" style="width: 26px; height: 26px;"></i>
            </div>
            <div>
                <div style="font-size: 2rem; font-weight: 800; line-height: 1;">{{ number_format($stats['sent']) }}</div>
                <div style="color: var(--text-secondary); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-top: 6px;">Pesan Terkirim</div>
            </div>
        </div>
    </div>

    <div class="glass-panel" style="padding: 32px;">
        @if($blasts->isEmpty())
        <div style="text-align: center; padding: 80px 20px; color: var(--text-secondary);">
            <i data-lucide="inbox" style="width: 48px; height: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
            <p style="font-weight: 600;">Belum ada riwayat blast.</p>
            <a href="/quick-blast" style="color: var(--primary); font-weight: 700;">Kirim blast pertama →</a>
        </div>
        @else
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Pesan</th>
                        <th>Penerima</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blasts as $blast)
                    @php
                        $statusClass = ['queued'=>'badge warning','sending'=>'badge primary','done'=>'badge success','failed'=>'badge danger'];
                        $sc = $statusClass[$blast->status] ?? 'badge warning';
                        $pct = $blast->total > 0 ? round(($blast->sent / $blast->total) * 100) : 0;
                    @endphp
                    <tr>
                        <td style="white-space: nowrap; font-weight: 600; color: var(--text-secondary); font-size: 0.9rem;">
                            {{ $blast->created_at->format('d M Y') }}<br>
                            <span style="font-size: 0.8rem;">{{ $blast->created_at->format('H:i') }}</span>
                        </td>
                        <td style="max-width: 280px;">
                            <div style="font-weight: 700; color: var(--text-primary); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit($blast->message, 80) }}</div>
                        </td>
                        <td style="font-weight: 700;">{{ $blast->total }} kontak</td>
                        <td style="min-width: 120px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex:1; height: 8px; background: var(--surface-border); border-radius: 9999px; overflow: hidden;">
                                    <div style="width: {{ $pct }}%; height: 100%; background: var(--primary); border-radius: 9999px;"></div>
                                </div>
                                <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-secondary);">{{ $blast->sent }}/{{ $blast->total }}</span>
                            </div>
                        </td>
                        <td><span class="{{ $sc }}">{{ ucfirst($blast->status) }}</span></td>
                        <td>
                            <a href="/blast-history/{{ $blast->id }}" style="color: var(--primary); font-weight: 700; font-size: 0.85rem; text-decoration: none;">Detail →</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 24px;">
            {{ $blasts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
