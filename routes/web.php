<?php

use App\Livewire\Auth\{Login, Register};
use App\Livewire\{Welcome};
use Illuminate\Support\Facades\{Auth, Route};

Route::get('/register', Register::class)->name('auth.register');
Route::get('/login', Login::class)->name('login');
Route::get('/logout', function () {
    Auth::logout();

    return redirect()->route('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', Welcome::class)->name('dashboard');
});
