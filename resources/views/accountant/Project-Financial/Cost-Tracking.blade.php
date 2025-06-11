



{{--table--}}

<div class="shadow-md  bg-white rounded-[20px]">

      <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">
         <tr>

           <th class="p-4 font-mediumt text-[15px]">Project Name</th>
           <th class="p-4 font-mediumt text-[15px]">Measurement($)</th>
           <th class="p-4 font-mediumt text-[15px]">Design($)</th>
           <th class="p-4 font-mediumt text-[15px]">Production($)</th>
            <th class="p-4 font-mediumt text-[15px]">Installation($)</th>

         </tr>
       </thead>
       <tbody>

        <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]">Kitchen Stool</td>
             <td class="p-4 font-normal text-[15px]">300 </td>
             <td class="p-4 font-normal text-[15px]"> 200</td>
             <td class="p-4 font-normal text-[15px]"> 100</td>
             <td class="p-4 font-normal text-[15px]"> 500</td>
            </tr>
  @foreach ($projectReports as $report)
            <tr>
                <td class="p-4 font-normal text-[15px]">{{ $report['project_name'] }}</td>
                <td class="p-4 font-normal text-[15px]">₵{{ number_format($report['measurement'], 2) }}</td>
                <td class="p-4 font-normal text-[15px]">₵{{ number_format($report['design'], 2) }}</td>
                <td class="p-4 font-normal text-[15px]">₵{{ number_format($report['production'], 2) }}</td>
                <td class="p-4 font-normal text-[15px]">₵{{ number_format($report['installation'], 2) }}</td>
            </tr>
        @endforeach


       </tbody>
      </table>


      <div class="mt-4 mb-5 ml-5 mr-5">
        {{ $projects1->links('pagination::tailwind') }}
      </div>

</div>
