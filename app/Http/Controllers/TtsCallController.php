<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TtsCallController extends Controller
{
    // ── Konfigurasi AMI & Asterisk ──────────────────────────────────────────
    private string $amiContext  = 'tts-call';
    private string $callerExt   = '101';          // Nomor yang muncul saat target berdering
    private string $ttsLang     = 'id';           // Bahasa default TTS


    // ────────────────────────────────────────────────────────────────────────

    /**
     * Endpoint utama: terima teks + ekstensi tujuan, lakukan TTS call via AMI.
     * POST /tts-call
     */
    public function call(Request $request)
    {
        Validator::make($request->all(), [
            'text'   => 'required|string|max:500',
            'target' => 'required|string|max:20',
            'lang'   => 'nullable|string|max:5',
        ])->validate();

        $text   = $request->input('text');
        $target = $request->input('target');
        $lang   = $request->input('lang', $this->ttsLang);

        // Decode in case the input was URL-encoded (PENTING: Lakukan INI SEBELUM regex)
        $text = urldecode($text);
        Log::info('[TTS Step 1 - raw decode]: ' . $text);

        // Normalisasi pelafalan angka, mata uang, nomor telepon, OTP/PIN/Kode, dan testing secara natural
        $encodedText = $this->normalizeTtsText($text);
        Log::info('[TTS Step 2 - normalized]: ' . $encodedText);

        try {
            $b64Text = base64_encode($encodedText);

            // Pre-cache audio locally on VPS so Asterisk doesn't wait when answered
            if (!app()->isLocal()) {
                @exec("python3 /usr/local/bin/get_tts.py " . escapeshellarg($b64Text) . " /tmp/tts_pre_" . md5($encodedText) . " " . escapeshellarg($lang) . " 1 > /dev/null 2>&1 &");
            }

            $variables = [
                'TTS_B64'    => $b64Text,
                'TTS_TEXT'   => $encodedText,
                'TTS_LANG'   => $lang,
                '__TTS_B64'  => $b64Text,
                '__TTS_TEXT' => $encodedText,
                '__TTS_LANG' => $lang,
            ];

            $result = $this->amiOriginate($target, $variables);

            \Illuminate\Support\Facades\Log::info('TTS_TEXT dikirim ke AMI: ' . $encodedText);

            return response()->json([
                'success'   => true,
                'message'   => "TTS Call ke ekstensi {$target} berhasil dikirim!",
                'mode'      => 'ami-direct',
                'ami_resp'  => $result,
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('AMI Exception: ' . $e->getMessage());
            if (app()->isLocal()) {
                return response()->json([
                    'success'     => true,
                    'message'     => "TTS Call ke ekstensi {$target} berhasil dikirim (Simulasi Suara Lokal)! Teks: \"{$encodedText}\"",
                    'mode'        => 'local-demo-simulation',
                    'text_spoken' => $encodedText,
                    'note'        => 'Mode presentasi lokal: TTS terkonversi otomatis.'
                ]);
            }
            return response()->json([
                'success' => false,
                'error'   => 'AMI Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Endpoint untuk mendengarkan preview suara TTS langsung di browser (HTML5 Audio)
     * GET/POST /tts-preview
     */
    public function preview(Request $request)
    {
        $text = $request->input('text', 'Halo, ini adalah pengujian suara text to speech.');
        $lang = $request->input('lang', $this->ttsLang);
        $text = urldecode($text);
        $normalized = $this->normalizeTtsText($text);

        $cacheKey = md5($normalized . '_' . $lang . '_v2');
        $cacheFile = "/tmp/tts_cache/{$cacheKey}.wav";

        if (file_exists($cacheFile) && filesize($cacheFile) > 1000) {
            return response()->file($cacheFile, [
                'Content-Type' => 'audio/wav',
                'Cache-Control' => 'public, max-age=3600',
            ]);
        }

        $tmpPrefix = '/tmp/tts_prev_' . uniqid();
        $tmpWav = "{$tmpPrefix}.wav";
        $b64 = base64_encode($normalized);

        @exec("python3 /usr/local/bin/get_tts.py " . escapeshellarg($b64) . " " . escapeshellarg($tmpPrefix) . " " . escapeshellarg($lang) . " 1 2>&1");

        if (file_exists($tmpWav) && filesize($tmpWav) > 1000) {
            return response()->file($tmpWav, [
                'Content-Type' => 'audio/wav',
                'Cache-Control' => 'no-cache, must-revalidate',
            ]);
        }

        return response()->json([
            'success' => false,
            'error'   => 'Gagal menghasilkan file audio preview.',
        ], 500);
    }

    // ── Originate call via Asterisk Manager Interface (AMI) ─────────────────

    private function amiOriginate(string $target, array $variables = []): string
    {
        $amiHost   = config('services.asterisk.host');
        $amiPort   = config('services.asterisk.port');
        $amiUser   = config('services.asterisk.user');
        $amiSecret = config('services.asterisk.secret');

        $sock = @fsockopen($amiHost, $amiPort, $errno, $errstr, 10);
        if (!$sock) {
            throw new \Exception("Tidak bisa konek ke AMI {$amiHost}:{$amiPort} — {$errstr} ({$errno})");
        }

        stream_set_timeout($sock, 10);

        // Baca greeting
        fgets($sock, 256);

        // Login
        fwrite($sock, "Action: Login\r\nUsername: {$amiUser}\r\nSecret: {$amiSecret}\r\n\r\n");
        $loginResp = $this->readAMIResponse($sock);
        if (strpos($loginResp, 'Success') === false) {
            fclose($sock);
            throw new \Exception("AMI Login gagal. Response: " . substr($loginResp, 0, 200));
        }

        // Build Variable lines
        $varLines = '';
        foreach ($variables as $k => $v) {
            if ($v !== '') {
                // AMI Originate uses comma as variable separator — escape literal commas with \,
                $cleanVal = str_replace(["\r", "\n"], ' ', $v);
                $cleanVal = str_replace(',', '\,', $cleanVal);
                $varLines .= "Variable: {$k}={$cleanVal}\r\n";
            }
        }

        // Originate
        $uid    = uniqid();
        $action = "Action: Originate\r\n"
                . "ActionID: {$uid}\r\n"
                . "Channel: PJSIP/{$target}\r\n"       // Panggil target (misal 9999)
                . "Context: {$this->amiContext}\r\n"   // tts-call
                . "Exten: s\r\n"
                . "Priority: 1\r\n"
                . "Timeout: 30000\r\n"
                . "CallerID: TTS Bot <1000>\r\n"
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

    // ── Normalisasi Pelafalan Suara TTS ─────────────────────────────────────

    /**
     * Normalisasi teks TTS agar pelafalan angka, mata uang, nomor telepon,
     * OTP/PIN/Kode, dan frase pengujian terdengar sangat natural.
     */
    public function normalizeTtsText(string $text): string
    {
        // 1. Tag eksplisit: [uang] 50000, [digit] 0812, [terbilang] 123
        $text = preg_replace_callback('/\[uang\]\s*([\d\.\,\s]+)/i', function($m) {
            $numPart = preg_replace('/[,\-](?:00|-)$/', '', trim($m[1]));
            $clean = (int) preg_replace('/[^\d]/', '', $numPart);
            return trim($this->terbilang($clean)) . ' rupiah ';
        }, $text);

        $text = preg_replace_callback('/\[(?:digit|angka)\]\s*([\d\s\-]+)/i', function($m) {
            return ' ' . $this->digitPerDigit($m[1]) . ' ';
        }, $text);

        $text = preg_replace_callback('/\[terbilang\]\s*([\d\.\,\s]+)/i', function($m) {
            $clean = (int) preg_replace('/[^\d]/', '', $m[1]);
            return ' ' . trim($this->terbilang($clean)) . ' ';
        }, $text);

        // 2. Mata uang: Rp 50.000 / Rp. 150.000 / IDR 50.000 / Rp 250.000,00
        $text = preg_replace_callback('/(?:Rp\.?|IDR)\s*([\d\.\,\-]+)/i', function($m) {
            $numPart = preg_replace('/[,\-](?:00|-)$/', '', trim($m[1]));
            $clean = preg_replace('/[^\d]/', '', $numPart);
            if (empty($clean)) return $m[0];
            return ' ' . trim($this->terbilang((int) $clean)) . ' rupiah ';
        }, $text);

        // 3. Nomor telepon: diawali 08, 628, +628, 021, 022, dll (panjang 6-16 digit)
        // Format internasional (+628... -> 08...) dinormalisasi ke awalan 0 agar santun & alami
        $text = preg_replace_callback('/(?:\+?62|0)[\d\-\s]{6,16}\b/', function($m) {
            $clean = preg_replace('/[^\d]/', '', $m[0]);
            if (str_starts_with($clean, '62')) {
                $clean = '0' . substr($clean, 2);
            }
            if (strlen($clean) >= 7) {
                return ' ' . $this->digitPerDigit($clean) . ' ';
            }
            return $m[0];
        }, $text);

        // 4. Konteks kode / OTP / PIN / test / tes / sandi / ekstensi / nomor rekening
        // contoh: "test 123", "kode 5821", "Kode OTP Anda adalah 5821", "pin 1234", "ext 101"
        $codeKeywords = 'kode|code|otp|pin|token|password|sandi|verifikasi|verification|test|tes|testing|id|ext|ekstensi|extension|user|serial|nomor\s+rekening|no\.?\s*rek|rekening|halo|hai|cek';
        $fillers = 'anda|kamu|milik\s+anda|ini|itu|ialah|adalah|berupa|yaitu|nomor|no';
        $text = preg_replace_callback('/(\b(?:' . $codeKeywords . ')\b(?:\s+(?:' . $fillers . '))*\s*[\:\-]?\s*)(\d+)/i', function($m) {
            return $m[1] . $this->digitPerDigit($m[2]);
        }, $text);

        // 5. Urutan angka testing populer: "123", "1234", "12345" jika berdiri sendiri
        $text = preg_replace_callback('/\b(123|1234|12345)\b/', function($m) {
            return $this->digitPerDigit($m[1]);
        }, $text);

        // 6. Angka panjang (>= 5 digit) yang berdiri sendiri (nomor resi, ID transaksi, dsb.)
        $text = preg_replace_callback('/(?<!\d)(\d{5,})(?!\d)/', function($m) {
            return ' ' . $this->digitPerDigit($m[1]) . ' ';
        }, $text);

        // 7. Angka kuantitas biasa (1 s/d 4 digit) -> terbilang alami (contoh: "25 orang", "tahun 2024")
        $text = preg_replace_callback('/(?<![\d\.\,])([1-9]\d{0,3})(?![\d\.\,])/', function($m) {
            return ' ' . trim($this->terbilang((int)$m[1])) . ' ';
        }, $text);

        // 8. Bersihkan karakter khusus yang dapat mengacaukan parser argumen shell/AMI
        $text = str_replace(['"', "'", '`', '$', '\\', '|', ';'], ' ', $text);
        $text = preg_replace('/\s+/', ' ', trim($text));

        return $text;
    }

    /**
     * Backward-compatible helper untuk parse tag TTS jika ada pemanggil legacy
     */
    public function parseTtsTags(string $text): string
    {
        return $this->normalizeTtsText($text);
    }

    /** Baca angka satu per satu: "08123" → "nol delapan satu dua tiga" */
    public function digitPerDigit(string $number): string
    {
        $kata = ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
        $digits = str_split(preg_replace('/[^\d]/', '', $number));
        $res = [];
        foreach ($digits as $d) {
            if (isset($kata[(int) $d])) {
                $res[] = $kata[(int) $d];
            }
        }
        return implode(' ', $res);
    }

    // ── Fungsi Helper Terbilang (Angka ke Teks) ─────────────────────────────
    private function terbilang(int $angka): string
    {
        $angka = abs($angka);
        $baca  = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        $hasil = '';

        if ($angka < 12) {
            $hasil = ' ' . $baca[$angka];
        } elseif ($angka < 20) {
            $hasil = $this->terbilang($angka - 10) . ' belas';
        } elseif ($angka < 100) {
            $hasil = $this->terbilang((int)($angka / 10)) . ' puluh' . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = ' seratus' . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = $this->terbilang((int)($angka / 100)) . ' ratus' . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = ' seribu' . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = $this->terbilang((int)($angka / 1000)) . ' ribu' . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = $this->terbilang((int)($angka / 1000000)) . ' juta' . $this->terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = $this->terbilang((int)($angka / 1000000000)) . ' milyar' . $this->terbilang($angka % 1000000000);
        }

        return $hasil;
    }
}
