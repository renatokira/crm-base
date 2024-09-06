<?php

use App\Livewire\Welcome;
use Livewire\Livewire;

it('should render welcome component', function () {

    Livewire::test(Welcome::class)
        ->assertOk()
        ->assertViewIs('livewire.welcome');
});
