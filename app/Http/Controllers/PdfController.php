<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfController extends Controller
{
    public function form()
    {
        return view('sign');
    }

    public function upload(Request $r)
    {
        $r->validate(['pdf' => 'required|mimes:pdf|max:10240']);
        $name = Str::uuid() . '.pdf';
        $path = $r->file('pdf')->storeAs('tmp', $name);

        return response()->json([
            'id'   => $name,
            'hash' => hash_file('sha256', Storage::path($path)),
        ]);
    }

    public function finish(Request $r)
    {
        $r->validate([
            'id'  => 'required|string',
            'cms' => 'required|string',
        ]);
        $src  = Storage::path('tmp/' . $r->id);
        abort_unless(file_exists($src), 404);

        // Здесь должна быть ваша логика встраивания подписи и генерации итогового PDF.
        // Для теста просто копируем исходник:
        $dstRel = 'signed/' . pathinfo($r->id, PATHINFO_FILENAME) . '-signed.pdf';
        $dstAbs = Storage::path($dstRel);
        copy($src, $dstAbs);

        return response()->json(['link' => route('sign.download', $dstRel)]);
    }

    public function download(string $id)
    {
        $path = Storage::path($id);
        abort_unless(file_exists($path), 404);

        return response()->download($path);
    }
}
