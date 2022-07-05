<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutorController;
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
    Route::get('/{id}/livros', 'showWithBooks')->name('showbooks');

    Route::middleware(['auth:sanctum'])->group(function (){
        Route::put('/{id}', 'update')->name('update')->middleware(['auth:sanctum']);
        Route::post('/', 'store')->name('store')->middleware(['auth:sanctum']);
        Route::delete('/{id}', 'destroy')->name('destroy')->middleware(['auth:sanctum']);
    });
});

Route::controller(AutorController::class)->prefix('autor')->name('autor.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/{id}', 'show')->name('show');

    Route::middleware(['auth:sanctum'])->group(function (){
        Route::put('/{id}', 'update')->name('update')->middleware(['auth:sanctum']);
        Route::post('/', 'store')->name('store')->middleware(['auth:sanctum']);
        Route::delete('/{id}', 'destroy')->name('destroy')->middleware(['auth:sanctum']);
    });
});

Route::controller(LivroController::class)->prefix('livro')->name('livro.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
    Route::get('/{id}/autor', 'showWithAutor')->name('showautor');
    Route::get('/{id}/editora', 'showWithEditora')->name('showeditora');

    Route::middleware(['auth:sanctum'])->group(function (){
        Route::get('/{id}/emprestimos', 'showWithEmprestimos')->name('showemprestimos');
        Route::put('/{id}', 'update')->name('update');
        Route::post('/', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
});

Route::controller(EmprestimoController::class)->middleware(['auth:sanctum'])->prefix('emprestimo')->name('emprestimo.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
    Route::get('/{id}/usuario', 'showWithUser')->name('showuser');
    Route::get('/{id}/livro', 'showWithBook')->name('showbook');
    Route::get('/{id}/completo', 'complete')->name('complete');
    Route::put('/{id}', 'update')->name('update');
    Route::post('/', 'store')->name('store');
    Route::delete('/{id}', 'destroy')->name('destroy');
});

Route::controller(AuthController::class)->prefix('auth')->name('auth.')->group(function (){
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout')->middleware(['auth:sanctum']);
});
