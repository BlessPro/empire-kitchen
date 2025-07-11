   <x-tech-layout>
    <x-slot name="header">
        @include('admin.layouts.header')

    </x-slot>

        @php
        $statusClasses = [
            'in progress' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
            'completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
            'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
        ];


        $defaultClass = 'bg-gray-100 text-gray-800';
    @endphp
          <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class=" bg-[#F9F7F7]">
             <div class="mb-[20px]">

   {{-- navigation bar --}}
   <div class="flex items-center justify-between mb-6">
    <div class="flex items-center justify-between mb-6">
     <span><i data-feather="home" class="w-[5] h-[5] text-fuchsia-900 ml-[3px]"></i></span>
     <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
     <a href="{{ route('tech.ClientManagement') }}">
        <h3 class="font-sans font-normal text-black cursor-pointer hover:underline">Clients Management</h3>
    </a>

         <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
        </h3>

        <span><span class="mr-[12px] font-normal text-black-900">{{$project->client->title . ' '.$project->client->firstname . ' '.$project->client->lastname }}</span> </span>
        <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
        <h3 class="font-semibold text-fuchsia-900">{{ $project->name}}</h3>

    </div>

 <button
onclick="window.location='{{ route('tech.CreateMeasurement',['project' => $project->id]) }}'"
     id="openMeasurementModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
     + Add Measurement
 </button>



     </div>
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <!-- Left Section: Project Info -->
                        <div class="p-6 bg-white shadow lg:col-span-2 rounded-xl">
                          <!-- Breadcrumbs -->

                          <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-semibold text-gray-800 mr-[12px] ">{{ $project->name}}</h2>

<span onclick="openStatusModal('{{ $project->id }}', '{{ $project->status }}', event)"
    class="cursor-pointer inline-block mt-1 px-3 py-0.5 text-xs {{ $statusClasses[$project->status] ?? $defaultClass }}">
    {{ ucfirst($project->status) }}
</span>

                 </div>

                             </div>

                          <!-- Project Details -->
                          <div class="mt-6 space-y-4 text-sm text-gray-700">

                            <div class="flex items-center gap-2 relative pl-[2px-]" x-data="{ showCalendar: false, selectedDate: '{{ $project->due_date }}' }">
                               <iconify-icon icon="ep:clock" width="22" style="color: #5A0562;"></iconify-icon>
                              <span class="font-medium">Due Date:</span>
<div x-data="{
        showCalendar: false,
        selectedDate: '{{ $project->due_date }}',
        tempDate: '{{ $project->due_date }}',
        updateDueDate(date) {
            fetch('/tech/project/{{ $project->id }}/update-due-date', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ due_date: date })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.selectedDate = date;
                    this.showCalendar = false;
                } else {
                    alert('Update failed');
                }
            });
        }
    }"
    class="relative flex items-center gap-2"
>
    {{-- <span class="font-medium">Due Date:</span> --}}

    <!-- Clickable Text to Open -->
    <div class="border-1 border-dotted">
    <span @click="tempDate = selectedDate; showCalendar = true"
          class="cursor-pointer text-blue-800 underline"
          x-text="new Date(selectedDate).toLocaleDateString()">
          <input type="date" name="" id="">
    </span>
</div>
    <!-- Date Picker Dropdown -->
    <div x-show="showCalendar"
         x-transition
         @click.away="showCalendar = false"
         class="absolute z-50 mt-2 bg-white rounded-xl shadow-xl border w-72 p-4"
         style="top: 100%; left: 0;"
    >
        <div class="text-center font-semibold text-lg mb-2 text-gray-800">
            <span x-text="new Date(tempDate).toLocaleString('default', { month: 'long', year: 'numeric' })"></span>
        </div>

        <input type="date"
               x-model="tempDate"
               class="w-full px-4 py-2 border rounded-lg text-sm mb-4 text-center"
        />

        <div class="flex justify-between mt-4">
            <button @click="showCalendar = false"
                    class="px-4 py-2 border rounded-lg text-sm text-gray-700 hover:bg-gray-100">
                Cancel
            </button>
            <button @click="updateDueDate(tempDate)"
                    class="px-4 py-2 bg-fuchsia-900 text-white rounded-lg text-sm hover:bg-fuchsia-800">
                Apply
            </button>
        </div>
    </div>
