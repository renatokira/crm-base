<?php

use App\Livewire\Auth\Password\{Recovery, Reset};
use App\Livewire\Auth\{Login, Register};
use App\Livewire\{Welcome};
use Illuminate\Support\Facades\Route;

//region Login
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('auth.register');
Route::get('/password/recovery', Recovery::class)->name('password.recovery');
Route::get('/password/reset', Reset::class)->name('password.reset');
//endregion

//region Autenticated
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', Welcome::class)->name('dashboard');

    //region Admin
    Route::prefix('admin')->middleware('can:be-an-admin')->group(function () {
        Route::get('/dashboard', fn () => 'oi')->name('admin.dashboard');
    });
    //endregion

});
//endregion
