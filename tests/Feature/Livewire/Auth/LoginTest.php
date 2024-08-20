<?php

use App\Livewire\Auth\Login;
use App\Models\User;
use Livewire\Livewire;

it('render login component', function () {
    Livewire::test(Login::class)
        ->assertOk();
});

it('should to be able to login in the system', function () {

    $user = User::factory()->create([
        'email' => 'joe@doe.com',
    ]);

    Livewire::test(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'password')
        ->call('tryToLogin')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user()->id)->toBe($user?->id);
});

it('should make sure to inform the user an error when login fails', function () {

    Livewire::test(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'password')
        ->call('tryToLogin')
        ->assertHasErrors(['invalidCredentials' => trans('auth.failed')])
        ->assertSee(trans('auth.failed'));
});
