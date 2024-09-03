<?php

use App\Livewire\Admin;
use App\Models\User;
use App\Notifications\{UserRestoredAccessNotification};
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted};

it('should be able to restore a user', function () {
    $user           = User::factory()->admin()->create();
    $forRestoration = User::factory()->deleted()->create();

    actingAs($user);
    Livewire::test(Admin\Users\Restore::class)
        ->set('user', $forRestoration)
        ->set('confirm_confirmation', 'RESTORE')
        ->call('restore')
        ->assertDispatched('user::restored');

    assertNotSoftDeleted('users', [
        'id' => $forRestoration->id,
    ]);

    $forRestoration->refresh();

    expect($forRestoration)
        ->restored_at->not->toBeNull()
        ->restoredBy->id->toBe($user->id);

    expect($forRestoration)->deletedBy->id->toBe(null);
});

it('should have a confirmation before restoration', function () {
    $user           = User::factory()->admin()->create();
    $forRestoration = User::factory()->deleted()->create();

    actingAs($user);
    Livewire::test(Admin\Users\Restore::class)
        ->set('user', $forRestoration)
        ->call('restore')
        ->assertHasErrors(['confirm' => 'confirmed'])
        ->assertNotDispatched('user::restored');

    assertSoftDeleted('users', ['id' => $forRestoration->id]);
});

it('should send a notification to the user telling him that he has again access to the application', function () {
    Notification::fake();
    $user = User::factory()->admin()->create();

    $forDeletion = User::factory()->create();

    actingAs($user);
    Livewire::test(Admin\Users\Restore::class)
        ->set('user', $forDeletion)
        ->set('confirm_confirmation', 'RESTORE')
        ->call('restore');

    Notification::assertSentTo($forDeletion, UserRestoredAccessNotification::class);
});
