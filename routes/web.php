<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Contact;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('login');
})->name('login.page');

Route::get('/login', function () {
    return redirect()->route('login.page');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard & Navigation Routes
|--------------------------------------------------------------------------
*/

// Dashboard dengan Data Realtime & Chart.js
Route::get('/dashboard', function () {
    $waContacts = class_exists(\App\Models\Contact::class) ? \App\Models\Contact::where('type', 'wa')->count() : 0;
    $smsContacts = class_exists(\App\Models\Contact::class) ? \App\Models\Contact::where('type', 'sms')->count() : 0;
    $totalContacts = $waContacts + $smsContacts;

    // Data aktivitas mingguan untuk Chart.js (S, M, T, W, T, F, S)
    $weeklyData = [0, 0, 0, 0, 0, 0, 0];
    if (class_exists(\App\Models\Blast::class)) {
        $blasts = \App\Models\Blast::where('created_at', '>=', now()->startOfWeek(0))->get();
        foreach ($blasts as $blast) {
            $dayOfWeek = $blast->created_at->dayOfWeek; // 0 (Sunday) to 6 (Saturday)
            // Add total recipients to that day
            $weeklyData[$dayOfWeek] += $blast->total;
        }
    }

    $recentHistories = class_exists(\App\Models\Blast::class) ? \App\Models\Blast::latest()->take(6)->get() : collect();

    return view('dashboard', compact('totalContacts', 'waContacts', 'smsContacts', 'weeklyData', 'recentHistories'));
})->name('dashboard');


// Quick Blast Routes
Route::get('/quick-blast', function () {
    try {
        $res = \Illuminate\Support\Facades\Http::timeout(3)->get('http://127.0.0.1:4000/sessions');
        $waDevices = $res->successful() ? ($res->json('data') ?? []) : [];
    } catch (\Exception $e) {
        $waDevices = [];
    }
    return view('quick-blast', compact('waDevices'));
})->name('quick.blast');


Route::post('/quick-blast/send', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'phone'   => 'required|string',
        'message' => 'required|string',
    ]);

    $phone   = preg_replace('/\D/', '', $request->phone);
    $message = $request->message;
    $session = $request->input('session', 'default');

    try {
        $http = \Illuminate\Support\Facades\Http::timeout(10)
            ->post('http://127.0.0.1:4000/send-message', [
                'phone'   => $phone,
                'message' => $message,
                'session' => $session,
            ]);

        $success = $http->successful() && ($http->json('success') ?? false);

        // Simpan ke blast history
        \App\Models\Blast::create([
            'message'    => $message,
            'recipients' => json_encode([$phone]),
            'total'      => 1,
            'sent'       => $success ? 1 : 0,
            'failed'     => $success ? 0 : 1,
            'status'     => $success ? 'done' : 'failed',
            'type'       => 'whatsapp',
            'session'    => $session,
        ]);

        if ($success) {
            return back()->with('success', "Pesan berhasil dikirim ke {$phone}!");
        }

        $err = $http->json('error') ?? 'Gagal mengirim pesan.';
        return back()->with('error', $err)->withInput();

    } catch (\Exception $e) {
        // Catat kegagalan juga
        \App\Models\Blast::create([
            'message'    => $message,
            'recipients' => json_encode([$phone]),
            'total'      => 1,
            'sent'       => 0,
            'failed'     => 1,
            'status'     => 'failed',
            'type'       => 'whatsapp',
            'session'    => $session,
        ]);
        return back()->with('error', 'WA Engine tidak dapat dihubungi. Pastikan wa-engine berjalan di port 4000.')->withInput();
    }
})->name('quick.blast.send');


Route::get('/blast-history', function () {
    $blasts = \App\Models\Blast::latest()->paginate(20);
    return view('blast-history', compact('blasts'));
})->name('blast.history');

// WhatsApp Phonebook Routes
Route::get('/phonebook', function () {
    $phonebooks = \App\Models\Phonebook::withCount('contacts')->where('type', 'wa')->latest()->get();
    return view('phonebook', compact('phonebooks'));
})->name('phonebook');

Route::post('/phonebook', function (\Illuminate\Http\Request $request) {
    $request->validate(['name' => 'required|string|max:100', 'description' => 'nullable|string|max:255']);
    \App\Models\Phonebook::create(['name' => $request->name, 'description' => $request->description, 'type' => 'wa']);
    return back()->with('success', 'Phonebook berhasil dibuat!');
})->name('phonebook.store');

