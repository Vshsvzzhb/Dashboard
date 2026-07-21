@extends('layouts.app')

@section('content')
<div class="page-container" style="background: #F8F9FD; min-height: 100vh;">
    
    @if(session('success'))
    <div style="background: #E6FBF5; border: 1px solid #A7F3D0; color: var(--accent-green); padding: 16px 24px; border-radius: 12px; margin-bottom: 28px; display: flex; align-items: center; gap: 12px;">
        <i data-lucide="check-circle-2" style="color: var(--accent-green); flex-shrink: 0;"></i>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif

    <div class="page-header" style="margin-bottom: 32px; border-bottom: 1px solid #E2E8F0; padding-bottom: 24px;">
        <div>
            <h1 class="page-title" style="font-weight: 400; color: #1F2937; font-size: 1.5rem;">Phonebook</h1>
        </div>
        <div style="display: flex; gap: 12px;">
            <button class="btn" style="background: #2563EB; color: white; border: none; border-radius: 6px; padding: 10px 20px; font-weight: 600; font-size: 0.85rem; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px; cursor: pointer;" onclick="document.getElementById('addModal').style.display='flex'">
                <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                ADD PHONEBOOK
            </button>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px;">
        @forelse($phonebooks as $name => $count)
        <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); padding: 20px; display: flex; align-items: center; gap: 16px; transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)';" onclick="window.location.href='/phonebook/show/{{ $name }}'">
            <input type="checkbox" style="width: 18px; height: 18px; border-radius: 4px; border: 2px solid #D1D5DB; cursor: pointer;" onclick="event.stopPropagation()">
            
            <div style="color: #4B5563;">
                <i data-lucide="contact-2" style="width: 28px; height: 28px;"></i>
            </div>
            
            <div style="flex: 1;">
                <div style="font-weight: 700; color: #374151; font-size: 1rem;">{{ $name }}</div>
                <div style="color: #6B7280; font-size: 0.85rem; margin-top: 2px;">{{ $count }} contacts</div>
                <div style="color: #9CA3AF; font-size: 0.8rem; margin-top: 2px;">Owner: VetenCall (Me)</div>
            </div>
            
            <button style="background: transparent; border: none; color: #9CA3AF; cursor: pointer; padding: 4px;">
                <i data-lucide="more-vertical" style="width: 20px; height: 20px;"></i>
            </button>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #ffffff; border-radius: 12px; border: 1px dashed #D1D5DB;">
            <i data-lucide="folder-open" style="width: 48px; height: 48px; color: #9CA3AF; margin-bottom: 16px; display: inline-block;"></i>
            <h3 style="color: #374151; font-size: 1.2rem; font-weight: 700;">No Phonebooks Found</h3>
            <p style="color: #6B7280; margin-top: 8px;">Click "Add Phonebook" or fetch your WhatsApp contacts to create one.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Add Phonebook / Contact -->
<div id="addModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0, 0.4); backdrop-filter: blur(8px); z-index: 100; align-items: center; justify-content: center;">
    <div class="glass-panel" style="width: 100%; max-width: 500px; padding: 40px; background: #ffffff; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
            <h2 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: #1F2937;">Add Phonebook / Contact</h2>
            <button style="background: transparent; border: none; color: #9CA3AF; cursor: pointer;" onclick="document.getElementById('addModal').style.display='none'">
                <i data-lucide="x"></i>
            </button>
        </div>
        
        <form action="/phonebook" method="POST">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #4B5563; font-weight: 700; font-size: 0.85rem;">Phonebook Name (Label)</label>
                <input type="text" name="labels" required placeholder="e.g. VIP Customers" style="width: 100%; background: #F9FAFB; border: 2px solid #E5E7EB; border-radius: 8px; padding: 12px 16px; color: #1F2937; outline: none; font-size: 0.95rem; font-weight: 600; transition: border 0.3s;" onfocus="this.style.borderColor='#2563EB'" onblur="this.style.borderColor='#E5E7EB'">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #4B5563; font-weight: 700; font-size: 0.85rem;">First Contact Name</label>
                <input type="text" name="name" required placeholder="e.g. Budi Santoso" style="width: 100%; background: #F9FAFB; border: 2px solid #E5E7EB; border-radius: 8px; padding: 12px 16px; color: #1F2937; outline: none; font-size: 0.95rem; font-weight: 500; transition: border 0.3s;" onfocus="this.style.borderColor='#2563EB'" onblur="this.style.borderColor='#E5E7EB'">
            </div>
            
            <div style="margin-bottom: 32px;">
                <label style="display: block; margin-bottom: 8px; color: #4B5563; font-weight: 700; font-size: 0.85rem;">First Contact Number</label>
                <input type="text" name="phone" required placeholder="6281234567890" style="width: 100%; background: #F9FAFB; border: 2px solid #E5E7EB; border-radius: 8px; padding: 12px 16px; color: #1F2937; outline: none; font-size: 0.95rem; font-weight: 500; transition: border 0.3s;" onfocus="this.style.borderColor='#2563EB'" onblur="this.style.borderColor='#E5E7EB'">
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 16px;">
                <button type="button" class="btn" style="background: transparent; color: #4B5563; font-weight: 700;" onclick="document.getElementById('addModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #2563EB; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700;">Save Phonebook</button>
            </div>
        </form>
    </div>
</div>


<script>
    // Lucide icons are initialized in app.blade.php
</script>
@endsection
