<div class="bg-white shadow-md rounded-[15px] pb-1">

<table class="min-w-full text-left ">
    <thead class="text-left bg-gray-100">
        <tr>
            <th class="p-4 font-mediumt text-[15px]">Client Name</th>
            <th class="p-4 font-mediumt text-[15px]">Amount</th>
            <th class="p-4 font-mediumt text-[15px]">Date</th>
            <th class="p-4 font-mediumt text-[15px]">Priority</th>
            <th class="p-4 font-mediumt text-[15px]">Actions</th>
        </tr>
    </thead>
    <tbody>

            @foreach ($followUps as $followUp)
    @php
        // Get the latest matching income for the client
        $latestIncome = $followUp->client->incomes()
            ->whereIn('status', ['pending', 'partpayment'])
            ->latest()
            ->first();
    @endphp

   {{-- <tr class="items-center p-2 border-t hover:bg-gray-50">
        <td p-4 font-normal text-[15px]">{{ $followUp->client->firstname }} {{ $followUp->client->lastname }}</td>
        <td p-4 font-normal text-[15px]">{{ $latestIncome?->amount ?? '—' }}</td>
        <td p-4 font-normal text-[15px]">{{ $latestIncome?->created_at->format('d M, Y') ?? '—' }}</td>
           <td class="p-4 font-normal text-[15px]">
            <span class="px-3 py-1 text-sm {{ $statusClasses[$followUp->priority] ?? $defaultClass }}">6{{ $followUp->priority }}</span>
            </td>
         </td>
                   <td class=" cursor-pointer p-4 font-normal text-[15px] flex items-center py-3 space-x-2 ">
        <i data-feather="eye" class="text-fuchsia-800 w-[25px] h-[25px] items-center justify-center"></i> </td>

    </tr> --}}

    <tr class="items-center p-2 border-t hover:bg-gray-50">
        <td class="p-4 font-normal text-[15px]"> {{ $followUp->client->firstname }} {{ $followUp->client->lastname }}</td>
        <td class="p-4 font-normal text-[15px]">{{ $latestIncome?->amount ?? '—' }}</td>
        <td class="p-4 font-normal text-[15px]">{{ $latestIncome?->created_at->format('d M, Y') ?? '—' }}</td>
         <td class="p-4 font-normal text-[15px]">
                {{-- {{ $followUp->priority }} --}}
            <span class="px-3 py-1 text-sm {{ $statusClasses[$followUp->priority] ?? $defaultClass }}">{{ $followUp->priority }}</span>
            </td>
                   <td class=" cursor-pointer p-4 font-normal text-[15px] flex items-center py-3 space-x-2 ">
        <i data-feather="eye" class="text-fuchsia-800 w-[25px] h-[25px] items-center justify-center"></i> </td>

    </tr>
@endforeach
    </tr>

            {{-- @forelse ($followUps as $followUp)
            @foreach ($followUp->client->incomes as $income)
                <tr class="items-center p-2 border-t hover:bg-gray-50">
                    <td class="p-4 font-normal text-[15px]">{{ $followUp->client->firstname }} {{ $followUp->client->lastname }}</td>
                    <td class="p-4 font-normal text-[15px]">₵{{ number_format($income->amount, 2) }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ \Carbon\Carbon::parse($income->created_at)->format('d M, Y') }}</td>
                    <td class="p-4 font-normal text-[15px]"> --}}
                        {{-- {{ $followUp->priority }} --}}
                    {{-- <span class="px-3 py-1 text-sm {{ $statusClasses[$followUp->priority] ?? $defaultClass }}">{{ $followUp->priority }}</span>
                    </td> --}}
                           {{-- <td class=" cursor-pointer p-4 font-normal text-[15px] flex items-center py-3 space-x-2 ">
                <i data-feather="eye" class="text-fuchsia-800 w-[25px] h-[25px] items-center justify-center"></i> </td>
                </tr>
            @endforeach
        @empty
            <tr> --}}
                {{-- <td colspan="4" class="p-4 font-normal text-[15px] text-center text-gray-500">No relevant follow-up records found.</td>
            </tr>
        @endforelse --}}
    </tbody>

</table>
@if ($followUps->hasPages())
    <div class="mt-4 mb-3 ml-3 mr-3">
        {{ $followUps->links('pagination::tailwind') }}
    </div>
@endif
</div>

