<x-layouts.app>
    <x-slot name="header">

        @include('admin.layouts.header')


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
                   <li class="flex items-center">
                     <span class="w-10 h-5 rounded-[15px] bg-yellow-400 mr-3"></span>
                     <span class="text-gray-800 font-normal text-[15px]">Quotes (9)</span>
                   </li>
                   <li class="flex items-center">
                     <span class="w-10 h-5 rounded-[15px] bg-blue-500 mr-3"></span>
                     <span class="text-gray-800 font-normal text-[15px]">Payments (6)</span>
                   </li>
                 </ul>
                </span>

               </div>
                            <!--try-->

             </div>

             <!--try-->

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
                 </button>
               </div>
             </div>


             {{--Testing the table logic--}}
             @if(isset($projects))
             @foreach($projects as $project)
                 <p>{{ $project->title }}</p>
             @endforeach
         @else
             <p>No projects found.</p>
         @endif
                  <!--My projects table begins-->
                   {{-- <table class="min-w-full text-left">
                     <thead class="text-sm text-gray-600 bg-gray-100">
                       <tr>
                         <th class="p-4 font-medium">
                           <input type="checkbox" id="selectAll" />
                         </th>
                         <th class="p-4 font-mediumt text-[15px]">Project Name</th>
                         <th class="p-4 font-mediumt text-[15px]">Status</th>
                         <th class="p-4 font-mediumt text-[15px]">Client Name</th>
                         <th class="p-4 font-mediumt text-[15px]">Duration</th>
                         <th class="p-4 font-mediumt text-[15px]">Cost</th>
                         <th class="p-4 font-mediumt text-[15px]">you</th>
                       </tr>
                     </thead>
<tbody>

</tbody> --}}



{{--
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Project Name</th>
            <th>Status</th>
            <th>Client Name</th>
            <th>Duration</th>
            <th>Cost</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($projects as $project)
            <tr>
                <td>{{ $project->project_name }}</td>
                <td>{{ $project->status }}</td>
                <td>{{ $project->client->name ?? 'N/A' }}</td>
                <td>
                    {{ $project->created_at->diffForHumans() }} --}}
                    {{-- Or you can use: $project->created_at->diff(now())->format('%w weeks') --}}
                {{-- </td>
                <td>GH₵ {{ number_format($project->cost, 2) }}</td>
            </tr>
            @empty
            <li>No projects available.</li>
        @endforelse
    </tbody>
</table> --}}


<table class="min-w-full text-left">
    <thead class="text-sm text-gray-600 bg-gray-100">
      <tr>
        <th class="p-4 font-medium">
          <input type="checkbox" id="selectAll" />
        </th>
        <th class="p-4 font-mediumt text-[15px]">Project Name</th>
        <th class="p-4 font-mediumt text-[15px]">Status</th>
        <th class="p-4 font-mediumt text-[15px]">Client Name</th>
        <th class="p-4 font-mediumt text-[15px]">Duration</th>
        <th class="p-4 font-mediumt text-[15px]">Cost</th>
        <th class="p-4 font-mediumt text-[15px]">delete</th>
      </tr>
    </thead>
<!-- Add other columns as needed -->
</tr>
</thead>
<tbody>
@foreach($projects as $project)
<tr class="border-t hover:bg-gray-50">
 <td class="p-4"><input type="checkbox" class="child-checkbox"/></td>
 <td class="p-4 font-normal text-[15px]">{{ $project->name }}</td>
 <td class="p-4">
   <span class="px-3 py-1 text-sm rounded-full {{ $project->statusStyle }}">{{ $project->status }}</span>
 </td>
 <td class="p-4 font-normal text-[15px]">{{ $project->client->firstname }}</td>
 <td class="p-4 font-normal text-[15px]">  {{ $project->start_date->diffForHumans() }}</td>
 <td class="p-4 font-normal text-[15px]">{{ $project->cost }}</td>

 <td class="p-4 text-right"><button class="text-gray-500 hover:text-red-500"><i data-feather="layers" class="mr-3"></i> </button></td>
</tr>
@endforeach
</tbody>

{{--working table--}}

                        {{-- inserting data from clients and projects table into blade table --}}

                        {{-- @if (!isset($projects))
                        <tr>
                            <td colspan="5" class="py-4 text-center">No projects found.</td>
                        </tr> --}}
                    {{-- @if (isset($projects) && is_iterable($projects)) --}}
                      {{--    @foreach ($projects as $project)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-3 font-semibold">{{ $project->name }}</td>
                            <td class="px-4 py-3 capitalize">{{ $project->status }}</td>
                            <td class="px-4 py-3">
                                {{ $project->client->title }} {{ $project->client->firstname }} {{ $project->client->lastname }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $project->start_date->diffForHumans() }}
                            </td>
                            <td class="px-4 py-3">₦{{ number_format($project->cost, 2) }}</td>
                        @endforeach
                   @endif

                    @endif

                     </tbody>
                   </table>--}}
                   {{-- @foreach($projects as $project)
                   <tr>
                       <td>{{ $project->project_name }}</td>
                       <td>{{ $project->status }}</td>
                       <td>{{ $project->client->firstname }} {{ $project->client->lastname }}</td>
                       <td>{{ $project->cost }}</td>
                       <td>{{ $project->start_date->diffForHumans() }}</td>
                   </tr>
                    @endforeach --}}

<!-- Pagination -->
{{-- {{ $projects->links() }} --}}

                   {{-- <div class="flex items-center justify-between pb-5 pl-6 pr-6 mt-6">
                     <p class="text-sm text-gray-500 results-text">Showing 1 to 3 of 50 results</p>
                     <nav class="flex items-center gap-1">
                       <button id="prevPage" class="px-3 py-1.5 rounded-md border text-sm text-gray-500 hover:bg-gray-100 disabled:opacity-50">
                         Previous
                       </button>
                       <button id="nextPage" class="px-3 py-1.5 rounded-md border text-sm text-gray-500 hover:bg-gray-100">
                         Next
                       </button>
                     </nav>
                   </div> --}}


           </div>
         </div>
         </main>




         @vite(['resources/js/app.js'])

    </x-slot>



</x-layouts.app>
