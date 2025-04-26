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
            <button class="flex items-center pt-[15px] pb-[15px] pr-[35px] pl-[20px] text-white text-[20px] bg-fuchsia-900  rounded-[50px] hover:bg-purple-700">
              + Add new Lead
            </button>
          </div>
          <!---->
        </div>

        <!--head ends-->
        <!--table begins-->

        <div class="bg-white shadow rounded-2xl">
            <div class="pt-6 pb-5 pl-6 border-b">
            <h2 class="text-sm text-gray-600 ">Manage all your Clients here</h2>
            </div>
            <div class="overflow-x-auto">
              <table class="min-w-full pt-6 pb-5 pl-6 text-sm text-left">
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
                </thead>
                <tbody class="text-gray-700 divide-y divide-gray-100">
                  <tr>
                    <td class="p-4">Yaw Boateng</td>
                    <td class="p-4 font-bold">842 140 1171</td>
                    <td class="p-4">5</td>
                    <td class="p-4">East Legon</td>
                  </tr>
                  <tr>
                    <td class="p-4">Kwesi Osei</td>
                    <td class="p-4 font-bold">794 251 9038</td>
                    <td class="p-4">3</td>
                    <td class="p-4">Jamestown</td>
                  </tr>
                  <tr>
                    <td class="p-4">Kwesi Kumi</td>
                    <td class="p-4 font-bold">258 690 7892</td>
                    <td class="p-4">1</td>
                    <td class="p-4">Lapaz</td>
                  </tr>
                  <tr>
                    <td class="p-4">Akwasi Appiah</td>
                    <td class="p-4 font-bold">087 347 4389</td>
                    <td class="p-4">4</td>
                    <td class="p-4">East Legon</td>
                  </tr>
                  <tr>
                    <td class="p-4">Ngozi Ogunde</td>
                    <td class="p-4 font-bold">521 343 9455</td>
                    <td class="p-4">3</td>
                    <td class="p-4">Gomoa Fetteh</td>
                  </tr>
                  <tr>
                    <td class="p-4">Fiifi Ansah</td>
                    <td class="p-4 font-bold">665 227 2066</td>
                    <td class="p-4">5</td>
                    <td class="p-4">Kasoa</td>
                  </tr>
                  <tr>
                    <td class="p-4">Kwame Mensah</td>
                    <td class="p-4 font-bold">322 532 4447</td>
                    <td class="p-4">2</td>
                    <td class="p-4">Dzorwulu</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between mt-6 text-sm text-gray-600">
              <div class="flex items-center space-x-2">
                <button class="px-3 py-1 bg-transparent rounded hover:bg-gray-100">Previous</button>
                <button class="px-3 py-1 font-semibold text-purple-700 bg-purple-100 rounded-full">1</button>
                <button class="px-3 py-1 rounded hover:bg-gray-100">2</button>
                <button class="px-3 py-1 rounded hover:bg-gray-100">3</button>
                <button class="px-3 py-1 rounded hover:bg-gray-100">4</button>
                <span>...</span>
                <button class="px-3 py-1 rounded hover:bg-gray-100">99</button>
                <button class="px-3 py-1 bg-transparent rounded hover:bg-gray-100">Next</button>
              </div>
              <div>
                Showing 100 of 1,000 results
              </div>
            </div>
          </div>



    </div>
</div>
</main>

         @vite(['resources/js/app.js'])

    </x-slot>



</x-layouts.app>
