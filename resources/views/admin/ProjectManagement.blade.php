<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')
    </x-slot>


    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">

        <div class="p-6 bg-[#F9F7F7]">
            <div class="mb-[20px]">
                <div class="flex items-center justify-between mb-6">

                    <!-- Top Navbar -->
                    <h1 class="text-2xl font-bold">Project Management</h1>

                    <a href="{{ route('admin.addproject') }}">
                    <button  class="px-6 py-2 text-semibold text-[15px]
                     text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                        + Add Project
                    </button>
                </a>

                </div>
    <div class="flex items-center justify-between mb-6">
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

                <!-- Columns (Pending, Ongoing, Completed) -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-4">

                    <!-- Pending Column -->
                    <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
                        <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#F59E0B]">
                            <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center">
                                <h5 class="items-center rounded-full px-[10px] py-[10px] text-black">
                                    {{ $measurements->count() }}</h5>
                            </span> Measurement
                        </div>
                        <div class="pt-2 space-y-5 ">

                            <!-- Card Item -->
                            @forelse($measurements as $project)
                                {{-- <a href="{{ route('admin.projects.info', $project->id) }}"> --}}
                                <a>

                                    <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-normal text-gray-800 text-[15px]">{{ $project->name }}</h3>

                                            <div class="p-3 font-normal text-[15px] cursor-pointer relative"
                                                x-data="{ open: false }">
                                                <!-- Trigger -->
                                                <button id="More" class="focus:outline-none">
                                                    <iconify-icon icon="mingcute:more-2-line" width="22"
                                                        style="color: #5A0562;"></iconify-icon>
                                                </button>

                                                <!-- Dropdown Menu -->
                                                <div id="MorePopup"
                                                    class="absolute right-0 z-50 hidden w-48 mt-2 bg-white border border-gray-100 shadow-lg rounded-xl">
                                                    <ul class="py-2 text-[15px] text-gray-700">

                                                        <li>
                                                            <a href="#"
                                                                class="block px-4 py-2 hover:bg-gray-100 assign-tech-trigger"
                                                                data-project-id="{{ $project->id }}"
                                                                data-project-name="{{ $project->name }}"
                                                                data-project-pic="{{ $project->cover_url ?? ($project->client->profile_pic_url ?? '') }}">
                                                                Assign Supervisor
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a id="openAddProjectModal"
                                                                class="block px-4 py-2 hover:bg-gray-100">
                                                                Add new project
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="block w-full px-4 py-2 text-left text-red-600 rounded-b-lg hover:bg-gray-100">
                                                                    Duplicate project
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>




                                        </div>
                                        <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                            {{-- <i data-feather="calendar"
                    class="mr-3 text-black feather-icon group "></i> --}}
                                            <iconify-icon icon="uis:calender" width="22"
                                                style="color: #5A0562;"></iconify-icon>
                                            {{ $project->due_date }}
                                        </div>
                                        <div class="flex items-center justify-between mt-4">
                                            <div class="flex items-center gap-3">
                                                <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                    alt="Client" class="w-8 h-8 rounded-full">
                                                <span
                                                    class="text-sm text-gray-700">{{ $project->client->title . ' ' . $project->client->firstname . ' ' . $project->client->lastname }}</span>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                    <h3 class="font-semibold text-gray-800">No project is currently under
                                        measurement</h3>
                                </div>
                            @endforelse

                            <!-- Another Card -->


                        </div>
                    </div>

                    <!-- Ongoing Column -->
                    <div>
                        <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
                            <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#4F46E5]">
                                <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center">
                                    <h5 class="items-center rounded-full px-[10px] py-[10px] text-black">
                                        {{ $designs->count() }}</h5>
                                </span> Design
                            </div>
                            <div class="pt-5 space-y-5 ">

                                <!-- Card Item -->
                                @forelse($designs as $project)
                                    <a href="{{ route('admin.projects.info', $project->id) }}">

                                        <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                            <h3 class="font-semibold text-gray-800">{{ $project->name }}</h3>
                                            <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                                <i data-feather="calendar"
                                                    class="mr-3 text-black feather-icon group "></i>
                                                {{ $project->due_date }}
                                            </div>
                                            <div class="flex items-center justify-between mt-4">
                                                <div class="flex items-center gap-3">
                                                    <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                        alt="Client" class="w-8 h-8 rounded-full">
                                                    <span
                                                        class="text-sm text-gray-700">{{ $project->client->title . ' ' . $project->client->firstname . ' ' . $project->client->lastname }}</span>
                                                </div>
                                                @php
                                                    $unreadCount = $project->comments
                                                        ->filter(fn($c) => $c->unread_by_admin === 0)
                                                        ->count();
                                                @endphp

                                                <div class="text-sm text-gray-500">
                                                    💬 {{ $unreadCount }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                        <h3 class="font-semibold text-gray-800">No project is currently under
                                            design</h3>


                                    </div>
                                @endforelse <!-- Another Card -->

                            </div>
                        </div>
                    </div>

                    <!-- Completed Column -->
                    <div>
                        <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
                            <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#22C55E]">
                                <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center">
                                    <h5 class="items-center rounded-full px-[10px] py-[10px] text-black">
                                        {{ $measurements->count() }}</h5>
                                </span> Production
                            </div>
                            <div class="pt-5 space-y-5 ">

                                <!-- Card Item -->
                                @forelse($productions as $project)
                                    <a href="{{ route('admin.projects.info', $project->id) }}">

                                        <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                            <h3 class="font-semibold text-gray-800">{{ $project->name }}</h3>
                                            <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                                <i data-feather="calendar"
                                                    class="mr-3 text-black feather-icon group "></i>
                                                {{ $project->due_date }}
                                            </div>
                                            <div class="flex items-center justify-between mt-4">
                                                <div class="flex items-center gap-3">
                                                    <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                        alt="Client" class="w-8 h-8 rounded-full">
                                                    <span
                                                        class="text-sm text-gray-700">{{ $project->client->title . ' ' . $project->client->firstname . ' ' . $project->client->lastname }}</span>
                                                </div>
                                                <div class="flex items-center gap-1 text-sm text-gray-400">
                                                    💬 0
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                        <h3 class="font-semibold text-gray-800">No project is currently under
                                            production</h3>


                                    </div>
                                @endforelse <!-- Another Card -->
                                <!-- Card Item -->


                            </div>
                        </div>
                    </div>

                    <!-- Another section completed Column -->
                    <div>
                        <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
                            <div class="flex items-center py-2 pl-2 pr-5 text-white rounded-full bg-fuchsia-500">
                                <span
                                    class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]
                 items-center">
                                    <h5
                                        class="items-center rounded-full px-[10px] py-[10px]
                  text-black">
                                        {{ $installations->count() }}</h5>
                                </span> Installation
                            </div>
                            <div class="pt-5 space-y-5 ">

                                <!-- Card Item -->
                                @forelse($installations as $project)
                                    <a href="{{ route('admin.projects.info', $project->id) }}">

                                        <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                            <h3 class="font-semibold text-gray-800">{{ $project->name }}</h3>
                                            <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                                <i data-feather="calendar"
                                                    class="mr-3 text-black feather-icon group "></i>
                                                {{ $project->due_date }}
                                            </div>
                                            <div class="flex items-center justify-between mt-4">
                                                <div class="flex items-center gap-3">
                                                    <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                        alt="Client" class="w-8 h-8 rounded-full">
                                                    <span class="text-sm text-gray-700">Marilyn Stanton</span>
                                                </div>
                                                {{-- <div class="flex items-center gap-1 text-sm text-gray-400">
                            💬 0
                        </div> --}}
                                                @php
                                                    $unreadCount = $project->comments
                                                        ->filter(fn($c) => $c->unread_by_admin === 0)
                                                        ->count();
                                                @endphp

                                                <div class="text-sm text-gray-500">
                                                    💬 {{ $unreadCount }}
                                                </div>


                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                        <h3 class="font-semibold text-gray-800">No project is currently under
                                            installation</h3>


                                    </div>
                                @endforelse
                                <!-- Another Card -->
                                <!-- Card Item -->


                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trigger Button -->
                {{-- <button id="openAddProjectModal" class="px-4 py-2 text-white bg-blue-500 rounded">Add Project</button>




                <!-- Trigger Button -->
                <button id="openAddProjectModal" class="px-4 py-2 text-white bg-blue-600 rounded">Add Project</button> --}}

                <!-- Modal -->
                <div id="addProjectModal"
                    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg p-6 w-[450px] items-center justify-center relative">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold">Create New Project</h2>
                            <button id="cancelAddProject" class="font-bold">
                                <iconify-icon icon="iconamoon:close-light" width="22" style="color: #5A0562;">
                                </iconify-icon></button>
                        </div>

                        <form id="addProjectForm">
                            @csrf


                            <div class="mb-4">
                                <label for="client_id"
                                    class="block mb-3 text-sm font-medium text-gray-700">Client</label>
                                <select name="client_id" id="client_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option disabled selected>Select a client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">
                                            {{ $client->title . ' ' . $client->firstname . ' ' . $client->lastname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-4">
                                <label for="name" class="block mb-3 text-sm font-medium text-gray-700">Project
                                    Name</label>
                                <input type="text" name="name" id="name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>


                            <button type="submit" class="w-full px-4 py-2 text-white rounded bg-fuchsia-900">
                                Create Project</button>
                        </form>
                    </div>
                </div>


                <div id="successModal2"
                    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                    <div class="w-full max-w-sm p-6 bg-white rounded-lg">
                        <div class="flex items-center justify-center w-10 h-10 mb-[10px] bg-fuchsia-100 rounded-full">
                            <i data-feather="user-plus" class="text-fuchsia-900 ml-[3px] text-center"></i>
                        </div>
                        <h2 class="mb-4 text-lg font-semibold text-left">Product successfully created</h2>
                        {{-- <p class="text-left">Do you want to add product now</p> --}}
                        <!-- Right-Aligned Button -->
                        <div class="flex justify-end mt-6">
                            <button id="closeSuccessModalYes"
                                class="px-4 py-2 mr-4 text-white rounded-full bg-fuchsia-900">
                                <a  ">
                                    Ok
                                </a>
                            </button>


                        </div>
                    </div>
                </div>

                <!---end of pop up--->
                <!--Assign Tech Supervisor Modal-->
                <div id="assignTechModal"
                    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                    <div class="w-full max-w-md p-6 bg-white rounded shadow-md">
                        <div class="flex flex-col justify-between gap-4 mb-4 sm:flex-row">
                            <h2 class="mb-4 text-xl font-semibold">Assign Tech Supervisor</h2>
                            <button type="button" onclick="closeTechModal()"
                                class="px-4 py-2 mt-2 rounded text-fuchsia-900">
                                <i data-feather="x" class="mr-3 feather-icon group"></i>
                            </button>
                        </div>

                        <form method="POST" action="{{ route('tech.assignSupervisor') }}">
                            @csrf
                            <input type="hidden" name="project_id" id="projectIdInput">

                            <!-- Project Name -->
                            <div class="mb-4">
                                <label class="block mb-1 text-sm font-medium">Project Name</label>
                                <input type="text" id="projectNameInput" disabled readonly
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>

                            <!-- Select Supervisor -->
                            <div class="mb-4 max-h-[300px] overflow-y-auto space-y-4">
                                <label class="block mb-2 text-sm font-medium">Select Supervisor</label>

                                @foreach ($supervisors as $supervisor)
                                    <label
                                        class="flex items-center justify-between p-2 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-100">
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ asset('storage/' . $supervisor->profile_pic) }}"
                                                alt="Supervisor" class="object-cover w-10 h-10 rounded-full">
                                            <span class="font-medium text-gray-800">{{ $supervisor->name }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Submit -->
                            <div class="flex justify-end space-x-2">
                                <button type="submit"
                                    class="bg-fuchsia-900 w-full text-[20px] text-white px-4 py-2 mt-5 rounded-[20px]">
                                    Proceed
                                </button>
                            </div>
                        </form>
                    </div>
                </div>




            </div>
        </div>
    </main>


    // assign tech supervisor




    <script>
        // Ensure the backdrop container can center content (optional UI fix)
        // Add 'flex' to your modal container if not present:
        // <div id="assignTechModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">

        // Cache elements
        const techModal = document.getElementById('assignTechModal');
        const projectIdInput = document.getElementById('projectIdInput');
        const projectNameInput = document.getElementById('projectNameInput');
        const projectPic = document.getElementById('projectPicPreview');
        const form = techModal?.querySelector('form');

        function openTechModal({
            id = '',
            name = '',
            pic = ''
        } = {}) {
            if (projectIdInput) projectIdInput.value = id;
            if (projectNameInput) projectNameInput.value = name;

            if (projectPic) {
                if (pic) {
                    projectPic.src = pic;
                    projectPic.classList.remove('hidden');
                } else {
                    projectPic.src = '';
                    projectPic.classList.add('hidden');
                }
            }

            techModal?.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // lock scroll
        }

        function closeTechModal() {
            techModal?.classList.add('hidden');
            document.body.style.overflow = ''; // restore scroll
        }

        // Make closeTechModal available to your inline onclick
        window.closeTechModal = closeTechModal;

        // Wire all triggers on the page
        document.querySelectorAll('.assign-tech-trigger').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                openTechModal({
                    id: trigger.getAttribute('data-project-id') || '',
                    name: trigger.getAttribute('data-project-name') || '',
                    pic: trigger.getAttribute('data-project-pic') || ''
                });
            });
        });

        // Close when clicking the shaded backdrop
        techModal?.addEventListener('click', (e) => {
            if (e.target === techModal) closeTechModal();
        });

        // Close on Esc
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && techModal && !techModal.classList.contains('hidden')) {
                closeTechModal();
            }
        });

        // After assign: close the modal
        // If you're using normal form POST, the page will navigate/refresh anyway.
        // If you want to keep the page and submit via AJAX, uncomment the block below and set your route to return JSON.
        /*
        form?.addEventListener('submit', async (e) => {
          e.preventDefault();
          const url = form.action;
          const data = new FormData(form);
          const res = await fetch(url, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: data
          });
          if (res.ok) {
            closeTechModal();
            // TODO: update UI (badge, assigned label) without reload
          } else {
            // TODO: show error toast/message
          }
        });
        */
    </script>



    <!-- Example Modal -->
    <div id="MorePopup" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div id="MoreContent" class="p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold">Popup Content</h2>
            <p class="mt-2">This is the popup body.</p>
        </div>
    </div>

    <script>
        const moreBtn = document.getElementById('More');
        const popup = document.getElementById('MorePopup');
        const popupContent = document.getElementById('MoreContent');

        function openMore() {
            popup.classList.remove('hidden');
        }

        function closeMore() {
            popup.classList.add('hidden');
        }

        // Open on button click
        moreBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation(); // prevent the document click from closing immediately
            openMore();
        });

        // Close when clicking outside (anywhere not inside popup OR the button)
        document.addEventListener('click', (e) => {
            const clickedOutsidePopup = !popup.contains(e.target);
            const clickedOutsideBtn = !moreBtn.contains(e.target);
            if (clickedOutsidePopup && clickedOutsideBtn) closeMore();
        });

        // Close when clicking a menu item inside the popup (li/a/button)
        popupContent.addEventListener('click', (e) => {
            const menuItem = e.target.closest('a, button, li, [data-close]');
            if (menuItem) closeMore(); // let the item’s default action continue (e.g., open another modal)
        });

        // Optional: close on Esc
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeMore();
        });
    </script>



    <script>
        // Open modal
        document.getElementById('openAddProjectModal').addEventListener('click', function() {
            document.getElementById('addProjectModal').classList.remove('hidden');
        });

        // Close modal
        document.getElementById('cancelAddProject').addEventListener('click', function() {
            document.getElementById('addProjectModal').classList.add('hidden');
        });

        // Handle form submission
        document.getElementById('addProjectForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("{{ route('projects.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async response => {
                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Validation error occurred');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data) {
                        console.log(data);
                        document.getElementById('addProjectModal').classList.add('hidden');
                        document.getElementById('successModal2').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
        });

        // Close success modal and reload
        document.getElementById('closeSuccessModal').addEventListener('click', function() {
            document.getElementById('successModal2').classList.add('hidden');
            location.reload();
        });
    </script>

</x-layouts.app>
