<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReservationController;

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

// profile
Route::get('/profile', [HomeController::class, 'profile'])
    ->middleware('auth')
    ->name('profile');

// edit profile
Route::get('/edit-profile', [HomeController::class, 'editProfile'])
    -> middleware('auth')
    -> name('edit-profile');

// update profile
Route::post('/profile/update', [HomeController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('profile.update');

// DELETE operácia - zmazanie profilovej fotky (CRUD - kompletná implementácia)
Route::delete('/profile/photo', [HomeController::class, 'deletePhoto'])
    ->middleware('auth')
    ->name('profile.photo.delete');


// routy pre CRUD operácie nad Offer
Route::resource('offers', OfferController::class);

// AJAX – ponuky podľa kategórie
Route::get('/categories/{id}/offers', [OfferController::class, 'byCategory'])->name('offers.byCategory');

//debug
Route::get('/debug-session', function () {
    return session()->all();
});

// reservation CRUD
Route::middleware(['auth'])->group(function () {
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/cart/add/{offer}', [ReservationController::class, 'store'])->name('reservations.store');
    Route::patch('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});
