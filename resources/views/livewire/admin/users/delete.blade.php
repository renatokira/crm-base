<x-modal wire:model="modal" title="Deletion Confirmation" subtitle="You are deleting the user {{ $user?->name }}"
    separator>

    @error('confirm')
        <x-alert icon="o-exclamation-triangle" class="mb-4 alert-error">
            {{ $message }}
        </x-alert>
    @enderror

    <x-input class="input-sm" label="Write `DELETAR` to confirm the deletion" wire:model="confirm_confirmation" />

    <x-slot:actions>
        <x-button label="Cancel" @click="$wire.modal = false" />
        <x-button label="Confirm" class="btn-primary" wire:click="destroy" />
    </x-slot:actions>
</x-modal>
