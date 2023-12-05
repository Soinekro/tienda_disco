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
                    <a href="{{ route('dashboard') }}" class="flex ml-2 md:mr-32">
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
                            <button type="button" @click="openmenu = !openmenu"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full"
                                    src="@if (Laravel\Jetstream\Jetstream::managesProfilePhotos()) {{ Auth::user()->profile_photo_url }} @else https://flowbite.com/docs/images/people/profile-picture-5.jpg @endif"
                                    alt="user photo">
                            </button>
                        </div>
                        <div x-show="openmenu" @click.away="openmenu = false"
                            class="z-50  my-4 w-40 text-base list-none bg-white divide-y divide-gray-100
                            rounded shadow dark:bg-gray-700 dark:divide-gray-600 float-right absolute
                            right-0 mr-3 mt-64"
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
                                <x-admin.layouts.drop-button href="{{ route('dashboard') }}" class="text-gray-700">
                                    {{ __('Main Menu') }}
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
                <x-admin.layouts.side-button href="{{ route('admin.categories.index') }}" :active="request()->routeIs('admin.categories.index')">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400
                            group-hover:text-gray-900 dark:group-hover:text-white"
                            viewBox="0 0 512 512">
                            <path
                                d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64V400c0 44.2 35.8 80 80 80H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H80c-8.8 0-16-7.2-16-16V64zm406.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L320 210.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L240 221.3l57.4 57.4c12.5 12.5 32.8 12.5 45.3 0l128-128z" />
                        </svg>
                    </x-slot>
                    {{ __('Categories') }}
                </x-admin.layouts.side-button>
                {{-- @endcan --}}
                {{-- @can('admin.products.index') --}}
                <x-admin.layouts.side-button href="{{ route('admin.products.index') }}" :active="request()->routeIs('admin.products.index')">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400
                            group-hover:text-gray-900 dark:group-hover:text-white"
                            viewBox="0 0 512 512">
                            <path
                                d="M326.3 218.8c0 20.5-16.7 37.2-37.2 37.2h-70.3v-74.4h70.3c20.5 0 37.2 16.7 37.2 37.2zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-128.1-37.2c0-47.9-38.9-86.8-86.8-86.8H169.2v248h49.6v-74.4h70.3c47.9 0 86.8-38.9 86.8-86.8z" />
                        </svg>
                    </x-slot>
                    {{ __('products') }}
                </x-admin.layouts.side-button>
                {{-- @endcan --}}
            </ul>
        </div>
    </aside>
</div>
