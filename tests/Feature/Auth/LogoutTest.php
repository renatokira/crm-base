<?php

use App\Livewire\Auth\Logout;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should to be able to logout in the system', function () {

    /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
    $user = User::factory()->create();

    actingAs($user);

    Livewire::test(Logout::class)
    ->call('logout')
    ->assertRedirect(route('login'));

    expect(auth())
    ->guest()
    ->toBeTrue();

});
