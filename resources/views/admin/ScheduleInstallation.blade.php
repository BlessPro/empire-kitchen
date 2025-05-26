<x-app-layout>
    <x-slot name="header">
<!--written on 19.05.2025 @ 9:45-->
    <!-- Main Content -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .fc .fc-button {
        background-color: #5A0562; /* Tailwind's blue-600 */
        color: white;
        font-size: 1rem; /* text-sm */
        padding: 0.25rem 0.75rem; /* py-1 px-3 */
        border-radius: 0.375rem; /* rounded-md */
        border: none;
        margin: 0 0.25rem;
        transition: all 0.2s ease-in-out;
    }

    .fc .fc-button:hover {
        background-color: #ff7300; /* Tailwind's blue-700 */
    }

    .fc .fc-button.fc-button-active {
        background-color: #ff7300; /* Tailwind's blue-900 */
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
    }

    .fc .fc-toolbar-title {
        font-weight: 600;
        color: #5A0562; /* text-gray-800 */
        font-size: 1.125rem; /* text-lg */
    }
</style>

    </x-slot>
    @include('admin.layouts.header')
    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">

            <!-- FullCalendar Styles -->


<!-- Tailwind Styles already included in your layout -->
<!-- Create Installation Button -->
<button onclick="openModal()" class="px-4 py-2 mt-4 mb-4 text-white rounded bg-fuchsia-950 hover:bg-purple-800">
    + Create Installation
</button>
<div class="p-6 bg-white shadow-md rounded-xl">
    <div id="calendar"></div>
</div>


{{-- installationmodal --}}

