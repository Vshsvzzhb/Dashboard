<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WaGroupController extends Controller
{
    public function index()
    {
        // Get contacts that have the label "WA-Group" or phone ending with @g.us
        $groups = Contact::where('phone', 'LIKE', '%@g.us%')->get();
        return view('wa_groups', compact('groups'));
    }

    public function fetch(Request $request)
    {
        $baseUrl = \App\Models\Setting::where('key', 'wa_api_url')->value('value');
        $apiUrl = \App\Services\WaEngineService::groupsUrl($baseUrl);

        try {
            $response = Http::timeout(10)->get($apiUrl);
            
            if ($response->successful() && $response->json('success')) {
                $groups = $response->json('data');
                $added = 0;
                
                foreach ($groups as $group) {
                    $contact = Contact::where('phone', $group['id'])->first();
                    
                    if ($contact) {
                        $labels = json_decode($contact->labels, true) ?? [];
                        if (!in_array('WA-Group', $labels)) {
                            $labels[] = 'WA-Group';
                            $contact->update(['labels' => json_encode($labels)]);
                            $added++;
                        }
                    } else {
                        Contact::create([
                            'name' => $group['name'],
                            'phone' => $group['id'],
                            'labels' => json_encode(['WA-Group'])
                        ]);
                        $added++;
                    }
                }
                
                return redirect('/wa-groups')->with('success', "Successfully fetched {$added} WA groups from device.");
            } else {
                return redirect('/wa-groups')->withErrors(['error' => 'Failed to fetch groups from WA Engine. Make sure the device is connected.']);
            }
        } catch (\Exception $e) {
            return redirect('/wa-groups')->withErrors(['error' => 'Could not connect to WA Engine: ' . $e->getMessage()]);
        }
    }

    public function extractContacts(Request $request)
    {
        $request->validate([
            'group_id' => 'required|string',
            'group_name' => 'required|string'
        ]);

        $groupId = $request->group_id;
        $groupName = $request->group_name;
        
        $baseUrl = \App\Models\Setting::where('key', 'wa_api_url')->value('value');
        $apiUrl = \App\Services\WaEngineService::groupMembersUrl($groupId, $baseUrl);

        try {
            $response = Http::timeout(15)->get($apiUrl);
            
            if ($response->successful() && $response->json('success')) {
                $members = $response->json('data');
                $added = 0;
                $label = 'Group: ' . $groupName;
                
                foreach ($members as $memberPhone) {
                    $contact = Contact::where('phone', $memberPhone)->first();
                    
                    if ($contact) {
                        $labels = json_decode($contact->labels, true) ?? [];
                        if (!in_array($label, $labels)) {
                            $labels[] = $label;
                            $contact->update(['labels' => json_encode($labels)]);
                            $added++;
                        }
                    } else {
                        Contact::create([
                            'name' => 'Member ' . substr($memberPhone, -4),
                            'phone' => $memberPhone,
                            'labels' => json_encode([$label])
                        ]);
                        $added++;
                    }
                }
                
                return redirect('/phonebook')->with('success', "Extracted {$added} contacts from '{$groupName}' into Phonebook.");
            } else {
                $errorDetail = $response->json('error') ?? $response->body();
                return redirect('/wa-groups')->withErrors(['error' => "Failed to extract members: " . $errorDetail]);
            }
        } catch (\Exception $e) {
            return redirect('/wa-groups')->withErrors(['error' => 'Could not connect to WA Engine: ' . $e->getMessage()]);
        }
    }
}
