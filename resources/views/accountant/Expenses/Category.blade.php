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
        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border rounded-full hover:bg-blue-700flex bg-fuchsia-900 border-fuchsia-800">
  <i data-feather="plus"> </i>
        New Expense    </button> --}}

  {{-- <button class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border rounded-full bg-fuchsia-900 border-fuchsia-800">
        <i data-feather="plus"> </i>
        New Expense
      </button> --}}
{{--
    <!-- Modal -->
    <div x-show="open"
         x-transition
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div @click.outside="open = false"
             class="w-full max-w-md p-6 space-y-4 bg-white rounded shadow-lg">

            <h2 class="text-xl font-semibold">Add New Category</h2>

            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium">Category Name</label>
                    <input type="text" name="name" required
                           class="w-full px-3 py-2 border-gray-300 rounded focus:ring focus:ring-blue-200" />
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium">Description</label>
                    <textarea name="description"
                              class="w-full px-3 py-2 border-gray-300 rounded focus:ring focus:ring-blue-200"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                    <button type="submit"
                            class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Save</button>
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
        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border rounded-full hover:bg-blue-700flex bg-fuchsia-900 border-fuchsia-800">
  <i data-feather="plus"> </i>
        New Category   </button>

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



{{--trials--}}
{{-- <div x-data="{ open: false }">

    <!-- Button to open modal -->
    <button @click="open = true"
        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border rounded-full hover:bg-blue-700flex bg-fuchsia-900 border-fuchsia-800">
  <i data-feather="plus"> </i>
        New Expense    </button>

<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
  <div class="relative w-full max-w-md p-6 bg-white rounded-xl">

    <!-- Close Button -->
    <button @click="open = false" class="absolute text-2xl font-bold text-gray-700 top-4 right-4 hover:text-black">&times;</button>

    <!-- Title -->
    <h2 class="mb-6 text-2xl font-semibold text-gray-900">Add Expense Category</h2>

    <!-- Form -->
 <form method="POST" action="{{ route('categories.store') }}">
                @csrf      <!-- Category Name -->
      <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-800" for="category">Category Name</label>
        <input
          type="text"
          id="category"
          placeholder="Enter category name"
          class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
        />
      </div>

      <!-- Description -->
      <div class="mb-6">
        <label class="block mb-1 text-sm font-medium text-gray-800" for="description">Description</label>
        <textarea
          id="description"
          rows="4"
          placeholder="Start typing"
          class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-purple-600"
        ></textarea>
      </div>

      <!-- Save Button -->
      <button
        type="submit"
        class="w-full py-2 text-white transition bg-purple-800 rounded-xl hover:bg-purple-900"
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
        @endforelse
    </tbody>
  </table>
</div>





{{--
<div x-data="{ open: false }">

    <!-- Button to open modal -->
    <button @click="open = true"
        class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
        + Add Category
    </button>

    <!-- Modal -->
    <div x-show="open"
         x-transition
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div @click.outside="open = false"
             class="w-full max-w-md p-6 space-y-4 bg-white rounded shadow-lg">

            <h2 class="text-xl font-semibold">Add New Category</h2>

            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium">Category Name</label>
                    <input type="text" name="name" required
                           class="w-full px-3 py-2 border-gray-300 rounded focus:ring focus:ring-blue-200" />
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium">Description</label>
                    <textarea name="description"
                              class="w-full px-3 py-2 border-gray-300 rounded focus:ring focus:ring-blue-200"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                    <button type="submit"
                            class="px-4 py-2 text-white rounded bg-fuchsia-900 hover:bg-blue-700">Save</button>
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
