<?php

namespace App\Livewire\Admin\Matrices;

use App\Enum\CanEnum;
use App\Models\Matrix;
use Livewire\Attributes\{On};
use Livewire\Component;

class Update extends Component
{
    public Form $form;

    public bool $matrixDrawer = false;

    public function mount()
    {
        $this->authorize(CanEnum::BE_AN_ADMIN->value);
    }

    public function render()
    {
        return view('livewire.admin.matrices.update', [
            'units' => [
                ['id' => 'MB', 'name' => 'MB'],
                ['id' => 'GB', 'name' => 'GB'],
                ['id' => 'TB', 'name' => 'TB'],
            ],
        ]);
    }

    public function save()
    {
        $this->form->update();

        $this->dispatch('matrices::reload')->to('admin.matrices.index');
        $this->matrixDrawer = false;
    }

    #[On('matrix::update')]
    public function load(int $id)
    {
        $matrix = Matrix::find($id);
        $this->form->setMatrix($matrix);

        $this->form->resetErrorBag();
        $this->matrixDrawer = true;
    }
}
