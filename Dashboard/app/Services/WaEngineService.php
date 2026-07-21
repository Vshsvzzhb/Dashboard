<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class WaEngineService
{
    public static function engineRoot(?string $apiUrl = null): string
    {
        $apiUrl = $apiUrl ?? Setting::where('key', 'wa_api_url')->value('value') ?? 'http://localhost:4000';

        $root = rtrim($apiUrl, '/');
        if (str_ends_with($root, '/api')) {
            $root = substr($root, 0, -4);
        }

        return $root;
    }

    public static function sendBulkUrl(?string $apiUrl = null): string
    {
        return self::engineRoot($apiUrl) . '/send-bulk';
    }

    public static function groupsUrl(?string $apiUrl = null): string
    {
        return self::engineRoot($apiUrl) . '/groups';
    }

    public static function groupMembersUrl(string $groupId, ?string $apiUrl = null): string
    {
        return self::engineRoot($apiUrl) . '/groups/' . urlencode($groupId) . '/members';
    }

    public static function getStatus(?string $apiUrl = null): array
    {
        $root = self::engineRoot($apiUrl);

        try {
            $response = Http::timeout(5)->get($root . '/status');

            if ($response->successful()) {
                return array_merge($response->json(), [
                    'reachable' => true,
                    'engine_root' => $root,
                ]);
            }

            return self::offlineStatus($root, 'HTTP ' . $response->status());
        } catch (\Exception $e) {
            return self::offlineStatus($root, $e->getMessage());
        }
    }

    public static function statusLabel(array $status): array
    {
        if (empty($status['reachable'])) {
            return [
                'label' => 'Engine Offline',
                'hint'  => 'Jalankan wa-engine: node index.js',
                'color' => '#ef4444',
                'bg'    => '#FEE2E2',
            ];
        }

        if (!empty($status['connected'])) {
            return [
                'label' => 'WhatsApp Connected',
                'hint'  => 'Session aktif, siap kirim pesan',
                'color' => '#10b981',
                'bg'    => '#E6FBF5',
            ];
        }

        if (!empty($status['qr_ready'])) {
            return [
                'label' => 'Scan QR Required',
                'hint'  => 'Buka panel QR di bawah untuk scan',
                'color' => '#eab308',
                'bg'    => '#FEF9C3',
            ];
        }

        if (($status['status'] ?? '') === 'connecting') {
            return [
                'label' => 'Connecting...',
                'hint'  => 'Menghubungkan ke WhatsApp',
                'color' => '#2563eb',
                'bg'    => '#EFF6FF',
            ];
        }

        return [
            'label' => 'Disconnected',
            'hint'  => 'WhatsApp belum terhubung',
            'color' => '#ef4444',
            'bg'    => '#FEE2E2',
        ];
    }

    private static function offlineStatus(string $root, string $error): array
    {
        return [
            'reachable'   => false,
            'connected'   => false,
            'qr_ready'    => false,
            'status'      => 'offline',
            'engine_root' => $root,
            'error'       => $error,
        ];
    }
}
