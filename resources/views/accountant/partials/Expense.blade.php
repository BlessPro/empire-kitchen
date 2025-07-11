<div class="col-span-2 p-4 bg-white rounded-[15px]  shadow">
 <div class="flex justify-between items-center bg-white  rounded-2xl pb-6 w-full max-w-4xl">
  <div>
    <p class="text-gray-700 font-semibold text-lg">Total Expense</p>
    <div class="flex items-center space-x-4 mt-1">

    </div>
  </div>


</div>

        <div class="relative h-80">
            <canvas id="revenueChart11" class="absolute w-full h-full"></canvas>
        </div>

</div>

{{--table--}}

<div class="shadow-md rounded-[15px]">

      <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
       <thead class="text-sm text-gray-600 bg-gray-100">
         <tr>

           <th class="p-4 font-mediumt text-[15px]">Expense</th>
           <th class="p-4 font-mediumt text-[15px]">Category</th>
           <th class="p-4 font-mediumt text-[15px]">Project</th>
           <th class="p-4 font-mediumt text-[15px]">Date</th>
           <th class="p-4 font-mediumt text-[15px]">Amount</th>

         </tr>
       </thead>
       <tbody>

        <tr class="border-t hover:bg-gray-50">
             <td class="p-4 font-normal text-[15px]">Cabinet pins</td>
             <td class="p-4 font-normal text-[15px]">Materials </td>
             <td class="p-4 font-normal text-[15px]">Kichen Cabinet </td>
             <td class="p-4 font-normal text-[15px]">17 January,2025 </td>
             <td class="p-4 font-normal text-[15px]">300 </td>
          </tr>

    @foreach ($incomes1 as $income)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-4 font-normal text-[15px]">{{ $income->client->firstname ?? 'Unknown' }}</td>
                <td class="p-4 font-normal text-[15px]">{{ $income->category->name ?? 'Uncategorized' }}</td>
                <td class="p-4 font-normal text-[15px]">{{ $income->project->name ?? 'No Project' }}</td>
                <td class="p-4 font-normal text-[15px]">{{ $income->created_at->format('d F, Y') }}</td>
                <td class="p-4 font-normal text-[15px]">₵{{ number_format($income->amount, 2) }}</td>
            </tr>
        @endforeach


            {{--

       </tbody>
      </table>

      <div class="mt-4 mb-5 ml-5 mr-5">
        {{-- {{ $projects->links('pagination::tailwind') }} --}}
      </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/accountant/Report&Analytics/expenses-data') // Adjust the URL to your route
            .then(response => response.json())
            .then(data => {
                const ctx11 = document.getElementById('revenueChart11').getContext('2d');
                new Chart(ctx11, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Expenses',
                            data: data, // fetched array
                            borderColor: '#6D28D9',
                            tension: 0.4,
                            fill: true,
                            backgroundColor: 'rgba(109, 40, 217, 0.1)'
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
            })
            .catch(error => console.error('Error fetching chart data:', error));
    });
</script>

{{-- <script>
        const ctx11 = document.getElementById('revenueChart11').getContext('2d');
        new Chart(ctx11, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 15000, 10000, 18000, 22000, 25000, 27000, 20000, 23000, 21000, 19000, 24000],
                    borderColor: '#6D28D9',
                    tension: 0.4,
                    fill: true,
                     backgroundColor: ['purple', ],
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
    </script> --}}

