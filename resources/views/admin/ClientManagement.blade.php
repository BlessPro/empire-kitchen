<x-layouts.app>
    <x-slot name="header">
<!--written on 26.04.2025-->
        @include('admin.layouts.header')
        <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">            <!---->
          <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Clients Management</h1>
            {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
            <!-- ADD CLIENT BUTTON -->
            <button id="openAddClientModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                + Add Client
            </button>


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

        </form>
    </div>


<!-- SUCCESS MODAL -->
{{-- <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="w-full max-w-sm p-6 text-center bg-white rounded-lg">
        <div class="opacity-25 bg-fuchsia-900"><i data-feather="user" class="mr-3 feather-icon group"></i></div>
        <h2 class="mb-4 text-lg font-semibold">Client successfully created</h2>
        <div class="right-0"><button id="closeSuccessModal" class="px-4 py-2 text-white rounded-full bg-fuchsia-900">OK</button></div>
    </div>
</div> --}}

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

          <!--test code-->

        <!--head ends-->
        <!--table begins-->

        <div class="mb-20 bg-white shadow rounded-2xl">
            <div class="pt-6 pb-5 pl-6 border-b">
            <h2 class="text-sm text-gray-600 ">Manage all your Clients here</h2>
            </div>
            <div class="overflow-x-auto">
                 <table class="min-w-full text-left">
                    <thead class="items-center text-sm text-gray-600 bg-gray-100">
                      <tr >

                        <th class="p-4 font-mediumt text-[15px] items-center">Client Name</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Phone Number</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Projects</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Location</th>
                      </tr>
                    </thead>

                <tbody class="text-gray-700 divide-y divide-gray-100">



                @foreach ( $clients as $client )
                <tr onclick="window.location='{{ route('admin.clients.projects', $client->id) }}'" class="cursor-pointer hover:bg-gray-100">
                    <td class="p-4 font-normal text-[15px] items-center">{{$client->title. ' '.$client->firstname . ' '.$client->lastname }}</td>

                    <td class="p-4 font-normal text-[15px] items-center">{{$client->phone_number}}</td>
                    <td class="p-4 font-normal text-[15px] items-center">{{$client->projects_count}}</td>
                    <td class="p-4 font-normal text-[15px] items-center">{{$client->location}}</td>

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

    // //for the pop up and error handling
    // Open the modal when the button is clicked
    document.getElementById('openAddClientModal').addEventListener('click', function () {
        document.getElementById('addClientModal').classList.remove('hidden');
    });

    // for closing the pop up
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

//success button to refresh the page
document.getElementById('closeSuccessModal').addEventListener('click', function () {
        document.getElementById('successModal').classList.add('hidden');
        location.reload(); // refresh to update the table
    });


</script>

         @vite(['resources/js/app.js'])

    </x-slot>



</x-layouts.app>
