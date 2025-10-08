<x-accountant-layout>
    <x-slot name="header">
        @include('admin.layouts.header')
    </x-slot>

    <main class="ml-[280px] mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen">
        <div class="p-6">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Edit Budget</h1>
                    <div class="mt-1 text-sm text-gray-600">
                        Project: <span class="font-medium">{{ $project->name }}</span>
                        &middot; Client:
                        <span class="font-medium">
                            {{ $project->client->firstname . ' ' . $project->client->lastname ?? trim($project->client->firstname . ' ' . $project->client->lastname) }}
                        </span>
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
                                This will remove all allocations and cost entries for this project.
                            </p>
                            <div class="flex justify-end gap-3 mt-6">
                                <button @click="open=false" class="px-4 py-2 border rounded-lg">Cancel</button>
                                <form method="POST" action="{{ route('accountant.budgets.destroy', $project) }}">
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

            <form method="POST" action="{{ route('accountant.budgets.update', $project) }}" x-data="editBudget()">
                @csrf @method('PUT')

                {{-- Main budget --}}
                <div class="grid grid-cols-1 gap-4 p-4 bg-white shadow md:grid-cols-3 rounded-2xl">
                    <div>
                        <label class="block mb-1 text-sm font-medium">Main Budget ({{ $currency }})</label>
                        <input type="number" step="0.01" min="0" name="main_amount" x-model="mainAmount"
                            value="{{ old('main_amount', $main_amount) }}" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium">Currency</label>
                        <input type="text" name="currency" value="{{ old('currency', $currency) }}"
                            class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div class="text-sm text-gray-700">
                        <div class="mt-7">
                            <div class="flex justify-between">
                                <span>Allocated (defaults + extras):</span>
                                <span x-text="fmt(totalAllocated())"></span>
                            </div>
                            <div class="flex justify-between font-semibold">
                                <span>Remaining:</span>
                                <span :class="remaining() < 0 ? 'text-red-600' : ''" x-text="fmt(remaining())"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Defaults --}}
                <div class="p-4 mt-6 bg-white shadow rounded-2xl">
                    <h3 class="mb-3 text-base font-semibold">Default Categories</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach ($defaults as $i => $row)
                            <div class="grid items-center grid-cols-12 gap-2">
                                <div class="col-span-6">
                                    <input type="text" readonly class="w-full px-3 py-2 border rounded-lg bg-gray-50"
                                        name="defaults[{{ $i }}][name]" value="{{ $row['name'] }}">
                                </div>
                                <div class="col-span-6">
                                    <input type="number" step="0.01" min="0"
                                        class="w-full px-3 py-2 border rounded-lg"
                                        name="defaults[{{ $i }}][amount]"
                                        x-model="defaults[{{ $i }}].amount" value="{{ $row['amount'] }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Extras --}}
                <div class="p-4 mt-6 bg-white shadow rounded-2xl" x-data>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-semibold">Extra Items</h3>
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
                            <button type="button" class="col-span-1 text-red-600" @click="removeExtra(idx)">✕</button>
                        </div>
                    </template>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('accountant.Project-Financials', ['tab' => 'Project-Budget']) }}"
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
                mainAmount: {{ json_encode($main_amount) }},
                defaults: @json($defaults->map(fn($r) => ['name' => $r['name'], 'amount' => $r['amount']])->values()),
                extras: @json($extras->map(fn($r) => ['name' => $r['name'], 'amount' => $r['amount']])->values()),
                fmt(v) {
                    return '₵' + Number(v || 0).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },
                addExtra() {
                    this.extras.push({
                        name: '',
                        amount: ''
                    });
                },
                removeExtra(i) {
                    this.extras.splice(i, 1);
                },
                totalAllocated() {
                    const d = (this.defaults || []).reduce((s, r) => s + Number(r.amount || 0), 0);
                    const e = (this.extras || []).reduce((s, r) => s + Number(r.amount || 0), 0);
                    return d + e;
                },
                remaining() {
                    return Number(this.mainAmount || 0) - this.totalAllocated();
                },
                submitAllowed() {
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
