



{{--table--}}

<div class="shadow-md rounded-[15px]">

      <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">
         <tr>

           <th class="p-4 font-mediumt text-[15px]">Project Name</th>
           <th class="p-4 font-mediumt text-[15px]">Allocated Budget</th>
           <th class="p-4 font-mediumt text-[15px]">Actual Spending</th>
           <th class="p-4 font-mediumt text-[15px]">Status</th>

         </tr>
       </thead>
       <tbody>

        <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]">Kitchen Stool</td>
             <td class="p-4 font-normal text-[15px]">989 </td>
             <td class="p-4 font-normal text-[15px]"> 567</td>
             <td class="inline-block text-[13px] bg-red-100 text-red-700 mt-3 px-4 py-[3px] border border-red-500 rounded-full"> At risk </td>
            </tr>

             <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]">Kitchen cabinet</td>
             <td class="p-4 font-normal text-[15px]">2389 </td>
             <td class="p-4 font-normal text-[15px]"> 2500</td>
             <td class="inline-block text-[13px] bg-green-100 text-green-700 mt-3 px-4 py-[3px] border border-green-500 rounded-full"> On track </td>
            </tr>
            
       </tbody>
      </table>

      <div class="mt-4 mb-5 ml-5 mr-5">
        {{-- {{ $projects->links('pagination::tailwind') }} --}}
      </div>

</div>
