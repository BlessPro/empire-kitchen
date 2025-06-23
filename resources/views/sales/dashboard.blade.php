<!-- Example for sales -->
<x-sales-layout>


 <main class="ml-64 mt-[100px] flex-1 bg-gray-100 min-h-screen  items-center">
            <div class=" bg-[#F9F7F7]">
             <div class="mb-[20px]">
    <!-- main body -->
                    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 ">

                         {{-- Doughnut Chart --}}
                        <div class="bg-white p-4 rounded-[30px] shadow items-center">

                          <div class="flex items-center justify-between mb-6">
                            <h2 class=" font-normal text-[15px] ml-5 text-gray-900">Total Projects</h2>

                            {{-- <div>
                              <select id="month1" class="p-2 rounded-[20px] text-[12px] pr-4 border border-gray-300 bg-white text-gray-700">

                              </select>

                            </div> --}}
                          </div>

                          <div class="grid grid-cols-1 gap-8 md:grid-cols-2 ">
                            <!-- Chart -->

                            <div class="flex justify-center items-center w-[300px] h-[300px] mx-auto">
                              <canvas id="projectChart1"  class="w-full h-full"></canvas>
                            </div>

                           <span class="flex flex-col items-center justify-center">
                            <!-- Legend -->
                            <ul class="items-center space-y-3">
                                <li class="flex items-center">
                                <span class="w-10 h-5 mr-3 bg-[#FF7300] rounded-full"></span>
                                <span class="text-gray-800 font-normal text-[15px]">New Clients </span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 mr-3 bg-[#6B1E72] rounded-full"></span>
                                <span class="text-gray-800 font-normal text-[15px]">In progress </span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 mr-3 bg-[#EAB308] rounded-full"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Followups  </span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 rounded-[15px] bg-[#5687F2]  mr-3"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Closed </span>
                              </li>


                            </ul>
                           </span>

                          </div>
                        </div>

                        {{-- Doughnut chart ends --}}
        <div class="bg-white p-4 rounded-[30px] shadow items-center">

<div class="col-span-2 bg-white ">
 <div class="flex items-center justify-between w-full max-w-4xl pb-6">
  <div>
    <p class="text-lg font-semibold text-gray-700">Average Expense Per Month</p>

  </div>
    </div>
        <div class="relative h-80">
            <canvas id="revenueChart1" class="absolute w-full h-full"></canvas>
        </div>

         </div>

    </div>
    {{-- Doughnut ends --}}

</div>
</div>
            </div>
 </main>


 
<!-- #region Chart Initialization   -->

 <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the charts
        const ctx1 = document.getElementById('projectChart1').getContext('2d');
        const projectChart1 = new Chart(ctx1, {
           type: 'doughnut',
data: {
  labels: ['New Clients', 'In Progress', 'Follow-ups', 'Closed'],
  datasets: [{
    data: [5, 10, 7, 9],
    backgroundColor: ['#FF7300', '#6B1E72', '#EAB308', '#5687F2'],
    borderWidth: 1,
    borderColor: '#fff',
    hoverOffset: 8,
    borderRadius: 7,
    spacing: 4,
  }]
},
options: {
  cutout: '70%',
  plugins: {
    legend: {
      display: false,
      position: 'right',
      borderRadius: 5,
    },

  }
}
});

    });

            // Initialize the revenue chart
   document.addEventListener('DOMContentLoaded', function () {
        fetch('/accountant/Report&Analytics/incomes-data')
            .then(response => response.json())
            .then(data => {
                const ctx2 = document.getElementById('revenueChart1').getContext('2d');
                new Chart(ctx2, {
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

   
</x-sales-layout>
