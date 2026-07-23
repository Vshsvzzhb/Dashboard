<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\QuickBlastController;
use App\Http\Controllers\TtsCallController;
use App\Http\Controllers\BlastHistoryController;

// ── Auth (from Breeze) ───────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Protected App Routes ──────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/wa-status', [DashboardController::class, 'waStatus']);

    // WA Engine Proxies
    Route::get('/wa-qr', function () {
        $apiUrl = \App\Services\WaEngineService::engineRoot();
        $sessionId = 'user_' . auth()->id();
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(5)->get($apiUrl . '/qr', [
                'session' => $sessionId
            ]);
            $body = $response->body();
            $body = str_replace('action="/logout', 'action="/wa-logout', $body);
            $body = str_replace('href="/status', 'href="/wa-status-raw', $body);
            return response($body);
        } catch (\Exception $e) {
            return response("Could not reach WA Engine: " . $e->getMessage(), 500);
        }
    });

    Route::post('/wa-logout', function (\Illuminate\Http\Request $request) {
        $apiUrl = \App\Services\WaEngineService::engineRoot();
        $session = $request->query('session');
        try {
            \Illuminate\Support\Facades\Http::post($apiUrl . '/logout?session=' . urlencode($session));
        } catch (\Exception $e) {}
        return redirect('/wa-qr?session=' . urlencode($session));
    });

    Route::get('/wa-status-raw', function (\Illuminate\Http\Request $request) {
        $apiUrl = \App\Services\WaEngineService::engineRoot();
        $session = $request->query('session');
        try {
            $response = \Illuminate\Support\Facades\Http::get($apiUrl . '/status?session=' . urlencode($session));
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });

    // Blast History
    Route::get('/blast-history', [BlastHistoryController::class, 'index']);
    Route::get('/blast-history/{blast}', [BlastHistoryController::class, 'show']);

    // Phonebook
    Route::get('/phonebook', [ContactController::class, 'index']);
    Route::get('/phonebook/show/{label}', [ContactController::class, 'show']);
    Route::post('/phonebook/fetch-wa', [ContactController::class, 'fetchWaGroups']);
    Route::post('/phonebook', [ContactController::class, 'store']);
    Route::post('/phonebook/import', [ContactController::class, 'import']);
    Route::delete('/phonebook/{contact}', [ContactController::class, 'destroy']);

    // Campaigns
    Route::get('/campaigns', [CampaignController::class, 'index']);
    Route::post('/campaigns', [CampaignController::class, 'store']);
    Route::post('/campaigns/{campaign}/status', [CampaignController::class, 'updateStatus']);
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy']);

    // WA Groups
    Route::get('/wa-groups', [App\Http\Controllers\WaGroupController::class, 'index']);
    Route::post('/wa-groups/fetch', [App\Http\Controllers\WaGroupController::class, 'fetch']);
    Route::post('/wa-groups/extract', [App\Http\Controllers\WaGroupController::class, 'extractContacts']);

    // Settings
    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings', [SettingController::class, 'save']);

    // Quick Blast
    Route::get('/quick-blast', [QuickBlastController::class, 'index']);
    Route::post('/quick-blast', [QuickBlastController::class, 'send']);

    // WebRTC Softphone
    Route::get('/webrtc', function () {
        return view('webrtc');
    });

    // TTS Call
    Route::post('/tts-call', [TtsCallController::class, 'call']);
});


require __DIR__.'/auth.php';
