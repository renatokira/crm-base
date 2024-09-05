<x-modal wire:model="modal" :title="$matrix?->name" separator>
    @if ($matrix)
        <div class="space-y-4">
            <x-input readonly label="Threshold" :value="$matrix->threshold" />
            <x-input readonly label="Bandwidth" :value="$matrix->bandwidth . '' . $matrix->bandwidth_unit" />
            <x-input readonly label="Created at" :value="$matrix->created_at?->format('d/m/Y H:i')" />
        </div>
    @endif

    <x-slot:actions>
        <x-button label="Close" @click="$wire.modal = false" />
    </x-slot:actions>
</x-modal>
