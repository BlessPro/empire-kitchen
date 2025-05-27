   <x-designer-layout>
   <x-slot name="header">
<!--written on 16.05.2025-->
        @include('admin.layouts.header')
         </x-slot>

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
                      <tr >

                        <th class="p-4 font-mediumt text-[15px] items-center">Client Name</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Phone Number</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Location</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Measurement Date</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Project</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Status</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Action</th>


                      </tr>
                    </thead>
                 <tbody>
                @foreach ($clients as $client)
                    @foreach ($client->projects as $project)


                        <tr  class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $client->firstname }} {{ $client->lastname }}</td>
                            <td class="px-4 py-2">{{ $client->phone_number }}</td>
                            <td class="px-4 py-2">{{ $client->location }}</td>
                            <td class="px-4 py-2">
                                @if ($project->measurement->first())
                                    {{ \Carbon\Carbon::parse($project->measurement->first()->measured_at)->format('d M Y') }}
                                @else
                                    <span class="italic text-gray-400">Not measured</span>
                                @endif
                            </td>
                              <td class="px-4 py-2">
                              <span class="text-sm ">{{ $project->name }}</span>
                            </td>
                            <td class="px-4 py-2">
                              <span class="px-3 py-1 text-sm {{ $statusClasses[$project->status] ?? $defaultClass }}">{{ $project->status }}</span>
                            </td>
                        <td  class="px-4 py-2">
                              <a cursor:pointer; href="{{ route('designer.projects.info', $project->id) }}">

                            <i data-feather="eye" class="text-gray-600"></i> </td>
                                </a>


                        </tr>
                    @endforeach
                @endforeach
            </tbody>
              </table>
  <div class="mt-4 mb-4 ml-4 mr-4">
    {!! $clients->links('pagination::tailwind') !!}
</div>


            </div>

            <!-- Pagination -->

            </div>

           </div>
    </div>
    </main>
    </x-designer-layout>
