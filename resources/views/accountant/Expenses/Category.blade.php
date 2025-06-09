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
     <a href="{{ route('accountant.Expenses') }}">
        <h3 class="font-sans font-normal text-black cursor-pointer hover:underline">Expenses</h3>
    </a>



        <span><i data-feather="chevron-right" class="w-[20px] h-[18px] text-fuchsia-900 ml-[3px]"></i></span>
        <h3 class="font-semibold text-fuchsia-900">Category</h3>

    </div>




{{-- <div x-data="{ open: false }">

    <!-- Button to open modal -->
    <button @click="open = true"
        class=" flex hover:bg-blue-700flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold
         bg-fuchsia-900 border border-fuchsia-800 rounded-full">
  <i data-feather="plus"> </i>
        New Expense    </button> --}}

  {{-- <button class="flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold  bg-fuchsia-900 border border-fuchsia-800 rounded-full">
        <i data-feather="plus"> </i>
        New Expense
      </button> --}}
{{--
    <!-- Modal -->
    <div x-show="open"
         x-transition
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div @click.outside="open = false"
             class="bg-white p-6 rounded shadow-lg w-full max-w-md space-y-4">

            <h2 class="text-xl font-semibold">Add New Category</h2>

            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Category Name</label>
                    <input type="text" name="name" required
                           class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description"
                              class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false"
                            class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cancel</button>
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
 --}}








<!-- Category Modal Trigger & Alpine Wrapper -->
<div x-data="{ open: false }">

    <!-- Trigger Button -->
     <!-- Button to open modal -->
    <button @click="open = true"
        class=" flex hover:bg-blue-700flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold
         bg-fuchsia-900 border border-fuchsia-800 rounded-full">
  <i data-feather="plus"> </i>
        New Category   </button>

    <!-- Modal -->
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-xl w-full max-w-md p-6 relative">

            <!-- Close Button -->
            <button @click="open = false"
                class="absolute top-4 right-4 text-gray-700 text-2xl font-bold hover:text-black">&times;
            </button>

            <!-- Title -->
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Add Expense Category</h2>

            <!-- Form -->
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <!-- Category Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-800 mb-1" for="category">Category Name</label>
                    <input
                        type="text"
                        id="category"
                        name="name"
                        required
                        placeholder="Enter category name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600"
                    />
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-800 mb-1" for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Start typing"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-purple-600"
                    ></textarea>
                </div>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="w-full bg-fuchsia-900 text-white py-2 rounded-xl hover:bg-purple-900 transition"
                >
                    Save
                </button>
            </form>
        </div>
    </div>
</div>



{{--trials--}}
{{-- <div x-data="{ open: false }">

    <!-- Button to open modal -->
    <button @click="open = true"
        class=" flex hover:bg-blue-700flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold
         bg-fuchsia-900 border border-fuchsia-800 rounded-full">
  <i data-feather="plus"> </i>
        New Expense    </button>

<div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
  <div class="bg-white rounded-xl w-full max-w-md p-6 relative">

    <!-- Close Button -->
    <button @click="open = false" class="absolute top-4 right-4 text-gray-700 text-2xl font-bold hover:text-black">&times;</button>

    <!-- Title -->
    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Add Expense Category</h2>

    <!-- Form -->
 <form method="POST" action="{{ route('categories.store') }}">
                @csrf      <!-- Category Name -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-800 mb-1" for="category">Category Name</label>
        <input
          type="text"
          id="category"
          placeholder="Enter category name"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600"
        />
      </div>

      <!-- Description -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-800 mb-1" for="description">Description</label>
        <textarea
          id="description"
          rows="4"
          placeholder="Start typing"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-purple-600"
        ></textarea>
      </div>

      <!-- Save Button -->
      <button
        type="submit"
        class="w-full bg-purple-800 text-white py-2 rounded-xl hover:bg-purple-900 transition"
      >
        Save
      </button>
    </form>
  </div>
</div>

</div> --}}


{{---trials--}}


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

         @forelse($categories as $category)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-4 text-sm text-gray-800">{{ $category->name }}</td>
                <td class="p-4 text-sm text-gray-600">{{ $category->description }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="p-4 text-center text-gray-500">No categories found.</td>
            </tr>
        @endforelse
    </tbody>
  </table>
</div>





{{--
<div x-data="{ open: false }">

    <!-- Button to open modal -->
    <button @click="open = true"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Category
    </button>

    <!-- Modal -->
    <div x-show="open"
         x-transition
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div @click.outside="open = false"
             class="bg-white p-6 rounded shadow-lg w-full max-w-md space-y-4">

            <h2 class="text-xl font-semibold">Add New Category</h2>

            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Category Name</label>
                    <input type="text" name="name" required
                           class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description"
                              class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false"
                            class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cancel</button>
                    <button type="submit"
                            class="bg-fuchsia-900 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
 --}}


        </div>
      </div>
    </main>


</x-accountant-layout>