</div>

</div>

                            <div class="flex items-center gap-2">
                            <iconify-icon icon="famicons:location-outline" width="24" style="color: #5A0562;"></iconify-icon>

                              <span class="font-medium">Address:</span>
                              <span><span class="mr-[12px] font-normal text-black-900">{{ $project->location }}</span> </span>
                            </div>

                            <div class="flex items-center gap-2">
                             <iconify-icon icon="iconamoon:profile-light" width="24" style="color: #5A0562;"></iconify-icon>

                              <span class="font-medium">Tech Supervisor:</span>

                              <span><span class="mr-[12px] font-normal text-black-900">{{ $project->techSupervisor->name ?? 'Not Assigned' }}</span> </span>

                          </div>
                        </div>

                          <!-- Additional Note -->
                          <div class="mt-6">
                            <h3 class="text-sm font-semibold text-gray-800">Additional Note</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ $project->description}}  </p>
                          </div>

                          <!-- Measurement -->

                          <div class="mt-6">
                            <h3 class="mb-2 text-sm font-semibold text-gray-800">Measurement (in length, width, height)</h3>
                            <div class="flex gap-8">
                             @forelse ($project->measurement as $measurement)
                         <div class="flex items-center gap-1">

                            <iconify-icon icon="solar:ruler-outline" width="22" style="color: #5A0562;"></iconify-icon>
                            <span><p> {{ $measurement->length }}mm</p></span>
                         </div>
                         <div class="flex items-center gap-1">
                          <iconify-icon icon="solar:ruler-outline" width="22" style="color: #5A0562;"></iconify-icon>

                             <span><p> {{ $measurement->width }}mm</p></span>
                         </div>
                         <div class="flex items-center gap-1">
                          <iconify-icon icon="solar:ruler-outline" width="22" style="color: #5A0562;"></iconify-icon>

                             <span><p> {{ $measurement->height }}mm</p></span>
                         </div>
                        @empty
                            <p onclick="window.location='{{ route('tech.CreateMeasurement') }}'" class="ml-50 font-semibold text-[13px] cursor-pointer text-fuchsia-900 hover:text-[#F59E0B]">+ Add measurement</p>
                        @endforelse

                            </div>
                          </div>

<!-- Measurement Attachments -->
<div class="mt-6">
    <h3 class="mb-2 text-sm font-semibold text-gray-800">Measurement Attachments</h3>
    <ul class="space-y-4">
        @foreach ($project->measurement as $measurement)
            @if (!empty($measurement->images) && is_array($measurement->images))
                <div class="w-full mx-auto">
                    @foreach ($measurement->images as $image)
                        <div class="pt-4 mt-6 border-t">
                            <h3 class="mb-2 text-sm font-semibold text-gray-900">Images</h3>
                            <ul>
                                <li class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('storage/' . $image) }}"
                                             alt="Measurement Image"
                                             class="object-cover rounded-md w-14 h-14">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ basename($image) }}</p>
                                            <p class="text-xs text-gray-500">Uploaded on {{ $measurement->created_at->format('d/m/y') }}</p>
                                            {{-- If you have file size saved, you can show it too --}}
                                        </div>
                                    </div>
                                    <div class="flex gap-4 text-purple-600">
                                        <a href="{{ asset('storage/' . $image) }}" target="_blank">
                                            <i data-feather="eye" class="w-5 h-5 text-fuchsia-900"></i>
                                        </a>
                                        <a href="{{ asset('storage/' . $image) }}" download>
                                            <i data-feather="download" class="w-5 h-5 text-fuchsia-900"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="italic text-gray-500">No measurement images available.</p>
            @endif
        @endforeach
    </ul>
