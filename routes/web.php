<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NPSController;
use App\Http\Controllers\TestConnectionController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/nps', [NPSController::class, 'index']);
Route::get('/test-connection', [TestConnectionController::class, 'testConnectionMysql']);
