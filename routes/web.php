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

/*
|--------------------------------------------------------------------------
| Dashboard & Navigation Routes
|--------------------------------------------------------------------------
*/

// Dashboard dengan Data Realtime & Chart.js
Route::get('/dashboard', function () {
    $waContacts = class_exists(Contact::class) ? Contact::where('type', 'wa')->count() : 60;
    $smsContacts = class_exists(Contact::class) ? Contact::where('type', 'sms')->count() : 60;
    $totalContacts = $waContacts + $smsContacts;

    // Data aktivitas mingguan untuk Chart.js (S, M, T, W, T, F, S)
    $weeklyData = [120, 80, 180, 40, 100, 90, 150];

    return view('dashboard', compact('totalContacts', 'waContacts', 'smsContacts', 'weeklyData'));
})->name('dashboard');

// Top Menu Routes
Route::get('/quick-blast', function () {
    return view('quick-blast');
})->name('quick.blast');

Route::get('/blast-history', function () {
    return view('blast-history');
})->name('blast.history');

// WhatsApp Gateway Routes
Route::get('/phonebook', function () {
    return view('phonebook');
})->name('phonebook');

Route::get('/wa-connect', function () {
    return view('wa-connect');
})->name('wa.connect');

Route::get('/campaigns', function () {
    return view('campaigns');
})->name('campaigns');

Route::get('/wa-groups', function () {
    return view('wa-groups');
})->name('wa.groups');

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

// WebRTC Routes
Route::get('/webrtc', function () {
    return view('webrtc');
})->name('webrtc.phone');

// Settings Route
Route::get('/settings/gateways', function () {
    return view('gateways');
})->name('gateways.settings');