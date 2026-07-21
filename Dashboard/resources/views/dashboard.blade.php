@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Command Center</h1>
            <p style="color: var(--text-secondary); margin-top: 8px; font-size: 1rem;">WhatsApp Gateway overview.</p>
        </div>
        <a href="/campaigns" class="btn btn-primary">
            <i data-lucide="zap" style="width: 20px; height: 20px;"></i>
            Launch Campaign
        </a>
    </div>

    <!-- Bento Grid - Live Data -->
    <div class="bento-grid">
        <!-- Hero Card: Total Sent -->
        <div class="bento-card wide tall glass-panel">
            <div>
                <div class="stat-icon">
                    <i data-lucide="send" style="width: 28px; height: 28px;"></i>
                </div>
                <div class="stat-value">{{ number_format($totalSent) }}</div>
                <div class="stat-label">Total Messages Sent</div>
            </div>
        </div>

        <!-- Active Contacts -->
        <div class="bento-card glass-panel">
            <div class="stat-icon" style="color: var(--secondary); border-color: rgba(14,165,233,0.2);">
                <i data-lucide="users" style="width: 28px; height: 28px;"></i>
            </div>
            <div>
                <div class="stat-value" style="font-size: 2.8rem;">{{ number_format($totalContacts) }}</div>
                <div class="stat-label">Active Contacts</div>
            </div>
        </div>

        <!-- Campaigns -->
        <div class="bento-card glass-panel">
            <div class="stat-icon" style="color: var(--accent-green); border-color: rgba(16,185,129,0.2);">
                <i data-lucide="radio" style="width: 28px; height: 28px;"></i>
            </div>
            <div>
                <div class="stat-value" style="font-size: 2.8rem;">{{ $totalCampaigns }}</div>
                <div class="stat-label">Total Campaigns</div>
            </div>
        </div>

        <!-- Running -->
        <div class="bento-card wide glass-panel" style="flex-direction: row; align-items: center; justify-content: space-between;">
            <div>
                <div class="stat-label" style="margin-top: 0;">WhatsApp Status</div>
                <div id="wa-status-label" class="stat-value" style="font-size: 1.3rem; margin-top: 8px; color: {{ $waLabel['color'] }};">{{ $waLabel['label'] }}</div>
                <div id="wa-status-hint" style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px; font-weight: 500;">{{ $waLabel['hint'] }}</div>
            </div>
            <div id="wa-status-icon-wrap" class="stat-icon" style="background: {{ $waLabel['bg'] }}; color: {{ $waLabel['color'] }}; margin-bottom: 0; width: 64px; height: 64px;">
                <i data-lucide="{{ !empty($waStatus['connected']) ? 'wifi' : (!empty($waStatus['reachable']) ? 'smartphone' : 'wifi-off') }}" style="width: 32px; height: 32px; {{ !empty($waStatus['connected']) ? 'animation: pulse 2s infinite;' : '' }}"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div style="display: grid; grid-template-columns: 2fr 1.2fr; gap: 28px;">
        
        <!-- Recent Activity -->
        <div class="glass-panel" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h3 style="font-size: 1.25rem; font-weight: 700;">Recent Campaigns</h3>
                <a href="/campaigns" style="color: var(--primary); font-size: 0.9rem; font-weight: 500; text-decoration: none;">View All &rarr;</a>
            </div>

            @if($recentCampaigns->isEmpty())
            <div style="text-align: center; padding: 40px; color: var(--text-secondary);">
                <p>No campaigns yet. <a href="/campaigns" style="color: var(--primary); font-weight: 700;">Create one →</a></p>
            </div>
            @else
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th>Status</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentCampaigns as $c)
                        @php
                            $pct = $c->total_count > 0 ? round(($c->sent_count/$c->total_count)*100) : 0;
                            $statusClass = ['running'=>'badge success', 'completed'=>'badge success', 'paused'=>'badge warning', 'failed'=>'badge danger'];
                            $sc = $statusClass[$c->status] ?? 'badge warning';
                        @endphp
                        <tr>
                            <td style="font-weight: 700; color: var(--text-primary);">{{ $c->name }}<br><span style="font-size: 0.75rem; color: var(--text-secondary); font-weight: 500;">{{ $c->target_audience }}</span></td>
                            <td><span class="{{ $sc }}">{{ ucfirst($c->status) }}</span></td>
                            <td style="min-width: 140px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="flex:1; height: 8px; background: var(--surface-border); border-radius: 9999px; overflow: hidden;">
                                        <div style="width: {{ $pct }}%; height: 100%; background: var(--primary); border-radius: 9999px;"></div>
                                    </div>
                                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-secondary);">{{ $pct }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--surface-border);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 1.1rem; font-weight: 700;">Recent Blasts</h3>
                    <a href="/blast-history" style="color: var(--primary); font-size: 0.9rem; font-weight: 500; text-decoration: none;">View All &rarr;</a>
                </div>
                @forelse($recentBlasts as $blast)
                @php
                    $statusClass = ['queued'=>'badge warning','sending'=>'badge primary','done'=>'badge success','failed'=>'badge danger'];
                    $sc = $statusClass[$blast->status] ?? 'badge warning';
                @endphp
                <div style="padding: 14px 16px; background: #F4F7FE; border-radius: 12px; margin-bottom: 10px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                        <p style="margin: 0; font-weight: 700; flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit($blast->message, 50) }}</p>
                        <span class="{{ $sc }}">{{ ucfirst($blast->status) }}</span>
                    </div>
                    <div style="display: flex; gap: 16px; margin-top: 8px; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary);">
                        <span>{{ $blast->total }} penerima</span>
                        <span style="color: var(--accent-green);">✓ {{ $blast->sent }} sent</span>
                        <span style="margin-left: auto;">{{ $blast->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <p style="color: var(--text-secondary); font-size: 0.9rem;">Belum ada blast. <a href="/quick-blast" style="color: var(--primary); font-weight: 700;">Kirim sekarang →</a></p>
                @endforelse
            </div>
        </div>

        <!-- WhatsApp Device Connection -->
        <div class="glass-panel" style="padding: 24px; background: #ffffff; display: flex; flex-direction: column; gap: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 800; margin: 0; color: var(--text-primary);">Device Link</h3>
                    <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 4px; font-weight: 500;">Connect your WhatsApp</p>
                </div>
                <div id="wa-device-badge" style="display: flex; align-items: center; gap: 8px; background: {{ $waLabel['bg'] }}; padding: 8px 16px; border-radius: 100px; color: {{ $waLabel['color'] }}; font-weight: 800; font-size: 0.85rem;">
                    <div id="wa-device-dot" class="status-indicator" style="{{ !empty($waStatus['connected']) ? '' : 'background: currentColor; opacity: 0.6;' }}"></div>
                    <span id="wa-device-label">{{ $waLabel['label'] }}</span>
                </div>
            </div>
            
            <hr style="border: none; border-top: 2px dashed var(--surface-border); margin: 0;">
            
            <div style="text-align: center; flex: 1; display: flex; flex-direction: column;">
                <iframe id="wa-qr-frame" src="{{ $engineRoot }}/qr" width="100%" style="border: none; border-radius: 16px; background: transparent; flex: 1; min-height: 380px;"></iframe>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
</style>

<script>
function waStatusIcon(status) {
    if (status.connected) return { name: 'wifi', pulse: true };
    if (status.reachable) return { name: 'smartphone', pulse: false };
    return { name: 'wifi-off', pulse: false };
}

function applyWaStatus(data) {
    const label = data.label;
    const status = data.status;

    document.getElementById('wa-status-label').textContent = label.label;
    document.getElementById('wa-status-label').style.color = label.color;
    document.getElementById('wa-status-hint').textContent = label.hint;

    const iconWrap = document.getElementById('wa-status-icon-wrap');
    iconWrap.style.background = label.bg;
    iconWrap.style.color = label.color;

    const iconInfo = waStatusIcon(status);
    iconWrap.innerHTML = `<i data-lucide="${iconInfo.name}" style="width: 32px; height: 32px;${iconInfo.pulse ? ' animation: pulse 2s infinite;' : ''}"></i>`;

    const badge = document.getElementById('wa-device-badge');
    badge.style.background = label.bg;
    badge.style.color = label.color;
    document.getElementById('wa-device-label').textContent = label.label;

    lucide.createIcons();
}

async function refreshWaStatus() {
    try {
        const res = await fetch('/wa-status');
        if (!res.ok) return;
        applyWaStatus(await res.json());
    } catch (e) {
        // engine offline — biarkan status terakhir
    }
}

refreshWaStatus();
setInterval(refreshWaStatus, 10000);
</script>
@endsection
