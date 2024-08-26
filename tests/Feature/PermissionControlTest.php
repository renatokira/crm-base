<?php

use App\Models\{Permission, User};
use Database\Seeders\{PermissionSeeder, UserSeeder};
use Illuminate\Support\Facades\{Cache, DB};

use function Pest\Laravel\{actingAs, assertDatabaseHas, seed};

it('should be able to give an user a permission to do something', function () {
    /** @var User $user */
    $user = User::factory()->create();
    $user->givePermissionTo('be an admin');

    expect($user)
        ->hasPermissionTo('be an admin')
        ->toBeTrue();

    assertDatabaseHas('permissions', [
        'key' => 'be an admin',
    ]);

    assertDatabaseHas('permission_user', [
        'user_id'       => $user->id,
        'permission_id' => Permission::where(['key' => 'be an admin'])->first()->id,
    ]);
});

test('permission must have a seeder', function () {

    seed(PermissionSeeder::class);

    assertDatabaseHas('permissions', [
        'key' => 'be an admin',
    ]);
});

test('seeder with an admin user', function () {

    seed([UserSeeder::class]);

    assertDatabaseHas('permissions', [
        'key' => 'be an admin',
    ]);

    assertDatabaseHas('permission_user', [
        'user_id'       => User::first()?->id,
        'permission_id' => Permission::where(['key' => 'be an admin'])->first()?->id,
    ]);
});

it('should block the access to an admin page if the user does not have the permission to be an admin', function () {
    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user)->get(route('admin.dashboard'))
        ->assertForbidden();
});

test("let's make sure that we are using cache to store permissions", function () {

    /** @var User $user */
    $user = User::factory()->create();
    $user->givePermissionTo('be an admin');

    $cacheKey = "user::{$user->id}::permissions";

    expect(Cache::has($cacheKey))->toBeTrue('checking if cache exists')
        ->and(Cache::get($cacheKey))->toBe($user->permissions);
});

test("let's make sure that we are using the cache the retrieve/check when the user has the given permission", function () {

    $user = User::factory()->create();

    $user->givePermissionTo('be an admin');

    DB::listen(function ($query) {
        throw new Exception('we got a query');
    });
    $user->hasPermissionTo('be an admin');

    expect(true)->toBeTrue();
});
