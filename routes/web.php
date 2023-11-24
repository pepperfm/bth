<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('login', [AuthController::class, 'showLoginForm'])
    ->name('login.form')
    ->middleware('guest');
Route::post('login', [AuthController::class, 'login'])
    ->name('login')
    ->middleware('guest');
Route::get('logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::group([
    'middleware' => 'auth',
], static function(): void {
    Route::inertia('/', 'App')->name('home');
    Route::resource('products', \App\Http\Controllers\ProductController::class)->except('edit');
});
