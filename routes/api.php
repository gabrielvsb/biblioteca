<?php

use App\Http\Controllers\{AuthController,
    AuthorController,
    CopyController,
    PublisherController,
    LoanController,
    BookController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PublisherController::class)->prefix('publisher')->name('publisher.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
    Route::get('/{id}/books', 'showWithBooks')->name('showbooks');

    Route::middleware(['auth:sanctum'])->group(function (){
        Route::put('/{id}', 'update')
            ->name('update')
            ->middleware([
                'role:admin|employee',
                'permission:update_publisher'
            ]);
        Route::post('/', 'store')
            ->name('store')
            ->middleware([
                'role:admin|employee',
                'permission:create_publisher'
            ]);
        Route::delete('/{id}', 'destroy')
            ->name('destroy')
            ->middleware([
                'role:admin',
                'permission:delete_publisher'
            ]);
    });
});

Route::controller(AuthorController::class)->prefix('author')->name('author.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/{id}', 'show')->name('show');

    Route::middleware(['auth:sanctum'])->group(function (){
        Route::put('/{id}', 'update')
            ->name('update')
            ->middleware([
                'role:admin|employee',
                'permission:update_author'
            ]);
        Route::post('/', 'store')
            ->name('store')
            ->middleware([
                'role:admin|employee',
                'permission:create_author'
            ]);
        Route::delete('/{id}', 'destroy')
            ->name('destroy')
            ->middleware([
                'role:admin',
                'permission:delete_author'
            ]);
    });
});

Route::controller(CopyController::class)->middleware(['auth:sanctum'])->prefix('copy')->name('copy.')->group(function (){
    Route::get('/',  'index')
        ->name('index')
        ->middleware([
            'role:admin|employee',
            'permission:view_copy_list'
        ]);
    Route::get('/{id}', 'show')
        ->name('show')
        ->middleware([
            'role:admin|employee',
            'permission:view_copy_detail'
        ]);
    Route::put('/{id}', 'update')
        ->name('update')
        ->middleware([
            'role:admin|employee',
            'permission:update_copy'
        ]);
    Route::post('/', 'store')
        ->name('store')
        ->middleware([
            'role:admin|employee',
            'permission:create_copy'
        ]);
    Route::delete('/{id}', 'destroy')
        ->name('destroy')
        ->middleware([
            'role:admin',
            'permission:delete_copy'
        ]);
});

Route::controller(BookController::class)->prefix('book')->name('book.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
    Route::get('/{id}/author', 'showWithAuthor')->name('showauthor');
    Route::get('/{id}/publisher', 'showWithPublisher')->name('showpublisher');

    Route::middleware(['auth:sanctum'])->group(function (){
        Route::get('/{id}/copies', 'showWithCopies')
            ->name('showcopies')
            ->middleware([
                'role:admin|employee',
                'permission:view_book_copies'
            ]);
        Route::put('/{id}', 'update')
            ->name('update')
            ->middleware([
                'role:admin|employee',
                'permission:update_book'
            ]);
        Route::post('/', 'store')
            ->name('store')
            ->middleware([
                'role:admin|employee',
                'permission:create_book'
            ]);
        Route::delete('/{id}', 'destroy')
            ->name('destroy')
            ->middleware([
                'role:admin',
                'permission:delete_book'
            ]);
    });
});

Route::controller(LoanController::class)->middleware(['auth:sanctum'])->prefix('loan')->name('loan.')->group(function (){
    Route::get('/',  'index')
        ->name('index')
        ->middleware([
            'role:admin|employee',
            'permission:view_loan_list'
        ]);
    Route::get('/{id}', 'show')
        ->name('show')
        ->middleware([
            'role:admin|employee|reader',
            'permission:view_loan_detail'
        ]);
    Route::get('/{id}/user', 'showWithUser')
        ->name('showuser')
        ->middleware([
            'role:admin|employee|reader',
            'permission:view_loan_user'
        ]);
    Route::get('/{id}/book', 'showWithBook')
        ->name('showbook')
        ->middleware([
            'role:admin|employee|reader',
            'permission:view_loan_book'
        ]);
    Route::get('/{id}/complete', 'complete')
        ->name('complete')
        ->middleware([
            'role:admin|employee|reader',
            'permission:view_loan_complete'
        ]);
    Route::put('/{id}', 'update')
        ->name('update')
        ->middleware([
            'role:admin|employee',
            'permission:update_loan'
        ]);
    Route::post('/', 'store')
        ->name('store')
        ->middleware([
            'role:admin|employee',
            'permission:create_loan'
        ]);
    Route::delete('/{id}', 'destroy')
        ->name('destroy')
        ->middleware([
            'role:admin',
            'permission:delete_loan'
        ]);
});

Route::controller(AuthController::class)->prefix('auth')->name('auth.')->group(function (){
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')
        ->name('logout')
        ->middleware([
            'auth:sanctum'
        ]);
});
