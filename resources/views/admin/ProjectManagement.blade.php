<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')

        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
           ProjectManagement?
        </h1>
        <h2 class="text-xl font-bold mb-4">All Projects</h2>

<main class="ml-64 mt-[100px] flex-1 bg-gray-100 min-h-screen  items-center">

    <div class="p-6 bg-[#F9F7F7]">
     <div class="mb-[20px]">

        {{-- <table class="table-auto w-full border">
            <thead>
              <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Start Date</th>
                <th class="border px-4 py-2">New</th> --}}

                            {{--working table--}}

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
            {{-- <tr class="border-t hover:bg-gray-50">
                <td class="p-4"><input type="checkbox" class="child-checkbox"/></td>
                <td class="p-4 font-normal text-[15px]">{{ $project->name }}</td>
                <td class="p-4">
                  <span class="px-3 py-1 text-sm rounded-full ${item.statusStyle}">{{ $project->status }}</span>
                </td>
                <td class="p-4 font-normal text-[15px]">{{ $project->client->firstname }}</td>
                <td class="p-4 font-normal text-[15px]">{{$project->cost}}</td>

                <td class="p-4 text-right"><button class="text-gray-500 hover:text-red-500"><i data-feather="layers" class="mr-3"></i> </button></td>
              </tr> --}}
            {{-- <tbody>
              @foreach($projects as $project)
                <tr>
                  <td class="border px-4 py-2">{{ $project->id }}</td>
                  <td class="border px-4 py-2">{{ $project->name }}</td>
                  <td class="border px-4 py-2">{{ $project->status }}</td>
                  <td class="border px-4 py-2">{{ $project->start_date }}</td>
                  <td class="border px-4 py-2">{{ $project->client->firstname }}</td>

                  <td></td> --}}
                  {{-- {{ $project->created_at->diffForHumans() }} --}}
                </tr>

              {{-- @endforeach
            </tbody> --}}


          </table>
          {{ $projects->links() }}



   </div>
 </div>
 </main>
    </x-slot>
</x-layouts.app>
