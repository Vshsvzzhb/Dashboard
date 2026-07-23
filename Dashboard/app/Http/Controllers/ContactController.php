<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // Exclude WA Groups from the general phonebook list
        $contacts = Contact::where('phone', 'NOT LIKE', '%@g.us%')->get();
        $phonebooks = [];
        
        foreach($contacts as $contact) {
            $labels = json_decode($contact->labels, true) ?? [];
            if (empty($labels)) {
                $labels = ['Uncategorized'];
            }
            foreach($labels as $label) {
                if(!isset($phonebooks[$label])) {
                    $phonebooks[$label] = 0;
                }
                $phonebooks[$label]++;
            }
        }

        return view('phonebook', compact('contacts', 'phonebooks'));
    }

    public function fetchWaGroups(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255'
        ]);

        $label = $request->label;
        $baseUrl = \App\Models\Setting::where('key', 'wa_api_url')->value('value');
        $apiUrl = \App\Services\WaEngineService::groupsUrl($baseUrl, 'user_' . auth()->id());

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)->get($apiUrl);
            
            if ($response->successful() && $response->json('success')) {
                $groups = $response->json('data');
                $added = 0;
                
                foreach ($groups as $group) {
                    $contact = Contact::where('phone', $group['id'])->first();
                    
                    if ($contact) {
                        $labels = json_decode($contact->labels, true) ?? [];
                        if (!in_array($label, $labels)) {
                            $labels[] = $label;
                            $contact->update(['labels' => json_encode($labels)]);
                            $added++;
                        }
                    } else {
                        Contact::create([
                            'name' => $group['name'] . ' (WA Group)',
                            'phone' => $group['id'],
                            'labels' => json_encode([$label])
                        ]);
                        $added++;
                    }
                }
                
                return redirect('/phonebook')->with('success', "Successfully fetched and added {$added} WA groups into phonebook: {$label}");
            } else {
                return redirect('/phonebook')->withErrors(['error' => 'Failed to fetch groups from WA Engine. Is the device connected?']);
            }
        } catch (\Exception $e) {
            return redirect('/phonebook')->withErrors(['error' => 'Could not connect to WA Engine: ' . $e->getMessage()]);
        }
    }

    public function show($label)
    {
        // Exclude WA Groups from the phonebook list
        $allContacts = Contact::where('phone', 'NOT LIKE', '%@g.us%')->get();
        $contacts = $allContacts->filter(function($contact) use ($label) {
            $labels = json_decode($contact->labels, true) ?? [];
            if (empty($labels) && $label === 'Uncategorized') return true;
            return in_array($label, $labels);
        });

        return view('phonebook_show', compact('contacts', 'label'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:contacts,phone',
            'labels' => 'nullable|string'
        ]);

        // Convert comma-separated labels to JSON array
        $labels = $request->labels ? array_map('trim', explode(',', $request->labels)) : [];

        Contact::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'labels' => json_encode($labels)
        ]);

        return redirect()->back()->with('success', 'Contact added successfully!');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->back()->with('success', 'Contact deleted.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx', // accept csv and text files
            'label' => 'required|string|max:255'
        ]);

        $file = $request->file('file');
        $label = $request->label;
        $added = 0;

        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            $header = fgetcsv($handle, 1000, ',');
            
            if ($header !== FALSE) {
                $header = array_map('strtolower', $header);
                $nameIdx = array_search('name', $header);
                $phoneIdx = array_search('phone', $header);

                if ($nameIdx === false || $phoneIdx === false) {
                    $nameIdx = 0;
                    $phoneIdx = 1;
                }

                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    if (!isset($data[$phoneIdx]) || empty(trim($data[$phoneIdx]))) {
                        continue;
                    }
                    
                    $phone = trim($data[$phoneIdx]);
                    $name = isset($data[$nameIdx]) ? trim($data[$nameIdx]) : 'Unnamed';

                    $contact = Contact::where('phone', $phone)->first();
                    if ($contact) {
                        $labels = json_decode($contact->labels, true) ?? [];
                        if (!in_array($label, $labels)) {
                            $labels[] = $label;
                            $contact->update(['labels' => json_encode($labels)]);
                            $added++;
                        }
                    } else {
                        Contact::create([
                            'name' => $name,
                            'phone' => $phone,
                            'labels' => json_encode([$label])
                        ]);
                        $added++;
                    }
                }
            }
            fclose($handle);
        }

        return redirect()->back()->with('success', "Successfully imported {$added} contacts into Phonebook: {$label}");
    }
}
