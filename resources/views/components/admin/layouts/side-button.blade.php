@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center rounded-lg p-2 bg-blue-100 dark:bg-gray-700 dark:text-white group text-[14px]'
            : 'flex items-center rounded-lg p-2 hover:bg-blue-100 dark:hover:bg-gray-700 dark:text-white group text-[14px]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $icon }}
    <span class="flex-1 ml-3 whitespace-nowrap">{{ $slot }}</span>
</a>
