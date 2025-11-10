<x-accountant-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Payments & Invoice') }}
        </h2>
        <script src="//unpkg.com/alpinejs" defer></script>
    </x-slot>

    <main>
        <div class="pb-[24px] pr-[24px] pl-[24px]">
            <div class="mb-[20px]">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span><i data-feather="home" class="w-[20px] h-[20px] text-fuchsia-900"></i></span>
                        <span><i data-feather="chevron-right" class="w-[18px] h-[18px] text-fuchsia-900"></i></span>
                        <a href="{{ route('accountant.Payments') }}"
                            class="font-sans font-normal text-black hover:underline">Payments</a>
                        <span><i data-feather="chevron-right" class="w-[18px] h-[18px] text-fuchsia-900"></i></span>
                        <span class="font-semibold text-fuchsia-900">Pay</span>
                    </div>

                    <button id="openIncomeModal"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border rounded-full bg-fuchsia-900 border-fuchsia-800 hover:bg-fuchsia-800">
                        <i data-feather="plus"></i>
                        New Payment
                    </button>
                </div>

                <div class="shadow-md rounded-[15px] bg-white">
                    <table class="min-w-full mt-6 text-left rounded-[15px]">
                        <thead class="text-sm text-gray-600 bg-gray-100">
                            <tr>
                                <th class="p-4 font-medium text-[15px]">Client Name</th>
                                <th class="p-4 font-medium text-[15px]">Project Name</th>
                                <th class="p-4 font-medium text-[15px]">Payment Method</th>
                                <th class="p-4 font-medium text-[15px]">Amount Paid</th>
                                <th class="p-4 font-medium text-[15px]">Transaction ID</th>
                                <th class="p-4 font-medium text-[15px]">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($incomes as $income)
                                <tr class="border-t">
                                    <td class="p-4 font-normal text-[15px]">
                                        {{ optional($income->client)->title ? $income->client->title . ' ' : '' }}
                                        {{ optional($income->client)->firstname }}
                                        {{ optional($income->client)->lastname }}
                                    </td>
                                    <td class="p-4 font-normal text-[15px]">
                                        {{ optional($income->project)->name ?? '-' }}
                                    </td>
                                    <td class="p-4 font-normal text-[15px]">
                                        {{ $income->payment_method ?? '-' }}
                                    </td>
                                    <td class="p-4 font-normal text-[15px]">
                                        GHS {{ number_format($income->amount ?? 0, 2) }}
                                    </td>
                                    <td class="p-4 font-normal text-[15px]">
                                        {{ $income->transaction_id ?? '—' }}
                                    </td>
                                    <td class="p-4 font-normal text-[15px]">
                                        {{ optional($income->date)->format('d M Y') ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-sm text-gray-500">
                                        No payments recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4 mb-5 ml-5 mr-5">
                        {{-- Pagination placeholder --}}
                    </div>
                </div>
            </div>
        </div>

        <div id="incomeModal"
            class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
            <div class="relative w-[620px] rounded-lg bg-white p-6">
                <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-xl font-semibold">Record Payment</h2>
                    <button type="button" id="closeEditModal" class="flex items-center text-gray-500 hover:text-black">
                        <i data-feather="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form id="incomeForm" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="mb-2 block text-sm font-medium text-gray-700" for="projectSelect">
                            Project
                        </label>
                        <select id="projectSelect" name="project_id"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-900"
                            required>
                            <option value="">-- Select Project --</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">
                                    {{ $project->name }}
                                    @if (optional($project->client)->firstname)
                                        — {{ optional($project->client)->firstname }}
                                        {{ optional($project->client)->lastname }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700" for="projectCost">
                                Project Cost
                            </label>
                            <input id="projectCost" type="text" readonly value="GHS 0.00"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 bg-gray-100 text-gray-700 focus:outline-none">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700" for="projectBalance">
                                Balance
                            </label>
                            <input id="projectBalance" type="text" readonly value="GHS 0.00"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 bg-gray-100 text-gray-700 focus:outline-none">
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700" for="amountInput">
                                Amount Paid
                            </label>
                            <input id="amountInput" type="number" step="0.01" min="0" name="amount" required
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-900">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700" for="payment_method">
                                Payment Method
                            </label>
                            <select id="payment_method" name="payment_method" required
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-900">
                                <option value="">-- Select Payment Method --</option>
                                <option value="Cash">Cash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Mobile Money">Mobile Money</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700" for="payment_date">
                                Date of Payment
                            </label>
                            <input id="payment_date" type="date" name="date" required
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-900">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700" for="transaction_id">
                                Transaction ID
                            </label>
                            <input id="transaction_id" type="text" name="transaction_id" maxlength="255"
                                value="{{ $nextTransactionId ?? '' }}"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-900"
                                placeholder="{{ $nextTransactionId ? '' : 'Optional reference' }}">
                        </div>
                    </div>

                    <p id="totalPaidHelper" class="mb-6 text-sm text-gray-500">
                        Total received so far: GHS 0.00
                    </p>

                    <button type="submit"
                        class="w-full rounded-xl bg-fuchsia-900 py-2 text-white hover:bg-fuchsia-800">
                        Save Payment
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        const incomeModal = document.getElementById('incomeModal');
        const openIncomeModal = document.getElementById('openIncomeModal');
        const closeIncomeModal = document.getElementById('closeEditModal');
        const projectSelect = document.getElementById('projectSelect');
        const projectCostInput = document.getElementById('projectCost');
        const projectBalanceInput = document.getElementById('projectBalance');
        const totalPaidHelper = document.getElementById('totalPaidHelper');
        const incomeForm = document.getElementById('incomeForm');
        const transactionInput = document.getElementById('transaction_id');

        const financialSummaryTemplate = @js(route('accountant.projects.financial-summary', ['project' => '__PROJECT__']));
        const initialTransactionId = @js($nextTransactionId);

        const formatCurrency = (value) => {
            const amount = Number(value || 0);
            return `GHS ${amount.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;
        };

        const toggleModal = (show = false) => {
            if (show) {
                incomeModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                return;
            }
            incomeModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };

        const resetTransactionId = () => {
            if (!transactionInput) {
                return;
            }

            if (initialTransactionId) {
                transactionInput.value = initialTransactionId;
            } else {
                transactionInput.value = '';
            }
        };

        openIncomeModal?.addEventListener('click', () => {
            resetTransactionId();
            toggleModal(true);
        });
        closeIncomeModal?.addEventListener('click', () => toggleModal(false));
        incomeModal?.addEventListener('click', (event) => {
            if (event.target === incomeModal) {
                toggleModal(false);
            }
        });

        projectSelect?.addEventListener('change', async (event) => {
            const projectId = event.target.value;

            if (!projectId) {
                projectCostInput.value = 'GHS 0.00';
                projectBalanceInput.value = 'GHS 0.00';
                totalPaidHelper.textContent = 'Total received so far: GHS 0.00';
                return;
            }

            const endpoint = financialSummaryTemplate.replace('__PROJECT__', projectId);

            try {
                const response = await fetch(endpoint);
                if (!response.ok) {
                    throw new Error('Unable to fetch project financials');
                }

                const data = await response.json();
                projectCostInput.value = formatCurrency(data.project_cost);
                projectBalanceInput.value = formatCurrency(data.balance);
                totalPaidHelper.textContent = `Total received so far: ${formatCurrency(data.total_paid)}`;
            } catch (error) {
                console.error(error);
                projectCostInput.value = 'GHS 0.00';
                projectBalanceInput.value = 'GHS 0.00';
                totalPaidHelper.textContent = 'Total received so far: GHS 0.00';
                alert('Could not load project financials. Please try again.');
            }
        });

        incomeForm?.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(incomeForm);

            try {
                const response = await fetch('{{ route('income.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (response.status === 422) {
                    const data = await response.json();
                    const firstError = Object.values(data.errors || {}).flat()[0] ?? 'Validation failed.';
                    alert(firstError);
                    return;
                }

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Payment save failed', response.status, errorText);
                    throw new Error(`Request failed with status ${response.status}`);
                }

                alert('Payment recorded successfully!');
                window.location.reload();
            } catch (error) {
                console.error(error);
                alert('Unexpected error saving payment. Please try again.');
            }
        });
    </script>
</x-accountant-layout>
