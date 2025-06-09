<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechDashboardController;
use App\Http\Controllers\DesignerDashboardController;
use App\Http\Controllers\accountantDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Admin
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');
// });
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
});

// Technical Supervisor
// Route::middleware(['auth', 'role:tech_supervisor'])->group(function () {
//     Route::get('/tech/dashboard', function () {
//         return view('tech.dashboard');
//     })->name('tech.dashboard');
// });


Route::middleware(['auth', 'role:tech_supervisor'])->group(function () {
    Route::get('/tech/dashboard', [TechDashboardController::class, 'index'])
        ->name('tech.dashboard');
});



// Designer
// Route::middleware(['auth', 'role:designer'])->group(function () {
//     Route::get('/designer/dashboard', function () {
//         return view('designer.dashboard');
//     })->name('designer.dashboard');
// });


Route::middleware(['auth', 'role:designer'])->group(function () {
    Route::get('/designer/dashboard', [DesignerDashboardController::class, 'index'])
        ->name('designer.dashboard');
});
// Route::middleware(['auth', 'role:designer'])->group(function () {
//     Route::get('/designer/dashboard', [DesignerDashboardController::class, 'RecentDesignerDashboard'])
//         ->name('designer.dashboard');
// });

// Accountant
Route::middleware(['auth', 'role:accountant'])->group(function () {
    Route::get('/accountant/dashboard', function () {
        return view('accountant.dashboard');
    })->name('accountant.dashboard');
});
Route::middleware(['auth', 'role:accountant'])->group(function () {
    Route::get('/accountant/dashboard', [accountantDashboardController::class, 'index'])
        ->name('accountant.dashboard');
});

// Sales Accountant
Route::middleware(['auth', 'role:sales_accountant'])->group(function () {
    Route::get('/sales/dashboard', function () {
        return view('sales.dashboard');
    })->name('sales.dashboard');
});
