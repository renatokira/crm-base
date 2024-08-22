<?php

use App\Livewire\Auth\Password\Recovery;
use App\Models\User;
use App\Notifications\PasswordRecoveryNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\get;

it('needs to have a route password recovery', function () {
    get(route('auth.password.recovery'))
        ->assertSeeLivewire('auth.password.recovery');
});

it('should be able to request for password recovery sending notification email to user', function () {

    Notification::fake();

    $user    = User::factory()->create();
    $message = 'We will send you an email with a link to reset your password.';

    Livewire::test(Recovery::class)
        ->assertDontSee($message)
        ->set('email', $user->email)
        ->call('startPasswordRecovery')
        ->assertSee($message);

    Notification::assertSentTo($user, PasswordRecoveryNotification::class);
});

it('testing email property validation', function ($value, $rule) {

    Livewire::test(Recovery::class)
        ->set('email', $value)
        ->call('startPasswordRecovery')
        ->assertHasErrors(['email' => $rule]);
})->with([
    'required' => ['email' => '', 'rule' => 'required'],
    'email'    => ['email' => 'not-an-email', 'rule' => 'email'],
]);
