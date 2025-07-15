<?php

use App\Http\Controllers\PDFSignController;

Route::post('/pdf/sign', [PDFSignController::class, 'sign'])->name('pdf.sign');
