@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block text-sm w-full pl-3 pr-4 py-2 border-l-4 border-blue-800 dark:border-blue-600
             text-left text-base font-medium text-blue-700 dark:text-black bg-blue-100
             dark:bg-gray-200 focus:outline-none focus:text-blue-800 dark:focus:text-blue-200
             focus:bg-blue-100 dark:focus:bg-blue-900 focus:border-blue-700
             dark:focus:border-blue-300 transition duration-150 ease-in-out'
            : 'block text-sm w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base
            font-medium text-black dark:text-white hover:text-white dark:hover:text-gray-200
            hover:bg-blue-200 dark:hover:bg-sky-700 hover:border-gray-300 dark:hover:border-gray-600
            focus:outline-none focus:text-white dark:focus:text-black focus:bg-cyan-700
             dark:focus:bg-sky-700 focus:border-gray-300 dark:focus:border-gray-600 transition
             duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
