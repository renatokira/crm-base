<?php

namespace App\Traits\Livewire;

trait HasTable
{
    public ?string $search = null;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public int $perPage = 15;

    abstract public function headers(): array;
}
