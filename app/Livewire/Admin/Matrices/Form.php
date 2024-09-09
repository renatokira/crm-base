<?php

namespace App\Livewire\Admin\Matrices;

use App\Models\Matrix;
use Illuminate\Validation\Rule;
use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    public ?Matrix $matrix = null;

    public string $name = '';

    public ?int $threshold = null;

    public ?int $bandwidth = null;

    public string $bandwidth_unit = '';

    public string $description = '';

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'min:3', 'max:255',  Rule::unique('matrices')->ignore($this->matrix?->id)],
            'threshold'      => ['required', 'numeric', 'min:1'],
            'bandwidth'      => ['required', 'numeric', 'min:1'],
            'bandwidth_unit' => ['required', 'string', 'in:MB,GB,TB'],
            'description'    => ['required', 'string', 'min:3', 'max:255'],
        ];
    }

    public function setMatrix(Matrix $matrix): void
    {

        $this->matrix         = $matrix;
        $this->name           = $matrix->name;
        $this->threshold      = $matrix->threshold;
        $this->bandwidth      = $matrix->bandwidth;
        $this->bandwidth_unit = $matrix->bandwidth_unit;
        $this->description    = $matrix->description;
    }

    public function create(): void
    {
        $this->validate();

        Matrix::create([
            'name'           => $this->name,
            'threshold'      => $this->threshold,
            'bandwidth'      => $this->bandwidth,
            'bandwidth_unit' => $this->bandwidth_unit,
            'description'    => $this->description,
        ]);

        $this->reset();
    }

    public function update(): void
    {
        $this->validate();

        $this->matrix->name           = $this->name;
        $this->matrix->threshold      = $this->threshold;
        $this->matrix->bandwidth      = $this->bandwidth;
        $this->matrix->bandwidth_unit = $this->bandwidth_unit;
        $this->matrix->description    = $this->description;

        $this->matrix->update();
    }
}
