<?php

use App\Livewire\Auth\{Login, Register};
use App\Livewire\{Welcome};
use Illuminate\Support\Facades\{Auth, Route};

Route::get('/', Welcome::class)->name('dashboard');
Route::get('/register', Register::class)->name('auth.register');

Route::get('/logout', fn () => Auth::logout());
Route::get('/login', Login::class);
