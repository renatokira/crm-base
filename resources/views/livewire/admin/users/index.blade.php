<div>

    <x-header title="Users" separator />

    <div class="flex mb-5 space-x-4">
        <div class="w-1/3">
            <x-input label="Search by email and name" placeholder="Search by email and name" icon="o-magnifying-glass"
                wire:model.live.debounce.300ms="search" />
        </div>

        <div class="w-1/6">
            <x-choices label="Serch by permissions" placeholder="Permissions" wire:model.live="search_permissions" :options="$permissionsToSearchable"
                search-function="searchPermissions" searchable option-label="key" no-result-text="Nothing here" />

        </div>

    </div>

    {{-- You can use any `$wire.METHOD` on `@row-click` --}}
    <x-table :headers="$this->headers" :rows="$this->users" with-pagination striped>

        @scope('cell_permissions', $user)
            @if ($user->permissions->count())
                @foreach ($user->permissions as $permission)
                    <x-badge :value="$permission->key" class="badge-sm badge-primary" />
                @endforeach
            @else
                <x-badge value="None" class="badge-sm badge-badge-ghost" />
            @endif
        @endscope


        {{-- Special `actions` slot --}}
        @scope('actions', $user)
            <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-ghost btn-sm" />
        @endscope

    </x-table>
</div>
