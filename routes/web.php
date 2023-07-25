<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::controller(AuthController::class)->group(function () {
        Route::get('auth/redirect', 'redirect')->name('auth');
        Route::get('auth/callback', 'callback');
    });
});

Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'show')->name('profile.show');
        Route::get('profile/edit', 'edit')->name('profile.edit');
        Route::post('profile/update', 'update')->name('profile.update');
    });

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
