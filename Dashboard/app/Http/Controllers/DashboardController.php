<?php

namespace App\Http\Controllers;

use App\Models\Blast;
use App\Models\Contact;
use App\Models\Campaign;
use App\Models\Setting;
use App\Services\WaEngineService;

class DashboardController extends Controller
{
    public function index()
    {
        $totalContacts  = Contact::count();
        $totalCampaigns = Campaign::count();
        $runningCampaigns = Campaign::where('status', 'running')->count();
        $totalSent      = Campaign::sum('sent_count');
        $recentCampaigns = Campaign::latest()->take(5)->get();
        $recentBlasts    = Blast::latest()->take(5)->get();
        $apiUrl = Setting::where('key', 'wa_api_url')->value('value') ?? 'http://localhost:4000';
        $waStatus = WaEngineService::getStatus($apiUrl);
        $waLabel  = WaEngineService::statusLabel($waStatus);
        $engineRoot = WaEngineService::engineRoot($apiUrl);

        return view('dashboard', compact(
            'totalContacts',
            'totalCampaigns',
            'runningCampaigns',
            'totalSent',
            'recentCampaigns',
            'recentBlasts',
            'apiUrl',
            'waStatus',
            'waLabel',
            'engineRoot'
        ));
    }

    public function waStatus()
    {
        $apiUrl = Setting::where('key', 'wa_api_url')->value('value') ?? 'http://localhost:4000';
        $waStatus = WaEngineService::getStatus($apiUrl);
        $waLabel  = WaEngineService::statusLabel($waStatus);

        return response()->json([
            'status' => $waStatus,
            'label'  => $waLabel,
        ]);
    }
}
