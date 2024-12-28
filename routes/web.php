<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ResponseController;

Route::get('/', function () {
    return view('welcome');
});

// Rotas de Departamentos
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/departments/{id}', [DepartmentController::class, 'show'])->name('departments.show');
Route::get('/departments/create', function () {
    return view('departments.create');
})->name('departments.create');
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');

// Rotas de Pesquisas
Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
Route::get('/surveys/{id}', [SurveyController::class, 'show'])->name('surveys.show');
Route::get('/surveys/create', function () {
    return view('surveys.create');
})->name('surveys.create');
Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');

// Rotas de Respostas
Route::get('/responses/{surveyId}', [ResponseController::class, 'showBySurvey'])->name('responses.showBySurvey');
Route::post('/responses', [ResponseController::class, 'store'])->name('responses.store');
