<x-layouts.app>
    <x-slot name="header">
<!--written on 19.05.2025 @ 9:45-->
    <!-- Main Content -->
<meta name="csrf-token" content="{{ csrf_token() }}">
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



<!-- Installation Modal -->
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

<div class="p-6 bg-white shadow-md rounded-xl">
    <div id="calendar"></div>
    <div id="eventPopover" class="absolute z-50 hidden p-3 text-sm bg-white border border-gray-300 rounded-lg shadow-lg" style="min-width: 200px;"></div>

</div>
<!-- FullCalendar Styles -->

<!-- Event Details Modal -->
<div id="eventDetailsModal" class="fixed flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
    <div class="p-6 bg-white rounded-lg w-96">
        <h2 class="mb-4 text-xl font-bold">Installation Details</h2>
        <p><strong>Project:</strong> <span id="eventProject"></span></p>
        <p><strong>Start:</strong> <span id="eventStart"></span></p>
        <p><strong>Notes:</strong> <span id="eventNotes"></span></p>
        <div class="mt-4 text-right">
            <button onclick="closeEventModal()" class="px-4 py-2 text-white bg-blue-500 rounded">Close</button>
        </div>
    </div>
</div>


<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-30">
    <div class="w-full max-w-md p-6 bg-white rounded shadow-md">
        <h2 class="mb-4 text-lg font-bold">Edit Installation</h2>
        <form id="editForm">
            <input type="hidden" id="editEventId">
            <div class="mb-2">
                <label>Project Name:</label>
                <input type="text" id="editProjectName" readonly class="w-full px-2 py-1 border rounded">
            </div>
            <div class="mb-2">
                <label>Start Time:</label>
                <input type="datetime-local" id="editStartTime" class="w-full px-2 py-1 border rounded">
            </div>
            <div class="mb-2">
                <label>End Time:</label>
                <input type="datetime-local" id="editEndTime" class="w-full px-2 py-1 border rounded">
            </div>
            <div class="mb-4">
                <label>Notes:</label>
                <textarea id="editNotes" class="w-full px-2 py-1 border rounded"></textarea>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="text-gray-600">Cancel</button>
                <button type="submit" class="px-4 py-1 text-white bg-blue-600 rounded">Update</button>
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
            popup.className = 'bg-white shadow-md mt-[-50px] rounded p-4 border border-gray-200 fixed z-50';
            popup.style.top = `${info.jsEvent.pageY + 10}px`;
            popup.style.left = `${info.jsEvent.pageX}px`;
            popup.innerHTML = `
                <div class="mb-2 font-semibold text-gray-800">${event.title}</div>
                <div class="mb-1 text-sm"><strong>Start:</strong> ${new Date(event.start).toLocaleString()}</div>
                <div class="mb-2 text-sm"><strong>Notes:</strong> ${event.extendedProps.notes ?? 'N/A'}</div>

                <div class="flex justify-end mt-2 space-x-2">
                    <button id="editEventBtn" class="text-sm text-blue-500 hover:text-blue-700">✏️ Edit</button>
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
                   fetch(`admin/installations/${event.id}`,  {
                        // (`{{ url('/installations') }}/${id}`
                        // (`/installations/${event.id}`
                        // fetch(`/admin/installations/${event.id}`,
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

    fetch(`/installations/${id}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            start_time: document.getElementById('editStartTime').value,
            end_time: document.getElementById('editEndTime').value,
            notes: document.getElementById('editNotes').value
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeEditModal();
            calendar.refetchEvents();
            alert('Installation updated!');
        } else {
            alert('Failed to update.');
        }
    })
    .catch(() => alert('Something went wrong'));
});




    // document.addEventListener('DOMContentLoaded', function () {
    //     const calendarEl = document.getElementById('calendar');
    //     const popover = document.getElementById('eventPopover');

    //     const calendar = new FullCalendar.Calendar(calendarEl, {
    //         initialView: 'dayGridMonth',
    //         headerToolbar: {
    //             left: 'prev,next today',
    //             center: 'title',
    //             right: 'dayGridMonth,timeGridWeek,listWeek'
    //         },
    //         events: '/installations/events',
    //         eventColor: '#0036BF',
    //         height: 'auto',

    //         eventClick: function (info) {
    //             const event = info.event;
    //             const project = event.extendedProps.project?.name || 'N/A';
    //             const notes = event.extendedProps.notes || 'No notes';
    //             const startTime = new Date(event.start).toLocaleString();

    //             // Set popover content
    //             popover.innerHTML = `
    //                 <div class="mb-1 font-semibold text-gray-800">${project}</div>
    //                 <div><span class="font-medium text-gray-600">Start:</span> ${startTime}</div>
    //                 <div class="mt-1 text-gray-700">${notes}</div>
    //             `;

    //             // Position popover near the click
    //             const rect = info.jsEvent.target.getBoundingClientRect();
    //             const scrollTop = window.scrollY || window.pageYOffset;
    //             popover.style.top = (rect.top + scrollTop + 25) + 'px';
    //             popover.style.left = (rect.left + rect.width / 2) + 'px';

    //             popover.classList.remove('hidden');

    //             // Close popover on outside click
    //             document.addEventListener('click', function onDocClick(e) {
    //                 if (!popover.contains(e.target) && !info.el.contains(e.target)) {
    //                     popover.classList.add('hidden');
    //                     document.removeEventListener('click', onDocClick);
    //                 }
    //             });
    //         }
    //     });

    //     calendar.render();
    // });






    // document.addEventListener('DOMContentLoaded', function () {
    //     var calendarEl = document.getElementById('calendar');

    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         initialView: 'dayGridMonth',
    //         headerToolbar: {
    //             left: 'prev,next today',
    //             center: 'title',
    //             right: 'dayGridMonth,timeGridWeek,listWeek'
    //         },
    //         events: '/installations/events', // Laravel route returning JSON events

    //         eventColor: '#0036BF',
    //         height: 'auto',

    //         eventClick: function (info) {
    //             const event = info.event;
    //             const projectName = event.extendedProps.project.name;
    //             const startTime = new Date(event.start).toLocaleString();
    //             const notes = event.extendedProps.notes || 'No notes available';

    //             alert(
    //                 `Project: ${projectName}\nStart Time: ${startTime}\nNotes: ${notes}`
    //             );
    //         }
    //     });

    //     calendar.render();
    // });



    // document.addEventListener('DOMContentLoaded', function () {
    //     var calendarEl = document.getElementById('calendar');

    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         initialView: 'dayGridMonth',
    //         headerToolbar: {
    //             left: 'prev,next today',
    //             center: 'title',
    //             right: 'dayGridMonth,timeGridWeek,listWeek'
    //         },
    //         //events: '/api/calendar/events', // Laravel route returning JSON events
    //         events: '/installations/events',

    //         eventColor: '#0036BF', // Tailwind's purple-700
    //         height: 'auto',
    //     });

    //     calendar.render();
    // });





