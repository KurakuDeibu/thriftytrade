@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex px-2 py-2 items-center hover:text-indigo-900 text-md text-indigo-500 border-b-2 border-indigo-400'
            : 'inline-flex px-2 py-2 items-center hover:text-indigo-900 text-md text-gray-500';

@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
