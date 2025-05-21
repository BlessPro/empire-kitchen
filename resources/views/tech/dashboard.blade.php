   <x-tech-layout>
   <x-slot name="header">
<!--written on 15.05.2025-->
        @include('admin.layouts.header')
         </x-slot>
        <main class="ml-64 mt-[100px] flex-1 bg-gray-100 min-h-screen  items-center">
        <!--head begins-->

            <div class=" bg-[#F9F7F7]">
             <div class="mb-[20px]">
     <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">


    <!-- Left Column -->
    <div class="flex flex-col gap-6">
      <!-- Overview -->
       <div class="p-6 bg-white shadow rounded-2xl">
      <h2 class="mb-4 text-lg font-semibold">Overview</h2>
      <p class="mb-2 text-3xl font-bold">45 <span class="text-base font-normal text-gray-600">projects</span></p>
      <div class="flex mb-4 space-x-1">
        <div class="w-1/4 h-2 bg-orange-500 rounded"></div>
        <div class="w-1/4 h-2 bg-blue-500 rounded"></div>
        <div class="w-1/4 h-2 bg-green-500 rounded"></div>
        <div class="w-1/4 h-2 bg-purple-500 rounded"></div>
      </div>
      <div class="space-y-2 text-sm text-gray-600">
        <div class="flex justify-between"><span class="flex items-center"><span class="w-3 h-3 mr-2 bg-orange-500 rounded-full"></span>Measurement</span><span>8</span></div>
        <div class="flex justify-between"><span class="flex items-center"><span class="w-3 h-3 mr-2 bg-blue-500 rounded-full"></span>Design</span><span>11</span></div>
        <div class="flex justify-between"><span class="flex items-center"><span class="w-3 h-3 mr-2 bg-green-500 rounded-full"></span>Production</span><span>5</span></div>
        <div class="flex justify-between"><span class="flex items-center"><span class="w-3 h-3 mr-2 bg-purple-500 rounded-full"></span>Installation</span><span>9</span></div>
      </div>
    </div>

      <!-- Upcoming Measurements -->
      <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold">Upcoming Measurements</h2>
          <button class="px-3 py-1 text-sm text-purple-700 border border-purple-700 rounded-full">View All</button>
        </div>
        <div class="space-y-4">
          <div class="py-2 pl-4 border-l-4 border-orange-500 rounded bg-gray-50">
            <h3 class="font-medium">New Build</h3>
            <p class="text-sm text-gray-600">2:30 PM - 5:30 PM</p>
            <p class="text-sm text-gray-600">👤 Chris Laventher</p>
            <p class="text-sm text-gray-500">3 hours 0 minutes</p>
          </div>
          <div class="py-2 pl-4 border-l-4 border-green-500 rounded bg-gray-50">
            <h3 class="font-medium">Smith Residence</h3>
            <p class="text-sm text-gray-600">2:30 PM - 5:30 PM</p>
            <p class="text-sm text-gray-600">📍 Maple Street, West Legon</p>
            <p class="text-sm text-gray-500">3 hours 0 minutes</p>
          </div>
          <div class="py-2 pl-4 border-l-4 border-blue-600 rounded bg-gray-50">
            <h3 class="font-medium">New Build</h3>
            <p class="text-sm text-gray-600">2:30 PM - 5:30 PM</p>
            <p class="text-sm text-gray-600">👤 Chris Laventher</p>
            <p class="text-sm text-gray-500">3 hours 0 minutes</p>
          </div>
        </div>
      </div>
    </div>


    <!-- Right Column -->
    <div class="flex flex-col gap-6">
         <!-- Production -->
    <div class="p-6 bg-white shadow rounded-2xl">
      <h2 class="mb-4 text-lg font-semibold">Production</h2>
      <div class="flex items-center space-x-6">
        <div class="relative w-24 h-24">
          <!-- Placeholder circle -->
          <svg class="w-full h-full">
            <circle cx="48" cy="48" r="40" stroke="#FACC15" stroke-width="10" fill="none" />
            <circle cx="48" cy="48" r="40" stroke="#9333EA" stroke-width="10" stroke-dasharray="50, 251" fill="none" stroke-linecap="round" />
          </svg>
          <div class="absolute inset-0 flex items-center justify-center text-xl font-bold">11</div>
        </div>
        <div class="space-y-2 text-sm text-gray-700">
          <div class="flex items-center"><span class="w-3 h-3 mr-2 bg-yellow-400 rounded-full"></span>Working Order (8)</div>
          <div class="flex items-center"><span class="w-3 h-3 mr-2 bg-purple-800 rounded-full"></span>Cutting List (3)</div>
        </div>
      </div>
    </div>

         <!-- Design -->
    <div class="p-6 bg-white shadow rounded-2xl">
      <h2 class="mb-4 text-lg font-semibold">Design</h2>
      <div class="flex items-center space-x-6">
        <div class="relative w-24 h-24">
          <svg class="w-full h-full">
            <circle cx="48" cy="48" r="40" stroke="#3B82F6" stroke-width="10" fill="none" />
            <circle cx="48" cy="48" r="40" stroke="#FACC15" stroke-width="10" stroke-dasharray="80, 251" fill="none" stroke-linecap="round" />
            <circle cx="48" cy="48" r="40" stroke="#8B5CF6" stroke-width="10" stroke-dasharray="50, 251" fill="none" stroke-linecap="round" />
          </svg>
          <div class="absolute inset-0 flex items-center justify-center text-xl font-bold">25</div>
        </div>
        <div class="space-y-2 text-sm text-gray-700">
          <div class="flex items-center"><span class="w-3 h-3 mr-2 bg-blue-500 rounded-full"></span>Completed Designs (11)</div>
          <div class="flex items-center"><span class="w-3 h-3 mr-2 bg-yellow-400 rounded-full"></span>Designs Sent (10)</div>
          <div class="flex items-center"><span class="w-3 h-3 mr-2 bg-purple-500 rounded-full"></span>Pending Designs (8)</div>
        </div>
      </div>
    </div>

      <!-- Recent Activities -->
      <div class="p-6 bg-white rounded-lg shadow">
        <h2 class="mb-4 text-lg font-semibold">Recent Activities</h2>
        <div class="space-y-4">
          <div class="flex items-center space-x-4">
            <img src="https://i.pravatar.cc/40?img=1" class="w-10 h-10 rounded-full" alt="User">
            <div>
              <p class="font-medium">Chris Laventher</p>
              <p class="text-sm text-gray-600">uploaded a file in <span class="font-semibold text-purple-700">New Build</span></p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <img src="https://i.pravatar.cc/40?img=2" class="w-10 h-10 rounded-full" alt="User">
            <div>
              <p class="font-medium">Chris Laventher</p>
              <p class="text-sm text-gray-600">uploaded a file in <span class="font-semibold text-purple-700">Smiths Residence</span></p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <img src="https://i.pravatar.cc/40?img=3" class="w-10 h-10 rounded-full" alt="User">
            <div>
              <p class="font-medium">Chris Laventher</p>
              <p class="text-sm text-gray-600">uploaded a file in <span class="font-semibold text-purple-700">Johnson Remodel</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>


 {{ $statusCounts['Measurement'] }},
                    {{ $statusCounts['Design'] }},
                    {{ $statusCounts['Production'] }},
                    {{ $statusCounts['Installation'] }}


