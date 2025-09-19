<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GatemanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HrController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Gateman routes
Route::middleware(['auth', 'role:Gateman'])->group(function () {
    Route::get('/gateman', [GatemanController::class, 'index'])->name('gateman.dashboard');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
});

Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::middleware('can:isAdmin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

        Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });

    // HR routes
    Route::middleware('can:isHr')->group(function () {
        Route::get('/hr/dashboard', [HrController::class, 'index'])->name('hr.dashboard');
        Route::get('/hr/reports', [HrController::class, 'reports'])->name('hr.reports');

        Route::get('/hr/employees/create', [HrController::class, 'createEmployee'])->name('hr.employees.create');
        Route::post('/hr/employees', [HrController::class, 'storeEmployee'])->name('hr.employees.store');
        Route::get('/hr/employees/{id}/edit', [HrController::class, 'editEmployee'])->name('hr.employees.edit');
        Route::put('/hr/employees/{id}', [HrController::class, 'updateEmployee'])->name('hr.employees.update');
        Route::delete('/hr/employees/{id}', [HrController::class, 'deleteEmployee'])->name('hr.employees.delete');
    });
});