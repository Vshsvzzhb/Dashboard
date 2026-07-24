@extends('layouts.app')

@section('content')
<div class="page-container" style="background: #F8F9FD; min-height: 100vh; padding: 24px;">
    
    @if(session('success'))
    <div style="background: #E6FBF5; border: 1px solid #A7F3D0; color: var(--accent-green); padding: 16px 24px; border-radius: 12px; margin-bottom: 28px; display: flex; align-items: center; gap: 12px;">
        <i data-lucide="check-circle-2" style="color: var(--accent-green); flex-shrink: 0;"></i>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif

    <div style="margin-bottom: 16px;">
        <a href="/phonebook" style="color: #6B7280; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 0.9rem;">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
            Back to Phonebooks
        </a>
    </div>

    <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 24px;">
        
        <!-- Header Row -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #374151; margin: 0; display: flex; align-items: center; gap: 8px;">
                PhoneBook : <span style="color: #1F2937;">{{ $label }}</span>
            </h2>
            
            <div style="display: flex; gap: 12px;">
                <button class="btn" style="background: #0066FF; color: white; border: none; border-radius: 4px; padding: 10px 16px; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 6px; cursor: pointer;" onclick="document.getElementById('addToPhonebookModal').style.display='flex'">
                    <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                    ADD CONTACT
                </button>
                <button class="btn" style="background: #10B981; color: white; border: none; border-radius: 4px; padding: 10px 16px; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 6px; cursor: pointer;" onclick="document.getElementById('importCsvModal').style.display='flex'">
                    <i data-lucide="file-text" style="width: 16px; height: 16px;"></i>
                    IMPORT CSV
                </button>
            </div>
        </div>

        <!-- Controls Row -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <div style="color: #6B7280; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
                Show 
                <select style="border: 1px solid #E5E7EB; border-radius: 4px; padding: 4px 8px; color: #374151; outline: none;">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                entries
            </div>
            
            <div style="color: #6B7280; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
                Search:
                <input type="text" style="border: 1px solid #E5E7EB; border-radius: 4px; padding: 4px 8px; outline: none; width: 200px;">
            </div>
        </div>

        <!-- Table -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid #E5E7EB; border-top: 1px solid #E5E7EB;">
                        <th style="padding: 16px 8px; color: #6B7280; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; width: 40px;">
                            <input type="checkbox" style="width: 16px; height: 16px; border-radius: 4px; border: 1px solid #D1D5DB;">
                        </th>
                        <th style="padding: 16px 8px; color: #6B7280; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Name</th>
                        <th style="padding: 16px 8px; color: #6B7280; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Salutation</th>
                        <th style="padding: 16px 8px; color: #6B7280; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Number</th>
                        <th style="padding: 16px 8px; color: #6B7280; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                        <th style="padding: 16px 8px; color: #6B7280; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 16px 8px;">
                            <input type="checkbox" style="width: 16px; height: 16px; border-radius: 4px; border: 1px solid #D1D5DB;">
                        </td>
                        <td style="padding: 16px 8px; color: #374151; font-size: 0.9rem;">{{ $contact->name ?: '-' }}</td>
                        <td style="padding: 16px 8px; color: #6B7280; font-size: 0.9rem;">-</td>
                        <td style="padding: 16px 8px; color: #9CA3AF; font-size: 0.9rem;">{{ $contact->phone }}</td>
                        <td style="padding: 16px 8px; color: #9CA3AF; font-size: 0.9rem;">
                            @if(str_contains($contact->phone, '@g.us'))
                                <span style="background: #E0F2FE; color: #0284C7; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">Group</span>
                            @else
                                <span style="background: #F3F4F6; color: #4B5563; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">Personal</span>
                            @endif
                        </td>
                        <td style="padding: 16px 8px; display: flex; gap: 8px; align-items: center;">
                            <button style="background: #0066FF; border: none; color: white; width: 32px; height: 32px; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Edit Contact">
                                <i data-lucide="edit-2" style="width: 14px; height: 14px;"></i>
                            </button>
                            <form action="/phonebook/{{ $contact->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contact?')" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #EF4444; border: none; color: white; width: 32px; height: 32px; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Delete Contact">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 32px; text-align: center; color: #6B7280;">
                            No contacts in this phonebook. Click "Add Contact" to add some.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>
