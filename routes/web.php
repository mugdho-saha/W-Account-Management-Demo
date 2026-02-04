<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    });

    // Level 2: Only Moderators can enter here
    Route::middleware(['role:moderator'])->group(function () {

    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
