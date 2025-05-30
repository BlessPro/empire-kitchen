<!-- Example for designer -->
   <x-Designer-layout>
    <div class="p-6 text-gray-900">Welcome designer!</div>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Designer Dashboard') }}
        </h2>
    </x-slot>

<main class="ml-64 flex-1 bg-[#F9F7F7] min-h-screen  items-center">

    <div class=" bg-[#F9F7F7]">
     <div class="">

                <h1 class="font-semibold text-[40px] mb-3"> Overview </h1>


      <!-- Overview Cards -->
      <div class="grid grid-cols-3 gap-6 mb-6">
        {{-- <div class="p-4 bg-white rounded-lg shadow ">
          <div class="pb-10 text-sm text-gray-500">Assigned Projects</div>
          <div class="text-2xl font-bold">12</div>
        </div>
        <div class="p-4 bg-white rounded-lg shadow">
          <div class="pb-10 text-sm text-gray-500">Completed</div>
          <div class="text-2xl font-bold text-green-500">10</div>
        </div> --}}

          {{--new 1--}}

           <div class="bg-white p-4 rounded-[30px] shadow items-center">
            <div class="flex items-center justify-between mt-2">
              <h2 class=" font-semibold text-[25px] ml-5 text-gray-900">Assigned Projects</h2>
            </div>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
              <!-- Chart -->
              <div class="flex mt-5 ml-4 justify-left items-left">
              <h2 class=" font-Normal text-[75px] text-gray-900">{{ $totalAssigned }}</h2>
            </div>

             <span class="flex flex-col items-center justify-center pt-10">
              <!-- Legend -->
              <ul class="items-center space-y-3 ">
                <li class="flex items-center ">
                    <span class="flex items-center w-[65px] h-[65px] bg-[#FF730033] rounded-full ">
                 <i data-feather="user" class="flex items-center mx-auto text-[#FF7300] "></i>
                    </span>
                </li>
             </ul>
            </span>
           </div>
         </div>

         {{-- New 1--}}




          {{--new 2--}}

           <div class="bg-white p-4 rounded-[30px] shadow items-center">
            <div class="flex items-center justify-between mt-6">
              <h2 class=" font-semibold text-[25px] ml-5 text-gray-900">Completed</h2>
            </div>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 ">
              <!-- Chart -->
              <div class="flex mt-5 ml-4 justify-left items-left">
              <h2 class=" font-Normal text-[75px] text-gray-900">{{ $completed}}</h2>
            </div>

             <span class="flex flex-col items-center justify-center">
              <!-- Legend -->
              <ul class="items-center space-y-3">
                <li class="flex items-center">
                    <span class="flex items-center w-20 h-20 bg-green-100 rounded-full ">
                 <i data-feather="check-circle" class="flex items-center mx-auto text-green-500 "></i>
                    </span>
                </li>
             </ul>
            </span>
           </div>
         </div>

         {{-- New 2--}}


          {{--new3 --}}

           <div class="bg-white p-4 rounded-[30px] shadow items-center">
            <div class="flex items-center justify-between mt-6">
              <h2 class=" font-semibold text-[25px] ml-5 text-gray-900">Due soon</h2>
            </div>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 ">
              <!-- Chart -->
              <div class="flex mt-5 ml-4 justify-left items-left">
              <h2 class=" font-Normal text-[75px] text-gray-900">{{ $dueSoon }}</h2>
            </div>

             <span class="flex flex-col items-center justify-center">
              <!-- Legend -->
              <ul class="items-center space-y-3">
                <li class="flex items-center">
                    <span class="flex items-center w-20 h-20 bg-red-100 rounded-full ">
                 <i data-feather="alert-triangle" class="flex items-center mx-auto text-red-500 "></i>
                    </span>
                </li>
             </ul>
            </span>
           </div>
         </div>

         {{-- New 3--}}
              </div>


        {{--recent activities--}}

