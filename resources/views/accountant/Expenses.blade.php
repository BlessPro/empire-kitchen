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
                      <button class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-full text-fuchsia-800 border-fuchsia-800">
                        <i data-feather="list"> </i>
                        Category
                      </button>
                        </a>



<!-- Category Modal Trigger & Alpine Wrapper -->
<div x-data="{ open: false }">

    <!-- Trigger Button -->
     <!-- Button to open modal -->
    <button @click="open = true"
        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border rounded-full hover:bg-blue-700flex bg-fuchsia-900 border-fuchsia-800">
  <i data-feather="plus"> </i>
        New Expense    </button>

    <!-- Modal -->
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"

    >
        <div class="bg-white rounded-lg p-6 w-[600px] items-center justify-center relative">

            <!-- Close Button -->
            <button @click="open = false"
                class="absolute text-2xl font-bold text-gray-700 top-4 right-4 hover:text-black">&times;
            </button>

            <!-- Title -->
            <h2 class="mb-6 text-2xl font-semibold text-gray-900">Add Expense Category</h2>

            <!-- Form -->
         <form method="POST" action="{{ route('expenses.store') }}">
                @csrf


      <!-- Expense Name -->
      <div class="mb-4">
        <label class="block mb-4 text-sm font-medium text-gray-700">Expense Name</label>
        <input name="expense_name"  type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
      </div>

      <div class="flex flex-col gap-4 mb-4 sm:flex-row">
      <!-- Amount -->
      <div class="mb-4">
        <label class="block mb-4 text-sm font-medium text-gray-700">Amount</label>
        <input name="amount" type="number" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
      </div>

      <!-- Date -->
      <div class="mb-4">
        <label class="block mb-4 text-sm font-medium text-gray-700">Date</label>
        <input name="date"  type="date" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
      </div>
      </div>
      <div class="flex flex-col gap-4 mb-4 sm:flex-row">
      <!-- Project -->
      <div class="mb-4">
        <label class="block mb-4 text-sm font-medium text-gray-700">Project</label>
        <select name="project_id" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="">-- Select Project --</option>
          @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
          @endforeach
        </select>
      </div>

      <!-- Category -->
      <div class="mb-4">
        <label class="block mb-4 text-sm font-medium text-gray-700">Category</label>
        <select name="category_id" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="">-- Select Category --</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>
      </div>
      <!-- Notes -->
      <div class="mb-6">
        <label class="block mb-4 text-sm font-medium text-gray-700">Notes</label>
        <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      </div>
      <input type="hidden" name="accountant_id" value="{{ Auth::id() }}">


      <button type="submit" class="w-full py-2 text-white bg-fuchsia-900 rounded-xl hover:bg-fuchsia-800">
        Save Expense
      </button>



            </form>
        </div>
    </div>
</div>

 {{-- pop up to edit expense --}}

