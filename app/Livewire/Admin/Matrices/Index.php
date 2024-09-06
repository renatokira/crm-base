<?php

namespace App\Livewire\Admin\Matrices;

use App\Enum\CanEnum;
use App\Models\Matrix;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\{Computed};
use Livewire\{Component, WithPagination, WithoutUrlPagination};
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;
    use WithPagination;
    use WithoutUrlPagination;

    public ?string $search = null;

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public int $perPage = 15;

    public function mount()
    {

        $this->authorize(CanEnum::BE_AN_ADMIN->value);
    }

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

    public function showMatrix($id): void
    {

        $this->dispatch('matrix::show', id: $id)->to('admin.matrices.show');
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

    // Reset pagination when any component property changes
    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    #[Computed]
    public function matrices(): \Illuminate\Pagination\Paginator
    {
        return Matrix::query()
            ->when($this->search, fn (Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->simplePaginate();
    }

    public function render()
    {

        return view('livewire.admin.matrices.index');
    }
}
