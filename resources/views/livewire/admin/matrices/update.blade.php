<x-drawer wire:model="matrixUpdateDrawer" title="Update Matrix" class="w-11/12 p-4 lg:w-1/3" separator right>

    <x-form wire:submit.prevent="save" id="update-matrix-form">
        <div class="space-y-4">

            <x-input label="Name" wire:model="form.name" />
            <x-input label="Threshold" type="number" wire:model="form.threshold" />
            <x-input label="Bandwidth" type="number" wire:model="form.bandwidth" />
            <x-select label="Bandwidth Unit" wire:model="form.bandwidth_unit" :options="$units"
                placeholder="Select a bandwidth unit" placeholder-value="0" />
            <x-textarea label="Description" wire:model="form.description" />


        </div>
        <x-slot:actions>
            <x-button label="Close" @click="$wire.matrixUpdateDrawer = false" />
            <x-button type="submit" form="update-matrix-form" label="Update" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</x-drawer>
