<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MajorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Route::middleware(['auth:api'])->group(function () {
//     Route::middleware(['role:Admin'])->group(function () {
//         Route::apiResource('majors', MajorController::class);
//     });
// });