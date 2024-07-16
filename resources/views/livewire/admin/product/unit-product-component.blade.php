<div class="div-container">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Unidades de producto') }}
    </h2>
    <x-button class="mt-4" wire:click="create">
        {{ __('Crear unidad') }}
    </x-button>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-4">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">{{ __('Code') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Description') }} </th>
                    <th scope="col" class="py-3 px-6">{{ __('Quantity') }} </th>
                    <th scope="col" class="py-3 px-6">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product_units as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">
                            {{ $item->idUnit }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $item->name }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $item->quantity }}
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

    <!-- modal -->
    @if ($open)
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                @if ($action == 'create')
                    {{ __('Create') }}
                @else
                    {{ __('Update') }}
                @endif
                {{ __('Nueva unidad para producto') }}
            </x-slot>
            <x-slot name="content">
                <div class="grid grid-rows-2">
                    <label class="label-to-input">
                        {{ __('Type') }}
                        {{ __('Unit') }}
                    </label>
                    <select wire:model.lazy="unit_id" class="input-modal">
                        <option value="">{{ __('Select') . ' ' . __('Unit') }}</option>
                        @foreach ($units as $unidad)
                            <option value="{{ $unidad->id }}">{{ $unidad->name }}</option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="grid grid-rows-2">
                    <label class="label-to-input">
                        {{ __('Quantity') }}({{ __('NIU') }})
                    </label>
                    <input class="input-modal" type="text" wire:model="quantity">
                    @error('quantity')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </x-slot>
            <x-slot name="footer">
                @if ($action == 'create')
                    <x-danger-button class="bg-verde-500 hover:bg-verde-700" wire:click="store">
                        {{ __('Create') }}
                    </x-danger-button>
                @else
                    <x-danger-button class="bg-verde-500 hover:bg-verde-700" wire:click="update">
                        {{ __('Update') }}
                    </x-danger-button>
                @endif
            </x-slot>
        </x-dialog-modal>
    @endif
    <!-- alerts -->
    <script>
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
                    @this.call('destroy', item)
                }
            })
        }
    </script>
</div>
