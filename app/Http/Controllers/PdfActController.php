<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HiddenWork;
use Illuminate\Support\Facades\Response;
use mikehaertl\pdftk\Pdf;
use App\Models\ActSignature;

class PdfActController extends Controller
{
    protected function notifyOtherRoles(HiddenWork $act)
    {
        $rolesToNotify = ['технадзор', 'авторнадзор'];

        foreach ($rolesToNotify as $role) {
            $users = User::where('role', $role)
                ->whereHas('passports', fn($q) => $q->where('id', $act->passport_id))
                ->get();

            foreach ($users as $user) {
                Notification::send($user, new ActSignedNotification($act, 'подрядчик'));
            }
        }
    }
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
            'type' => 'required|string|in:hidden_works,intermediate_accept,other_type',
            'id' => 'required|integer', // Это act_number
            'cms' => 'required|string',
        ]);

        $type = $request->input('type');
        $actNumber = $request->input('id'); // Это act_number
        $cmsBase64 = $request->input('cms');

        $modelMap = [
            'hidden_works' => \App\Models\HiddenWork::class,
            'intermediate_accept' => \App\Models\IntermediateAccept::class,
        ];

        if (!array_key_exists($type, $modelMap)) {
            return response()->json(['error' => 'Invalid type provided.'], 422);
        }

        $modelClass = $modelMap[$type];

        // ✅ Получаем акт по act_number
        $act = $modelClass::where('act_number', $actNumber)->firstOrFail();
        $passportId = $act->passport_id ?? 'unknown_passport';

        $signatureCount = count(glob(storage_path("app/pdf_outputs/{$passportId}/{$type}/{$actNumber}/*.cms")));
        $signatureNumber = $signatureCount + 1;

        $cmsBinary = base64_decode($cmsBase64);
        $cmsPath = storage_path("app/pdf_outputs/{$passportId}/{$type}/{$actNumber}/{$signatureNumber}.cms");

        $dir = dirname($cmsPath);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($cmsPath, $cmsBinary);

        $user = auth()->user();

        \App\Models\ActSignature::updateOrCreate(
            [
                'actable_id' => $act->id,
                'actable_type' => $modelClass,
                'user_id' => $user->id,
                'role' => $user->role,
            ],
            [
                'cms' => "pdf_outputs/{$passportId}/{$type}/{$actNumber}/{$signatureNumber}.cms",
                'signed_at' => now(),
                'status' => 'подписано',
            ]
        );

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


    public function getBase64($type, $actNumber)
    {
        $act = HiddenWork::where('act_number', $actNumber)->firstOrFail();

        $passportId = $act->passport_id;

        $pdfPath = storage_path("app/pdf_outputs/{$passportId}/{$type}/{$actNumber}/{$actNumber}.pdf");

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
    public function view($type, $id)
    {
        $act = HiddenWork::findOrFail($id);

        $passportId = $act->passport_id;
        $actNumber = $act->act_number;

        $pdfPath = storage_path("app/pdf_outputs/{$passportId}/{$type}/{$actNumber}/{$actNumber}.pdf");

        if (!file_exists($pdfPath)) {
            abort(404, 'PDF-файл не найден.');
        }

        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Акт.pdf"',
        ]);
    }



}
