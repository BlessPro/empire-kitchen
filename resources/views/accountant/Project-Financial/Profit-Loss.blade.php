
{{-- End of table --}}


@php $fmt = fn($n) => '₵' . number_format((float)$n, 2); @endphp

<div class="shadow-md rounded-[15px] bg-white">
  <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
    <thead class="text-sm text-gray-600 bg-gray-100">
      <tr>
        <th class="p-4 font-medium text-[15px]">Budget Name</th>
        <th class="p-4 font-medium text-[15px]">Total Budget</th>
        <th class="p-4 font-medium text-[15px]">Total Expense</th>
        <th class="p-4 font-medium text-[15px]">Net Profit</th>
        <th class="p-4 font-medium text-[15px]">Profit Margin (%)</th>
        {{-- <th class="p-4 font-medium text-[15px] text-right">Actions</th> --}}
      </tr>
    </thead>
    <tbody>
      @forelse($projectSummary as $row)
        <tr class="border-t hover:bg-gray-50">
          <td class="p-4 text-[15px]">{{ $row->name }}</td>
          <td class="p-4 text-[15px]">{{ $fmt($row->sum_total_budget) }}</td>
          <td class="p-4 text-[15px]">{{ $fmt($row->sum_total_expense) }}</td>
          <td class="p-4 text-[15px]">{{ $fmt($row->sum_net_profit) }}</td>
          <td class="p-4 text-[15px]">{{ number_format($row->sum_margin_pct, 2) }}%</td>

        </tr>
      @empty
        <tr><td colspan="6" class="p-6 text-center text-gray-500">No projects found.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4 mb-5 ml-5 mr-5">
    {{ $projectSummary->links('pagination::tailwind') }}
  </div>
</div>
