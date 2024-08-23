<?php

use App\Livewire\Auth\Password\Recovery;
use App\Livewire\Auth\{Login, Register};
use App\Livewire\{Welcome};
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('auth.register');
Route::get('/password/recovery', Recovery::class)->name('password.recovery');
Route::get('/password/reset', fn () => 'Oi')->name('password.reset');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', Welcome::class)->name('dashboard');
});
