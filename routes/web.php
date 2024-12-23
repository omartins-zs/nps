<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NPSController;
use App\Http\Controllers\TestConnectionController;
use Laravel\Socialite\Facades\Socialite;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/nps', [NPSController::class, 'index'])->name('dashboard');

Route::get('/relatorio-indicadores-json/{month}/{year}/{id}', [NpsController::class, 'relatorioIndicadoresJson']);

Route::get('/grafico/{month}/{year}', [NpsController::class, 'grafico']);

Route::get('/graficoLinhaMeses/{month}/{year}/{detalhado}', [NpsController::class, 'graficoLinhaMeses']);

Route::get('/graficoPrevisao/{month}/{year}', [NpsController::class, 'graficoPrevisao']);

Route::get('/graficoPrevisaoLinhaMeses/{month}/{year}/{detalhado}', [NpsController::class, 'graficoPrevisaoLinhaMeses']);

Route::post('/comparar-chamados', [NpsController::class, 'comparar'])->name('comparar.chamados');

Route::get('/test-connection', [TestConnectionController::class, 'testConnectionMysql']);

// Rota para redirecionar ao Google
Route::get('auth/google', [LoginController::class, 'googleLogin'])->name('auth.google');

// Rota de callback após o login com Google
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);


