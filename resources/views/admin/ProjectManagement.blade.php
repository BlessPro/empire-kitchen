<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')



<main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">

    <div class="p-6 bg-[#F9F7F7]">
     <div class="mb-[20px]">
        <div class="flex items-center justify-between mb-6">

 <!-- Top Navbar -->
 <h1 class="text-2xl font-bold">Project Management</h1>

 <button id="openAddProjectModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
     + Add Project
 </button>


 </div>

<!-- Columns (Pending, Ongoing, Completed) -->
<div class="grid grid-cols-1 gap-6 md:grid-cols-4">

    <!-- Pending Column -->
    <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
        <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#F59E0B]">
            <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">{{ $measurements->count() }}</h5></span> Measurement
        </div>
        <div class="pt-5 space-y-5 ">

            <!-- Card Item -->
            @forelse($measurements as $project)
            <a href="{{ route('admin.projects.info', $project->id) }}">

            <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                <h3 class="font-semibold text-gray-800">{{ $project->name }}</h3>
                <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                    <i data-feather="calendar"
                    class="mr-3 text-black feather-icon group "></i> {{ $project->due_date }}
                </div>
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center gap-3">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-8 h-8 rounded-full">
                        <span class="text-sm text-gray-700">{{ $project->client->title. ' '.$project->client->firstname . ' '.$project->client->lastname}}</span>
                    </div>
                    {{-- <div class="flex items-center gap-1 text-sm text-gray-400">
                        💬 0
                    </div> --}}

                                @php
    $unreadCount = $project->comments->filter(fn($c) => $c->unread_by_admin === 0)->count();
@endphp

<div class="text-sm text-gray-500">
     💬 {{ $unreadCount }}
</div>

                </div>
            </div>
        </a>
            @empty
            <p>No projects currently in the Measurement stage.</p>
        @endforelse

            <!-- Another Card -->


        </div>
    </div>

    <!-- Ongoing Column -->
    <div>
        <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
            <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#4F46E5]">
                <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">{{ $designs->count() }}</h5></span> Design
            </div>
            <div class="pt-5 space-y-5 ">

                <!-- Card Item -->
                @forelse($designs as $project)
                <a href="{{ route('admin.projects.info', $project->id) }}">

                <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                    <h3 class="font-semibold text-gray-800">{{ $project->name }}</h3>
                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                        <i data-feather="calendar"
                        class="mr-3 text-black feather-icon group "></i> {{ $project->due_date }}
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-8 h-8 rounded-full">
                            <span class="text-sm text-gray-700">{{ $project->client->title. ' '.$project->client->firstname . ' '.$project->client->lastname}}</span>
                        </div>
                                   @php
    $unreadCount = $project->comments->filter(fn($c) => $c->unread_by_admin === 0)->count();
@endphp

<div class="text-sm text-gray-500">
   💬 {{ $unreadCount }}
</div>
                    </div>
                </div>
            </a>
                @empty
                <p>No projects currently in the Measurement stage.</p>
            @endforelse  <!-- Another Card -->

            </div>
        </div>
    </div>

    <!-- Completed Column -->
    <div>
        <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
            <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#22C55E]">
                <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">{{ $measurements->count() }}</h5></span> Production
            </div>
            <div class="pt-5 space-y-5 ">

                <!-- Card Item -->
                @forelse($productions as $project)
                <a href="{{ route('admin.projects.info', $project->id) }}">

                <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                    <h3 class="font-semibold text-gray-800">{{ $project->name }}</h3>
                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                        <i data-feather="calendar"
                        class="mr-3 text-black feather-icon group "></i> {{ $project->due_date }}
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-8 h-8 rounded-full">
                            <span class="text-sm text-gray-700">{{ $project->client->title. ' '.$project->client->firstname . ' '.$project->client->lastname}}</span>
                        </div>
                        <div class="flex items-center gap-1 text-sm text-gray-400">
                            💬 0
                        </div>
                    </div>
                </div>
            </a>
                @empty
      <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                    <h3 class="font-semibold text-gray-800">No project is currently under installation</h3>


                </div>
                           @endforelse  <!-- Another Card -->
                                    <!-- Card Item -->


            </div>
        </div>
    </div>

     <!-- Another section completed Column -->
     <div>
        <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
            <div class="flex items-center py-2 pl-2 pr-5 text-white rounded-full bg-fuchsia-500">
                <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]
                 items-center"><h5 class="items-center rounded-full px-[10px] py-[10px]
                  text-black">{{ $installations->count() }}</h5></span> Installation
            </div>
            <div class="pt-5 space-y-5 ">

                <!-- Card Item -->
                @forelse($installations as $project)
                <a href="{{ route('admin.projects.info', $project->id) }}">

                <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                    <h3 class="font-semibold text-gray-800">{{ $project->name }}</h3>
                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                        <i data-feather="calendar"
                        class="mr-3 text-black feather-icon group "></i> {{ $project->due_date }}
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-8 h-8 rounded-full">
                            <span class="text-sm text-gray-700">Marilyn Stanton</span>
                        </div>
                        {{-- <div class="flex items-center gap-1 text-sm text-gray-400">
                            💬 0
                        </div> --}}
              @php
    $unreadCount = $project->comments->filter(fn($c) => $c->unread_by_admin === 0)->count();
