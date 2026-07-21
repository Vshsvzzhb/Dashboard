@extends('layouts.app')

@section('content')
<div class="page-container">

    @if(session('success'))
    <div style="background: #E6FBF5; border: 1px solid #A7F3D0; color: var(--accent-green); padding: 16px 24px; border-radius: 16px; margin-bottom: 28px; display: flex; align-items: center; gap: 12px;">
        <i data-lucide="check-circle-2" style="color: var(--accent-green); flex-shrink: 0;"></i>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif

    <div class="page-header">
        <div>
            <h1 class="page-title">Settings</h1>
            <p style="color: var(--text-secondary); margin-top: 8px; font-size: 1.05rem;">Configure your WhatsApp Gateway connection & preferences.</p>
        </div>
    </div>

    <form action="/settings" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 28px;">

            <!-- LEFT COLUMN: WA API Config -->
            <div style="display: flex; flex-direction: column; gap: 28px;">
                <div class="glass-panel" style="padding: 32px;">
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
                        <div style="width: 56px; height: 56px; border-radius: 50%; background: #E6FBF5; display: flex; align-items: center; justify-content: center; color: var(--accent-green); flex-shrink: 0;">
                            <i data-lucide="message-circle" style="width: 28px; height: 28px;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 1.2rem; font-weight: 800; margin: 0; color: var(--text-primary);">WhatsApp API</h3>
                            <p style="color: var(--text-secondary); font-size: 0.85rem; margin: 4px 0 0 0; font-weight: 500;">Connection to WA Engine</p>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">WA Engine URL</label>
                            <input type="text" name="wa_api_url" value="{{ $settings['wa_api_url'] ?? '' }}" placeholder="http://52.2.21.5:4000"
                                style="width: 100%; background: #ffffff; border: 2px solid var(--surface-border); border-radius: 14px; padding: 16px 20px; color: var(--text-primary); outline: none; font-family: monospace; font-size: 1rem; font-weight: 600; transition: all 0.3s;"
                                onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(67, 24, 255, 0.1)';" onblur="this.style.borderColor='var(--surface-border)'; this.style.boxShadow='none';">
                            <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 8px; font-weight: 500; line-height: 1.5;">
                                Isi <strong>root URL engine</strong> (bukan <code>/api</code>). Contoh benar: <code>http://52.2.21.5:4000</code><br>
                                Buka <a href="{{ $engineRoot }}/status" target="_blank" style="color: var(--primary); font-weight: 700;">{{ $engineRoot }}/status</a> untuk tes — harus muncul JSON, bukan "Cannot GET /api".
                            </p>
                            <div style="margin-top: 12px; padding: 12px 16px; border-radius: 12px; background: {{ $waLabel['bg'] }}; color: {{ $waLabel['color'] }}; font-weight: 700; font-size: 0.9rem;">
                                Status saat ini: {{ $waLabel['label'] }}
                                @if(!empty($waStatus['error']))
                                <span style="display: block; font-size: 0.8rem; font-weight: 600; margin-top: 4px; opacity: 0.85;">{{ $waStatus['error'] }}</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">API Token / Secret Key</label>
                            <input type="password" name="wa_api_token" value="{{ $settings['wa_api_token'] ?? '' }}" placeholder="your-secret-api-key"
                                style="width: 100%; background: #ffffff; border: 2px solid var(--surface-border); border-radius: 14px; padding: 16px 20px; color: var(--text-primary); outline: none; font-family: monospace; font-size: 1rem; font-weight: 600; transition: all 0.3s;"
                                onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(67, 24, 255, 0.1)';" onblur="this.style.borderColor='var(--surface-border)'; this.style.boxShadow='none';">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Message Delay (ms)</label>
                            <input type="number" name="sender_delay" value="{{ $settings['sender_delay'] ?? '3000' }}" placeholder="3000"
                                style="width: 100%; background: #ffffff; border: 2px solid var(--surface-border); border-radius: 14px; padding: 16px 20px; color: var(--text-primary); outline: none; font-family: inherit; font-size: 1rem; font-weight: 600; transition: all 0.3s;"
                                onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(67, 24, 255, 0.1)';" onblur="this.style.borderColor='var(--surface-border)'; this.style.boxShadow='none';">
                            <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 8px; display: flex; align-items: center; gap: 6px; font-weight: 500;"><i data-lucide="alert-triangle" style="width: 16px; height: 16px; color: var(--accent-orange);"></i> Minimum 2000ms recommended to avoid WA ban.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Webhook & App -->
            <div style="display: flex; flex-direction: column; gap: 28px;">
                <div class="glass-panel" style="padding: 32px;">
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
                        <div style="width: 56px; height: 56px; border-radius: 50%; background: #E0F2FE; display: flex; align-items: center; justify-content: center; color: #0284C7; flex-shrink: 0;">
                            <i data-lucide="webhook" style="width: 28px; height: 28px;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 1.2rem; font-weight: 800; margin: 0; color: var(--text-primary);">Webhook & App</h3>
                            <p style="color: var(--text-secondary); font-size: 0.85rem; margin: 4px 0 0 0; font-weight: 500;">Callback endpoint identity</p>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Webhook URL</label>
                            <input type="text" name="webhook_url" value="{{ $settings['webhook_url'] ?? '' }}" placeholder="https://yourdomain.com/webhook"
                                style="width: 100%; background: #ffffff; border: 2px solid var(--surface-border); border-radius: 14px; padding: 16px 20px; color: var(--text-primary); outline: none; font-family: monospace; font-size: 1rem; font-weight: 600; transition: all 0.3s;"
                                onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(67, 24, 255, 0.1)';" onblur="this.style.borderColor='var(--surface-border)'; this.style.boxShadow='none';">
                            <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 8px; font-weight: 500;">URL yang akan menerima notifikasi dari WA Engine.</p>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 10px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Application Name</label>
                            <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'WAGateway' }}" placeholder="WAGateway"
                                style="width: 100%; background: #ffffff; border: 2px solid var(--surface-border); border-radius: 14px; padding: 16px 20px; color: var(--text-primary); outline: none; font-family: inherit; font-size: 1rem; font-weight: 600; transition: all 0.3s;"
                                onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(67, 24, 255, 0.1)';" onblur="this.style.borderColor='var(--surface-border)'; this.style.boxShadow='none';">
                        </div>
                    </div>
                </div>

                </div>

            </div>
        </div>

        <!-- Save Button -->
        <div style="display: flex; justify-content: flex-end; margin-top: 28px;">
            <button type="submit" class="btn btn-primary" style="padding: 18px 48px; font-size: 1.1rem;">
                <i data-lucide="save" style="width: 20px; height: 20px;"></i>
                Save All Settings
            </button>
        </div>
    </form>
</div>
@endsection
