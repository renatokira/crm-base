<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\{Component, WithPagination};

class Welcome extends Component
{
    use WithPagination;

    public ?string $search = null;

    public ?int $bandwidth = null;

    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    #[Computed]
    public function matrices()
    {
        return \App\Models\Matrix::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%$this->search%");
            })
            ->when($this->bandwidth, function ($query) {
                $query->where('bandwidth', 'like', "%$this->bandwidth%");
            })
            ->simplePaginate(10);
    }

    public function render()
    {
        return view('livewire.welcome');
    }
}
