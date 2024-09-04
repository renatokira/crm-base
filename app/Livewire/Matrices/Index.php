<?php

namespace App\Livewire\Matrices;

use App\Models\Matrice;
use Livewire\Attributes\Computed;
use Livewire\{Component, WithPagination, WithoutUrlPagination};
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;
    use WithPagination;
    use WithoutUrlPagination;

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Delete action
    public function delete($id): void
    {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    // Table headers
    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Matriz', 'class' => 'w-64'],
            ['key' => 'threshold', 'label' => 'Threshold', 'class' => 'w-20'],
            ['key' => 'bandwidth', 'label' => 'Bandwidth', 'class' => 'w-20'],
        ];
    }

    #[Computed]
    public function users(): \Illuminate\Pagination\Paginator
    {
        return Matrice::query()->simplePaginate();
    }

    public function render()
    {

        return view('livewire.matrices.index');
    }
}
