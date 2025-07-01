<?php

use App\Http\Controllers\UserAuthController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::post('/register' , [UserAuthController::class , 'register']);
Route::post('/login' , [UserAuthController::class , 'login']);
Route::get('/users', [UserAuthController::class, 'index']);
Route::delete('/logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [UserAuthController::class, 'me'])->middleware('auth:sanctum');