</div>



          {{-- for the design images --}}
<div class="mt-6">
    <h3 class="mb-2 text-sm font-semibold text-gray-800">Design Attachments</h3>
    <ul class="space-y-4">
        @foreach ($project->design as $design)
            <li class="flex items-center justify-between p-4 rounded-lg">

@if (!empty($design->images) && is_array($design->images))
    {{-- <div class="grid grid-cols-2 gap-4 md:grid-cols-3"> --}}

        <div class="w-full mx-auto ">

        @foreach ($design->images as $image)

  <!-- Designs -->
        <div class="pt-4 mt-6 border-t">
        <h3 class="mb-2 text-sm font-semibold text-gray-900">Designs</h3>
        <ul class="">
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-3">
  <img src="{{ asset('storage/' . $image) }}"
                     alt="Design Image"
                     class="object-cover rounded-md w-14 h-14">
                        <div>
                        <p class="font-medium text-gray-800">MapleStreet1.png</p>
                        <p class="text-xs text-gray-500">Uploaded on 8/10/25</p>
                        <p class="text-xs text-gray-400">11MB</p>
                    </div>
                </div>
                <div class="flex gap-4 text-purple-600">
                    <button onclick="{{ route('designer.ProjectDesign') }}">

                      <i data-feather="eye" class="w-5 h-5 text-fuchsia-900"></i>
                    </button>
                    <button onclick="{{ route('designer.ProjectDesign') }}">

                      <i data-feather="upload" class="w-5 h-5 text-fuchsia-900"></i>

                    </button>
                </div>
            </li>
        </ul>
        </div>

            @endforeach
        </div>
    @else
        <p class="italic text-gray-500">No images available.</p>
    @endif
        @endforeach

    </ul>
</div>                     
                        </div>

                        <!-- Right Section: Comments -->
                        <div class="flex flex-col justify-between p-6 bg-white shadow rounded-xl">
                          <div>
                            <h3 class="mb-4 text-lg font-semibold text-gray-800">Comments</h3>
                            <ul class="space-y-4" id="commentsList">
                                @forelse ($project->comments as $comment)
                                <li class="flex items-start gap-3">
                                  <img
                                  src="{{ auth()->user()->profile_pic ? asset('storage/' . auth()->user()->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                  alt="Profile Photo"
                                  class="w-10 h-10 border-2
                                   border-yellow-300 rounded-[10px]">

                              <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $comment->user->name }} <span class="text-xs font-normal text-gray-400">{{ $comment->user->created_at ->diffForHumans() }}</span></p>
                                    <p class="text-sm text-gray-600">{{ $comment->comment }}</p>
                                  </div>
                                </li>
                                @empty
                                    <p>No comments yet.</p>
                                @endforelse
                              <!-- Repeat for other users -->
                            </ul>
                          </div>
                          {{-- My test code for comment --}}

                          <div class="mt-6">

                            <form method="POST" id="commentForm" action="{{ route('project.comment.store', $project->id) }}">
                                @csrf
                                <textarea name="comment" placeholder="Start typing" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                                <button type="submit" class="px-4 py-2 mt-2 text-white rounded bg-fuchsia-900">Post Comment</button>
                            </form>
                            </div>
                        </div>

                      </div>
