<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PdfSignController extends Controller
{
    // страница формы
    public function index()
    {
        return view('pdfsign.index');
    }

    // приём оригинального pdf
    public function upload(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        // сохраняем во временную папку
        $path = $request->file('pdf_file')->store('pdfs');
        return response()->json(['path' => $path]);
    }

    // приём base64-подписанного pdf и отдача ссылки на скачивание
    public function download(Request $request)
    {
        $signedPdfBase64 = $request->input('signed_pdf');
        $filename        = 'signed_' . time() . '.pdf';

        $binary = base64_decode(
            preg_replace('#^data:application/pdf;base64,#i', '', $signedPdfBase64)
        );

        Storage::put('signed_pdfs/' . $filename, $binary);

        return response()->download(storage_path('app/signed_pdfs/' . $filename));
    }
}