<!-- Add this modal structure to your view -->
<div id="editExpenseModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class=" bg-white rounded-lg p-6 w-[600px] items-center justify-center relative">
        <div class="mt-3 ">
 <div class="flex flex-col justify-between gap-4 mb-4 sm:flex-row">
        <h2 class="mb-4 text-xl font-semibold">Edit  Expense</h2>
        <button type="button" id="closeEditModal" class="px-4 py-2 text-black "> <i data-feather="x"
    class="mr-3 feather-icon group"></i></button>
        </div>    
                <form id="editExpenseForm" method="POST" action="">
                @csrf
                @method('PUT') <!-- Add this for update requests -->

                <!-- Expense Name -->
                <div class="">
                    <label class="block mb-4 text-sm font-medium text-gray-700">Expense Name</label>
                    <input name="expense_name" id="edit_expense_name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                </div>

                <div class="flex flex-col gap-4 mb-4 sm:flex-row">
                    <!-- Amount -->
                    <div class="mb-4">
                        <label class="block mb-4 text-sm font-medium text-gray-700">Amount</label>
                        <input name="amount" id="edit_amount" type="number" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    </div>

                    <!-- Date -->
                    <div class="mb-4">
                        <label class="block mb-4 text-sm font-medium text-gray-700">Date</label>
                        <input name="date" id="edit_date" type="date" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    </div>
                </div>

                <div class="flex flex-col gap-4 mb-4 sm:flex-row">
                    <!-- Project -->
                    <div class="mb-4">
                        <label class="block mb-4 text-sm font-medium text-gray-700">Project</label>
                        <select name="project_id" id="edit_project_id" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Select Project --</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="block mb-4 text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" id="edit_category_id" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label class="block mb-4 text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="edit_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <input type="hidden" name="accountant_id" value="{{ Auth::id() }}">

                <div class="flex justify-end gap-3 mt-4">

                        <button type="submit" class="w-full py-2 text-white bg-fuchsia-900 rounded-xl hover:bg-fuchsia-800">
                 Update Expense
                 </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{----- End of Edit Expense Modal --}}

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
                                <span class="text-gray-800 font-normal text-[15px]">Materials </span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 rounded-[15px] bg-orange-500  mr-3"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Logistics </span>
                              </li>
                              <li class="flex items-center">
                                <span class="w-10 h-5 rounded-[15px] bg-violet-500 mr-3"></span>
                                <span class="text-gray-800 font-normal text-[15px]">Labor </span>
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

             <div class="bg-white rounded-[20px] pb-2 shadow">
             {{-- table ui --}}
      <table class="min-w-full text-left">
              <thead class="pl-8 text-sm text-gray-600 bg-gray-100">
                <tr>

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
         <tbody  class="pl-8 text-sm text-gray-600">
            {{-- Loop through expenses --}}
    @forelse($expenses as $expense)
                <tr class=" hover:bg-gray-50">

                    <td class="p-3 border-t">{{ $expense->expense_name }}</td>
                    <td class="p-3 border-t">{{ $expense->category->name ?? 'N/A' }}</td>
                    <td class="p-3 border-t">{{ $expense->project->name ?? 'N/A' }}</td>
                    <td class="p-3 border-t">{{ $expense->date->format('M d, Y') }}</td>
                    <td class="p-3 border-t">{{ number_format($expense->amount, 2) }}</td>
                  <td class="flex p-3 space-x-2 border-t">
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-gray-500 hover:text-red-500">
                            <i data-feather="trash" class="mr-3 w-[20px] h-[20px]"></i>
                        </button>
                        </form>

                        {{-- data-id="{{ $user->id }}" --}}
                        <button data-id="{{ $expense->id }}" id="editExpenseBtn"  class="text-gray-500 hover:text-red-500 btn btn-primary editExpenseBtn">
                            <i data-feather="edit-3" class="mr-3 w-[20px] h-[20px]"></i>
                        </button>


                    {{-- <button class="btn btn-primary editUserBtn" data-id="{{ $user->id }}">Edit</button> --}}
                  </td>
                </tr>

            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">No expenses found.</td>
                </tr>
            @endforelse
         </tbody>
     </div>

            </div>
        </div>
        </main>

        

        <script>
            // document.getElementById("selectAll").addEventListener("change", function () {
            //    const isChecked = this.checked;
            //    const checkboxes = document.querySelectorAll(".child-checkbox");
            //    checkboxes.forEach(cb => cb.checked = isChecked);
            //    });
            //    // When 'selectAll' is unchecked

            //    const allCheckboxes = document.querySelectorAll(".child-checkbox");
            //    allCheckboxes.forEach(cb => {
            //    cb.addEventListener("change", () => {
            //    const allChecked = Array.from(allCheckboxes).every(c => c.checked);
            //    document.getElementById("selectAll").checked = allChecked;
            //    });
            //    });


            // Initializing the doughnut chart for the Project status
            // const ctx1 = document.getElementById('clientsChart1').getContext('2d');
            // new Chart(ctx1, {
            //   type: 'doughnut',
            //   data: {
            //     labels: ['Pending', 'Ongoing', 'Completed'],
            //     datasets: [{
            //       data: [10, 20, 30], // Replace with your actual data
            //       backgroundColor: ['#6B1E72', '#FF7300', '#9151FF'],
            //       borderWidth: 1,
            //       borderColor: '#fff',
            //       hoverOffset: 8,
            //       borderRadius: 7,
            //       spacing: 4,
            //     }]
            //   },
            //   options: {
            //     cutout: '70%',
            //     plugins: {
            //       legend: {
            //         display: false,
            //         position: 'right',
            //         borderRadius: 5,
            //       },
            //     }
            //   }
            // });


//adding month filter to the Project status - completed, pending and closed section
// Get the select element and month names

// const monthSelect = document.getElementById('month1');
// const monthNames = [
// "January", "February", "March", "April", "May", "June",
// "July", "August", "September", "October", "November", "December"
// ];