@endphp

<div class="text-sm text-gray-500">
     💬 {{ $unreadCount }}
</div>


                    </div>
                </div>
            </a>
                @empty
                <p>No projects currently in the Measurement stage.</p>
            @endforelse
                <!-- Another Card -->
                                    <!-- Card Item -->


            </div>
        </div>
    </div>
</div>
{{--
<!-- Add Project Modal -->

<div class="mb-4">
      <label for="tech_supervisor_id" class="block mb-3 text-sm font-medium text-gray-700">Tech Supervisor</label>
      <select name="tech_supervisor_id" id="tech_supervisor_id" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        <option disabled selected>Select a supervisor</option>
        {{-- @foreach ($techSupervisors as $supervisor)
          <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
        @endforeach --}}
         {{-- @foreach ($techSupervisors as $techSupervisor)
                        <option value="{{ $techSupervisor->id }}">
                            <img src="{{ asset('storage/'
                            . $techSupervisor->profile_pic) }}"
                             alt="techSupervisor" width="40" height="40"
                             class="object-cover w-8 h-8 rounded-full">
                            {{ $techSupervisor->name }}</option>
                    @endforeach
      </select>
    </div>
    </div>
      <!--group row 4 ends-->

    <!-- Submit -->
    <button type="submit" class="bg-fuchsia-900 w-full text-[20px] text-white px-4 py-2 rounded">Save Project</button>
</form> --}}
</div>






<!-- Trigger Button -->
<button id="openAddProjectModal" class="px-4 py-2 text-white bg-blue-500 rounded">Add Project</button>

<!-- Modal -->
{{-- <div id="addProjectModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded shadow-md w-[400px]">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">Assign Project to Tech Supervisor</h2>
            <button id="cancelAddProject" class="font-bold text-red-600">X</button>
        </div>

        <form id="addProjectForm">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                <input type="text" name="name" id="name" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="w-full px-3 py-2 border rounded" required></textarea>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" name="location" id="location" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="tech_supervisor_id" class="block mb-2 text-sm font-medium text-gray-700">Tech Supervisor</label>
                <select name="tech_supervisor_id" id="tech_supervisor_id" class="w-full px-3 py-2 border rounded" required>
                    <option disabled selected>Select a supervisor</option>
                    @foreach ($techSupervisors as $techSupervisor)
                        <option value="{{ $techSupervisor->id }}">{{ $techSupervisor->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full px-4 py-2 text-white rounded bg-fuchsia-900">Save Project</button>
        </form>
    </div>
</div> --}}

<!-- Success Modal -->
{{-- <div id="successModal2" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="p-6 bg-white rounded shadow-md">
        <p class="font-semibold text-green-700">Project assigned successfully!</p>
        <button id="closeSuccessModal" class="px-4 py-2 mt-4 text-white bg-green-600 rounded">Close</button>
    </div>
</div> --}}





<!-- Trigger Button -->
<button id="openAddProjectModal" class="px-4 py-2 text-white bg-blue-600 rounded">Add Project</button>

<!-- Modal -->
<div id="addProjectModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-[600px] items-center justify-center relative">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Create New Project</h2>
            <button id="cancelAddProject" class="font-bold text-red-500">X</button>
        </div>

        <form id="addProjectForm">
            @csrf

            <div class="flex flex-col gap-4 sm:flex-row">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Project Name</label>
                <input type="text" name="name" id="name" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"" required>
            </div>


   <div class="mb-4">
                <label for="client_id" class="block text-sm font-medium">Client</label>
                <select name="client_id" id="client_id" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"" required>
                    <option disabled selected>Select a client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->title. ' '.$client->firstname.' '.$client->lastname }}</option>
                    @endforeach
                </select>
            </div>

        </div>


        <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea name="description" id="description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"" required></textarea>
            </div>


        <div class="flex flex-col gap-4 sm:flex-row">
            <div class="mb-4">
                <label for="location" class="block text-sm font-medium">Location</label>
                <input type="text" name="location" id="location" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"" required>
            </div>
            <div class="mb-4">
                <label for="cost" class="block text-sm font-medium">Estimated Cost</label>
                <input type="number" name="cost" id="cost" step="0.01" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"" required>
            </div>

        </div>

            <div class="mb-4">
                <label for="tech_supervisor_id" class="block text-sm font-medium">Technical Supervisor</label>
                <select name="tech_supervisor_id" id="tech_supervisor_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"" required>
                    <option disabled selected>Select a supervisor</option>
                    @foreach ($techSupervisors as $techSupervisor)
                        <option value="{{ $techSupervisor->id }}">{{ $techSupervisor->name }}</option>
                    @endforeach
                </select>
            </div>



        <div class="flex flex-col gap-4 sm:flex-row">
              <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"" required>
            </div>
            <div class="mb-4">
                <label for="due_date" class="block text-sm font-medium">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"" required>
            </div>


        </div>
            <button type="submit" class="w-full px-4 py-2 text-white rounded bg-fuchsia-900">Save Project</button>
        </form>
    </div>
