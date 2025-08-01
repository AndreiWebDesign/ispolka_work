<?php

use App\Http\Controllers\ObjectAndProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ActController;
use App\Http\Controllers\PdfActController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ExecutiveDocsController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\ActSignatureController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PassportWizardController;
;



// Главная страница (доступна всем)
Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/complete', [ProfileController::class, 'edit'])->name('complete-profile');
    Route::post('/profile/complete', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/invite', [ProfileController::class, 'inviteEmployee'])->name('profile.invite');


    Route::middleware('profile.complete')->group(function () {
        // Управление объектами и проектами (это одно и то же у тебя)
        Route::get('/projects', [ObjectAndProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/create', [ObjectAndProjectController::class, 'projectCreate'])->name('projects.create');
        Route::post('/projects', [ObjectAndProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{passport}', [ObjectAndProjectController::class, 'show'])->name('projects.show');
        Route::get('/report/{passport}', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
        Route::get('/report', [\App\Http\Controllers\ReportController::class, 'select'])->name('report.select');


        Route::prefix('passport/create')->group(function () {
            Route::get('/step1', [PassportWizardController::class, 'step1'])->name('passport.step1');
            Route::post('/step1', [PassportWizardController::class, 'storeStep1'])->name('passport.storeStep1');

            Route::get('/step2/{id}', [PassportWizardController::class, 'step2'])->name('passport.step2');
            Route::post('/step2/{id}', [PassportWizardController::class, 'storeStep2'])->name('passport.storeStep2');

            Route::get('/step3/{id}', [PassportWizardController::class, 'step3'])->name('passport.step3');
            Route::post('/step3/{id}', [PassportWizardController::class, 'storeStep3'])->name('passport.storeStep3');

            Route::get('/finish/{id}', [PassportWizardController::class, 'finish'])->name('passport.finish');
        });

        Route::post('/projects/{passport}/invite', [ObjectAndProjectController::class, 'invite'])->name('projects.invite');
        Route::get('/notifications', [ObjectAndProjectController::class, 'notifications'])->name('notifications');
        Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::get('/pdf/view/{type}/{id}', [PdfActController::class, 'view'])->name('pdf.view');
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');


        Route::post('/invitations/{invitation}/accept', [ObjectAndProjectController::class, 'accept'])->name('invitation.accept');
        Route::post('/invitations/{invitation}/decline', [ObjectAndProjectController::class, 'decline'])->name('invitation.decline');

        // Акты
        Route::get('/projects/{passport}/acts/create', [ActController::class, 'create'])->name('acts.create');
        Route::post('/projects/{passport}/acts', [ActController::class, 'store'])->name('acts.store');
        Route::get('/acts/{id}/pdf', [PdfActController::class, 'download'])->name('acts.pdf');
        Route::get('/cms/view/{passport}/{type}/{act}', [CmsController::class, 'viewCms'])->name('cms.view');
        Route::get('/cms/download/{passport}/{type}/{act}', [CmsController::class, 'download'])->name('cms.download');
        Route::get('/projects/{passport}/acts/select', [ActController::class, 'select'])->name('acts.select');
        Route::get('/pdf/base64/{type}/{act_number}', [PdfActController::class, 'getBase64'])->name('pdf.base64');
        Route::get('/cms/download/{passportId}/{type}/{actNumber}/{filename}', function ($passportId, $type, $actNumber, $filename) {
            $path = storage_path("app/pdf_outputs/{$passportId}/{$type}/{$actNumber}/{$filename}");

            if (!file_exists($path)) {
                abort(404, 'Файл не найден');
            }

            return response()->download($path);
        })->name('cms.download');


        Route::post('/pdf/sign', [PdfActController::class, 'sign']);
        Route::get('/acts/{type}/{id}/signatures', [ActSignatureController::class, 'show'])->name('acts.signatures');
        Route::post('/acts/reject', [\App\Http\Controllers\ActSignatureController::class, 'reject'])->name('acts.reject');



    });
});


// Маршруты для регистрации и логина (доступны всем)
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');






