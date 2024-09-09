<?php

namespace App\Livewire\Admin\Matrices;

use App\Models\Matrix;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public ?Matrix $matrix = null;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.admin.matrices.show');
    }

    #[On('matrix::show')]
    public function load(int $id): void
    {
        $this->matrix = Matrix::find($id);
        $this->modal  = true;
    }
}
