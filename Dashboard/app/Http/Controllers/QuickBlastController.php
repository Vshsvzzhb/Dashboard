<?php

namespace App\Http\Controllers;

use App\Models\Blast;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuickBlastController extends Controller
{
    public function index()
    {
        // Exclude WA Groups from the regular contacts list
        $contacts = Contact::where('phone', 'NOT LIKE', '%@g.us%')->latest()->get();
        $history  = Blast::latest()->take(20)->get();
        $apiUrl   = Setting::where('key', 'wa_api_url')->value('value') ?? 'http://localhost:4000/api';
        return view('quick-blast', compact('contacts', 'history', 'apiUrl'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message'    => 'required|string|min:1',
            'recipients' => 'required|array|min:1',
        ]);

        $phones  = $request->recipients;
        $message = $request->message;

        // Resolve contacts for personalization {name}
        $contacts = Contact::whereIn('phone', $phones)->pluck('name', 'phone');

        // Save blast record first
        $blast = Blast::create([
            'message'    => $message,
            'recipients' => $phones,
            'total'      => count($phones),
            'sent'       => 0,
            'failed'     => 0,
            'status'     => 'queued',
        ]);

        $apiUrl   = Setting::where('key', 'wa_api_url')->value('value') ?? 'http://127.0.0.1:4000';
        $apiToken = Setting::where('key', 'wa_api_token')->value('value');
        $delay    = (int)(Setting::where('key', 'sender_delay')->value('value') ?? 3000);

        if ($apiUrl) {
            $blast->update(['status' => 'sending']);

            // Build personalized messages per recipient
            $recipientList = collect($phones)->map(function ($phone) use ($contacts, $message) {
                $name = $contacts[$phone] ?? 'Pelanggan';
                return [
                    'phone'   => $phone,
                    'message' => str_replace('{name}', $name, $message),
                ];
            })->toArray();

            try {
                // Call WA Engine bulk endpoint
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiToken,
                    'Content-Type'  => 'application/json',
                ])->timeout(15)->post(\App\Services\WaEngineService::sendBulkUrl($apiUrl, 'user_' . auth()->id()), [
                    'recipients' => $phones,
                    'message'    => $message,
                    'delay_ms'   => $delay,
                ]);

                $blast->update([
                    'sent'   => count($phones),
                    'status' => 'done',
                ]);

                $msg = 'Success: Blast sent to ' . count($phones) . ' contacts! Engine is processing in background.';
            } catch (\Exception $e) {
                $blast->update(['status' => 'failed', 'failed' => count($phones)]);
                $msg = 'Error: Failed to reach WA Engine: ' . $e->getMessage() . '. Check your API URL in Settings.';
            }
        } else {
            $msg = 'Info: Blast queued (' . count($phones) . ' recipients). Set your WA Engine URL in Settings to start sending!';
        }

        return redirect()->back()->with('success', $msg);
    }
}
