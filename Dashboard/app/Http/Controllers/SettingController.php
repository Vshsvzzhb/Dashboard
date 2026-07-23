<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\WaEngineService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        $apiUrl   = $settings['wa_api_url'] ?? 'http://localhost:4000';
        $waStatus = WaEngineService::getStatus($apiUrl, 'user_' . auth()->id());
        $waLabel  = WaEngineService::statusLabel($waStatus);
        $engineRoot = WaEngineService::engineRoot($apiUrl);

        return view('settings', compact('settings', 'waStatus', 'waLabel', 'engineRoot'));
    }

    public function save(Request $request)
    {
        $fields = [
            'wa_api_url',
            'wa_api_token',
            'webhook_url',
            'sender_delay',
            'app_name',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $request->input($field)]
                );
            }
        }

        return redirect()->back()->with('success', 'Settings saved successfully!');
    }
}
