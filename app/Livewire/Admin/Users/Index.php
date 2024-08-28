<?php

namespace App\Livewire\Admin\Users;

use App\Enum\CanEnum;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\{Component, WithPagination, WithoutUrlPagination};

class Index extends Component
{
    use WithPagination;
    use WithoutUrlPagination;

    public function mount()
    {
        $this->authorize(CanEnum::BE_AN_ADMIN->value);
    }

    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    public function delete(int $id)
    {

    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::query()->with('permissions')->paginate();
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'permissions', 'label' => 'Permissions'],
        ];
    }
}
