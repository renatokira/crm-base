<?php

use App\Livewire\Auth\Password\Recovery;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas, get};

it('needs to have a route password recovery', function () {
    get(route('password.recovery'))
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

    Notification::assertSentTo($user, ResetPassword::class);
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

it('needs to create a token when requesting for password recovery', function () {

    $user = User::factory()->create();
    Livewire::test(Recovery::class)
        ->set('email', $user->email)
        ->call('startPasswordRecovery');

    assertDatabaseCount('password_reset_tokens', 1);
    assertDatabaseHas('password_reset_tokens', [
        'email' => $user->email,

    ]);
});