</div>

<!-- Modal Add Contact to Specific Phonebook -->
<div id="addToPhonebookModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0, 0.4); backdrop-filter: blur(8px); z-index: 100; align-items: center; justify-content: center;">
    <div class="glass-panel" style="width: 100%; max-width: 500px; padding: 40px; background: #ffffff; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
            <div>
                <h2 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: #1F2937;">Add Contact</h2>
                <p style="color: #6B7280; font-size: 0.85rem; margin-top: 4px;">to Phonebook: <strong style="color: #0066FF;">{{ $label }}</strong></p>
            </div>
            <button style="background: transparent; border: none; color: #9CA3AF; cursor: pointer;" onclick="document.getElementById('addToPhonebookModal').style.display='none'">
                <i data-lucide="x"></i>
            </button>
        </div>
        
        <form action="/phonebook" method="POST">
            @csrf
            <input type="hidden" name="labels" value="{{ $label }}">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #4B5563; font-weight: 700; font-size: 0.85rem;">Contact Name</label>
                <input type="text" name="name" required placeholder="e.g. Siti Aminah" style="width: 100%; background: #F9FAFB; border: 2px solid #E5E7EB; border-radius: 8px; padding: 12px 16px; color: #1F2937; outline: none; font-size: 0.95rem; font-weight: 500; transition: border 0.3s;" onfocus="this.style.borderColor='#0066FF'" onblur="this.style.borderColor='#E5E7EB'">
            </div>
            
            <div style="margin-bottom: 32px;">
                <label style="display: block; margin-bottom: 8px; color: #4B5563; font-weight: 700; font-size: 0.85rem;">WhatsApp Number</label>
                <input type="text" name="phone" required placeholder="6281234567890" style="width: 100%; background: #F9FAFB; border: 2px solid #E5E7EB; border-radius: 8px; padding: 12px 16px; color: #1F2937; outline: none; font-size: 0.95rem; font-weight: 500; transition: border 0.3s;" onfocus="this.style.borderColor='#0066FF'" onblur="this.style.borderColor='#E5E7EB'">
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 16px;">
                <button type="button" class="btn" style="background: transparent; color: #4B5563; font-weight: 700;" onclick="document.getElementById('addToPhonebookModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #0066FF; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700;">Save Contact</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Import CSV -->
<div id="importCsvModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0, 0.4); backdrop-filter: blur(8px); z-index: 100; align-items: center; justify-content: center;">
    <div class="glass-panel" style="width: 100%; max-width: 500px; padding: 40px; background: #ffffff; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
            <div>
                <h2 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: #1F2937;">Import Contacts (CSV)</h2>
                <p style="color: #6B7280; font-size: 0.85rem; margin-top: 4px;">to Phonebook: <strong style="color: #10B981;">{{ $label }}</strong></p>
            </div>
            <button style="background: transparent; border: none; color: #9CA3AF; cursor: pointer;" onclick="document.getElementById('importCsvModal').style.display='none'">
                <i data-lucide="x"></i>
            </button>
        </div>
        
        <form action="/phonebook/import" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="label" value="{{ $label }}">
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; color: #4B5563; font-weight: 700; font-size: 0.85rem;">Select CSV File</label>
                <input type="file" name="file" required accept=".csv" style="width: 100%; background: #F9FAFB; border: 2px solid #E5E7EB; border-radius: 8px; padding: 12px 16px; color: #1F2937; outline: none; font-size: 0.95rem; font-weight: 500;">
                <p style="color: #9CA3AF; font-size: 0.75rem; margin-top: 6px;">Format CSV harus memiliki header: <strong>name, phone</strong></p>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 16px;">
                <button type="button" class="btn" style="background: transparent; color: #4B5563; font-weight: 700;" onclick="document.getElementById('importCsvModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn" style="background: #10B981; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700; cursor: pointer;">Upload & Import</button>
            </div>
        </form>
    </div>
</div>
@endsection
