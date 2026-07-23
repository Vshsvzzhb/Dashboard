<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use phpseclib3\Net\SFTP;

class TtsCallController extends Controller
{
    // ── Konfigurasi AMI & Asterisk ──────────────────────────────────────────
    private string $amiHost     = '52.2.21.5';
    private int    $amiPort     = 5038;
    private string $amiUser     = 'laravel';
    private string $amiSecret   = 'passwordAMI123';
    private string $amiContext  = 'tts-call';
    private string $callerExt   = '101';          // Nomor yang muncul saat 102 berdering
    private string $ttsLang     = 'id';           // Bahasa default TTS

    // ────────────────────────────────────────────────────────────────────────

    /**
     * Endpoint utama: terima teks + ekstensi tujuan, lakukan TTS call via AMI.
     * POST /tts-call
     */
    public function call(Request $request)
    {
        $request->validate([
            'text'   => 'required|string|max:500',
            'target' => 'required|string|max:20',
            'lang'   => 'nullable|string|max:5',
        ]);

        $text   = $request->input('text');
        $target = $request->input('target');
        $lang   = $request->input('lang', $this->ttsLang);

        // Decode in case the input was URL-encoded (prevents reading %20 as 'persen')
        $encodedText = urldecode($text);

        // Step 2 — Kirim Originate ke Asterisk via AMI
        try {
            $variables = [
                'TTS_TEXT' => $encodedText,
                'TTS_LANG' => $lang,
            ];

            $result = $this->amiOriginate($target, $variables);

            return response()->json([
                'success'   => true,
                'message'   => "TTS Call ke ekstensi {$target} berhasil dikirim!",
                'mode'      => 'ami-direct',
                'ami_resp'  => $result,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => 'AMI Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ── Originate call via Asterisk Manager Interface (AMI) ─────────────────

    private function amiOriginate(string $target, array $variables = []): string
    {
        $sock = @fsockopen($this->amiHost, $this->amiPort, $errno, $errstr, 10);
        if (!$sock) {
            throw new \Exception("Tidak bisa konek ke AMI {$this->amiHost}:{$this->amiPort} — {$errstr} ({$errno})");
        }

        stream_set_timeout($sock, 10);

        // Baca greeting
        fgets($sock, 256);

        // Login
        fwrite($sock, "Action: Login\r\nUsername: {$this->amiUser}\r\nSecret: {$this->amiSecret}\r\n\r\n");
        $loginResp = $this->readAMIResponse($sock);
        if (strpos($loginResp, 'Success') === false) {
            fclose($sock);
            throw new \Exception("AMI Login gagal. Response: " . substr($loginResp, 0, 200));
        }

        // Build Variable lines (Multi-line header, sesuai dengan perilaku 'Array' pada library AMI)
        $varLines = '';
        foreach ($variables as $k => $v) {
            if ($v !== '') {
                // AMI Originate uses comma as variable separator — escape literal commas with \,
                // Spaces are fine; the dialplan's URIENCODE() handles encoding for get_tts.sh
                $cleanVal = str_replace(["\r", "\n"], ' ', $v);
                $cleanVal = str_replace(',', '\,', $cleanVal);
                $varLines .= "Variable: {$k}={$cleanVal}\r\n";
            }
        }

        // Originate — panggil 102, saat diangkat masuk ke context tts-call
        $uid    = uniqid();
        $action = "Action: Originate\r\n"
                . "ActionID: {$uid}\r\n"
                . "Channel: PJSIP/{$target}\r\n"       // Panggil target (misal 102)
                . "Context: {$this->amiContext}\r\n"   // tts-call
                . "Exten: s\r\n"
                . "Priority: 1\r\n"
                . "Timeout: 30000\r\n"
                . "CallerID: TTS Bot <{$this->callerExt}>\r\n"
                . "Async: yes\r\n"                     // Non-blocking
                . $varLines
                . "\r\n";

        fwrite($sock, $action);
        $resp = $this->readAMIResponse($sock);

        // Logout
        fwrite($sock, "Action: Logoff\r\n\r\n");
        fclose($sock);

        return $resp;
    }

    private function readAMIResponse($sock, int $timeout = 5): string
    {
        $response = '';
        $start    = time();
        while (!feof($sock) && (time() - $start) < $timeout) {
            $line = fgets($sock, 4096);
            if ($line === false) break;
            $response .= $line;
            // Respons AMI diakhiri dengan baris kosong
            if (substr($response, -4) === "\r\n\r\n") break;
        }
        return $response;
    }

    private function findFfmpeg(): ?string
    {
        // Cek common paths ffmpeg di Windows dan Linux
        $paths = [base_path('node_modules/ffmpeg-static/ffmpeg.exe'), 'ffmpeg', 'C:\\ffmpeg\\bin\\ffmpeg.exe', '/usr/bin/ffmpeg', '/usr/local/bin/ffmpeg'];
        foreach ($paths as $p) {
            if (@exec(escapeshellarg($p) . ' -version 2>&1') && strpos(@exec(escapeshellarg($p) . ' -version 2>&1'), 'ffmpeg') !== false) {
                return $p;
            }
        }
        return null;
    }

    private function hasSsh(): bool
    {
        return !empty(exec('which ssh 2>/dev/null')) || file_exists('C:\\Windows\\System32\\OpenSSH\\ssh.exe');
    }
}
