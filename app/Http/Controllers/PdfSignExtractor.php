<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PdfSignExtractor extends Controller
{
    // страница формы
    public function extractOriginalPdf(Request $request)
    {
        $request->validate([
            'cms' => 'required|file',
        ]);

        $cmsPath = $request->file('cms')->getPathname();
        $outputPath = storage_path('app/extracted_' . uniqid() . '.pdf');

        $result = null;

        try {
            // Используем openssl для извлечения PDF
            $cmd = "openssl smime -verify -in " . escapeshellarg($cmsPath) . " -inform DER -noverify -out " . escapeshellarg($outputPath);
            exec($cmd, $output, $result);

            if ($result !== 0 || !file_exists($outputPath)) {
                return response()->json(['error' => 'Не удалось извлечь PDF из CMS'], 500);
            }

            return response()->download($outputPath)->deleteFileAfterSend();
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
