<x-accountant-layout>

    <x-slot name="header">

    </x-slot>

    <main class="bg-[#F9F7F7] min-h-screen">
        <div class="p-3 space-y-2 sm:p-4">

            <h1 class="text-2xl font-semibold text-gray-900">Overview</h1>

            <!-- Overview Cards -->
            <div class="grid gap-2 md:grid-cols-2">



                <div class="bg-white rounded-[15px] shadow items-center p-4">
                        <li class="flex items-left">
                            <span class="flex items-center w-10 h-10 ml-1 rounded-full bg-fuchsia-900 ">
                                <i class="fa fa-money" aria-hidden="true"></i>

                                <i data-feather="dollar-sign" class="flex items-center mx-auto text-white"></i>
                            </span>
                        </li>
                        <div class="flex justify-between mt-3 items-left">
                            <h2 class=" font-semibold text-[14px] ml-1 mb-[-10px] text-gray-500">Total Expense</h2>
                        </div>
                        @php
                            $arrowUp1 = '<i data-feather="arrow-up" class="text-green-600"></i>'; // ▲
                            $arrowDown1 = '<i data-feather="arrow-down" class="text-red-600"></i>'; // ▼
                        @endphp
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 ">
                            <!-- Chart -->
                            <div class="flex mt-2 ml-1 justify-left items-left">
                                <h2 class="font-bold text-[30px] text-gray-900"> GH₵{{ $totalExpense }}</h2>
                            </div>

                            <span class="flex flex-col items-center justify-center">
                                <!-- Legend -->
                                <ul class="items-center space-y-2">
                                    <li class="flex items-center">

                                        @if ($percentageChangeE > 0)

                                            <span class="flex items-center w-full h-full mt-2">
                                                <p class="flex text-gray-500"> {!! $arrowUp1 !!}<span
                                                        class="text-green-600">
                                                        {{ number_format($percentageChangeE, 2) }}% </span>&nbsp; vs
                                                    last month</p>
                                            </span>
                                        @elseif ($percentageChangeE < 0)
                                            <span class="flex items-center w-full h-full mt-2">
                                                <p class="flex text-gray-500"> {!! $arrowDown1 !!}<span
                                                        class="text-red-600">
                                                        {{ number_format(abs($percentageChangeE), 2) }}% </span>&nbsp;
                                                    vs last month</p>
                                            </span>
                                        @else
                                            <p><strong>No Change in Income</strong></p>
                                        @endif
                                    </li>
                                </ul>
                            </span>
                        </div>
                    </div>



                <div class="bg-white rounded-[15px] shadow items-center p-4">
                        <li class="flex items-left">
                            <span class="flex items-center w-10 h-10 ml-1 bg-red-600 rounded-full ">
                                <i class="fa fa-money" aria-hidden="true"></i>

                                <i data-feather="dollar-sign" class="flex items-center mx-auto text-white"></i>
                            </span>
                        </li>
                        <div class="flex justify-between mt-3 items-left">
                            <h2 class=" font-semibold text-[14px] ml-1 mb-[-10px] text-gray-500">Debt</h2>
                        </div>
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 ">
                            <!-- Chart -->
                            <div class="flex mt-2 ml-1 justify-left items-left">
                                <h2 class=" font-semibold text-[30px]  text-gray-900">

                                    @php
                                        $debt = $totalIncome - $totalExpense;
                                    @endphp

                                    @if ($debt < 0)
                                        <p class="font-bold text-[30px]  text-gray-900">GH₵
                                            {{ number_format(abs($debt), 2) }}</p>
                                    @else
                                        <p class="font-bold text-[26px] text-gray-900">GH₵ 0.00</p>
                                    @endif

                                </h2>
                            </div>
                                @php
                                    $arrowUp = '<i data-feather="arrow-up" class="text-green-600"></i>'; // ▲
                                    $arrowDown = '<i data-feather="arrow-down" class="text-red-600"></i>'; // ▼
                                @endphp






                            </div>

                            <span class="flex flex-col items-center justify-center">
                                <!-- Legend -->
                                <ul class="items-center space-y-2">
                                    <li class="flex items-center">
                                        @if ($percentageChangeD > 0)
                                            <span class="flex items-center w-full h-full mt-2">
                                                <p class="flex text-gray-500"> {!! $arrowUp !!}<span
                                                        class="text-green-600">
                                                        {{ number_format($percentageChangeD, 2) }}% </span>&nbsp; vs
                                                    last month</p>
                                            </span>
                                        @elseif ($percentageChangeD < 0)
                                            <span class="flex items-center w-full h-full mt-2">
                                                <p class="flex text-gray-500"> {!! $arrowUp !!}<span
                                                        class="text-red-600">
                                                        {{ number_format($percentageChangeD, 2) }}% </span>&nbsp; vs
                                                    last month</p>
                                            </span>
                                        @else
                                            <p><strong>No Change in Income</strong></p>
                                        @endif
                                        {{-- <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="flex text-gray-500"> <i data-feather="arrow-up" class="text-green-600"> </i> <span class="text-green-600"> 100% </span>&nbsp; vs last month</p>
                    </span> --}}
                                    </li>
                                </ul>
                            </span>
                        </div>
                    </div>


                </div>



                {{-- Total Revenue --}}
                @php
                    $arrowUpI = '<i data-feather="arrow-up" class="text-green-600"></i>'; // ▲
                    $arrowDownI = '<i data-feather="arrow-down" class="text-red-600"></i>'; // ▼
                @endphp
                <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">

                    <div class="col-span-2 p-[24px] bg-white shadow rounded-[15px]">
                        <div class="flex flex-col items-start justify-between w-full gap-3 pb-3 bg-white rounded-2xl sm:flex-row sm:items-center">
                            <div>
                                <p class="text-lg font-semibold text-gray-700">Total Revenue</p>
                                @if ($percentageChangeI > 0)
                                    <span class="flex items-center gap-2 mt-2 text-sm text-gray-500">
                                        {!! $arrowUpI !!}
                                        <span class="font-semibold text-green-600">
                                            {{ number_format($percentageChangeI, 2) }}%
                                        </span>
                                    </span>
                                @elseif ($percentageChangeI < 0)
                                    <span class="flex items-center gap-2 mt-2 text-sm text-gray-500">
                                        {!! $arrowDownI !!}
                                        <span class="font-semibold text-red-600">
                                            {{ number_format(abs($percentageChangeI), 2) }}%
                                        </span>
                                    </span>
                                @else
                                    <p class="mt-2 text-sm text-gray-500"><strong>No Change in Income</strong></p>
                                @endif






                            </div>

                            {{-- <div>
     <select class="p-2 text-sm border rounded-[10px] w-20 h-fit">
                <option>Month</option>
                <option>Week</option>
            </select>
  </div> --}}
                        </div>


                        <div class="relative h-64">
                            <canvas id="revenueChart" class="absolute inset-0 w-full h-full"></canvas>
                        </div>

                    </div>

                    {{-- recent activities --}}

                    <div class="w-full max-w-md p-4 bg-white shadow-md rounded-3xl">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-lg font-semibold text-gray-800">Recent Transactions</h2>
                            <button class="text-xl text-gray-400 hover:text-gray-600">⋮</button>
                        </div>

                        <!-- Transaction item -->
                        <div class="space-y-2">
                            @foreach ($RecentIncomes as $RecentIncome)
                                <!-- Repeat this block for each transaction -->
                                <div class="flex items-center justify-between pb-3 border-b">
                                    <div class="flex items-center space-x-2">
                                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User"
                                            class="object-cover w-10 h-10 rounded-full">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">
                                                {{ $RecentIncome->client->title . ' ' . $RecentIncome->client->firstname . ' ' . $RecentIncome->client->lastname }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $RecentIncome->date }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm font-semibold text-green-600">+ {{ $RecentIncome->amount }}</p>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>


                {{-- table --}}

                {{-- <div id="followup-table-container" class="shadow-md  min-w-full mt-6 pb-[3px] text-left bg-white rounded-[20px]">
    @include('accountant.partials.dashboard-table')

</div> --}}

            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revenueCanvas = document.getElementById('revenueChart');
            if (!revenueCanvas || typeof Chart === 'undefined') {
                console.warn('Revenue chart skipped: canvas element or Chart.js not available.');
                return;
            }

            const monthlyIncomeData = (@json($monthlyIncomeChartData ?? []))
                .map(value => Number.parseFloat(value) || 0);

            const ctx = revenueCanvas.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                        'Oct', 'Nov', 'Dec'
                    ],
                    datasets: [{
                        label: 'Incomes',
                        data: monthlyIncomeData,
                        borderColor: '#6D28D9',
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(109, 40, 217, 0.1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>


</x-accountant-layout>
