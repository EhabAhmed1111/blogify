<?php

use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // http://localhost:8080/api/v1/hello
    Route::prefix('v1')->group(function () {
        Route::get('/hello', function () {
            return "hello";
        });

        Route::apiResource('blogs', BlogController::class);

        Route::post('like/{blog}', [UserController::class, 'like'])->name('like');

        Route::post('comment/{blog}', [UserController::class, 'commentToBLog'])->name('comment');
    });
});


require __DIR__ . '/auth.php';
