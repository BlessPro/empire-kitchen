<x-layouts.app>
    <x-slot name="header">
<!--written on 19.05.2025 @ 9:45-->
    <!-- Main Content -->

    @include('admin.layouts.header')

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">

            <!-- FullCalendar Styles -->


<!-- Tailwind Styles already included in your layout -->
<!-- Create Installation Button -->
<button onclick="openModal()" class="mt-4 mb-4 px-4 py-2 bg-fuchsia-950 text-white rounded hover:bg-purple-800">
    + Create Installation
</button>
<div class="p-6 bg-white shadow-md rounded-xl">
    <div id="calendar"></div>
</div>



<!-- Installation Modal -->
<div id="installationModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-xl w-full max-w-2xl shadow-lg">
        <h2 class="text-xl font-bold mb-4">Create Installation</h2>

     {{-- //   <form id="installationForm"> --}}
            <form id="installationForm" enctype="multipart/form-data">

            @csrf
            <!-- Client -->
            <div class="mb-4">
                <label class="block font-medium">Client</label>
                <select id="client_id" name="client_id" class="w-full border p-2 rounded" required>
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
                <input type="text" id="client_phone" class="border p-2 rounded" placeholder="Phone Number" readonly>
                <input type="text" id="client_location" class="border p-2 rounded" placeholder="Location" readonly>
            </div>

            <!-- Project -->
            <div class="mb-4">
                <label class="block font-medium">Project</label>
                <select id="project_id" name="project_id" class="w-full border p-2 rounded" required>
                    <option value="">Select a project</option>
                    <!-- JS will populate based on selected client -->
                </select>
            </div>

            <!-- Start/End Time -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium">Start Time</label>
                    <input type="datetime-local" id="start_time" name="start_time" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block font-medium">End Time</label>
                    <input type="datetime-local" id="end_time" name="end_time" class="w-full border p-2 rounded" required>
                </div>
            </div>

            <!-- Duration -->
            <div class="mb-4">
                <input type="text" id="duration" class="border p-2 rounded w-full" placeholder="Duration (auto)" readonly>
            </div>

            <!-- Notes -->
            <div class="mb-4">
                <textarea name="notes" rows="3" class="w-full border p-2 rounded" placeholder="Additional Notes (optional)"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-800">Save</button>
            </div>
        </form>
    </div>
</div>

<div class="p-6 bg-white shadow-md rounded-xl">
    <div id="calendar"></div>
</div>
<!-- FullCalendar Styles -->

</div>
</div>
</main>
<!-- FullCalendar Script -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>
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
            eventColor: '#ffff', // Tailwind's purple-700
            height: 'auto',
        });

        calendar.render();
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

        // fetch('{{ route('installation.store') }}', {
        //     method: 'POST',
        //     headers: {
        //         //'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //     },

                fetch("{{ route('installation.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                // 'Accept': 'application/json'  // Tell Laravel you want JSON
            },
            body: formData,






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



</script>

    </x-slot>
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
<button onclick="openModal()" class="mt-4 px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-800">
    + Create Installation
</button>

<!-- Installation Modal -->
<div id="installationModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-xl w-full max-w-2xl shadow-lg">
        <h2 class="text-xl font-bold mb-4">Create Installation</h2>

        <form id="installationForm">
            @csrf
            <!-- Client -->
            <div class="mb-4">
                <label class="block font-medium">Client</label>
                <select id="client_id" name="client_id" class="w-full border p-2 rounded" required>
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
                <input type="text" id="client_phone" class="border p-2 rounded" placeholder="Phone Number" readonly>
                <input type="text" id="client_location" class="border p-2 rounded" placeholder="Location" readonly>
            </div>

            <!-- Project -->
            <div class="mb-4">
                <label class="block font-medium">Project</label>
                <select id="project_id" name="project_id" class="w-full border p-2 rounded" required>
                    <option value="">Select a project</option>
                    <!-- JS will populate based on selected client -->
                </select>
            </div>

            <!-- Start/End Time -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium">Start Time</label>
                    <input type="datetime-local" id="start_time" name="start_time" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block font-medium">End Time</label>
                    <input type="datetime-local" id="end_time" name="end_time" class="w-full border p-2 rounded" required>
                </div>
            </div>

            <!-- Duration -->
            <div class="mb-4">
                <input type="text" id="duration" class="border p-2 rounded w-full" placeholder="Duration (auto)" readonly>
            </div>

            <!-- Notes -->
            <div class="mb-4">
                <textarea name="notes" rows="3" class="w-full border p-2 rounded" placeholder="Additional Notes (optional)"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-800">Save</button>
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
