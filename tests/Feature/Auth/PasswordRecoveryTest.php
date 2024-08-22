<?php

use function Pest\Laravel\get;

it('needs to have password recovery', function () {

    get(route('auth.password.recovery'))
        ->assertOk();
})->only();
