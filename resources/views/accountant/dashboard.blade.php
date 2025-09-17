
   <x-accountant-layout>
    <div class="p-6 text-gray-900">Welcome designer!</div>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Designer Dashboard') }}
        </h2>
    </x-slot>

<main class="ml-64 flex-1 bg-[#F9F7F7] min-h-screen  items-center">

    <div class=" pb-[24px] pr-[24px] pl-[24px] bg-[#F9F7F7]">
     <div class="">

                <h1 class="font-semibold text-[30px] mb-3"> Overview </h1>


      <!-- Overview Cards -->
      <div class="grid grid-cols-2 gap-6 mb-6">



             <div class="bg-white p-4 rounded-[15px] shadow items-center pt-6 pr-6 pb-5 pl-6">
              <li class="flex items-left">
                    <span class="flex items-center w-10 h-10 ml-1 rounded-full bg-fuchsia-900 ">
                        <i class="fa fa-money" aria-hidden="true"></i>

                 <i data-feather="dollar-sign" class="flex items-center mx-auto text-white"></i>
                    </span>
                </li>
            <div class="flex justify-between mt-8 items-left">
              <h2 class=" font-semibold text-[14px] ml-1 mb-[-10px] text-gray-500">Total Expense</h2>
            </div>
            @php
    $arrowUp1 = '<i data-feather="arrow-up" class="text-green-600"></i>';   // ▲
    $arrowDown1 = '<i data-feather="arrow-down" class="text-red-600"></i>'; // ▼
@endphp
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 ">
              <!-- Chart -->
              <div class="flex mt-2 ml-1 justify-left items-left">
              <h2 class=" font-bold text-[35px]  text-gray-900"> GH₵{{$totalExpense}}</h2>
            </div>

             <span class="flex flex-col items-center justify-center">
              <!-- Legend -->
              <ul class="items-center space-y-3">
                <li class="flex items-center">

                    @if ($percentageChangeE > 0)

    {{-- <p> --}}
        {{-- <strong>Growth:</strong> --}}
        {{-- <span style="color: green;"> --}}
            {{-- {{ number_format($percentageChange, 2) }}% {!! $arrowUp1 !!} --}}
        {{-- </span>
    </p> --}}

      <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="flex text-gray-500">  {!! $arrowUp1 !!}<span class="text-green-600">
                    {{ number_format($percentageChangeE, 2) }}%  </span>&nbsp; vs last month</p>
       </span>
