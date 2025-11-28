<x-accountant-layout>
    <x-slot name="header">
        @include('admin.layouts.header')
    </x-slot>

    <main class="ml-0 mt-0 flex-1 bg-[#F9F7F7] min-h-screen">
        <div class="p-6">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Edit Budget</h1>
                    <div class="mt-1 text-sm text-gray-600">
                        Budget: <span class="font-medium">{{ $budget->name }}</span>
                    </div>
                </div>

                {{-- Delete button + confirm --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open=true"
                        class="px-4 py-2 text-red-700 border border-red-600 rounded-lg hover:bg-red-50">
                        Delete Budget
                    </button>

                    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                        <div class="w-full max-w-md p-6 bg-white shadow-xl rounded-2xl">
                            <h3 class="mb-2 text-lg font-semibold">Delete budget?</h3>
                            <p class="text-sm text-gray-600">
                                This will remove all allocations and cost entries for this budget.
                            </p>
                            <div class="flex justify-end gap-3 mt-6">
                                <button @click="open=false" class="px-4 py-2 border rounded-lg">Cancel</button>
                                <form method="POST" action="{{ route('accountant.budgets.destroy', $budget) }}">
                                    @csrf @method('DELETE')
                                    <button class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="px-3 py-2 mb-4 text-sm text-green-700 rounded bg-green-50">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="px-3 py-2 mb-4 text-sm text-red-700 rounded bg-red-50">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $prefillExtras = collect(old('extras', $extras->toArray()))
                    ->map(fn($r) => [
                        'name' => $r['name'] ?? '',
                        'amount' => $r['amount'] ?? '',
                        'note' => $r['note'] ?? '',
                    ])
                    ->values();
            @endphp

            <form method="POST" action="{{ route('accountant.budgets.update', $budget) }}" x-data="editBudget()">
                @csrf @method('PUT')

                {{-- Budget meta --}}
                <div class="grid grid-cols-1 gap-4 p-4 bg-white shadow md:grid-cols-3 rounded-2xl">
                    <div class="md:col-span-3">
                        <label class="block mb-1 text-sm font-medium">Budget Name</label>
                        <input type="text" name="name" x-model="name"
                            value="{{ old('name', $budget->name) }}"
                            class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium">From Date</label>
                        <input type="date" name="start_date" x-model="startDate"
                            value="{{ old('start_date', optional($budget->start_date)->toDateString()) }}"
                            class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium">To Date</label>
                        <input type="date" name="end_date" x-model="endDate"
                            value="{{ old('end_date', optional($budget->end_date)->toDateString()) }}"
                            class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium">Main Budget ({{ $currency }})</label>
                        <input type="number" step="0.01" min="0" name="main_amount" x-model="mainAmount"
                            value="{{ old('main_amount', $main_amount) }}" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium">Currency</label>
                        <input type="text" name="currency" x-model="currency"
                            value="{{ old('currency', $currency) }}"
                            class="w-full px-3 py-2 border rounded-lg">
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

                {{-- Extras --}}
                <div class="p-4 mt-6 bg-white shadow rounded-2xl">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-semibold">Budget Items</h3>
                        <button type="button" @click="addExtra()"
                            class="px-3 py-1 text-sm bg-gray-100 rounded-lg hover:bg-gray-200">+ Add Item</button>
                    </div>

                    <template x-for="(ex, idx) in extras" :key="idx">
                        <div class="grid grid-cols-12 gap-2 mb-2">
                            <input type="text" class="col-span-7 px-3 py-2 border rounded-lg"
                                :name="`extras[${idx}][name]`" x-model="ex.name" placeholder="Item name" />
                            <input type="number" step="0.01" min="0"
                                class="col-span-4 px-3 py-2 border rounded-lg" :name="`extras[${idx}][amount]`"
                                x-model="ex.amount" placeholder="Amount" />
                            <button type="button" class="col-span-1 text-red-600" @click="removeExtra(idx)">Remove</button>
                            <textarea class="col-span-12 px-3 py-2 border rounded-lg"
                                :name="`extras[${idx}][note]`" x-model="ex.note"
                                placeholder="Optional note (details, assumptions)"></textarea>
                        </div>
                    </template>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('accountant.Project-Financials', ['tab' => 'project-budget']) }}"
                        class="px-4 py-2 border rounded-lg">Cancel</a>
                    <button class="px-5 py-2 text-white rounded-lg bg-fuchsia-900 hover:bg-purple-800"
                        @click="return submitAllowed()">
                        Update Budget
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function editBudget() {
            return {
                name: {{ json_encode(old('name', $budget->name)) }},
                startDate: {{ json_encode(old('start_date', optional($budget->start_date)->toDateString())) }},
                endDate: {{ json_encode(old('end_date', optional($budget->end_date)->toDateString())) }},
                mainAmount: {{ json_encode(old('main_amount', $main_amount)) }},
                currency: {{ json_encode(old('currency', $currency)) }},
                extras: @json($prefillExtras),
                fmt(v) {
                    const prefix = (this.currency ? this.currency + ' ' : '');
                    return prefix + Number(v || 0).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },
                addExtra() {
                    this.extras.push({
                        name: '',
                        amount: '',
                        note: ''
                    });
                },
                removeExtra(i) {
                    this.extras.splice(i, 1);
                },
                totalAllocated() {
                    return (this.extras || []).reduce((s, r) => s + Number(r.amount || 0), 0);
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
                    if (this.remaining() < 0) {
                        alert('Allocations exceed main budget. Reduce some amounts.');
                        return false;
                    }
                    return true;
                }
            }
        }
    </script>
</x-accountant-layout>
