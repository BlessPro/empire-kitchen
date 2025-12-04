 <x-accountant-layout>
     <x-slot name="header">

     </x-slot>

                <main class="bg-[#F9F7F7] min-h-screen">
        <div class="p-3 space-y-2 sm:p-4">
             <div class="">
                 <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
                     <h2 class="text-xl font-semibold leading-tight text-gray-800">
                         {{ __('Payments & Invoice') }}
                     </h2>

                     <div class="flex items-center gap-3">
                         <a href="{{ route('accountant.Payment.Pay') }}">
                             <button
                                 class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-full text-fuchsia-800 border-fuchsia-800">
                                 <i data-feather="list"> </i>
                                 Payment
                             </button>
                         </a>

                         <div x-data="{ open:false }" class="relative">
                             <button @click="open = !open"
                                 class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border rounded-full bg-fuchsia-900 border-fuchsia-800 hover:bg-fuchsia-800">
                                 <i data-feather="plus"></i>
                                 New Invoice
                             </button>
                             <div x-cloak x-show="open" @click.away="open = false"
                                 class="absolute right-0 z-20 mt-2 bg-white border rounded-lg shadow w-44">
                                 <a href="{{ route('accountant.Invoice') }}"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100">Project Invoice</a>
                                 <a href="{{ route('accountant.Invoice.other') }}"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100">Other Invoice</a>
                             </div>
                         </div>
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
