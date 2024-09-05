<div>
    <!-- HEADER -->
    <x-header title="Matrizes" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$this->headers" :rows="$this->matrices" :sort-by="$sortBy">

            @scope('cell_bandwidth', $user)
                {{ $user['bandwidth'] . '' . $user['bandwidth_unit'] }}
            @endscope

            @scope('actions', $user)
                <x-button icon="o-eye" wire:key="show-btn-{{ $user->id }}" id="show-btn-{{ $user->id }}"
                    wire:click="showMatrix('{{ $user->id }}')" spinner class="btn-ghost btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $user['id'] }})" spinner class="btn-ghost btn-sm" />
            @endscope
        </x-table>

        <div class="mt-7">
            {{ $this->matrices->links(data: ['scrollTo' => false]) }}
        </div>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass"
            @keydown.enter="$wire.drawer = false" />

        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>

    <livewire:matrices.show />
</div>
