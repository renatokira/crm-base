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
        ->assertViewHas('matrices', function ($matrices) {
            expect($matrices)
                ->toBeInstanceOf(\Illuminate\Pagination\Paginator::class)
                ->toHaveCount(10);

            return true;
        });
});
