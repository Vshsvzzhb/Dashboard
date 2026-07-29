<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;
use App\Models\User;
use App\Models\Contact;
use App\Services\WaEngineService;
use Illuminate\Support\Facades\Http;

$base = Setting::where('key','wa_api_url')->value('value');
$uid = optional(User::first())->id ?: 1;
$session = 'user_' . $uid;
$api = WaEngineService::groupsUrl($base, $session);

try {
    $r = Http::timeout(10)->get($api);
    if ($r->successful() && ($r->json('success') ?? false)) {
        $groups = $r->json('data');
        $added = 0;
        foreach ($groups as $g) {
            $contact = Contact::where('phone', $g['id'])->first();
            if ($contact) {
                $labels = json_decode($contact->labels, true) ?? [];
                if (!in_array('WA-Group', $labels)) {
                    $labels[] = 'WA-Group';
                    $contact->update(['labels' => json_encode($labels)]);
                    $added++;
                }
            } else {
                Contact::create([
                    'name' => $g['name'] ?? 'Group',
                    'phone' => $g['id'],
                    'labels' => json_encode(['WA-Group'])
                ]);
                $added++;
            }
        }
        echo 'added:' . $added . PHP_EOL;
    } else {
        echo 'failed:' . ($r->body() ?? 'no body') . PHP_EOL;
    }
} catch (Exception $e) {
    echo 'err:' . $e->getMessage() . PHP_EOL;
}
