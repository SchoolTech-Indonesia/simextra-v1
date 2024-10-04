<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\ClassController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/user/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
   Route::post('/profile/photo/upload', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');

    Route::post('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.deletePhoto');
    Route::post('/profile/photo/upload', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('permissions', PermissionController::class);
    Route::delete('/admin/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::resource('roles', RoleController::class);
    Route::get('/admin/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/admin/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');

    Route::get('/admin/roles/{id}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/admin/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/admin/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
   
    Route::resource('users', UserController::class);
    Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/admin/users/import', [UserController::class, 'showImportForm'])->name('users.import.form');
    Route::post('/admin/users/import', [UserController::class, 'import'])->name('users.import');
    Route::get('download-pdf', [UserController::class, 'downloadPDF'])->name('users.download-pdf');

    Route::resource('schools', SchoolController::class);
    Route::get('/admin/schools/{id}', [SchoolController::class, 'show'])->name('schools.show');
    Route::get('/admin/schools/{id}/edit', [SchoolController::class, 'edit'])->name('schools.edit');
    Route::put('/admin/schools/{id}', [SchoolController::class, 'update'])->name('schools.update');
    
    Route::resource('majors', MajorController::class);
     Route::get('/admin/majors', [MajorController::class, 'index'])->name('majors.index');
     Route::post('/admin/majors', [MajorController::class, 'store'])->name('majors.store');
     Route::get('/admin/majors/{id}', [MajorController::class, 'show'])->name('majors.show');
     Route::put('/admin/majors/{id}', [MajorController::class, 'update'])->name('majors.update');
     Route::delete('/admin/majors/{major}', [MajorController::class, 'destroy'])->name('majors.destroy');
     Route::get('/admin/majors/{id}/edit', [MajorController::class, 'edit'])->name('majors.edit');
     Route::delete('/majors/{id}/classrooms', [MajorController::class, 'removeClassroom'])->name('majors.removeClassroom');

     // Route::resource('majors', MajorController::class, [
    //     'admin' => [
    //         'index' => 'majors.index',
    //         'store' => 'majors.store',
    //         'show' => 'majors.show',
    //         'edit' => 'majors.edit',
    //         'update' => 'majors.update',
    //         'destroy' => 'majors.destroy',
    //     ],
    //     'parameters' => [
    //         'majors' => 'id', // This will replace {major} with {id} in your URLs
    //     ]
    // ]);
    Route::resource('classroom', ClassController::class);
     Route::get('/classroom', [ClassController::class, 'index'])->name('classroom.index');
     Route::get('/classroom/{id}', [ClassController::class, 'show'])->name('classroom.show');

});

Route::middleware(['role:superadmin'])->prefix('admin')->group(function(){

    

});

Route::get('/forgot-password', [OtpController::class, 'showForgotPasswordForm'])->name('password.forgot.form');
Route::post('/forgot-password', [OtpController::class, 'sendOtp'])->name('password.forgot');

Route::get('/verify-otp', [OtpController::class, 'showOtpVerificationForm'])->name('otp.verify.form');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

Route::get('/reset-password', [OtpController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [OtpController::class, 'resetPassword'])->name('password.update');

