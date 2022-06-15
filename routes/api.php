<?php

use App\Http\Controllers\EditoraController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\LivroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(EditoraController::class)->prefix('editora')->name('editora.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
    Route::put('/{id}', 'update')->name('update');
    Route::post('/', 'store')->name('store');
    Route::delete('/{id}', 'destroy')->name('destroy');
});

Route::controller(LivroController::class)->prefix('livro')->name('livro.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/cadastrar','cadastrar')->name('cadastrar');
    Route::get('/{id}', 'show')->name('show');
    Route::put('/{id}', 'update')->name('update');
    Route::post('/', 'store')->name('store');
    Route::delete('/{id}', 'destroy')->name('destroy');
});

Route::controller(EmprestimoController::class)->prefix('emprestimo')->name('emprestimo.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/cadastrar','cadastrar')->name('cadastrar');
    Route::get('/{id}', 'show')->name('show');
    Route::put('/{id}', 'update')->name('update');
    Route::post('/', 'store')->name('store');
    Route::delete('/{id}', 'destroy')->name('destroy');
});
