<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HiddenWork;
use Illuminate\Support\Facades\Response;
use mikehaertl\pdftk\Pdf;

class PdfActController extends Controller
{
    public function show(Passport $passport)
    {
        $acts = $passport->acts;
        $cmsFiles = [];

        foreach ($acts as $act) {
            $fullPath = "/var/www/ispolka/storage/app/cms/act_{$act->id}.cms";
            $cmsFiles[$act->id] = file_exists($fullPath);
        }

        return view('your.view.name', compact('passport', 'acts', 'cmsFiles'));
    }

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
    public function downloadCms($id)
    {
        $path = "/var/www/ispolka/storage/app/cms/act_{$id}.cms";

        if (!file_exists($path)) {
            abort(404, 'Файл не найден');
        }

        return response()->download($path, "act_{$id}.cms", [
            'Content-Type' => 'application/pkcs7-signature',
        ]);
    }
    public function view($id)
    {
        $act = HiddenWork::findOrFail($id);

        $pdfPath = storage_path("app/pdf_outputs/act_{$id}.pdf");

        // Если файл отсутствует — генерируем его
        if (!file_exists($pdfPath)) {
            $templatePath = storage_path('app/pdf_templates/hidden_work_template.pdf');

            $fields = [
                'act_number' => $act->act_number,
                'city' => $act->city,
                'act_date' => $act->act_date,
                'object_name' => $act->object_name,
                'contractor_representative' => $act->contractor_representative,
                'tech_supervisor_representative' => $act->tech_supervisor_representative,
                'author_supervisor_representative' => $act->author_supervisor_representative,
                'additional_participants' => $act->additional_participants,
                'work_executor' => $act->work_executor,
                'hidden_works' => $act->hidden_works,
                'psd_info' => $act->psd_info,
                'materials' => $act->materials,
                'compliance_evidence' => $act->compliance_evidence,
                'deviations' => $act->deviations,
                'start_date' => $act->start_date,
                'end_date' => $act->end_date,
                'commission_decision' => $act->commission_decision,
                'next_works' => $act->next_works,
                'contractor_sign_name' => $act->contractor_sign_name,
                'contractor_sign' => $act->contractor_sign,
                'tech_supervisor_sign_name' => $act->tech_supervisor_sign_name,
                'tech_supervisor_sign' => $act->tech_supervisor_sign,
                'author_supervisor_sign_name' => $act->author_supervisor_sign_name,
                'author_supervisor_sign' => $act->author_supervisor_sign,
                'additional_signs' => $act->additional_signs,
            ];

            $pdf = new Pdf($templatePath);
            $result = $pdf->fillForm($fields)
                ->needAppearances()
                ->flatten()
                ->saveAs($pdfPath);

            if (!$result) {
                abort(500, 'Ошибка генерации PDF: ' . $pdf->getError());
            }
        }

        // Возврат для отображения в браузере
        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Акт_просмотр.pdf"',
        ]);
    }

}
