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
use App\Http\Controllers\salesDashboardController;
use App\Http\Controllers\ProductionSettingsController;
use App\Http\Controllers\ProductionProjectManagementController;
use App\Http\Controllers\InstallationSettingsController;
use App\Http\Controllers\InstallationProjectManagementController;
use App\Http\Controllers\ProductionClientController;
use App\Http\Controllers\InstallationClientController;
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

    Route::get('reset-password/success', function () {
        return view('auth.reset-success');
    })->name('password.reset.success');

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


use App\Http\Middleware\UpdateLastSeen;

Route::middleware(['auth', 'role:administrator', UpdateLastSeen::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
});

Route::middleware(['auth', 'role:tech_supervisor', UpdateLastSeen::class])->group(function () {
    Route::get('/tech/dashboard', [TechDashboardController::class, 'index'])
        ->name('tech.dashboard');
});

Route::middleware(['auth', 'role:designer', UpdateLastSeen::class])->group(function () {
    Route::get('/designer/dashboard', [DesignerDashboardController::class, 'index'])
        ->name('designer.dashboard');
});

Route::middleware(['auth', 'role:accountant', UpdateLastSeen::class])->group(function () {
    Route::get('/accountant/dashboard', [accountantDashboardController::class, 'index'])
        ->name('accountant.dashboard');
});

Route::middleware(['auth', 'role:sales_account', UpdateLastSeen::class])->group(function () {
    Route::get('/sales/dashboard', [salesDashboardController::class, 'index'])
        ->name('sales.dashboard');
});

// Production Officer
Route::middleware(['auth', 'role:production_officer', UpdateLastSeen::class])->group(function () {
    Route::get('/production/settings', [ProductionSettingsController::class, 'index'])
        ->name('production.settings');
    Route::get('/production/projects', [ProductionProjectManagementController::class, 'index'])
        ->name('production.projects');
    Route::get('/production/projects/{project}/info', [ProductionClientController::class, 'showProjectname'])
        ->name('production.projects.info');
});

// Installation Officer
Route::middleware(['auth', 'role:installation_officer', UpdateLastSeen::class])->group(function () {
    Route::get('/installation/settings', [InstallationSettingsController::class, 'index'])
        ->name('installation.settings');
    Route::get('/installation/projects', [InstallationProjectManagementController::class, 'index'])
        ->name('installation.projects');
    Route::get('/installation/projects/{project}/info', [InstallationClientController::class, 'showProjectname'])
        ->name('installation.projects.info');
});