Route::delete('/phonebook/{phonebook}', function (\App\Models\Phonebook $phonebook) {
    $phonebook->contacts()->delete();
    $phonebook->delete();
    return back()->with('success', 'Phonebook berhasil dihapus.');
})->name('phonebook.destroy');

// Contacts per phonebook
Route::get('/phonebook/{phonebook}/contacts', function (\App\Models\Phonebook $phonebook) {
    $contacts = $phonebook->contacts()->latest()->get();
    return view('phonebook-contacts', compact('phonebook', 'contacts'));
})->name('phonebook.contacts');

Route::post('/phonebook/{phonebook}/contacts', function (\Illuminate\Http\Request $request, \App\Models\Phonebook $phonebook) {
    $request->validate([
        'name'  => 'required|string|max:100',
        'phone' => 'required|string|max:30',
    ]);
    $phone = preg_replace('/\D/', '', $request->phone);
    // Cek duplikat dalam phonebook ini
    if ($phonebook->contacts()->where('phone', $phone)->exists()) {
        return back()->with('error', 'Nomor '.$phone.' sudah ada di grup ini.')->withInput();
    }
    $phonebook->contacts()->create(['name' => $request->name, 'phone' => $phone, 'type' => 'wa']);
    return back()->with('success', 'Kontak berhasil ditambahkan!');
})->name('phonebook.contacts.store');

Route::delete('/phonebook/{phonebook}/contacts/{contact}', function (\App\Models\Phonebook $phonebook, \App\Models\Contact $contact) {
    abort_if($contact->phonebook_id !== $phonebook->id, 403);
    $contact->delete();
    return back()->with('success', 'Kontak dihapus.');
})->name('phonebook.contacts.destroy');


Route::get('/wa-connect', function () {
    $apiUrl = 'http://' . request()->getHost() . ':4000';
    return view('wa-connect', compact('apiUrl'));
})->name('wa.connect');

Route::get('/campaigns', function () {
    $campaigns  = \App\Models\Campaign::with('phonebook')->latest()->get();
    $phonebooks = \App\Models\Phonebook::where('type', 'wa')->withCount('contacts')->get();
    try {
        $res        = \Illuminate\Support\Facades\Http::timeout(3)->get('http://127.0.0.1:4000/sessions');
        $waDevices  = $res->successful() ? array_filter($res->json('data') ?? [], fn($d) => $d['connected'] ?? false) : [];
    } catch (\Exception $e) { $waDevices = []; }
    return view('campaigns', compact('campaigns', 'phonebooks', 'waDevices'));
})->name('campaigns');

Route::post('/campaigns', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name'         => 'required|string|max:100',
        'message'      => 'required|string',
        'phonebook_id' => 'required|exists:phonebooks,id',
        'session'      => 'required|string',
        'scheduled_at' => 'required|date|after:now',
    ]);
    $pb = \App\Models\Phonebook::withCount('contacts')->findOrFail($data['phonebook_id']);
    \App\Models\Campaign::create([
        ...$data,
        'target_audience' => $pb->name,
        'status'          => 'paused',
        'total_count'     => $pb->contacts_count,
        'sent_count'      => 0,
    ]);
    return back()->with('success', 'Campaign berhasil dijadwalkan!');
})->name('campaigns.store');

Route::delete('/campaigns/{campaign}', function (\App\Models\Campaign $campaign) {
    $campaign->delete();
    return back()->with('success', 'Campaign dihapus.');
})->name('campaigns.destroy');

Route::patch('/campaigns/{campaign}/toggle', function (\App\Models\Campaign $campaign) {
    $newStatus = $campaign->status === 'paused' ? 'running' : 'paused';
    $campaign->update(['status' => $newStatus]);
    
    if ($newStatus === 'running') {
        // Trigger background dispatch so user doesn't have to wait for cron
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            pclose(popen('cmd /c start /B php artisan campaign:dispatch > NUL 2>&1', 'r'));
        } else {
            exec('php artisan campaign:dispatch > /dev/null 2>&1 &');
        }
    }
    
    return back()->with('success', 'Status campaign diperbarui.');
})->name('campaigns.toggle');


