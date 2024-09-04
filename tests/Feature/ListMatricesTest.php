<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

it('should be able to access the route of matrices with any authenticated user', function () {
    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user)->get(route('matrices.index'))->assertOk();
});
