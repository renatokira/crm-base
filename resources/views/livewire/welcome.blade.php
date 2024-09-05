<div>
    <!-- HEADER -->
    <x-header title="Welcome" size="text-3xl" separator
        progress-indicator>
    </x-header>


    <div class="grid grid-cols-1 gap-5 mt-5 lg:grid-cols-2 xl:grid-cols-3">
        @foreach ($matrices as $matrix)
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
        @endforeach
    </div>

    <div class="mt-7">
        {{ $matrices->links() }}
    </div>


</div>
