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
                    <div class="flex items-center gap-1 text-sm text-gray-400">
                        💬 0
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
                        <div class="flex items-center gap-1 text-sm text-gray-400">
                            💬 0
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
                        <div class="flex items-center gap-1 text-sm text-gray-400">
                            💬 0
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
         @foreach ($techSupervisors as $techSupervisor)
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
</form>
</div>

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
    document.getElementById('openAddProjectModal').addEventListener('click', function () {
            document.getElementById('addProjectModal').classList.remove('hidden');
        });
          // for the close (X) button
          document.getElementById('cancelAddProject').addEventListener('click', function () {
            document.getElementById('addProjectModal').classList.add('hidden');
        });
    document.getElementById('addProjectForm').addEventListener('submit', function (e) {
        e.preventDefault();





        const form = e.target;
        const formData = new FormData(form);

        fetch("{{ route('projects.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'  // Tell Laravel you want JSON
            },
            body: formData,
        })
        .then(async response => {
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Validation failed');
            }
            return response.json();
        })
        .then(data => {
            // document.getElementById('addProjectModal').classList.add('hidden');
            // // alert('Project created successfully!');
            // document.getElementById('successModal').classList.remove('hidden');
            // // Optionally refresh data here
            if (data)
            console.log(data);{

            document.getElementById('addProjectModal').classList.add('hidden');
            document.getElementById('successModal2').classList.remove('hidden');

            //  alert('Project created successfully!');

        }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });


    //reloading the page
    document.getElementById('closeSuccessModal').addEventListener('click', function () {
            document.getElementById('successModal').classList.add('hidden');
            location.reload(); // refresh to update the table
        });

        </script>
    </x-slot>
</x-layouts.app>
