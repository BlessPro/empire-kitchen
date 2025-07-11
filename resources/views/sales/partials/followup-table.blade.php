      @php
         $priorityClasses = [
            'High' => 'bg-red-100 text-red-700 px-2 py-1 border border-red-500 rounded-full text-xs',
            'Medium' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
            'Low' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
        ];

             $statusClasses = [
            'Completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
            'Pending' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
            'Rescheduled' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
        ];
        
              $defaultClass = 'bg-gray-100 text-gray-800';
    @endphp


<div>
     <table id="my-table-id" class="min-w-full text-sm
      text-left  rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">
            <tr>
                <th class="p-4 font-mediumt text-[15px]">Client</th>
                <th class="p-4 font-mediumt text-[15px]">Project</th>
                <th class="p-4 font-mediumt text-[15px]">Date</th>
                <th class="p-4 font-mediumt text-[15px]">Time</th>
                <th class="p-4 font-mediumt text-[15px]">Priority</th>
                <th class="p-4 font-mediumt text-[15px]">Action</th>
                <th class="p-4 font-mediumt text-[15px]">Status</th>
                <th class="p-4 font-mediumt text-[15px]">Notes</th>
            </tr>
        </thead>
        <tbody>
@forelse($followUps as $followUp)
<tr class="followup-row items-center p-2 border-t hover:bg-gray-50 cursor-pointer"
    data-id="{{ $followUp->id }}"
    data-client="{{ $followUp->client->firstname }} {{ $followUp->client->lastname }}"
    data-project="{{ $followUp->project->name ?? '—' }}"
    data-date="{{ \Carbon\Carbon::parse($followUp->follow_up_date)->format('d M, Y') }}"
    data-time="{{ \Carbon\Carbon::parse($followUp->follow_up_time)->format('h:i A') }}"
    data-notes="{{ $followUp->notes }}"
    data-status="{{ $followUp->status }}">

    <td class="p-4 font-normal text-[15px]">{{ $followUp->client->firstname }} {{ $followUp->client->lastname }}</td>
    <td class="p-4 font-normal text-[15px]">{{ $followUp->project->name ?? '—' }}</td>
    <td class="p-4 font-normal text-[15px]">{{ \Carbon\Carbon::parse($followUp->follow_up_date)->format('d M, Y') }}</td>
    <td class="p-4 font-normal text-[15px]">{{ \Carbon\Carbon::parse($followUp->follow_up_time)->format('h:i A') }}</td>
    <td class="p-2 font-normal text-[15px]">
        <span class="px-3 py-1 text-sm {{ $priorityClasses[$followUp->priority] ?? $defaultClass }}">{{ $followUp->priority }}</span>
    </td>
    <td class="p-4 font-normal text-[15px]">
        <div class="flex items-center">
            <iconify-icon icon="proicons:eye" width="26" class="text-fuchsia-700"></iconify-icon>
        </div>
    </td>
    <td class="p-2 font-normal text-[15px]">
        <span class="px-3 py-1 text-sm {{ $statusClasses[$followUp->status] ?? $defaultClass }}">{{ $followUp->status }}</span>
    </td>
    <td class="p-4 font-normal text-[15px]">{{ $followUp->notes }}</td>
</tr>
@empty
<tr>
    <td colspan="8" class="p-4 text-center text-gray-500">No follow-ups found.</td>
</tr>
@endforelse

</tbody>
    </table>
</div>
</div>



{{-- 
 <div>
 <table id="my-table-id" class="min-w-full text-sm
      text-left  rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">
            <tr>
                <th class="p-4 font-mediumt text-[15px]">Client</th>
                <th class="p-4 font-mediumt text-[15px]">Project</th>
                <th class="p-4 font-mediumt text-[15px]">Date</th>
                <th class="p-4 font-mediumt text-[15px]">Time</th>
                <th class="p-4 font-mediumt text-[15px]">Priority</th>
                <th class="p-4 font-mediumt text-[15px]">Action</th>
                <th class="p-4 font-mediumt text-[15px]">Status</th>
                <th class="p-4 font-mediumt text-[15px]">Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($followUps as $followUp)
                <tr class="followup-row items-center p-2 border-t hover:bg-gray-50">
                    <td class="p-4 font-normal text-[15px]">{{ $followUp->client->firstname }} {{ $followUp->client->lastname }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ $followUp->project->name ?? '—' }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ \Carbon\Carbon::parse($followUp->follow_up_date)->format('d M, Y') }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ \Carbon\Carbon::parse($followUp->follow_up_time)->format('h:i A') }}</td>
            <td class="p-2 font-normal text-[15px]">
            <span class="px-3 py-1 text-sm {{ $priorityClasses[$followUp->priority] ?? $defaultClass }}">{{ $followUp->priority }}</span>
            </td>
        <td class="p-4 font-normal text-[15px]">
            <div class="flex items-center ">
                <iconify-icon icon="proicons:eye" width="26"  class="text-fuchsia-700 cursor-pointer"></iconify-icon>
            </div>
        </td>

         <td class="p-2 font-normal text-[15px]">
            <span class="px-3 py-1 text-sm {{ $statusClasses[$followUp->status] ?? $defaultClass }}">{{ $followUp->status }}</span>
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
</div> --}}
    {{-- Pagination --}}
