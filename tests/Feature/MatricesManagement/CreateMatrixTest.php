<?php

use App\Livewire\Admin\Matrices;
use App\Models\{Matrix, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

beforeEach(function () {
    /** @var User $user */
    $user = User::factory()->admin()->create();
    actingAs($user);
});

it('should be able admin create a new matrix', function () {

    Livewire::test(Matrices\Create::class)
        ->set('name', 'FLA-JZN')
        ->set('threshold', 100)
        ->set('bandwidth', 300)
        ->set('bandwidth_unit', 'GB')
        ->set('description', 'Some description')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('matrices', [
        'name'           => 'FLA-JZN',
        'threshold'      => 100,
        'bandwidth'      => 300,
        'bandwidth_unit' => 'GB',
        'description'    => 'Some description',
    ]);
});

it('make sure that method saved is wired in form', function () {

    /** @var User $user */
    $user = User::factory()->admin()->create();
    actingAs($user);

    Livewire::test(Matrices\Create::class)
        ->assertMethodWiredToForm('save');
});

it('should be able to wired modal property', function () {

    /** @var User $user */
    $user = User::factory()->admin()->create();
    actingAs($user);

    Livewire::test(Matrices\Create::class)
        ->assertPropertyEntangled('matrixDrawer');
});

describe('validations', function () {
    test('name', function ($rule, $value) {

        Matrix::factory()->create(['name' => 'FLA-JZN']);

        Livewire::test(Matrices\Create::class)
            ->set('name', $value)
            ->call('save')
            ->assertHasErrors(['name' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'JZ'],
        'max'      => ['max', str_repeat('a', 256)],
        'unique'   => ['unique', 'FLA-JZN'],
    ]);

    test('threshold', function ($rule, $value) {
        Livewire::test(Matrices\Create::class)
            ->set('threshold', $value)
            ->call('save')
            ->assertHasErrors(['threshold' => $rule]);
    })->with([
        'required' => ['required', ''],
        'numeric'  => ['numeric', 'a'],
        'min'      => ['min', 0],
    ]);

    test('bandwidth', function ($rule, $value) {
        Livewire::test(Matrices\Create::class)
            ->set('bandwidth', $value)
            ->call('save')
            ->assertHasErrors(['bandwidth' => $rule]);
    })->with([
        'required' => ['required', ''],
        'numeric'  => ['numeric', 'a'],
        'min'      => ['min', 0],
    ]);

    test('bandwidth_unit', function ($rule, $value) {
        Livewire::test(Matrices\Create::class)
            ->set('bandwidth_unit', $value)
            ->call('save')
            ->assertHasErrors(['bandwidth_unit' => $rule]);
    })->with([
        'required' => ['required', ''],
        'in'       => ['in', 'KB'],
    ]);

    test('description', function ($rule, $value) {
        Livewire::test(Matrices\Create::class)
            ->set('description', $value)
            ->call('save')
            ->assertHasErrors(['description' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'hi'],
        'max'      => ['max', str_repeat('a', 256)],
    ]);
});
