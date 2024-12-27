<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('departamentos', DepartamentoController::class);
    Route::resource('pesquisas', PesquisaController::class);
    Route::resource('respostas', RespostaController::class);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
