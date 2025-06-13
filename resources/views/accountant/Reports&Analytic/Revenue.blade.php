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
      

          @forelse($clientIncomes as $report)
                <tr class="border-b">
                    <td class="p-4 font-normal text-[15px]">{{ $report['client_name'] }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ number_format($report['total_income'], 2) }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ \Carbon\Carbon::parse($report['from_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($report['to_date'])->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-2 text-center text-gray-500">No income data available.</td>
                </tr>
            @endforelse
       </tbody>
      </table>

      <div class="mt-4 mb-5 ml-5 mr-5">
        {{-- {{ $clientIncomes->links('pagination::tailwind') }} --}}
        <div class="mt-4">
</div>
      </div>

</div>





<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/accountant/Report&Analytics/incomes-data')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('revenueChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Incomes',
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
 --}}
