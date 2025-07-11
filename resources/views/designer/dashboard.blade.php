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

<div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
  <!-- Closed Deals -->
  <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
    <div>
      <p class="mb-6 text-[22px] font-semibold text-gray-700">Assigned Projects</p>
      <h2 class="text-[50px] font-semibold ">{{ $totalAssigned }}</h2>
    </div>
    <div class="flex items-center justify-center w-[70px] h-[70px] bg-orange-100 rounded-full">
           {{-- <i class=" text-orange-500 w-5 h-5" data-feather="dollar-sign"></i> --}}
           <iconify-icon icon="iconamoon:profile-light" width="24" style="color: #ff9800;"></iconify-icon>


    </div>
  </div>

  <!-- Revenue Generated -->
  <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
    <div>
      <p class="mb-6 text-[22px] font-semibold text-gray-700">Completed</p>
      <h2 class="text-[50px] font-semibold">{{ $completed}}</h2>
    </div>
    <div class="flex items-center justify-center w-[70px] h-[70px] bg-green-100 rounded-full">
           {{-- <i class=" text-green-500 w-5 h-5" data-feather="dollar-sign"></i> --}}
           <iconify-icon icon="lets-icons:check-ring-light" width="24"  class="text-green-500"></iconify-icon>

    </div>
  </div>

  <!-- Completed Follow-ups -->
  <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
    <div>
      <p class="mb-6 text-[22px] font-semibold text-gray-700">Due Soon</p>
      <h2 class="text-[50px] font-semibold">{{ $dueSoon }}</h2>
    </div>
    <div class="flex items-center justify-center w-[70px] h-[70px] bg-red-100 rounded-full">

           <iconify-icon icon="mynaui:danger-triangle" width="24"  class="text-red-500"></iconify-icon>

    </div>
  </div>
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
