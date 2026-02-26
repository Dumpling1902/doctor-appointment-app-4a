@props(['tab'])

<div x-show="tab === '{{ $tab }}'" class="mt-4">
    {{ $slot }}
</div>