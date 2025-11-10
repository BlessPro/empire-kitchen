@php
    $statusClasses = [
        'Sold' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
        'Unsold' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
    ];

    $defaultClass = 'bg-gray-100 text-gray-800';
@endphp


<div>
    <table id="my-table-id" class="min-w-full text-sm text-left rounded-[20px]">
        <thead class="text-sm text-gray-600 bg-gray-100">
            <tr>
                <th class="p-4 font-mediumt text-[15px]">Client</th>
                <th class="p-4 font-mediumt text-[15px]">Date</th>
                <th class="p-4 font-mediumt text-[15px]">Status</th>
                <th class="p-4 font-mediumt text-[15px]">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($followUps as $followUp)
                @php
                    $clientDisplay = trim($followUp->client_name ?? (($followUp->client->firstname ?? '') . ' ' . ($followUp->client->lastname ?? '')));
                    if ($clientDisplay === '') {
                        $clientDisplay = 'N/A';
                    }
                    $projectDisplay = $followUp->project->name ?? 'No Project';
                @endphp
                <tr class="followup-row items-center p-2 border-t hover:bg-gray-50"
                    data-id="{{ $followUp->id }}"
                    data-client="{{ e($clientDisplay) }}"
                    data-project="{{ e($projectDisplay) }}"
                    data-date="{{ \Carbon\Carbon::parse($followUp->follow_up_date)->format('d M, Y') }}"
                    data-time="{{ \Carbon\Carbon::parse($followUp->follow_up_time)->format('h:i A') }}"
                    data-notes="{{ e($followUp->notes ?? '') }}"
                    data-priority="{{ e($followUp->priority) }}"
                    data-status="{{ $followUp->status }}">

                    <td class="p-4 font-normal text-[15px]">
                        {{ $clientDisplay }}
                    </td>
                    <td class="p-4 font-normal text-[15px]">
                        {{ \Carbon\Carbon::parse($followUp->follow_up_date)->format('d M, Y') }}
                    </td>
                    <td class="p-4 font-normal text-[15px]">
                        <span data-status-pill
                            class="px-3 py-1 text-sm {{ $statusClasses[$followUp->status] ?? $defaultClass }}">
                            {{ $followUp->status }}
                        </span>
                    </td>
                    <td class="p-4 font-normal text-[15px] flex space-x-2">
                        <button type="button" class="followup-view flex items-center text-fuchsia-700" data-id="{{ $followUp->id }}">
                            <iconify-icon icon="proicons:eye" width="26"></iconify-icon>
                        </button>

                         <button type="button" class="followup-view flex items-center text-fuchsia-700" data-id="{{ $followUp->id }}">
                            <iconify-icon icon="solar:alarm-linear" width="26"></iconify-icon>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">No follow-ups found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($followUps->hasPages())
    <div class="mt-4 mb-5 ml-5 mr-5">
        {{ $followUps->links('pagination::tailwind') }}
    </div>
@endif


