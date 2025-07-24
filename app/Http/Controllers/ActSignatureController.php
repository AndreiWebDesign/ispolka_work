<?php
namespace App\Http\Controllers;

use App\Models\ActSignature;
use App\Models\HiddenWork;
use App\Models\IntermediateAccept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ActSignatureController extends Controller
{
    public function show($type, $id)
    {
        $modelMap = [
            'hidden_works' => HiddenWork::class,
            'intermediate_accept' => IntermediateAccept::class,
            'Prilozeniye_21' => \App\Models\Prilozeniye_21::class,
            'Prilozeniye_22' => \App\Models\Prilozeniye_22::class,
            'Prilozeniye_23' => \App\Models\Prilozeniye_23::class,
            'Prilozeniye_24' => \App\Models\Prilozeniye_24::class,
            'Prilozeniye_26' => \App\Models\Prilozeniye_26::class,
            'Prilozeniye_27' => \App\Models\Prilozeniye_27::class,
            'Prilozeniye_28' => \App\Models\Prilozeniye_28::class,
            'Prilozeniye_29' => \App\Models\Prilozeniye_29::class,
            'Prilozeniye_30' => \App\Models\Prilozeniye_30::class,
            'Prilozeniye_31' => \App\Models\Prilozeniye_31::class,
            'Prilozeniye_32' => \App\Models\Prilozeniye_32::class,
            'Prilozeniye_67' => \App\Models\Prilozeniye_67::class,
            'Prilozeniye_72' => \App\Models\Prilozeniye_72::class,
            'Prilozeniye_73' => \App\Models\Prilozeniye_73::class,
        ];

        abort_unless(isset($modelMap[$type]), 404);

        $model = $modelMap[$type]::where('act_number', $id)->firstOrFail();

        $signaturesFromDb = ActSignature::where('actable_type', $modelMap[$type])
            ->where('actable_id', $model->id)
            ->get();

        $cmsDir = storage_path("app/pdf_outputs/{$model->passport_id}/{$type}/{$id}");
        $cmsSignatures = [];

        if (File::isDirectory($cmsDir)) {
            foreach (File::files($cmsDir) as $file) {
                if ($file->getExtension() !== 'cms') continue;

                try {
                    $rawOutput = (new Process([
                        'openssl', 'pkcs7',
                        '-inform', 'DER',
                        '-in', $file->getRealPath(),
                        '-print_certs',
                        '-text'
                    ]))->mustRun()->getOutput();

                    $decoded = $this->decodeHexStrings($rawOutput);

                    $cmsSignatures[] = [
                        'serial' => $this->extractSerial($decoded),
                        'iin' => $this->extractIin($decoded),
                        'fio' => $this->extractFio($decoded),
                        'validity' => $this->extractValidity($decoded),
                        'signingDate' => date('Y-m-d H:i:s', filemtime($file->getRealPath())) ?? 'Не удалось получить дату изменения',
                        'template' => 'Физическое лицо',
                        'cms_path' => route('cms.download', [
                            'passportId' => $model->passport_id,
                            'type' => $type,
                            'actNumber' => $model->act_number,
                            'filename' => $file->getFilename(),
                        ]),
                    ];

                    $cmsFiles = File::files(storage_path("app/pdf_outputs/{$model->passport_id}/{$type}/{$model->act_number}"));
                    $cmsFile = collect($cmsFiles)->firstWhere(fn($file) => Str::endsWith($file->getFilename(), '.cms'));

                    if ($cmsFile) {
                        $cmsPath = route('cms.download', [
                            'passportId' => $model->passport_id,
                            'type' => $type,
                            'actNumber' => $model->act_number,
                            'filename' => basename($cmsFile->getRealPath())
                        ]);
                    }
                } catch (ProcessFailedException $e) {
                    continue;
                }
            }
        }

        return view('acts.signatures', compact('model', 'type', 'signaturesFromDb', 'cmsSignatures'));
    }

    private function decodeHexStrings($text)
    {
        return preg_replace_callback('/\\\\x([0-9A-Fa-f]{2})/', fn($m) => chr(hexdec($m[1])), $text);
    }

    private function extractSerial($text)
    {
        return preg_match('/Serial Number:\s+([0-9a-fA-F:\s]+)/', $text, $m)
            ? strtolower(str_replace([':', ' '], '', $m[1]))
            : null;
    }

    private function extractIin($text)
    {
        return preg_match('/serialNumber=IIN(\d{12})/', $text, $m) ? $m[1] : null;
    }

    private function extractFio($text)
    {
        $last = $middle = '';
        if (preg_match('/Subject: CN=([^\n,]+)/', $text, $m)) $last = trim($m[1]);
        if (preg_match('/GN=([^\n,]+)/', $text, $m)) $middle = trim($m[1]);
        return "$last $middle";
    }

    private function extractValidity($text)
    {
        if (
            preg_match('/Not Before:\s+([A-Za-z]{3} \d{1,2} \d{2}:\d{2}:\d{2} \d{4}) GMT/', $text, $start) &&
            preg_match('/Not After\s*:\s+([A-Za-z]{3} \d{1,2} \d{2}:\d{2}:\d{2} \d{4}) GMT/', $text, $end)
        ) {
            $startDate = Carbon::createFromFormat('M d H:i:s Y', $start[1])->addHours(6)->format('d/m/Y H:i:s');
            $endDate = Carbon::createFromFormat('M d H:i:s Y', $end[1])->addHours(6)->format('d/m/Y H:i:s');
            return "$startDate — $endDate";
        }
        return null;
    }

    private function extractSigningTimeFromCms($cmsPath): ?string
    {
        $tempOutput = tempnam(sys_get_temp_dir(), 'cmsout');
        try {
            $verify = new Process([
                'openssl', 'smime',
                '-verify',
                '-in', $cmsPath,
                '-inform', 'DER',
                '-noverify',
                '-out', $tempOutput
            ]);
            $verify->mustRun();
            $output = $verify->getErrorOutput();
            if (preg_match('/signingTime:([A-Za-z]{3} \d{1,2} \d{2}:\d{2}:\d{2} \d{4}) GMT/', $output, $matches)) {
                return Carbon::createFromFormat('M d H:i:s Y', $matches[1], 'GMT')
                    ->setTimezone('Asia/Almaty')->format('d.m.Y H:i:s');
            }
        } catch (\Exception $e) {
            return null;
        } finally {
            @unlink($tempOutput);
        }

        return null;
    }
}
