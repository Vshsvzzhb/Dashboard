@extends('layouts.app')

@section('content')
<div class="page-container">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="background: #E6FBF5; border: 1px solid #A7F3D0; color: var(--accent-green); padding: 16px 24px; border-radius: 16px; margin-bottom: 28px; display: flex; align-items: center; gap: 12px;">
        <i data-lucide="check-circle-2" style="color: var(--accent-green); flex-shrink: 0;"></i>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif
    @if($errors->any())
    <div style="background: #FEECEB; border: 1px solid #FECACA; color: var(--accent-pink); padding: 16px 24px; border-radius: 16px; margin-bottom: 28px;">
        @foreach($errors->all() as $error)
            <p style="margin: 0; font-weight: 600;">⚠️ {{ $error }}</p>
        @endforeach
    </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Campaigns</h1>
            <p style="color: var(--text-secondary); margin-top: 8px; font-size: 1.05rem;">Manage & schedule your WhatsApp broadcasts.</p>
        </div>
        <button class="btn" style="background: #4318FF; color: white; border: none; border-radius: 12px; font-weight: 700; padding: 14px 28px; display: flex; align-items: center; gap: 8px; font-size: 0.95rem; cursor: pointer; transition: background 0.3s;" onclick="document.getElementById('createModal').style.display='flex'" onmouseover="this.style.background='#3A14DF'" onmouseout="this.style.background='#4318FF'">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Create Campaign
        </button>
    </div>

    {{-- Stats Row --}}
    <div class="bento-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 32px; gap: 24px;">
        <div class="glass-panel" style="padding: 24px 32px; display: flex; align-items: center; gap: 24px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: none; background: #ffffff;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: #F4F0FF; display: flex; align-items: center; justify-content: center; color: #6D28D9; flex-shrink: 0;">
                <i data-lucide="radio" style="width: 28px; height: 28px;"></i>
            </div>
            <div>
                <div style="font-size: 2.2rem; font-weight: 800; line-height: 1; color: #111827;">{{ $campaigns->count() }}</div>
                <div style="color: #9CA3AF; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin-top: 8px;">Total</div>
            </div>
        </div>
        <div class="glass-panel" style="padding: 24px 32px; display: flex; align-items: center; gap: 24px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: none; background: #ffffff;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: #E0F2FE; display: flex; align-items: center; justify-content: center; color: #0284C7; flex-shrink: 0;">
                <i data-lucide="loader" style="width: 28px; height: 28px;"></i>
            </div>
            <div>
                <div style="font-size: 2.2rem; font-weight: 800; line-height: 1; color: #111827;">{{ $campaigns->where('status','running')->count() }}</div>
                <div style="color: #9CA3AF; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin-top: 8px;">Running</div>
            </div>
        </div>
        <div class="glass-panel" style="padding: 24px 32px; display: flex; align-items: center; gap: 24px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: none; background: #ffffff;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: #E6FBF5; display: flex; align-items: center; justify-content: center; color: #059669; flex-shrink: 0;">
                <i data-lucide="check-circle-2" style="width: 28px; height: 28px;"></i>
            </div>
            <div>
                <div style="font-size: 2.2rem; font-weight: 800; line-height: 1; color: #111827;">{{ $campaigns->where('status','completed')->count() }}</div>
                <div style="color: #9CA3AF; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin-top: 8px;">Completed</div>
            </div>
        </div>
        <div class="glass-panel" style="padding: 24px 32px; display: flex; align-items: center; gap: 24px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: none; background: #ffffff;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: #FEF3C7; display: flex; align-items: center; justify-content: center; color: #D97706; flex-shrink: 0;">
                <i data-lucide="pause-circle" style="width: 28px; height: 28px;"></i>
            </div>
            <div>
                <div style="font-size: 2.2rem; font-weight: 800; line-height: 1; color: #111827;">{{ $campaigns->where('status','paused')->count() }}</div>
                <div style="color: #9CA3AF; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin-top: 8px;">Paused</div>
            </div>
        </div>
    </div>

    {{-- Campaigns Table --}}
    <div class="glass-panel" style="padding: 32px;">
        @if($campaigns->isEmpty())
        <div style="text-align: center; padding: 120px 20px; background: #ffffff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.03);">
            <div style="width: 80px; height: 80px; background: #F4F0FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <i data-lucide="radio" style="width: 36px; height: 36px; color: #4318FF;"></i>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 800; color: #111827; margin-bottom: 8px;">No campaigns yet.</h3>
            <p style="font-size: 0.95rem; color: #9CA3AF; font-weight: 500;">Click "<strong>Create Campaign</strong>" to schedule your first broadcast.</p>
        </div>
        @else
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Campaign Name</th>
                        <th>Target Audience</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Scheduled</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaigns as $campaign)
                    @php
                        $pct = $campaign->total_count > 0
                            ? round(($campaign->sent_count / $campaign->total_count) * 100)
                            : 0;
                        $statusClass = [
                            'running'   => 'badge success',
                            'completed' => 'badge success',
                            'paused'    => 'badge warning',
                            'failed'    => 'badge danger',
                        ];
                        $sc = $statusClass[$campaign->status] ?? 'badge warning';
                    @endphp
                    <tr>
                        <td style="font-weight: 700; color: var(--text-primary); font-size: 1.05rem;">{{ $campaign->name }}</td>
                        <td>
                            <span style="background: #F4F7FE; padding: 6px 14px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; color: var(--primary);">
                                {{ $campaign->target_audience }}
                            </span>
                        </td>
                        <td style="min-width: 180px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="flex: 1; height: 8px; background: var(--surface-border); border-radius: 100px; overflow: hidden;">
                                    <div style="width: {{ $pct }}%; height: 100%; background: var(--primary); border-radius: 100px; transition: width 0.5s ease;"></div>
                                </div>
                                <span style="font-size: 0.85rem; font-weight: 800; color: var(--text-primary); flex-shrink: 0;">{{ $pct }}%</span>
                            </div>
                            <div style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 6px; font-weight: 500;">{{ $campaign->sent_count }} / {{ $campaign->total_count }} sent</div>
                        </td>
                        <td>
                            <span class="{{ $sc }}">
                                {{ ucfirst($campaign->status) }}
                            </span>
                        </td>
                        <td style="color: var(--text-secondary); font-weight: 500;">
                            {{ $campaign->scheduled_at ? \Carbon\Carbon::parse($campaign->scheduled_at)->format('M d, Y H:i') : '—' }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                {{-- Play/Pause Toggle --}}
                                @if($campaign->status === 'running')
                                <form action="/campaigns/{{ $campaign->id }}/status" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="paused">
                                    <button type="submit" title="Pause" style="background: #FFF7D8; border: none; color: var(--accent-orange); padding: 10px; border-radius: 10px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center;">
                                        <i data-lucide="pause" style="width: 18px; height: 18px;"></i>
                                    </button>
                                </form>
                                @else
                                <form action="/campaigns/{{ $campaign->id }}/status" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="running">
                                    <button type="submit" title="Run" style="background: #E6FBF5; border: none; color: var(--accent-green); padding: 10px; border-radius: 10px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center;">
                                        <i data-lucide="play" style="width: 18px; height: 18px;"></i>
                                    </button>
                                </form>
                                @endif
                                {{-- Delete --}}
                                <form action="/campaigns/{{ $campaign->id }}" method="POST" onsubmit="return confirm('Delete this campaign?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" style="background: #FEECEB; border: none; color: var(--accent-pink); padding: 10px; border-radius: 10px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center;">
                                        <i data-lucide="trash-2" style="width: 18px; height: 18px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

<div id="createModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0, 0.4); backdrop-filter: blur(8px); z-index: 100; align-items: center; justify-content: center;">
    <div class="glass-panel" style="width: 100%; max-width: 900px; padding: 0; background: #ffffff; display: flex; flex-direction: column; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
        
        {{-- Header --}}
        <div style="padding: 24px 32px; border-bottom: 1px solid var(--surface-border); display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i data-lucide="rocket" style="color: #0066FF; width: 24px; height: 24px;"></i>
                <h2 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: var(--text-primary);">Campaign Baru</h2>
            </div>
            <button onclick="document.getElementById('createModal').style.display='none'" style="background: transparent; border: 1px solid var(--surface-border); color: var(--text-secondary); padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.background='#F4F7FE'" onmouseout="this.style.background='transparent'">
                <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> KEMBALI
            </button>
        </div>

        {{-- Body --}}
        <div style="display: flex; min-height: 400px;">
            {{-- Left Sidebar Steps --}}
            <div style="width: 280px; border-right: 1px solid var(--surface-border); padding: 32px; background: #FAFAFA;">
                {{-- Step 1 --}}
                <div class="step-item active" id="step-nav-1" style="display: flex; gap: 16px; margin-bottom: 32px; opacity: 1;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #0066FF; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; flex-shrink: 0;">1</div>
                    <div>
                        <div style="font-weight: 700; color: var(--text-primary); font-size: 1rem;">Pengaturan Awal</div>
                        <div style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 4px;">Nama & Target</div>
                    </div>
                </div>
                {{-- Step 2 --}}
                <div class="step-item" id="step-nav-2" style="display: flex; gap: 16px; margin-bottom: 32px; opacity: 0.5;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #E2E8F0; color: var(--text-secondary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; flex-shrink: 0;">2</div>
                    <div>
                        <div style="font-weight: 700; color: var(--text-primary); font-size: 1rem;">Konten Pesan</div>
                        <div style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 4px;">Buat pesan & template</div>
                    </div>
                </div>
                {{-- Step 3 --}}
                <div class="step-item" id="step-nav-3" style="display: flex; gap: 16px; opacity: 0.5;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #E2E8F0; color: var(--text-secondary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; flex-shrink: 0;">3</div>
                    <div>
                        <div style="font-weight: 700; color: var(--text-primary); font-size: 1rem;">Penjadwalan</div>
                        <div style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 4px;">Atur waktu kirim</div>
                    </div>
                </div>
            </div>

            {{-- Right Content --}}
            <div style="flex: 1; padding: 32px; background: #ffffff;">
                <form action="/campaigns" method="POST" id="campaignStepperForm">
                    @csrf
                    
                    {{-- Step 1 Content --}}
                    <div id="step-content-1">
                        <div style="background: #F4F0FF; border-radius: 12px; padding: 16px 24px; display: flex; align-items: center; gap: 12px; margin-bottom: 32px; color: #6D28D9;">
                            <i data-lucide="smartphone" style="width: 20px; height: 20px;"></i>
                            <span style="font-size: 0.95rem;">Create Campaign for <strong>Primary (Connected)</strong> device.</span>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                            <div>
                                <label style="display: block; margin-bottom: 10px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem;">Campaign Name</label>
                                <input type="text" name="name" id="c_name" placeholder="Enter Name" required
                                    style="width: 100%; border: 2px solid #0066FF; border-radius: 8px; padding: 12px 16px; outline: none; font-weight: 600; font-size: 0.95rem; color: var(--text-primary);">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 10px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem;">Phonebook (Recipient)</label>
                                <select name="target_audience" id="c_target" style="width: 100%; border: 2px solid var(--surface-border); border-radius: 8px; padding: 12px 16px; outline: none; font-weight: 600; font-size: 0.95rem; color: var(--text-primary); appearance: none; background: #fff url('data:image/svg+xml;utf8,<svg width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%2364748b\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><polyline points=\'6 9 12 15 18 9\'></polyline></svg>') no-repeat right 12px center; background-size: 16px;">
                                    <option value="All Contacts">Semua Kontak Individu (Bukan Grup)</option>
                                    @if(isset($labels))
                                        @foreach($labels as $label)
                                            <option value="{{ $label }}">{{ $label }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div style="margin-top: 40px; border-top: 1px solid var(--surface-border); padding-top: 24px; display: flex; justify-content: space-between;">
                            <button type="button" class="btn" style="background: #FF4B4B; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;" onclick="document.getElementById('createModal').style.display='none'">
                                <i data-lucide="x" style="width: 18px; height: 18px;"></i> CANCEL
                            </button>
                            <button type="button" class="btn" style="background: #0066FF; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;" onclick="nextStep(2)">
                                NEXT STEP <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Step 2 Content --}}
                    <div id="step-content-2" style="display: none;">
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem;">Pesan Broadcast</label>
                            <textarea name="message" id="c_message" rows="6" placeholder="Halo {name}, promo menarik untukmu!"
                                style="width: 100%; border: 2px solid #0066FF; border-radius: 8px; padding: 12px 16px; outline: none; font-weight: 500; font-size: 0.95rem; resize: vertical; color: var(--text-primary);"></textarea>
                            <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;">Gunakan tag <b>{name}</b> untuk menyapa pelanggan secara otomatis.</p>
                        </div>

                        <div style="margin-top: 40px; border-top: 1px solid var(--surface-border); padding-top: 24px; display: flex; justify-content: space-between;">
                            <button type="button" class="btn" style="background: #F4F7FE; color: var(--text-primary); padding: 12px 24px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;" onclick="prevStep(1)">
                                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i> KEMBALI
                            </button>
                            <button type="button" class="btn" style="background: #0066FF; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;" onclick="nextStep(3)">
                                NEXT STEP <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Step 3 Content --}}
                    <div id="step-content-3" style="display: none;">
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem;">Jadwal Kirim (Opsional)</label>
                            <input type="datetime-local" name="scheduled_at"
                                style="width: 100%; border: 2px solid var(--surface-border); border-radius: 8px; padding: 12px 16px; outline: none; font-weight: 600; font-size: 0.95rem; color: var(--text-primary);">
                            <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;">Kosongkan jika ingin langsung dikirim (Play Manual nantinya).</p>
                        </div>

                        <div style="margin-top: 40px; border-top: 1px solid var(--surface-border); padding-top: 24px; display: flex; justify-content: space-between;">
                            <button type="button" class="btn" style="background: #F4F7FE; color: var(--text-primary); padding: 12px 24px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;" onclick="prevStep(2)">
                                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i> KEMBALI
                            </button>
                            <button type="submit" class="btn" style="background: #10b981; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                <i data-lucide="check-circle" style="width: 18px; height: 18px;"></i> SIMPAN
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function nextStep(step) {
    if (step === 2) {
        if(!document.getElementById('c_name').value) { 
            alert('Campaign Name harus diisi!'); 
            document.getElementById('c_name').focus();
            return; 
        }
    }
    if (step === 3) {
        if(!document.getElementById('c_message').value) { 
            alert('Pesan Broadcast harus diisi!'); 
            document.getElementById('c_message').focus();
            return; 
        }
    }
    showStep(step);
}
function prevStep(step) {
    showStep(step);
}
function showStep(step) {
    // Hide all contents
    document.getElementById('step-content-1').style.display = 'none';
    document.getElementById('step-content-2').style.display = 'none';
    document.getElementById('step-content-3').style.display = 'none';
    
    // Show active content
    document.getElementById('step-content-' + step).style.display = 'block';

    // Reset styles
    for(let i=1; i<=3; i++) {
        let nav = document.getElementById('step-nav-' + i);
        let icon = nav.querySelector('div');
        if(i === step) {
            nav.style.opacity = '1';
            icon.style.background = '#0066FF';
            icon.style.color = 'white';
        } else if (i < step) {
            nav.style.opacity = '1';
            icon.style.background = '#10b981'; // Green for completed
            icon.style.color = 'white';
        } else {
            nav.style.opacity = '0.5';
            icon.style.background = '#E2E8F0';
            icon.style.color = 'var(--text-secondary)';
        }
    }
}
</script>
@endsection
