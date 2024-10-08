<div>
    <main>
        <div class="pt-6 px-2">
            <div class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-4">
                <!-- comparacion de movimientos entre ingresos y egresos -->
                <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8  2xl:col-span-2">
                    <div class="mt-4">
                        <h1 class="mt-4 text-xl font-bold text-gray-900 mb-2">
                            {{ $chartRevenue->options['chart_title'] }}
                        </h1>
                       <div class="mt-4">
                        {!! $chartRevenue->renderHtml() !!}
                       </div>
                    </div>
                </div>
                <!-- ultimos movimientos -->
                <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('Ultimas Transacciones') }}</h3>
                            <span class="text-base font-normal text-gray-500">
                                {{ __('Lista de las ultimas transacciones') }}
                            </span>
                        </div>
                        {{-- <div class="flex-shrink-0">
                            <a href="#"
                                class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg p-2">{{ 'View all' }}</a>
                        </div> --}}
                    </div>
                    <div class="flex flex-col mt-8">
                        <div class="overflow-x-auto rounded-lg">
                            <div class="align-middle inline-block min-w-full">
                                <div class="shadow overflow-hidden sm:rounded-lg" >
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Transaction') }}
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Fecha y hora') }}
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Monto') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            @foreach ($movementCash as $item)
                                                <tr wire:key="cash-{{ $item->id }}">
                                                    <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-900">
                                                        {{ $item->name }} <span class="font-semibold">
                                                            @if ($item->type == 'I')
                                                                (Ingreso)
                                                            @else
                                                                (Egreso)
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500">
                                                        {{ date_for_humans($item->created_at) }}
                                                    </td>
                                                    <td
                                                        class="p-4 whitespace-nowrap text-sm font-semibold @if ($item->type == 'I') text-green-500

                                                        @else
                                                            text-red-500 @endif">
                                                        @if ($item->type == 'E')
                                                            -
                                                        @endif
                                                        {{ tramsform_cash($item->amount) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ultimos movimientos -->
            </div>
            {{-- <div class="mt-4 w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">2,340</span>
                            <h3 class="text-base font-normal text-gray-500">New products this week</h3>
                        </div>
                        <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                            14.6%
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">5,355</span>
                            <h3 class="text-base font-normal text-gray-500">Visitors this week</h3>
                        </div>
                        <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                            32.9%
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">385</span>
                            <h3 class="text-base font-normal text-gray-500">User signups this week</h3>
                        </div>
                        <div class="ml-5 w-0 flex items-center justify-end flex-1 text-red-500 text-base font-bold">
                            -2.7%
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="grid grid-cols-1 2xl:grid-cols-2 xl:gap-4 my-4">
                 <div class="bg-white shadow rounded-lg mb-4 p-4 sm:p-6 h-full">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold leading-none text-gray-900">Latest Customers</h3>
                        <a href="#"
                            class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg inline-flex items-center p-2">
                            View all
                        </a>
                    </div>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200">
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://demo.themesberg.com/windster/images/users/neil-sims.png"
                                            alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            Neil Sims
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="17727a767e7b57607e7973646372653974787a">[email&#160;protected]</a>
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                        $320
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://demo.themesberg.com/windster/images/users/bonnie-green.png"
                                            alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            Bonnie Green
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="d4b1b9b5bdb894a3bdbab0a7a0b1a6fab7bbb9">[email&#160;protected]</a>
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                        $3467
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://demo.themesberg.com/windster/images/users/michael-gough.png"
                                            alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            Michael Gough
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="57323a363e3b17203e3933242332257934383a">[email&#160;protected]</a>
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                        $67
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://demo.themesberg.com/windster/images/users/thomas-lean.png"
                                            alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            Thomes Lean
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="284d45494144685f41464c5b5c4d5a064b4745">[email&#160;protected]</a>
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                        $2367
                                    </div>
                                </div>
                            </li>
                            <li class="pt-3 sm:pt-4 pb-0">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://demo.themesberg.com/windster/images/users/lana-byrd.png"
                                            alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            Lana Byrd
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="a2c7cfc3cbcee2d5cbccc6d1d6c7d08cc1cdcf">[email&#160;protected]</a>
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                        $367
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div> 
                <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                    <h3 class="text-xl leading-none font-bold text-gray-900 mb-10">{{ __('Pagos mas usados') }}</h3>
                    <div class="block w-full overflow-x-auto">
                        <table class="items-center w-full bg-transparent border-collapse">
                            <thead>
                                <tr>
                                    <th
                                        class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">
                                        {{ __('Top pagos') }}</th>
                                    <th
                                        class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">
                                        {{ __('Total de pagos') }}</th>
                                    <th
                                        class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
                                        {{ __('Conteo de Pagos') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($rankingPays as $payrank)
                                    <tr class="text-gray-500">
                                        <th
                                            class="border-t-0 px-4 align-middle text-sm font-normal whitespace-nowrap p-4 text-left">
                                            {{ $payrank->name }}</th>
                                        <td
                                            class="border-t-0 px-4 align-middle text-xs font-medium text-gray-900 whitespace-nowrap p-4">
                                            {{ tramsform_cash($payrank->total) }}</td>
                                        <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                                            <div class="flex items-center">
                                                <span
                                                    class="mr-2 text-xs font-medium">{{ round($payrank->porcentaje, 2) }}
                                                    %</span>
                                                <div class="relative w-full">
                                                    <div class="w-full bg-gray-200 rounded-sm h-2">
                                                        <div class="bg-cyan-600 h-2 rounded-sm"
                                                            style="width: {{ round($payrank->porcentaje, 2) }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" {{-- integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" --}}
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var char = @json($chartRevenue->getDatasets());
        var options = @json($chartRevenue->options);
        const jsonObject = char[0].data;
        //recorrer el json de data y asignar los valores a un array
        const labels = [];
        const dataLabel = [];

        for (const item in jsonObject) {
            if (jsonObject.hasOwnProperty(item)) {
                labels.push(item);
                dataLabel.push(jsonObject[item]);
            }
        }
        const data = {
            labels: labels,
            datasets: [{
                label: char[0].name,
                backgroundColor: "blue",
                borderColor: 'rgb(0, 0, 0)',
                data: dataLabel,
                fill: false,
            }, ],
        };

        const configLineChart = {
            type: options.chart_type,
            data,
            options: {},
        };

        var chartLine = new Chart(
            document.getElementById(options.chart_name),
            configLineChart
        );
    </script>
</div>