<div class="flex flex-col gap-6 font-sans text-black lg:flex-row ">
  <!-- Upcoming Deadlines -->
  <div class="w-full p-6 bg-white shadow-md rounded-2xl lg:w-1/2">
    <h2 class="mb-4 text-2xl font-semibold">Upcoming Deadlines</h2>
    <div class="space-y-4">
      <!-- Yaw Boateng -->
      <div class="flex items-center justify-between pb-4 border-b">
        <div class="flex items-center gap-3">
          <span class="font-medium">Yaw Boateng</span>
          <span class="px-3 py-1 text-sm text-red-500 border border-red-400 rounded-full">At Risk</span>
        </div>
        <div class="flex items-center gap-2 text-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span>23/12/2025</span>
        </div>
      </div>
      <!-- Kwesi Osei -->
      <div class="flex items-center justify-between pb-4 border-b">
        <div class="flex items-center gap-3">
          <span class="font-medium">Kwesi Osei</span>
          <span class="px-3 py-1 text-sm text-yellow-600 border border-yellow-400 rounded-full">On Track</span>
        </div>
        <div class="flex items-center gap-2 text-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span>23/12/2025</span>
        </div>
      </div>
      <!-- Akwasi Appiah -->
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <span class="font-medium">Akwasi Appiah</span>
          <span class="px-3 py-1 text-sm text-yellow-600 border border-yellow-400 rounded-full">On Track</span>
        </div>
        <div class="flex items-center gap-2 text-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span>23/12/2025</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Activities -->
  <div class="w-full p-6 bg-white shadow-md rounded-2xl lg:w-1/2">
    <h2 class="mb-4 text-2xl font-semibold">Recent Activities</h2>
    <div class="space-y-6">
      <!-- Tiana -->
      <div class="flex items-start gap-4">
        <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Tiana" class="w-10 h-10 rounded-full">
        <div>
          <p><span class="font-medium">Tiana Siphron</span> added a comment in <span class="font-medium text-purple-700">New Build</span></p>
        </div>
      </div>
      <!-- Aspen and other -->
      <div class="flex items-start gap-4">
        <div class="flex -space-x-2">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Aspen" class="w-10 h-10 border-2 border-white rounded-full">
          <img src="https://randomuser.me/api/portraits/men/76.jpg" alt="Other" class="w-10 h-10 border-2 border-white rounded-full">
        </div>
        <div>
          <p><span class="font-medium">Aspen Vaccaro and 1 other</span> added a comment in <span class="font-medium text-purple-700">New Build</span></p>
        </div>
      </div>
      <!-- Chris -->
      <div class="flex items-start gap-4">
        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Chris" class="w-10 h-10 rounded-full">
        <div>
          <p><span class="font-medium">Chris Laventher</span> approved designs in <span class="font-medium text-purple-700">Smith Residence</span></p>
        </div>
      </div>
    </div>
  </div>
</div>




        {{--recent activities--}}


      <!-- Deadline & Activity -->
      {{-- <div class="grid grid-cols-2 gap-6 mb-6"> --}}
        {{-- <div class="p-4 bg-white rounded-lg shadow">
          <div class="mb-4 font-semibold">Upcoming Deadlines</div>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span>Yaw Boateng</span><span class="text-red-500">At Risk</span></div>
            <div class="flex justify-between"><span>Kwesi Osei</span><span class="text-yellow-500">On Track</span></div>
            <div class="flex justify-between"><span>Akwasi Appiah</span><span class="text-yellow-500">On Track</span></div>
          </div>
        </div>
        <div class="p-4 bg-white rounded-lg shadow">
          <div class="mb-4 font-semibold">Recent Activities</div>
          <div class="space-y-3 text-sm">
            <div>Tiana Siphron added a comment in <span class="text-purple-600">New Build</span></div>
            <div>Aspen Vaccaro and 1 other added a comment in <span class="text-purple-600">New Build</span></div>
            <div>Chris Laventher approved designs in <span class="text-purple-600">Smith Residence</span></div>
          </div>
        </div> --}}






      {{-- </div> --}}
{{--
      <!-- Assigned Projects Table -->
      <div class="p-4 bg-white rounded-lg shadow">
        <div class="mb-4 font-semibold">Assigned Projects</div>
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left border-b">
              <th class="py-2">Client Name</th>
              <th>Location</th>
              <th>Due Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b">
              <td class="py-2">Yaw Boateng</td>
              <td>Ashaiman</td>
              <td>January 11, 2025</td>
              <td><span class="text-green-600">Completed</span></td>
              <td><button class="text-purple-600">View</button></td>
            </tr>
            <tr class="border-b">
              <td class="py-2">Kwesi Osei</td>
              <td>Jamestown</td>
              <td>August 26, 2025</td>
              <td><span class="text-yellow-500">On Track</span></td>
              <td><button class="text-purple-600">View</button></td>
            </tr>
            <tr>
              <td class="py-2">Kwesi Kumi</td>
              <td>Abeka</td>
              <td>September 23, 2025</td>
              <td><span class="text-green-600">Completed</span></td>
              <td><button class="text-purple-600">View</button></td>
            </tr>
          </tbody>
        </table>
      </div> --}}





