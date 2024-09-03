<x-drawer wire:model="drawer" :title="$user?->name"  class="w-11/12 p-4 lg:w-1/3" separator right>

    @if ($user)
        <div class="space-y-4">
            <x-input readonly label="Name" :value="$user->name" />
            <x-input readonly label="Email" :value="$user->email" />
            <x-input readonly label="Created at" :value="$user->created_at?->format('d/m/Y H:i')" />
            <x-input readonly label="Updated at" :value="$user->updated_at?->format('d/m/Y H:i')" />
            <x-input readonly label="Deleted at" :value="$user->deleted_at?->format('d/m/Y H:i')" />
            <x-input readonly label="Deleted by" :value="$user->deletedBy?->name" />
        </div>
    @endif

    <x-slot:actions>
        <x-button label="Close" @click="$wire.drawer = false" />
    </x-slot:actions>
</x-drawer>
