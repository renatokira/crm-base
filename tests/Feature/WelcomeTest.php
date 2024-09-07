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
        ->assertSet('matrices', function ($matrices) {
            expect($matrices)
                ->toBeInstanceOf(\Illuminate\Pagination\Paginator::class)
                ->toHaveCount(12);

            return true;
        });
});

it('should be able filter matrices by name', function () {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    Matrix::factory()->count(15)->create();
    Matrix::factory()->create([
        'name' => 'FLA-JZN',
    ]);

    Livewire::test(Welcome::class)
        ->set('search', 'FLA-JZN')
        ->assertSet('matrices', function ($matrices) {
            expect($matrices)
                ->toHaveCount(1)
                ->first()->name->toBe('FLA-JZN');

            return true;
        });
});

// filter bandwidth

it('should be able filter matrices by bandwidth', function () {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    Matrix::factory()->count(15)->create([
        'bandwidth' => random_int(100, 300),
    ]);
    Matrix::factory()->count(2)->create([
        'bandwidth' => 600,
    ]);

    Livewire::test(Welcome::class)
        ->set('bandwidth', 600)
        ->assertSet('matrices', function ($matrices) {
            expect($matrices)
                ->toHaveCount(2)
                ->first()->bandwidth->toBe(600);

            return true;
        });
});
