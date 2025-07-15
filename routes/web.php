<?php

use App\Http\Controllers\PdfActController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ExecutiveDocsController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\ActController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;


// Главная страница (доступна всем)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Группа защищённых маршрутов
Route::middleware(['auth'])->group(function () {

    // Аутентификация (dashboard и logout)
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Исполнительная документация
    Route::post('/executive-docs', [ExecutiveDocsController::class, 'store'])->name('executive-docs.store');

    // Объекты и акты
    Route::get('/objects', [PassportController::class, 'index'])->name('objects.index');
    Route::get('/objects/create', [PassportController::class, 'create'])->name('objects.create');
    Route::post('/objects', [PassportController::class, 'store'])->name('objects.store');
    Route::get('/objects/{passport}', [PassportController::class, 'show'])->name('objects.show');
    Route::get('/objects/{passport}/acts/create', [ActController::class, 'create'])->name('acts.create');
    Route::post('/objects/{passport}/acts', [ActController::class, 'store'])->name('acts.store');
    Route::get('/acts/{id}/pdf', [PdfActController::class, 'download'])->name('acts.pdf');
});

// Маршруты для регистрации и логина (доступны всем)
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

Route::get('/pdf/hash/{id}', [PdfActController::class, 'getHash']);
Route::post('/pdf/sign', [PdfActController::class, 'signPdf']);
Route::get('/qr/{id}', [QrController::class, 'show'])->name('qr.xml.view');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/complete', [ProfileController::class, 'edit'])->name('complete-profile');
    Route::post('/profile/complete', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('profile.complete')->group(function () {
        Route::resource('projects', ProjectController::class)->middleware('can:create-project');
        Route::post('/projects/{project}/invite', [ProjectController::class, 'invite'])->name('projects.invite');

        Route::get('/notifications', [ProjectController::class, 'notifications'])->name('notifications');
        Route::post('/invitations/{invitation}/accept', [ProjectController::class, 'accept'])->name('invitation.accept');
        Route::post('/invitations/{invitation}/decline', [ProjectController::class, 'decline'])->name('invitation.decline');
    });
});
