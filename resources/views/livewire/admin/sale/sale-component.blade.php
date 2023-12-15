<div>
    <div class="w-full sm:px-2 lg:p-4 grid grid-cols-1 md:flex">
        <div class="border-2 border-blue-300 sm:rounded-lg m-4 xs:m-3 p-4 lg:basis-1/2">
            <div class="border-2 border-blue-300 sm:rounded-lg p-4 m-auto xs:m-3 ">
                <h2 class="mb-3 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    {{ __('Sale Info') }}
                </h2>
                <div class="grid grid-cols-1">
                    <div x-data="{ boleta: false, factura: false, ticket: true }">
                        {{-- @if (module_active('Facturacion'))
                            <label for="type" class="text-black font-bold">
                                {{ __('Type') }}:
                            </label>
                            <div class="block xs:flex">
                                <div>
                                    <label for="type" class="m-2">
                                        <input type="radio" name="type" id="type" checked wire:model="type"
                                            @click="boleta=false;factura=false;ticket=true" value="T" />
                                        {{ __('Ticket') }}
                                    </label>
                                </div>
                                <div>
                                    <label for="type" class="m-2">
                                        <input type="radio" name="type" id="type" wire:model="type"
                                            @click="boleta=true;factura=false;ticket=false" value="B" />
                                        {{ __('Boleta') }}
                                    </label>
                                </div>
                                <div>
                                    <label for="type" class="m-2">
                                        <input type="radio" name="type" id="type" wire:model="type"
                                            @click="boleta=false;factura=true;ticket=false" value="F" />
                                        {{ __('Factura') }}
                                    </label>
                                </div>
                            </div>
                        @endif --}}
                        <!-- ticket-->
                        <div x-show="ticket" class="mt-3">
                            {{-- checkbox para incluir igv --}}
                            <div class="block md:flex">
                                <div class="mx-1.5 w-full xs:basis-1/2">
                                    <label for="document_number" class="block text-sm font-bold text-gray-700">
                                        {{ __('N° Doc') }}
                                    </label>
                                    <input type="number" name="document_number" id="document_number"
                                        wire:model.live="document_number"
                                        class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                    <br>
                                    @error('document_number')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mx-1.5 w-full xs:basis-1/2">
                                    <label for="name" class="block text-sm font-bold text-gray-700">
                                        {{ __('name') }}
                                    </label>
                                    <input type="text" name="name" id="name" wire:model="name"
                                        class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                    @error('name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- boleta-->
                        <div x-show="boleta">
                            <label for="igv" class="text-black font-bold mt-3">
                                <input type="checkbox" name="igv" id="igv" wire:model="igv" value="1">
                                {{ __('include IGV') }}
                            </label>
                            <div class="block md:flex">
                                <div class="mx-1.5 w-full xs:basis-1/2">
                                    <label for="dni" class="block text-sm font-bold text-gray-700">
                                        {{ __('DNI') }}
                                    </label>
                                    <input type="number" name="dni" id="dni" wire:model="dni"
                                        wire:keydown="totalProductUpdate"
                                        class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                    @error('dni')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mx-1.5 w-full xs:basis-1/2">
                                    <label for="priceProduct" class="block text-sm font-bold text-gray-700">
                                        {{ __('Name') }}
                                    </label>
                                    <input type="number" name="priceProduct" id="priceProduct"
                                        wire:model="priceProduct" wire:keydown="priceUpdate"
                                        class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                    @error('priceProduct')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- factura-->
                        <div x-show="factura">
                            <div class="block md:flex">
                                <div class="mx-1.5 w-full xs:basis-1/2">
                                    <label for="quantityProduct" class="block text-sm font-bold text-gray-700">
                                        {{ __('Quantity') }}
                                    </label>
                                    <input type="text" name="quantityProduct" id="quantityProduct"
                                        wire:model="quantityProduct" wire:keydown="totalProductUpdate"
                                        class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                    @error('quantityProduct')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mx-1.5 w-full xs:basis-1/2">
                                    <label for="priceProduct" class="block text-sm font-bold text-gray-700">
                                        {{ __('Price') }}
                                        {{ __('Product') }}
                                    </label>
                                    <input type="text" name="priceProduct" id="priceProduct"
                                        wire:model="priceProduct" wire:keydown="priceUpdate"
                                        class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                    @error('priceProduct')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="block md:flex mt-3">
                            <div class="mx-1.5 w-full xs:basis-1/2">
                                <label for="address" class="block text-sm font-bold text-gray-700">
                                    {{ __('Address') }}
                                </label>
                                <input type="text" name="address" id="address" wire:model="address"
                                    class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                @error('address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="block sm:flex  p-2 m-auto xs:m-3 mx-0.5">
                <div class="-mt-0.5 xs:basis-1/3">
                    <button wire:click="cancelSale" wire:target="cancelSale" wire:loading.attr="disabled"
                        class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded mt-2 w-full">
                        {{ __('Cancel') }}
                    </button>
                </div>
                <div class="-mt-0.5 xs:basis-1/3 mx-0.5">
                    <button wire:click="directSale" wire:target="directSale" wire:loading.attr="disabled"
                        class="bg-blue-500 hover:bg-blue-300 text-white font-bold py-2 px-4 rounded mt-2 w-full ">
                        {{ __('Direct Sale') }}
                    </button>
                </div>
            </div> --}}
        </div>
        <div class="border-2 border-blue-300 sm:rounded-lg m-4 xs:m-3 p-4 lg:basis-1/2">
            <h2 class="mb-3 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                {{ __('Products') }}
            </h2>
            <div class="grid grid-cols-1">
                <div class="relative w-full">
                    <div class="block md:flex mt-2">
                        <select wire:model.lazy="category_id" id="category_id" name="category_id"
                            class="my-0.5 flex-shrink-0 w-full md:w-32 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium
                            text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-lg md:rounded-s-lg hover:bg-gray-200
                            focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600
                            dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                            type="button">
                            <option value="">{{ __('Select') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="relative w-full mx-1 lg:basis-1/3">
                            <input type="text" wire:model.live="searchProduct" id="searchProduct"
                                name="searchProduct"
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
                    <div class="absolute z-10 w-full bg-white rounded-lg shadow-lg mt-1" x-show="showDrop"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90" x-cloak
                        x-bind:class="{ 'block': showDrop, 'hidden': !showDrop }" wire:model="showDrop">
                        @if ($products != [])
                            @foreach ($products as $product)
                                <!-- items -->
                                <div wire:click="addProductID({{ $product->id }})"
                                    class="w-full flex p-1 pl-2 items-center hover:bg-gray-300 rounded-lg cursor-pointer">
                                    <div class="text-xs text-gray-500">
                                        <div class="font-bold text-sm">{{ __('Name') }}:
                                            {{ $product->name }}</div>
                                        <span class="mr-2">{{ __('Category') }}:
                                            {{ $product->category->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 mt-3">
                    <div class="mx-1 w-full xs:basis-1/3">
                        <label for="stockProduct" class="block text-sm font-bold text-gray-700">
                            {{ __('Stock') }}
                        </label>
                        <input type="text" name="stockProduct" id="stockProduct" disabled
                            wire:model.live="stockProduct"
                            class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                        <br>
                        @error('stockProduct')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mx-1 w-full xs:basis-1/3">
                        <label for="quantityProduct" class="block text-sm font-bold text-gray-700">
                            {{ __('Quantity') }}
                        </label>
                        <input type="text" name="quantityProduct" id="quantityProduct"
                            wire:model.live="quantityProduct"
                            class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                        <br>
                        @error('quantityProduct')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="block md:flex mt-3 md:items-center">
                    <div class="mx-1 w-full xs:basis-1/3">
                        <label for="priceProduct" class="block text-sm font-bold text-gray-700">
                            {{ __('Price') }}
                            {{ __('Product') }}
                        </label>
                        <input type="text" name="priceProduct" id="priceProduct" wire:model.live="priceProduct"
                            class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                        <br>
                        @error('priceProduct')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mx-1 w-full xs:basis-1/3">
                        <label for="totalProduct" class="block text-sm font-bold text-gray-700">
                            {{ __('Total Product') }}
                        </label>
                        <input type="text" name="totalProduct" id="totalProduct" wire:model="totalProduct"
                            class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                        <br>
                        @error('totalProduct')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="-mt-0.5 xs:basis-1/3 mx-0.5">
                    <button wire:click="addProductToSale" wire:loading.attr="disabled" wire:target="addProductToSale"
                        class="bg-blue-500 hover:bg-blue-300 text-white font-bold py-2 px-4 rounded float-right mt-2 ">
                        {{ __('Add Product') }}
                    </button>
                </div>
                <!-- linea de separacion -->
                <div class="border-t-2 border-blue-300 my-3"></div>
                <div class="block sm:flex  p-2 {{-- m-auto --}} xs:m-3 mx-0.5">
                    <div class="-mt-0.5 xs:basis-1/3">
                        <button wire:click="cancelSale" wire:target="cancelSale" wire:loading.attr="disabled"
                            class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded mt-2 w-full">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                    <div class="-mt-0.5 xs:basis-1/3 mx-0.5">
                        <button wire:click="saveSale" wire:target="saveSale" wire:loading.attr="disabled"
                            class="bg-blue-500 hover:bg-blue-300 text-white font-bold py-2 px-4 rounded mt-2 w-full ">
                            {{ __('Generate Sale') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @if ($details_products)
        <div class="w-full sm:px-6 lg:p-4 block {{-- xl:flex --}} overflow-x-auto">
            <!-- ver los detalles de la venta-->
            <div>
                <h2 class="mb-3 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    {{ __('Detail Sale') }}
                    <div class="text-xl font-bold text-gray-700">
                        {{ __('Total') }}:
                        {{ tramsform_cash($totalCarrito) }}
                    </div>
                </h2>
            </div>

            <!-- total -->

            <div class="bg-white rounded-xl shadow-xl overflow-x-auto p-1 m-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="m-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Name') }}
                            </th>
                            <th class="m-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Quantity') }}
                            </th>
                            <th class="m-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Price') }}
                            </th>
                            <th class="m-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Total') }}
                            </th>
                            <th class="m-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- items array-->
                        @foreach ($details_products as $detail_product)
                            <tr>
                                {{-- table --}}
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $detail_product['name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <!-- BOTON PARA DISMINUIR LA CANTIDAD -->
                                    <x-button type="button" class="bg-white"
                                        wire:click="decrementProduct('{{ $detail_product['product_id'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mx-auto svg-dark"
                                            viewBox="0 0 512 512">
                                            <path
                                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM184 232H328c13.3 0 24 10.7 24 24s-10.7 24-24 24H184c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
                                        </svg>
                                    </x-button>
                                    {{ $detail_product['quantity'] }}
                                    <!-- BOTON PARA AUMENTAR LA CANTIDAD -->
                                    <x-button type="button" wire:loading.attr="disabled" class="bg-white"
                                        wire:click="incrementProduct('{{ $detail_product['product_id'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mx-auto svg-dark"
                                            viewBox="0 0 512 512">
                                            <path
                                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                                        </svg>
                                    </x-button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ tramsform_cash($detail_product['price']) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ tramsform_cash($detail_product['totalProduct']) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-button type="button"
                                        wire:click="deleteProduct('{{ $detail_product['product_id'] }}')"
                                        class="bg-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                            class="w-4 h-4 mx-auto svg-dark" viewBox="0 0 448 512">
                                            <path
                                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                        </svg>
                                    </x-button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    @endif
    {{-- @dd($salesDB) --}}
    @isset($salesDB)
        <div class="border-2 border-blue-300 sm:rounded-lg m-auto xs:m-3 p-4 lg:basis-2/3">
            <h2 class="mb-3 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                {{ __('Sales') }}
            </h2>
            <div class="bg-white rounded-xl shadow-xl overflow-x-auto p-1 m-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                {{ __('Date') }}
                            </th>
                            <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                {{ __('Code') }}
                            </th>
                            <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                {{ __('Client') }}
                            </th>
                            <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                {{ __('Total') }}
                            </th>
                            <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                {{ __('User') }}
                            </th>
                            <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- items array-->
                        @foreach ($salesDB as $item)
                            <tr wire:key="sale_id-{{ $item->id }}">
                                <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                    {{ format_date($item->created_at) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                    {{ $item->serie }} -
                                    {{ $item->correlative }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    {{ $item->client->name ?? 'Sin Cliente' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ tramsform_cash($item->total) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    {{ $item->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    @if ($item->payments()->sum('amount') == $item->total)
                                        <button
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                            wire:click="printSale({{ $item->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 svg-dark"
                                                viewBox="0 0 384 512">
                                                <path
                                                    d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8V488c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488V24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96zM80 352c0 8.8 7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96z" />
                                            </svg>
                                        </button>
                                    @endif
                                    <button class="bg-amber-500 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded"
                                        wire:click="showDetails({{ $item->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 svg-dark"
                                            viewBox="0 0 576 512">
                                            <path
                                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                        </svg>
                                    </button>
                                    @if ($item->payments()->sum('amount') < $item->total)
                                        <button
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                            wire:click="openPays('{{ $item->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 svg-dark"
                                                viewBox="0 0 576 512">
                                                <path
                                                    d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z" />
                                            </svg>
                                        </button>
                                    @endif
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="deleteSale({{ $item->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                            class="w-4 h-4 mx-auto svg-dark" viewBox="0 0 448 512">
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
            <div class="mt-2">
                {{ $salesDB->links() }}
            </div>
        </div>
    @endisset

    <!-- modal para ver los detalles de la venta-->
    @isset($sale)
        <x-dialog-modal wire:model="showSale">
            <x-slot name="title">
                {{ __('Detail Sale') }}
            </x-slot>
            <x-slot name="content">
                <div class=" bg-white rounded-xl shadow-xl overflow-x-auto p-1 m-auto">
                    <div class="flex justify-between">
                        <div class="text-xl font-bold text-gray-700">
                            {{ __('Total') }}:
                            {{ tramsform_cash($sale->details->sum('total')) }}
                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <div class="flex justify-between">
                            <div class="text-xl font-bold text-gray-700">
                                {{ __('Date') }}:
                                {{ date_for_humans($sale->created_at) }}
                            </div>
                            <div class="text-xl font-bold text-gray-700">
                                {{ __('Code') }}:
                                {{ $sale->serie }} -
                                {{ $sale->correlative }}
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="text-xl font-bold text-gray-700">
                                {{ __('Client') }}:
                                {{ $sale->client->name ?? __('void') }}
                            </div>
                            <div class="text-xl font-bold text-gray-700">
                                {{ __('User') }}:
                                {{ $sale->user->name }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-xl overflow-x-auto p-1 mt-3 m-auto">
                        <h1 class="text-xl font-bold text-gray-700 text-center">
                            {{ __('Details') }}
                        </h1>
                        <table class="w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('Name') }}
                                    </th>
                                    <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('Quantity') }}
                                    </th>
                                    <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('Price') }}
                                    </th>
                                    <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('Total') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- items array-->
                                @foreach ($details_sale as $detail_sale)
                                    <tr>
                                        {{-- table --}}
                                        <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                            {{ $detail_sale->product->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            {{ $detail_sale->quantity }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                            {{ tramsform_cash($detail_sale->price_sale) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                            {{ tramsform_cash($detail_sale->total) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- pays --}}
                    <div class="bg-white rounded-xl shadow-xl overflow-x-auto p-1 mt-3 m-auto">
                        {{ __('Payments') }}
                        <table class="w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('Name') }}
                                    </th>
                                    <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('Total') }}
                                    </th>
                                    <th class="m-1 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('Registered by') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- items array-->
                                @foreach ($sale->payments as $payment)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                            {{ $payment->typePayment->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                            {{ tramsform_cash($payment->amount) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                            {{ $payment->user->name }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="mt-2">
                {{ $details_sale->links() }}
            </div> --}}
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="cancelSaleDetails" wire:loading.attr="disabled">
                    {{ __('Close') }}
                </x-secondary-button>
            </x-slot>
        </x-dialog-modal>

        <!-- modal para pagar la venta-->
    @endisset
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
                            {{-- <div class="flex justify-between">
                                <div class="text-xl font-bold text-gray-700 mx-2">
                                    {{ __('Reference') }}:
                                    <input type="text" name="reference" id="reference" wire:model="reference"
                                        class="rounded-lg border-4 border-blue-300 w-full md:max-w-xs">
                                </div>
                            </div> --}}
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

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('alert', (event) => {
                Swal.fire({
                    position: 'top-end',
                    icon: event[0].type,
                    title: event[0].message,
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        });

        function deleteSale(id) {
            Swal.fire({
                title: '¿Estas seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Si, bórralo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteSale', id);
                }
            })
        }

        function confirmDelete(id) {
            Swal.fire({
                title: '¿Estas seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Si, bórralo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteSale', id);
                }
            })
        }
    </script>
</div>
