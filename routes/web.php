<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageTemplateController;
use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\MediaLibraryController;
use App\Http\Controllers\LinkTrackerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\AutoResponderController;
use App\Http\Controllers\VoipUserController;
use App\Http\Controllers\SmsProviderController;
use App\Http\Controllers\TtsCallController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\QuickBlastController;
use App\Http\Controllers\PhonebookController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SmsCampaignController;
use App\Http\Controllers\TtsCampaignController;
use App\Http\Controllers\WaGroupController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest only)
|--------------------------------------------------------------------------
*/
Route::get('/landing', function () {
    return view('landing');
})->name('landing');

// Public blog routes
Route::get('/blog/{slug}', function (string $slug) {
    $posts = config('blog.posts', []);
    $post  = collect($posts)->firstWhere('slug', $slug);
    if (!$post) abort(404);
    $related = collect($posts)->where('slug', '!=', $slug)->take(2)->values()->all();
    return view('blog-post', compact('post', 'related'));
})->name('blog.post');

Route::get('/blog', function () {
    return redirect(url('/') . '#blog');
})->name('blog.index');


Route::middleware(['guest', 'throttle:30,1'])->group(function () {
    Route::get('/', function () {
        return response(view('landing'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    });

    Route::get('/login', function () {
        return response(view('login'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    })->name('login.page');

    Route::get('/register', function () { return redirect()->route('login.page'); });
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('verify-otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp.process');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend-otp');

    // Forgot Password & Reset via OTP
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp'])->name('password.email');
    Route::get('/reset-password-otp', [AuthController::class, 'showResetPasswordOtpForm'])->name('password.reset.otp');
    Route::post('/reset-password-otp', [AuthController::class, 'resetPasswordWithOtp'])->name('password.update.otp');
    Route::post('/resend-reset-otp', [AuthController::class, 'resendResetOtp'])->name('password.resend.otp');
});

// Public Tracked Link Redirect
Route::get('/r/{code}', [LinkTrackerController::class, 'redirect'])->name('links.redirect');

Route::match(['GET', 'POST'], '/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard & Navigation Routes (Auth required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/fetch-devices', [DashboardController::class, 'fetchDevicesStatus'])->name('dashboard.fetch-devices');

    // Team Management (Role-Based Access Control) - Owner only
    Route::middleware('role:owner')->group(function () {
        Route::get('/team', [TeamController::class, 'index'])->name('team.index');
        Route::post('/team', [TeamController::class, 'store'])->name('team.store');
        Route::put('/team/{id}', [TeamController::class, 'update'])->name('team.update');
        Route::delete('/team/{id}', [TeamController::class, 'destroy'])->name('team.destroy');
    });

    // Quick Blast (Owner, Manager, Sales)
    Route::middleware('role:owner,manager,sales')->group(function () {
        Route::get('/quick-blast', [QuickBlastController::class, 'index'])->name('quick.blast');
        Route::post('/quick-blast/send', [QuickBlastController::class, 'send'])->name('quick.blast.send');
        Route::get('/blast-history', function (\Illuminate\Http\Request $request) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $ownerId = $user->isOwner() ? $user->id : ($user->parent_id ?? 1);
            
            $query = \App\Models\Blast::query();
            $staffList = collect();
            $isSupervisor = $user->isOwner() || $user->hasRole('manager');

            if ($isSupervisor) {
                $teamUserIds = \App\Models\User::where('parent_id', $ownerId)->orWhere('id', $ownerId)->pluck('id')->toArray();
                $staffList = \App\Models\User::whereIn('id', $teamUserIds)->select('id', 'name', 'role')->get();

                if ($request->filled('staff_id') && in_array((int)$request->staff_id, $teamUserIds)) {
                    $query->where('user_id', (int)$request->staff_id);
                } else {
                    $query->whereIn('user_id', $teamUserIds);
                }
            } else {
                $query->where('user_id', $user->id);
            }

            $total = (clone $query)->count();
            $sent = (clone $query)->where('status', 'done')->count();
            $failed = (clone $query)->where('status', 'failed')->count();
            $stats = compact('total', 'sent', 'failed');

            $blasts = $query->with('user:id,name,role')->latest()->paginate(20)->withQueryString();
            return view('blast-history', compact('blasts', 'staffList', 'isSupervisor', 'stats'));
        })->name('blast.history');
    });

    // WhatsApp Phonebook
    Route::get('/phonebook', [PhonebookController::class, 'indexWa'])->name('phonebook');
    Route::post('/phonebook', [PhonebookController::class, 'storeWa'])->name('phonebook.store');
    Route::delete('/phonebook/{phonebook}', [PhonebookController::class, 'destroyWa'])->name('phonebook.destroy');
    Route::get('/phonebook/{phonebook}/contacts', [PhonebookController::class, 'contactsWa'])->name('phonebook.contacts');
    Route::post('/phonebook/{phonebook}/contacts', [PhonebookController::class, 'storeContactWa'])->name('phonebook.contacts.store');
    Route::delete('/phonebook/{phonebook}/contacts/{contact}', [PhonebookController::class, 'destroyContactWa'])->name('phonebook.contacts.destroy');
    Route::post('/phonebook/{phonebook}/import', [PhonebookController::class, 'importContacts'])->name('phonebook.contacts.import');
    Route::get('/phonebook/{phonebook}/export', [PhonebookController::class, 'exportContacts'])->name('phonebook.contacts.export');
    Route::get('/phonebook/{phonebook}/contacts-json', [PhonebookController::class, 'contactsJson'])->name('phonebook.contacts.json');

    // WA Connect Page (Owner only)
    Route::middleware('role:owner')->get('/wa-connect', function (\Illuminate\Http\Request $request) {
        $userId = \Illuminate\Support\Facades\Auth::id();
        $waEngineUrl = config('services.wa_engine.url');
        $apiUrl = (request()->isSecure() || !app()->isLocal()) ? '/wa-engine' : $waEngineUrl;
        $waDevices = [];
        try {
            $res = \Illuminate\Support\Facades\Http::connectTimeout(2)->timeout(3)->get($waEngineUrl . '/sessions?user_id=' . $userId);
            $waDevices = $res->successful() ? ($res->json('data') ?? []) : [];
        } catch (\Exception $e) {}
        
        $session = $request->query('session');
        if (!$session && !empty($waDevices)) $session = $waDevices[0]['id'];
        else if (!$session) $session = ($userId == 1 ? 'default' : 'u' . $userId . '_default');
        return view('wa-connect', compact('apiUrl', 'session', 'waDevices', 'userId'));
    })->name('wa.connect');

    // Campaigns (Owner, Manager, Sales)
    Route::middleware('role:owner,manager,sales')->group(function () {
        Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
        Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
        Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');
        Route::patch('/campaigns/{campaign}/toggle', [CampaignController::class, 'toggle'])->name('campaigns.toggle');
        Route::post('/campaigns/{campaign}/resend', [CampaignController::class, 'resend'])->name('campaigns.resend');
    });

    // WA Groups
    Route::get('/wa-groups', [WaGroupController::class, 'index'])->name('wa.groups');
    Route::post('/wa-groups/{groupId}/extract', [WaGroupController::class, 'extract'])->name('wa.groups.extract');

    // SMS Phonebook
    Route::get('/phonebook-sms', [PhonebookController::class, 'indexSms'])->name('sms.phonebook');
    Route::post('/phonebook-sms', [PhonebookController::class, 'storeSms'])->name('sms.phonebook.store');
    Route::delete('/phonebook-sms/{phonebook}', [PhonebookController::class, 'destroySms'])->name('sms.phonebook.destroy');
    Route::get('/phonebook-sms/{phonebook}/contacts', [PhonebookController::class, 'contactsSms'])->name('sms.phonebook.contacts');
    Route::post('/phonebook-sms/{phonebook}/contacts', [PhonebookController::class, 'storeContactSms'])->name('sms.phonebook.contacts.store');
    Route::delete('/phonebook-sms/{phonebook}/contacts/{contact}', [PhonebookController::class, 'destroyContactSms'])->name('sms.phonebook.contacts.destroy');
    Route::post('/phonebook-sms/{phonebook}/import', [PhonebookController::class, 'importContacts'])->name('sms.phonebook.contacts.import');
    Route::get('/phonebook-sms/{phonebook}/export', [PhonebookController::class, 'exportContacts'])->name('sms.phonebook.contacts.export');

    // SMS Connect (Owner only)
    Route::middleware('role:owner')->group(function () {
        Route::get('/sms-connect', [SmsProviderController::class, 'index'])->name('sms.connect');
        Route::post('/sms-connect', [SmsProviderController::class, 'store'])->name('sms.connect.store');
        Route::post('/sms-connect/test', [SmsProviderController::class, 'test'])->name('sms.connect.test');
    });

    // SMS Campaigns (Owner, Manager, Sales)
    Route::middleware('role:owner,manager,sales')->group(function () {
        Route::get('/sms-campaigns', [SmsCampaignController::class, 'index'])->name('sms.campaigns');
        Route::post('/sms-campaigns', [SmsCampaignController::class, 'store'])->name('sms.campaigns.store');
        Route::delete('/sms-campaigns/{campaign}', [SmsCampaignController::class, 'destroy'])->name('sms.campaigns.destroy');
        Route::patch('/sms-campaigns/{campaign}/toggle', [SmsCampaignController::class, 'toggle'])->name('sms.campaigns.toggle');
        Route::post('/sms-campaigns/{campaign}/resend', [SmsCampaignController::class, 'resend'])->name('sms.campaigns.resend');
    });
    Route::get('/sms-autoresponder', function () { return redirect()->route('autoresponder.index'); })->name('sms.autoresponder');

    // Auto Responder (Owner, Manager, CS)
    Route::middleware('role:owner,manager,cs')->group(function () {
        Route::get('/autoresponder', [AutoResponderController::class, 'index'])->name('autoresponder.index');
        Route::post('/autoresponder', [AutoResponderController::class, 'store'])->name('autoresponder.store');
        Route::put('/autoresponder/{id}', [AutoResponderController::class, 'update'])->name('autoresponder.update');
        Route::delete('/autoresponder/{id}', [AutoResponderController::class, 'destroy'])->name('autoresponder.destroy');
        Route::patch('/autoresponder/{id}/toggle', [AutoResponderController::class, 'toggle'])->name('autoresponder.toggle');
        Route::post('/autoresponder/test', [AutoResponderController::class, 'testSimulator'])->name('autoresponder.test');
    });

    // WebRTC
    Route::get('/webrtc', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        $voipUsers = collect();
        $recentCalls = collect();

        try {
            if (class_exists(\App\Models\VoipUser::class)) {
                $voipUsers = \App\Models\VoipUser::all();
            }
        } catch (\Throwable $e) {}

        try {
            if (class_exists(\App\Models\WebrtcCall::class) && $user) {
                $recentCalls = \App\Models\WebrtcCall::where('user_id', $user->id)->latest()->take(6)->get();
            }
        } catch (\Throwable $e) {}

        return view('webrtc', compact('voipUsers', 'recentCalls'));
    })->name('webrtc.phone');
    Route::get('/webrtc-history', function (\Illuminate\Http\Request $request) {
        $user = \Illuminate\Support\Facades\Auth::user();
        $ownerId = $user->isOwner() ? $user->id : ($user->parent_id ?? 1);
        $isSupervisor = $user->isOwner() || $user->hasRole('manager');
        $staffList = collect();

        if (class_exists(\App\Models\WebrtcCall::class)) {
            $query = \App\Models\WebrtcCall::query();
            if ($isSupervisor) {
                $teamUserIds = \App\Models\User::where('parent_id', $ownerId)->orWhere('id', $ownerId)->pluck('id')->toArray();
                $staffList = \App\Models\User::whereIn('id', $teamUserIds)->select('id', 'name', 'role', 'asterisk_exten')->get();

                if ($request->filled('staff_id') && in_array((int)$request->staff_id, $teamUserIds)) {
                    $query->where('user_id', (int)$request->staff_id);
                } else {
                    $query->whereIn('user_id', $teamUserIds);
                }
            } else {
                $query->where('user_id', $user->id);
            }
            $calls = $query->with('user:id,name,role,asterisk_exten')->latest()->paginate(15)->withQueryString();
        } else {
            $calls = collect();
        }

        if ($request->ajax()) return view('partials.webrtc-table-rows', compact('calls', 'isSupervisor'))->render();
        return view('webrtc-history', compact('calls', 'staffList', 'isSupervisor'));
    })->name('webrtc.history');
    Route::post('/webrtc-history/log', function (\Illuminate\Http\Request $request) {
        $data = $request->validate([
            'caller'     => 'required|string|max:50',
            'recipient'  => 'required|string|max:50',
            'duration'   => 'required|string|max:20',
            'status'     => 'required|string|max:50',
            'transcript' => 'nullable|string',
        ]);
        $data['user_id'] = \Illuminate\Support\Facades\Auth::id();
        $call = \App\Models\WebrtcCall::create($data);
        return response()->json(['success' => true, 'data' => $call]);
    })->name('webrtc.history.log');
    Route::delete('/webrtc-history/clear', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (class_exists(\App\Models\WebrtcCall::class)) {
            if ($user->isOwner()) {
                $ownerId = $user->id;
                $teamUserIds = \App\Models\User::where('parent_id', $ownerId)->orWhere('id', $ownerId)->pluck('id')->toArray();
                \App\Models\WebrtcCall::whereIn('user_id', $teamUserIds)->delete();
            } else {
                \App\Models\WebrtcCall::where('user_id', $user->id)->delete();
            }
        }
        return back()->with('success', 'Riwayat panggilan berhasil dibersihkan.');
    })->name('webrtc.history.clear');
    
    Route::post('/tts-call', [TtsCallController::class, 'call']);
    Route::match(['get', 'post'], '/tts-preview', [TtsCallController::class, 'preview'])->name('tts.preview');

    // TTS Voice Campaigns (Owner, Manager, Sales)
    Route::middleware('role:owner,manager,sales')->group(function () {
        Route::get('/tts-campaigns', [TtsCampaignController::class, 'index'])->name('tts.campaigns');
        Route::post('/tts-campaigns', [TtsCampaignController::class, 'store'])->name('tts.campaigns.store');
        Route::delete('/tts-campaigns/{campaign}', [TtsCampaignController::class, 'destroy'])->name('tts.campaigns.destroy');
        Route::patch('/tts-campaigns/{campaign}/toggle', [TtsCampaignController::class, 'toggle'])->name('tts.campaigns.toggle');
        Route::post('/tts-campaigns/{campaign}/resend', [TtsCampaignController::class, 'resend'])->name('tts.campaigns.resend');
    });

    // VoIP / TTS Phonebook
    Route::get('/phonebook-tts', [PhonebookController::class, 'indexTts'])->name('tts.phonebook');
    Route::post('/phonebook-tts', [PhonebookController::class, 'storeTts'])->name('tts.phonebook.store');
    Route::delete('/phonebook-tts/{phonebook}', [PhonebookController::class, 'destroyTts'])->name('tts.phonebook.destroy');
    Route::get('/phonebook-tts/{phonebook}/contacts', [PhonebookController::class, 'contactsTts'])->name('tts.phonebook.contacts');
    Route::post('/phonebook-tts/{phonebook}/contacts', [PhonebookController::class, 'storeContactTts'])->name('tts.phonebook.contacts.store');
    Route::delete('/phonebook-tts/{phonebook}/contacts/{contact}', [PhonebookController::class, 'destroyContactTts'])->name('tts.phonebook.contacts.destroy');
    Route::post('/phonebook-tts/{phonebook}/import', [PhonebookController::class, 'importContactsTts'])->name('tts.phonebook.contacts.import');
    Route::get('/phonebook-tts/{phonebook}/export', [PhonebookController::class, 'exportContacts'])->name('tts.phonebook.contacts.export');


    // VoIP Users (Owner only)
    Route::middleware('role:owner')->group(function () {
        Route::get('/voip/users', [VoipUserController::class, 'index'])->name('voip.users.index');
        Route::post('/voip/users', [VoipUserController::class, 'store'])->name('voip.users.store');
        Route::delete('/voip/users/{id}', [VoipUserController::class, 'destroy'])->name('voip.users.destroy');
    });

    // Settings (Owner only)
    Route::middleware('role:owner')->group(function () {
        Route::get('/settings/gateways', [SettingController::class, 'gateways'])->name('gateways.settings');
        Route::post('/settings/gateways/wa', [SettingController::class, 'storeWa'])->name('settings.gateways.wa');
        Route::post('/settings/gateways/wa/test', [SettingController::class, 'testWa'])->name('settings.gateways.wa.test');
        Route::post('/settings/gateways/sms', [SettingController::class, 'storeSms'])->name('settings.gateways.sms');
        Route::post('/settings/gateways/sms/test', [SettingController::class, 'testSms'])->name('settings.gateways.sms.test');
    });

    // Templates (All roles)
    Route::get('/templates', [MessageTemplateController::class, 'index'])->name('templates.index');
    Route::post('/templates', [MessageTemplateController::class, 'store'])->name('templates.store');
    Route::put('/templates/{template}', [MessageTemplateController::class, 'update'])->name('templates.update');
    Route::delete('/templates/{template}', [MessageTemplateController::class, 'destroy'])->name('templates.destroy');

    // CRM & Marketing (Owner, Manager, Sales)
    Route::middleware('role:owner,manager,sales')->group(function () {
        Route::get('/blacklist', [BlacklistController::class, 'index'])->name('blacklist');
        Route::post('/blacklist', [BlacklistController::class, 'store'])->name('blacklist.store');
        Route::patch('/blacklist/{contact}/unblock', [BlacklistController::class, 'unblock'])->name('blacklist.unblock');
        Route::patch('/blacklist/{contact}/block', [BlacklistController::class, 'block'])->name('blacklist.block');

        Route::get('/media', [MediaLibraryController::class, 'index'])->name('media.index');
        Route::post('/media', [MediaLibraryController::class, 'store'])->name('media.store');
        Route::delete('/media/{mediaFile}', [MediaLibraryController::class, 'destroy'])->name('media.destroy');

        Route::get('/link-tracker', [LinkTrackerController::class, 'index'])->name('links.index');
        Route::post('/link-tracker', [LinkTrackerController::class, 'store'])->name('links.store');
        Route::delete('/link-tracker/{trackedLink}', [LinkTrackerController::class, 'destroy'])->name('links.destroy');

        Route::get('/leads', [ContactController::class, 'index'])->name('leads.index');
        Route::patch('/leads/{contact}/score', [ContactController::class, 'updateScore'])->name('leads.update-score');
        Route::post('/leads/score-all', [ContactController::class, 'recalculateAll'])->name('leads.score-all');

        Route::get('/pipeline', [PipelineController::class, 'index'])->name('pipeline');
        Route::patch('/pipeline/{contact}', [PipelineController::class, 'update'])->name('pipeline.update');
        Route::post('/pipeline/add', [PipelineController::class, 'add'])->name('pipeline.add');
    });

    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::patch('/contacts/{contact}/labels', [ContactController::class, 'updateLabels'])->name('contacts.labels');

    // Profile & Security Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/sip', [ProfileController::class, 'updateSip'])->name('profile.sip');
    Route::post('/profile/logout-other-devices', [ProfileController::class, 'logoutOtherDevices'])->name('profile.logout-other');
});

// Public Routes
Route::get('/r/{code}', [LinkTrackerController::class, 'redirect'])->name('links.redirect');
Route::get('/autoresponder-check', [AutoResponderController::class, 'apiCheck']);