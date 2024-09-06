<div class="flex items-center space-x-3 ">
    <x-select class="select-sm" placeholder="Select a user" placeholder-value="0" icon="o-user" :options="$this->users"
        wire:model.live="selectedUser" />
    <x-button class=" btn-sm" wire:click="tryToLogin" label="Login" />
</div>
