<div class="bg-white shadow-md rounded-[15px] pb-1">

<table class="min-w-full text-left ">
    <thead class="text-left bg-gray-100">
        <tr>
            <th class="p-4 font-mediumt text-[15px]">Client</th>
            <th class="p-4 font-mediumt text-[15px]">Due Date</th>
            <th class="p-4 font-mediumt text-[15px]">Priority</th>
            <th class="p-4 font-mediumt text-[15px]">Status</th>
        </tr>
    </thead>
    <tbody>

        @forelse ($recentFollowUps as $followUp)
            @php
                $clientModel = $followUp->client;
                $clientDisplay = trim($followUp->client_name ?? (($clientModel->firstname ?? '') . ' ' . ($clientModel->lastname ?? '')));
                if ($clientDisplay === '') {
                    $clientDisplay = 'N/A';
                }

                $latestIncome = $clientModel
                    ? $clientModel->incomes()
                        ->whereIn('status', ['pending', 'partpayment'])
                        ->latest()
                        ->first()
                    : null;

                $priorityClasses = [
                    'High' => 'bg-red-100 text-red-700 px-2 py-1 border border-red-500 rounded-full text-xs',
                    'Medium' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
                    'Low' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
                ];
                $priorityBadge = $priorityClasses[$followUp->priority] ?? 'bg-gray-100 text-gray-800 px-2 py-1 border border-gray-300 rounded-full text-xs';
            @endphp

            <tr class="items-center p-2 border-t hover:bg-gray-50">
                <td class="p-4 font-normal text-[15px]">{{ $followUp->client_name }}</td>
                <td class="p-4 font-normal text-[15px]">{{ \Carbon\Carbon::parse($followUp->follow_up_date)->format('M d, Y') }}</td>
                <td class="p-4 font-normal text-[15px]">
                <span class="@if($followUp->priority === 'High') text-red-600
                            @elseif($followUp->priority === 'Medium') text-yellow-600
                            @else text-blue-600 @endif font-medium">
                {{ $followUp->priority }}
              </span>                </td>
                <td class="cursor-pointer p-4 font-normal text-[15px] flex items-center py-3 space-x-2">
                <span class="@if($followUp->status === 'Sold') bg-green-100 text-green-700
                            @elseif($followUp->status === 'Unsold') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif
                            px-3 py-1 rounded-full text-xs font-semibold">
                {{ $followUp->status }}
              </span>                </td>
            </tr>
        @endforeach
    </tbody>

</table>
 {{-- Only render pagination if it's a paginator --}}
  @if ($followUps instanceof \Illuminate\Pagination\LengthAwarePaginator && $followUps->hasPages())
    <div class="mt-4 mb-3 ml-3 mr-3">
      {{ $followUps->links('pagination::tailwind') }}
    </div>
  @endif
</div>
