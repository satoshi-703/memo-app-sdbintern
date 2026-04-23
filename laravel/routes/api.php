<?php

use App\Http\Controllers\MemoController;
use Illuminate\Support\Facades\Route;

Route::get('/memos', [MemoController::class, 'index']);
Route::post('/memos', [MemoController::class, 'store']);