Route::get('/wa-groups', function (\Illuminate\Http\Request $request) {
    // Fetch active sessions for device dropdown first
    try {
        $res = \Illuminate\Support\Facades\Http::timeout(3)->get('http://127.0.0.1:4000/sessions');
        $waDevices = $res->successful() ? array_filter($res->json('data') ?? [], fn($d) => $d['connected'] ?? false) : [];
    } catch (\Exception $e) { $waDevices = []; }
    
    // Auto-select first connected device if no session is explicitly requested
    $session = $request->query('session');
    if (!$session) {
        $session = !empty($waDevices) ? array_values($waDevices)[0]['id'] : 'default';
    }

    try {
        $res = \Illuminate\Support\Facades\Http::timeout(5)->get("http://127.0.0.1:4000/groups?session={$session}");
        $groups = $res->successful() ? $res->json('data') ?? [] : [];
    } catch (\Exception $e) {
        $groups = [];
    }
    
    return view('wa-groups', compact('groups', 'waDevices', 'session'));
})->name('wa.groups');

Route::post('/wa-groups/{groupId}/extract', function (\Illuminate\Http\Request $request, $groupId) {
    $session = $request->input('session', 'default');
    $groupName = $request->input('group_name', 'Extracted Group');
    
    try {
        $res = \Illuminate\Support\Facades\Http::timeout(15)->get("http://127.0.0.1:4000/groups/{$groupId}/members?session={$session}");
        if ($res->successful() && $res->json('success')) {
            $members = $res->json('data') ?? [];
            if (empty($members)) {
                return back()->with('error', 'Grup kosong atau gagal mengambil anggota.');
            }
            
            // Buat phonebook baru
            $pb = \App\Models\Phonebook::create([
                'name' => 'WA Group: ' . substr($groupName, 0, 80),
                'description' => 'Diekstrak otomatis dari WA Group (' . count($members) . ' kontak)',
                'type' => 'wa'
            ]);
            
            // Insert contacts
            $contacts = [];
            $now = now();
            foreach ($members as $m) {
                // Backward compatibility just in case wa-engine hasn't restarted yet
                $phoneNum = is_array($m) ? ($m['phone'] ?? '') : $m;
                $contactName = is_array($m) ? ($m['name'] ?? $phoneNum) : $phoneNum;
                
                if (empty($phoneNum)) continue;
                
                $contacts[] = [
                    'phonebook_id' => $pb->id,
                    'name'         => $contactName, 
                    'phone'        => $phoneNum,
                    'type'         => 'wa',
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }
            
            foreach (array_chunk($contacts, 500) as $chunk) {
                \App\Models\Contact::insert($chunk);
            }
            
            return redirect()->route('phonebook.contacts', $pb)->with('success', count($members) . ' kontak berhasil diekstrak dan disimpan ke phonebook baru.');
        }
        return back()->with('error', 'Gagal ekstrak kontak dari wa-engine.');
    } catch (\Exception $e) {
        return back()->with('error', 'Koneksi ke wa-engine gagal: ' . $e->getMessage());
    }
})->name('wa.groups.extract');

// SMS Gateway Routes
Route::get('/phonebook-sms', function () {
    return view('phonebook-sms');
})->name('sms.phonebook');

Route::get('/sms-connect', function () {
    return view('sms-connect');
})->name('sms.connect');

Route::get('/sms-campaigns', function () {
    return view('sms-campaigns');
})->name('sms.campaigns');

Route::get('/sms-autoresponder', function () {
    return view('sms-autoresponder');
})->name('sms.autoresponder');

// WebRTC Routes
Route::get('/webrtc', function () {
    return view('webrtc');
})->name('webrtc.phone');

Route::get('/webrtc-history', function (\Illuminate\Http\Request $request) {
    $calls = class_exists(\App\Models\WebrtcCall::class) ? \App\Models\WebrtcCall::latest()->paginate(15) : collect();
    
    if ($request->ajax()) {
        return view('partials.webrtc-table-rows', compact('calls'))->render();
    }
    
    return view('webrtc-history', compact('calls'));
})->name('webrtc.history');

Route::delete('/webrtc-history/clear', function () {
    if (class_exists(\App\Models\WebrtcCall::class)) {
        \App\Models\WebrtcCall::truncate();
    }
    return back()->with('success', 'Call history cleared successfully.');
})->name('webrtc.history.clear');

// TTS Call
Route::post('/tts-call', [\App\Http\Controllers\TtsCallController::class, 'call']);

// Settings Route
Route::get('/settings/gateways', function () {
    return view('gateways');
})->name('gateways.settings');