<!-- Status Modal -->
<div id="statusModal" class="absolute z-50 hidden bg-white rounded-xl shadow-lg p-6 w-[280px]">
    <h3 class="text-lg font-semibold mb-4">Set Status</h3>
    <form id="statusForm">
        <input type="hidden" name="project_id" id="statusProjectId">
        <div class="space-y-3 mb-6">
            @foreach (['completed', 'pending', 'in progress'] as $value)
                @php
                    $pillStyle = match($value) {
                        'completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
                        'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
                        'in progress' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
                        // 'cancelled' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
                    };
                @endphp

                <button type="button" onclick="selectStatus('{{ $value }}')"
                    class="statusOption w-full py-2 rounded-full font-semibold {{ $pillStyle }}">
                    {{ ucfirst($value) }}
                </button>
            @endforeach
        </div>
        <div class="flex justify-between">
            <button type="button" onclick="closeStatusModal()" class="text-gray-500 font-medium hover:underline">Cancel</button>
            <button type="submit" class="bg-fuchsia-900 text-white rounded-full px-5 py-1.5">Confirm</button>
        </div>
    </form>
</div>

                 </div>
                </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script>
 // //for the pop up and error handling
    // Open the modal when the button is clicked
    document.getElementById('openAddClientModal').addEventListener('click', function () {
        document.getElementById('addClientModal').classList.remove('hidden');
    });

    document.getElementById('cancelAddClient').addEventListener('click', function () {
        document.getElementById('addClientModal').classList.add('hidden');
    });


    document.getElementById('addClientForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // Clear previous errors
    document.querySelectorAll('.error-message').forEach(el => el.remove());
    document.querySelectorAll('input, select').forEach(el => el.classList.remove('border-red-500'));

    fetch("{{ route('clients.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: formData,
    })
    .then(async response => {
        if (!response.ok) {
            if (response.status === 422) {
                const data = await response.json();
                for (const [field, messages] of Object.entries(data.errors)) {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('border-red-500');

                        const errorText = document.createElement('p');
                        errorText.className = 'error-message text-red-500 text-sm mt-1';
                        errorText.textContent = messages[0];

                        input.parentElement.appendChild(errorText);
                    }
                }
            } else {
                throw new Error('Something went wrong');
            }
        } else {
            return response.json();
        }
    })
    .then(data => {
        if (data) {
            document.getElementById('addClientModal').classList.add('hidden');
            document.getElementById('successModal').classList.remove('hidden');
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
});
document.getElementById('closeSuccessModal').addEventListener('click', function () {
        document.getElementById('successModal').classList.add('hidden');
        location.reload(); // refresh to update the table
    });




        </script>

        <script>
    //add the status change card

let selectedStatus = null;

/
function openStatusModal(projectId, currentStatus, event = null) {
    const modal = document.getElementById('statusModal');
    document.getElementById('statusProjectId').value = projectId;
    selectedStatus = currentStatus;

    // Clear selection
    document.querySelectorAll('.statusOption').forEach(btn => {
        btn.classList.remove('ring-2', 'ring-fuchsia-900');
        if (btn.textContent.trim().toLowerCase() === currentStatus.toLowerCase()) {
            btn.classList.add('ring-2', 'ring-fuchsia-900');
        }
    });

    // Position modal near the clicked span
    if (event) {
        const rect = event.target.getBoundingClientRect();
        modal.style.top = `${rect.bottom + window.scrollY + 8}px`;
        modal.style.left = `${rect.left + window.scrollX}px`;
    }

    modal.classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}


function selectStatus(status) {
    selectedStatus = status;
    document.querySelectorAll('.statusOption').forEach(btn => {
        btn.classList.remove('ring-2', 'ring-fuchsia-900');
        if (btn.textContent.trim().toLowerCase() === status.toLowerCase()) {
            btn.classList.add('ring-2', 'ring-fuchsia-900');
        }
    });
}

document.getElementById('statusForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const projectId = document.getElementById('statusProjectId').value;

    fetch(`/project/${projectId}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ status: selectedStatus }),
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Or manually update the pill’s text/status color
        } else {
            alert('Update failed');
        }
    });
});

        </script>

    <script>

        //add another pop up for the calender
function updateDueDate(date) {
    fetch(`/tech/project/{{ $project->id }}/update-due-date`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ due_date: date })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Due date updated!');
            location.reload();
        } else {
            alert('Failed to update due date.');
        }
    });
}
</script>


</x-tech-layout>
