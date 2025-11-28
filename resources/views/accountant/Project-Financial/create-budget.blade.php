<x-accountant-layout>
    <x-slot name="header">
        @include('admin.layouts.header')
    </x-slot>

    <main class="ml-[280px] mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Create Budget</h1>
                    <p class="mt-1 text-sm text-gray-600">Name the budget, set its date range, and allocate amounts.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="px-3 py-2 mb-4 text-sm text-green-700 rounded bg-green-50">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="px-3 py-2 mb-4 text-sm text-red-700 rounded bg-red-50">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $extrasValues = collect(old('extras', []))
                    ->map(function ($row) {
                        return [
                            'name' => $row['name'] ?? '',
                            'amount' => $row['amount'] ?? '',
                            'note' => $row['note'] ?? '',
                        ];
                    })
                    ->values();
            @endphp

            <form method="POST" action="{{ route('accountant.budgets.store') }}" x-data="createBudget()">
                @csrf

                <div class="grid grid-cols-1 gap-4 p-4 bg-white shadow md:grid-cols-3 rounded-2xl">
                    <div class="md:col-span-3">
                        <label class="block mb-1 text-sm font-medium">Budget Name</label>
                        <input type="text" name="name" x-model="name" value="{{ old('name') }}"
                               class="w-full px-3 py-2 border rounded-lg" placeholder="e.g., Q1 2026 Operating Budget">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">From Date</label>
                        <input type="date" name="start_date" x-model="startDate" value="{{ old('start_date') }}"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium">To Date</label>
                        <input type="date" name="end_date" x-model="endDate" value="{{ old('end_date') }}"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Main Budget ({{ $currency }})</label>
                        <input type="number" step="0.01" min="0" name="main_amount"
                               x-model="mainAmount" value="{{ old('main_amount') }}"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Currency</label>
                        <input type="text" name="currency" x-model="currency" value="{{ old('currency', $currency) }}"
                               class="w-full px-3 py-2 border rounded-lg uppercase">
                    </div>

                    <div class="text-sm text-gray-700">
                        <div class="mt-7">
                            <div class="flex justify-between">
                                <span>Allocated (extras):</span>
                                <span x-text="fmt(totalAllocated())"></span>
                            </div>
                            <div class="flex justify-between font-semibold">
                                <span>Remaining:</span>
                                <span :class="remaining() < 0 ? 'text-red-600' : ''" x-text="fmt(remaining())"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 mt-6 bg-white shadow rounded-2xl">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-semibold">Budget Items</h3>
                        <button type="button" @click="addExtra()"
                                class="px-3 py-1 text-sm bg-gray-100 rounded-lg hover:bg-gray-200">+ Add Item</button>
                    </div>

                    <template x-for="(extra, index) in extras" :key="index">
                        <div class="grid grid-cols-12 gap-2 mb-2">
                            <input type="text" class="col-span-7 px-3 py-2 border rounded-lg"
                                   :name="`extras[${index}][name]`"
                                   x-model="extra.name" placeholder="Item name" />
                            <input type="number" step="0.01" min="0"
                                   class="col-span-4 px-3 py-2 border rounded-lg"
                                   :name="`extras[${index}][amount]`"
                                   x-model="extra.amount" placeholder="Amount" />
                            <button type="button" class="col-span-1 text-red-600"
                                    @click="removeExtra(index)">Remove</button>
                            <textarea class="col-span-12 px-3 py-2 border rounded-lg"
                                      :name="`extras[${index}][note]`"
                                      x-model="extra.note"
                                      placeholder="Optional note (details, assumptions)"></textarea>
                        </div>
                    </template>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('accountant.Project-Financials', ['tab' => 'project-budget']) }}"
                       class="px-4 py-2 border rounded-lg">Cancel</a>
                    <button class="px-5 py-2 text-white rounded-lg bg-fuchsia-900 hover:bg-purple-800"
                            @click="return submitAllowed()">
                        Create Budget
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function createBudget() {
            return {
                name: @json(old('name')),
                startDate: @json(old('start_date')),
                endDate: @json(old('end_date')),
                mainAmount: @json(old('main_amount')),
                currency: @json(old('currency', $currency)),
                extras: @json($extrasValues),
                fmt(value) {
                    const prefix = (this.currency ? this.currency + ' ' : '');
                    return prefix + Number(value || 0).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });
                },
                addExtra() {
                    this.extras.push({ name: '', amount: '', note: '' });
                },
                removeExtra(index) {
                    this.extras.splice(index, 1);
                },
                totalAllocated() {
                    return (this.extras || []).reduce((sum, row) => sum + Number(row.amount || 0), 0);
                },
                remaining() {
                    return Number(this.mainAmount || 0) - this.totalAllocated();
                },
                submitAllowed() {
                    if (!this.name || !this.name.trim()) {
                        alert('Please enter a budget name.');
                        return false;
                    }
                    if (!this.startDate || !this.endDate) {
                        alert('Select a start and end date.');
                        return false;
                    }
                    if (new Date(this.endDate) < new Date(this.startDate)) {
                        alert('End date cannot be earlier than start date.');
                        return false;
                    }
                    if (!this.mainAmount || Number(this.mainAmount) < 0) {
                        alert('Enter a valid main budget.');
                        return false;
                    }
                    if (this.remaining() < 0) {
                        alert('Allocations exceed main budget. Reduce some amounts.');
                        return false;
                    }
                    return true;
                },
            };
        }
    </script>
</x-accountant-layout>