// const currentMonthIndex = new Date().getMonth(); // 0 = Jan, 11 = Dec

// // Add all months as options
// monthNames.forEach((name, index) => {
// const option = document.createElement("option");
// option.value = String(index + 1).padStart(2, '0'); // Format as 01, 02, ...
// option.textContent = name;

// // Automatically select current month
// if (index === currentMonthIndex) {
// option.selected = true;
// }

// monthSelect.appendChild(option);
// });


       //initializing the doughnut chart for the  Finance summary section
//        const ctx2 = document.getElementById('clientsChart2').getContext('2d');
// new Chart(ctx2, {
// type: 'doughnut',
// data: {
//   labels: ['Incoming Payments', 'Outgoing Payments'],
//   datasets: [{
//     data: [5, 25],
//     backgroundColor: ['#EAB308','#9151FF'],
//     borderWidth: 1,
//       borderColor: '#fff',
//       hoverOffset: 8,
//       borderRadius: 7,
//       spacing: 4,
//   }]
// },
// options: {
//   cutout: '70%',
//   plugins: {
//     legend: {
//       display: false,
//       position: 'right',
//       borderRadius: 5,
//     },

//   }
// }
// });
//adding month filter to the Finance summary section
// Get the select element and month names

// const monthSelect2 = document.getElementById('month2');
// const monthNames2 = [
// "January", "February", "March", "April", "May", "June",
// "July", "August", "September", "October", "November", "December"
// ];

// const currentMonthIndex2 = new Date().getMonth(); // 0 = Jan, 11 = Dec

// Add all months as options
// monthNames2.forEach((name, index) => {
// const option = document.createElement("option");
// option.value = String(index + 1).padStart(2, '0'); // Format as 01, 02, ...
// option.textContent = name;

// // Automatically select current month
// if (index === currentMonthIndex2) {
// option.selected = true;
// }

// monthSelect2.appendChild(option);
// });


// for the Revenue Chart

</script>

            @vite(['resources/js/app.js'])
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Select All Checkbox
    document.getElementById("selectAll")?.addEventListener("change", function () {
        const isChecked = this.checked;
        const checkboxes = document.querySelectorAll(".child-checkbox");
        checkboxes.forEach(cb => cb.checked = isChecked);
    });

    const allCheckboxes = document.querySelectorAll(".child-checkbox");
    allCheckboxes.forEach(cb => {
        cb.addEventListener("change", () => {
            const allChecked = Array.from(allCheckboxes).every(c => c.checked);
            document.getElementById("selectAll").checked = allChecked;
        });
    });

    // Chart
    const ctx1 = document.getElementById('clientsChart1');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Ongoing', 'Completed'],
                datasets: [{
                    data: [10, 20, 30],
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
                    legend: { display: false }
                }
            }
        });
    }

    // Month dropdown
    const monthSelect = document.getElementById('month1');
    if (monthSelect) {
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        const currentMonthIndex = new Date().getMonth();
        monthNames.forEach((name, index) => {
            const option = document.createElement("option");
            option.value = String(index + 1).padStart(2, '0');
            option.textContent = name;
            if (index === currentMonthIndex) option.selected = true;
            monthSelect.appendChild(option);
        });
    }
});
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/accountant/expenses/chart-data')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('revenueChart1').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
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





<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get modal element
    const modal = document.getElementById('editExpenseModal');

    // Get all edit buttons
    const editButtons = document.querySelectorAll('.editExpenseBtn');

    // Get close button
    const closeButton = document.getElementById('closeEditModal');

    // Form element
    const editForm = document.getElementById('editExpenseForm');

    // Add click event to all edit buttons
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const expenseId = this.getAttribute('data-id');

            // Fetch expense data via AJAX
            fetch(`/expenses/${expenseId}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Populate form fields
                    document.getElementById('edit_expense_name').value = data.expense_name;
                    document.getElementById('edit_amount').value = data.amount;
                    document.getElementById('edit_date').value = data.date.split(' ')[0]; // Format date if needed
                    document.getElementById('edit_project_id').value = data.project_id;
                    document.getElementById('edit_category_id').value = data.category_id;
                    document.getElementById('edit_notes').value = data.notes || '';

                    // Update form action
                    editForm.action = `/expenses/${expenseId}`;

                    // Show modal
                    modal.classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Close modal when clicking cancel
    closeButton.addEventListener('click', function() {
        modal.classList.add('hidden');
    });

    // Close modal when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
</script>

    </x-accountant-layout>
