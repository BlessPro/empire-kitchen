<x-sales-layout>
    <x-slot name="title">Reports & Analytics</x-slot>

    <x-slot name="sidebar">
        @include('sales.layouts.sidebar')
    </x-slot>

      @php
        $statusClasses = [
            'in progress' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
            'completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
            'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
        ];
     

        $defaultClass = 'bg-gray-100 text-gray-800';
    @endphp
           <main class="ml-64 mt-[100px] flex-1 bg-gray-100 min-h-screen  items-center">
            <div class=" bg-[#F9F7F7]">
             <div class="mb-[20px]">
<div class="container px-4 mx-auto">
    <h2 class="mb-4 text-xl font-semibold">Reports & Analytics</h2>
<div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
  <!-- Closed Deals -->
  <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
    <div>
      <p class="mb-6 text-sm text-gray-700">Closed Deals</p>
      <h2 class="text-3xl font-semibold text-black">{{ $closedDeals }}</h2>
    </div>
    <div class="flex items-center justify-center w-10 h-10 bg-orange-100 rounded-full">
           {{-- <i class=" text-orange-500 w-5 h-5" data-feather="dollar-sign"></i> --}}
           <iconify-icon icon="ph:handshake" width="24" style="color: #ff9800;"></iconify-icon>


    </div>
  </div>

  <!-- Revenue Generated -->
  <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
    <div>
      <p class="mb-6 text-sm text-gray-700">Revenue Generated</p>
      <h2 class="text-3xl font-semibold text-black">GH₵ {{ $totalRevenue }}</h2>
    </div>
    <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full">
           {{-- <i class=" text-green-500 w-5 h-5" data-feather="dollar-sign"></i> --}}
           <iconify-icon icon="circum:money-bill" width="24"  class="text-green-500"></iconify-icon>

    </div>
  </div>

  <!-- Completed Follow-ups -->
  <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
    <div>
      <p class="mb-6 text-sm text-gray-700">Completed Follow-ups</p>
      <h2 class="text-3xl font-semibold text-black">{{ $completedFollowUps }}</h2>
    </div>
    <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-full">

           <iconify-icon icon="fluent-mdl2:user-followed" width="24"  class="text-red-500"></iconify-icon>



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
