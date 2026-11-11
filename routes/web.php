<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::view('/', 'welcome');


// Authentication
Route::get('/login',[AuthController::class,'index']);
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset
Route::get('/forgot-password',[ForgotPasswordController::class,'index'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::middleware('auth')->group(function () {
    
    // ==========================================
    // ACCESSIBLE TO BOTH ADMINS & SUPERADMINS
    // ==========================================
    
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    Route::get('/analytics',[AnalyticsController::class,'index'])->name('analytics');
    
    // Reports (Access Log + Student Summary)
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');

    Route::get('/reports/accesslog', function () {
        return redirect()->route('reports.index', array_merge(
            request()->query(),
            ['tab' => 'access', 'step' => 4]
        ));
    })->name('reports.accesslog');

    Route::get('/reports/summary', function () {
        return redirect()->route('reports.index', array_merge(
            request()->query(),
            ['tab' => 'students', 'step' => 4]
        ));
    })->name('reports.summary');

    // Access log PDF
    Route::get('/reports/accesslog/preview-pdf', [ReportsController::class, 'previewPdf'])->name('reports.accesslog.preview');
    Route::get('/reports/accesslog/pdf',[ReportsController::class,'exportPdf'])->name('reports.accesslog.pdf');

    // Summary report PDF
    Route::get('/reports/summary/preview-pdf', [ReportsController::class, 'summaryPreviewPdf'])->name('reports.summary.preview');
    Route::get('/reports/summary/pdf',[ReportsController::class,'summaryExportPdf'])->name('reports.summary.pdf');
    // Device Management

    Route::get('/dashboard/active-sessions', [AdminController::class, 'activeSessions'])->name('dashboard.active-sessions');
    Route::post('/dashboard/sessions/{sessionId}/force-end', [AdminController::class, 'forceEndSession'])->name('dashboard.session.force-end');

    Route::get('/devices',[DeviceController::class,'index'])->name('device');
    Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('device.show');
    Route::delete('/devices/{device}/delete', [DeviceController::class, 'destroy'])->name('device.destroy');
    Route::post('/devices/{device}/lock', [DeviceController::class, 'lockDevice'])->name('device.lock');
    Route::post('/devices/{device}/announce', [DeviceController::class, 'announceDevice'])->name('device.announce');
    // Monitoring
    Route::get('/monitoring',[MonitoringController::class,'index'])->name('monitoring');
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
        
        // Device Management 
        Route::get('/device/add',[DeviceController::class,'create'])->name('device.create');
        Route::post('/device/add',[DeviceController::class,'store'])->name('device.store');
        Route::get('/device/{device}/edit',[DeviceController::class,'edit'])->name('device.edit');
        Route::put('/device/{device}/update', [DeviceController::class, 'update'])->name('device.update');
        Route::delete('/devices/{device}/delete', [DeviceController::class, 'destroy'])->name('device.destroy');
        Route::get('/settings',[SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings',[SettingController::class, 'update'])->name('settings.update');
    });
});