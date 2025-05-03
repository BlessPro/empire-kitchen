<x-layouts.app>
    <x-slot name="header">
<!--written on 30.04.2025 @ 9:45-->
    <!-- Main Content -->

    @include('admin.layouts.header')

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">

   {{-- navigation bar --}}
<div class="flex items-center justify-between mb-6">
   <div class="flex items-center justify-between mb-6">
    <span><i data-feather="home" class="w-[5] h-[5] text-fuchsia-900 ml-[3px]"></i></span>
    <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>  
    <a href="{{ route('admin.ClientManagement') }}">
        <h3 class="font-sans font-normal text-black cursor-pointer hover:underline">Clients Management</h3>
    </a>
        <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
</span> <span class="font-semibold text-fuchsia-900">{{ $client->title . ' '.$client->firstname . ' '.$client->lastname }}</span></div>


   {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
    <!-- ADD CLIENT BUTTON -->
    <button id="openAddClientModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
        + Add Client
    </button>

    </div>

   {{-- navigation bar --}}

        <!-- Columns (Pending, Ongoing, Completed)  begins-->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

            <!-- Pending Column begins-->
            <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
                <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#F59E0B]">
                    <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">{{ $pending->count() }}</h5></span> Pending
                </div>
                <div class="pt-5 space-y-5 ">

                    <!-- Card Item  begins-->
                    @foreach ($pending as $project)

                    <div onclick="window.location='{{ route('admin.clients.projects2', $client->id) }}'" class="p-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                        <h3 class="mb-3 font-semibold text-gray-800">{{ $project->name }}</h3>
                        <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                            <i data-feather="calendar"
                            class="mr-3 text-black feather-icon group "></i> <p class="text-sm">{{ $project->created_at->format('F j, Y') }}</p>

                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center gap-3">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-8 h-8 rounded-full">
                                <span class="text-sm text-gray-700"> <p class="text-sm">{{ $project->client->title . ' '.$project->client->firstname . ' '.$project->client->lastname }}</p>
                                </span>
                            </div>
                            <div class="flex items-center gap-1 text-sm text-gray-400">
                                💬 0
                            </div>
                        </div>
                    </div>
                    @endforeach
    <!--another text-semibold-->

                    <!-- Card Item  begins-->
                </div>
            </div>

            <!-- Pending Column begins-->


            <!-- Ongoing Column begins-->
            <div>
                <div onclick="window.location='{{ route('admin.clients.projects2', $client->id) }}'" class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#4F46E5]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">{{ $ongoing->count() }}</h5></span> Ongoing
                    </div>
                    <div class="pt-5 space-y-5 ">

                        <!-- Card Item -->
                        @foreach ($ongoing as $project)

                        <div class="p-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                            <h3 class="mb-3 font-semibold text-gray-800">{{ $project->name }}</h3>
                            <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                <i data-feather="calendar"
                                class="mr-3 text-black feather-icon group "></i> <p class="text-sm">{{ $project->created_at->format('F j, Y') }}</p>

                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-8 h-8 rounded-full">
                                    <span class="text-sm text-gray-700"> <p class="text-sm">{{ $project->client->title . ' '.$project->client->firstname . ' '.$project->client->lastname }}</p>
                                    </span>
                                </div>
                                <div class="flex items-center gap-1 text-sm text-gray-400">
                                    💬 0
                                </div>
                            </div>
                        </div>
                        @endforeach
                             <!-- Card Item ends-->


                    </div>
                </div>
            </div>
            <!-- Ongoing Column begins-->

            <!-- Completed Column begins-->
            <div>
                <div onclick="window.location='{{ route('admin.clients.projects2', $client->id) }}'" class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#22C55E]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">{{ $completed->count() }}</h5></span> Completed
                    </div>
                    <div class="pt-5 space-y-5 ">

                        <!-- Card Item begins-->
                        @foreach ($completed as $project)

                        <div class="p-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                            <h3 class="mb-3 font-semibold text-gray-800">{{ $project->name }}</h3>
                            <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                <i data-feather="calendar"
                                class="mr-3 text-black feather-icon group "></i> <p class="text-sm">{{ $project->created_at->format('F j, Y') }}</p>

                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-8 h-8 rounded-full">
                                    <span class="text-sm text-gray-700"> <p class="text-sm">{{ $project->client->title . ' '.$project->client->firstname . ' '.$project->client->lastname }}</p>
                                    </span>
                                </div>
                                <div class="flex items-center gap-1 text-sm text-gray-400">
                                    💬 0
                                </div>
                            </div>
                        </div>
                        @endforeach
                         <!-- Card Item ends-->


                    </div>
                </div>
            </div>
            <!-- Completed Column ends-->

        </div>
        <!-- Columns (Pending, Ongoing, Completed)  ends-->

<!-- ADD CLIENT MODAL -->
<div id="addClientModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-[600px] items-center justify-center relative">
        <div class="flex flex-col justify-between gap-4 mb-4 sm:flex-row">
        <h2 class="mb-4 text-xl font-semibold">Add New Client</h2>
        <button type="button" id="cancelAddClient" class="px-4 py-2 text-black "> <i data-feather="x"
    class="mr-3 feather-icon group"></i></button>
        </div>
        <form id="addClientForm" method="POST">
            @csrf

<div class="flex flex-col gap-4 sm:flex-row">
              <!-- First Name -->
            <div class="mb-4">
                <label for="firstName" class="block mb-3 text-sm font-medium text-gray-700">First Name</label>
                <input
                id="firstName" name="firstname"
                  type="text"
                  placeholder="Enter first name"
                  class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <!-- Last Name -->
              <div class="mb-4">
                <label for="lastName" class="block mb-3 text-sm font-medium text-gray-700">Last Name</label>
                <input
                id="lastName" name="lastname"  id="lastName"
                  placeholder="Enter last name"
                  class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>
            </div>


            <div class="flex flex-col gap-4 sm:flex-row">
              <!-- Other Names -->
              <div class="mb-4">
                <label for="otherNames" class="block mb-3 text-sm font-medium text-gray-700">Other Names</label>
                <input
                  type="text"
                  id="otherNames" name="othernames"                  placeholder="Enter other name"
                  class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <!-- Title Dropdown -->
              <div class="mb-4">
                <label for="title" class="block mb-3 text-sm font-medium text-gray-700">Title</label>
                <select name="title"
                  id="title"
                  class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="" disabled selected>Select Title</option>
                  <option value="Mr">Mr</option>
                  <option value="Mrs">Mrs</option>
                  <option value="Ms">Ms</option>
                  <option value="Bro">Bro</option>
                </select>
              </div>
            </div>

              <!-- Phone Number -->
              <div class="flex flex-col gap-4 sm:flex-row">
              <div class="mb-4">
                <label for="phone" class="block mb-3 text-sm font-medium">Phone Number</label>
                <input
                  type="tel"
                  id="phone" name="phone_number" placeholder="Enter phone number"
                  class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none text-gray-200 focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <!-- Location -->
              <div class="mb-6">
                <label for="location" class="block mb-3 text-sm font-medium text-gray-700">Location</label>
                <input
                  type="text"
                  id="location" name="location"
                  placeholder="Enter location"
                  class="w-[270px] px-3 py-2 border border-gray-300 rounded-md text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>
              </div>

              <!-- Submit Button -->

                <button type="submit" class="bg-fuchsia-900 w-full text-[20px] text-white px-4 py-2 rounded">Save Client</button>
            </div>
              {{-- <button
                type="submit"
                class="w-[270px] bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
              >
                Save Client
              </button> --}}
        </form>
    </div>

    {{-- Client modal ends --}}
{{-- SUCCESS MODAL BEGINS --}}
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
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
    </div>
</div>
</main>
<script>
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

        fetch("{{ route('clients.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData,
        })
        .then(response => {
            if (!response.ok) throw new Error('Something went wrong');
            return response.json();
        })
        .then(data => {
            // Close form modal and show success modal
            document.getElementById('addClientModal').classList.add('hidden');
            document.getElementById('successModal').classList.remove('hidden');
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

    @vite(['resources/js/app.js'])

</x-slot>



</x-layouts.app>

