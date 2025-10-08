<x-accountant-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Designer Dashboard') }}
        </h2>
        <script src="//unpkg.com/alpinejs" defer></script>

    </x-slot>

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

        <div class="">
            <div class="mb-[20px]">

                {{-- navigation bar --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <span><i data-feather="home" class="w-[20px] h-[20px] text-fuchsia-900 ml-[3px]"></i></span>
                        <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
                        <a href="{{ route('accountant.Payments') }}">
                            <h3 class="font-sans font-normal text-black cursor-pointer hover:underline">Payments</h3>
                        </a>



                        <span><i data-feather="chevron-right"
                                class="w-[20px] h-[18px] text-fuchsia-900 ml-[3px]"></i></span>
                        <h3 class="font-semibold text-fuchsia-900">Pay</h3>

                    </div>
                    <button id="openIncomeModal"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border rounded-full hover:bg-blue-700flex bg-fuchsia-900 border-fuchsia-800">
                        <i data-feather="plus"> </i>
                        New Payment </button>
                </div>
                <!-- Category Modal Trigger & Alpine Wrapper -->

                <div class="shadow-md rounded-[15px]">

                    <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
                        <thead class="text-sm text-gray-600 bg-gray-100">
                            <tr>

                                <th class="p-4 font-mediumt text-[15px]">Client Name</th>
                                <th class="p-4 font-mediumt text-[15px]">Project Name</th>
                                <th class="p-4 font-mediumt text-[15px]">Category</th>
                                <th class="p-4 font-mediumt text-[15px]">Payment Method</th>
                                <th class="p-4 font-mediumt text-[15px]">Project stage</th>
                                <th class="p-4 font-mediumt text-[15px]">Amount</th>

                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($incomes as $income)
                                <tr class="border-t">
                                    <td class="p-4 font-normal text-[15px]">
                                        {{ $income->client->title . ' ' . $income->client->firstname . ' ' . $income->client->lastname ?? '-' }}
                                    </td>
                                    <td class="p-4 font-normal text-[15px]">{{ $income->project->name ?? '-' }}</td>
                                    <td class="p-4 font-normal text-[15px]">{{ $income->category->name ?? '-' }}</td>
                                    <td class="p-4 font-normal text-[15px]">{{ $income->payment_method }}</td>
                                    <td class="p-4 font-normal text-[15px]">{{ $income->project_stage }}</td>
                                    <td class="p-4 font-normal text-[15px]">₵{{ number_format($income->amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="mt-4 mb-5 ml-5 mr-5">
                        {{-- {{ $projects->links('pagination::tailwind') }} --}}
                    </div>

                </div>





                <!-- Income Entry Modal -->
                <div id="incomeModal"
                    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 ">
                    <div class="bg-white rounded-lg p-6 w-[600px] items-center justify-center relative">
                        <div class="flex flex-col justify-between gap-4 mb-4 sm:flex-row">
                            <h2 class="mb-4 text-xl font-semibold">Add New Income</h2>
                            <button type="button" id="closeEditModal" class="px-4 py-2 text-black "> <i
                                    data-feather="x" class="mr-3 feather-icon group"></i></button>
                        </div>
                        <form id="incomeForm" method="POST">
                            @csrf

                            <div class="flex flex-col gap-4 mb-4 sm:flex-row">
                                <div class="mb-4">
                                    <label class="block mb-4 text-sm font-medium text-gray-700">Client</label>
                                    <select id="clientSelect" name="client_id"
                                        class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">-- Select Client --</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->title . ' ' . $client->firstname . ' ' . $client->lastname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block mb-4 text-sm font-medium text-gray-700">Project</label>
                                    <select id="projectSelect" name="project_id"
                                        class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">-- Select Project --</option>
                                    </select>
                                </div>
                            </div>


                            <div class="flex flex-col gap-4 mb-4 sm:flex-row">
                                <div class="mb-4">
                                    <label class="block mb-4 text-sm font-medium text-gray-700">Category</label>
                                    <select name="category_id"
                                        class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block mb-4 text-sm font-medium text-gray-700">Project Stage</label>
                                    <select name="project_stage"
                                        class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">-- What are you paying for --</option>
                                        <option value="Measurement">Measurement</option>
                                        <option value="Design">Design</option>
                                        <option value="Production">Production</option>
                                        <option value="Installation">Installation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-4 text-sm font-medium text-gray-700" for="payment_method">Payment
                                    Method</label>
                                <select name="payment_method"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md form-input focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Select Payment Method --</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Mobile Money">Mobile Money</option>
                                </select>
                            </div>

                            <div class="flex flex-col gap-4 mb-4 sm:flex-row">
                                <div class="mb-4">

                                    <label class="block mb-4 text-sm font-medium text-gray-700">Amount</label>
                                    <input type="number" step="0.01" name="amount"
                                        class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="mb-4">
                                    <label class="block mb-4 text-sm font-medium text-gray-700">Date</label>
                                    <input type="date" name="date"
                                        class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>


                            <button type="submit"
                                class="w-full py-2 text-white bg-fuchsia-900 rounded-xl hover:bg-fuchsia-800">Save
                                Income</button>
                        </form>
                    </div>
                </div>



            </div>
        </div>
    </main>

    <script>
        document.getElementById('closeEditModal').addEventListener('click', function() {
            document.getElementById('incomeModal').classList.add('hidden');
        });
        document.getElementById('clientSelect').addEventListener('change', function() {
            const clientId = this.value;
            fetch(`/projects/by-client/${clientId}`)
                .then(response => response.json())
                .then(projects => {
                    const projectSelect = document.getElementById('projectSelect');
                    projectSelect.innerHTML = '<option value="">-- Select Project --</option>';
                    projects.forEach(project => {
                        projectSelect.innerHTML +=
                            `<option value="${project.id}">${project.name}</option>`;
                    });
                });
        });
        //ends


        document.getElementById('incomeForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('income.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                // .then(res => res.json())
                .then(data => {
                    alert("Income saved!");
                    location.reload(); // or close modal and refresh data table
                })
                .catch(async err => {
                    const errorData = await err.response.json();
                    alert('Validation failed: ' + JSON.stringify(errorData.errors));
                    // .catch(err => console.error(err));

                });


        });
        document.getElementById('openIncomeModal').addEventListener('click', function() {
            document.getElementById('incomeModal').classList.remove('hidden');
        });
    </script>
</x-accountant-layout>
