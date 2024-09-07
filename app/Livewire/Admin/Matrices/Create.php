<?php

namespace App\Livewire\Admin\Matrices;

use App\Enum\CanEnum;
use App\Models\Matrix;
use Livewire\Attributes\Rule;
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

    #[Rule(['required', 'string', 'max:255'])]
    public string $description = '';

    public function mount()
    {

        $this->authorize(CanEnum::BE_AN_ADMIN->value);
    }

    public function render()
    {
        return view('livewire.admin.matrices.create');
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

        $this->reset('name');
        $this->redirect(route('admin.matrices.index'));
    }
}
