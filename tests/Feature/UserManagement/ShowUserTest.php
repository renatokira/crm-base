<?php

use App\Livewire\Admin;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to show all details of a user in the component', function () {

    $admin = User::factory()->admin()->create();
    $user  = User::factory()->deleted()->create();

    actingAs($admin);
    Livewire::test(Admin\Users\Show::class)
        ->call('load', $user->id)
        ->assertSet('user.id', $user->id)
        ->assertSet('drawer', true)
        ->assertSee($user->email)
        ->assertSee($user->created_at->format('d/m/Y H:i'))
        ->assertSee($user->updated_at->format('d/m/Y H:i'))
        ->assertSee($user->deleted_at->format('d/m/Y H:i'))
        ->assertSee($user->deletedBy->name);
});

it('should be able to restore a user and display information', function () {

    $admin          = User::factory()->admin()->create();
    $forRestoration = User::factory()->deleted()->create();

    actingAs($admin);

    Livewire::test(Admin\Users\Restore::class)
        ->set('user', $forRestoration)
        ->set('confirm_confirmation', 'RESTORE')
        ->call('restore');

    Livewire::test(Admin\Users\Show::class)
        ->call('load', $forRestoration->id)
        ->assertSet('user.id', $forRestoration->id)
        ->assertSet('drawer', true)
        ->assertSee($forRestoration->email)
        ->assertSee($forRestoration->deleted_at?->format('d/m/Y H:i'))
        ->assertSee($forRestoration->restoredBy?->name);
});

it('should open the drawer when event is dispatched', function () {

    $admin = User::factory()->admin()->create();
    $user  = User::factory()->deleted()->create();
    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->call('showUser', $user->id)
        ->assertDispatched('user::show', id: $user->id);
});

it('making sure that the method load has the On', function () {

    $livewireClass = Admin\Users\Show::class;
    $reflection    = new ReflectionClass($livewireClass);
    $method        = $reflection->getMethod('load');

    $attributesLoadUser = $method->getAttributes();

    expect($attributesLoadUser)->toHaveCount(1);

    /** @var ReflectionAttribute $attribuite */
    $attribuite = $attributesLoadUser[0];

    expect($attribuite)->getName()->toBe('Livewire\Attributes\On')
        ->and($attribuite)->getArguments()->toHaveCount(1);

    expect($attribuite->getArguments()[0])->toBe('user::show');
});