<!-- Chart.js CDN (in your head section or layout) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="p-4 mt-6 bg-white rounded shadow">
    <h2 class="mb-4 text-xl font-semibold">Project Stages Overview</h2>
    <canvas id="projectsBarChart" height="100"></canvas>
</div>
{{--
<script>
    const ctx = document.getElementById('projectsBarChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Projects by Stage',
                data: @json($chartData),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.5)', // measurement - blue
                    'rgba(34, 197, 94, 0.5)',  // design - green
                    'rgba(234, 179, 8, 0.5)',  // production - yellow
                    'rgba(239, 68, 68, 0.5)'   // installation - red
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(234, 179, 8, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
 --}}



{{--
 <canvas id="projectsBarChart" width="400" height="200"></canvas>

<script>
    // Wrap in a DOMContentLoaded listener to make sure everything is ready
    document.addEventListener('DOMContentLoaded', function () {
        const chartLabels = {!! json_encode($chartLabels) !!};        {{ $statusCounts['Pending'] }},

        const chartData = {!! json_encode($chartData) !!};

        const ctx = document.getElementById('projectsBarChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Projects by Stage',
                    data: chartData,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.5)',
                        'rgba(34, 197, 94, 0.5)',
                        'rgba(234, 179, 8, 0.5)',
                        'rgba(239, 68, 68, 0.5)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    });
</script> --}}
<canvas id="projectsStageChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('projectsStageChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Measurement', 'Design', 'Production', 'Installation'],
            datasets: [{
                label: 'Project Stages',
                data: [
                    // {{ $statusCounts['Measurement'] }},
                    // {{ $statusCounts['Design'] }},
                    // {{ $statusCounts['Production'] }},
                    // {{ $statusCounts['Installation'] }}
              
                ],
                backgroundColor: [
                    '#6B1E72',
                    '#FF7300',
                    '#9151FF',
                    '#2DD4BF'
                ],
                borderColor: '#fff',
                borderWidth: 1,
                borderRadius: 6,
                barPercentage: 0.6,
                categoryPercentage: 0.7,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

  </div>
           </div>
    </div>
</main>
</x-tech-layout>
