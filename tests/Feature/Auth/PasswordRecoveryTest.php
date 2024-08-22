<?php

use App\Livewire\Auth\Password\Recovery;
use App\Models\User;
use App\Notifications\PasswordRecoveryNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\get;

it('needs to have password recovery route', function () {

    get(route('auth.password.recovery'))
        ->assertOk();
});

it('should be able to request for password recovery sending notification email to user', function () {

    Notification::fake();

    $user    = User::factory()->create();
    $message = 'We will send you an email with a link to reset your password.';

    Livewire::test(Recovery::class)
        ->assertDontSee($message)
        ->set('email', $user->email)
        ->call('startRecoveryPassword')
        ->assertSee($message);

    Notification::assertSentTo($user, PasswordRecoveryNotification::class);
});
