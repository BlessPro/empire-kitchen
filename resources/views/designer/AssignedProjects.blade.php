   <x-designer-layout>
       <x-slot name="header">
           <!--written on 16.05.2025-->
           @include('admin.layouts.header')
       </x-slot>

       @php
           $statusClasses = [
               'ON_GOING' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
               'COMPLETED' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
               'IN_REVIEW' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
           ];

           $defaultClass = 'bg-gray-100 text-gray-800';
       @endphp
       <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
           <!--head begins-->


           <div class="]">
               <div class="mb-[20px]">

                   <h2 class="mb-6 text-2xl font-bold">Assigned Projects </h2>
                   <div class="mb-20 bg-white shadow rounded-2xl">



                       <div class="flex items-center justify-between">


                           <div class="pt-6 pb-5 pl-6 border-b border-gray-200 ">

                               <h2 class="font-normal text-gray-900 text-normal">Manage your clients here</h2>
                           </div>

                           <div class="pt-4 pr-4">
                               <form method="GET" action="{{ url('designer/AssignedProjects') }}"
                                   class="flex flex-wrap gap-3 mb-4">
                                   {{-- Client search --}}
                                   <input type="text" name="q" value="{{ request('q') }}"
                                       placeholder="Search client name…"
                                       class="pt-2 pb-2 pl-5 pr-5 text-sm border-gray-300 rounded-full" />

                                   {{-- Status select (COMPLETED / IN_REVIEW / ON_GOING) --}}
                                   <select name="status"
                                       class="pt-2 pb-2 pl-5 pr-5 text-sm border-gray-300 rounded-full">
                                       <option value="">All Statuses</option>
                                       @foreach ($statusOptions as $opt)
                                           <option value="{{ $opt }}" @selected(strtoupper(request('status')) === $opt)>
                                               {{ $opt }}</option>
                                       @endforeach
                                   </select>

                                   <button class="px-5 pt-2 pb-2 text-sm border border-gray-300 rounded-full">
                                       Apply
                                   </button>
                               </form>
                           </div>
                       </div>

                       <div class="overflow-x-auto">
                           <table class="min-w-full text-left">
                               <thead class="items-center text-sm text-gray-600 bg-gray-100">
                                   <tr>
                                       <th class="p-4 font-medium text-[15px] items-center">Client</th>
                                       <th class="p-4 font-medium text-[15px] items-center">Location</th>
                                       <th class="p-4 font-medium text-[15px] items-center">Installation Date</th>
                                       <th class="p-4 font-medium text-[15px] items-center text-left">Status</th>
                                       <th class="p-4 font-medium text-[15px] items-center text-left">Action</th>
                                   </tr>
                               </thead>

                               <tbody class="text-gray-700 border-b divide-y divide-gray-100 hover:bg-gray-50">
                                   @forelse ($projects as $project)
                                       <tr class="border-b hover:bg-gray-50">
                                           <td class="px-4 py-2 text-[13px]">
                                               {{ trim(($project->client->firstname ?? '') . ' ' . ($project->client->lastname ?? '')) ?: '—' }}
                                           </td>

                                           <td class="px-4 py-2 text-[13px]">
                                               {{ $project->location ?? '—' }}
                                           </td>

                                           <td class="px-4 py-2 text-[13px]">
                                               @php
                                                   $d = $project->latestInstallation?->install_date; // or installation?->install_date
                                               @endphp
                                               {{ $d ? ($d->format('H:i:s') === '00:00:00' ? $d->format('d M Y') : $d->format('d M Y · g:i A')) : '—' }}
                                           </td>

                                           <td class="px-4 py-2 text-[13px]">
                                               @php
                                                   $status = (string) ($project->status ?? '—');
                                               @endphp
                                               <span
                                                   class="px-3 py-1 text-[13px] {{ $statusClasses[$status] ?? $defaultClass }}">
                                                   {{ $status }}
                                               </span>
                                           </td>

                                           <td class="px-4 py-2 text-[13px] text-left">
                                               <a href="#"
                                                   class="inline-flex items-center text-[13px] justify-center w-8 h-8 rounded-md hover:bg-gray-100"
                                                   title="View">
                                                   <iconify-icon icon="mdi:eye-outline"
                                                       class="text-[13px]"></iconify-icon>
                                               </a>
                                           </td>
                                       </tr>
                                   @empty
                                       <tr>
                                           <td colspan="5" class="px-4 py-6 text-center text-gray-500">No assigned
                                               projects yet.</td>
                                       </tr>
                                   @endforelse
                               </tbody>
                           </table>
                       </div>


                       <!-- Pagination -->
                   </div>



                   <div class="mt-4">
                       {{ $projects->links() }}
                   </div>


               </div>
           </div>
       </main>
   </x-designer-layout>