@elseif ($percentageChangeE < 0)
    {{-- <p class="flex items-center w-full h-full mt-[20px] ">
        {{-- <strong>Drop:</strong> --}}
        {{-- <span style="color: green;"> --}}
            {{-- {{ number_format(abs($percentageChange), 2) }}% {!! $arrowDown1 !!} --}}

        {{-- </span>
        vs last month
    </p> --}}

    <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="flex text-gray-500">  {!! $arrowDown1 !!}<span class="text-red-600">
                    {{ number_format(abs($percentageChangeE), 2) }}%  </span>&nbsp; vs last month</p>
       </span>



@else
    <p><strong>No Change in Income</strong></p>
@endif
{{--
                    <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="flex text-gray-500"> <i data-feather="arrow-up" class="text-green-600"> </i> <span class="text-green-600"> 100% </span>&nbsp; vs last month</p>
                    </span> --}}
                </li>
             </ul>
            </span>
           </div>
         </div>



<div class="bg-white p-4 rounded-[15px] shadow items-center pt-6 pr-6 pb-5 pl-6">
              <li class="flex items-left">
                    <span class="flex items-center w-10 h-10 ml-1 bg-red-600 rounded-full ">
                        <i class="fa fa-money" aria-hidden="true"></i>

                 <i data-feather="dollar-sign" class="flex items-center mx-auto text-white"></i>
                    </span>
                </li>
            <div class="flex justify-between mt-8 items-left">
              <h2 class=" font-semibold text-[14px] ml-1 mb-[-10px] text-gray-500">Debt</h2>
            </div>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 ">
              <!-- Chart -->
              <div class="flex mt-2 ml-1 justify-left items-left">
              <h2 class=" font-semibold text-[30px]  text-gray-900">

        @php
            $debt = $totalIncome - $totalExpense;
        @endphp

        @if ($debt < 0)
            <p class="font-bold text-[35px]  text-gray-900">GH₵ {{ number_format(abs($debt), 2) }}</p>
        @else
            <p> GH₵ 00.00</p>
        @endif

              </h2>


{{-- @php
    $arrowUp = '<span style="color:green;">&#9650;</span>';   // ▲
    $arrowDown = '<span style="color:red;">&#9660;</span>';   // ▼
@endphp --}}


{{-- <i data-feather="arrow-up" class="text-green-600"> </i> <span class="text-green-600"> --}}
@php
    $arrowUp = '<i data-feather="arrow-up" class="text-green-600"></i>';   // ▲
    $arrowDown = '<i data-feather="arrow-down" class="text-red-600"></i>'; // ▼
@endphp

{{-- <p><strong>Current Month Income:</strong> GHS {{ number_format($currentMonthIncome, 2) }}</p>
<p><strong>Previous Month Income:</strong> GHS {{ number_format($previousMonthIncome, 2) }}</p> --}}




            </div>

             <span class="flex flex-col items-center justify-center">
              <!-- Legend -->
              <ul class="items-center space-y-3">
                <li class="flex items-center">
                    @if ($percentageChangeD > 0)

 <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="flex text-gray-500">  {!! $arrowUp !!}<span class="text-green-600">
                    {{ number_format($percentageChangeD, 2) }}%  </span>&nbsp; vs last month</p>
       </span>

@elseif ($percentageChangeD < 0)
   <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="flex text-gray-500">  {!! $arrowUp !!}<span class="text-red-600">
                    {{ number_format($percentageChangeD, 2) }}%  </span>&nbsp; vs last month</p>
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



    {{--the chart--}}
            @php
    $arrowUpI = '<i data-feather="arrow-up" class="text-green-600"></i>';   // ▲
    $arrowDownI = '<i data-feather="arrow-down" class="text-red-600"></i>'; // ▼
@endphp
<div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

<div class="col-span-2 p-4 bg-white rounded-[15px]  shadow">
 <div class="flex items-center justify-between w-full max-w-4xl pb-6 bg-white rounded-2xl">
  <div>
    <p class="text-lg font-semibold text-gray-700">Total Revenue</p>
    {{-- <div class="flex items-center mt-1 space-x-4"> --}}
      {{-- <h1 class="text-3xl font-bold text-gray-900">$201,221.05</h1> --}}
      {{-- <span class="flex items-center px-3 py-1 text-sm font-semibold text-green-600 bg-green-100 rounded-full">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
        8.2%
      </span>
    </div> --}}


@if ($percentageChangeI > 0)


      <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="flex text-gray-500">  {!! $arrowUpI !!}<span class="text-green-600">
                    {{ number_format($percentageChangeI, 2) }}%  </span></p>
       </span>

 <div class="flex items-center mt-1 space-x-4">
      {{-- <h1 class="text-3xl font-bold text-gray-900">$201,221.05</h1> --}}
      <span class="flex items-center px-3 py-1 text-sm font-semibold text-green-600 bg-green-100 rounded-full">
        {!! $arrowUpI !!}
 {{ number_format($percentageChangeI, 2) }}%      </span>
    </div>



@elseif ($percentageChangeI < 0)
 <div class="flex items-center mt-1 space-x-4">
      {{-- <h1 class="text-3xl font-bold text-gray-900">$201,221.05</h1> --}}
      <span class="flex items-center px-3 py-1 text-sm font-semibold text-red-600 bg-red-100 rounded-full">
        {!! $arrowDownI !!}
 {{ number_format(abs($percentageChangeI), 2) }}%      </span>
    </div>

    {{-- <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="flex text-gray-500">  {!! $arrowDownI !!}<span class="text-red-600">
                    {{ number_format(abs($percentageChangeI), 2) }}%  </span>&nbsp; vs last month</p>
       </span> --}}



@else
    <p><strong>No Change in Income</strong></p>
@endif






  </div>

  {{-- <div>
     <select class="p-2 text-sm border rounded-[10px] w-20 h-fit">
                <option>Month</option>
                <option>Week</option>
            </select>
  </div> --}}
</div>


        <div class="relative h-80">
            <canvas id="revenueChart" class="absolute w-full h-full"></canvas>
        </div>

</div>

{{--recent activities--}}

<div class="w-full max-w-md p-6 bg-white shadow-md rounded-3xl">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Recent Transactions</h2>
        <button class="text-xl text-gray-400 hover:text-gray-600">⋮</button>
    </div>

    <!-- Transaction item -->
    <div class="space-y-4">
        @foreach ($RecentIncomes as $RecentIncome)
<!-- Repeat this block for each transaction -->
        <div class="flex items-center justify-between pb-4 border-b">
            <div class="flex items-center space-x-4">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="object-cover w-12 h-12 rounded-full">
                <div>
                    <p class="font-semibold text-gray-800">{{$RecentIncome->client->title. ' ' . $RecentIncome->client->firstname.' '. $RecentIncome->client->lastname}}</p>
                    <p class="text-sm text-gray-500">{{$RecentIncome->date}}</p>
                </div>
            </div>
            <p class="font-semibold text-green-600">+ {{$RecentIncome->amount}}</p>
        </div>
        @endforeach

    </div>
</div>

</div>


{{--table--}}

{{-- <div id="followup-table-container" class="shadow-md  min-w-full mt-6 pb-[3px] text-left bg-white rounded-[20px]">
    @include('accountant.partials.dashboard-table')

</div> --}}

      </div>
</div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/accountant/Report&Analytics/incomes-data')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('revenueChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Incomes',
                            data: data, // fetched array
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
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching chart data:', error));
    });
</script>


</x-accountant-layout>
