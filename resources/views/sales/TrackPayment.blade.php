<!-- Example for sales -->
<x-sales-layout>
  <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

    <div class=" bg-[#F9F7F7] items-center">
     <div class="mb-[20px] items-center">
  @php
        $statusClasses = [
            'in progress' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
            'completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
            'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
        ];


        $defaultClass = 'bg-gray-100 text-gray-800';
    @endphp

 <div class="flex items-center justify-between mb-6">

                    <!-- Top Navbar -->
            <h1 class="text-2xl font-bold">Track Payments</h1>


 </div>
{{--table--}}

<div class="bg-white shadow-md rounded-[15px] pb-1">

      <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">
         <tr>

           <th class="p-4 font-mediumt text-[15px]">Client Name</th>
           <th class="p-4 font-mediumt text-[15px]"> Amount</th>
           <th class="p-4 font-mediumt text-[15px]">Date</th>
           <th class="p-4 font-mediumt text-[15px]">status</th>
           <th class="p-4 font-mediumt text-[15px] ">Actions</th>

         </tr>
       </thead>
       <tbody>
@foreach ($incomes as $income)
    {{-- <tr onclick="window.location.href='{{ route('sales.TrackPayment', $invoice->id) }}'"
         class="items-center p-2 border-t hover:bg-gray-50"> --}}
             <tr class="items-center p-2 border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]">{{$income->client->title.' '.$income->client->firstname.' '.$income->client->lastname}} </td>
             <td class="p-4 font-normal text-[15px]"> GHS {{ number_format($income->amount, 2) }}</td>
             <td class="p-4 font-normal text-[15px]">{{ \Carbon\Carbon::parse($income->date)->format('d M Y') }}  </td>
             <td class="p-4 font-normal text-[15px] ">
                <span class="px-3 py-1 text-sm {{ $statusClasses[$income->status] ?? $defaultClass }}">{{ $income->status}} </span>
             </td>
             <td class=" cursor-pointer p-4 font-normal text-[15px] flex items-center py-3 space-x-2 ">
                <i data-feather="eye" class="text-fuchsia-800 w-[25px] h-[25px] items-center justify-center"></i> </td>
            </tr>

@endforeach

       </tbody>

      </table>

      <div class="mt-4 mb-5 ml-5 mr-5">
        {{ $incomes->links('pagination::tailwind') }}
      </div>

</div>

            </div>

      </div>

     </div>
    </div>
</main>

</x-sales-layout>
