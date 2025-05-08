<x-layouts.app>
    <x-slot name="header">
<!--written on 07.05.2025 @ 9:45-->
    <!-- Main Content -->

    @include('admin.layouts.header')
    @php
    $statusClasses = [
        'in progress' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
        'completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
        'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
    ];


    $defaultClass = 'bg-gray-100 text-gray-800';
@endphp
    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">
                <div class="flex items-center justify-between mb-6">

                    <!-- Top Navbar -->
                    <h1 class="text-2xl font-bold">Reports and Analytics</h1>

                    <button class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-purple-800 bg-purple-100 border border-purple-800 rounded-full">
                        Export
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm8 8v4m0-4l-2 2m2-2l2 2" />
                        </svg>
                      </button>

                    </div>
                    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 ">

                         {{-- Doughnut Chart --}}
                        <div class="bg-white p-4 rounded-[30px] shadow items-center">

                          <div class="flex items-center justify-between mb-6">
                            <h2 class=" font-normal text-[15px] ml-5 text-gray-900">Total Projects</h2>

                            <div>
                              <select id="month1" class="p-2 rounded-[20px] text-[12px] pr-4 border border-gray-300 bg-white text-gray-700">

                              </select>

                            </div>
                          </div>


                          <div class="grid grid-cols-1 gap-8 md:grid-cols-2 ">
                            <!-- Chart -->

                            <div class="flex justify-center items-center w-[210px] h-[210px] mx-auto">
                              <canvas id="clientsChart1"  class="w-full h-full"></canvas>
                            </div>
                           <span class="flex flex-col items-center justify-center">
                            <!-- Legend -->
                            <ul class="items-center space-y-3">
                              <li class="flex items-center">
                                <span class="w-10 h-5 mr-3 bg-purple-900 rounded-full"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Pending Projects {{ $statusCounts['Pending'] }}</span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 rounded-[15px] bg-orange-500  mr-3"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Pending Projects {{ $statusCounts['Ongoing'] }}</span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 rounded-[15px] bg-violet-500 mr-3"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Completed Projects {{ $statusCounts['Completed'] }}</span>
                              </li>

                            </ul>
                           </span>

                          </div>
                        </div>

                        {{-- Doughnut chart ends --}}
                                   {{-- Doughnut Chart --}}
                                   <div class="bg-white p-4 rounded-[30px] shadow items-center">

                                    <div class="flex items-center justify-between mb-6">
                                      <h2 class=" font-normal text-[15px] ml-5 text-gray-900">Finance Summary</h2>

                                      <div>
                                        <select id="month2" class="p-2 rounded-[20px] text-[12px] pr-4 border border-gray-300 bg-white text-gray-700">

                                        </select>

                                      </div>
                                    </div>


                                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 ">
                                      <!-- Chart -->

                                      <div class="flex justify-center items-center w-[210px] h-[210px] mx-auto">
                                        <canvas id="clientsChart2"  class="w-full h-full"></canvas>
                                      </div>
                                     <span class="flex flex-col items-center justify-center">
                                      <!-- Legend -->
                                      <ul class="items-center space-y-3">
                                        <li class="flex items-center">
                                          <span class="text-gray-800 font-semibold text-[30px]">$156,790</span>
                                         <i data-feather="trending-up" class="text-green-600 mr-[2px] ml-[10px]"></i> <h5 class="text-green-600 mr-[2px] ml-[10px]"> 2.6% </h5>

                                        </li>
                                        <li class="flex items-center">
                                          <span class="w-10 h-5 rounded-[15px] bg-violet-500  mr-3"></span>
                                          <span class="text-gray-800 font-normal text-[15px]"> Incoming Payments ($170,690)</span>
                                        </li>
                                        <li class="flex items-center">
                                          <span class="w-10 h-5 rounded-[15px] bg-[#EAB308] mr-3"></span>
                                          <span class="text-gray-800 font-normal text-[15px]">Outgoing Payments ($73,807)</span>
                                        </li>

                                      </ul>
                                     </span>

                                    </div>
                                  </div>
                                    {{-- Doughnut ends --}}


                      </div>

                      <div class="bg-white rounded-[20px] pb-2 shadow">

                        <div class="flex items-center justify-between pt-4 pb-5 pl-6 pr-6">
                          <p class="text-gray-600 text-[15px] font-Semibold">Projects </p>
                          <div class="flex gap-3">
                            <button class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-full">
                              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6h4M6 10h12M6 14h12M10 18h4" />
                              </svg>
                              Filter
                            </button>

                          </div>
                        </div>

                                    {{-- table ui --}}

                                   <table class="min-w-full text-left">
                                           <thead class="text-sm text-gray-600 bg-gray-100">
                                             <tr>
                                               <th class="p-4 font-medium">
                                                 <input type="checkbox" id="selectAll" />
                                               </th>
                                               <th class="p-4 font-mediumt text-[15px]">Project Name</th>
                                               <th class="p-4 font-mediumt text-[15px]">Status</th>
                                               <th class="p-4 font-mediumt text-[15px]">Client Name</th>
                                               <th class="p-4 font-mediumt text-[15px]">Technical Supervisor</th>
                                               <th class="p-4 font-mediumt text-[15px]">Duration</th>
                                               <th class="p-4 font-mediumt text-[15px]">Cost</th>
                                             </tr>
                                           </thead>
                                      <!-- Add other columns as needed -->
                                    </tr>
                                  </thead>
                                  <tbody>
                                   @foreach($projects as $project)
                                      <tr class="border-t hover:bg-gray-50">
                                          <td class="p-4"><input type="checkbox" class="child-checkbox" /></td>
                                          <td class="p-4 font-normal text-[15px]">{{ $project->name }}</td>
                                          <td class="p-4">
                                              <span class="px-3 py-1 text-sm {{ $statusClasses[$project->status] ?? $defaultClass }}">{{ $project->status }}</span>
                                          </td>
                                          <td  class="px-3 py-1 text-sm  ${item.statusStyle}">{{ $project->client->firstname . ' ' . $project->client->lastname}}</td>
                                          <td class="p-4 text-left"> <div class="flex items-center gap-3">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-8 h-8 rounded-full">
                                            <span class="text-sm text-gray-700"> <p class="text-sm">{{ $project->techSupervisor?->name ?? 'Not Assigned' }}</p>
                                            </span>
                                        </div></td>

                                          <td id="itemstatus" class="p-4 font-normal text-[15px]">{{ $project->start_date->diffForHumans() }}</td>
                                          <td class="p-4 font-normal text-[15px]">{{ $project->cost }}</td>
                                      </tr>
                                  @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 ml-5 mr-5">
                                   {{ $projects->links('pagination::tailwind') }}
                               </div>

                      </div>

            </div>
        </div>
        </main>
        <script>
            document.getElementById("selectAll").addEventListener("change", function () {
               const isChecked = this.checked;
               const checkboxes = document.querySelectorAll(".child-checkbox");
               checkboxes.forEach(cb => cb.checked = isChecked);
               });
               // When 'selectAll' is unchecked

               const allCheckboxes = document.querySelectorAll(".child-checkbox");
               allCheckboxes.forEach(cb => {
               cb.addEventListener("change", () => {
               const allChecked = Array.from(allCheckboxes).every(c => c.checked);
               document.getElementById("selectAll").checked = allChecked;
               });
               });

               
