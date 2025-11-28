@if(!$budget)
  <div class="p-4 text-sm text-gray-600">Select a budget to view its allocations.</div>
@else
  {{-- SUMMARY --}}
  @php
    $main = $budget->main_amount ?? 0;
    $allocated = $budget->allocations->sum('amount') ?? 0;
    $spentAll = $budget->allocations->flatMap->costEntries->sum('amount') ?? 0;
    $currency = $budget->currency ?? 'GHS';
  @endphp

  <div class="grid grid-cols-3 gap-3 mb-4 text-sm">
    <div class="p-3 rounded-xl bg-gray-50">
      <div class="text-gray-500">Main Budget</div>
      <div class="font-semibold">{{ $currency }} {{ number_format($main,2) }}</div>
    </div>
    <div class="p-3 rounded-xl bg-gray-50">
      <div class="text-gray-500">Allocated Total</div>
      <div class="font-semibold">{{ $currency }} {{ number_format($allocated,2) }}</div>
    </div>
    <div class="p-3 rounded-xl bg-gray-50">
      <div class="text-gray-500">Spent to Date</div>
      <div class="font-semibold">{{ $currency }} {{ number_format($spentAll,2) }}</div>
    </div>
  </div>

  {{-- POST form to save costs --}}
  <form method="POST" action="{{ route('accountant.costs.store') }}">
    @csrf
    <input type="hidden" name="budget_id" value="{{ $budget->id }}">

    <div class="overflow-x-auto">
      <table class="min-w-full text-left">
        <thead class="text-sm text-gray-600 bg-gray-100">
          <tr>
            <th class="p-3">Item</th>
            <th class="p-3">Budgeted</th>
            <th class="p-3">Spent to Date</th>
            <th class="p-3">Remaining</th>
            <th class="p-3">Add Amount Spent</th>
            <th class="p-3">Date</th>
            <th class="p-3">Note</th>
          </tr>
        </thead>
        <tbody class="divide-y">
        @foreach($budget->allocations as $a)
          @php
            $budgeted = (float) $a->amount;
            $spent    = (float) ($a->costEntries->sum('amount'));
            $remain   = $budgeted - $spent;
          @endphp
          <tr x-data="{ amt: 0, remain: {{ $remain }} }"
              x-init="$watch('amt', v => { remain = ({{ $remain }} - Number(v||0)); })">
            <td class="p-3">{{ $a->category?->name ?? '-' }}</td>
            <td class="p-3">{{ $currency }} {{ number_format($budgeted,2) }}</td>
            <td class="p-3">{{ $currency }} {{ number_format($spent,2) }}</td>
            <td class="p-3">
              <span :class="remain < 0 ? 'text-red-600 font-semibold' : ''"
                    x-text="`${@js($currency)} ${Number(remain).toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2})}`">
              </span>
            </td>
            <td class="p-3">
              <input type="number" step="0.01" min="0"
                     x-model="amt"
                     name="entries[{{ $a->id }}][amount]"
                     class="px-3 py-2 border rounded-lg w-36"
                     placeholder="0.00">
              <input type="hidden" name="entries[{{ $a->id }}][allocation_id]" value="{{ $a->id }}">
            </td>
            <td class="p-3">
              <input type="date" name="entries[{{ $a->id }}][spent_at]"
                     class="w-40 px-3 py-2 border rounded-lg">
            </td>
            <td class="p-3">
              <input type="text" name="entries[{{ $a->id }}][description]"
                     class="w-64 px-3 py-2 border rounded-lg"
                     placeholder="Optional note (vendor, memo)">
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>

    <div class="flex items-center justify-between mt-4">
       <button type="button" class="px-4 py-2 border rounded-lg"
                          @click="showCostModal = false">Close</button>
      <button class="px-5 py-2 text-white rounded-lg bg-fuchsia-900 hover:bg-purple-800">
        Save Costs
      </button>
    </div>
  </form>
@endif


<script>
(function(){
  const form  = document.getElementById('costSelectorForm');
  const body  = document.getElementById('cost-modal-body');
  if (!form || !body) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const sel = form.querySelector('select[name="budget_id"]');
    const budgetId = sel ? sel.value : '';

    const fragURL = new URL("{{ route('accountant.costs.fragment') }}", window.location.origin);
    if (budgetId) fragURL.searchParams.set('budget_id', budgetId);

    const res = await fetch(fragURL.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
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
