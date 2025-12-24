@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center p-2 font-semibold text-sm rounded-sm group bg-violet-200 shadow text-violet-800 transition-all ease-in-out duration-300'
            : 'flex items-center p-2 text-gray-600 font-semibold text-sm rounded-sm group hover:bg-violet-200 hover:text-violet-800 transition-all ease-in-out duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
