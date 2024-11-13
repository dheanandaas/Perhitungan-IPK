<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('/krs', [MahasiswaController::class, 'getKRS']);
Route::get('/', function () {
    return view('welcome');
});
