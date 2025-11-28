<style>
    [x-cloak] {
        display: none !important
    }
</style>

<div x-data="{ showCostModal: false }">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Cost Tracking</h1>

        <!-- Trigger button -->
        <button @click="showCostModal = true" class="px-5 py-2 rounded-full text-white bg-fuchsia-900 hover:bg-[#F59E0B]">
            Track Cost
        </button>
    </div>

    <!-- COST MODAL -->
    <div x-show="showCostModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
        @click.self="showCostModal = false">
        <div class="w-full max-w-6xl max-h-[85vh] overflow-y-auto bg-white rounded-2xl shadow-xl p-6">

            <!-- Modal header with close X -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Track Cost</h2>
                <button type="button" class="text-xl leading-none text-gray-400 hover:text-gray-600"
                    @click="showCostModal = false" aria-label="Close">
                    &times;
                </button>
            </div>

            @if (session('success'))
                <div class="px-3 py-2 mb-4 text-sm text-green-700 rounded bg-green-50">{{ session('success') }}</div>
            @endif
            @if (session('info'))
                <div class="px-3 py-2 mb-4 text-sm text-blue-700 rounded bg-blue-50">{{ session('info') }}</div>
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

            {{-- Budget selector --}}
            <form method="GET" id="costSelectorForm" class="mb-4">
                <label class="block mb-2 text-sm font-medium">Budget</label>
                <div class="flex gap-2">
                    <select name="budget_id" class="w-[420px] border rounded-lg px-3 py-2">
                        <option value="">-- Select budget --</option>
                        @foreach ($budgetsAudit as $budgetOption)
                            <option value="{{ $budgetOption->id }}" @selected($selectedBudgetId == $budgetOption->id)>{{ $budgetOption->name }}</option>
                        @endforeach
                    </select>
                    <button class="px-4 py-2 text-white rounded-lg bg-fuchsia-900 hover:bg-purple-800">Load</button>
                </div>
            </form>

            <div id="cost-modal-body">
                @include('accountant.Project-Financial._cost_modal_body', [
                    'budget' => $selectedBudget,
                ])
            </div>

            <script>
                (function() {
                    const form = document.getElementById('costSelectorForm');
                    const body = document.getElementById('cost-modal-body');
                    if (!form || !body) return;

                    form.addEventListener('submit', async (e) => {
                        e.preventDefault();

                        const sel = form.querySelector('select[name="budget_id"]');
                        const budgetId = sel ? sel.value : '';

                        const fragURL = new URL("{{ route('accountant.costs.fragment') }}", window.location.origin);
                        if (budgetId) fragURL.searchParams.set('budget_id', budgetId);

                        const res = await fetch(fragURL.toString(), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        if (!res.ok) return;
                        const html = await res.text();

                        body.innerHTML = html;

                        const pageURL = new URL(window.location.href);
                        if (budgetId) pageURL.searchParams.set('budget_id', budgetId);
                        pageURL.searchParams.set('tab', pageURL.searchParams.get('tab') || 'cost-tracking');
                        history.replaceState({}, '', pageURL.toString());
                    });
                })();
            </script>

        </div>
    </div>
</div>

{{-- Cost summary table --}}
<div class="shadow-md rounded-[15px] bg-white">
    <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
        <thead class="text-sm text-gray-600 bg-gray-100">
            <tr>
                <th class="p-4 font-medium text-[15px]">Budget Name</th>
                <th class="p-4 font-medium text-[15px]">Total Cost</th>
                <th class="p-4 font-medium text-[15px]">Measurement</th>
                <th class="p-4 font-medium text-[15px]">Design</th>
                <th class="p-4 font-medium text-[15px]">Production</th>
                <th class="p-4 font-medium text-[15px]">Installation</th>
                <th class="p-4 font-medium text-[15px]">Others</th>
            </tr>
        </thead>
        <tbody>
            @php $fmt = fn($n) => number_format((float)$n, 2); @endphp

            @forelse($costBudgets as $budget)
                @php $currency = $budget->currency ?? 'GHS'; @endphp
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-4 font-normal text-[15px]">{{ $budget->name }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ $currency }} {{ $fmt($budget->cost_total) }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ $currency }} {{ $fmt($budget->cost_measurement) }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ $currency }} {{ $fmt($budget->cost_design) }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ $currency }} {{ $fmt($budget->cost_production) }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ $currency }} {{ $fmt($budget->cost_installation) }}</td>
                    <td class="p-4 font-normal text-[15px]">{{ $currency }} {{ $fmt($budget->cost_others) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-6 text-center text-gray-500">No budgets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4 mb-5 ml-5 mr-5">
        {{ $costBudgets->links('pagination::tailwind') }}
    </div>
</div>
