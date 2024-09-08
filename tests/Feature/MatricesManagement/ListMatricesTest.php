<?php

use App\Livewire\Admin\Matrices;
use App\Models\{Matrix, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs};

it('should be able to access the route of matrices', function () {

    $user = User::factory()->admin()->create();
    actingAs($user)->get(route('admin.matrices.index'))->assertOk();
});

it('livewire component to list  paginated matrices in the page', function () {

    /** @var User $user */
    $user = User::factory()->admin()->create();

    actingAs($user);

    Matrix::factory()->count(20)->create();

    $livewire = Livewire::test(Matrices\Index::class);

    $livewire->assertSet('items', function ($items) {
        expect($items)
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
            ['key' => 'name', 'label' => 'Matrix', 'class' => 'w-64'],
            ['key' => 'threshold', 'label' => 'Threshold', 'class' => 'w-20'],
            ['key' => 'bandwidth', 'label' => 'Bandwidth', 'class' => 'w-20'],
        ]);
});

it('should be able to filter by name and bandwidth', function () {
    /** @var User $user */
    $user = User::factory()->admin()->create();

    Matrix::factory()->create([
        'name'      => 'FLA-JZN',
        'bandwidth' => 100,
    ]);

    Matrix::factory()->create([
        'name'      => 'RNT-KIRA',
        'bandwidth' => 700,
    ]);

    actingAs($user);

    Livewire::test(Matrices\Index::class)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(2);

            return true;
        })
        ->set('search', 'fla')
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->name->toBe('FLA-JZN');

            return true;
        })
        ->set('search', 700)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->name->toBe('RNT-KIRA');

            return true;
        });
});

it('should open the modal when event is dispatched', function () {

    $matrix = Matrix::factory()->create();
    $user   = User::factory()->admin()->create();
    actingAs($user);

    Livewire::test(Matrices\Index::class)
        ->call('showMatrix', $matrix->id)
        ->assertDispatched('matrix::show', id: $matrix->id);
});

it('should be able to show all details of a matrix in the component', function () {

    $matrix = Matrix::factory()->create();

    Livewire::test(Matrices\Show::class)
        ->call('loadMatrix', $matrix->id)
        ->assertSet('matrix.id', $matrix->id)
        ->assertSet('modal', true)
        ->assertSee($matrix->name)
        ->assertSee($matrix->threshold)
        ->assertSee($matrix->bandwidth . '' . $matrix->bandwidth_unit)
        ->assertSee($matrix->created_at->format('d/m/Y H:i'));
});

test('check if components are in the page', function () {

    $matrix = Matrix::factory()->create();
    $user   = User::factory()->admin()->create();
    actingAs($user);

    Livewire::test(Matrices\Index::class)
        ->assertContainsLivewireComponent('admin.matrices.show')
        ->assertContainsLivewireComponent('admin.matrices.create');
});
