<x-layouts.app>
    <x-slot name="header">
<!--written on 26.04.2025-->
        @include('admin.layouts.header')
        <main class="ml-64 mt-[100px] flex-1 bg-gray-100 min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">            <!---->
          <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Clients Management</h1>
            <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button>
          </div>
          <!---->
        </div>

   
        
        <!--head ends-->
        <!--table begins-->

        <div class="mb-20 bg-white shadow rounded-2xl">
            <div class="pt-6 pb-5 pl-6 border-b">
            <h2 class="text-sm text-gray-600 ">Manage all your Clients here</h2>
            </div>
            <div class="overflow-x-auto">
              {{-- <table class="min-w-full pt-6 pb-5 pl-6 text-sm text-left">
                <thead class="pt-6 pb-5 pl-6 bg-gray-200">
                  <tr class="text-black-900 ">
                    <th class="p-4 font-bold">
                      Client Name
                      <span class="inline-block ml-1">&#8597;</span>
                    </th>
                    <th class="p-4 font-bold">
                      Phone Number
                      <span class="inline-block ml-1">&#8597;</span>
                    </th>
                    <th class="p-4 font-bold">
                      Projects
                      <span class="inline-block ml-1">&#8597;</span>
                    </th>
                    <th class="p-4 font-bold">
                      Location
                      <span class="inline-block ml-1">&#8597;</span>
                    </th>
                  </tr>
                </thead> --}}
                <table class="min-w-full text-left">
                    <thead class="items-center text-sm text-gray-600 bg-gray-100">
                      <tr>

                        <th class="p-4 font-mediumt text-[15px] items-center">Client Name</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Phone Number</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Projects</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Location</th>
                      </tr>
                    </thead>

                <tbody class="text-gray-700 divide-y divide-gray-100">



                @foreach ( $Clients as $Client )
                <tr class="items-center border-t hover:bg-gray-50">
                    <td class="p-4 font-normal text-[15px] items-center">{{$Client->title. ' '.$Client->firstname . ' '.$Client->lastname }}</td>

                    <td class="p-4 font-normal text-[15px] items-center">{{$Client->phone_number}}</td>
                    <td class="p-4 font-normal text-[15px] items-center">{{$Client->projects_count}}</td>
                    <td class="p-4 font-normal text-[15px] items-center">{{$Client->location}}</td>

                  </tr>
                @endforeach

                </tbody>
              </table>
              <div class="mt-4">
                {{ $Clients->links('pagination::tailwind') }}
            </div>
            </div>

            <!-- Pagination -->

            </div>



    </div>
</div>
</main>

         @vite(['resources/js/app.js'])

    </x-slot>



</x-layouts.app>
