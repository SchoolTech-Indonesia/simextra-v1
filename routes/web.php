<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
});

Route::middleware(['role:superadmin'])->prefix('admin')->group(function(){
    Route::resource('permissions', PermissionController::class);
    Route::get('/admin/roles/{id}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/admin/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/admin/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

});

Route::get('/forgot-password', [OtpController::class, 'showForgotPasswordForm'])->name('password.forgot.form');
Route::post('/forgot-password', [OtpController::class, 'sendOtp'])->name('password.forgot');

Route::get('/verify-otp', [OtpController::class, 'showOtpVerificationForm'])->name('otp.verify.form');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

Route::get('/reset-password', [OtpController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [OtpController::class, 'resetPassword'])->name('password.update');

