
      @php
       
             $statusClasses = [
            'completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
            'in progress' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
            'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
        ];
        
              $defaultClass = 'bg-gray-100 text-gray-800';
    @endphp


      <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">

         <tr>

           <th class="p-4 font-mediumt text-[15px]">Client Name</th>
           <th class="p-4 font-mediumt text-[15px]">Amount</th>
           <th class="p-4 font-mediumt text-[15px]">Due Date</th>
           <th class="p-4 font-mediumt text-[15px]">Status</th>

         </tr>
       </thead>
       <tbody>


         @foreach ($DashboardIncomeTables as $DashboardIncomeTable)
         <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]">{{$DashboardIncomeTable->client->title.' '.$DashboardIncomeTable->client->firstname.' '.$DashboardIncomeTable->client->lastname}} </td>
             <td class="p-4 font-normal text-[15px]">{{$DashboardIncomeTable->amount}}</td>
             <td class="p-4 font-normal text-[15px]"> {{$DashboardIncomeTable->date}}</td>
            

                <td class="p-2 font-normal text-[15px]">
        <span class="px-3 py-1 text-sm {{ $statusClasses[$DashboardIncomeTable->status] ?? $defaultClass }}">{{ $DashboardIncomeTable->status }}</span>
    </td>
            </tr>
        @endforeach

       </tbody>
      </table>

      <div class="mt-4 mb-2 ml-5 mr-2">
        {{$DashboardIncomeTables->links('pagination::tailwind') }}
      </div>