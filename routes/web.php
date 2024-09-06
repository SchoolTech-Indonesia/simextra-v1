<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/profile/photo/upload', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('permissions', PermissionController::class);
// Route::get('/permission', [PermissionController::class, 'show'])->name('user.permission.show');
// Route::get('/permission', PermissionController::class);
});




Route::get('/forgot-password', [OtpController::class, 'showForgotPasswordForm'])->name('password.forgot.form');
Route::post('/forgot-password', [OtpController::class, 'sendOtp'])->name('password.forgot');

Route::get('/verify-otp', [OtpController::class, 'showOtpVerificationForm'])->name('otp.verify.form');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

Route::get('/reset-password', [OtpController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [OtpController::class, 'resetPassword'])->name('password.update');