</div>

<!-- Success Modal -->
{{-- <div id="successModal2" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="p-6 bg-white rounded shadow-md">
        <p class="font-semibold text-green-700">Project created successfully!</p>
        <button id="closeSuccessModal" class="px-4 py-2 mt-4 text-white bg-green-600 rounded">Close</button>
    </div>
</div> --}}







<div id="successModal2" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg">
        <div class="flex items-center justify-center w-10 h-10 mb-[10px] bg-fuchsia-100 rounded-full">
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
<!---end of pop up--->


</div>
</div>
</main>

<script>

    // document.getElementById('openAddProjectModal').addEventListener('click', function () {
    //     document.getElementById('addProjectModal').classList.remove('hidden');
    // });
    // document.getElementById('openAddProjectModal').addEventListener('click', function () {
    //         document.getElementById('addProjectModal').classList.remove('hidden');
    //     });
    //       // for the close (X) button
    //       document.getElementById('cancelAddProject').addEventListener('click', function () {
    //         document.getElementById('addProjectModal').classList.add('hidden');
    //     });
    // document.getElementById('addProjectForm').addEventListener('submit', function (e) {
    //     e.preventDefault();





    //     const form = e.target;
    //     const formData = new FormData(form);

    //     fetch("{{ route('projects.store') }}", {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //             'Accept': 'application/json'  // Tell Laravel you want JSON
    //         },
    //         body: formData,
    //     })
    //     .then(async response => {
    //         if (!response.ok) {
    //             const errorData = await response.json();
    //             throw new Error(errorData.message || 'Validation failed');
    //         }
    //         return response.json();
    //     })
    //     .then(data => {
    //         // document.getElementById('addProjectModal').classList.add('hidden');
    //         // // alert('Project created successfully!');
    //         // document.getElementById('successModal').classList.remove('hidden');
    //         // // Optionally refresh data here
    //         if (data)
    //         console.log(data);{

    //         document.getElementById('addProjectModal').classList.add('hidden');
    //         document.getElementById('successModal2').classList.remove('hidden');

    //         //  alert('Project created successfully!');

    //     }
    //     })
    //     .catch(error => {
    //         alert('Error: ' + error.message);
    //     });
    // });


    // //reloading the page
    // document.getElementById('closeSuccessModal').addEventListener('click', function () {
    //         document.getElementById('successModal').classList.add('hidden');
    //         location.reload(); // refresh to update the table
    //     });

        </script>



<script>
    // Open modal
    document.getElementById('openAddProjectModal').addEventListener('click', function () {
        document.getElementById('addProjectModal').classList.remove('hidden');
    });

    // Close modal
    document.getElementById('cancelAddProject').addEventListener('click', function () {
        document.getElementById('addProjectModal').classList.add('hidden');
    });

    // Handle form submission
    document.getElementById('addProjectForm').addEventListener('submit', function (e) {
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
    document.getElementById('closeSuccessModal').addEventListener('click', function () {
        document.getElementById('successModal2').classList.add('hidden');
        location.reload();
    });
</script>

</x-layouts.app>
