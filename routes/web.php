<?php

use App\Http\Controller\DashboardController as ControllerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; // Ensure this class exists in the specified namespace
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Models\Project;
use App\Http\Controllers\ClientManagementController;
use App\Http\Controllers\ProjectManagementController;
use App\Http\Controllers\Settings;
use App\Http\Controllers\Inbox;
use App\Http\Controllers\ReportsandAnalytics;
use App\Http\Controllers\ScheduleInstallationController;

use App\Http\Controllers\RoleMiddleware;
Route::get('/', function () {
    return view('main');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


    //profile route
    Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Navigation with admin login

    // Admin Route
    //navigating with admin login

// for the client management
    Route::get('/admin/ClientManagement', [ClientManagementController::class, 'index'])->name('admin.ClientManagement');
    //for saving the client
    Route::post('/clients/store', [ClientManagementController::class, 'store'])->name('clients.store');

// Route::post('/clients', [ClientManagementController::class, 'store'])->name('clients.store');
    Route::get('/admin/Settings', [Settings::class, 'index'])->name('admin.Settings')->middleware('auth');
    Route::get('/admin/Inbox', [Inbox::class, 'index'])->name('admin.Inbox')->middleware('auth');
    Route::get('/admin/ReportsandAnalytics', [ReportsandAnalytics::class, 'index'])->name('admin.ReportsandAnalytics')->middleware('auth');
    Route::get('/admin/ScheduleInstallation', [ScheduleInstallationController::class, 'index'])->name('admin.ScheduleInstallation')->middleware('auth');

    //navigating with tech user login

    Route::get('/tech/dashboard', [TechController::class, 'index'])->middleware('role:tech_supervisor');
    //navigating with Designer user login

    Route::get('/designer/dashboard', [DesignerController::class, 'index'])->middleware('role:designer');
       //navigating with tech accountant login

    Route::get('/accountant/dashboard', [AccountantController::class, 'index'])->middleware('role:accountant');
        //navigating with sales accountant  user login

    Route::get('/sales/dashboard', [SalesController::class, 'index'])->middleware(middleware: 'RoleMiddleware:sales_accountant');

    // Route::get('/admin/bick', [DashboardController::class, 'dashboard']);
    Route::get('/admin/ProjectManagement', action: [ProjectController::class, 'index'])->name('admin.ProjectManagement');


    Route::get('/admin/Dashboard2',  [ProjectController::class, 'index'])->name('admin.Dashboard2');

});


// Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware('role:admin');
// Route::get('/tech/dashboard', [TechController::class, 'index'])->middleware('role:tech_supervisor');
// Route::get('/designer/dashboard', [DesignerController::class, 'index'])->middleware('role:designer');
// Route::get('/accountant/dashboard', [AccountantController::class, 'index'])->middleware('role:accountant');
// Route::get('/sales/dashboard', [SalesController::class, 'index'])->middleware('role:sales_accountant');

require __DIR__.'/auth.php';
