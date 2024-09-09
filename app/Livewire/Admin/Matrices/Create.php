<?php

namespace App\Livewire\Admin\Matrices;

use App\Enum\CanEnum;
use Livewire\Attributes\{On};
use Livewire\Component;

class Create extends Component
{
    public Form $form;

    public bool $matrixCreateDrawer = false;

    public function mount()
    {
        $this->authorize(CanEnum::BE_AN_ADMIN->value);
    }

    public function render()
    {
        return view('livewire.admin.matrices.create', [
            'units' => [
                ['id' => 'MB', 'name' => 'MB'],
                ['id' => 'GB', 'name' => 'GB'],
                ['id' => 'TB', 'name' => 'TB'],
            ],
        ]);
    }

    public function save()
    {
        $this->form->create();

        $this->matrixCreateDrawer = false;
        $this->dispatch('matrices::reload')->to('admin.matrices.index');
    }

    #[On('matrix::create')]
    public function open(): void
    {
        $this->form->resetErrorBag();
        $this->matrixCreateDrawer = true;
    }
}
