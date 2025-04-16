<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Redirect based on the user's role
        $role = Auth::user()->role;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'tech_supervisor' => redirect()->route('tech.dashboard'),
            'designer' => redirect()->route('designer.dashboard'),
            'accountant' => redirect()->route('accountant.dashboard'),
            'sales_accountant' => redirect()->route('sales.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }


//     Route::get('/admin/dashboard', [AdminController::class, 'index'])
//     ->middleware('role:admin')
//     ->name('admin.dashboard');

// Route::get('/tech/dashboard', [TechController::class, 'index'])
//     ->middleware('role:tech_supervisor')
//     ->name('tech.dashboard');

// Route::get('/designer/dashboard', [DesignerController::class, 'index'])
//     ->middleware('role:designer')
//     ->name('designer.dashboard');

// Route::get('/accountant/dashboard', [AccountantController::class, 'index'])
//     ->middleware('role:accountant')
//     ->name('accountant.dashboard');

// Route::get('/sales/dashboard', [SalesController::class, 'index'])
//     ->middleware('role:sales_accountant')
//     ->name('sales.dashboard');


// }
}
