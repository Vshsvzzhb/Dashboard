<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->get();
        $totalContacts = Contact::where('phone', 'NOT LIKE', '%@g.us%')->count();
        
        $contacts = Contact::where('phone', 'NOT LIKE', '%@g.us%')->get();
        $phonebooks = [];
        foreach($contacts as $contact) {
            $labels = json_decode($contact->labels, true) ?? [];
            if (empty($labels)) $labels = ['Uncategorized'];
            foreach($labels as $label) {
                if(!isset($phonebooks[$label])) $phonebooks[$label] = 0;
                $phonebooks[$label]++;
            }
        }
        $labels = array_keys($phonebooks);

        return view('campaigns', compact('campaigns', 'totalContacts', 'labels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'message'          => 'required|string',
            'target_audience'  => 'nullable|string|max:255',
            'scheduled_at'     => 'nullable|date',
        ]);

        $audience = $request->target_audience ?? 'All Contacts';
        
        if (strtolower($audience) == 'all contacts' || trim($audience) == '') {
            $totalCount = Contact::where('phone', 'NOT LIKE', '%@g.us%')->count();
        } else {
            $totalCount = Contact::where('labels', 'like', '%' . trim($audience) . '%')->count();
        }

        Campaign::create([
            'name'            => $request->name,
            'message'         => $request->message,
            'target_audience' => $audience,
            'total_count'     => $totalCount,
            'sent_count'      => 0,
            'status'          => 'paused',
            'scheduled_at'    => $request->scheduled_at,
        ]);

        return redirect()->back()->with('success', 'Campaign "' . $request->name . '" created with ' . $totalCount . ' targets!');
    }

    public function updateStatus(Request $request, Campaign $campaign)
    {
        $request->validate(['status' => 'required|in:running,paused,completed,failed']);
        
        $campaign->update(['status' => $request->status]);

        if ($request->status === 'running') {
            // Trigger WA Engine
            $apiUrl   = Setting::where('key', 'wa_api_url')->value('value');
            $apiToken = Setting::where('key', 'wa_api_token')->value('value');
            $delay    = (int)(Setting::where('key', 'sender_delay')->value('value') ?? 3000);

            if ($apiUrl) {
                if (strtolower($campaign->target_audience) == 'all contacts') {
                    $phones = Contact::where('phone', 'NOT LIKE', '%@g.us%')->pluck('phone')->toArray();
                } else {
                    $phones = Contact::where('labels', 'like', '%' . trim($campaign->target_audience) . '%')->pluck('phone')->toArray();
                }

                if (count($phones) > 0) {
                    try {
                        Http::withHeaders([
                            'Authorization' => 'Bearer ' . $apiToken,
                            'Content-Type'  => 'application/json',
                        ])->timeout(15)->post(\App\Services\WaEngineService::sendBulkUrl($apiUrl), [
                            'recipients' => $phones,
                            'message'    => $campaign->message,
                            'delay_ms'   => $delay,
                        ]);
                        
                        $campaign->update(['sent_count' => count($phones), 'status' => 'completed']);
                        return redirect()->back()->with('success', 'Campaign started! WA Engine is processing in the background.');
                    } catch (\Exception $e) {
                        $campaign->update(['status' => 'failed']);
                        return redirect()->back()->withErrors(['Engine Error: ' . $e->getMessage()]);
                    }
                }
            } else {
                $campaign->update(['status' => 'failed']);
                return redirect()->back()->withErrors(['API URL is not set in settings!']);
            }
        }

        return redirect()->back()->with('success', 'Campaign status updated.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return redirect()->back()->with('success', 'Campaign deleted.');
    }
}

