<?php

namespace App\Livewire;

use Livewire\{Component, WithPagination};

class Welcome extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.welcome', [
            'matrices' => \App\Models\Matrix::simplePaginate(10),
        ]);
    }
}
