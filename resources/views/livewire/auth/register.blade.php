<div>

    <x-card title="Register" class="mx-auto w-[450px]">

        <x-form wire:submit="submit">
            <x-input label="Name" wire:model="name" />
            <x-input label="Email" type="email" wire:model="email" />
            <x-input label="Confirm your email" type="email" wire:model="email_confirmation" />
            <x-input label="Password" type="password" wire:model="password" />


            <x-slot:actions>
                <div class="flex justify-between w-full align-items-center">

                    <a wire:navigate class="link link-primary" href="{{ route('login') }}"
                        class="text-sm text-sky-500">I
                        already have an account</a>

                    <div>
                        <x-button label="Reset" class="btn-ghost" type="reset" />
                        <x-button label="Register" class="btn-primary" type="submit" spinner="submit" />
                    </div>
                </div>

            </x-slot:actions>
        </x-form>

    </x-card>
</div>
