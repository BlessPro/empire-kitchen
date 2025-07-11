   <x-tech-layout>
   <x-slot name="header">
<!--written on 16.05.2025-->
        @include('admin.layouts.header')
         </x-slot>
        <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="]">
             <div class="mb-[20px]">



    <div class="flex items-center justify-between mb-6">

    <!-- Top Navbar -->
    <div><h1 class="text-[30px] font-bold">Reports</h1></div>
    {{-- <div>
     <button class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-full text-fuchsia-800 border-fuchsia-800">
                        Download
                      </button></div> --}}

                      <a href="{{ route('admin.export-csv') }}">
      <button class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-full text-fuchsia-800 border-fuchsia-800">
Download
 <!-- #region --></a>



 </div>
        <div class="mb-20 bg-white shadow rounded-2xl">
            <div class="pt-6 pb-5 pl-6 ">
            <h2 class="text-sm text-gray-600 ">Manage all your Clients here</h2>
            </div>
            <div class="overflow-x-auto">
                 <table class="min-w-full text-left">
                    <thead class="items-center text-sm text-gray-600 bg-gray-100">
                      <tr >

                        <th class="p-4 font-mediumt text-[15px] items-center">Projects</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Location</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Measurement Date</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Width(m/ft)</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Height(m/ft)</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Length(m/ft)</th>
                      </tr>
                    </thead>

                <tbody class="text-gray-700 divide-y divide-gray-100">

   @forelse($projects as $project)
                @foreach($project->measurement as $measurement)

                <tr class="cursor-pointer hover:bg-gray-100">
                    <td class="p-4 font-normal text-[15px] items-center">{{ $project->name }}</td>

                    <td class="p-4 font-normal text-[15px] items-center">{{ $project->location }}</td>
                    <td class="p-4 font-normal text-[15px] items-center">January 11, 2025</td>
                    <td class="p-4 font-normal text-[15px] items-center">{{ $measurement->width }}</td>
                    <td class="p-4 font-normal text-[15px] items-center">{{ $measurement->height }}</td>
                    <td class="p-4 font-normal text-[15px] items-center">{{ $measurement->length }}</td>

                </tr>

                    @endforeach
            @empty
                <tr>
                    <td colspan="6">No measurement projects found.</td>
                </tr>
            @endforelse

                </tbody>
              </table>
              <div class="mt-4 mb-5 ml-5 mr-5">
            </div>
            </div>

            <!-- Pagination -->

            </div>



             </div>
            </div>
        </main>
        </x-tech-layout>
