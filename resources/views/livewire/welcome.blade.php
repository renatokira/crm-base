<div>
    <!-- HEADER -->
    <x-header title="Welcome" size="text-3xl" separator progress-indicator>
    </x-header>

    <div class="flex mb-5 space-x-4 place-items-center">

        <div class="w-1/3">
            <x-input placeholder="Search by name" icon="o-magnifying-glass" wire:model.live.debounce.300ms="search" />
        </div>

        <x-input placeholder="Bandwidth" icon="o-presentation-chart-line" wire:model.live.debounce.300ms="bandwidth"
            type="number" />

    </div>

    <div class="grid grid-cols-1 gap-5 mt-5 lg:grid-cols-2 xl:grid-cols-3">

        @forelse ($this->matrices as $matrix)
            <x-card shadow class="flex justify-evenly">
                <x-slot:title>
                    <p class="text-lg">{{ $matrix->name }}</p>
                </x-slot:title>

                <div class="text-sm text-gray-500 ">
                    Bandwidth :{{ $matrix->bandwidth . '' . $matrix->bandwidth_unit }} </br>
                    Threshold :{{ $matrix->threshold }}
                </div>
                <hr class="mt-3" />

                <div class="py-2 truncate">
                    {{ $matrix->description }}
                </div>

                <x-slot:menu>
                    <x-button icon="o-presentation-chart-line" class="btn-circle btn-sm" />
                    <x-button icon="o-information-circle" class="btn-circle btn-sm" />
                </x-slot:menu>

                <x-slot:actions>
                    <x-button label="More" icon="o-link" class="btn-outline btn-sm" link="#" />
                </x-slot:actions>
            </x-card>
        @empty
            <p class="text-lg">No matrix found</p>
        @endforelse

    </div>

    <div class="mt-7">
        {{ $this->matrices->links() }}
    </div>


</div>
