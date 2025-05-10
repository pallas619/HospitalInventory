<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicalEquipmentController;
use App\Http\Controllers\ConsumableController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Berisi semua route untuk aplikasi ini
|
*/

Route::redirect('', '/login');
// Guest Routes (Akses tanpa login)
Route::middleware('guest')->group(function () {
    // Auth Routes
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login.store');
        Route::get('/register', 'showRegisterForm')->name('register');
        Route::post('/register', 'register')->name('register.store');
    });
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes Berdasarkan Role

    // 1. Admin Routes
    Route::middleware('check.role:Admin')->group(function () {
        // User Management
        Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::put('/{user}', 'update')->name('update');
            Route::delete('/{user}', 'destroy')->name('destroy');
        });

        // Consumable Management
        Route::controller(ConsumableController::class)->prefix('consumable')->name('consumables.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{consumable}/edit', 'edit')->name('edit');
            Route::put('/{consumable}', 'update')->name('update');
            Route::delete('/{consumable}', 'destroy')->name('destroy');
        });
    });

    // 2. Admin & Pharmacist Routes
    Route::middleware('check.role:Admin,Pharmacist')->group(function () {
        // Medicine Management
        Route::controller(MedicineController::class)->prefix('medicines')->name('medicines.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{medicine}/edit', 'edit')->name('edit');
            Route::put('/{medicine}', 'update')->name('update');
            Route::delete('/{medicine}', 'destroy')->name('destroy');
        });
    });

    // 3. Admin & Technician Routes
    Route::middleware('check.role:Admin,Technician')->group(function () {
        // Medical Equipment Management
        Route::controller(MedicalEquipmentController::class)->prefix('medical')->name('medical.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{medicalEquipment}/edit', 'edit')->name('edit');
            Route::put('/{medicalEquipment}', 'update')->name('update');
            Route::delete('/{medicalEquipment}', 'destroy')->name('destroy');
        });
    });
});
