 
 <div>
 <table class="min-w-full text-sm
      text-left  rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">
            <tr>
                <th class="p-4 font-mediumt text-[15px]">Client</th>
                <th class="p-4 font-mediumt text-[15px]">Project</th>
                <th class="p-4 font-mediumt text-[15px]">Date</th>
                <th class="p-4 font-mediumt text-[15px]">Time</th>
                <th class="p-4 font-mediumt text-[15px]">Priority</th>
                <th class="p-4 font-mediumt text-[15px]">Status</th>
                <th class="p-4 font-mediumt text-[15px]">Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($followUps as $followUp)
                <tr class="items-center p-2 border-t hover:bg-gray-50">
                    <td class="p-4 font-normal text-[15px]">{{ $followUp->client->firstname }} {{ $followUp->client->lastname }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ $followUp->project->name ?? '—' }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ \Carbon\Carbon::parse($followUp->follow_up_date)->format('d M, Y') }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ \Carbon\Carbon::parse($followUp->follow_up_time)->format('h:i A') }}</td>
                    <td class="p-4 font-normal text-[15px]">
                        <span class="px-2 py-1 rounded text-white
                            {{ $followUp->priority == 'High' ? 'bg-red-600' : ($followUp->priority == 'Medium' ? 'bg-yellow-500' : 'bg-green-600') }}">
                            {{ $followUp->priority }}
                        </span>
                    </td>
                    <td class="p-4 font-normal text-[15px]">
                        <span class="text-sm font-medium {{ $followUp->status == 'Pending' ?
                         'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs'
                         : ($followUp->status == 'Completed' ?
                         'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs'
                         : ($followUp->status == 'Rescheduled' ?
                         'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs' : '')) }}">
                            {{ $followUp->status }}

                        </span>
                    </td>
                    <td class="p-4 font-normal text-[15px]">{{ $followUp->notes }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">No follow-ups found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
    {{-- Pagination --}}
@if ($followUps->hasPages())
    <div class="mt-4 mb-5 ml-5 mr-5">
        {{ $followUps->links('pagination::tailwind') }}
    </div>
@endif
 {{-- <div class="mt-4 mb-5 ml-5 mr-5">
                        {{ $projects->links('pagination::tailwind') }}
                    </div> --}}
