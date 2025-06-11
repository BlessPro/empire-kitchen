<div class="col-span-2 p-4 bg-white rounded-[15px]  shadow">
 <div class="flex justify-between items-center bg-white  rounded-2xl pb-6 w-full max-w-4xl">
  <div>
    <p class="text-gray-700 font-semibold text-lg">Total Revenue</p>
    <div class="flex items-center space-x-4 mt-1">
     
    </div>
  </div>

 
</div>
        <div class="relative h-80">
            <canvas id="revenueChart" class="absolute w-full h-full"></canvas>
        </div>

</div>
{{--table--}}
<div class="shadow-md rounded-[15px]">
      <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">
         <tr>
           <th class="p-4 font-mediumt text-[15px]">Client Name</th>
           <th class="p-4 font-mediumt text-[15px]">Revenue / Income (GH₵)</th>
           <th class="p-4 font-mediumt text-[15px]">Date Range</th>
         </tr>
       </thead>
       <tbody>
        <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]">Kitchen Stool</td>
             <td class="p-4 font-normal text-[15px]">300 </td>
             <td class="p-4 font-normal text-[15px]"> 19th January, 2024 - 23rd December,2024</td>
          </tr>

       </tbody>
      </table>

      <div class="mt-4 mb-5 ml-5 mr-5">
        {{-- {{ $projects->links('pagination::tailwind') }} --}}
      </div>

</div>

<script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 15000, 10000, 18000, 22000, 25000, 27000, 20000, 23000, 21000, 19000, 24000],
                    borderColor: '#6D28D9',
                    // tension: 0.4,
                    fill: true,
                     backgroundColor:'rgba(109, 40, 217, 0.1)'

                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

