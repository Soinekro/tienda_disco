<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- sweetalert --}}
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased dark:bg-gray-900">
    <div class="h-full ">
        <!-- Sidebar compponent -->
        @include('admin.layouts.side')
        <!--end Sidebar -->

        <div class="p-4 sm:ml-60">
            <div class="p-4 dark:border-gray-700 mt-14 sm:px-6  dark:bg-gray-800 border-b border-gray-200 rounded-md">
                @if (session('message'))
                    <div x-data="{ open: true }" x-show="open" id="alert-border-1">
                        <div class="flex items-center p-4 mb-4 text-blue-800 border-b-4 animate-bounce
                                border-blue-300 bg-blue-50 dark:text-blue-400
                                 dark:bg-gray-800 dark:border-blue-800"
                            role="alert">
                            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <div class="ml-3 text-sm font-medium">
                                {{ session('message') }}
                            </div>
                            <button type="button" @click="open = false"
                                class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500
                                rounded-lg focus:ring-2
                                    focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex
                                    items-center justify-center w-8 dark:bg-gray-800 dark:text-blue-400
                                    h-8 dark:hover:bg-gray-700"
                                data-dismiss-target="#alert-border-1" aria-label="Close">
                                <span class="sr-only">Dismiss</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    @stack('modals')

    @yield('scripts')
    @livewireScripts
</body>

</html>
