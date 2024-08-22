<?php

use App\Livewire\Auth\{Login, Register};
use App\Livewire\{Welcome};
use Illuminate\Support\Facades\Route;

Route::get('/register', Register::class)->name('auth.register');
Route::get('/login', Login::class)->name('login');
Route::get('/password/recovery', function () {
    return "Oi";
})->name('auth.password.recovery');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', Welcome::class)->name('dashboard');
});
