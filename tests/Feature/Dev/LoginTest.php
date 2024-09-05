<?php

use App\Livewire\Dev;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertAuthenticatedAs, get};

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

it('should not load livewire component on production environment', function () {

    app()->detectEnvironment(fn () => 'production');

    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    get(route('welcome')) //app.blade.php
        ->assertDontSeeLivewire('dev.login');

    get(route('login')) //guest.blade.php
        ->assertDontSeeLivewire('dev.login');
});

it('should load livewire component on development environment', function () {

    app()->detectEnvironment(fn () => 'local');

    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    get(route('welcome')) //app.blade.php
        ->assertSeeLivewire('dev.login');

    get(route('login')) //guest.blade.php
        ->assertSeeLivewire('dev.login');
});
