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
   <div class="flex items-center justify-between mb-6"><span><i data-feather="home" class="text-fuchsia-900 mr-[12px] ml-[3px]"></i></span><span class="font-normal text-black mr-[12px]">Clients Management</span><span class="mr-[12px] font-semibold text-fuchsia-900">{{ $client->title . ' '.$client->firstname . ' '.$client->lastname }}</span></div>


   {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
    <!-- ADD CLIENT BUTTON -->
    <button id="openAddClientModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
        + Add Client
    </button>

    </div>

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

                    <div class="p-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                        <h3 class="font-semibold text-gray-800 mb-3">{{ $project->name }}</h3>
                        <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                            <i data-feather="calendar"
                            class="feather-icon mr-3 group text-black "></i> <p class="text-sm">{{ $project->created_at->format('F j, Y') }}</p>

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
                <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#4F46E5]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">{{ $ongoing->count() }}</h5></span> Pending
                    </div>
                    <div class="pt-5 space-y-5 ">

                        <!-- Card Item -->
                        @foreach ($ongoing as $project)

                        <div class="p-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                            <h3 class="font-semibold text-gray-800 mb-3">{{ $project->name }}</h3>
                            <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                <i data-feather="calendar"
                                class="feather-icon mr-3 group text-black "></i> <p class="text-sm">{{ $project->created_at->format('F j, Y') }}</p>

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
                <div class=" pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px] ">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#22C55E]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px] items-center"><h5 class="items-center rounded-full px-[10px] py-[10px] text-black">{{ $completed->count() }}</h5></span> Pending
                    </div>
                    <div class="pt-5 space-y-5 ">

                        <!-- Card Item begins-->
                        @foreach ($completed as $project)

                        <div class="p-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                            <h3 class="font-semibold text-gray-800 mb-3">{{ $project->name }}</h3>
                            <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                <i data-feather="calendar"
                                class="feather-icon mr-3 group text-black "></i> <p class="text-sm">{{ $project->created_at->format('F j, Y') }}</p>

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
    </div>
</div>
</main>
    @vite(['resources/js/app.js'])

</x-slot>



</x-layouts.app>

