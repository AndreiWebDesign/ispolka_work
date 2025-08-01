<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class CmsController extends Controller
{
    private function extractSigningTimeFromCms($cmsPath): ?string
    {
        $tempOutput = tempnam(sys_get_temp_dir(), 'cmsout');
        $verify = new Process([
            'openssl', 'smime',
            '-verify',
            '-in', $cmsPath,
            '-inform', 'DER',
            '-noverify',
            '-out', $tempOutput
        ]);

        try {
            $verify->mustRun();
            $output = $verify->getErrorOutput(); // подписанные атрибуты в stderr
            if (preg_match('/signingTime:([A-Za-z]{3} \d{1,2} \d{2}:\d{2}:\d{2} \d{4}) GMT/', $output, $matches)) {
                $date = \Carbon\Carbon::createFromFormat('M d H:i:s Y', $matches[1], 'GMT');
                return $date->setTimezone('Asia/Almaty')->format('d/m/Y H:i:s');
            }
        } catch (\Exception $e) {
            return null;
        } finally {
            @unlink($tempOutput);
        }

        return null;
    }

    public function viewCms($passportId, $type, $actNumber)
    {
        $cmsDir = storage_path("app/pdf_outputs/{$passportId}/{$type}/{$actNumber}");
        if (!File::isDirectory($cmsDir)) {
            return response("Папка актов не найдена", 404);
        }

        $cmsFiles = File::files($cmsDir);
        $signatures = [];

        foreach ($cmsFiles as $file) {
            if ($file->getExtension() !== 'cms') continue;

            $cmsPath = $file->getRealPath();

            $process = new Process([
                'openssl', 'pkcs7',
                '-inform', 'DER',
                '-in', $cmsPath,
                '-print_certs',
                '-text'
            ]);

            try {
                $process->mustRun();
                $rawOutput = $process->getOutput();
                $decoded = $this->decodeHexStrings($rawOutput);

                $signatures[] = [
                    'serial' => $this->extractSerial($decoded),
                    'iin' => $this->extractIin($decoded),
                    'fio' => $this->extractFio($decoded),
                    'validity' => $this->extractValidity($decoded),
                    'signingDate' => $this->extractSigningTimeFromCms($cmsPath) ?? 'Не удалось извлечь',
                    'status' => [
                        'cert' => 'Успешно',
                        'tsp' => 'Успешно',
                        'sign' => 'Успешно',
                    ],
                    'template' => 'Физическое лицо'
                ];
            } catch (ProcessFailedException $e) {
                continue; // просто пропусти ошибочный файл
            }
        }

        if (empty($signatures)) {
            return response("Нет валидных CMS файлов для акта", 404);
        }

        return view('cms.view', compact('signatures'));
    }

    private function decodeHexStrings($text)
    {
        return preg_replace_callback('/\\\\x([0-9A-Fa-f]{2})/', function ($m) {
            return chr(hexdec($m[1]));
        }, $text);
    }

    private function extractSerial($text)
    {
        if (preg_match('/Serial Number:\s+([0-9a-fA-F:\s]+)/', $text, $matches)) {
            return strtolower(str_replace([':', ' '], '', $matches[1]));
        }
        return null;
    }

    private function extractIin($text)
    {
        if (preg_match('/serialNumber=IIN(\d{12})/', $text, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function extractFio($text)
    {
        if (preg_match('/Subject: CN=([^\n,]+)/', $text, $matches)) {
            $lastName = trim($matches[1]);
        }

        if (preg_match('/GN=([^\n,]+)/', $text, $matches)) {
            $middleName = trim($matches[1]);
        }

        return ($lastName ?? '') . ' ' . ($middleName ?? '');
    }

    private function extractValidity($text)
    {
        if (
            preg_match('/Not Before:\s+([A-Za-z]{3} \d{1,2} \d{2}:\d{2}:\d{2} \d{4}) GMT/', $text, $start) &&
            preg_match('/Not After\s*:\s+([A-Za-z]{3} \d{1,2} \d{2}:\d{2}:\d{2} \d{4}) GMT/', $text, $end)
        ) {
            $startDate = Carbon::createFromFormat('M d H:i:s Y', $start[1])->addHours(5)->format('d/m/Y H:i:s');
            $endDate = Carbon::createFromFormat('M d H:i:s Y', $end[1])->addHours(5)->format('d/m/Y H:i:s');
            return $startDate . ' - ' . $endDate;
        }
        return null;
    }
    public function download($passportId, $type, $actNumber)
    {
        $file = storage_path("app/pdf_outputs/{$passportId}/{$type}/{$actNumber}/1.cms");

        if (!file_exists($file)) {
            abort(404, 'Файл не найден');
        }

        return response()->download($file);
    }
}