<div id="installationModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
    <div class="w-full max-w-2xl p-6 bg-white shadow-lg rounded-xl">
        <h2 class="mb-4 text-xl font-bold">Create Installation</h2>

     {{-- //   <form id="installationForm"> --}}
            <form id="installationForm" method="POST" enctype="multipart/form-data">

            @csrf
            <!-- Client -->
            <div class="mb-4">
                <label class="block font-medium">Client</label>
                <select id="client_id" name="client_id" class="w-full p-2 border rounded" required>
                    <option value="">Select a client</option>
                    @foreach(\App\Models\Client::all() as $client)
                        <option value="{{ $client->id }}"
                            data-phone="{{ $client->phone_number }}"
                            data-location="{{ $client->location }}">
                            {{ $client->firstname }} {{ $client->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Client Info -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <input type="text" id="client_phone" class="p-2 border rounded" placeholder="Phone Number" readonly>
            <input type="text" id="client_location" class="p-2 border rounded" placeholder="Location" readonly>
            </div>

            <!-- Project -->
            <div class="mb-4">
                <label class="block font-medium">Project</label>
                <select id="project_id" name="project_id" class="w-full p-2 border rounded" required>
                    <option value="">Select a project</option>
                    <!-- JS will populate based on selected client -->
                </select>
            </div>

            <!-- Start/End Time -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium">Start Time</label>
                    <input type="datetime-local" id="start_time" name="start_time" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block font-medium">End Time</label>
                    <input type="datetime-local" id="end_time" name="end_time" class="w-full p-2 border rounded" required>
                </div>
            </div>

            <!-- Duration -->
            <div class="mb-4">
                <input type="text" id="duration" class="w-full p-2 border rounded" placeholder="Duration (auto)" readonly>
            </div>

            <!-- Notes -->
            <div class="mb-4">
                <textarea name="notes" rows="3" class="w-full p-2 border rounded" placeholder="Additional Notes (optional)"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 text-white bg-purple-700 rounded hover:bg-purple-800">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- installationmodal --}}





<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-30">
    <div class="w-full max-w-md p-6 bg-white rounded shadow-md">
<div class="flex flex-col justify-between gap-4 mb-4 sm:flex-row">
        <h2 class="mb-4 text-xl font-semibold">Edit Installation</h2>
        <button onclick="closeEditModal()" type="button" id="closeModalBtn" class="px-4 py-2 text-black "> <i data-feather="x"
    class="mr-3 feather-icon group"></i>

     {{-- <button type="button"  class="text-gray-600">Cancel</button> --}}
    </button>

        </div>
           <form id="editForm" enctype="multipart/form-data">
            @csrf

            <input type="hidden" id="editEventId">
            <div class="mb-2">
                <label>Project Name:</label>
                <input type="text" id="editProjectName" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-2">
                <label>Start Time:</label>
                <input type="datetime-local" id="editStartTime" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-2">
                <label>End Time:</label>
                <input type="datetime-local" id="editEndTime" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label>Notes:</label>
                <textarea id="editNotes" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="submit" class="bg-fuchsia-900 w-full text-[20px] text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>


</div>
</div>
</main>
<!-- FullCalendar Script -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>



function openEventModal(project, start, notes) {
    document.getElementById('eventProject').innerText = project;
    document.getElementById('eventStart').innerText = new Date(start).toLocaleString();
    document.getElementById('eventNotes').innerText = notes;
    document.getElementById('eventDetailsModal').classList.remove('hidden');
}

function closeEventModal() {
    document.getElementById('eventDetailsModal').classList.add('hidden');
}




document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '/installations/events',

        eventColor: '#0036BF',
        height: 'auto',
        eventClick: function (info) {
    const event = info.event;

    const popup = document.createElement('div');
    popup.className = 'bg-white shadow-md rounded p-4 border border-gray-200 fixed z-50';
    popup.style.position = 'fixed'; // ensure it's fixed to the viewport

    // Set default popup dimensions
    const popupWidth = 250;
    const popupHeight = 150;
    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;

    // Initial top/left based on cursor position
    let top = info.jsEvent.clientY + 10;
    let left = info.jsEvent.clientX;

    // Adjust if popup would go off-screen
    if (left + popupWidth > viewportWidth) {
        left = viewportWidth - popupWidth - 10;
    }
    if (top + popupHeight > viewportHeight) {
        top = viewportHeight - popupHeight - 10;
    }

    popup.style.top = `${top}px`;
    popup.style.left = `${left}px`;
    popup.style.width = `${popupWidth}px`; // optional fixed width

    popup.innerHTML = `
        <div class="mb-2 font-semibold text-gray-800">${event.title}</div>
        <div class="mb-1 text-sm"><strong>Start:</strong> ${new Date(event.start).toLocaleString()}</div>
        <div class="mb-2 text-sm"><strong>Notes:</strong> ${event.extendedProps.notes ?? 'N/A'}</div>

        <div class="flex justify-end mt-2">
            <button id="editEventBtn" class="text-sm text-blue-500 hover:text-blue-700"><i data-feather="edit-3" class="mr-3"></i> Edit</button>
            <button id="deleteEventBtn" class="text-sm text-red-500 hover:text-red-700">🗑️ Delete</button>
        </div>
    `;

    document.body.appendChild(popup);

    function removePopup() {
        popup.remove();
        document.removeEventListener('click', outsideClickListener);
    }

    function outsideClickListener(e) {
        if (!popup.contains(e.target)) {
            removePopup();
        }
    }

    setTimeout(() => {
        document.addEventListener('click', outsideClickListener);
    }, 0);

    // Delete Handler
    popup.querySelector('#deleteEventBtn').addEventListener('click', function () {
        if (confirm('Are you sure you want to delete this installation?')) {
            fetch(`/admin/Installation/${event.id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            }).then(res => res.json())
              .then(data => {
                  if (data.success) {
                      calendar.refetchEvents();
                      alert('Deleted successfully');
                      removePopup();
                  } else {
                      alert('Failed to delete.');
                  }
              });
        }
    });


            // Edit Handler
            popup.querySelector('#editEventBtn').addEventListener('click', function () {
                removePopup();
                openEditModal(event); // Call a function to open a modal with prefilled form
            });
        }

    });

    calendar.render();
});



//for the edit pop up

function openEditModal(event) {
    document.getElementById('editEventId').value = event.id;
    document.getElementById('editProjectName').value = event.title;
    document.getElementById('editStartTime').value = new Date(event.start).toISOString().slice(0,16);
    document.getElementById('editEndTime').value = new Date(event.end).toISOString().slice(0,16);
    document.getElementById('editNotes').value = event.extendedProps.notes ?? '';

    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('editEventId').value;
    const formData = new FormData(this);

    // const formData = new FormData();
       fetch(`/admin/ScheduleInstallation/${Id}`, {
        method: 'POST',
        body: formData,
    })
    .then(res => res.json())
    .then(res => {
        if (res.message) {
            document.getElementById('editUserModal').classList.add('hidden');
            document.getElementById('editUserModal').classList.remove('flex');

            document.getElementById('successModal').classList.remove('hidden');
        }
    });
});




function openModal() {
    document.getElementById('installationModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('installationModal').classList.add('hidden');
    document.getElementById('installationForm').reset();
    document.getElementById('project_id').innerHTML = '<option value="">Select a project</option>';
    document.getElementById('duration').value = '';
}

document.getElementById('client_id').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    document.getElementById('client_phone').value = selected.getAttribute('data-phone') || '';
    document.getElementById('client_location').value = selected.getAttribute('data-location') || '';

    const clientId = this.value;
    fetch(`/api/projects/by-client/${clientId}`)
        .then(res => res.json())
        .then(data => {
            const projectSelect = document.getElementById('project_id');
            projectSelect.innerHTML = '<option value="">Select a project</option>';
            data.forEach(project => {
                projectSelect.innerHTML += `<option value="${project.id}">${project.name}</option>`;
            });
        });
});

// Shared function to calculate and update duration
function updateDuration() {
    const start = new Date(document.getElementById('start_time').value);
    const end = new Date(document.getElementById('end_time').value);
    const diffMs = end - start;

    if (diffMs > 0) {
        const minutes = Math.floor(diffMs / 60000);
        const hours = Math.floor(minutes / 60);
        const remainingMinutes = minutes % 60;
        document.getElementById('duration').value = `${hours} hr(s) ${remainingMinutes} min(s)`;
    } else {
        document.getElementById('duration').value = '';
    }
}

// Call updateDuration on end_time change
document.getElementById('end_time').addEventListener('change', updateDuration);

// NEW: Call updateDuration on start_time change as well
document.getElementById('start_time').addEventListener('change', updateDuration);

document.getElementById('installationForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);



fetch('/installations/store', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
    },
    body: formData
})

    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeModal();
            calendar.refetchEvents();
            alert('Installation created successfully!');
        } else {
            alert('Error saving installation');
        }
    })
    .catch(() => alert('Something went wrong.'));
});


</script>

</x-app-layout>


