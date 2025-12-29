<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleRequisitionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes (Laravel's built-in)
Auth::routes();

// Authenticated user routes
// Route::middleware(['auth'])->group(function () {
    
    // Dashboard/Home
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('requisitions.index');
    })->name('dashboard');

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::get('/password', [ProfileController::class, 'editPassword'])->name('password.edit');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    // Vehicle Requisition routes
    Route::resource('requisitions', VehicleRequisitionController::class);
// });

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Requisitions management
    Route::get('/requisitions', [AdminDashboardController::class, 'requisitions'])->name('requisitions');
    Route::put('/requisitions/{requisition}/status', [AdminDashboardController::class, 'updateRequisitionStatus'])->name('requisitions.status');
    
    // User management
    Route::resource('users', AdminUserController::class);
    
    // Activity logs
    Route::get('/activities', [AdminDashboardController::class, 'activities'])->name('activities');
    
    // Export routes
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/requisitions/excel', [ExportController::class, 'exportRequisitionsExcel'])->name('requisitions.excel');
        Route::get('/requisitions/pdf', [ExportController::class, 'exportRequisitionsPdf'])->name('requisitions.pdf');
        Route::get('/requisition/{requisition}/pdf', [ExportController::class, 'exportSingleRequisitionPdf'])->name('requisition.pdf');
        Route::get('/users/excel', [ExportController::class, 'exportUsersExcel'])->name('users.excel');
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
