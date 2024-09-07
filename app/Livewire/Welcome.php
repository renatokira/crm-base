<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\{Component, WithPagination};

class Welcome extends Component
{
    use WithPagination;

    public ?string $search = null;

    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    #[Computed]
    public function items()
    {
        return \App\Models\Matrix::query()
            ->search($this->search, ['name', 'bandwidth'])
            ->simplePaginate(12);
    }

    public function render()
    {
        return view('livewire.welcome');
    }
}
