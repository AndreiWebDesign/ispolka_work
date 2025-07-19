<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HiddenWork;
use Illuminate\Support\Facades\Response;

class PdfActController extends Controller
{

    public function sign(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:hidden_works,id',
        'cms' => 'required|string',
    ]);

    $act = HiddenWork::findOrFail($request->id);
    $cmsBase64 = $request->input('cms');

    // Декодируй CMS и сохрани, например:
    $cmsBinary = base64_decode($cmsBase64);
    $cmsPath = storage_path("app/cms/act_{$act->id}.cms");
    file_put_contents($cmsPath, $cmsBinary);

    // Возвращаем успешный ответ
    return response()->json([
        'message' => 'CMS сохранён успешно',
        'cms_path' => $cmsPath
    ]);
}
    public function signPdf(Request $request)
    {
        $id = $request->input('id');
        $cmsBase64 = $request->input('cms');

        $cmsBinary = base64_decode($cmsBase64);

        $fileName = "act_{$id}.cms"; // или .cms
        $path = storage_path("app/pdf_signatures/{$fileName}");
        file_put_contents($path, $cmsBinary);

        return response()->json(['success' => true]);
    }


    public function getBase64($id)
    {
        $pdfPath = storage_path("app/pdf_outputs/act_{$id}.pdf");

        if (!file_exists($pdfPath)) {
            return response()->json(['error' => 'Файл не найден'], 404);
        }

        $content = file_get_contents($pdfPath);
        $base64 = base64_encode($content);

        return response()->json(['base64' => $base64]);
    }

    // Отдаёт PDF в виде Base64 для подписания (TBS для CMS)
    public function getPdfHashBase64($id)
    {
        $act = HiddenWork::findOrFail($id);
        $pdfPath = storage_path("app/pdf_outputs/act_{$act->id}.pdf");

        if (!file_exists($pdfPath)) {
            return response()->json(['error' => 'PDF not found'], 404);
        }

        $pdfContent = file_get_contents($pdfPath);
        $base64 = base64_encode($pdfContent);

        return response()->json(['base64' => $base64]);
    }

    // Принимает .CMS подпись и сохраняет в файл
    public function receiveCms(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'cms' => 'required|string'
        ]);

        $id = $request->input('id');
        $cms = $request->input('cms');

        $cmsDecoded = base64_decode($cms);

        if ($cmsDecoded === false) {
            return response()->json(['error' => 'Invalid base64 CMS'], 400);
        }

        $directory = storage_path("app/pdf_signatures");
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $fileName = "act_{$id}.cms";
        $cmsPath = $directory . DIRECTORY_SEPARATOR . $fileName;

        file_put_contents($cmsPath, $cmsDecoded);

        // Скачивание .cms файла клиентом
        return response()->json([
            'success' => true,
            'path' => $cmsPath
        ]);
    }

}
