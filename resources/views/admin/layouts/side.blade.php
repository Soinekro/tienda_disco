<div x-data="{ opennav: true, openmenu: false }" class="h-full">
    <nav class="fixed top-0 z-50 w-full bg-blue-400 border-b border-gray-200
    dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between" @click="opennav = !opennav">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg
                        sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2
                        focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700
                        dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="{{ route('sales') }}" class="flex ml-2 md:mr-32">
                        <img src="@if (file_exists(storage_path('app/public/logos/logo.png'))) {{ asset('storage/logos/logo.png') }} @else {{ asset('storage/logos/logo-oficial.png') }} @endif"
                            class="h-8 mr-3" alt="Logo" />
                        <span
                            class="hidden xs:block self-center text-xl font-semibold text-[13px] sm:text-[18px] whitespace-nowrap
                             dark:text-white">
                            {{ config('app.name', 'Laravel') }}
                        </span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ml-3 md:ml-6 mb-1">
                        <div>
                            {{-- <button type="button" @click="openmenu = !openmenu"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full"
                                    src="@if (Laravel\Jetstream\Jetstream::managesProfilePhotos()) {{ Auth::user()->profile_photo_url }} @else https://flowbite.com/docs/images/people/profile-picture-5.jpg @endif"
                                    alt="user photo">
                            </button> --}}
                            <span class="inline-flex rounded-md">
                                <button type="button" @click="openmenu = !openmenu"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                    {{ Auth::user()->name }}
                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </div>
                        <div x-show="openmenu" @click.away="openmenu = false" x-cloak
                            class="z-50 my-4 w-40 text-base list-none bg-white divide-y divide-gray-100
                            rounded shadow dark:bg-gray-700 dark:divide-gray-600 float-right absolute
                            right-0 mr-5 mt-64"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <x-admin.layouts.drop-button href="{{ route('profile.show') }}" class="text-gray-700">
                                    {{ __('Profile') }}
                                </x-admin.layouts.drop-button>
                                <x-admin.layouts.drop-button href="{{ route('sales') }}" class="text-gray-700">
                                    {{ __('Sales') }}
                                </x-admin.layouts.drop-button>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-admin.layouts.drop-button href="{{ route('logout') }}"
                                        @click.prevent="$root.submit();" class="text-gray-700">
                                        {{ __('Log Out') }}
                                    </x-admin.layouts.drop-button>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside :class="{ '-translate-x-full sm:translate-x-0': opennav, 'block ': !opennav }" aria-label="Sidebar"
        class="fixed top-0 left-0 z-40 w-60 h-screen pt-20 transition-transform
         bg-blue-300 border-r border-gray-200
         dark:bg-gray-800 dark:border-gray-700 none md:block">
        <div class="h-screen px-3 pb-4 overflow-y-auto dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                {{-- @can('admin.categories.index') --}}
                <x-admin.layouts.side-button href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400
                            group-hover:text-gray-900 dark:group-hover:text-white"
                            viewBox="0 0 512 512">
                            <path
                                d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64V400c0 44.2 35.8 80 80 80H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H80c-8.8 0-16-7.2-16-16V64zm406.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L320 210.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L240 221.3l57.4 57.4c12.5 12.5 32.8 12.5 45.3 0l128-128z" />
                        </svg>
                    </x-slot>
                    {{ __('Dashboard') }}
                </x-admin.layouts.side-button>
                {{-- @endcan --}}
                {{-- @can('admin.products.index') --}}
                {{-- @endcan --}}
                <div x-data="{ open: false }"
                    @if (request()->is('admin/tienda*')) x-init="open = true"
                            @else
                            x-init="open = false" @endif
                    class="relative">
                    <x-admin.layouts.side-button @click="open = !open" :active="request()->is('admin/tienda*')">
                        <x-slot name="icon">
                            <template x-if="open">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ms-0.5" viewBox="0 0 448 512">
                                    <path
                                        d="M201.4 137.4c12.5-12.5 32.8-12.5 45.3 0l160 160c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 205.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l160-160z" />
                                </svg>
                            </template>
                            <template x-if="!open">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ms-0.5" viewBox="0 0 448 512">
                                    <path
                                        d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" />
                                </svg>
                            </template>
                        </x-slot>
                        {{ __('Store') }}
                    </x-admin.layouts.side-button>
                    <!-- Dropdown menu -->
                    <div x-show="open" class="mt-0.5">
                        <x-admin.layouts.side-button :active="request()->routeIs('admin.categories.index')" href="{{ route('admin.categories.index') }}">
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400
                                        group-hover:text-gray-900 dark:group-hover:text-white"
                                    viewBox="0 0 448 512">
                                    <path
                                        d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                </svg>
                            </x-slot>
                            {{ __('Categories') }}
                        </x-admin.layouts.side-button>
                        <x-admin.layouts.side-button :active="request()->routeIs('admin.products.index')" href="{{ route('admin.products.index') }}">
                            <x-slot name="icon">
                                <svg viewBox="0 0 24 24" fill="currentColor"
                                    class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400
                                        group-hover:text-gray-900 dark:group-hover:text-white"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.5 17V6H19.5V17H4.5Z" stroke="" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M4.5 6L6.5 2.00001L17.5 2L19.5 6" stroke="none" stroke-width="1.5" />
                                    <path d="M10 9H14" stroke="#FFFFFF" stroke-width="1.5" />
                                    <path
                                        d="M11.9994 19.5V22M11.9994 19.5L6.99939 19.5M11.9994 19.5H16.9994M6.99939 19.5H1.99939V22M6.99939 19.5V22M16.9994 19.5H22L21.9994 22M16.9994 19.5V22"
                                        stroke="#141B34" stroke-width="1.5" stroke-linejoin="round" />
                                </svg>
                            </x-slot>
                            {{ __('Products') }}
                        </x-admin.layouts.side-button>
                    </div>
                </div>
                <div x-data="{ open: false }"
                    @if (request()->is('admin/movimientos*')) x-init="open = true"
                            @else
                            x-init="open = false" @endif
                    class="relative">
                    <x-admin.layouts.side-button @click="open = !open" :active="request()->is('admin/movimientos*')">
                        <x-slot name="icon">
                            <template x-if="open">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ms-0.5" viewBox="0 0 448 512">
                                    <path
                                        d="M201.4 137.4c12.5-12.5 32.8-12.5 45.3 0l160 160c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 205.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l160-160z" />
                                </svg>
                            </template>
                            <template x-if="!open">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ms-0.5" viewBox="0 0 448 512">
                                    <path
                                        d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" />
                                </svg>
                            </template>
                        </x-slot>
                        {{ __('Movimientos') }}
                    </x-admin.layouts.side-button>
                    <!-- Dropdown menu -->
                    <div x-show="open" class="mt-0.5">
                        <x-admin.layouts.side-button :active="request()->routeIs('admin.providers.index')" href="{{ route('admin.providers.index') }}">
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400
                                        group-hover:text-gray-900 dark:group-hover:text-white"
                                    viewBox="0 0 448 512">
                                    <path
                                        d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                </svg>
                            </x-slot>
                            {{ __('Providers') }}
                        </x-admin.layouts.side-button>
                        <x-admin.layouts.side-button :active="request()->routeIs('admin.shoppings.index')" href="{{ route('admin.shoppings.index') }}">
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400
                                        group-hover:text-gray-900 dark:group-hover:text-white"
                                    viewBox="0 0 640 512">
                                    <path
                                        d="M640 0l0 400c0 61.9-50.1 112-112 112c-61 0-110.5-48.7-112-109.3L48.4 502.9c-17.1 4.6-34.6-5.4-39.3-22.5s5.4-34.6 22.5-39.3L352 353.8 352 64c0-35.3 28.7-64 64-64L640 0zM576 400a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM23.1 207.7c-4.6-17.1 5.6-34.6 22.6-39.2l46.4-12.4 20.7 77.3c2.3 8.5 11.1 13.6 19.6 11.3l30.9-8.3c8.5-2.3 13.6-11.1 11.3-19.6l-20.7-77.3 46.4-12.4c17.1-4.6 34.6 5.6 39.2 22.6l41.4 154.5c4.6 17.1-5.6 34.6-22.6 39.2L103.7 384.9c-17.1 4.6-34.6-5.6-39.2-22.6L23.1 207.7z" />
                                </svg>
                            </x-slot>
                            {{ __('Entradas') }}
                        </x-admin.layouts.side-button>
                        <!-- salidas -->
                        <x-admin.layouts.side-button :active="request()->routeIs('admin.sales.index')" href="{{ route('admin.sales.index') }}">
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg"fill="currentColor"
                                    class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400
                                    group-hover:text-gray-900 dark:group-hover:text-white"
                                    viewBox="0 0 576 512">
                                    <path
                                        d="M24 0C10.7 0 0 10.7 0 24S10.7 48 24 48l45.5 0c3.8 0 7.1 2.7 7.9 6.5l51.6 271c6.5 34 36.2 58.5 70.7 58.5L488 384c13.3 0 24-10.7 24-24s-10.7-24-24-24l-288.3 0c-11.5 0-21.4-8.2-23.6-19.5L170.7 288l288.5 0c32.6 0 61.1-21.8 69.5-53.3l41-152.3C576.6 57 557.4 32 531.1 32L360 32l0 102.1 23-23c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-64 64c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l23 23L312 32 120.1 32C111 12.8 91.6 0 69.5 0L24 0zM176 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm336-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0z" />
                                </svg>
                            </x-slot>
                            {{ __('Salidas') }}
                        </x-admin.layouts.side-button>
                    </div>
                </div>
            </ul>
        </div>
    </aside>
</div>
