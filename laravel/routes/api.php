<?php

use App\Http\Controllers\MemoController;
use Illuminate\Support\Facades\Route;

Route::get('/memos', [MemoController::class, 'index']);
Route::post('/memos', [MemoController::class, 'store']);
Route::patch('/memos/{id}', [MemoController::class, 'updata']);
Route::delete('/memos/{id}', [MemoController::class, 'destroy']);
Route::patch('/memos/{id}/restore', [MemoController::class, 'restore']);
