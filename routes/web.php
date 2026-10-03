<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\adminController as AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::view('/', 'welcome');
Route::get('/test-toast', function () {
    return redirect()->route('device')
        ->with('pairing_success', true)
        ->with('paired_device_id', "ADMIN123"); // Replace 1 with a real device ID if available
});

// Authentication
Route::get('/login',[AuthController::class,'index']);
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset
Route::get('/forgot-password',[ForgotPasswordController::class,'index'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Protected Routes (Must be logged in)
Route::middleware('auth')->group(function () {
    
    // ==========================================
    // ACCESSIBLE TO BOTH ADMINS & SUPERADMINS
    // ==========================================
    
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    Route::get('/analytics',[AnalyticsController::class,'index'])->name('analytics');
    
    // Reports
    Route::get('/reports',[ReportsController::class,'index'])->name('reports');
    Route::get('/reports/csv',[ReportsController::class,'exportCsv'])->name('reports.csv');
    Route::get('/reports/preview-pdf', [ReportsController::class, 'previewPdf'])->name('reports.preview');
    Route::get('/reports/pdf',[ReportsController::class,'exportPdf'])->name('reports.pdf');
    
    // Device Management
    Route::get('/device',[DeviceController::class,'index'])->name('device');
    Route::get('/device/add',[DeviceController::class,'create'])->name('device.create');
    Route::post('/device/add',[DeviceController::class,'store'])->name('device.store');
    Route::get('/device/{device}/edit',[DeviceController::class,'edit'])->name('device.edit');
    Route::put('/device/{device}/update', [DeviceController::class, 'update'])->name('device.update');
    Route::get('/device/{device}', [DeviceController::class, 'show'])->name('device.show');
    Route::delete('/device/{device}/delete', [DeviceController::class, 'destroy'])->name('device.destroy');
    Route::post('/device/{device}/lock', [DeviceController::class, 'lockDevice'])->name('device.lock');
    Route::post('/device/{device}/announce', [DeviceController::class, 'announceDevice'])->name('device.announce');
    
    // Account (Personal Settings)
    Route::get('/account',[AccountController::class,'index'])->name('account');
    Route::post('/account/send-code',[AccountController::class,'sendCode'])->name('account.send-code');
    Route::put('/account/update',[AccountController::class,'update'])->name('account.update');
    Route::delete('/account/delete',[AccountController::class,'destroy'])->name('account.delete');
    
    // ==========================================
    // RESTRICTED TO SUPERADMIN ONLY
    // ==========================================
    Route::middleware('superadmin')->group(function () {
        
        // User Management
        Route::get('/users',[UserController::class,'index'])->name('user');
        Route::get('/users/add',[UserController::class,'create'])->name('user.create');
        Route::post('/users/add',[UserController::class,'store'])->name('user.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');    
        Route::get('/users/{user}/edit',[UserController::class,'edit'])->name('user.edit');
        Route::put('/users/{user}/update',[UserController::class,'update'])->name('user.update');
        Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])->name('user.destroy');
        
    });
});