@if ($followUps->hasPages())
    <div class="mt-4 mb-5 ml-5 mr-5">
        {{ $followUps->links('pagination::tailwind') }}
    </div>
@endif


<!-- Follow-up Modal -->
<div id="followup-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center px-4">
  <div class="bg-white w-full max-w-lg rounded-xl p-6 relative shadow-xl">
    
    <!-- Close Button -->
    <button id="closeModal" class="mt-1 absolute top-3 right-4 text-2xl text-gray-500 hover:text-red-600">&times;</button>

    <!-- Header -->
    <div class="flex items-center justify-between mt-2 mr-3  ml-3">
      <h2 class="text-lg font-semibold text-gray-800" id="modal-client">Yaw Boateng</h2>
      <span id="modal-priority" class="text-sm border border-red-500 text-red-600 px-3 py-1 rounded-full">High</span>
    </div>

    <!-- Info Grid -->
    <div class="grid grid-cols-2 gap-4 mt-6 text-sm text-gray-700">
      <div>
        <p class="mb-1 font-medium">Date</p>
        <div class="flex items-center gap-2 bg-gray-100 px-3 py-2 rounded-md">
          <iconify-icon icon="solar:calendar-outline" width="18" class="text-gray-600"></iconify-icon>
          <span id="modal-date">Nov 12, 2025</span>
        </div>
      </div>
      <div>
        <p class="mb-1 font-medium">Time</p>
        <div class="flex items-center gap-2 bg-gray-100 px-3 py-2 rounded-md">
          <iconify-icon icon="solar:clock-outline" width="18" class="text-gray-600"></iconify-icon>
          <span id="modal-time">Dec 12, 2025</span>
        </div>
      </div>

      <div class="col-span-2 flex items-center gap-2 mt-2">
        <iconify-icon icon="solar:document-bold" width="20" class="text-gray-600"></iconify-icon>
        <span id="modal-project">New Build</span>
      </div>
    </div>

    <!-- Status Dropdown -->
    <div class="flex justify-end mt-4">
      <select id="modal-status" class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-700 focus:outline-none w-[150px]">
        <option value="Pending">Pending</option>
        <option value="Completed">Completed</option>
        <option value="Rescheduled">Rescheduled</option>
      </select>
    </div>

    <!-- Notes -->
    <div class="mt-6 border-t pt-4">
      <p class="text-sm font-medium mb-1">Notes</p>
      <p id="modal-notes" class="text-sm text-gray-600 leading-relaxed">
        Lorem ipsum dolor sit amet consectetur. Nunc velit orci sagittis sed consectetur mi enim facilisis volutpat...
      </p>
    </div>

    <!-- Reschedule / Save Button -->
    <div class="mt-6">
      <button id="saveFollowup" class="w-full bg-fuchsia-900 text-white py-3 rounded-lg hover:bg-purple-900 text-sm font-semibold">
        Reschedule
      </button>
    </div>
  </div>
</div>


 {{-- modal for the single followup  --}}

                    <!-- Follow-up Modal -->
{{-- <div id="followup-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-md relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl">&times;</button>
        
        <h2 class="text-lg font-semibold mb-4">Update Follow-Up</h2>

        <div class="space-y-3 text-sm">
            <p><strong>Client:</strong> <span id="modal-client"></span></p>
            <p><strong>Project:</strong> <span id="modal-project"></span></p>
            <p><strong>Date:</strong> <span id="modal-date"></span></p>
            <p><strong>Time:</strong> <span id="modal-time"></span></p>
            <p><strong>Notes:</strong> <span id="modal-notes"></span></p>
        </div>

        <div class="mt-4">
            <label for="modal-status" class="block text-sm font-medium">Update Status:</label>
            <select id="modal-status" class="w-full border border-gray-300 rounded p-2 mt-1">
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="Rescheduled">Rescheduled</option>
            </select>
        </div>

        <div class="mt-5 flex justify-end">
            <button id="saveFollowup" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>
    </div>
</div>