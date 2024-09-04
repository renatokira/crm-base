<?php

use App\Livewire\Matrices;
use App\Models\{Matrix, User};
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to access the route of matrices with any authenticated user', function () {
    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user)->get(route('matrices.index'))->assertOk();
});

it('livewire component to list  paginated matrices in the page', function () {

    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user);

    Matrix::factory()->count(20)->create();

    $livewire = Livewire::test(Matrices\Index::class);

    $livewire->assertSet('matrices', function ($matrices) {
        expect($matrices)
            ->toBeInstanceOf(\Illuminate\Pagination\Paginator::class)
            ->toHaveCount(15);

        return true;
    });
});

test('checking a matices table format', function () {

    actingAs(User::factory()->admin()->create());

    Livewire::test(Matrices\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Matriz', 'class' => 'w-64'],
            ['key' => 'threshold', 'label' => 'Threshold', 'class' => 'w-20'],
            ['key' => 'bandwidth', 'label' => 'Bandwidth', 'class' => 'w-20'],
        ]);
});

it('should be able to filter by name', function () {
    /** @var User $user */
    $user = User::factory()->create();

    Matrix::factory()->create([
        'name' => 'MATRIZ-FLA-JZN',
    ]);

    Matrix::factory()->create([
        'name' => 'MATRIZ-KIRA',
    ]);

    actingAs($user);

    Livewire::test(Matrices\Index::class)
        ->assertSet('matrices', function ($matrices) {
            expect($matrices)
                ->toHaveCount(2);

            return true;
        })
        ->set('search', 'Fla')
        ->assertSet('matrices', function ($matrices) {
            expect($matrices)
                ->toHaveCount(1)
                ->first()->name->toBe('MATRIZ-FLA-JZN');

            return true;
        })
        ->set('search', 'kira')
        ->assertSet('matrices', function ($matrices) {
            expect($matrices)
                ->toHaveCount(1)
                ->first()->name->toBe('MATRIZ-KIRA');

            return true;
        });
});
