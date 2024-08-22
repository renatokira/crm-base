<div>
    {{-- The Master doesn't talk, he acts. --}}

    @if ($message)
        <x-alert icon="o-exclamation-triangle" class="mb-4 text-sm alert-warning">
            {{ $message }}
        </x-alert>
    @endif
</div>