//  function openModal() {
//         document.getElementById('installationModal').classList.remove('hidden');
//     }

//     function closeModal() {
//         document.getElementById('installationModal').classList.add('hidden');
//         document.getElementById('installationForm').reset();
//         document.getElementById('project_id').innerHTML = '<option value="">Select a project</option>';
//         document.getElementById('duration').value = '';
//     }

//     document.getElementById('client_id').addEventListener('change', function () {
//         const selected = this.options[this.selectedIndex];
//         document.getElementById('client_phone').value = selected.getAttribute('data-phone') || '';
//         document.getElementById('client_location').value = selected.getAttribute('data-location') || '';

//         const clientId = this.value;
//         fetch(`/api/projects/by-client/${clientId}`)
//             .then(res => res.json())
//             .then(data => {
//                 const projectSelect = document.getElementById('project_id');
//                 projectSelect.innerHTML = '<option value="">Select a project</option>';
//                 data.forEach(project => {
//                     projectSelect.innerHTML += `<option value="${project.id}">${project.name}</option>`;
//                 });
//             });
//     });

//     document.getElementById('end_time').addEventListener('change', function () {
//         const start = new Date(document.getElementById('start_time').value);
//         const end = new Date(this.value);
//         const diffMs = end - start;

//         if (diffMs > 0) {
//             const minutes = Math.floor(diffMs / 60000);
//             const hours = Math.floor(minutes / 60);
//             const remainingMinutes = minutes % 60;
//             document.getElementById('duration').value = `${hours} hr(s) ${remainingMinutes} min(s)`;
//         } else {
//             document.getElementById('duration').value = '';
//         }
//     });

