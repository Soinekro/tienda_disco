<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Productos') }}
    </h2>
    <x-button class="mt-4" wire:click="create">
        {{ __('Crear producto') }}
    </x-button>
    <x-button class="ml-2 mt-4" wire:click="exportProducts">
        {{ __('Exportar productos') }}
    </x-button>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-4">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">{{ __('ID') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Producto') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Categoría') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Precio compra') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Precio venta') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Stock') }}[{{ __('Units') }}] </th>
                    <th scope="col" class="py-3 px-6">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">
                            {{ $item->id }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $item->name }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $item->category->name }}
                        </td>
                        <td class="py-4 px-6">
                            {{ tramsform_cash($item->price_buy) }}
                        </td>
                        <td class="py-4 px-6">
                            {{ tramsform_cash($item->price_sale) }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $item->stock }}
                        </td>
                        <td class="py-4 px-6">
                            <button class="bg-amber-500 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded"
                                wire:click="toUnits({{ $item->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="w-6 h-6 mx-auto svg-dark"
                                    viewBox="0 0 576 512">
                                    <path
                                        d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z" />
                                </svg>
                            </button>
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
        {{-- links --}}
        <div class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            {{ $products->links() }}
        </div>
    </div>

    <x-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Guardar producto') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" wire:model="name"
                    autocomplete="false" />
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="category_id" value="{{ __('Category') }}" />
                <select id="category_id" class="block mt-1 w-full" wire:model="category_id">
                    <option value="">{{ __('Seleccionar categoría') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="price_buy" value="{{ __('Precio compra') }}" />
                <x-input id="price_buy" class="block mt-1 w-full" type="text" wire:model="price_buy"
                    autocomplete="false" />
                @error('price_buy')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="price_sale" value="{{ __('Precio venta') }}" />
                <x-input id="price_sale" class="block mt-1 w-full" type="text" wire:model="price_sale"
                    autocomplete="false" />
                @error('price_sale')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="stock" value="{{ __('Stock') }}" />
                <x-input id="stock" class="block mt-1 w-full" type="text" wire:model="stock"
                    autocomplete="false" />
                @error('stock')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="stock_min" value="{{ __('Stock Min.') }}" />
                <x-input id="stock_min" class="block mt-1 w-full" type="text" wire:model="stock_min"
                    autocomplete="false" />
                @error('stock_min')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            @if ($product_id)
                <x-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-button>
            @else
                <x-button class="ml-2" wire:click="store" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-button>
            @endif

        </x-slot>
    </x-dialog-modal>

    @section('scripts')
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
                        @this.call('delete', item)
                    }
                })
            }
        </script>
    @endsection
</div>
