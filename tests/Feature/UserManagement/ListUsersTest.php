<?php

use App\Enum\CanEnum;
use App\Livewire\Admin;
use App\Models\{Permission, User};
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

    $livewire->assertSet('items', function ($items) {
        expect($items)
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
            ['key' => 'name', 'label' => 'Name', ],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'permissions_name', 'label' => 'Permissions'],
        ]);
});

it('should be able to filter by name or email', function () {
    $admin = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'jd@jd.com']);
    User::factory()->create(['name' => 'Kira', 'email' => 'rntok@k.com']);

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(2);

            return true;
        })->set('search', 'kira')
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->name->toBe('Kira');

            return true;
        })
        ->set('search', 'rntok')
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->name->toBe('Kira');

            return true;
        });
});

it('should be able to filter by permission key', function () {
    $admin = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'jd@jd.com']);
    User::factory()->withPermission(CanEnum::BE_AN_USER)
        ->create(['name' => 'No Admin', 'email' => 'noadmin@noadm.com']);

    $permissionAnAdmin = Permission::where('key', CanEnum::BE_AN_ADMIN->value)->first();
    $permissionAnUser  = Permission::where('key', CanEnum::BE_AN_USER->value)->first();

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(2);

            return true;
        })->set('search_permissions', [$permissionAnAdmin->id, $permissionAnUser->id])
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(2)
                ->first()->name->toBe('Joe Doe');

            return true;
        });
});

it('should be list deleted users', function () {
    $admin = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@admin.com']);
    User::factory()->count(2)->deleted($admin)->create();

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1);

            return true;
        })
        ->set('search_trashed', true)
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(2);

            return true;
        });
});

it('should be able to sort by name', function () {
    $admin = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'jd@jd.com']);
    User::factory()->withPermission(CanEnum::BE_AN_USER)
        ->create(['name' => 'No Admin', 'email' => 'noadmin@noadm.com']);

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->set('sortBy', ['column' => 'name', 'direction' => 'desc'])
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->name->toBe('No Admin')
                ->and($items)
                ->last()->name->toBe('Joe Doe');

            return true;
        });

    Livewire::test(Admin\Users\Index::class)
        ->set('sortBy', ['column' => 'name', 'direction' => 'asc'])
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->name->toBe('Joe Doe')
                ->and($items)
                ->last()->name->toBe('No Admin');

            return true;
        });
});

it('should be able paginate the result', function () {

    $admin = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'jd@jd.com']);
    User::factory()->count(30)->create();

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('items', function (LengthAwarePaginator $items) {
            expect($items)->toHaveCount(15);

            return true;
        })->set('perPage', 20)
        ->assertSet('items', function (LengthAwarePaginator $items) {
            expect($items)->toHaveCount(20);

            return true;
        });
});
