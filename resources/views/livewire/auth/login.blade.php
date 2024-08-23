<div>

    <x-card shawdow title="Login" class="mx-auto w-[450px]">
        @if ($errors->hasAny(['invalidCredentials', 'rateLimiter']))
            <x-alert icon="o-exclamation-triangle" class="mb-4 text-sm alert-warning">
                @error('invalidCredentials')
                    <span>{{ $message }}</span>
                @enderror

                @error('rateLimiter')
                    <span>{{ $message }}</span>
                @enderror
            </x-alert>
        @endif

        <x-form wire:submit="tryToLogin">
            <x-input label="Email" wire:model="email" />
            <x-input label="Password" type="password" wire:model="password" />

            <div class="w-full text-sm text-right">
                <a href="{{ route('password.recovery') }}" class="text-xs link link-primary">
                    Forgot your password?
                </a>
            </div>

            <x-slot:actions>
                <div class="flex justify-between w-full align-items-center">
                    <a wire:navigate class="link link-primary" href="{{ route('auth.register') }}"
                        class="text-sm text-sky-500">I want to register</a>
                    <x-button label="Login" class="btn-primary" type="submit" spinner="save" />
                </div>
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
