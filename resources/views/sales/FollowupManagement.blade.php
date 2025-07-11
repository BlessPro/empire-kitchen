<!-- Example for sales -->
<x-sales-layout>
<x-slot name="header">
   @include('sales.layouts.header')
</x-slot>
     {{-- {{ dd($projects) }} --}}
   
        

     

  <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

    <div class=" bg-[#F9F7F7] items-center">
     <div class="mb-[20px] items-center">
 <div class="flex items-center justify-between mb-6">

                    <!-- Top Navbar -->
            <h1 class="text-2xl font-bold">Followup </h1>

            <div class="flex items-center space-x-4">

            <button
     onclick="openFollowUpModal()" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white border border-purple-800 rounded-full bg-fuchsia-900">
                <i data-feather="plus" class="text-white"> </i>
                    Add Reminder
            </button>



            </div>
      </div>


<div class="filter-controls flex gap-2 mb-4" data-filter-target="#my-table-id">
    <button data-status="all" class="filter-btn px-3 py-1 bg-gray-300 rounded">All</button>
    <button data-status="Pending" class="filter-btn px-3 py-1 bg-yellow-300 rounded">Pending</button>
    <button data-status="Completed" class="filter-btn px-3 py-1 bg-green-300 rounded">Completed</button>
    <button data-status="Rescheduled" class="filter-btn px-3 py-1 bg-blue-300 rounded">Rescheduled</button>
</div>

<div class="bg-white shadow-md rounded-[15px] pb-1">
 <div class="pt-6 pb-5 pl-6 border-b">
            <h2 class="text-sm text-gray-600 ">Upcoming followups</h2>
            </div>

            {{-- Table Section --}}
<div id="followup-table-container">
    @include('sales.partials.followup-table', ['followUps' => $followUps])
</div>
</div>

      <!-- Modal Backdrop -->
<div id="followUpModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl relative">
        <h2 class="text-xl font-semibold mb-4">Add Follow-Up</h2>

        <button onclick="closeFollowUpModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black">&times;</button>

        <form method="POST" action="{{ route('sales.followup.store') }}">
            @csrf

                   <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">

            <div>
            <!-- Client -->
            <label class="block mb-1 text-sm font-medium text-gray-700">Client</label>
            <select name="client_id" id="client-select" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                <option value="">Select Client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->firstname }} {{ $client->lastname }}</option>
                @endforeach
            </select>
        </div>
    <div>
       <label class="block mb-1 text-sm font-medium text-gray-700">Project</label>

     <select name="project_id" id="project-select" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
    <option value="">Select Project</option>
    {{-- Options will be added dynamically --}}
    </select>
    </div>
    </div>


        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
  <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="follow_up_date" required class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Time</label>
                    <input type="time" name="follow_up_time" required class=" w-full p-2 border border-gray-300 rounded-md">
                </div>
        </div>

           <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">

<div>
            <!-- Priority -->
            <label class="block text-sm font-medium mt-4 mb-1">Priority</label>
            <select name="priority" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                <option value="Low">Low</option>
                <option value="Medium" selected>Medium</option>
                <option value="High">High</option>
            </select>
</div>
<div>
            <!-- Status -->
            <label class="block mb-1 text-sm font-medium text-gray-700">Status</label>
            <select name="status" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                <option value="Pending" selected>Pending</option>
                <option value="Completed">Completed</option>
                <option value="Rescheduled">Rescheduled</option>
            </select>
</div>
           </div>
            <!-- Notes -->
            <label class="block mb-4 text-sm font-medium text-gray-700">Notes</label>
            <textarea name="notes" rows="3" class="w-full mb-4 border rounded px-3 py-2" placeholder="Optional..."></textarea>

            <!-- Submit -->
            <button type="submit" class="bg-fuchsia-700 hover:bg-fuchsia-800 text-white font-semibold px-4 py-2 rounded w-full">
                Save Follow-Up
            </button>
        </form>
    </div>
</div>
            </div>
    </div>
</main>

{{--selecting client and project--}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const clientSelect = document.getElementById('client-select');
        const projectSelect = document.getElementById('project-select');

        clientSelect.addEventListener('change', function () {
            const clientId = this.value;

            // Clear existing options
            projectSelect.innerHTML = '<option value="">Select Project</option>';

            if (clientId) {
                fetch(`/sales/client/${clientId}/projects`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(project => {
                            const option = document.createElement('option');
                            option.value = project.id;
                            option.textContent = project.name;
                            projectSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching projects:', error);
                    });
            }
        });
    });
</script>

{{--follow up modal--}}
<script>
function openFollowUpModal() {
    document.getElementById('followUpModal').classList.remove('hidden');
}

