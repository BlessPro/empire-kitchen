{{--table--}}

<div class="shadow-md  bg-white rounded-[20px]">

      <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">
         <tr>
           <th class="p-4 font-mediumt text-[15px]">Project Name</th>
           <th class="p-4 font-mediumt text-[15px]">Total Income(GH₵)</th>
           <th class="p-4 font-mediumt text-[15px]">Total Expense(GH₵)</th>
           <th class="p-4 font-mediumt text-[15px]">Net Profit(GH₵)</th>
            <th class="p-4 font-mediumt text-[15px]">Profit Margin</th>
         </tr>
       </thead>
       <tbody>
@foreach ($projects as $project)
            <tr>
                <td class="p-4 font-normal text-[15px]">{{ $project->name }}</td>
                <td class="p-4 font-normal text-[15px]">₵{{ number_format($project->total_income, 2) }}</td>
                <td class="p-4 font-normal text-[15px]">₵{{ number_format($project->total_expense, 2) }}</td>
                <td class="p-4 font-normal text-[15px]">₵{{ number_format($project->net_profit, 2) }}</td>
                <td class="p-4 font-normal text-[15px]">{{ $project->profit_margin }}%</td>
            </tr>
        @endforeach


    </tbody>
        </table>
      <div class="mt-4 mb-5 ml-5 mr-5">
        {{ $projects->links('pagination::tailwind') }}
      </div>

</div>

{{-- End of table --}}

