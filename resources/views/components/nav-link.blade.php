@props([
    'active',
])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center border-b-2 border-white px-1 pt-1 text-lg font-medium leading-5 text-white transition duration-150 ease-in-out focus:border-white focus:outline-none'
            : 'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-lg font-medium leading-5 text-white transition duration-150 ease-in-out hover:border-white hover:text-white focus:border-white focus:text-white focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
