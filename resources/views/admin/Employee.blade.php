<x-layouts.app>
    <x-slot name="header">
        <script src="//unpkg.com/alpinejs" defer></script>
        <style>
            [x-cloak] {
                display: none !important
            }
        </style>
        @include('admin.layouts.header')
    </x-slot>

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen items-center">
        <div class="p-6 bg-[#F9F7F7]">


 <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-semibold">Employees</h1>
                        {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
                        <!-- ADD CLIENT BUTTON -->
                        <a href="{{ route('admin.addemployee') }}">
                        <button                     
                            class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                            + Add Employee
                        </button>
                    </a>

                    </div>






        </div>
    </main>
</x-layouts.app>
