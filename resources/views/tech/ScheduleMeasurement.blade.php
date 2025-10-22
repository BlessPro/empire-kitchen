<x-tech-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    </x-slot>

    @include('admin.layouts.header')

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Measurement Calendar</h1>
                {{-- <button onclick="openCreateModal()" class="px-4 py-2 text-white rounded bg-fuchsia-900 hover:bg-fuchsia-700">+ Schedule Measurement</button> --}}
            </div>

            <div class="p-4 bg-white shadow rounded-xl">
                <div id="calendar"></div>
            </div>
        </div>
    </main>

    {{-- Success Toast --}}
    <div id="successToast" class="fixed hidden px-4 py-2 text-white bg-green-600 rounded shadow bottom-5 right-5">
        <span id="successMessage"></span>
    </div>

    {{-- Create Modal --}}
    <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="w-full max-w-xl p-6 bg-white rounded-lg shadow-lg">

            <h2 class="mb-4 text-xl font-semibold">Schedule Measurement</h2>

            <form id="createForm">
                @csrf
                <div class="mb-4">
                    <label>Client</label>
                    <select id="client_id" name="client_id" class="w-full p-2 border rounded" required>
                        <option value="">Select a client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                data-phone="{{ $client->phone_number }}"
                                data-email="{{ $client->email }}"
                                data-location="{{ $client->location }}">
                                {{ $client->firstname }} {{ $client->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <input type="text" id="client_phone" placeholder="Phone" readonly class="p-2 border rounded">
                    <input type="text" id="client_location" placeholder="Location" readonly class="p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label>Project</label>
                    <select id="project_id" name="project_id" class="w-full p-2 border rounded" required>
                        <option value="">Select a project</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label>Start Time</label>
                        <input type="datetime-local" name="start_time" id="start_time" class="w-full p-2 border rounded" required>
                    </div>
                    <div>
                        <label>End Time</label>
                        <input type="datetime-local" name="end_time" id="end_time" class="w-full p-2 border rounded" required>
                    </div>
                </div>

                <div class="mb-4">
                    <input type="text" id="duration" placeholder="Duration" readonly class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label>Notes</label>
                    <textarea name="notes" class="w-full p-2 border rounded"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeCreateModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-white rounded bg-fuchsia-900">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS --}}
    <script>
        const showToast = (msg) => {
            const toast = document.getElementById('successToast');
            document.getElementById('successMessage').innerText = msg;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 2500);
        };

        const openCreateModal = () => {
            document.getElementById('createModal').classList.remove('hidden');
        };
        const closeCreateModal = () => {
            document.getElementById('createForm').reset();
            document.getElementById('project_id').innerHTML = '<option value="">Select a project</option>';
            document.getElementById('duration').value = '';
            document.getElementById('client_phone').value = '';
            document.getElementById('client_location').value = '';
            document.getElementById('createModal').classList.add('hidden');
        };

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

        const updateDuration = () => {
            const start = new Date(document.getElementById('start_time').value);
            const end = new Date(document.getElementById('end_time').value);
            const diff = end - start;
            if (diff > 0) {
                const mins = Math.floor(diff / 60000);
                const hours = Math.floor(mins / 60);
                const remaining = mins % 60;
                document.getElementById('duration').value = `${hours} hr(s) ${remaining} min(s)`;
            } else {
                document.getElementById('duration').value = '';
            }
        };

        document.getElementById('start_time').addEventListener('change', updateDuration);
        document.getElementById('end_time').addEventListener('change', updateDuration);

        document.getElementById('createForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('/tech/ScheduleMeasurement/store', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    closeCreateModal();
                    calendar.refetchEvents();
                    showToast('Measurement scheduled!');
                }
            });
        });
let calendar;
document.addEventListener('DOMContentLoaded', function () {
    calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: function (fetchInfo, successCallback, failureCallback) {
            fetch('/tech/ScheduleMeasurement/events')
                .then(res => res.json())
                .then(data => {
                    console.log('Events fetched:', data); // ✅ This helps debug
                    successCallback(data);
                })
                .catch(err => {
                    console.error('Event fetch error', err);
                    failureCallback(err);
                });
        },
        eventClick: function (info) {
            const e = info.event;
            const popup = document.createElement('div');
            popup.className = 'absolute z-50 bg-white border p-4 rounded shadow w-[260px]';
            popup.style.top = `${info.jsEvent.clientY}px`;
            popup.style.left = `${info.jsEvent.clientX}px`;
            popup.innerHTML = `
                <div class="mb-2 font-semibold">${e.title}</div>
                <div class="mb-1 text-sm"><strong>From:</strong> ${new Date(e.start).toLocaleString()}</div>
                <div class="mb-2 text-sm"><strong>To:</strong> ${new Date(e.end).toLocaleString()}</div>
                <div class="flex justify-end gap-2 mt-3">
                    <button onclick="deleteEvent(${e.id})" class="text-red-600">🗑 Delete</button>
                </div>
            `;
            document.body.appendChild(popup);

            const removePopup = () => {
                popup.remove();
                document.removeEventListener('click', outsideClick);
            };
            const outsideClick = (ev) => {
                if (!popup.contains(ev.target)) removePopup();
            };
            setTimeout(() => document.addEventListener('click', outsideClick), 50);
        }
    });

    calendar.render();
});


        const deleteEvent = (id) => {
            fetch(`/tech/ScheduleMeasurement/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    calendar.refetchEvents();
                    showToast('Deleted successfully');
                }
            });
        };
    </script>
</x-tech-layout>
