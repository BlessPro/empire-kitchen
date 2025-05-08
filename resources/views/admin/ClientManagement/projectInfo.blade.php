<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')


        @php
        $statusClasses = [
            'in progress' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
            'completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
            'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
        ];


        $defaultClass = 'bg-gray-100 text-gray-800';
    @endphp
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
        </h3>

        <span><span class="mr-[12px] font-normal text-black-900">{{$project->client->title . ' '.$project->client->firstname . ' '.$project->client->lastname }}</span> </span>
        <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
        <h3 class="font-semibold text-fuchsia-900">{{ $project->name}}</h3>

    </div>



    {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
     <!-- ADD CLIENT BUTTON -->
     <button id="openAddClientModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
         + Add Client
     </button>

     </div>
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <!-- Left Section: Project Info -->
                        <div class="p-6 bg-white shadow lg:col-span-2 rounded-xl">
                          <!-- Breadcrumbs -->


                          <!-- Project Header -->
                          {{-- <div class="flex items-start justify-between">
                            <div>

                              <h2 class="text-2xl font-semibold text-gray-800">Wardrobe</h2>
                              <span class="inline-block mt-1 px-3 py-0.5 text-xs bg-green-100 text-green-600 rounded-full">Completed</span>
                            </div>
                            <div class="flex text-sm text-right text-gray-600">
                              <span><i data-feather="home" class="text-fuchsia-900 mr-[12px] ml-[3px]"></i></span>       </span><span class="mr-[12px] font-semibold text-fuchsia-900">{{ $client->title . ' '.$client->firstname . ' '.$client->lastname }}</span> </span>
                            </div>
                          </div> --}}


                          <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-semibold text-gray-800 mr-[12px] ">{{ $project->name}}</h2>
                                <span class="inline-block mt-1 px-3 py-0.5 text-xs bg-green-100 text-green-600 rounded-full ml-[6px] {{ $statusClasses[$project->status] ?? $defaultClass }}">{{ $project->status}}</span>


                            </div>

                             <!-- ADD CLIENT BUTTON -->
                             <div class="flex text-sm text-right text-gray-600">
                                <span><i data-feather="home" class="text-fuchsia-900 mr-[12px] ml-[3px]"></i></span>       </span><span class="mr-[12px] font-semibold text-fuchsia-900">{{$project->client->title . ' '.$project->client->firstname . ' '.$project->client->lastname }}</span> </span>
                              </div>

                             </div>

                          <!-- Project Details -->
                          <div class="mt-6 space-y-4 text-sm text-gray-700">
                            <div class="flex items-center gap-2">
                              <span class="font-medium">Due Date:</span>
                              <span>{{ $project->due_date}}</span>
                            </div>
                            <div class="flex items-center gap-2">
                              <span class="font-medium">Address:</span>
                              <span><span class="mr-[12px] font-normal text-black-900">{{ $project->client->location }}</span> </span>
                            </div>
                            <div class="flex items-center gap-2">
                              <span class="font-medium">Tech Supervisor:</span>

                              <span><span class="mr-[12px] font-normal text-black-900">{{ $project->techSupervisor?->name ?? 'Not Assigned' }}</span> </span>

                          </div>
                        </div>

                          <!-- Additional Note -->
                          <div class="mt-6">
                            <h3 class="text-sm font-semibold text-gray-800">Additional Note</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ $project->description}}                          </p>
                          </div>

                          <!-- Measurement -->



                          <div class="mt-6">
                            <h3 class="mb-2 text-sm font-semibold text-gray-800">Measurement (in length, width, height)</h3>
                            <div class="flex gap-4">
                                @foreach ($project->measurement as $measurement)

                              <div class="flex items-center gap-1">
                                📐 <span>   <p>Length: {{ $measurement->length }}</p>
                                </span>
                              </div>
                              <div class="flex items-center gap-1">
                                📐 <span><p>Width: {{ $measurement->width }}</p>
                                </span>
                              </div>
                              <div class="flex items-center gap-1">
                                📐 <span><p>Length: {{ $measurement->height }}</p>
                                </span>
                              </div>
                              @endforeach

                            </div>
                          </div>

