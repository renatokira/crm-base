@props(['header', 'name'])

@php
    $direction = $header['sortDirection'] == 'asc' ? 'desc' : 'asc';
@endphp

<div {{ $attributes->class(['cursor-pointer']) }} wire:click="sortBy('{{ $name }}', '{{ $direction }}')">
    {{ $header['label'] }} @if ($header['sortColumnBy'] == $name)
        <x-icon :name="$header['sortDirection'] == 'asc' ? 'o-chevron-up' : 'o-chevron-down'" class="w-3 h-3 ml-px" />
    @endif
</div>
