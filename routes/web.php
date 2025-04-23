<?php



use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return view('main');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware('role:admin');
    Route::get('/tech/dashboard', [TechController::class, 'index'])->middleware('role:tech_supervisor');
    Route::get('/designer/dashboard', [DesignerController::class, 'index'])->middleware('role:designer');
    Route::get('/accountant/dashboard', [AccountantController::class, 'index'])->middleware('role:accountant');
    Route::get('/sales/dashboard', [SalesController::class, 'index'])->middleware('RoleMiddleware:sales_accountant');
    Route::get('/admin/dashboard', [ProjectController::class, 'index'])->middleware('auth');
    // Route::get('/admin/dashboard', [AdminController::class, 'show'])->name('admin.dashboard');

});


// Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware('role:admin');
// Route::get('/tech/dashboard', [TechController::class, 'index'])->middleware('role:tech_supervisor');
// Route::get('/designer/dashboard', [DesignerController::class, 'index'])->middleware('role:designer');
// Route::get('/accountant/dashboard', [AccountantController::class, 'index'])->middleware('role:accountant');
// Route::get('/sales/dashboard', [SalesController::class, 'index'])->middleware('role:sales_accountant');

require __DIR__.'/auth.php';
