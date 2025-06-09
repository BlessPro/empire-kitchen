<x-accountant-layout>
 <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Designer Dashboard') }}
        </h2>
    </x-slot>

       <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="">
             <div class="mb-[20px]">

                {{--top bar with buttons--}}
    <div class="flex items-center justify-between mb-6">
                    <!-- Top Navbar -->
                    <h1 class="text-2xl font-bold">Expenses</h1>

                    <div class="flex items-center space-x-4">

                        <a href="{{ route('accountant.Expenses.Category') }}">
                      <button class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-fuchsia-800 border border-fuchsia-800 rounded-full">
                        <i data-feather="list"> </i>
                        Category
                      </button>
                        </a>



<!-- Category Modal Trigger & Alpine Wrapper -->
<div x-data="{ open: false }">

    <!-- Trigger Button -->
     <!-- Button to open modal -->
    <button @click="open = true"
        class=" flex hover:bg-blue-700flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold
         bg-fuchsia-900 border border-fuchsia-800 rounded-full">
  <i data-feather="plus"> </i>
        New Expense    </button>

    <!-- Modal -->
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-xl w-full max-w-md p-6 relative">

            <!-- Close Button -->
            <button @click="open = false"
                class="absolute top-4 right-4 text-gray-700 text-2xl font-bold hover:text-black">&times;
            </button>

            <!-- Title -->
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Add Expense Category</h2>

            <!-- Form -->
         <form method="POST" action="{{ route('expenses.store') }}">
                @csrf


      <!-- Expense Name -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-800 mb-1">Expense Name</label>
        <input name="expense_name"  type="text" class="w-full border rounded-lg px-4 py-2" required />
      </div>

      <!-- Amount -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-800 mb-1">Amount</label>
        <input name="amount" type="number" class="w-full border rounded-lg px-4 py-2" required />
      </div>

      <!-- Date -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-800 mb-1">Date</label>
        <input name="date"  type="date" class="w-full border rounded-lg px-4 py-2" required />
      </div>

      <!-- Project -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-800 mb-1">Project</label>
        <select name="project_id" class="w-full border rounded-lg px-4 py-2" required>
          <option value="">-- Select Project --</option>
          @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
          @endforeach
        </select>
      </div>

      <!-- Category -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-800 mb-1">Category</label>
        <select name="category_id" class="w-full border rounded-lg px-4 py-2" required>
          <option value="">-- Select Category --</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>

      <!-- Notes -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-800 mb-1">Notes</label>
        <textarea name="notes" rows="3" class="w-full border rounded-lg px-4 py-2"></textarea>
      </div>
      <input type="hidden" name="accountant_id" value="{{ Auth::id() }}">


      <button type="submit" class="w-full bg-purple-800 text-white py-2 rounded-xl hover:bg-purple-900">
        Save Expense
      </button>



            </form>
        </div>
    </div>
</div>




                    </div>

                    </div>

                    <!-- main body -->
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
                                <span class="text-gray-800 font-normal text-[15px]">Pending Projects </span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 rounded-[15px] bg-orange-500  mr-3"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Ongoing Projects </span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 rounded-[15px] bg-violet-500 mr-3"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Completed Projects </span>
                              </li>

                            </ul>
                           </span>

                           {{-- <span class="flex flex-col items-center justify-center">
                            <!-- Legend -->
                            <ul class="items-center space-y-3">
                              <li class="flex items-center">
                                <span class="w-10 h-5 mr-3 bg-purple-900 rounded-full"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Pending Projects {{ $statusCounts['Pending'] }}</span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 rounded-[15px] bg-orange-500  mr-3"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Ongoing Projects {{ $statusCounts['Ongoing'] }}</span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 rounded-[15px] bg-violet-500 mr-3"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Completed Projects {{ $statusCounts['Completed'] }}</span>
                              </li>

                            </ul>
                           </span> --}}

                          </div>
                        </div>

                        {{-- Doughnut chart ends --}}
        <div class="bg-white p-4 rounded-[30px] shadow items-center">

<div class="col-span-2  bg-white ">
 <div class="flex justify-between items-center pb-6 w-full max-w-4xl">
  <div>
    <p class="text-gray-700 font-semibold text-lg">Average Expense Per Month</p>

  </div>
    </div>
        <div class="relative h-80">
            <canvas id="revenueChart1" class="absolute w-full h-full"></canvas>
        </div>

         </div>

    </div>
    {{-- Doughnut ends --}}


             </div>
             <div class="bg-white rounded-[20px] pb-2 shadow">
             {{-- table ui --}}
      <table class="min-w-full text-left">
              <thead class="text-sm text-gray-600 bg-gray-100">
                <tr>
                  <th class="p-4 font-medium">
                    <input type="checkbox" id="selectAll" />
                  </th>
                  <th class="p-4 font-mediumt text-[15px]">Expense Name</th>
                  <th class="p-4 font-mediumt text-[15px]">Category</th>
                  <th class="p-4 font-mediumt text-[15px]">Project</th>
                  <th class="p-4 font-mediumt text-[15px]">Date</th>
                  <th class="p-4 font-mediumt text-[15px]">Amount</th>
                  <th class="p-4 font-mediumt text-[15px]">Actions</th>
                </tr>
              </thead>
         <!-- Add other columns as needed -->
           </tr>
         </thead>
         <tbody>

         </tbody>
     </div>


<table class="w-full border-collapse border border-gray-300 rounded-lg shadow-md">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3 border-b">Expense Name</th>
                <th class="p-3 border-b">Category</th>
                <th class="p-3 border-b">Project</th>
                <th class="p-3 border-b">Date</th>
                <th class="p-3 border-b">Amount (GHS)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $expense->expense_name }}</td>
                    <td class="p-3 border-b">{{ $expense->category->name ?? 'N/A' }}</td>
                    <td class="p-3 border-b">{{ $expense->project->name ?? 'N/A' }}</td>
                    <td class="p-3 border-b">{{ $expense->date->format('M d, Y') }}</td>
                    <td class="p-3 border-b">{{ number_format($expense->amount, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">No expenses found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>




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
      data: [10, 20, 30], // Replace with your actual data
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


// for the Revenue Chart



   </script>

            @vite(['resources/js/app.js'])

<script>
        const ctx = document.getElementById('revenueChart1').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 15000, 10000, 18000, 22000, 25000, 27000, 20000, 23000, 21000, 19000, 24000],
                    borderColor: '#6D28D9',
                    tension: 0.4,
                    fill: true,
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




    </x-accountant-layout>
