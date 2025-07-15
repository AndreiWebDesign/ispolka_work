<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\Process\Process;

class LibreSignService
{
    public function sign(string $src, string $dst, string $cmsBase64): void
    {
        // 1) генерируем QR-код с hash+cms
        $payload = json_encode([
            'hash' => hash_file('sha256', $src),
            'cms'  => $cmsBase64,
            'ts'   => now()->toIso8601String(),
        ]);
        $qrPng = QrCode::format('png')->size(140)->margin(0)->generate($payload);
        $qrTmp = tempnam(sys_get_temp_dir(), 'qr').'.png';
        file_put_contents($qrTmp, $qrPng);

        // 2) запускаем LibreSign CLI
        $cmd = [
            'libresign', 'sign',
            '--in',  $src,
            '--out', $dst,
            '--detached-cms-base64', $cmsBase64,
            '--visible-qrcode', $qrTmp,
            '--page', 'last',
            '--pos', 'tr',            // top-right
            '--tsa', 'http://tsp.pki.gov.kz/', // штамп времени
        ];

        $p = new Process($cmd, timeout: 120);
        $p->run();
        if (!$p->isSuccessful()) {
            throw new \RuntimeException($p->getErrorOutput());
        }
        unlink($qrTmp);
    }
}
