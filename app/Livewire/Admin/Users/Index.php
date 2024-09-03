<?php

namespace App\Livewire\Admin\Users;

use App\Enum\CanEnum;
use App\Models\{Permission, User};
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

    public ?string $search = null;

    public bool $search_trashed = false;

    public array $search_permissions = [];

    public Collection $permissionsToSearch;

    public string $sortDirection = 'asc';

    public string $sortColumnBy = 'id';

    public int $perPage = 15;

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
            ->orderBy($this->sortColumnBy, $this->sortDirection)
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
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'name', 'label' => 'Name', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'email', 'label' => 'Email', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'permissions', 'label' => 'Permissions', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
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

    public function sortBy(string $column, string $direction): void
    {
        $this->sortColumnBy  = $column;
        $this->sortDirection = $direction;
    }

    public function destroy(int $userId): void
    {
        $this->dispatch('user::deletion', userId: $userId)->to('admin.users.delete');
    }

    public function restore(int $userId): void
    {
        $this->dispatch('user::restoring', userId: $userId)->to('admin.users.restore');
    }
}
