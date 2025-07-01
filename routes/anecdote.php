<?php

use App\Http\Controllers\AnecdoteController;
use Illuminate\Support\Facades\Route;


Route::get('/anecdotes' ,[AnecdoteController::class , 'index'] );
Route::post('/anecdote' ,[AnecdoteController::class , 'store'] )->middleware('auth:sanctum');
?>