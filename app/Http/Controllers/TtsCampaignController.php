<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\MessageTemplate;
use App\Models\Phonebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class TtsCampaignController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $campaigns = Campaign::where('user_id', $userId)
            ->where('target_audience', 'tts')
            ->with('phonebook')
            ->latest()
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data'    => $campaigns,
            ]);
        }

        // Phonebook prioritizing TTS/VoIP first
        $phonebooks = Phonebook::where('user_id', $userId)
            ->withCount('contacts')
            ->orderByRaw("CASE WHEN type = 'tts' THEN 0 ELSE 1 END")
            ->latest()
            ->get();
        $templates  = MessageTemplate::where('user_id', $userId)->get();

        return view('tts-campaigns', compact('campaigns', 'phonebooks', 'templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:100',
            'phonebook_id'      => 'required|exists:phonebooks,id',
            'message'           => 'required|string|max:1000',
            'lang'              => 'nullable|string|max:10',
            'session'           => 'nullable|string|max:10',
            'scheduled_at'      => 'nullable|date',
            'selected_contacts' => 'nullable|array',
        ]);

        $userId = Auth::id();
        $phonebook = Phonebook::where('id', $request->phonebook_id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $selected = $request->input('selected_contacts', []);
        $total = !empty($selected) ? count($selected) : $phonebook->contacts()->count();

        $scheduledAt = $request->filled('scheduled_at') ? $request->scheduled_at : null;

        $rawLang = $request->input('lang', $request->input('session', 'id'));
        $lang = str_starts_with(strtolower((string)$rawLang), 'en') ? 'en' : 'id';

        $campaign = Campaign::create([
            'user_id'           => $userId,
            'phonebook_id'      => $phonebook->id,
            'selected_contacts' => !empty($selected) ? $selected : null,
            'name'              => $request->name,
            'message'           => $request->message,
            'target_audience'   => 'tts',
            'session'           => $lang,
            'total_count'       => $total,
            'sent_count'        => 0,
            'status'            => 'running',
            'scheduled_at'      => $scheduledAt,
        ]);

        // Auto-dispatch if scheduled for now
        if (!$scheduledAt || strtotime($scheduledAt) <= time()) {
            try {
                Artisan::call('campaign:dispatch');
            } catch (\Exception $e) {
                Artisan::queue('campaign:dispatch');
            }
        }

        return back()->with('success', "TTS Voice Campaign '{$campaign->name}' berhasil dibuat dan sedang diproses!");
    }

    public function destroy(Campaign $campaign)
    {
        abort_if($campaign->user_id !== Auth::id(), 403);
        $campaign->delete();
        return back()->with('success', 'TTS Voice Campaign berhasil dihapus.');
    }

    public function toggle(Campaign $campaign)
    {
        abort_if($campaign->user_id !== Auth::id(), 403);
        $newStatus = $campaign->status === 'paused' ? 'running' : 'paused';
        $campaign->update(['status' => $newStatus]);

        if ($newStatus === 'running') {
            try {
                Artisan::call('campaign:dispatch');
            } catch (\Exception $e) {
                Artisan::queue('campaign:dispatch');
            }
        }

        return back()->with('success', "Status campaign diubah menjadi: {$newStatus}");
    }

    public function resend(Campaign $campaign)
    {
        abort_if($campaign->user_id !== Auth::id(), 403);

        $pb = $campaign->phonebook;
        $totalCount = $pb ? $pb->contacts()->count() : $campaign->total_count;

        $campaign->update([
            'status'     => 'running',
            'sent_count' => 0,
            'total_count'=> $totalCount,
            'sent_at'    => null,
        ]);

        try {
            Artisan::call('campaign:dispatch');
        } catch (\Exception $e) {
            Artisan::queue('campaign:dispatch');
        }

        return back()->with('success', "TTS Voice Campaign '{$campaign->name}' sedang dikirim ulang!");
    }
}
