<?php

use App\Enum\CanEnum;
use App\Livewire\Admin\Dashboard;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

it('should block access to users without the permission be an admin', function () {
    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user);

    Livewire::test(Dashboard::class)
        ->assertForbidden();

    get(route('admin.dashboard'))
        ->assertForbidden();
});

it('should allow access to users with the permission be an admin', function () {
    /** @var User $user */
    $user = User::factory()->create();
    $user->givePermissionTo(CanEnum::BE_AN_ADMIN);

    actingAs($user);

    Livewire::test(Dashboard::class)
        ->assertOk();

    get(route('admin.dashboard'))
        ->assertOk();
});
