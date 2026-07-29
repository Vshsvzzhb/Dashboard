<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/webrtc/logs', function (Request $request) {
    $data = $request->validate([
        'caller' => 'required|string',
        'recipient' => 'required|string',
        'duration' => 'required|string',
        'status' => 'required|string',
        'transcript' => 'nullable|string',
    ]);

    $call = \App\Models\WebrtcCall::create($data);

    return response()->json(['success' => true, 'data' => $call]);
});
