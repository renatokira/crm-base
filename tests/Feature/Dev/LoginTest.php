<?php

use App\Livewire\Dev;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\assertAuthenticatedAs;

it('should be able to list all users of the application', function () {

    User::factory()->count(10)->create();

    $users = User::all();

    Livewire::test(Dev\Login::class)
        ->assertSet('users', $users)
        ->assertSee($users->first()->name);
});

it('should be able to login with any user', function () {

    /**
     * @var User $user
     */
    $user = User::factory()->create();

    Livewire::test(Dev\Login::class)->set('selectedUser', $user->id)
        ->call('tryToLogin')
        ->assertRedirect(route('welcome'));

    assertAuthenticatedAs($user);
});
