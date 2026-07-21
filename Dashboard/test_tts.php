<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$ffmpeg = base_path('node_modules/ffmpeg-static/ffmpeg.exe');
echo 'FFmpeg path: ' . $ffmpeg . PHP_EOL;
echo 'Exists: ' . (file_exists($ffmpeg) ? 'Yes' : 'No') . PHP_EOL;

exec(escapeshellarg($ffmpeg) . ' -version 2>&1', $out, $code);
echo 'Exit Code: ' . $code . PHP_EOL;
echo 'Output: ' . implode(PHP_EOL, $out) . PHP_EOL;

// Test SFTP
use phpseclib3\Net\SFTP;
try {
    echo "Connecting to SFTP...\n";
    $sftp = new SFTP('52.2.21.5', 22);
    if (!$sftp->login('laravel_upload', 'Laravel123')) {
        echo "SFTP Login failed!\n";
    } else {
        echo "SFTP Login success!\n";
    }
} catch (\Exception $e) {
    echo "SFTP Exception: " . $e->getMessage() . "\n";
}
