@extends('layouts.app')

@section('content')
<div class="page-container" style="background: #F8F9FD; min-height: 100vh;">
    
    @if(session('success'))
    <div style="background: #E6FBF5; border: 1px solid #A7F3D0; color: var(--accent-green); padding: 16px 24px; border-radius: 12px; margin-bottom: 28px; display: flex; align-items: center; gap: 12px;">
        <i data-lucide="check-circle-2" style="color: var(--accent-green); flex-shrink: 0;"></i>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div style="background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; padding: 16px 24px; border-radius: 12px; margin-bottom: 28px; display: flex; align-items: center; gap: 12px;">
        <i data-lucide="alert-circle" style="color: #DC2626; flex-shrink: 0;"></i>
        <span style="font-weight: 600;">{{ $errors->first() }}</span>
    </div>
    @endif

    <div class="page-header" style="margin-bottom: 32px; border-bottom: 1px solid #E2E8F0; padding-bottom: 24px;">
        <div>
            <h1 class="page-title" style="font-weight: 400; color: #1F2937; font-size: 1.5rem;">WA Groups</h1>
            <p style="color: #6B7280; margin-top: 8px;">Manage your synced WhatsApp Groups.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <form action="/wa-groups/fetch" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn" style="background: #10B981; color: white; border: none; border-radius: 6px; padding: 10px 20px; font-weight: 600; font-size: 0.85rem; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <i data-lucide="refresh-cw" style="width: 16px; height: 16px;"></i>
                    SYNC WA GROUPS
                </button>
            </form>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px;">
        @forelse($groups as $group)
        <div style="background: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); padding: 20px; display: flex; flex-direction: column; justify-content: space-between; gap: 16px; min-height: 160px; border: 1px solid #E2E8F0; transition: transform 0.2s, box-shadow 0.2s;">
            <div style="display: flex; gap: 12px; align-items: flex-start;">
                <div style="color: #10B981; background: #E6FBF5; padding: 8px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="users" style="width: 24px; height: 24px;"></i>
                </div>
                
                <div style="flex: 1; min-width: 0; word-break: break-word;">
                    <div style="font-weight: 700; color: #1F2937; font-size: 0.95rem; line-height: 1.4; margin-bottom: 4px;">{{ $group->name }}</div>
                    <div style="color: #6B7280; font-size: 0.75rem; font-family: monospace;">ID: {{ $group->phone }}</div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: auto; border-top: 1px dashed #E2E8F0; padding-top: 12px;">
                <form action="/wa-groups/extract" method="POST" style="margin: 0; width: 100%;">
                    @csrf
                    <input type="hidden" name="group_id" value="{{ $group->phone }}">
                    <input type="hidden" name="group_name" value="{{ $group->name }}">
                    <button type="submit" class="btn" style="background: #3B82F6; color: white; border: none; border-radius: 8px; padding: 10px 14px; font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; width: 100%; transition: background 0.2s;">
                        <i data-lucide="download-cloud" style="width: 16px; height: 16px;"></i>
                        Extract Contacts
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #ffffff; border-radius: 12px; border: 1px dashed #D1D5DB;">
            <i data-lucide="folder-open" style="width: 48px; height: 48px; color: #9CA3AF; margin-bottom: 16px; display: inline-block;"></i>
            <h3 style="color: #374151; font-size: 1.2rem; font-weight: 700;">No WA Groups Synced</h3>
            <p style="color: #6B7280; margin-top: 8px;">Click "SYNC WA GROUPS" to fetch all groups from your connected WhatsApp device.</p>
        </div>
        @endforelse
    </div>
</div>

<script>
    // Lucide icons are initialized in app.blade.php
</script>
@endsection
