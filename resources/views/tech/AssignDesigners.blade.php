   <x-tech-layout>
   <x-slot name="header">
<!--written on 16.05.2025-->
        @include('admin.layouts.header')
     
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
                        <th class="p-4 font-mediumt text-[15px] items-center">Project Name</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Phone Number</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Location</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Measurement Date</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Status</th>
                        <th class="p-4 font-mediumt text-[15px] items-center">Designer</th>


                      </tr>
                    </thead>

                <tbody class="text-gray-700 divide-y divide-gray-100">



                <tr class="cursor-pointer hover:bg-gray-100">
                    <td class="p-4 font-normal text-[15px] items-center">Berla Mundi</td>

                    <td class="p-4 font-normal text-[15px] items-center">0247419436</td>
                    <td class="p-4 font-normal text-[15px] items-center">Kasoa</td>
                    <td class="p-4 font-normal text-[15px] items-center">January 11, 2025</td>
                    <td class="p-4 font-normal text-[15px] items-center">Pending</td>
                    <td class="p-4 font-normal text-[15px] items-center"><i data-feather="eye"></i></td>
                    <td class="p-4 font-normal text-[15px]  flex items-center py-3 space-x-2">
                        
                         {{-- <img src="https://i.pravatar.cc/30?img=1" class="w-8 h-8 rounded-full"> --}}
                    <img src="https://i.pravatar.cc/30" class="object-cover w-8 h-8 rounded-full">



                    <span>Bless</span></td>

                  </tr>
                      <tr class="cursor-pointer hover:bg-gray-100">
                    <td class="p-4 font-normal text-[15px] items-center">Lydia Forson</td>

                    <td class="p-4 font-normal text-[15px] items-center">0247419436</td>
                    <td class="p-4 font-normal text-[15px] items-center">Kasoa</td>
                    <td class="p-4 font-normal text-[15px] items-center">January 11, 2025</td>
                    <td class="p-4 font-normal text-[15px] items-center">Pending</td>
                    <td class="p-4 font-normal text-[15px] items-center"><i data-feather="eye"></i></td>
                    <td class="p-4 font-normal text-[15px] items-center"> 
                    <button id="openAddUserModal" class="flex px-3 py-1 text-sm font-medium text-purple-800 bg-purple-100 border border-purple-800 rounded-full hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                   <span>  <i data-feather="plus" class="w-4 h-5 m"> </i> </span> Create
                    </button></td>

                  </tr>
                

              

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