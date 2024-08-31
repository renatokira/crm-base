<?php

namespace App\Livewire\Admin\Users;

use App\Enum\CanEnum;
use App\Models\{Permission, User};
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\{Component, WithPagination, WithoutUrlPagination};

class Index extends Component
{
    use WithPagination;
    use WithoutUrlPagination;

    public ?string $search = null;

    public bool $search_trashed = false;

    public array $search_permissions = [];

    public Collection $permissionsToSearchable;

    public function mount()
    {
        $this->authorize(CanEnum::BE_AN_ADMIN->value);
        $this->searchPermissions();
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
            ->paginate();
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

    public function searchPermissions(?string $value = '')
    {
        $this->permissionsToSearchable = Permission::query()
            ->when(
                $value,
                fn (Builder $q) => $q->where('key', 'like', '%' . $value . '%')
            )
            ->orderBy('key')
            ->get();
    }

    #[Computed]
    public function permissions(): array
    {
        return Permission::all()
            ->map(fn ($permission) => [
                'id'   => $permission->id,
                'name' => $permission->key,
            ])->toArray();
    }
}
