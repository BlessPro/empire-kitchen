<x-accountant-layout>
    <x-slot name="header">
        <style>[x-cloak]{display:none!important;}</style>
    
    </x-slot>

    <div class="space-y-4 p-3 sm:p-4">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Expenses</h1>

            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                <a href="{{ route('accountant.Expenses.Category') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-full text-fuchsia-800 border-fuchsia-800 hover:bg-fuchsia-50">
                    <i data-feather="list"></i>
                    Category
                </a>

                <!-- Category Modal Trigger & Alpine Wrapper -->
                <div x-data="expenseEntryModal()" class="relative">
                    <button type="button" @click="toggleMenu"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white rounded-full bg-fuchsia-900 hover:bg-fuchsia-800 focus:outline-none focus:ring-2 focus:ring-fuchsia-400">
                        <i data-feather="plus"></i>
                        New Expense
                    </button>

                    <div x-cloak x-show="menuOpen" x-transition
                        @click.away="menuOpen = false"
                        class="absolute right-0 z-40 w-48 mt-2 bg-white border border-gray-100 rounded-lg shadow-lg">
                        <button type="button"
                            class="flex items-center w-full gap-2 px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100"
                            @click="openModal('project')">
                            <i data-feather="briefcase" class="w-4 h-4 text-fuchsia-800"></i>
                            Project Expense
                        </button>
                        <button type="button"
                            class="flex items-center w-full gap-2 px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100"
                            @click="openModal('other')">
                            <i data-feather="shopping-bag" class="w-4 h-4 text-fuchsia-800"></i>
                            Other Expense
                        </button>
                    </div>

                    <div x-cloak x-show="modalOpen" x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/50">
                        <div class="relative w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg">
                            <button type="button" @click="closeModal"
                                class="absolute text-2xl font-bold text-gray-600 top-4 right-4 hover:text-black">
                                &times;
                            </button>

                            <h2 class="mb-6 text-2xl font-semibold text-gray-900" x-text="modalTitle"></h2>

                            <form id="expenseForm" method="POST" action="{{ route('expenses.store') }}"
                                class="space-y-4">
                                @csrf
                                <input type="hidden" name="expense_type" :value="expenseType">

                                <div>
                                    <label for="expense_name"
                                        class="block mb-2 text-sm font-medium text-gray-700">Expense Name</label>
                                    <input id="expense_name" name="expense_name" type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-fuchsia-900"
                                        placeholder="What are you paying for?" required>
                                </div>

                                <div x-show="expenseType === 'project'" x-transition class="space-y-2">
                                    <label for="expense_project_id"
                                        class="block text-sm font-medium text-gray-700">Project</label>
                                    <select id="expense_project_id" name="project_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-fuchsia-900"
                                        :required="expenseType === 'project'">
                                                <option value="">-- Select Project --</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label for="expense_category_id"
                                                class="block mb-2 text-sm font-medium text-gray-700">Category</label>
                                            <select id="expense_category_id" name="category_id"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-fuchsia-900"
                                                required>
                                                <option value="">-- Select Category --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-2">
                                            <div>
                                                <label for="expense_amount"
                                                    class="block mb-2 text-sm font-medium text-gray-700">Amount</label>
                                                <input id="expense_amount" name="amount" type="number" step="0.01" min="0"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-fuchsia-900"
                                                    placeholder="0.00" required>
                                            </div>
                                            <div>
                                                <label for="expense_date"
                                                    class="block mb-2 text-sm font-medium text-gray-700">Date</label>
                                                <input id="expense_date" name="date" type="date"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-fuchsia-900"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <label for="expense_notes"
                                                class="block mb-2 text-sm font-medium text-gray-700">Notes</label>
                                            <textarea id="expense_notes" name="notes" rows="4"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-fuchsia-900"
                                                placeholder="Additional context (optional)"></textarea>
                                        </div>

                                        <input type="hidden" name="accountant_id" value="{{ Auth::id() }}">

                                        <button type="submit"
                                            class="w-full py-2 text-white rounded-xl bg-fuchsia-900 hover:bg-fuchsia-800">
                                            Save Expense
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- pop up to edit expense --}}

                        <!-- Add this modal structure to your view -->
                        <div id="editExpenseModal"
                            class="fixed inset-0 z-50 flex items-center justify-center hidden px-4 bg-black/50">
                            <div class="relative w-full max-w-3xl p-6 bg-white rounded-lg shadow-lg">
                                <div class="flex flex-col justify-between gap-4 mb-6 sm:flex-row sm:items-center">
                                    <h2 class="text-xl font-semibold text-gray-900">Edit Expense</h2>
                                    <button type="button" id="closeEditModal"
                                        class="inline-flex items-center justify-center w-10 h-10 text-gray-500 transition rounded-full hover:text-gray-700 hover:bg-gray-100">
                                        <i data-feather="x" class="w-5 h-5"></i>
                                    </button>
                                </div>

                                <form id="editExpenseForm" method="POST" action="" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Expense Name</label>
                                        <input name="expense_name" id="edit_expense_name" type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required />
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Amount</label>
                                            <input name="amount" id="edit_amount" type="number"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                required />
                                        </div>
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Date</label>
                                            <input name="date" id="edit_date" type="date"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                required />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Project</label>
                                        <select name="project_id" id="edit_project_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">-- Select Project --</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Category</label>
                                        <select name="category_id" id="edit_category_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                            <option value="">-- Select Category --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Notes</label>
                                        <textarea name="notes" id="edit_notes" rows="3"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    </div>

                                    <input type="hidden" name="accountant_id" value="{{ Auth::id() }}">

                                    <div>
                                        <button type="submit"
                                            class="w-full px-4 py-2 text-sm font-semibold text-white rounded-md bg-fuchsia-900 hover:bg-fuchsia-800">
                                            Update Expense
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- --- End of Edit Expense Modal --}}

                    </div>

                </div>

        <div class="bg-white rounded-[20px] shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Expense Name</th>
                            <th class="px-4 py-3 font-semibold">Category</th>
                            <th class="px-4 py-3 font-semibold">Project</th>
                            <th class="px-4 py-3 font-semibold">Date</th>
                            <th class="px-4 py-3 font-semibold">Amount</th>
                            <th class="px-4 py-3 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($expenses as $expense)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $expense->expense_name }}</td>
                                <td class="px-4 py-3">{{ $expense->category->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $expense->project->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $expense->date->format('M d, Y') }}</td>
                                <td class="px-4 py-3">{{ number_format($expense->amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-gray-500 transition hover:text-red-500">
                                                <i data-feather="trash" class="w-5 h-5"></i>
                                            </button>
                                        </form>

                                        <button data-id="{{ $expense->id }}"
                                            class="text-gray-500 transition hover:text-fuchsia-900 editExpenseBtn">
                                            <i data-feather="edit-3" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">No expenses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function expenseEntryModal() {
            return {
                menuOpen: false,
                modalOpen: false,
                expenseType: null,
                toggleMenu() {
                    this.menuOpen = !this.menuOpen;
                },
                openModal(type) {
                    this.expenseType = type;
                    const form = document.getElementById('expenseForm');
                    if (form) {
                        form.reset();
                    }
                    this.menuOpen = false;
                    this.modalOpen = true;
                    this.$nextTick(() => {
                        const projectSelect = document.getElementById('expense_project_id');
                        if (projectSelect) {
                            projectSelect.value = '';
                        }
                    });
                },
                closeModal() {
                    this.modalOpen = false;
                    this.expenseType = null;
                },
                get modalTitle() {
                    return this.expenseType === 'project'
                        ? 'Record Project Expense'
                        : 'Record Other Expense';
                },
            };
        }
    </script>


    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select All Checkbox
            document.getElementById("selectAll")?.addEventListener("change", function() {
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
                            legend: {
                                display: false
                            }
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
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/accountant/expenses/chart-data')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('revenueChart1').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                                'Oct', 'Nov', 'Dec'
                            ],
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
                                legend: {
                                    display: false
                                }
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
                            document.getElementById('edit_expense_name').value = data
                                .expense_name;
                            document.getElementById('edit_amount').value = data.amount;
                            document.getElementById('edit_date').value = data.date.split(' ')[
                            0]; // Format date if needed
                            document.getElementById('edit_project_id').value = data.project_id;
                            document.getElementById('edit_category_id').value = data
                            .category_id;
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
