<?php

namespace App\Livewire\Admin\Matrices;

use App\Enum\CanEnum;
use App\Models\Matrix;
use Livewire\Attributes\{Computed, On, Rule};
use Livewire\Component;

class Create extends Component
{
    #[Rule(['required', 'unique:matrices', 'min:3', 'max:255'])]
    public string $name = '';

    #[Rule(['required', 'numeric', 'min:1'])]
    public string $threshold = '';

    #[Rule(['required', 'numeric', 'min:1'])]
    public string $bandwidth = '';

    #[Rule('required')]
    #[Rule('in:MB,GB,TB')]
    public string $bandwidth_unit = '';

    #[Rule(['required', 'string', 'min:3', 'max:255'])]
    public string $description = '';

    public bool $matrixDrawer = false;

    public function mount()
    {

        $this->authorize(CanEnum::BE_AN_ADMIN->value);
    }

    public function render()
    {
        return view('livewire.admin.matrices.create');
    }
    #[On('matrix::create')]
    public function open(): void
    {
        $this->resetErrorBag();
        $this->matrixDrawer = true;
    }

    public function clear(): void
    {
        $this->resetErrorBag();

        $this->reset(array_keys($this->except('matrixDrawer')));
    }
    #[Computed]
    public function units(): array
    {
        return [
            ['id' => 'MB', 'name' => 'MB'],
            ['id' => 'GB', 'name' => 'GB'],
            ['id' => 'TB', 'name' => 'TB'],
        ];
    }

    public function save()
    {

        $this->validate();

        Matrix::create([
            'name'           => $this->name,
            'threshold'      => $this->threshold,
            'bandwidth'      => $this->bandwidth,
            'bandwidth_unit' => $this->bandwidth_unit,
            'description'    => $this->description,
        ]);

        $this->matrixDrawer = false;
        $this->reset();
    }
}
