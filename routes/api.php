<?php

use App\Http\Middleware\checkUser as checkUser;
use App\Http\Middleware\checkRegister;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Register;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;

Route::get('/user', function (Request $request) {
    return response()->json(['status' => '204', 'OK' => 'True']);
});
Route::post('/register', [UserController::class, 'Insert'])->middleware(checkRegister::class);

Route::post("/login", function (Request $request) {
    return response()->json(['login_status' => 'success']);
})->middleware(checkUser::class);

Route::get('/getVideo/{id}', [VideoController::class, 'getVideoById']);

Route::get('/getVideo/type/{type}', [VideoController::class, 'getVideoByType']);

Route::get('/getVideoBy', [VideoController::class, 'getVideo']);

Route::post('/upload', [VideoController::class, 'upVideo']);
Route::get('/video/{filename}', [VideoController::class, 'stream']);
