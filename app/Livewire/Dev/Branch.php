<?php

namespace App\Livewire\Dev;

use Illuminate\Support\Facades\Process;
use Livewire\Component;

class Branch extends Component
{
    public function render(): string
    {
        return <<<'BLADE'
                <x-badge :value="$this->branch()"  />
               BLADE;
    }

    public function branch()
    {
        $result = Process::run('git branch --show-current');

        return $result->output();
    }
}
