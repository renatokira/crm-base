<?php

namespace App\Livewire\Matrices;

use App\Models\Matrix;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public ?Matrix $matrix = null;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.matrices.show');
    }

    #[On('matrix::show')]
    public function loadMatrix(int $id): void
    {
        $this->matrix = Matrix::find($id);
        $this->modal  = true;
    }
}
