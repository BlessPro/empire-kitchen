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
     <div class="flex items-center justify-between mb-6">

                    <!-- Top Navbar -->
            <h1 class="text-2xl font-bold">Reports and Analytics</h1>

            <button onclick="window.location='{{ route('accountant.Invoice')}}'"
     id="openMeasurementModal"  class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-fuchsia-900 border border-purple-800 rounded-full">
                <i data-feather="plus" class="text-white"> </i>
                    New Invoice
            </button>
             {{-- <button
    onclick="window.location='{{ route('tech.CreateMeasurement',['project' => $project->id]) }}'"
     id="openMeasurementModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
     + Add Measurement
 </button> --}}
      </div>







{{--table--}}

<div class="shadow-md rounded-[15px]">

      <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">
         <tr>

           <th class="p-4 font-mediumt text-[15px]">Client Name</th>
           <th class="p-4 font-mediumt text-[15px]">Invoice ID</th>
           <th class="p-4 font-mediumt text-[15px]">Amount</th>
           <th class="p-4 font-mediumt text-[15px]">Payment Method</th>
           <th class="p-4 font-mediumt text-[15px]">Due Date</th>
           <th class="p-4 font-mediumt text-[15px]">Actions</th>

         </tr>
       </thead>
       <tbody>

        <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0010 </td>
             <td class="p-4 font-normal text-[15px]">78989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Cash </td>
             <td class="p-4 font-normal text-[15px]"> 5th October,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>

              <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0011 </td>
             <td class="p-4 font-normal text-[15px]">8989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Credit Card </td>
             <td class="p-4 font-normal text-[15px]"> 5th June,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>

              <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0010 </td>
             <td class="p-4 font-normal text-[15px]">78989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Bank Transfer </td>
             <td class="p-4 font-normal text-[15px]"> 11th Apil,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>

              <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0010 </td>
             <td class="p-4 font-normal text-[15px]">78989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Cash </td>
             <td class="p-4 font-normal text-[15px]"> 5th October,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>

             <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0011 </td>
             <td class="p-4 font-normal text-[15px]">8989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Credit Card </td>
             <td class="p-4 font-normal text-[15px]"> 5th June,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>

            <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0010 </td>
             <td class="p-4 font-normal text-[15px]">78989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Cash </td>
             <td class="p-4 font-normal text-[15px]"> 5th October,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>

             <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0010 </td>
             <td class="p-4 font-normal text-[15px]">78989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Cash </td>
             <td class="p-4 font-normal text-[15px]"> 5th October,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>

              <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0011 </td>
             <td class="p-4 font-normal text-[15px]">8989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Credit Card </td>
             <td class="p-4 font-normal text-[15px]"> 5th June,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>

              <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0010 </td>
             <td class="p-4 font-normal text-[15px]">78989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Cash </td>
             <td class="p-4 font-normal text-[15px]"> 5th October,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>

            <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0010 </td>
             <td class="p-4 font-normal text-[15px]">78989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Cash </td>
             <td class="p-4 font-normal text-[15px]"> 5th October,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>

              <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0011 </td>
             <td class="p-4 font-normal text-[15px]">8989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Credit Card </td>
             <td class="p-4 font-normal text-[15px]"> 5th June,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>


                      <tr class="border-t hover:bg-gray-50 items-center p-2">
             <td class="p-4 font-normal text-[15px]">Samuel Amankwah </td>
             <td class="p-4 font-normal text-[15px]">0010 </td>
             <td class="p-4 font-normal text-[15px]">78989 </td>
             <td class="p-4 font-normal text-[15px] items-center">Cash </td>
             <td class="p-4 font-normal text-[15px]"> 5th October,2025</td>
             <td class="p-4 font-normal text-[15px] flex items-center py-3 space-x-2"> </td>
            </tr>
       </tbody>

      </table>

      <div class="mt-4 mb-5 ml-5 mr-5">
        {{-- {{ $projects->links('pagination::tailwind') }} --}}
      </div>

</div>











      </div>
</div>
</main>

 </x-accountant-layout>
