<!-- Example for sales -->
<x-sales-layout>
    <main>
        <!--head begins-->

        <div class="p-3 sm:p-4">
            <div class="mb-[20px]">
                @php
                    $statusClasses = [
                        'in progress' =>
                            'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
                        'completed' =>
                            'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
                        'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
                    ];

                    $defaultClass = 'bg-gray-100 text-gray-800';
                @endphp

                <div class="flex items-center justify-between mb-6">

                    <!-- Top Navbar -->
                    <h1 class="text-2xl font-bold">Track Payments</h1>


                </div>
                {{-- table --}}

                <div class="bg-white shadow-md rounded-[15px] pb-1">

                    <div class="overflow-x-auto">
                    <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
                        <thead class="text-sm text-gray-600 bg-gray-100">
                            <tr>

                                <th class="p-4 font-mediumt text-[15px]">Client Name</th>
                                <th class="p-4 font-mediumt text-[15px]">Location</th>
                                <th class="p-4 font-mediumt text-[15px]">Cost</th>
                                <th class="p-4 font-mediumt text-[15px]">Paid</th>
                                <th class="p-4 font-mediumt text-[15px]">Balance</th>

                                <th class="p-4 font-mediumt text-[15px]">Status</th>

                            </tr>

                        </thead>
                        <tbody>
@foreach ($clients as $row)
                                {{-- <tr onclick="window.location.href='{{ route('sales.TrackPayment', $invoice->id) }}'"
         class="items-center p-2 border-t hover:bg-gray-50"> --}}
                                <tr class="items-center p-2 border-t hover:bg-gray-50">

                                    <td class="p-4 font-normal text-[15px]">
{{ $row->client_name }}                                    </td>

                                    <td
                                        class=" cursor-pointer p-4 font-normal text-[15px] flex items-center py-3 space-x-2 ">
                                        {{ $row->location }} </td>

                                
                                    

                                    <td class="p-4 font-normal text-[15px]"> 
                                        {{ number_format($row->cost, 2) }}
                                    </td>
                                    <td class="p-4 font-normal text-[15px]"> 
                                        GHS {{ number_format($row->paid, 2) }}
                                    </td>

                                      <td class="p-4 font-normal text-[15px]"> 
                                        GHS {{ number_format($row->balance, 2) }}
                                    </td>

                                    <td class="p-4 font-normal text-[15px] ">
                                        {{-- <span
                                            class="px-3 py-1 text-sm {{ $stat[$income->status] ?? $defaultClass }}">{{ $income->status }}
                                        </span> --}}

                                         <span
                                            class="px-3 py-1 text-sm {{ $statusClasses[$row->status] ?? $defaultClass }}">
{{ $row->status }}                                        </span>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                    </div>

                    <div class="mt-4 mb-5 ml-5 mr-5">
                        {{ $clients->links('pagination::tailwind') }}
                    </div>

                </div>

            </div>

        </div>
    </main>

</x-sales-layout>
