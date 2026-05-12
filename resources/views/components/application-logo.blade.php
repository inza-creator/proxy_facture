@props([])

{{-- Ne pas fixer h-auto/w-auto ici : le parent impose max-h-* ou h-* pour préserver le ratio (object-contain). --}}
<img
    src="{{ asset('image.png') }}"
    alt="Proxyma Technologies"
    {{ $attributes->merge(['class' => 'block max-w-full object-contain']) }}
/>
