<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

abstract class QrController
{
    public function show($id) {
        $path = "qr_xml/act_{$id}.xml";
        if (!Storage::exists($path)) {
            abort(404);
        }
        return response(Storage::get($path), 200)->header('Content-Type', 'application/xml');
    }

}
