   <x-designer-layout>
    <x-slot name="header">
        @include('admin.layouts.header')

    </x-slot>

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
             <a href="{{ route('designer.dashboard') }}">
     <span><i data-feather="home" class="w-[5] h-[5] text-fuchsia-900 ml-[3px]"></i></span>
             </a>
     <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
     <a href="{{ route('designer.AssignedProjects') }}">
        <h3 class="font-sans font-normal text-black cursor-pointer hover:underline">Assigned Projects</h3>
    </a>

        </h3>

        <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
        <h3 class="font-semibold text-fuchsia-900">{{ $project->name}}</h3>

    </div>


     </div>
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <!-- Left Section: Project Info -->
                        <div class="p-6 bg-white shadow lg:col-span-2 rounded-xl">
                          <!-- Breadcrumbs -->

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
                              <span><span class="mr-[12px] font-normal text-black-900">{{ $project->location }}</span> </span>
                            </div>
                            <div class="flex items-center gap-2">
                              <span class="font-medium">Tech Supervisor:</span>

                              <span><span class="mr-[12px] font-normal text-black-900">{{ $project->techSupervisor->name ?? 'Not Assigned' }}</span> </span>

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


<div class="mt-6">
    <h3 class="mb-2 text-sm font-semibold text-gray-800">Design Attachments</h3>
    <ul class="space-y-4">
        @foreach ($project->design as $design)
            <li class="flex items-center justify-between p-4 rounded-lg">

@if (!empty($design->images) && is_array($design->images))
    {{-- <div class="grid grid-cols-2 gap-4 md:grid-cols-3"> --}}

        <div class="w-full mx-auto ">

        @foreach ($design->images as $image)
  {{-- <div class="flex items-center gap-3">
                <img src="{{ asset('storage/' . $image) }}"
                     alt="Design Image"
                     class="object-cover rounded-md w-14 h-14">
                     <div>
                        <p class="font-medium text-gray-800">MapleStreet1.png</p>
                        <p class="text-xs text-gray-500">Uploaded on 8/10/25</p>
                        <p class="text-xs text-gray-400">11MB</p>
                    </div>
            </div> --}}
  <!-- Designs -->
        <div class="pt-4 mt-6 border-t">
        <h3 class="mb-2 text-sm font-semibold text-gray-900">Designs</h3>
        <ul class="">
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-3">
  <img src="{{ asset('storage/' . $image) }}"
                     alt="Design Image"
                     class="object-cover rounded-md w-14 h-14">
                        <div>
                        <p class="font-medium text-gray-800">MapleStreet1.png</p>
                        <p class="text-xs text-gray-500">Uploaded on 8/10/25</p>
                        <p class="text-xs text-gray-400">11MB</p>
                    </div>
                </div>
                <div class="flex gap-4 text-purple-600">
                    <button onclick="{{ route('designer.ProjectDesign') }}">

                      <i data-feather="eye" class="w-5 h-5 text-fuchsia-900"></i>
                    </button>
                    <button onclick="{{ route('designer.ProjectDesign') }}">

                      <i data-feather="upload" class="w-5 h-5 text-fuchsia-900"></i>

                    </button>
                </div>
            </li>
        </ul>
        </div>

            @endforeach
        </div>
    @else
        <p class="italic text-gray-500">No images available.</p>
    @endif
        @endforeach






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
            src="{{ $comment->user->profile_pic ? asset('storage/' . $comment->user->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
            alt="Profile Photo"
            class="w-10 h-10 border-2 border-yellow-300 rounded-[10px]">
        <div>
            <p class="text-sm font-semibold text-gray-800">
                {{ $comment->user->name }}
                <span class="text-xs font-normal text-gray-400">
                    {{ $comment->created_at->diffForHumans() }}
                </span>
            </p>
            <p class="text-sm text-gray-600">{{ $comment->comment }}</p>
        </div>
    </li>
    @empty
    <p>No comments yet.</p>
    @endforelse
</ul>

                          </div>
                          {{--My code for comment --}}

                          <div class="mt-6">

                            <form method="POST" id="commentForm" action="{{ route('project.comment.store', $project->id) }}">
                                @csrf
                                <textarea name="comment" placeholder="Start typing" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                                <button type="submit" class="px-4 py-2 mt-2 text-white rounded bg-fuchsia-900">Post Comment</button>
                            </form>
                          </div>
                        </div>


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

</x-designer-layout>
