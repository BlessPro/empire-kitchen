   <x-tech-layout>
   <x-slot name="header">
<!--written on 16.05.2025-->
        @include('admin.layouts.header')
    @php
        $statusClasses = [
            'in progress' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
            'completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
            'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
        ];
        $defaultClass = 'bg-gray-100 text-gray-800';
    @endphp
        <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="]">
             <div class="mb-[20px]">
                <h2 class="font-semibold text-[30px] mb-6">My Client </h2>
        <div class="mb-20 bg-white shadow rounded-2xl">
            <div class="pt-6 pb-5 pl-6 ">
            <h2 class="text-sm text-gray-600 ">Manage all your Clients here</h2>
            </div>
            <div class="overflow-x-auto">
                 <table class="min-w-full text-left">
                    <thead class="items-center text-sm text-gray-600 bg-gray-100">
                      <tr>
                        <th class="p-4 font-mediumt text-[15px] items-center">Client Name</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Project Name</th>
                        {{-- <th class="p-4 font-mediumt text-[15px] items-center">Phone Number</th> --}}
                        <th class="p-4 font-mediumt text-[15px] items-center">Location</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Measurement Date</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Status</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Designer</th>
                      </tr>
                    </thead>

                <tbody class="text-gray-700 divide-y divide-gray-100">

                     @foreach($projects as $project)
                      <tr class="cursor-pointer hover:bg-gray-100">
                    <td class="p-4 font-normal text-[15px] items-center">{{ $project->client->title.' '. $project->client->firstname. ' '.$project->client->lastname }}</td>

                    <td class="p-4 font-normal text-[15px] items-center">{{ $project->name }}</td>
                    {{-- <td class="p-4 font-normal text-[15px] items-center">Kasoa</td> --}}
                    <td class="p-4 font-normal text-[15px] items-center">
                        {{$project->location}}</td>
                    <td class="p-4 font-normal text-[15px] items-center ">
                        {{ $project->created_at }}
                    </td>
                    <td class="p-4 font-normal text-[15px] items-center">
                        {{-- {{ ucfirst($project->status) }} --}}

                              <span class="px-3 py-1 text-sm {{ $statusClasses[$project->status] ?? $defaultClass }}">{{ $project->status }}</span>
                    </td>
                    <td class="p-4 font-normal text-[15px]  flex items-center py-3 space-x-2">

                         @if($project->designer)
                            <div class="d-flex align-items-center p-4 font-normal text-[15px] flex items-center py-3 space-x-2 ">
                              {{-- <img  src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : 'https://i.pravatar.cc/30' }}" > --}}
                                <img src="{{ asset('storage/' . $project->designer->profile_pic) }}" alt="designer" width="40" height="40" class="object-cover w-8 h-8 rounded-full">
                                <span>{{ $project->designer->name }}</span>
                            </div>
                        @else
                            <!-- Button to Open Modal -->
                            <button
                            class  ="flex px-3 py-1 text-sm font-medium text-purple-800
                             bg-purple-100 border border-purple-800 rounded-full
                             hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                             onclick="openModal('{{ $project->id }}', '{{ $project->name }}')" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal" data-project-id="{{ $project->id }}">
                               <span>  <i data-feather="plus" class="w-4 h-5 m"> </i> </span> Assign
                            </button>
                        @endif
                </td>
                  </tr>
                              @endforeach
                </tbody>
              </table>
             <div class="mt-4 mb-4 ml-4 mr-4">
            {{$projects->links('pagination::tailwind')}}
            </div>
            </div>

            <!-- Pagination -->

            </div>

        {{-- Select designer pop-up --}}
        <!-- Modal -->
<div id="assignModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50">
    <div class="w-full max-w-md p-6 bg-white rounded shadow-md">
          <div class="flex flex-col justify-between gap-4 mb-4 sm:flex-row">
        <h2 class="mb-4 text-xl font-semibold">Assign Designer</h2>
        <button  type="button" onclick="closeModal()" class="px-4 py-2 mt-2 rounded text-fuchsia-900"> <i data-feather="x"
    class="mr-3 feather-icon group"></i></button>
        </div>
        <form method="POST" action="{{ route('tech.AssignDesigners') }}">
            @csrf
            <input type="hidden" name="project_id" id="projectIdInput">

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium">Project Name</label>
                <input type="text" id="projectNameInput" disabled readonly class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>

          <div class="mb-4">
      <label for="design_date" class="block mb-3 text-sm font-medium text-gray-700">Due Date</label>
      <input type="date" name="design_date" id="design_date" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

           <div class="mb-4 max-h-[300px] overflow-y-auto space-y-4">
    <label class="block mb-2 text-sm font-medium">Select Designer</label>

    @foreach ($designers as $designer)
        <label class="flex items-center justify-between cursor-pointer p-2 rounded-md border border-gray-200 hover:bg-gray-100">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('storage/' . $designer->profile_pic) }}" alt="Designer" class="w-10 h-10 rounded-full object-cover">
                <span class="font-medium text-gray-800">{{ $designer->name }}</span>
            </div>

            @if($project->designer_id === $designer->id)
                <span class="text-sm text-purple-800 font-semibold">Already Assigned</span>
            @else
                <input type="radio" name="designer_id" value="{{ $designer->id }}" class="form-radio text-fuchsia-800 focus:ring-fuchsia-900">
            @endif
        </label>
    @endforeach
</div>


            <div class="flex justify-end space-x-2">
<button type="submit" class="bg-fuchsia-900 w-full text-[20px] text-white px-4 py-2 mt-5 rounded-[20px]">Proceed</button>
            </div>
        </form>
    </div>
</div>

               </div>
            </div>

        </main>

<script>
function openModal(projectId, projectName) {
    document.getElementById('projectIdInput').value = projectId;
    document.getElementById('projectNameInput').value = projectName;
    document.getElementById('assignModal').classList.remove('hidden');
    document.getElementById('assignModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('assignModal').classList.add('hidden');
    document.getElementById('assignModal').classList.remove('flex');
    alert("Assignement Created successfully")
}
</script>

</x-tech-layout>
