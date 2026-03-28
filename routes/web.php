<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

// Public entry: send unauthenticated visitors to the login page.
Route::get('/', function () {
    return redirect()->route('login');
});

// -------------------------------------------------------------------------
// Authenticated + verified email: everything below requires a signed-in user
// with a verified address (see Fortify/Jetstream verification flow).
// -------------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {

    // Administrators only: manage application users and transaction categories.
    Route::middleware(['role:admin'])->group(function () {

        // Users: list, create, edit, delete.
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

        // Categories: CRUD for classifying transactions.
        Route::get('/category',[CategoryController::class, 'index'])->name('category.index');
        Route::post('/category',[CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/edit/{category}',[CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/category/edit/{category}',[CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{category}',[CategoryController::class, 'destroy'])->name('category.destroy');
    });

    // Moderators and administrators: full transaction CRUD.
    Route::middleware(['role:moderator|admin'])->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
        Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
        Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');

    });

    // Administrators and observers: dashboard summary (observers typically read-only elsewhere).
    Route::middleware(['role:admin|observer'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Reports: any verified role. Date-wise views and exports (PDF/Excel via query/type).
    Route::get('reports/datewise-report', [ReportController::class, 'datewiseReport'])->name('reports.datewise');
    Route::get('/reports/daily/export', [ReportController::class, 'export'])
        ->name('reports.datewise.export');

    Route::get('/reports/balancesheet', [ReportController::class, 'balancesheet'])->name('reports.balancesheet');
    Route::get('/reports/balancesheet/export', [ReportController::class, 'exportBalanceSheet'])->name('reports.balancesheet.export');

    // Profile: current user’s account settings and deletion (any verified role).
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Login, registration, password reset, and email verification routes.
require __DIR__.'/auth.php';
