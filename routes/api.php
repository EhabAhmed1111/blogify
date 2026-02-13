<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function() {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // http://localhost:8080/api/v1/hello
    Route::prefix('v1')->group(function() {
        Route::get('/hello', function() {
            return "hello";
        });
    });
});


require __DIR__.'/auth.php';
