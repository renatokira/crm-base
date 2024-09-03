<div>
    <x-header title="Users" separator />

    <div class="flex mb-5 space-x-4 place-items-center">
        <div class="w-1/3">
            <x-input label="Search by email and name" placeholder="Search by email and name" icon="o-magnifying-glass"
                wire:model.live.debounce.300ms="search" />
        </div>

        <div class="min-w-52">
            <x-choices label="Serch by permissions" placeholder="Permissions" wire:model.live="search_permissions"
                :options="$permissionsToSearch" search-function="searchPermissions" searchable option-label="key"
                no-result-text="Nothing here" />

        </div>


        <x-checkbox label="Show deleted users" wire:model.live="search_trashed" right tight />

        <x-select label="Records per page" :options="$this->listPerPages" wire:model.live="perPage" />



    </div>

    <x-table :headers="$this->headers" :rows="$this->users">

        @scope('header_id', $header)
            <x-table.th-label name="id" :$header class="select-none" />
        @endscope

        @scope('header_name', $header)
            <x-table.th-label name="name" :$header class="select-none" />
        @endscope

        @scope('header_email', $header)
            <x-table.th-label name="email" :$header class="select-none" />
        @endscope


        @scope('cell_permissions', $user)
            @if ($user->permissions->count())
                @foreach ($user->permissions as $permission)
                    <x-badge :value="$permission->key" class="badge-sm badge-primary" />
                @endforeach
            @else
                <x-badge value="None" class="badge-sm badge-badge-ghost" />
            @endif
        @endscope


        @scope('actions', $user)
            @unless ($user->trashed())
                @unless ($user->is(auth()->user()))
                    <x-button icon="o-trash" id="destroy-{{ $user->id }}" wire:click="destroy('{{ $user->id }}')" spinner
                        class="btn-ghost btn-sm" wire:key="destroy-{{ $user->id }}" />
                @endunless
            @else
                <x-button title="Restore" icon="o-arrow-uturn-left"  wire:key="restore-{{ $user->id }}" wire:click="restore('{{ $user->id }}')" spinner
                    class="btn-ghost btn-sm" />
            @endunless
        @endscope

    </x-table>

    <div class="mt-7">
        {{ $this->users->links(data: ['scrollTo' => false]) }}
    </div>

    <livewire:admin.users.delete />

    <livewire:admin.users.restore />
</div>
