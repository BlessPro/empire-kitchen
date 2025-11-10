<x-layouts.app>
    <!-- Main Content -->
        <!--head begins-->

            <div class="p-4 sm:p-6">
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
            {{-- Columns --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Measurement --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#F59E0B]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 class="px-[10px] py-[10px] text-black">{{ ($measurements ?? collect())->count() }}</h5>
                        </span>
                        Measurement
                    </div>
                    <div class="pt-2 space-y-5">
                        @forelse(($measurements ?? collect()) as $project)
                            <div class="relative p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">

                                {{-- makes the whole card clickable --}}
                                {{-- <a href="{{ route('admin.projectInfo') }}" class="absolute inset-0 z-10"
                                    aria-label="Open project info"></a> --}}
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="absolute inset-0 z-10"
                                    aria-label="Open {{ $project->name }}"></a>

                                {{-- card content sits above background but below menu --}}
                                <div class="relative z-20">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-normal text-gray-800 text-[15px]">{{ $project->name }}</h3>

                                        {{-- 3-dot menu stays above the stretched link --}}
                                        <div class="relative z-30">
                                            <div class="relative" data-no-nav>
                                                <button class="p-3 more-trigger" data-project="{{ $project->id }}"
                                                    aria-haspopup="menu" aria-expanded="false">
                                                    <iconify-icon icon="mingcute:more-2-line" width="22"
                                                        style="color:#5A0562;"></iconify-icon>
                                                </button>

                                                <div class="more-menu absolute right-0 z-50 hidden w-48 mt-2 bg-white border border-gray-100 shadow-lg rounded-xl"
                                                    data-project="{{ $project->id }}" role="menu">
                                                    <ul class="py-2 text-[15px] text-gray-700">
                                                        <li>
                                                            <a href="#"
                                                                class="assign-trigger block px-4 py-2 hover:bg-gray-100"
                                                                data-project-id="{{ $project->id }}"
                                                                data-project-name="{{ $project->name }}"
                                                                data-current-id="{{ $project->tech_supervisor_id ?? '' }}"
                                                                data-no-nav onclick="event.preventDefault();">
                                                                Assign Supervisor
                                                            </a>
                                                        </li>


                                                      

                                                        <li>
 <a href="#"
   class="add-product-trigger block px-4 py-2 hover:bg-gray-100"
   data-project-id="{{ $project->id }}"
   data-project-name="{{ $project->name }}"
   onclick="event.preventDefault();">
  Add new product
</a>

</li>


                                                        <li>

                                                            <button type="button"
                                                                class="block w-full px-4 py-2 text-left hover:bg-gray-100"
                                                                onclick="duplicateProject({{ $project->id }})">
                                                                Duplicate project
                                                            </button>

                                                            {{-- <button type="button"
                                                                class="duplicate-project-trigger block w-full px-4 py-2 text-left text-red-600 hover:bg-gray-100"
                                                                data-project-id="{{ $project->id }}" data-no-nav>
                                                                Duplicate project
                                                            </button> --}}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            {{-- your dropdown… --}}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                        <iconify-icon icon="uis:calender" width="22"
                                            style="color:#5A0562;"></iconify-icon>
                                        {{ $project->due_date }}
                                    </div>

                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                class="w-8 h-8 rounded-full" alt="">
                                            <span class="text-sm text-gray-700">
                                                {{ $project->client?->title . ' ' . $project->client?->firstname . ' ' . $project->client?->lastname }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 mb-5 bg-white rounded-[20px] shadow">
                                <h3 class="font-semibold text-gray-800">No project is currently under measurement</h3>
                            </div>
                        @endforelse

                    </div>

                </div>

                {{-- Design --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#4F46E5]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 class="px-[10px] py-[10px] text-black">{{ ($designs ?? collect())->count() }}</h5>
                        </span>
                        Design
                    </div>
                    <div class="pt-2 space-y-5">
                        @forelse(($designs ?? collect()) as $project)
                            <div class="relative p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">

                                {{-- makes the whole card clickable --}}
                                {{-- <a href="{{ route('admin.projectInfo') }}" class="absolute inset-0 z-10"
                                    aria-label="Open project info"></a> --}}
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="absolute inset-0 z-10"
                                    aria-label="Open {{ $project->name }}"></a>

                                {{-- card content sits above background but below menu --}}
                                <div class="relative z-20">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-normal text-gray-800 text-[15px]">{{ $project->name }}</h3>

                                        {{-- 3-dot menu stays above the stretched link --}}
                                        <div class="relative z-30">
                                            <div class="relative" data-no-nav>
                                                <button class="p-3 more-trigger" data-project="{{ $project->id }}"
                                                    aria-haspopup="menu" aria-expanded="false">
                                                    <iconify-icon icon="mingcute:more-2-line" width="22"
                                                        style="color:#5A0562;"></iconify-icon>
                                                </button>

                                            </div>

                                            {{-- your dropdown… --}}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                        <iconify-icon icon="uis:calender" width="22"
                                            style="color:#5A0562;"></iconify-icon>
                                        {{ $project->due_date }}
                                    </div>

                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                class="w-8 h-8 rounded-full" alt="">
                                            <span class="text-sm text-gray-700">
                                                {{ $project->client?->title . ' ' . $project->client?->firstname . ' ' . $project->client?->lastname }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 mb-5 bg-white rounded-[20px] shadow">
                                <h3 class="font-semibold text-gray-800">No project is currently under measurement</h3>
                            </div>
                        @endforelse

                    </div>
                </div>

                {{-- Production --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#22C55E]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 class="px-[10px] py-[10px] text-black">{{ ($productions ?? collect())->count() }}</h5>
                        </span>
                        Production
                    </div>



                <div class="pt-2 space-y-5">
                        @forelse(($productions ?? collect()) as $project)
                            <div class="relative p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">

                                {{-- makes the whole card clickable --}}
                                {{-- <a href="{{ route('admin.projectInfo') }}" class="absolute inset-0 z-10"
                                    aria-label="Open project info"></a> --}}
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="absolute inset-0 z-10"
                                    aria-label="Open {{ $project->name }}"></a>

                                {{-- card content sits above background but below menu --}}
                                <div class="relative z-20">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-normal text-gray-800 text-[15px]">{{ $project->name }}</h3>

                                        {{-- 3-dot menu stays above the stretched link --}}
                                        <div class="relative z-30">
                                            <div class="relative" data-no-nav>
                                                <button class="p-3 more-trigger" data-project="{{ $project->id }}"
                                                    aria-haspopup="menu" aria-expanded="false">
                                                    <iconify-icon icon="mingcute:more-2-line" width="22"
                                                        style="color:#5A0562;"></iconify-icon>
                                                </button>

                                            </div>

                                            {{-- your dropdown… --}}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                        <iconify-icon icon="uis:calender" width="22"
                                            style="color:#5A0562;"></iconify-icon>
                                        {{ $project->due_date }}
                                    </div>

                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                class="w-8 h-8 rounded-full" alt="">
                                            <span class="text-sm text-gray-700">
                                                {{ $project->client?->title . ' ' . $project->client?->firstname . ' ' . $project->client?->lastname }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 mb-5 bg-white rounded-[20px] shadow">
                                <h3 class="font-semibold text-gray-800">No project is currently under measurement</h3>
                            </div>
                        @endforelse

                    </div>

                </div>

                {{-- Installation --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center py-2 pl-2 pr-5 text-white rounded-full bg-fuchsia-500">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 class="px-[10px] py-[10px] text-black">{{ ($installations ?? collect())->count() }}
                            </h5>
                        </span>
                        Installation
                    </div>


                <div class="pt-2 space-y-5">
                        @forelse(($installations ?? collect()) as $project)
                            <div class="relative p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">

                                {{-- makes the whole card clickable --}}
                                {{-- <a href="{{ route('admin.projectInfo') }}" class="absolute inset-0 z-10"
                                    aria-label="Open project info"></a> --}}
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="absolute inset-0 z-10"
                                    aria-label="Open {{ $project->name }}"></a>

                                {{-- card content sits above background but below menu --}}
                                <div class="relative z-20">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-normal text-gray-800 text-[15px]">{{ $project->name }}</h3>

                                        {{-- 3-dot menu stays above the stretched link --}}
                                        <div class="relative z-30">
                                            <div class="relative" data-no-nav>
                                                <button class="p-3 more-trigger" data-project="{{ $project->id }}"
                                                    aria-haspopup="menu" aria-expanded="false">
                                                    <iconify-icon icon="mingcute:more-2-line" width="22"
                                                        style="color:#5A0562;"></iconify-icon>
                                                </button>

                                            </div>

                                            {{-- your dropdown… --}}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                        <iconify-icon icon="uis:calender" width="22"
                                            style="color:#5A0562;"></iconify-icon>
                                        {{ $project->due_date }}
                                    </div>

                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                class="w-8 h-8 rounded-full" alt="">
                                            <span class="text-sm text-gray-700">
                                                {{ $project->client?->title . ' ' . $project->client?->firstname . ' ' . $project->client?->lastname }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 mb-5 bg-white rounded-[20px] shadow">
                                <h3 class="font-semibold text-gray-800">No project is currently under measurement</h3>
                            </div>
                        @endforelse

                    </div>

                </div>
            </div>
<!-- ADD CLIENT MODAL -->
    <div id="addClientModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-[600px] items-center justify-center relative">
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
                  class="w-full md:w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <!-- Last Name -->
              <div class="mb-4">
                <label for="lastName" class="block mb-3 text-sm font-medium text-gray-700">Last Name</label>
                <input
                id="lastName" name="lastname"  id="lastName"
                  placeholder="Enter last name"
                  class="w-full md:w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                  class="w-full md:w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <!-- Title Dropdown -->
              <div class="mb-4">
                <label for="title" class="block mb-3 text-sm font-medium text-gray-700">Title</label>
                <select name="title"
                  id="title"
                  class="w-full md:w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                  class="w-full md:w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none text-gray-200 focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <!-- Location -->
              <div class="mb-6">
                <label for="location" class="block mb-3 text-sm font-medium text-gray-700">Location</label>
                <input
                  type="text"
                  id="location" name="location"
                  placeholder="Enter location"
                  class="w-full md:w-[270px] px-3 py-2 border border-gray-300 rounded-md text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>
              </div>

              <!-- Submit Button -->

                <button type="submit" class="bg-fuchsia-900 w-full text-[20px] text-white px-4 py-2 rounded">Save Client</button>
            </div>
              {{-- <button
                type="submit"
                class="w-full md:w-[270px] bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
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
    });</script>

 



</x-layouts.app>
