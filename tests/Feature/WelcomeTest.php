<?php

use App\Livewire\Welcome;
use App\Models\{Matrix, User};
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should render welcome component', function () {

    Livewire::test(Welcome::class)
        ->assertOk()
        ->assertViewIs('livewire.welcome');
});

it('should be able list all matrices in the page welcome paginated', function () {

    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    Matrix::factory()->count(15)->create();

    Livewire::test(Welcome::class)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toBeInstanceOf(\Illuminate\Pagination\Paginator::class)
                ->toHaveCount(12);

            return true;
        });
});

it('should be able filter matrices by name', function () {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    Matrix::factory()->create([
        'name'      => 'FLA-JZP',
        'bandwidth' => 300,
    ]);

    Matrix::factory()->create([
        'name'      => 'FLA-JZN',
        'bandwidth' => 700,
    ]);

    Livewire::test(Welcome::class)
        ->set('search', 'FLA-JZP')
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->name->toBe('FLA-JZP');

            return true;
        })
        ->set('search', 700)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->bandwidth->toBe(700);

            return true;
        });
});
