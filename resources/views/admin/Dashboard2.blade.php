<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')
        {{ dd($projects) }}

        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
           ProjectManagement?
        </h1>
        <h2 class="mb-4 text-xl font-bold">All Projects</h2>

<main class="ml-64 mt-[100px] flex-1 bg-gray-100 min-h-screen  items-center">

    <div class="p-6 bg-[#F9F7F7]">
     <div class="mb-[20px]">



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



          </table>
          <div class="pagination-wrapper">
        </div>

        <div class="mt-4">
            {{ $projects->links('pagination::tailwind') }}
        </div>


   </div>
 </div>
 </main>
    </x-slot>
</x-layouts.app>
