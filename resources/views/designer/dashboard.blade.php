<!-- Example for designer -->
   <x-Designer-layout>
    <div class="p-6 text-gray-900">Welcome designer!</div>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Designer Dashboard') }}
        </h2>
    </x-slot>

<main class="ml-64 flex-1 bg-[#F9F7F7] min-h-screen  items-center">

    <div class=" pb-[24px] pr-[24px] pl-[24px] bg-[#F9F7F7]">
     <div class="">

                <h1 class="font-semibold text-[30px] mb-3"> Overview </h1>


      <!-- Overview Cards -->
      <div class="grid grid-cols-3 gap-6 mb-6">


          {{--new 1--}}

           <div class="bg-white p-4 rounded-[25px] shadow items-center">
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

           <div class="bg-white p-4 rounded-[25px] shadow items-center">
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

           <div class="bg-white p-4 rounded-[25px] shadow items-center">
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


<div class="flex flex-col gap-6 font-sans text-black lg:flex-row ">
  <!-- Upcoming Deadlines -->
  <div class="w-full p-6 bg-white shadow-md rounded-2xl lg:w-1/2">
    <h2 class="mb-4 text-2xl font-semibold">Upcoming Deadlines</h2>
    <div class="space-y-4">
      <!-- Yaw Boateng -->
                  @foreach($designs as $design)

      <div class="flex items-center justify-between pb-4 border-b">
        <div class="flex items-center gap-3">
          <span class="font-medium">{{ $design->project->client->title. ' '.$design->project->client->firstname. ' '. $design->project->client->firstname  }}</span>
          {{-- <span class="px-3 py-1 text-sm text-red-500 border border-red-400 rounded-full">At Risk</span> --}}
         <span class="px-3 py-1 text-sm text-red-500 border border-red-400 rounded-full {{ $design->urgency === 'at_risk' ? 'text-red-500' : 'text-yellow-500' }}">
                            {{ $design->urgency === 'at_risk' ? 'At Risk' : 'On Track' }}
                        </span>
        </div>
        <div class="flex items-center gap-2 text-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span>{{ $design->design_date->format('d M Y') }}</span>
        </div>
      </div>
            @endforeach

       {{-- Upcoming Deadlines --}}

    </div>
  </div>

  <!-- Recent Activities -->
  <div class="w-full p-6 bg-white shadow-md rounded-2xl lg:w-1/2">
    <h2 class="mb-4 text-2xl font-semibold">Recent Activities</h2>
    <div class="space-y-6">


         <div class=" pt-[10px] pb-[10px] ">
        <ul>
            @forelse($recentComments as $comment)
                <li class="mb-4  pb-4 flex justify-between items-center">
                 <img
    src="{{ $comment->user->profile_pic
        ? asset('storage/' . $comment->user->profile_pic)
        : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
    alt="Profile Photo"
    class="w-10 h-10 rounded-full pr-[2px]">

                    <div>
                        <p><strong>{{ $comment->user->name }}</strong> added a comment in <strong>{{ $comment->project->name }}</strong></p>
                        <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>

                    </div>
                    <br>
                     <button onclick="markAsViewed({{ $comment->id }})" class="font-semibold text-fuchsia-900 hover:underline ml-[10px] mt-[-20px] ">Mark as Read</button>
                  </li>
            @empty
                <li>No new activities.</li>
            @endforelse
        </ul>
    </div>

    </div>
  </div>
</div>




        {{--recent activities--}}



<div class="shadow-md rounded-2xl">

      <table class="min-w-full mt-6 text-left bg-white rounded-2">
       <thead class="text-sm text-gray-600 bg-gray-100">
         <tr>

           <th class="p-4 font-mediumt text-[15px]">Project Name</th>
           <th class="p-4 font-mediumt text-[15px]">Location</th>
           <th class="p-4 font-mediumt text-[15px]">Design Date</th>
           <th class="p-4 font-mediumt text-[15px]">Status</th>
           <th class="p-4 font-mediumt text-[15px]">Action</th>

         </tr>
       </thead>
       <tbody>
                @foreach ($projects as $project)

        <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]"> {{ $project->name }}</td>
             <td class="p-4 font-normal text-[15px]"> {{ $project->location }}</td>
             <td class="p-4 font-normal text-[15px]">
             {{ optional($project->designs->first())->design_date ? \Carbon\Carbon::parse($project->designs->first()->design_date)->format('M d, Y') : 'N/A' }}

             </td>
             <td class="p-4 font-normal text-[15px]"> {{ ucfirst($project->status) }}</td>
             <td class="p-4 font-normal text-[15px]"> <i data-feather="eye" class="text-fuchsia-900 cursor:pointer hover:text-red-800"> </i></td>
            </tr>
              @endforeach

       </tbody>
      </table>

      <div class="mt-4 mb-5 ml-5 mr-5">
        {{ $projects->links('pagination::tailwind') }}
      </div>

</div>

      </div>
</div>
</main>



</x-Designer-layout>
