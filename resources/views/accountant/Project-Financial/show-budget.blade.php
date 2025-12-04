<x-accountant-layout>
    <section class="p-4 space-y-4 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Budget</p>
                <h1 class="text-2xl font-bold text-gray-900">{{ $budget->name ?? 'Budget' }}</h1>
                <p class="text-sm text-gray-500">
                    {{ optional($budget->start_date)->format('M j, Y') ?? '-' }} — {{ optional($budget->end_date)->format('M j, Y') ?? '-' }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Total Budget</p>
                <p class="text-xl font-semibold text-gray-900">{{ $currency }} {{ number_format($totals['budget'], 2) }}</p>
                <p class="text-sm text-gray-500">Balance: {{ $currency }} {{ number_format($totals['balance'], 2) }}</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl bg-white p-4 shadow">
                <p class="text-xs text-gray-500">Budget</p>
                <p class="text-lg font-semibold text-gray-900">{{ $currency }} {{ number_format($totals['budget'], 2) }}</p>
            </div>
            <div class="rounded-2xl bg-white p-4 shadow">
                <p class="text-xs text-gray-500">Cost</p>
                <p class="text-lg font-semibold text-gray-900">{{ $currency }} {{ number_format($totals['cost'], 2) }}</p>
            </div>
            <div class="rounded-2xl bg-white p-4 shadow">
                <p class="text-xs text-gray-500">Balance</p>
                <p class="text-lg font-semibold text-gray-900">{{ $currency }} {{ number_format($totals['balance'], 2) }}</p>
            </div>
        </div>

        <div class="overflow-x-auto rounded-[20px] bg-white shadow">
            <table class="min-w-full text-left text-sm text-gray-700">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Category</th>
                        <th class="px-4 py-3 font-semibold text-right">Budget</th>
                        <th class="px-4 py-3 font-semibold text-right">Cost</th>
                        <th class="px-4 py-3 font-semibold text-right">Balance</th>
                        <th class="px-4 py-3 font-semibold">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($allocations as $alloc)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $alloc['name'] ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">{{ $currency }} {{ number_format($alloc['amount'], 2) }}</td>
                            <td class="px-4 py-3 text-right">{{ $currency }} {{ number_format($alloc['cost_total'], 2) }}</td>
                            <td class="px-4 py-3 text-right">{{ $currency }} {{ number_format($alloc['balance'], 2) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $alloc['note'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No budget items.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('accountant.Project-Financials', ['tab' => 'project-budget']) }}"
               class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 rounded-full hover:bg-gray-50">
                Back to budgets
            </a>
            <a href="{{ route('accountant.budgets.edit', $budget) }}"
               class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                Edit Budget
            </a>
        </div>
    </section>
</x-accountant-layout>