// Initializing the doughnut chart for the Project status
const ctx1 = document.getElementById('clientsChart1').getContext('2d');
new Chart(ctx1, {
  type: 'doughnut',
  data: {
    labels: ['Pending', 'Ongoing', 'Completed'],
    datasets: [{
      data: [
        {{ $statusCounts['Pending'] }},
        {{ $statusCounts['Ongoing'] }},
        {{ $statusCounts['Completed'] }}
      ],
      backgroundColor: ['#6B1E72', '#FF7300', '#9151FF'],
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


//adding month filter to the Project status - completed, pending and closed section
// Get the select element and month names

const monthSelect = document.getElementById('month1');
const monthNames = [
"January", "February", "March", "April", "May", "June",
"July", "August", "September", "October", "November", "December"
];

const currentMonthIndex = new Date().getMonth(); // 0 = Jan, 11 = Dec

// Add all months as options
monthNames.forEach((name, index) => {
const option = document.createElement("option");
option.value = String(index + 1).padStart(2, '0'); // Format as 01, 02, ...
option.textContent = name;

// Automatically select current month
if (index === currentMonthIndex) {
option.selected = true;
}

monthSelect.appendChild(option);
});


       //initializing the doughnut chart for the  Finance summary section
       const ctx2 = document.getElementById('clientsChart2').getContext('2d');
new Chart(ctx2, {
type: 'doughnut',
data: {
  labels: ['Incoming Payments', 'Outgoing Payments'],   
  datasets: [{
    data: [5, 25],
    backgroundColor: ['#EAB308','#9151FF'],
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
//adding month filter to the Finance summary section
// Get the select element and month names

const monthSelect2 = document.getElementById('month2');
const monthNames2 = [
"January", "February", "March", "April", "May", "June",
"July", "August", "September", "October", "November", "December"
];

const currentMonthIndex2 = new Date().getMonth(); // 0 = Jan, 11 = Dec

// Add all months as options
monthNames2.forEach((name, index) => {
const option = document.createElement("option");
option.value = String(index + 1).padStart(2, '0'); // Format as 01, 02, ...
option.textContent = name;

// Automatically select current month
if (index === currentMonthIndex2) {
option.selected = true;
}

monthSelect2.appendChild(option);
});
   </script>

            @vite(['resources/js/app.js'])

    </x-slot>
</x-layouts.app>
