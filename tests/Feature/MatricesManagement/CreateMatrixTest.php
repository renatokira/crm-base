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
        ->set('form.name', 'FLA-JZN')
        ->assertPropertyWired('form.name')
        ->set('form.threshold', 100)
        ->assertPropertyWired('form.threshold')
        ->set('form.bandwidth', 300)
        ->assertPropertyWired('form.bandwidth')
        ->set('form.bandwidth_unit', 'GB')
        ->assertPropertyWired('form.bandwidth_unit')
        ->set('form.description', 'Some description')
        ->assertPropertyWired('form.description')
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
        ->assertPropertyEntangled('matrixCreateDrawer');
});

describe('validations', function () {
    test('name', function ($rule, $value) {

        Matrix::factory()->create(['name' => 'FLA-JZN']);

        Livewire::test(Matrices\Create::class)
            ->set('form.name', $value)
            ->call('save')
            ->assertHasErrors(['form.name' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'JZ'],
        'max'      => ['max', str_repeat('a', 256)],
        'unique'   => ['unique', 'FLA-JZN'],
    ]);

    test('threshold', function ($rule, $value) {
        Livewire::test(Matrices\Create::class)
            ->set('form.threshold', $value)
            ->call('save')
            ->assertHasErrors(['form.threshold' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 0],
    ]);

    test('bandwidth', function ($rule, $value) {
        Livewire::test(Matrices\Create::class)
            ->set('form.bandwidth', $value)
            ->call('save')
            ->assertHasErrors(['form.bandwidth' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 0],
    ]);

    test('bandwidth_unit', function ($rule, $value) {
        Livewire::test(Matrices\Create::class)
            ->set('form.bandwidth_unit', $value)
            ->call('save')
            ->assertHasErrors(['form.bandwidth_unit' => $rule]);
    })->with([
        'required' => ['required', ''],
        'in'       => ['in', 'KB'],
    ]);

    test('description', function ($rule, $value) {
        Livewire::test(Matrices\Create::class)
            ->set('form.description', $value)
            ->call('save')
            ->assertHasErrors(['form.description' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'hi'],
        'max'      => ['max', str_repeat('a', 256)],
    ]);
});

test('check if components are in the page', function () {

    $user = User::factory()->admin()->create();
    actingAs($user);

    Livewire::test(Matrices\Index::class)
        ->assertContainsLivewireComponent('admin.matrices.create');
});
