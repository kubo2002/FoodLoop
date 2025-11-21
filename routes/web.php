<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// prepnutie jazyka stranky
Route::get('/lang/{locale}', function ($locale) {
    session(['locale' => $locale]);
    session()->save(); // FORCE SAVE

    return back();

})->name('lang.switch');

// homepage
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');


//debug
Route::get('/debug-session', function () {
    return session()->all();
});
