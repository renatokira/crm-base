<?php

use App\Livewire\Auth\Register;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas};

it('should render the component', function () {
    Livewire::test(Register::class)
        ->assertStatus(200);
});

it('should be able to register new user in the system', function () {

    Livewire::test(Register::class)
        ->set('name', 'Joe Doe')
        ->set('email', 'joe@doe.com')
        ->set('email_confirmation', 'joe@doe.com')
        ->set('password', 'secret')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    assertDatabaseHas('users', [
        'name'  => 'Joe Doe',
        'email' => 'joe@doe.com',
    ]);

    assertDatabaseCount('users', 1);

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user()->id)
        ->toBe(User::first()->id);
});

test('required fields', function ($field) {

    if ($field->rule === 'unique') {
        User::factory()->create([$field->field => $field->value]);
    }

    $component = Livewire::test(Register::class)
        ->set($field->field, $field->value);

    if (property_exists($field, 'additional_field')) {
        $component->set($field->additional_field, $field->additional_value);
    }

    $component->call('submit')
        ->assertHasErrors([$field->field => $field->rule]);
})->with([

    'name::required'   => (object)['field' => 'name', 'value' => '', 'rule' => 'required'],
    'name::max:255'    => (object)['field' => 'name', 'value' => str_repeat('*', 256), 'rule' => 'max'],
    'email::required'  => (object)['field' => 'email', 'value' => '', 'rule' => 'required'],
    'email::email'     => (object)['field' => 'email', 'value' => 'not-an-email', 'rule' => 'email'],
    'email::max:255'   => (object)['field' => 'email', 'value' => str_repeat('*' . '@doe.com', 256), 'rule' => 'max'],
    'email::confirmed' => (object)['field' => 'email', 'value' => 'joe@doe.com', 'rule' => 'confirmed'],
    'email::unique'    => (object)[
        'field'            => 'email',
        'value'            => 'joe@doe.com',
        'rule'             => 'unique',
        'additional_field' => 'email_confirmation',
        'additional_value' => 'joe@doe.com',
    ],
    'password::required' => (object)['field' => 'password', 'value' => '', 'rule' => 'required'],

]);

it('should send a notification welcoming a new user', function () {

    Notification::fake();

    Livewire::test(Register::class)
        ->set('name', 'Joe Doe')
        ->set('email', 'joe@doe.com')
        ->set('email_confirmation', 'joe@doe.com')
        ->set('password', 'secret')
        ->call('submit');

    $user = User::whereEmail('joe@doe.com')->first();

    Notification::assertSentTo($user, WelcomeNotification::class);
});
