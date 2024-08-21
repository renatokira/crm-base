<div>

    <x-card title="Login" class="mx-auto w-[400px]">
        @error('invalidCredentials')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        @error('rateLimiter')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <x-form wire:submit="tryToLogin">
            <x-input label="Email" wire:model="email" />
            <x-input label="Password" type="password" wire:model="password" />


            <x-slot:actions>
                <x-button label="Cancel" />
                <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
