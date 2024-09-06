<?php

namespace App\Livewire;

use Livewire\{Component, WithPagination};

class Welcome extends Component
{
    use WithPagination;

    public ?string $search = null;

    public function render()
    {
        return view('livewire.welcome', [
            'matrices' => \App\Models\Matrix::query()
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', "%$this->search%");
                })
                ->simplePaginate(10),
        ]);
    }
}
