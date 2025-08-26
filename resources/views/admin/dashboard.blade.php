<x-layouts.app>
    <x-slot name="header">

        @include('admin.layouts.header')

        {{-- {{ dd($projects) }} --}}
        @php
        $statusClasses = [
            'in progress' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
            'completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
            'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
        ];


        $defaultClass = 'bg-gray-100 text-gray-800';
    @endphp

        <main class="ml-64 mt-[100px] flex-1 bg-gray-100 min-h-screen  items-center">
            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">
             <h2 class="text-[25px] font-semi-bold text-gray-900 "> Overview </h2>
           </div>
           <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 ">
             <div class="bg-white p-4 rounded-[30px] shadow items-center">
                <!--try-->

               <div class="flex items-center justify-between mb-6">
                 <h2 class=" font-normal text-[15px] ml-5 text-gray-900">Total Incoming Clients</h2>
                       <!-- Doughnut Chart  -->

                 <div>
                   <select id="month" class="p-2 rounded-[20px] text-[12px] pr-4 border border-gray-300 bg-white text-gray-700">

                   </select>

                 </div>
               </div>


               <div class="grid grid-cols-1 gap-8 md:grid-cols-2 ">
                 <!-- Chart -->

                 <div class="flex justify-center items-center w-[270px] h-[270px] mx-auto">
                   <canvas id="clientsChart"  class="w-full h-full"></canvas>
                 </div>
                <span class="flex flex-col items-center justify-center">

                 <!-- Legend -->

                 <ul class="items-center space-y-3">
                   <li class="flex items-center">
                     <span class="w-10 h-5 mr-3 bg-orange-500 rounded-full"></span>
                     <span class="text-gray-800 font-normal text-[15px]">New Clients (5)</span>
                   </li>

                   <li class="flex items-center">
                     <span class="w-10 h-5 rounded-[15px] bg-purple-900 mr-3"></span>
                     <span class="text-gray-800 font-normal text-[15px]">Schd. Measurements (10)</span>
                   </li>

                   <li class="flex items-center">
                     <span class="w-10 h-5 rounded-[15px] bg-violet-500 mr-3"></span>
                     <span class="text-gray-800 font-normal text-[15px]">Pending Designs (7)</span>
                   </li>

                   {{-- <li class="flex items-center">
                     <span class="w-10 h-5 rounded-[15px] bg-yellow-400 mr-3"></span>
                     <span class="text-gray-800 font-normal text-[15px]">Quotes (9)</span>
                   </li> --}}

                   <li class="flex items-center">
                     <span class="w-10 h-5 rounded-[15px] bg-blue-500 mr-3"></span>
                     <span class="text-gray-800 font-normal text-[15px]">Payments (6)</span>
                   </li>
                 </ul>
                </span>
               </div>

            </div>

           <!--the pipeline bar chart begins-->
             <div class="bg-white p-4 rounded-[30px] shadow">

             <div class="flex items-center justify-between px-5 py-2 space-x-6">
               <h2 class="font-normal text-[14px] text-gray-900">Project Pipeline</h2>

               <div class="flex items-center space-x-6">
                 <div class="flex items-center space-x-2">
                   <span class="w-3 h-3 bg-orange-400 rounded-full"></span>
                   <span class="text-[15px] font-normal text-gray-700">Measurement</span>
                 </div>
                 <div class="flex items-center space-x-2">
                   <span class="w-3 h-3 bg-blue-600 rounded-full"></span>
                   <span class="text-[15px] font-normal text-gray-700">Design</span>
                 </div>
                 <div class="flex items-center space-x-2">
                   <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                   <span class="text-[15px] font-normal text-gray-700">Installation</span>
                 </div>
                 <div class="flex items-center space-x-2">
                   <span class="w-3 h-3 bg-purple-400 rounded-full"></span>
                   <span class="text-[15px] font-normal text-gray-700">Payment</span>
                 </div>
               </div>
             </div>

                 <canvas id="ProjectsPipeline"  class="w-full h-full"></canvas>
             </div>

           <!--the pipeline bar chart begins-->
           </div>

           <!-- Projects Table -->
           <div class="px-5 py-5 text-[25px] font-semi-bold text-gray-900" > <h1>My Projects</h1></div>

           <div class="bg-white rounded-[20px] shadow">

             <div class="flex items-center justify-between pt-4 pb-5 pl-6 pr-6">
               <p class="text-gray-600 text-[15px] font-normal">Easily manage your projects here</p>
               <div class="flex gap-3">
                {{-- <div class="flex gap-3 mb-4">
                    <button class="px-4 py-2 text-white bg-blue-600 rounded filter-btn" data-status="all">All</button>
                    <button class="px-4 py-2 text-white bg-yellow-500 rounded filter-btn" data-status="pending">Pending</button>
                    <button class="px-4 py-2 text-white bg-green-600 rounded filter-btn" data-status="ongoing">Ongoing</button>
                    <button class="px-4 py-2 text-white bg-purple-700 rounded filter-btn" data-status="completed">Completed</button>
                </div> --}}


{{--
                 <button class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-full">
                   <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6h4M6 10h12M6 14h12M10 18h4" />
                   </svg>
                   Filter
                 </button>
                 <button class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-purple-800 bg-purple-100 border border-purple-800 rounded-full">
                   Export
                   <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm8 8v4m0-4l-2 2m2-2l2 2" />
                   </svg>
                 </button> --}}
               </div>
             </div>



             {{--Testing the table logic--}}
             <div id="projectsTableContainer">
                @include('partials.projects-table', ['projects' => $projects])
            </div>


            {{-- table was here --}}
                     <div class="mt-4 mb-5 ml-5 mr-5">
                        {{ $projects->links('pagination::tailwind') }}
                    </div>


           </div>
         </div>
         </main>
         <script>
         document.getElementById("selectAll").addEventListener("change", function () {
            const isChecked = this.checked;
            const checkboxes = document.querySelectorAll(".child-checkbox");
            checkboxes.forEach(cb => cb.checked = isChecked);
            });
            // When 'selectAll' is unchecked

            const allCheckboxes = document.querySelectorAll(".child-checkbox");
            allCheckboxes.forEach(cb => {
            cb.addEventListener("change", () => {
            const allChecked = Array.from(allCheckboxes).every(c => c.checked);
            document.getElementById("selectAll").checked = allChecked;
            });
            });



document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function () {
        const status = this.dataset.status;

        fetch(`/admin/projects/filter?status=${status}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('projectsTableContainer').innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching filtered projects:', error);
            });
    });
});





</script>

         @vite(['resources/js/app.js'])

    </x-slot>

</x-layouts.app>
