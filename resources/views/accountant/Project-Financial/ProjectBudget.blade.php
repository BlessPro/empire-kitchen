    <section class="p-3 space-y-4 sm:p-4">
        @if (session('success'))
            <div class="px-4 py-2 text-sm text-green-700 rounded bg-green-50">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="px-4 py-2 text-sm text-red-700 rounded bg-red-50">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-[20px] overflow-hidden">
            <div
                class="flex flex-col gap-3 px-4 py-4 border-b sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900 sm:text-xl">Project Budgets</h1>
                    <p class="text-sm text-gray-500">Monitor allocated budgets, costs, and balances for every project.</p>
                </div>

                <a href="{{ route('accountant.budgets.create') }}"
                    class="inline-flex items-center px-5 py-2 text-sm font-semibold text-white transition rounded-full bg-fuchsia-900 hover:bg-[#F59E0B] focus:outline-none focus:ring-2 focus:ring-fuchsia-400">
                    + Create Budget
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="text-gray-700 bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Client Name</th>
                            <th class="px-4 py-3 font-semibold">Total Budget</th>
                            <th class="px-4 py-3 font-semibold">Cost</th>
                            <th class="px-4 py-3 font-semibold">Balance</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($projectsBudget as $project)
                            @php
                                $client = $project->client;
                                $clientName = $client ? trim(($client->firstname ?? '') . ' ' . ($client->lastname ?? '')) : '';
                                $currency = optional($project->budget)->currency ?? 'GHS';
                                $formatAmount = fn ($amount) => number_format((float) $amount, 2);
                                $tone = $project->budget_status['tone'] ?? 'gray';
                                $badge = match ($tone) {
                                    'green' => 'bg-green-100 text-green-700 border-green-500',
                                    'amber' => 'bg-yellow-100 text-yellow-700 border-yellow-500',
                                    'red' => 'bg-red-100 text-red-700 border-red-500',
                                    default => 'bg-gray-100 text-gray-700 border-gray-400',
                                };
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $clientName !== '' ? $clientName : '—' }}</td>
                                <td class="px-4 py-3">{{ $currency }} {{ $formatAmount($project->total_budget) }}</td>
                                <td class="px-4 py-3">{{ $currency }} {{ $formatAmount($project->total_cost) }}</td>
                                <td class="px-4 py-3">{{ $currency }} {{ $formatAmount($project->balance) }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-4 py-[3px] text-xs font-medium border rounded-full {{ $badge }}">
                                        {{ $project->budget_status['label'] ?? 'No budget' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right" x-data="{ open: false, confirm: false }">
                                    <div class="relative inline-block text-left">
                                        <button type="button" @click="open = !open"
                                            class="p-2 transition rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-fuchsia-400">
                                            <iconify-icon icon="mdi:dots-vertical"></iconify-icon>
                                        </button>

                                        <div x-cloak x-show="open" x-transition @click.away="open = false"
                                            class="absolute right-0 z-20 w-56 mt-2 bg-white border shadow-lg rounded-xl">
                                            <div class="py-1 text-sm">
                                                @if ($project->budget)
                                                    <a href="{{ route('accountant.budgets.edit', $project) }}"
                                                        class="block px-4 py-2 transition hover:bg-gray-50">
                                                        Edit Budget
                                                    </a>
                                                    <button type="button"
                                                        class="block w-full px-4 py-2 text-left text-red-600 transition hover:bg-red-50"
                                                        @click="open = false; confirm = true">
                                                        Delete Budget
                                                    </button>
                                                @else
                                                    <div class="px-4 py-2 text-gray-400">No budget to edit</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if ($project->budget)
                                        <div x-cloak x-show="confirm"
                                            class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/50"
                                            @click.self="confirm = false" @keydown.escape.window="confirm = false">
                                            <div class="relative w-full max-w-3xl p-10 bg-white rounded-[24px] shadow-lg">
                                                <div class="flex items-start justify-between mb-6">
                                                    <span
                                                        class="inline-flex items-center justify-center bg-red-100 rounded-full w-14 h-14">
                                                        <iconify-icon icon="mdi:close-thick"
                                                            class="text-xl text-red-600"></iconify-icon>
                                                    </span>
                                                    <button type="button" @click="confirm = false"
                                                        class="text-2xl leading-none text-slate-500 hover:text-slate-700">
                                                        &times;
                                                    </button>
                                                </div>

                                                <div class="text-left">
                                                    <h3 class="text-[28px] font-extrabold text-slate-800 leading-tight">
                                                        Delete budget?
                                                    </h3>
                                                    <p class="mt-4 text-base leading-7 text-slate-500">
                                                        Are you sure you want to delete this budget? This action cannot be undone.
                                                    </p>
                                                </div>

                                                <div class="flex items-center justify-end gap-4 mt-10">
                                                    <button type="button" @click="confirm = false"
                                                        class="px-6 py-2.5 rounded-full border border-slate-300 text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-300/60">
                                                        Cancel
                                                    </button>

                                                    <form method="POST" action="{{ route('accountant.budgets.destroy', $project) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-7 py-2.5 rounded-full bg-red-600 text-white font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400/60">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">No projects found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-4">
                {{ $projectsBudget->links('pagination::tailwind') }}
            </div>
        </div>
    </section>