<div class="shadow-md rounded-2xl">

      <table class="min-w-full mt-6 text-left bg-white rounded-2">
       <thead class="text-sm text-gray-600 bg-gray-100">
         <tr>

           <th class="p-4 font-mediumt text-[15px]">Project Name</th>
           <th class="p-4 font-mediumt text-[15px]">Status</th>
           <th class="p-4 font-mediumt text-[15px]">Client Name</th>
           <th class="p-4 font-mediumt text-[15px]">Technical Supervisor</th>
           <th class="p-4 font-mediumt text-[15px]">Duration</th>
           <th class="p-4 font-mediumt text-[15px]">Cost</th>
         </tr>
       </thead>
       <tbody>
        <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]"> ThinkTech Cabinet</td>
             <td class="p-4 font-normal text-[15px]"> Completed</td>
             <td class="p-4 font-normal text-[15px]"> Elorm Doe</td>
             <td class="p-4 font-normal text-[15px]"> Joyce Amoah</td>
             <td class="p-4 font-normal text-[15px]"> Three days</td>
             <td class="p-4 font-normal text-[15px]"> 56768</td>

            </tr>
              <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]"> ThinkTech Cabinet</td>
             <td class="p-4 font-normal text-[15px]"> Completed</td>
             <td class="p-4 font-normal text-[15px]"> Elorm Doe</td>
             <td class="p-4 font-normal text-[15px]"> Joyce Amoah</td>
             <td class="p-4 font-normal text-[15px]"> Three days</td>
             <td class="p-4 font-normal text-[15px]"> 76878</td>

            </tr>
              <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]"> ThinkTech Cabinet</td>
             <td class="p-4 font-normal text-[15px]"> Completed</td>
             <td class="p-4 font-normal text-[15px]"> Elorm Doe</td>
             <td class="p-4 font-normal text-[15px]"> Joyce Amoah</td>
             <td class="p-4 font-normal text-[15px]"> Three days</td>
             <td class="p-4 font-normal text-[15px]"> 576878</td>

            </tr>
              <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]"> ThinkTech Cabinet</td>
             <td class="p-4 font-normal text-[15px]"> Completed</td>
             <td class="p-4 font-normal text-[15px]"> Elorm Doe</td>
             <td class="p-4 font-normal text-[15px]"> Joyce Amoah</td>
             <td class="p-4 font-normal text-[15px]"> Three days</td>
             <td class="p-4 font-normal text-[15px]"> 5676878</td>

            </tr>





       </tbody>
      </table>


      {{-- <div class="grid grid-cols-1 gap-6 my-10 sm:grid-cols-3">
    <!-- Total Assigned Projects -->
    <div class="p-6 text-center bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700">Assigned Projects</h3>
        <p class="mt-2 text-3xl font-bold text-fuchsia-900">{{ $totalAssigned }}</p>
    </div>

    <!-- Completed Projects -->
    <div class="p-6 text-center bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700">Completed Projects</h3>
        <p class="mt-2 text-3xl font-bold text-green-600">{{ $completed }}</p>
    </div>

    <!-- Due Soon (Next 10 Days) -->
    <div class="p-6 text-center bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700">Due in 10 Days</h3>
        <p class="mt-2 text-3xl font-bold text-yellow-500">{{ $dueSoon }}</p>
    </div>
</div> --}}


      </div>
</div>
</main>


<div class="p-6 space-y-10">

    {{-- Upcoming Deadlines --}}
    <div>
        <h2 class="text-xl font-bold mb-4">Upcoming Deadlines</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($projectsWithDeadlines as $item)
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4
                    {{ $item['status'] === 'At risk' ? 'border-red-500' : 'border-yellow-500' }}">
                    <p class="text-lg font-semibold text-gray-700">
                        {{ $item['client_name'] }}
                    </p>
                    <p class="text-sm text-gray-500">Design Date: {{ $item['design_date'] }}</p>
                    <span class="text-xs mt-2 inline-block px-3 py-1 rounded-full
                        {{ $item['status'] === 'At risk' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $item['status'] }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500">No upcoming deadlines.</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Activities --}}
    <div>
        <h2 class="text-xl font-bold mb-4">Recent Activities</h2>
        <ul class="space-y-3">
            @forelse($recentComments as $comment)
                <li class="bg-white p-4 rounded-xl shadow flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-800">
                            <span class="font-semibold">{{ $comment->user->name }}</span>
                            added new comment in
                            <span class="font-semibold">{{ $comment->project->name }}</span>
                        </p>
                        <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('tech.project.show', $comment->project_id) }}"
                       class="text-blue-600 text-sm hover:underline">View</a>
                </li>
            @empty
                <li class="text-gray-500">No recent activities.</li>
            @endforelse
        </ul>
    </div>

</div>

</x-Designer-layout>
