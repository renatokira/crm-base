<div>

    <x-card title="Register a new user" class="mx-auto w-[400px]">

        <x-form wire:submit="submit">
            <x-input label="Name" wire:model="name" />
            <x-input label="Email" type="email" wire:model="email" />
            <x-input label="Confirm your email" type="email" wire:model="email_confirmation" />
            <x-input label="Password" type="password" wire:model="password" />

            <x-slot:actions>
                <x-button label="Reset" type="reset" />
                <x-button label="Register" class="btn-primary" type="submit" spinner="submit" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>
