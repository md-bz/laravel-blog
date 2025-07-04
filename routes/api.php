<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});




Route::get('/', function () {
    return "api";
});

Route::apiResource('blog', BlogController::class);
Route::apiResource('comment', CommentController::class)->middleware('auth:sanctum');
