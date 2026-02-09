<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return redirect()->route('login');
});


// Level 1: Everyone must be Logged In & Verified
Route::middleware(['auth', 'verified'])->group(function () {

    // Level 2: Only Admins can enter this specific group
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        /*user routes*/
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');


        /*category routes*/
        Route::get('/category',[CategoryController::class, 'index'])->name('category.index');
        Route::post('/category',[CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/edit/{category}',[CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/category/edit/{category}',[CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{category}',[CategoryController::class, 'destroy'])->name('category.destroy');
    });

    // Level 2: Both Moderators and Admins can enter here
    Route::middleware(['role:moderator|admin'])->group(function () {
        /*Routes for transactions*/
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
