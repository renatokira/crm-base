<?php

use App\Livewire\Dev;
use Illuminate\Support\Facades\Process;
use Livewire\Livewire;

it('should be able show the current branch in the page', function () {
    Process::fake([
        'git branch --show-current' => 'feature/dmt-4',
    ]);

    Livewire::test(Dev\Branch::class)
        ->assertSee('feature/dmt-4');

    Process::assertRan('git branch --show-current');
});
