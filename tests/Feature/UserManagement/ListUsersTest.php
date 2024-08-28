<?php

use App\Livewire\Admin;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to access the route admin/users', function () {
    $user = User::factory()->admin()->create();

    actingAs($user)->get(route('admin.users'))->assertOk();
});

it('making sure that the route is protected by permission BE_AN_ADMIN', function () {

    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user)->get(route('admin.users'))->assertForbidden();
});

test('livewire component to list users in the page', function () {

    actingAs(User::factory()->admin()->create());
    $users = User::factory()->count(10)->create();

    $livewire = Livewire::test(Admin\Users\Index::class);

    $livewire->assertSet('users', function ($users) {
        expect($users)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(11);

        return true;
    });

    foreach ($users as $user) {
        $livewire->assertSee($user->name);
    }
});

test('checking a table format', function () {

    actingAs(User::factory()->admin()->create());

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'permissions', 'label' => 'Permissions'],
        ]);
});

it('should be able to filter by name or email', function () {
    $admin = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'j@j.com']);
    User::factory()->create(['name' => 'Kira', 'email' => 'rntok@k.com']);

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);

            return true;
        })->set('search', 'kira')
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(1)
                ->first()->name->toBe('Kira');

            return true;
        })
        ->set('search', 'rntok')
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(1)
                ->first()->name->toBe('Kira');

            return true;
        });
});
