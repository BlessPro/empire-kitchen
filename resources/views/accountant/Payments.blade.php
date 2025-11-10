 <x-accountant-layout>
     <x-slot name="header">
   
     </x-slot>

     {{-- <main class="ml-64 flex-1 bg-[#F9F7F7] min-h-screen  items-center">

         <div class=" pb-[24px] pr-[24px] pl-[24px] bg-[#F9F7F7]"> --}}
            


                <main class="bg-[#F9F7F7] min-h-screen">
        <div class="p-3 space-y-2 sm:p-4">
             <div class="">
                 <div class="flex items-center justify-between mb-6">

                     <!-- Top Navbar -->
                     <h1 class="text-2xl font-bold">Payments & Invoice</h1>

                     <div class="flex items-center space-x-4">
                         <a href="{{ route('accountant.Payment.Pay') }}">
                             <button
                                 class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-full text-fuchsia-800 border-fuchsia-800">
                                 <i data-feather="list"> </i>
                                 Payment
                             </button>
                         </a>
                         <button onclick="window.location='{{ route('accountant.Invoice') }}'" id="openMeasurementModal"
                             class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border border-purple-800 rounded-full bg-fuchsia-900">
                             <i data-feather="plus" class="text-white"> </i>
                             New Invoice
                         </button>
                     </div>
                 </div>


                 {{-- table --}}
                 <div class="shadow-md rounded-[15px]">

                     <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
                         <thead class="text-sm text-gray-600 bg-gray-100">
                             <tr>

                                 <th class="p-4 font-mediumt text-[15px]">Client Name</th>
                                 <th class="p-4 font-mediumt text-[15px]">Invoice ID</th>
                                 <th class="p-4 font-mediumt text-[15px]">Amount</th>
                                 <th class="p-4 font-mediumt text-[15px]">Due Date</th>
                                 <th class="p-4 font-mediumt text-[15px]">Actions</th>

                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($invoices as $invoice)
                                 <tr onclick="window.location.href='{{ route('accountant.Invoice.Invoiceview', $invoice->id) }}'"
                                     class="items-center p-2 border-t hover:bg-gray-50">
                                     <td class="p-4 font-normal text-[15px]">
                                         {{ $invoice->client->title . ' ' . $invoice->client->firstname . ' ' . $invoice->client->lastname }}
                                     </td>
                                     <td class="p-4 font-normal text-[15px]"> {{ $invoice->invoice_code }}</td>
                                     <td class="p-4 font-normal text-[15px]">GHS
                                         {{ number_format($invoice->summary->total_amount, 2) }} </td>
                                     <td class="p-4 font-normal text-[15px]">
                                         {{ \Carbon\Carbon::parse($invoice->date)->format('d M Y') }}</td>
                                     <td
                                         class=" cursor-pointer p-4 font-normal text-[15px] flex items-center py-3 space-x-2">
                                         <i data-feather="eye"
                                             class="text-fuchsia-800 w-[25px] h-[25px] items-center justify-center"></i>
                                     </td>
                                 </tr>
                             @endforeach

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
