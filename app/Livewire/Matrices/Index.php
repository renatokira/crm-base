<?php

namespace App\Livewire\Matrices;

use App\Models\Matrice;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;

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
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Matriz', 'class' => 'w-64'],
            ['key' => 'total', 'label' => 'Total', 'class' => 'w-20'],
        ];
    }

    #[Computed]
    public function users(): Collection
    {

        return Matrice::query()
            ->get()->map(fn (Matrice $matrix) => [
                'id'    => $matrix->id,
                'name'  => $matrix->name,
                'total' => $matrix->count(),
            ]);
        // return collect([
        //     ['id' => 1, 'name' => 'Matriz 1', 'total' => 23],
        //     ['id' => 2, 'name' => 'Matriz 2', 'total' => 7],
        //     ['id' => 3, 'name' => 'Matriz 3', 'total' => 5],
        // ])
        //     ->sortBy([[...array_values($this->sortBy)]])
        //     ->when($this->search, function (Collection $collection) {
        //         return $collection->filter(fn (array $item) => str($item['name'])->contains($this->search, true));
        //     });
    }

    public function render()
    {
        return view('livewire.matrices.index', [
            'users'   => $this->users(),
            'headers' => $this->headers(),
        ]);
    }
}
