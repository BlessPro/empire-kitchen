<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')



<main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">

    <div class="p-6 bg-[#F9F7F7]">
     <div class="mb-[20px]">
        <div class="flex items-center justify-between mb-6">

 <!-- Top Navbar -->
 <h1 class="text-2xl font-bold">Clients Management</h1>

 <button id="openAddClientModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
     + Add Client
 </button>


 </div>

<!-- Columns (Pending, Ongoing, Completed) -->
<div class="grid grid-cols-1 gap-6 md:grid-cols-4">

    <!-- Pending Column -->
    <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
        <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#F59E0B]">
            <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">2</h5></span> Measurement
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


        </div>
    </div>

    <!-- Ongoing Column -->
    <div>
        <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
            <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#4F46E5]">
                <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">2</h5></span> Design
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
            @endforelse  <!-- Another Card -->

            </div>
        </div>
    </div>

    <!-- Completed Column -->
    <div>
        <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
            <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#22C55E]">
                <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">2</h5></span> Production
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
            @endforelse  <!-- Another Card -->
                                    <!-- Card Item -->


            </div>
        </div>
    </div>

     <!-- Another section completed Column -->
     <div>
        <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
            <div class="flex items-center py-2 pl-2 pr-5 text-white rounded-full bg-fuchsia-500">
                <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">2</h5></span> Installation
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
</div>
 </div>
 </main>
    </x-slot>
</x-layouts.app>
