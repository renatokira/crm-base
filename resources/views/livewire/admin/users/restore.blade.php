<x-modal wire:model="modal"
         title="Restore Confirmation"
         subtitle="You are restoring access for the user {{ $user?->name }}"
         separator>

    @error('confirm')
    <x-alert icon="o-exclamation-triangle" class="mb-4 alert-error">
        {{ $message }}
    </x-alert>
    @enderror

    <x-input
        class="input-sm"
        label="Write `RESTORE` to confirm the restoration"
        wire:model="confirm_confirmation"
    />

    <x-slot:actions>
        <x-button label="Cancel" @click="$wire.modal = false"/>
        <x-button label="Confirm" class="btn-primary" wire:click="restore"/>
    </x-slot:actions>
</x-modal>
