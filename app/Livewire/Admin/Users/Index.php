<?php

namespace App\Livewire\Admin\Users;

use App\Enum\CanEnum;
use App\Models\{Permission, User};
use App\Traits\Livewire\HasTable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Computed, On};
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;
    use HasTable;

    public bool $search_trashed = false;

    public array $search_permissions = [];

    public Collection $permissionsToSearch;

    public function mount()
    {
        $this->authorize(CanEnum::BE_AN_ADMIN->value);
        $this->searchPermissions();
    }

    #[On(['user::deleted', 'user::restored'])]
    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    // Reset pagination when any component property changes
    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }
    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::query()
            ->with('permissions')
            ->withAggregate('permissions', 'name')
            ->when(
                $this->search,
                fn (Builder $q) => $q->where(
                    DB::raw('lower(name)'),
                    'like',
                    '%' . strtolower($this->search) . '%'
                )
                    ->orWhere('email', 'like', '%' . strtolower($this->search) . '%')
            )->when(
                $this->search_permissions,
                fn (Builder $q) => $q->whereHas(
                    'permissions',
                    fn (Builder $q) => $q->whereIn('id', $this->search_permissions)
                )
            )
            ->when(
                $this->search_trashed,
                fn (Builder $q) => $q->onlyTrashed()
            )
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    #[Computed]
    public function listPerPages(): array
    {
        return [
            ['id' => 15, 'name' => '15'],
            ['id' => 30, 'name' => '30'],
            ['id' => 50, 'name' => '50'],
        ];
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'permissions_name', 'label' => 'Permissions'],
        ];
    }

    public function searchPermissions(?string $value = '')
    {
        $this->permissionsToSearch = Permission::query()
            ->when(
                $value,
                fn (Builder $q) => $q->where('key', 'like', "%$value%")
            )
            ->orderBy('key')
            ->get();
    }

    public function destroy(int $userId): void
    {
        $this->dispatch('user::deletion', userId: $userId)->to('admin.users.delete');
    }

    public function restore(int $userId): void
    {
        $this->dispatch('user::restoring', userId: $userId)->to('admin.users.restore');
    }

    public function showUser(int $id): void
    {
        $this->dispatch('user::show', id: $id)->to('admin.users.show');
    }
}
