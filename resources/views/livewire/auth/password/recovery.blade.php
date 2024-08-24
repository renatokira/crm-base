<x-card title="Password recovery" shadow class="mx-auto w-[450px]">
    @if($message)
        <x-alert icon="o-exclamation-triangle" class="mb-4 alert-success">
            <span>We will send you an email with a link to reset your password.</span>
        </x-alert>
    @endif

    <x-form wire:submit="startPasswordRecovery">
        <x-input label="Email" wire:model="email"/>
        <x-slot:actions>
            <div class="flex items-center justify-between w-full">
                <a wire:navigate href="{{ route('login') }}" class="link link-primary">
                    Never mind, get back to login page.
                </a>
                <div>
                    <x-button label="Submit" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
