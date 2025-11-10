<x-layouts.app>
    <x-slot name="header">
        <!--written on 26.04.2025-->
        @include('admin.layouts.header')
        <main>
            <!--head begins-->

            <div class="p-3 sm:p-4 bg-[#F9F7F7]">
                <div class="mb-[20px]"> <!---->
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-bold">Clients Management</h1>
                        {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
                        <!-- ADD CLIENT BUTTON -->
                        <button id="openAddClientModal"
                            class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                            + Add new Client
                        </button>


                    </div>
                    <!-- ADD CLIENT MODAL -->
                    <div id="addClientModal"
                        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-full max-w-[600px] items-center justify-center relative">
                            <div class="flex flex-col justify-between gap-4 mb-4 sm:flex-row">
                                <h2 class="mb-4 text-xl font-semibold">Add New Client</h2>
                                <button type="button" id="cancelAddClient" class="px-4 py-2 text-black">
                                    <i data-feather="x" class="mr-3 feather-icon group"></i>
                                </button>
                            </div>

                            <form id="addClientForm" method="POST">
                                @csrf

                                <!-- First & Last Name -->
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="mb-4">
                                        <label for="firstName"
                                            class="block mb-3 text-sm font-medium text-gray-700">First Name</label>
                                        <input id="firstName" name="firstname" type="text"
                                            placeholder="Enter first name"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <div class="mb-4">
                                        <label for="lastName" class="block mb-3 text-sm font-medium text-gray-700">Last
                                            Name</label>
                                        <input id="lastName" name="lastname" type="text"
                                            placeholder="Enter last name"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>

                                <!-- Phone Numbers -->
                                <div class="flex flex-col gap-4 sm:flex-row">
                                    <div class="mb-4">
                                        <label for="phone" class="block mb-3 text-sm font-medium">Phone
                                            Number</label>
                                        <input id="phone" name="phone_number" type="tel"
                                            placeholder="Enter phone number"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <div class="mb-4">
                                        <label for="otherPhone" class="block mb-3 text-sm font-medium">Other
                                            Phone</label>
                                        <input id="otherPhone" name="other_phone" type="tel"
                                            placeholder="Enter other phone"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>

                                <!-- Location & Email -->
                                <div class="mb-6">
                                    <label for="location"
                                        class="block mb-3 text-sm font-medium text-gray-700">Location</label>
                                    <input id="location" name="location" type="text" placeholder="Enter location"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="mb-6">
                                    <label for="email" class="block mb-3 text-sm font-medium text-gray-700">Email
                                        Address</label>
                                    <input id="email" name="email" type="email" placeholder="Enter email"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Contact Person & Contact Phone -->
                                <div class="flex flex-col gap-4 sm:flex-row">
                                    <div class="mb-4">
                                        <label for="contactPerson" class="block mb-3 text-sm font-medium">Contact
                                            Person</label>
                                        <input id="contactPerson" name="contact_person" type="text"
                                            placeholder="Enter contact person"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <div class="mb-4">
                                        <label for="contactPhone" class="block mb-3 text-sm font-medium">Contact
                                            Phone</label>
                                        <input id="contactPhone" name="contact_phone" type="tel"
                                            placeholder="Enter contact phone"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>

                                <!-- Submit -->
                                <button type="submit"
                                    class="bg-fuchsia-900 w-full text-[20px] text-white px-4 py-2 rounded">
                                    Save Client
                                </button>
                            </form>
                        </div>
                    </div>




                    <div id="successModal"
                        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                        <div class="w-full max-w-sm p-6 bg-white rounded-lg">
                            <div
                                class="flex items-center justify-center w-10 h-10 mb-[10px] bg-fuchsia-100 rounded-full">
                                <i data-feather="user-plus" class="text-fuchsia-900 ml-[3px]"></i>
                            </div>
                            <h2 class="mb-4 text-lg font-semibold text-left">Client successfully created</h2>

                            <!-- Right-Aligned Button -->
                            <div class="flex justify-end">
                                <button id="closeSuccessModal" class="px-4 py-2 text-white rounded-full bg-fuchsia-900">
                                    OK
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- SUCCESS MODAL  ENDS-->

                    <div class="mb-20 bg-white shadow rounded-2xl">
                        <div class="flex items-center justify-between pt-3 pb-1 pl-6 pr-2 border-b">

                            <div>
                                <h2 class="font-normal text-gray-900 text-normal">Manage your clients here</h2>
                            </div>
                            <div>
                                <form id="filterForm" method="GET" action="{{ route('clients.index') }}"
                                    class="flex gap-3 mb-4">
                                    <input type="text" name="search" id="searchInput"
                                        value="{{ request('search') }}" placeholder="Search clients..."
                                        class="pt-2 pb-2 pl-5 pr-5 border-gray-300 rounded-full">

                                    <select name="location" id="locationSelect"
                                        class="pt-2 pb-2 pl-5 pr-5 border-gray-300 rounded-full">
                                        <option value="">All Locations</option>
                                        @foreach ($clients->pluck('location')->unique() as $location)
                                            <option value="{{ $location }}"
                                                {{ request('location') == $location ? 'selected' : '' }}>
                                                {{ $location }}</option>
                                        @endforeach
                                    </select>
                                </form>

                            </div>

                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left">
                                <thead class="items-center text-sm text-gray-600 bg-gray-100">
                                    <tr>

                                        <th class="p-4 font-mediumt text-[15px] items-center">Client Name</th>
                                        <th class="p-4 font-mediumt text-[15px] items-center">Phone Number</th>
                                        <th class="p-4 font-mediumt text-[15px] items-center">Projects</th>
                                        <th class="p-4 font-mediumt text-[15px] items-center">Location</th>
                                        <th class="p-4 font-mediumt text-[15px] items-center">Action</th>

                                    </tr>
                                </thead>

                                <tbody class="text-gray-700 divide-y divide-gray-100">



                                    @foreach ($clients as $client)
                                        <tr onclick="window.location='{{ route('admin.clients.projects', $client->id) }}'"
                                            class="cursor-pointer hover:bg-gray-100">

                                            {{-- <tr onclick="window.location='{{ route('admin.clients.projects', $client->id) }}'" class="cursor-pointer hover:bg-gray-100"> --}}

                                            {{-- <tr class="cursor-pointer items-right hover:bg-gray-100"> --}}
                                        <tr class="cursor-pointer items-right hover:bg-gray-100"
                                            data-client-id="{{ $client->id }}">
                                            <td class="p-4 font-normal text-[15px]  items-center">
                                                {{ $client->title . ' ' . $client->firstname . ' ' . $client->lastname }}
                                            </td>
                                            <td class="p-4 font-normal text-[15px] items-center">
                                                {{ $client->phone_number }}</td>
                                            <td class="p-4 font-normal text-[15px] items-center">
                                                {{ $client->projects_count }}</td>
                                            <td class="p-4 font-normal text-[15px] items-center">
                                                {{ $client->location }}</td>
                                            {{-- <td class="p-4 font-normal text-[15px] items-right cursor-pointer">
                    <iconify-icon icon="mingcute:more-2-line" width="24" style="color: #5A0562;"></iconify-icon>
                      </td> --}}
                                            <td class="p-4 font-normal text-[15px] cursor-pointer relative"
                                                data-no-nav="true"
                                                x-data="{ open: false }">
                                                <!-- Trigger -->
                                                <button @click="open = !open" class="focus:outline-none">
                                                    <iconify-icon icon="mingcute:more-2-line" width="24"
                                                        style="color: #5A0562;"></iconify-icon>
                                                </button>

                                                <!-- Dropdown Menu -->
                                                <div x-show="open" @click.away="open = false" x-transition
                                                    class="absolute right-0 z-50 w-48 mt-2 bg-white border border-gray-100 shadow-lg rounded-xl">
                                                    <ul class="py-2 text-[15px] text-gray-700">
                                                        <li>
                                                            <a href="{{ route('admin.clients.projects', ['client' => $client->id]) }}"
                                                                class="block px-4 py-2 rounded-t-lg hover:bg-gray-100">
                                                                View Projects
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('clients.edit', $client->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100">
                                                                Edit Client Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form method="POST"
                                                                action="{{ route('clients.destroy', $client->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="block w-full px-4 py-2 text-left text-red-600 rounded-b-lg hover:bg-gray-100">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="mt-4 mb-5 ml-5 mr-5">
                                {{ $clients->links('pagination::tailwind') }}
                            </div>
                        </div>

                        <!-- Pagination -->

                    </div>


                </div>
            </div>
        </main>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let form = document.getElementById("filterForm");
                let searchInput = document.getElementById("searchInput");
                let locationSelect = document.getElementById("locationSelect");

                // Auto-submit when typing (with a small delay)
                let typingTimer;
                searchInput.addEventListener("keyup", function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(() => form.submit(), 500); // waits 0.5s after typing
                });

                // Auto-submit when location changes
                locationSelect.addEventListener("change", function() {
                    form.submit();
                });
            });
        </script>

        <script>
            // //for the pop up and error handling
            // Open the modal when the button is clicked
            document.getElementById('openAddClientModal').addEventListener('click', function() {
                document.getElementById('addClientModal').classList.remove('hidden');
            });

            // for closing the pop up
            document.getElementById('cancelAddClient').addEventListener('click', function() {
                document.getElementById('addClientModal').classList.add('hidden');
            });


            document.getElementById('addClientForm').addEventListener('submit', function(e) {
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

            //success button to refresh the page
            document.getElementById('closeSuccessModal').addEventListener('click', function() {
                document.getElementById('successModal').classList.add('hidden');
                location.reload(); // refresh to update the table
            });
        </script>

        @vite(['resources/js/app.js'])
        <script>
            (function() {
                // Base for /admin/clients/{id}/projects
                const clientProjectsBase = "{{ url('/admin/clients') }}";

                document.addEventListener('click', function(e) {
                    // Ignore clicks inside elements marked data-no-nav
                    if (e.target.closest('[data-no-nav]')) return;

                    // Find the nearest row with a client id
                    const row = e.target.closest('tr[data-client-id]');
                    if (!row) return;

                    const id = row.dataset.clientId;
                    if (!id) return;

                    // Navigate
                    window.location.href = `${clientProjectsBase}/${id}/projects`;
                });
            })();
        </script>

    </x-slot>



</x-layouts.app>
