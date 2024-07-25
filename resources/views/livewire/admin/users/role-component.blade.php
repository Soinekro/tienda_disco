<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Roles') }}
    </h2>
    <x-button class="mt-4" wire:click="create">
        {{ __('Create') }} {{ __('rol') }}
    </x-button>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-4">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">{{ __('Rol') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Permisos') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">
                            {{ $item->name }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $item->permissions->count() }}
                        </td>
                        <td class="py-4 px-6">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                wire:click="edit({{ $item->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="w-6 h-6 mx-auto svg-dark"
                                    viewBox="0 0 512 512">
                                    <path
                                        d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                </svg>
                            </button>
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                onclick="confirmDelete({{ $item->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="w-6 h-6 mx-auto svg-dark"
                                    viewBox="0 0 448 512">
                                    <path
                                        d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            {{ __('Roles') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" wire:model="name"
                    autocomplete="false" />
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <div class="border rounded-md p-2 m-0.5">
                    <label class="text-sm font-medium text-gray-900 dark:text-white">
                        <input onclick="selectAll()"
                            class="w-4 h-4 text-sm text-gray-900 dark:text-gray-400
                            focus:outline-none dark:bg-gray-700 dark:border-gray-600 cursor-pointer
                            dark:placeholder-gray-400"
                            id="all_permissions" type="checkbox" />
                        {{ __('Seleccionar todo') }}
                    </label>
                    <div class="grid grid-rows-12 grid-flow-col">
                        @foreach ($permissions as $permission)
                            <div class="mt-1 ml-2">
                                <label class="flex text-sm font-medium text-gray-900 dark:text-white">
                                    <input id="permission-{{ $permission->id }}" name="permissions[]"
                                        wire:model="permissions_picked"
                                        class="mx-1 flex w-4 h-4 text-sm text-gray-900 border
                                        border-verde-300 rounded-lg bg-gray-50 dark:text-gray-400
                                        focus:outline-none dark:bg-gray-700 dark:border-gray-600 cursor-pointer
                                        dark:placeholder-gray-400"
                                        value="{{ $permission->id }}" type="checkbox"
                                        @isset($role)
                                @if (in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray()))) checked @endif @endisset>
                                    {{ __($permission->description) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('permissions_picked')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('open')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            @if ($role_id)
                <x-button class="ml-2" wire:click="update" wire:loading.attr="disabled" wire:target="update">
                    {{ __('Update') }}
                </x-button>
            @else
                <x-button class="ml-2" wire:click="store" wire:loading.attr="disabled" wire:target="store">
                    {{ __('Create') }}
                </x-button>
            @endif

        </x-slot>
    </x-dialog-modal>

    @section('scripts')
        <script>
            function selectAll() {
                let all_permissions = document.getElementById('all_permissions');
                let permissions = document.getElementsByName('permissions[]');
                if (all_permissions.checked) {
                    permissions.forEach(permission => {
                        permission.checked = true;
                        @this.call('selectAll');
                    });
                } else {
                    permissions.forEach(permission => {
                        permission.checked = false;
                        @this.call('unselectAll');
                    });
                }
            }

            function confirmDelete(item) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('delete', item)
                    }
                })
            }
        </script>
    @endsection
</div>
