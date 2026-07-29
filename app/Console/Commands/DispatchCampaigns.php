<?php

namespace App\Console\Commands;

use App\Models\Blast;
use App\Models\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DispatchCampaigns extends Command
{
    protected $signature   = 'campaign:dispatch';
    protected $description = 'Kirim campaign yang sudah mencapai waktu jadwal';

    public function handle(): int
    {
        // Ambil semua campaign yang sudah waktunya dan masih paused/pending
        // Ambil semua campaign yang manual running ATAU yang jadwalnya sudah tiba
        $due = Campaign::where(function ($query) {
                $query->where('status', 'running')
                      ->orWhere(function ($q) {
                          $q->where('status', 'paused')
                            ->whereNotNull('scheduled_at')
                            ->where('scheduled_at', '<=', now());
                      });
            })
            ->with('phonebook.contacts')
            ->get();

        if ($due->isEmpty()) {
            $this->line('Tidak ada campaign yang jatuh tempo.');
            return 0;
        }

        foreach ($due as $campaign) {
            $contacts = $campaign->phonebook?->contacts ?? collect();

            if ($contacts->isEmpty()) {
                $campaign->update(['status' => 'completed', 'sent_at' => now()]);
                $this->warn("Campaign [{$campaign->name}] — tidak ada kontak, ditandai selesai.");
                continue;
            }

            $campaign->update([
                'status'      => 'running',
                'total_count' => $contacts->count(),
                'sent_count'  => 0,
            ]);

            $sentCount = 0;

            foreach ($contacts as $contact) {
                try {
                    $res = Http::timeout(10)->post('http://127.0.0.1:4000/send-message', [
                        'phone'   => $contact->phone,
                        'message' => $campaign->message,
                        'session' => $campaign->session ?? 'default',
                    ]);

                    $ok = $res->successful() && ($res->json('success') ?? false);
                } catch (\Exception $e) {
                    $ok = false;
                    Log::warning("Campaign [{$campaign->name}] gagal kirim ke {$contact->phone}: " . $e->getMessage());
                }

                // Catat ke blast history
                Blast::create([
                    'message'    => $campaign->message,
                    'recipients' => json_encode([$contact->phone]),
                    'total'      => 1,
                    'sent'       => $ok ? 1 : 0,
                    'failed'     => $ok ? 0 : 1,
                    'status'     => $ok ? 'done' : 'failed',
                    'type'       => 'whatsapp',
                    'session'    => $campaign->session ?? 'default',
                ]);

                if ($ok) $sentCount++;

                // Delay kecil antar pesan agar tidak kena rate-limit WhatsApp
                usleep(800_000); // 0.8 detik
            }

            $campaign->update([
                'status'     => 'completed',
                'sent_count' => $sentCount,
                'sent_at'    => now(),
            ]);

            $this->info("Campaign [{$campaign->name}] selesai: {$sentCount}/{$contacts->count()} terkirim.");
        }

        return 0;
    }
}