//     document.getElementById('installationForm').addEventListener('submit', function (e) {
//         e.preventDefault();

//         const formData = new FormData(this);

//         // fetch('{{ route('installation.store') }}', {
//         //     method: 'POST',
//         //     headers: {
//         //         //'X-CSRF-TOKEN': '{{ csrf_token() }}'
//         //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         //     },

//                 fetch("{{ route(name: 'installation.store') }}", {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
//                 'Accept': 'application/json'  // Tell Laravel you want JSON
//             },
//             body: formData,






//         })
//         .then(res => res.json())
//         .then(data => {
//             if (data.success) {
//                 closeModal();
//                 calendar.refetchEvents(); // Refresh the calendar
//                 alert('Installation created successfully!');

//             } else {
//                 alert('Error saving installation');

//             }
//         })
//         .catch(() => alert('Something went wrong.'));
//     });



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

//  fetch("{{ route( 'installation.store') }}", {
//         method: 'POST',
//         headers: {
//             'X-CSRF-TOKEN': '{{ csrf_token() }}',
//             'Accept': 'application/json'
//         },
//         body: formData
//     })


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

</x-layouts.app>


{{---}}
//            headers: {
//   'Content-Type': 'application/json',
//   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//}
// const form = document.getElementById('installationForm');
// const formDataObj = Object.fromEntries(new FormData(form).entries());

// fetch('{{ route('installation.store') }}', {
//     method: 'POST',
//     headers: {
//         'Content-Type': 'application/json',
//         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//     },
//     body: JSON.stringify(formDataObj)
// })

            // body: formData
            //  body: JSON.stringify(formDataObj)



 {{-- <x-layouts.app>
    <x-slot name="header">
<!--written on 07.05.2025 @ 9:45-->
    <!-- Main Content -->

    @include('admin.layouts.header')

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">
<!-- Create Installation Button -->
<button onclick="openModal()" class="px-4 py-2 mt-4 text-white bg-purple-700 rounded hover:bg-purple-800">
    + Create Installation
</button>

<!-- Installation Modal -->
<div id="installationModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
    <div class="w-full max-w-2xl p-6 bg-white shadow-lg rounded-xl">
        <h2 class="mb-4 text-xl font-bold">Create Installation</h2>

        <form id="installationForm">
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

<div class="p-6 bg-white shadow-md rounded-xl">
    <div id="calendar"></div>
</div>

</div>
</div>
</main>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>


<!-- FullCalendar js -->

<script>
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

    document.getElementById('end_time').addEventListener('change', function () {
        const start = new Date(document.getElementById('start_time').value);
        const end = new Date(this.value);
        const diffMs = end - start;

        if (diffMs > 0) {
            const minutes = Math.floor(diffMs / 60000);
            const hours = Math.floor(minutes / 60);
            const remainingMinutes = minutes % 60;
            document.getElementById('duration').value = `${hours} hr(s) ${remainingMinutes} min(s)`;
        } else {
            document.getElementById('duration').value = '';
        }
    });

    document.getElementById('installationForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('{{ route('installation.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeModal();
                calendar.refetchEvents(); // Refresh the calendar
                alert('Installation created successfully!');
            } else {
                alert('Error saving installation');
            }
        })
        .catch(() => alert('Something went wrong.'));
    });


     document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            events: '/api/calendar/events', // Laravel route returning JSON events
            eventColor: '#7C3AED', // Tailwind's purple-700
            height: 'auto',
        });

        calendar.render();
    });


//     let calendar = new FullCalendar.Calendar(calendarEl, {
//     initialView: 'dayGridMonth',
//     events: '{{ route('installation.events') }}',
//     headerToolbar: {
//         left: 'prev,next today',
//         center: 'title',
//         right: 'dayGridMonth,timeGridWeek,listWeek'
//     },
//     eventClick: function(info) {
//         alert(info.event.title + '\nNotes: ' + (info.event.extendedProps.notes || 'None'));
//     }
// });
// calendar.render();

<!-- FullCalendar Script -->

    </x-slot>


</x-layouts.app> --}}
