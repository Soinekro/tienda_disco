<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Shopping') }}
    </h2>
    <x-button class="mt-4" wire:click="create">
        {{ __('Crear compra') }}
    </x-button>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-4">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">{{ __('date') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('code') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Provider') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Total') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('user') }}</th>
                    <th scope="col" class="py-3 px-6">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @isset($shoppings)
                    @foreach ($shoppings as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">
                                {{ date_for_humans($item->date) }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $item->code }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $item->provider->name }}
                            </td>
                            <td class="py-4 px-6">
                                {{ tramsform_cash($item->total) }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $item->user->name }}
                            </td>
                            <td class="py-4 px-6 flex">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                    wire:click="edit({{ $item->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="w-4 h-4 mx-auto svg-dark"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                    </svg>
                                </button>
                                @if ($item->payments()->sum('amount') < $item->total)
                                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                        wire:click="openPays('{{ $item->id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                            class="w-4 h-4 mx-auto svg-dark" viewBox="0 0 576 512">
                                            <path
                                                d="M0 112.5V422.3c0 18 10.1 35 27 41.3c87 32.5 174 10.3 261-11.9c79.8-20.3 159.6-40.7 239.3-18.9c23 6.3 48.7-9.5 48.7-33.4V89.7c0-18-10.1-35-27-41.3C462 15.9 375 38.1 288 60.3C208.2 80.6 128.4 100.9 48.7 79.1C25.6 72.8 0 88.6 0 112.5zM288 352c-44.2 0-80-43-80-96s35.8-96 80-96s80 43 80 96s-35.8 96-80 96zM64 352c35.3 0 64 28.7 64 64H64V352zm64-208c0 35.3-28.7 64-64 64V144h64zM512 304v64H448c0-35.3 28.7-64 64-64zM448 96h64v64c-35.3 0-64-28.7-64-64z" />
                                        </svg>
                                    </button>
                                @endif
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                    onclick="confirmDelete({{ $item->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="w-4 h-4 mx-auto svg-dark"
                                        viewBox="0 0 448 512">
                                        <path
                                            d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    @if ($modalFormVisible)
        <x-dialog-modal wire:model="modalFormVisible">
            <x-slot name="title">
                {{ __('Save Shop') }}
            </x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="mt-4">
                        <x-label for="code" value="{{ __('Code') }}" />
                        <x-input id="code" class="block mt-1 w-full" type="text" wire:model="code"
                            autocomplete="false" />
                        @error('code')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <x-label for="date" value="{{ __('Date') }}" />
                        <x-input id="date" class="block mt-1 w-full" type="date" wire:model="date"
                            autocomplete="false" />
                        @error('date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <x-label for="ruc" value="{{ __('RUC') }}" />
                    <x-input id="ruc" class="block mt-1 w-full" type="text" wire:model.lazy="ruc"
                        autocomplete="false" />
                    @error('ruc')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-label for="name_provider" value="{{ __('Provider') }}" />
                    <x-input id="name_provider" class="block mt-1 w-full" type="text" wire:model="name_provider"
                        disabled autocomplete="false" />
                    @error('name_provider')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- agregar productos -->
                <div class="mt-4 shadow-md border-1 border-blue-300">
                    <div class="block md:flex">
                        <select wire:model.lazy="category_id" id="category_id" name="category_id"
                            class="my-0.5 flex-shrink-0 w-full md:max-w-max z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium
                        text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-lg md:rounded-s-lg hover:bg-gray-200
                        focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600
                        dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                            type="button">
                            <option value="" disabled>{{ __('Select') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="relative w-full">
                            <input type="text" wire:model.live="searchProduct"
                                class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg md:rounded-e-lg border-s-gray-50
                            border-s-2 border border-gray-300 focus:ring-blue-500
                            focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600
                            dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                                placeholder="{{ __('Search Product') }}" required>
                            <div>
                                @error('productPicked_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="absolute z-10 w-full bg-white rounded-lg shadow-lg mt-1"  wire:model="showDrop">
                        @if ($products != [])
                            @foreach ($products as $product)
                                <!-- items -->
                                <div wire:click="addProductID({{ $product->id }})"
                                    class="w-full flex p-1 pl-2 items-center hover:bg-gray-300 rounded-lg cursor-pointer">
                                    <div class="text-xs text-gray-500">
                                        <div class="font-bold text-sm">{{ __('Name') }}:
                                            {{ $product->name }}</div>
                                        <span class="mr-2">{{ __('Category') }}:
                                            {{ $product->categoryname }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div class="my-3">
                            <label for="unit_product" class="block text-sm font-medium text-gray-700">
                                {{ __('Product Units') }}
                            </label>
                            <select wire:model.lazy="unit_product" id="unit_product" name="unit_product"
                                class="my-0.5 flex-shrink-0 w-full inline-flex items-center py-2.5 px-4 text-sm font-medium
                            text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-lg md:rounded-s-lg hover:bg-gray-200
                            focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600
                            dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                                type="button">
                                <option value="" disabled>{{ __('Select') }}</option>
                                @if ($productUnits != [])
                                    @foreach ($productUnits as $productUnit)
                                        <option value="{{ $productUnit->id }}">
                                            {{ $productUnit->unit->name }} X {{ $productUnit->quantity }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('unit_product')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="quantityProduct" class="block text-sm font-medium text-gray-700">
                                {{ __('Quantity') }}
                            </label>
                            <input type="number" name="quantityProduct" id="quantityProduct"
                                wire:model.live="quantityProduct"
                                class="rounded-lg border-4 border-verde-300 w-full md:max-w-xs">
                            @error('quantityProduct')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="priceProduct" class="block text-sm font-medium text-gray-700">
                                {{ __('Price') }}
                                {{ __('Product') }}
                            </label>
                            <input type="number" name="priceProduct" id="priceProduct"
                                wire:model.live="priceProduct"
                                class="rounded-lg border-4 border-verde-300 w-full md:max-w-xs">
                            @error('priceProduct')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="totalProduct" class="block text-sm font-medium text-gray-700">
                                {{ __('Total Product') }}
                            </label>
                            <input type="number" name="totalProduct" id="totalProduct"
                                wire:model.live="totalProduct" disabled
                                class="rounded-lg border-4 border-verde-300 w-full md:max-w-xs">
                            @error('totalProduct')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <button wire:click="addProductToShop" wire:loading.attr="disabled"
                            wire:target="addProductToShop"
                            class="bg-blue-500 hover:bg-verde-300 text-white font-bold py-2 px-4 rounded float-right">
                            {{ __('Add Product') }}
                        </button>
                    </div>
                    @isset($details_products)
                        <div class="bg-white w-full rounded-xl shadow-xl overflow-x-auto p-1 m-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="m-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Name') }}
                                        </th>
                                        <th
                                            class="m-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Quantity') }}
                                        </th>
                                        <th
                                            class="m-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Price') }}
                                        </th>
                                        <th
                                            class="m-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Total') }}
                                        </th>
                                        <th
                                            class="m-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- items array-->
                                    @foreach ($details_products as $detail_product)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $detail_product['name'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $detail_product['quantity'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ tramsform_cash($detail_product['price_buy']) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ tramsform_cash($detail_product['total']) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <button
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                    wire:click="deleteProduct({{ $detail_product['product_id'] }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                        class="w-6 h-6 mx-auto svg-dark" viewBox="0 0 448 512">
                                                        <path
                                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endisset
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                @if ($shop_id)
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
    @endif

    @if ($showPaydSale)
        <x-dialog-modal wire:model="showPaydSale">
            <x-slot name="title">
                {{ __('Payd Sale') }}
            </x-slot>
            <x-slot name="content">
                <div class=" bg-white rounded-xl shadow-xl overflow-x-auto p-1 m-auto">
                    <div class="grid grid-cols-1">
                        <div class="block xs:flex xs:justify-between">
                            <div class="text-xl font-bold text-gray-700 mx-2">
                                {{ __('Date') }}:
                                {{ format_date($salePaid->created_at) }}
                            </div>
                            <div class="text-xl font-bold text-gray-700 mx-2">
                                {{ __('Code') }}:
                                {{ $salePaid->code }}
                            </div>
                        </div>
                        <div class="block xs:flex xs:justify-between">
                            <div class="text-xl font-bold text-gray-700 mx-2">
                                {{ __('Client') }}:
                                {{ $salePaid->client->name ?? __('Not Client') }}
                            </div>
                            <div class="text-xl font-bold text-gray-700 mx-2">
                                {{ __('User') }}:
                                {{ $salePaid->user->name }}
                            </div>
                        </div>
                    </div>
                    {{-- formulario para ingresar el tipo de pago el monto, referencia --}}
                    <div class="bg-white rounded-xl shadow-xl overflow-x-auto p-1 mt-3 m-auto">
                        {{ __('Sale Info') }}
                        <div class="grid grid-cols-1">
                            <div class="block xs:flex xs:justify-between">
                                <div class="text-xl font-bold text-gray-700 mx-2">
                                    {{ __('Total') }}:
                                    {{ tramsform_cash($salePaid->details->sum('total')) }}
                                </div>
                                <div class="text-xl font-bold text-gray-700 mx-2">
                                    {{ __('Pending') }}:
                                    {{ tramsform_cash($salePaid->details->sum('total') - $salePaid->payments->sum('amount')) }}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1">
                            <div class="block xs:flex xs:justify-between">
                                <div class="text-xl font-bold text-gray-700 mx-2">
                                    {{ __('Type') }}:
                                    <select wire:model.lazy="typePayment_id" id="typePayment_id"
                                        name="typePayment_id"
                                        class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs" type="button">
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach ($typePayments as $typePayment)
                                            <option value="{{ $typePayment->id }}">
                                                {{ $typePayment->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <br>
                                    @error('typePayment_id')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-xl font-bold text-gray-700 mx-2">
                                    {{ __('Amount') }}:
                                    <input type="number" name="amount" id="amount" wire:model.live="amount"
                                        class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                    <br>
                                    @error('amount')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- llamar una variable de livewire --}}
                            <div x-data="{ showEfective: @entangle('showEfective'), showTransfer: @entangle('showTransfer') }">
                                <div class="block xs:flex xs:justify-between" x-show="showEfective">
                                    <div class="text-xl font-bold text-gray-700 mx-2">
                                        {{ __('Paid With') }}:
                                        <input type="number" name="paidWith" id="paidWith" wire:model="paidWith"
                                            wire:keydown="paydSaleUpdate"
                                            class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                    </div>
                                    <div class="text-xl font-bold text-gray-700 mx-2">
                                        {{ __('Turned') }}:
                                        <input type="number" name="turned" id="turned" wire:model.lazy="turned"
                                            disabled class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                    </div>
                                </div>

                                <div class="flex justify-between" x-show="showTransfer">
                                    {{-- imagen de deposito --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="cancelPaydSale" wire:loading.attr="disabled">
                    {{ __('Close') }}
                </x-secondary-button>
                <x-button class="ml-2" wire:click="paydSale" wire:loading.attr="disabled">
                    {{ __('Payd') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>
    @endif

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
