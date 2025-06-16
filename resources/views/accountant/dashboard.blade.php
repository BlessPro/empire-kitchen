
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
                    <span class="ml-1 flex items-center w-10 h-10 bg-fuchsia-900 rounded-full ">
                        <i class="fa fa-money" aria-hidden="true"></i>

                 <i data-feather="dollar-sign" class="flex items-center mx-auto text-white"></i>
                    </span>
                </li>
            <div class="flex items-left justify-between mt-8">
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
                <p class="text-gray-500 flex">  {!! $arrowUp1 !!}<span class="text-green-600">
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
                <p class="text-gray-500 flex">  {!! $arrowDown1 !!}<span class="text-red-600">
                    {{ number_format(abs($percentageChangeE), 2) }}%  </span>&nbsp; vs last month</p>
       </span>



@else
    <p><strong>No Change in Income</strong></p>
@endif
{{--
                    <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="text-gray-500 flex"> <i data-feather="arrow-up" class="text-green-600"> </i> <span class="text-green-600"> 100% </span>&nbsp; vs last month</p>
                    </span> --}}
                </li>
             </ul>
            </span>
           </div>
         </div>



<div class="bg-white p-4 rounded-[15px] shadow items-center pt-6 pr-6 pb-5 pl-6">
              <li class="flex items-left">
                    <span class="ml-1 flex items-center w-10 h-10 bg-red-600 rounded-full ">
                        <i class="fa fa-money" aria-hidden="true"></i>

                 <i data-feather="dollar-sign" class="flex items-center mx-auto text-white"></i>
                    </span>
                </li>
            <div class="flex items-left justify-between mt-8">
              <h2 class=" font-semibold text-[14px] ml-1 mb-[-10px] text-gray-500">Debt</h2>
            </div>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 ">
              <!-- Chart -->
              <div class="flex mt-2 ml-1 justify-left items-left">
              <h2 class=" font-bold text-[35px]  text-gray-900">

@php
    $debt = $totalIncome - $totalExpense;
@endphp

@if ($debt < 0)
    <p><strong>Debt:</strong> GH₵ {{ number_format(abs($debt), 2) }}</p>
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
    <p>
        {{-- <strong>Growth:</strong> --}}
        <span style="color: green;">
            {{ number_format($percentageChangeD, 2) }}% {!! $arrowUp !!}
        </span>
    </p>
@elseif ($percentageChangeD < 0)
    <p class="flex items-center w-full h-full mt-[20px] ">
        {{-- <strong>Drop:</strong> --}}
        <span style="color: red;">
            {{ number_format(abs($percentageChangeD), 2) }}% {!! $arrowDown !!}
        </span>
    </p>
@else
    <p><strong>No Change in Income</strong></p>
@endif
                    {{-- <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="text-gray-500 flex"> <i data-feather="arrow-up" class="text-green-600"> </i> <span class="text-green-600"> 100% </span>&nbsp; vs last month</p>
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
 <div class="flex justify-between items-center bg-white  rounded-2xl pb-6 w-full max-w-4xl">
  <div>
    <p class="text-gray-700 font-semibold text-lg">Total Revenue</p>
    {{-- <div class="flex items-center space-x-4 mt-1"> --}}
      {{-- <h1 class="text-3xl font-bold text-gray-900">$201,221.05</h1> --}}
      {{-- <span class="flex items-center px-3 py-1 bg-green-100 text-green-600 text-sm font-semibold rounded-full">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
        8.2%
      </span>
    </div> --}}


@if ($percentageChangeI > 0)


      <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="text-gray-500 flex">  {!! $arrowUpI !!}<span class="text-green-600">
                    {{ number_format($percentageChangeI, 2) }}%  </span></p>
       </span>

 <div class="flex items-center space-x-4 mt-1">
      {{-- <h1 class="text-3xl font-bold text-gray-900">$201,221.05</h1> --}}
      <span class="flex items-center px-3 py-1 bg-green-100 text-green-600 text-sm font-semibold rounded-full">
        {!! $arrowUpI !!}
 {{ number_format($percentageChangeI, 2) }}%      </span>
    </div>



@elseif ($percentageChangeI < 0)
 <div class="flex items-center space-x-4 mt-1">
      {{-- <h1 class="text-3xl font-bold text-gray-900">$201,221.05</h1> --}}
      <span class="flex items-center px-3 py-1 bg-red-100 text-red-600 text-sm font-semibold rounded-full">
        {!! $arrowDownI !!}
 {{ number_format(abs($percentageChangeI), 2) }}%      </span>
    </div>

    {{-- <span class="flex items-center w-full h-full mt-[20px] ">
                <p class="text-gray-500 flex">  {!! $arrowDownI !!}<span class="text-red-600">
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


{{--testing code--}}


















{{--recent activities--}}

<div class="bg-white rounded-3xl shadow-md p-6 w-full max-w-md">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Recent Transactions</h2>
        <button class="text-gray-400 hover:text-gray-600 text-xl">⋮</button>
    </div>

    <!-- Transaction item -->
    <div class="space-y-4">
        @foreach ($RecentIncomes as $RecentIncome)
<!-- Repeat this block for each transaction -->
        <div class="flex justify-between items-center border-b pb-4">
            <div class="flex items-center space-x-4">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="w-12 h-12 rounded-full object-cover">
                <div>
                    <p class="text-gray-800 font-semibold">{{$RecentIncome->client->title. ' ' . $RecentIncome->client->firstname.' '. $RecentIncome->client->lastname}}</p>
                    <p class="text-sm text-gray-500">{{$RecentIncome->date}}</p>
                </div>
            </div>
            <p class="text-green-600 font-semibold">+ {{$RecentIncome->amount}}</p>
        </div>
        @endforeach







    </div>
</div>

</div>


{{--table--}}

<div class="shadow-md  min-w-full mt-6 pb-[3px] text-left bg-white rounded-[20px]">

      <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">

         <tr>

           <th class="p-4 font-mediumt text-[15px]">Client Name</th>
           <th class="p-4 font-mediumt text-[15px]">Amount</th>
           <th class="p-4 font-mediumt text-[15px]">Due Date</th>
           <th class="p-4 font-mediumt text-[15px]">Status</th>

         </tr>
       </thead>
       <tbody>


         @foreach ($DashboardIncomeTables as $DashboardIncomeTable)
         <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]">{{$DashboardIncomeTable->client->title.' '.$DashboardIncomeTable->client->firstname.' '.$DashboardIncomeTable->client->lastname}} </td>
             <td class="p-4 font-normal text-[15px]">{{$DashboardIncomeTable->amount}}</td>
             <td class="p-4 font-normal text-[15px]"> {{$DashboardIncomeTable->date}}</td>
             <td class="inline-block text-[15px] bg-blue-100 text-blue-700 mt-3 px-4 py-[3px] border border-blue-500 rounded-full"> Pending payment </td>
            </tr>
        @endforeach

       </tbody>
      </table>

      <div class="mt-4 mb-2 ml-5 mr-2">
        {{$DashboardIncomeTables->links('pagination::tailwind') }}
      </div>

</div>




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
