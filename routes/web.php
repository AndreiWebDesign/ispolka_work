<?php

use App\Http\Controllers\ObjectAndProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ActController;
use App\Http\Controllers\PdfActController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\ExecutiveDocsController;



// Главная страница (доступна всем)
Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile/complete', [ProfileController::class, 'edit'])->name('complete-profile');
    Route::post('/profile/complete', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('profile.complete')->group(function () {
        // Управление объектами и проектами (это одно и то же у тебя)
        Route::get('/projects', [ObjectAndProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/create', [ObjectAndProjectController::class, 'projectCreate'])->name('projects.create');
        Route::post('/projects', [ObjectAndProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{passport}', [ObjectAndProjectController::class, 'show'])->name('projects.show');

        Route::post('/projects/{passport}/invite', [ObjectAndProjectController::class, 'invite'])->name('projects.invite');
        Route::get('/notifications', [ObjectAndProjectController::class, 'notifications'])->name('notifications');
        Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::get('/pdf/view/{id}', [PdfActController::class, 'view'])->name('pdf.view');


        Route::post('/invitations/{invitation}/accept', [ObjectAndProjectController::class, 'accept'])->name('invitation.accept');
        Route::post('/invitations/{invitation}/decline', [ObjectAndProjectController::class, 'decline'])->name('invitation.decline');

        // Акты
        Route::get('/projects/{passport}/acts/create', [ActController::class, 'create'])->name('acts.create');
        Route::post('/projects/{passport}/acts', [ActController::class, 'store'])->name('acts.store');
        Route::get('/acts/{id}/pdf', [PdfActController::class, 'download'])->name('acts.pdf');
    });
});


// Маршруты для регистрации и логина (доступны всем)
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

Route::get('/pdf/hash/{id}', [PdfActController::class, 'getHash']);
Route::post('/pdf/sign', [PdfActController::class, 'signPdf']);
Route::get('/qr/{id}', [QrController::class, 'show'])->name('qr.xml.view');

