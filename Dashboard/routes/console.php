<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Setting;
use App\Services\WaEngineService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $campaigns = Campaign::whereNotNull('scheduled_at')
        ->where('status', 'paused')
        ->where('scheduled_at', '<=', now())
        ->get();

    if ($campaigns->isEmpty()) return;

    $apiUrl   = Setting::where('key', 'wa_api_url')->value('value') ?? 'http://localhost:4000';
    $delay    = (int)(Setting::where('key', 'sender_delay')->value('value') ?? 3000);

    foreach ($campaigns as $campaign) {
        Log::info("Executing scheduled campaign: {$campaign->name}");
        $campaign->update(['status' => 'running']);

        if (strtolower($campaign->target_audience) == 'all contacts') {
            $phones = Contact::where('phone', 'NOT LIKE', '%@g.us%')->pluck('phone')->toArray();
        } else {
            $phones = Contact::where('labels', 'like', '%' . trim($campaign->target_audience) . '%')->pluck('phone')->toArray();
        }

        if (count($phones) > 0) {
            try {
                Http::timeout(15)->post(WaEngineService::sendBulkUrl($apiUrl), [
                    'recipients' => $phones,
                    'message'    => $campaign->message,
                    'delay_ms'   => $delay,
                ]);
                $campaign->update(['sent_count' => count($phones), 'status' => 'completed']);
                Log::info("Campaign {$campaign->name} finished successfully.");
            } catch (\Exception $e) {
                $campaign->update(['status' => 'failed']);
                Log::error("Campaign {$campaign->name} failed: " . $e->getMessage());
            }
        } else {
            $campaign->update(['status' => 'completed', 'sent_count' => 0]);
        }
    }
})->everyMinute();
