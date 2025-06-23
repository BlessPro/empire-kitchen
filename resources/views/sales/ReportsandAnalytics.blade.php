<x-sales-layout>
    <x-slot name="title">Reports & Analytics</x-slot>

    <x-slot name="sidebar">
        @include('sales.layouts.sidebar')
    </x-slot>

           <main class="ml-64 mt-[100px] flex-1 bg-gray-100 min-h-screen  items-center">
            <div class=" bg-[#F9F7F7]">
             <div class="mb-[20px]">
<div class="container mx-auto px-4">
    <h2 class="text-xl font-semibold mb-4">Reports & Analytics</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
  <!-- Closed Deals -->
  <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
    <div>
      <p class="text-sm text-gray-700 mb-6">Closed Deals</p>
      <h2 class="text-3xl font-semibold text-black">{{ $closedDeals }}</h2>
    </div>
    <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
      <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
      </svg>
    </div>
  </div>

  <!-- Revenue Generated -->
  <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
    <div>
      <p class="text-sm text-gray-700 mb-6">Revenue Generated</p>
      <h2 class="text-3xl font-semibold text-black">GH₵ {{ $totalRevenue }}</h2>
    </div>
    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
      <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.5 0 2-1 2-2s-.5-2-2-2-2 1-2 2 .5 2 2 2zm0 0v6m0 0c-1.5 0-2 1-2 2s.5 2 2 2 2-1 2-2-.5-2-2-2z" />
      </svg>
    </div>
  </div>

  <!-- Completed Follow-ups -->
  <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
    <div>
      <p class="text-sm text-gray-700 mb-6">Completed Follow-ups</p>
      <h2 class="text-3xl font-semibold text-black">{{ $completedFollowUps }}</h2>
    </div>
    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
      <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </div>
  </div>
</div>

    <div id="reportsTable">
        @include('sales.partials.reports-table', ['projects' => $projects])
    </div>
</div>



             </div>
            </div>
        </main>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = e.target.getAttribute('href');

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('reportsTable').innerHTML = html;
            });
        }
    });
});
</script>
</x-sales-layout>
