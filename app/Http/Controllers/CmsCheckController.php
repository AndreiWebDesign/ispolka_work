<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class CmsCheckController extends Controller
{
    // Показать кнопку или ссылку на проверку
    public function index()
    {
        return view('cms_check');
    }

    // Извлечь PDF из заранее загруженного .cms
    public function extract()
    {
        $cmsFilename = 'act_17.cms';
        $cmsPath = storage_path("app/cms/act_17.cms");
        $pdfOutputPath = storage_path("app/cms_uploads/act_17_extracted.pdf");

        $command = "openssl cms -verify -in act_17.cms -inform DER -noverify -out output.pdf
" . escapeshellarg($pdfOutputPath) . " 2>&1";

        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            Log::error("Ошибка openssl: ", ['output' => $output]);
            return response("Не удалось извлечь PDF: " . implode("\n", $output), 500);
        }

        return response()->download($pdfOutputPath);
    }
}