{{--
                          <h2>Measurements</h2>
                          <ul>
                              @foreach ($project->measurements as $measurement)
                                  <li>{{ $measurement->measurement_detail }}</li>
                              @endforeach
                          </ul>

                          <h2>Installations</h2>
                          <ul>
                              @foreach ($project->installations as $installation)
                                  <li>{{ $installation->installation_detail }}</li>
                              @endforeach
                          </ul>

                          <h2>Designs</h2>
                          <ul>
                              @foreach ($project->designs as $design)
                                  <li>{{ $design->design_detail }}</li>
                              @endforeach
                          </ul> --}}

                          <!-- Attachments -->
                          <div class="mt-6">
                            <h3 class="mb-2 text-sm font-semibold text-gray-800">Design attachment</h3>
                            <ul class="space-y-2">
                                @foreach ($project->design as $design)

                              <li class="flex items-center justify-between p-3 bg-gray-100 rounded">
                                <div>
                                  <img src="{{$project->design_image_path}}">
                                  <p class="text-xs text-gray-500">Uploaded on {{ $design->uploaded_at }}</p>
                                </div>
                                {{-- <div class="flex gap-3 text-purple-600">
                                  👁️ 📥
                                </div> --}}
                              </li>
                              @endforeach

                              {{-- <li class="flex items-center justify-between p-3 bg-gray-100 rounded">
                                <div>
                                  <p class="text-sm font-medium">Image9077.png</p>
                                  <p class="text-xs text-gray-500">Uploaded on 8/10/25 · 11MB</p>
                                </div>
                                <div class="flex gap-3 text-purple-600">
                                  👁️ 📥
                                </div>
                              </li> --}}
                            </ul>
                          </div>
                        </div>

                        <!-- Right Section: Comments -->
                        <div class="flex flex-col justify-between p-6 bg-white shadow rounded-xl">
                          <div>
                            <h3 class="mb-4 text-lg font-semibold text-gray-800">Comments</h3>
                            <ul class="space-y-4" id="commentsList">
                                @forelse ($project->comments as $comment)
                                <li class="flex items-start gap-3">
                                  <img
                                  src="{{ auth()->user()->profile_pic ? asset('storage/' . auth()->user()->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                  alt="Profile Photo"
                                  class="w-10 h-10 border-2 border-yellow-300 rounded-[10px]">
                              <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $comment->user->name }} <span class="text-xs font-normal text-gray-400">{{ $comment->user->created_at ->diffForHumans() }}</span></p>
                                    <p class="text-sm text-gray-600">{{ $comment->comment }}</p>
                                  </div>
                                </li>
                                @empty
                                    <p>No comments yet.</p>
                                @endforelse
                              <!-- Repeat for other users -->
                            </ul>
                          </div>
                          {{-- My test code for comment --}}

                          <div class="mt-6">

                            <form method="POST" id="commentForm" action="{{ route('project.comment.store', $project->id) }}">
                                @csrf
                                <textarea name="comment" placeholder="Start typing" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                                <button type="submit" class="px-4 py-2 mt-2 text-white rounded bg-fuchsia-900">Post Comment</button>
                            </form>
{{--
                            <input type="text" placeholder="Start typing" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:ring-2 focus:ring-purple-500" />
                            <button class="px-4 py-2 mt-2 text-sm text-white bg-purple-600 rounded hover:bg-purple-700">Comment</button> --}}
                          </div>
                        </div>

                        {{-- <form method="POST" action="{{ route('project.comment.store', $project->id) }}">
                            @csrf
                            <textarea name="comment" class="w-full p-2 border rounded" rows="3" placeholder="Write a comment..."></textarea>
                            <button type="submit" class="px-4 py-2 mt-2 text-white rounded bg-fuchsia-900">Post Comment</button>
                        </form>
                         --}}
                      </div>

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
            <div id="formErrors" class="mb-4 text-sm text-red-500"></div>
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
    <!-- SUCCESS MODAL  ENDS-->
                 </div>
                </div>
        </main>
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
    });


        </script>

    </x-slot>
</x-layouts.app>
