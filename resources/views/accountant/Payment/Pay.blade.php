<x-accountant-layout>
 <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Designer Dashboard') }}
        </h2>
        <script src="//unpkg.com/alpinejs" defer></script>

    </x-slot>

       <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="">
             <div class="mb-[20px]">

                 {{-- navigation bar --}}
   <div class="flex items-center justify-between mb-6">
    <div class="flex items-center justify-between mb-6">
     <span><i data-feather="home" class="w-[20px] h-[20px] text-fuchsia-900 ml-[3px]"></i></span>
     <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
     <a href="{{ route('accountant.Payments') }}">
        <h3 class="font-sans font-normal text-black cursor-pointer hover:underline">Expenses</h3>
    </a>

<button id="openIncomeModal" class="px-4 py-2 text-white rounded bg-fuchsia-800">Add Income</button>


        <span><i data-feather="chevron-right" class="w-[20px] h-[18px] text-fuchsia-900 ml-[3px]"></i></span>
        <h3 class="font-semibold text-fuchsia-900">Pay</h3>

    </div>


<!-- Category Modal Trigger & Alpine Wrapper -->
<div x-data="{ open: false }">

    <!-- Trigger Button -->
     <!-- Button to open modal -->
    <button @click="open = true"
        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border rounded-full hover:bg-blue-700flex bg-fuchsia-900 border-fuchsia-800">
  <i data-feather="plus"> </i>
        New Payment   </button>

    <!-- Modal -->
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
    >
        <div class="relative w-full max-w-md p-6 bg-white rounded-xl">

            <!-- Close Button -->
            <button @click="open = false"
                class="absolute text-2xl font-bold text-gray-700 top-4 right-4 hover:text-black">&times;
            </button>

            <!-- Title -->
            <h2 class="mb-6 text-2xl font-semibold text-gray-900">Add Expense Category</h2>

            <!-- Form -->
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <!-- Category Name -->
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-800" for="category">Category Name</label>
                    <input
                        type="text"
                        id="category"
                        name="name"
                        required
                        placeholder="Enter category name"
                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    />
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block mb-1 text-sm font-medium text-gray-800" for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Start typing"
                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-purple-600"
                    ></textarea>
                </div>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="w-full py-2 text-white transition bg-fuchsia-900 rounded-xl hover:bg-purple-900"
                >
                    Save
                </button>
            </form>
        </div>
    </div>
</div>





   </div>

   {{-- end of navigation bar --}}

<div class="shadow-md rounded-[15px] ">

  <table class=" min-w-full mt-6 pl-6 text-left bg-white rounded-[20px]">
    <thead class="text-sm text-gray-600 bg-gray-100">
      <tr>
        <th class="p-4 font-medium text-[15px] w-1/2">Category</th>
        <th class="p-4 font-medium text-[15px] w-1/2">Description</th>
      </tr>
    </thead>
    <tbody class="text-sm text-gray-600">

         {{-- @forelse($categories as $category)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-4 text-sm text-gray-800">{{ $category->name }}</td>
                <td class="p-4 text-sm text-gray-600">{{ $category->description }}</td>

                 <td class="p-4 text-sm text-gray-600">
                <form action="{{ route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-gray-500 hover:text-red-500">
                            <i data-feather="trash" class="mr-3 w-[20px] h-[20px]"></i>
                        </button>
                        </form>
                    </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="p-4 text-center text-gray-500">No categories found.</td>
            </tr>
        @endforelse --}}
    </tbody>
  </table>
</div>

<!-- Income Entry Modal -->
<div id="incomeModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-md w-[600px]">
        <h2 class="mb-4 text-xl font-semibold">Add New Income</h2>
        <form id="incomeForm">
            @csrf
            <div class="mb-4">
                <label>Client</label>
                <select id="clientSelect" name="client_id" class="w-full p-2 border rounded">
                    <option value="">-- Select Client --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->title.' ' .$client->firstname. ' '. $client->lastname }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label>Project</label>
                <select id="projectSelect" name="project_id" class="w-full p-2 border rounded">
                    <option value="">-- Select Project --</option>
                </select>
            </div>

            <div class="mb-4">
                <label>Category</label>
                <select name="category_id" class="w-full p-2 border rounded">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label>Date</label>
                <input type="date" name="date" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label>Material</label>
                <input type="text" name="material" class="w-full p-2 border rounded">
            </div>

            <button type="submit" class="px-4 py-2 text-white bg-purple-700 rounded">Save Income</button>
        </form>
    </div>
</div>



        </div>
      </div>
    </main>

<script>
document.getElementById('clientSelect').addEventListener('change', function () {
    const clientId = this.value;
    fetch(`/projects/by-client/${clientId}`)
        .then(response => response.json())
        .then(projects => {
            const projectSelect = document.getElementById('projectSelect');
            projectSelect.innerHTML = '<option value="">-- Select Project --</option>';
            projects.forEach(project => {
                projectSelect.innerHTML += `<option value="${project.id}">${project.name}</option>`;
            });
        });
});
//ends


document.getElementById('incomeForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('{{ route("income.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert("Income saved!");
        location.reload(); // or close modal and refresh data table
    })
    .catch(err => console.error(err));
});
document.getElementById('openIncomeModal').addEventListener('click', function () {
    document.getElementById('incomeModal').classList.remove('hidden');
});


    </script>
</x-accountant-layout>