function closeFollowUpModal() {
    document.getElementById('followUpModal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    const clientSelect = document.getElementById('client-select');
    const projectSelect = document.getElementById('project-select');

    if (clientSelect) {
        clientSelect.addEventListener('change', function () {
            const clientId = this.value;

            if (!clientId) return;

            fetch(`/sales/client/${clientId}/projects`)
                .then(res => res.json())
                .then(data => {
                    projectSelect.innerHTML = '<option value="">Select Project</option>';
                    data.forEach(project => {
                        const opt = document.createElement('option');
                        opt.value = project.id;
                        opt.textContent = project.name;
                        projectSelect.appendChild(opt);
                    });
                });
        });
    }
});


</script>
{{--pagination--}}
<script>
    function loadFollowUps(url) {
        fetch(url)
            .then(res => res.text())
            .then(html => {
                document.getElementById('followup-table-container').innerHTML = html;

                // Reattach pagination click events
                attachPaginationEvents();
            });
    }

    function attachPaginationEvents() {
        document.querySelectorAll('#followup-table-container .pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                loadFollowUps(this.href);
            });
        });
    }

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const status = this.dataset.status;
            const url = `/sales/followups/filter?status=${status}`;
            loadFollowUps(url);
        });
    });

    // Initial load attach
    attachPaginationEvents();
</script>

{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    loadFollowUps(); // bind once at start

    function loadFollowUps() {
        document.querySelectorAll('#followup-table-wrapper .pagination a').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.getAttribute('href');

                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('followup-table-wrapper').innerHTML = html;
                        loadFollowUps(); // rebind after DOM update
                    });
            });
        });
    }
});
</script> --}}

{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.filter-btn');
    const rows = document.querySelectorAll('#followups-table-wrapper tr[data-status]');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const status = this.getAttribute('data-status');

            rows.forEach(row => {
                if (status === 'all' || row.getAttribute('data-status') === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Optional: style the active button
            buttons.forEach(btn => btn.classList.remove('ring', 'ring-offset-2', 'ring-gray-800'));
            this.classList.add('ring', 'ring-offset-2', 'ring-gray-800');
        });
    });
});
</script> --}}


{{--for filtering--}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.filter-controls').forEach(controlGroup => {
        const tableSelector = controlGroup.getAttribute('data-filter-target');
        const rows = document.querySelectorAll(`${tableSelector} tr[data-status]`);
        const buttons = controlGroup.querySelectorAll('.filter-btn');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const status = this.getAttribute('data-status');

                rows.forEach(row => {
                    if (status === 'all' || row.getAttribute('data-status') === status) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Optional: highlight active button
                buttons.forEach(btn => btn.classList.remove('ring', 'ring-offset-2', 'ring-gray-800'));
                this.classList.add('ring', 'ring-offset-2', 'ring-gray-800');
            });
        });
    });
});
</script>

{{-- Modal for follow-up details --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('followup-modal');
    const closeModalBtn = document.getElementById('closeModal');
    const saveBtn = document.getElementById('saveFollowup');
    let currentId = null;

    document.querySelectorAll('.followup-row').forEach(row => {
        row.addEventListener('click', function () {
            currentId = this.dataset.id;
            document.getElementById('modal-client').innerText = this.dataset.client;
            document.getElementById('modal-project').innerText = this.dataset.project;
            document.getElementById('modal-date').innerText = this.dataset.date;
            document.getElementById('modal-time').innerText = this.dataset.time;
            document.getElementById('modal-notes').innerText = this.dataset.notes;
            document.getElementById('modal-status').value = this.dataset.status;

            modal.classList.remove('hidden');
        });
    });

    closeModalBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

  saveBtn.addEventListener('click', function () {
    const newStatus = document.getElementById('modal-status').value;

    fetch(`/sales/followups/${currentId}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Update status in the table row
            const row = document.querySelector(`tr[data-id="${currentId}"]`);
            const statusCell = row.querySelector('td:nth-child(7) span');

            // Optional: Update the row's dataset too
            row.dataset.status = newStatus;

            // Update status label text
            statusCell.innerText = newStatus;

            // Update status badge class (re-apply colors)
            const statusClasses = {
                'Pending': 'bg-blue-100 text-blue-700 border border-blue-500 rounded-full ',
                'Completed': 'bg-green-100 text-green-700 border border-green-500 rounded-full',
                'Rescheduled': 'bg-yellow-100 text-yellow-700 border border-yellow-500 rounded-full'
            };
            const defaultClass = 'bg-gray-100 text-gray-800';

            // Remove all old classes and apply new
            statusCell.className = `px-3 py-1 text-sm ${statusClasses[newStatus] || defaultClass}`;

            // Close modal
            modal.classList.add('hidden');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Failed to update status.');
        console.error(error);
    });
});

});
</script>

     </x-sales-layout>
