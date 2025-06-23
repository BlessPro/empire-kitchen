<!-- Example for sales -->
<x-sales-layout>

  <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

    <div class=" bg-[#F9F7F7] items-center">
     <div class="mb-[20px] items-center">



<div class="container">

    <h2 class="text-xl font-semibold mb-4">Client List</h2>

    <div class="mb-4 flex gap-3">
        <button data-filter="" class="filter-btn px-3 py-1 bg-gray-200 rounded">All</button>
        <button data-filter="new" class="filter-btn px-3 py-1 bg-blue-200 rounded">New</button>
        <button data-filter="with-projects" class="filter-btn px-3 py-1 bg-green-200 rounded">With Projects</button>
    </div>

    <table class="w-full border-collapse border border-gray-300 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">Name</th>
                <th class="border px-3 py-2">Email</th>
                <th class="border px-3 py-2">Phone</th>
                <th class="border px-3 py-2">Location</th>
                <th class="border px-3 py-2">Created</th>
            </tr>
        </thead>
        <tbody id="clients-table-body">
            @include('sales.partials.clienttable', ['clients' => $clients])
        </tbody>
    </table>
</div>

<script>
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const filter = this.dataset.filter;

        fetch(`/sales/ClientManagement/filter?filter=${filter}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('clients-table-body').innerHTML = html;
            });
    });
});
</script>
     </div>
    </div>
</main>
</x-sales-layout>
