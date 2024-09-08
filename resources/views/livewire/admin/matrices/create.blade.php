<x-drawer wire:model="matrixDrawer" title="Create Matrix" class="w-11/12 p-4 lg:w-1/3" separator right>

    <x-form wire:submit.prevent="save" id="create-matrix-form">
        <div class="space-y-4">

            <x-input label="Name" wire:model="name" />
            <x-input label="Threshold" type="number" wire:model="threshold" />
            <x-input label="Bandwidth" type="number" wire:model="bandwidth" />
            <x-select label="Bandwidth Unit" wire:model="bandwidth_unit" :options="$this->units"
                placeholder="Select a bandwidth unit" placeholder-value="0" />
            <x-textarea label="Description" wire:model="description" />


        </div>
        <x-slot:actions>
            <x-button label="Close" @click="$wire.matrixDrawer = false" />
            <x-button type="reset" label="Reset" wire:click="clear" class="btn-secondary" />
            <x-button type="submit" form="create-matrix-form" label="Create" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</x-drawer>
