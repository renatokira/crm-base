<div>
    <div class="flex justify-center">
        <x-select class="w-full" :options="$this->users" wire:model.live="selectedUser" />
        <x-button label="Login" />
    </div>
</div>
