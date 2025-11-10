<x-sales-layout>
    <x-slot name="header">
        @include('sales.layouts.header')
    </x-slot>

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen">
        <div class="px-6 pb-12">
            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Follow-up</h1>
                <button id="followup-create-btn"
                    class="flex items-center gap-2 rounded-full border border-fuchsia-800 bg-fuchsia-900 px-4 py-2 text-sm font-semibold text-white hover:bg-fuchsia-800">
                    <i data-feather="plus" class="text-white"></i>
                    Add Reminder
                </button>
            </div>

            <div class="filter-controls mb-4 flex gap-2" data-filter-target="#my-table-id">
                <button data-status="all" class="filter-btn rounded px-3 py-1 text-sm font-medium text-gray-700 ring-transparent">
                    All
                </button>
                <button data-status="Sold" class="filter-btn rounded bg-green-100 px-3 py-1 text-sm font-medium text-green-700">
                    Sold
                </button>
                <button data-status="Unsold" class="filter-btn rounded bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-700">
                    Unsold
                </button>
            </div>

            @if (session('success'))
                <div id="followup-success-banner"
                    class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-[15px] bg-white shadow">
                <div class="border-b px-6 py-5">
                    <h2 class="text-sm text-gray-600">Upcoming follow-ups</h2>
                </div>
                <div id="followup-table-container">
                    @include('sales.partials.followup-table', ['followUps' => $followUps])
                </div>
            </div>
        </div>
    </main>

    <!-- Create / Edit Modal -->
    <div id="followup-form-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="relative w-full max-w-xl rounded-2xl bg-white p-6 shadow-xl">
            <button type="button" id="followup-form-close" class="absolute top-4 right-5 text-2xl text-gray-500 hover:text-black">&times;</button>
            <h2 class="text-xl font-semibold" id="followup-form-title">Add Follow-Up</h2>

            <form id="followup-form" method="POST" action="{{ route('sales.followup.store') }}" class="mt-5 space-y-4">
                @csrf
                <input type="hidden" id="followup-form-method" name="_method" value="">

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Client Name</label>
                    <input type="text" name="client_name" id="followup-client-name" list="followup-client-options"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500"
                        placeholder="Type client name" autocomplete="off" required>
                    <datalist id="followup-client-options">
                        @foreach($clients as $client)
                            <option value="{{ $client->firstname }} {{ $client->lastname }}" data-id="{{ $client->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="client_id" id="followup-client-id">
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="follow_up_date" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500" required>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Time</label>
                        <input type="time" name="follow_up_time" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Priority</label>
                        <select name="priority" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500" required>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500" required>
                            <option value="Sold">Sold</option>
                            <option value="Unsold" selected>Unsold</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" rows="4" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500" placeholder="Optional..."></textarea>
                </div>

                <button type="submit" class="w-full rounded-full bg-fuchsia-900 py-2 text-sm font-semibold text-white hover:bg-fuchsia-800">
                    Save Follow-Up
                </button>
            </form>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="followup-detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="relative w-full max-w-2xl rounded-3xl bg-white p-7 shadow-2xl">
            <button type="button" id="detail-close" class="absolute top-4 right-5 text-3xl text-gray-500 hover:text-black">&times;</button>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 id="detail-client-name" class="text-2xl font-semibold text-gray-900">Client Name</h2>
                    <span id="detail-status-pill" class="mt-2 inline-flex items-center rounded-full border border-gray-300 px-3 py-1 text-xs text-gray-600">Status</span>
                </div>
                <span id="detail-priority-pill" class="inline-flex items-center rounded-full border border-gray-300 px-3 py-1 text-xs text-gray-600">Priority</span>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 text-sm text-gray-700 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-semibold uppercase text-gray-400">Date</p>
                    <div class="mt-2 flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-3">
                        <iconify-icon icon="solar:calendar-outline" width="18" class="text-gray-500"></iconify-icon>
                        <span id="detail-date">�</span>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase text-gray-400">Time</p>
                    <div class="mt-2 flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-3">
                        <iconify-icon icon="solar:clock-outline" width="18" class="text-gray-500"></iconify-icon>
                        <span id="detail-time">�</span>
                    </div>
                </div>
                <div class="col-span-1 flex items-center gap-2 sm:col-span-2">
                    <iconify-icon icon="solar:document-bold" width="20" class="text-gray-500"></iconify-icon>
                    <span id="detail-project">�</span>
                </div>
            </div>

            <div class="mt-6 border-t pt-4">
                <p class="mb-2 text-sm font-semibold text-gray-800">Notes</p>
                <p id="detail-notes" class="text-sm text-gray-600 leading-relaxed">�</p>
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" id="detail-edit"
                    class="w-full rounded-full border border-fuchsia-700 px-6 py-2 text-sm font-semibold text-fuchsia-700 hover:bg-fuchsia-50 sm:w-auto">
                    Edit
                </button>
                <button type="button" id="detail-mark-sold"
                    class="w-full rounded-full bg-fuchsia-900 px-6 py-2 text-sm font-semibold text-white hover:bg-fuchsia-800 sm:w-auto">
                    Mark as Sold
                </button>
            </div>
        </div>
    </div>

    @php
        $successBanner = session('success');
    @endphp
<script>
const followUpStoreUrl = "{{ route('sales.followup.store') }}";
const followUpUpdateUrlTemplate = "{{ route('sales.followups.update', '__ID__') }}";
const followUpShowUrlTemplate = "{{ route('sales.followups.show', '__ID__') }}";
const followUpStatusUrlTemplate = "{{ url('/sales/followups/__ID__/update-status') }}";

document.addEventListener('DOMContentLoaded', () => {
    // ====== GET ELEMENTS ======
    const successBanner = document.getElementById('followup-success-banner');
    const formModal = document.getElementById('followup-form-modal');
    const detailModal = document.getElementById('followup-detail-modal');
    const createBtn = document.getElementById('followup-create-btn');
    const formCloseBtn = document.getElementById('followup-form-close');
    const detailCloseBtn = document.getElementById('detail-close');
    const detailEditBtn = document.getElementById('detail-edit');
    const detailMarkSoldBtn = document.getElementById('detail-mark-sold');

    const form = document.getElementById('followup-form');
    const methodField = document.getElementById('followup-form-method');
    const clientNameInput = document.getElementById('followup-client-name');
    const clientIdField = document.getElementById('followup-client-id');
    const titleEl = document.getElementById('followup-form-title');

    const prioritySelect = form ? form.querySelector('select[name="priority"]') : null;
    const statusSelect   = form ? form.querySelector('select[name="status"]') : null;
    const notesField     = form ? form.querySelector('textarea[name="notes"]') : null;

    // detail fields
    const detailClientName = document.getElementById('detail-client-name');
    const detailStatusPill = document.getElementById('detail-status-pill');
    const detailPriorityPill = document.getElementById('detail-priority-pill');
    const detailDate = document.getElementById('detail-date');
    const detailTime = document.getElementById('detail-time');
    const detailProject = document.getElementById('detail-project');
    const detailNotes = document.getElementById('detail-notes');

    // hide success after 3s
    if (successBanner) {
        setTimeout(() => successBanner.classList.add('hidden'), 3000);
    }

    // ====== CLIENT LIST (datalist) ======
    const clientOptions = Array.from(document.querySelectorAll('#followup-client-options option')).map(opt => ({
        label: (opt.value || '').trim().toLowerCase(),
        id: opt.dataset.id || '',
    }));

    function syncClientId() {
        if (!clientNameInput || !clientIdField) return;
        const value = (clientNameInput.value || '').trim().toLowerCase();
        const match = clientOptions.find(opt => opt.label === value);
        clientIdField.value = match ? match.id : '';
    }

    if (clientNameInput) {
        clientNameInput.addEventListener('input', syncClientId);
        clientNameInput.addEventListener('blur', syncClientId);
    }
    if (form) {
        form.addEventListener('submit', syncClientId);
    }

    // ====== FORM MODAL ======
    function resetForm() {
        if (!form) return;
        form.reset();
        if (prioritySelect) prioritySelect.value = 'Medium';
        if (statusSelect) statusSelect.value = 'Unsold';
        if (clientIdField) clientIdField.value = '';
        if (clientNameInput) clientNameInput.value = '';
        if (notesField) notesField.value = '';
    }

    function openFormModal(data = null) {
        if (!formModal || !form) return;

        if (data) {
            // EDIT MODE
            form.action = followUpUpdateUrlTemplate.replace('__ID__', data.id);
            methodField.value = 'PUT';
            methodField.disabled = false;

            if (clientNameInput) clientNameInput.value = data.client_name || '';
            if (clientIdField) clientIdField.value = data.client_id || '';
            form.follow_up_date.value = data.follow_up_date || '';
            form.follow_up_time.value = data.follow_up_time || '';
            if (prioritySelect) prioritySelect.value = data.priority || 'Medium';
            if (statusSelect) statusSelect.value = data.status || 'Unsold';
            if (notesField) notesField.value = data.notes || '';

            if (titleEl) titleEl.textContent = 'Edit Follow-Up';
        } else {
            // CREATE MODE
            form.action = followUpStoreUrl;
            methodField.value = '';
            methodField.disabled = true;
            resetForm();
            if (titleEl) titleEl.textContent = 'Add Follow-Up';
        }

        formModal.classList.remove('hidden');
        formModal.classList.add('flex');
    }

    function closeFormModal() {
        if (!formModal) return;
        formModal.classList.add('hidden');
        formModal.classList.remove('flex');
    }

    // bind "Add Reminder"
    if (createBtn) {
        createBtn.addEventListener('click', () => openFormModal(null));
    }
    if (formCloseBtn) {
        formCloseBtn.addEventListener('click', closeFormModal);
    }
    if (formModal) {
        formModal.addEventListener('click', (e) => {
            if (e.target === formModal) closeFormModal();
        });
    }

    // ====== DETAIL MODAL ======
    const priorityClasses = {
        High: 'inline-flex items-center rounded-full px-3 py-1 text-xs border border-red-500 text-red-600',
        Medium: 'inline-flex items-center rounded-full px-3 py-1 text-xs border border-yellow-500 text-yellow-600',
        Low: 'inline-flex items-center rounded-full px-3 py-1 text-xs border border-blue-500 text-blue-600',
    };
    const statusClasses = {
        Sold: 'mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs border border-green-500 text-green-600',
        Unsold: 'mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs border border-yellow-500 text-yellow-600',
    };

    let currentFollowUp = null;

    function formatDate(value) {
        if (!value) return '—';
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return value;
        return date.toLocaleDateString(undefined, {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
        });
    }

    function formatTime(value) {
        if (!value) return '—';
        const [hours, minutes] = value.split(':');
        if (hours === undefined || minutes === undefined) return value;
        const date = new Date();
        date.setHours(parseInt(hours, 10), parseInt(minutes, 10), 0, 0);
        return date.toLocaleTimeString(undefined, { hour: 'numeric', minute: '2-digit' });
    }

    function openDetailModal(data) {
        currentFollowUp = data;

        if (detailClientName) detailClientName.textContent = data.client_name || 'N/A';

        if (detailStatusPill) {
            detailStatusPill.textContent = data.status || 'Unsold';
            detailStatusPill.className = statusClasses[data.status] || 'mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs border border-gray-300 text-gray-600';
        }

        if (detailPriorityPill) {
            detailPriorityPill.textContent = data.priority || 'Medium';
            detailPriorityPill.className = priorityClasses[data.priority] || 'inline-flex items-center rounded-full px-3 py-1 text-xs border border-gray-300 text-gray-600';
        }

        if (detailDate) detailDate.textContent = formatDate(data.follow_up_date);
        if (detailTime) detailTime.textContent = formatTime(data.follow_up_time);
        if (detailProject) detailProject.textContent = data.project || '—';
        if (detailNotes) detailNotes.textContent = data.notes || '—';

        if (detailMarkSoldBtn) {
            const isSold = data.status === 'Sold';
            detailMarkSoldBtn.disabled = isSold;
            detailMarkSoldBtn.classList.toggle('opacity-50', isSold);
            detailMarkSoldBtn.classList.toggle('cursor-not-allowed', isSold);
        }

        if (detailModal) {
            detailModal.classList.remove('hidden');
            detailModal.classList.add('flex');
        }
    }

    function closeDetailModal() {
        if (!detailModal) return;
        detailModal.classList.add('hidden');
        detailModal.classList.remove('flex');
    }

    if (detailCloseBtn) {
        detailCloseBtn.addEventListener('click', closeDetailModal);
    }
    if (detailModal) {
        detailModal.addEventListener('click', (e) => {
            if (e.target === detailModal) closeDetailModal();
        });
    }

    // ====== LOAD DETAIL (eye) ======
    function loadFollowUpDetail(id) {
        const url = followUpShowUrlTemplate.replace('__ID__', id);
        fetch(url)
            .then(res => res.json())
            .then(data => openDetailModal(data))
            .catch(() => alert('Unable to load follow-up details.'));
    }

    // ====== TABLE VIEW BUTTONS (eyes) ======
    function bindViewButtons() {
        document.querySelectorAll('.followup-view').forEach(button => {
            if (button.dataset.bound === 'true') return;
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const id = button.dataset.id;
                if (id) loadFollowUpDetail(id);
            });
            button.dataset.bound = 'true';
        });
    }

    // ====== UPDATE ROW STATUS ======
    function updateRowStatus(id, status) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (!row) return;
        row.dataset.status = status;
        const pill = row.querySelector('[data-status-pill]');
        if (pill) {
            const classes = {
                Sold: 'px-3 py-1 text-sm bg-green-100 text-green-700 border border-green-500 rounded-full',
                Unsold: 'px-3 py-1 text-sm bg-yellow-100 text-yellow-700 border border-yellow-500 rounded-full',
            };
            pill.className = classes[status] || 'px-3 py-1 text-sm bg-gray-100 text-gray-800 border border-gray-300 rounded-full';
            pill.textContent = status;
        }
    }

    // ====== DETAIL BUTTONS ======
    if (detailEditBtn) {
        detailEditBtn.addEventListener('click', () => {
            if (!currentFollowUp) return;
            closeDetailModal();
            openFormModal(currentFollowUp);
        });
    }

    if (detailMarkSoldBtn) {
        detailMarkSoldBtn.addEventListener('click', () => {
            if (!currentFollowUp) return;
            const url = followUpStatusUrlTemplate.replace('__ID__', currentFollowUp.id);
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ status: 'Sold' }),
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        currentFollowUp.status = 'Sold';
                        updateRowStatus(currentFollowUp.id, 'Sold');
                        openDetailModal(currentFollowUp);
                    } else {
                        alert(data.message || 'Failed to update status.');
                    }
                })
                .catch(() => alert('Failed to update status.'));
        });
    }

    // ====== PAGINATION / FILTER (AJAX) ======
    function bindPagination() {
        document.querySelectorAll('#followup-table-container .pagination a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                loadFollowUps(e.target.href);
            });
        });
    }

    function loadFollowUps(url) {
        fetch(url)
            .then(res => res.text())
            .then(html => {
                document.getElementById('followup-table-container').innerHTML = html;
                bindPagination();
                bindViewButtons(); // re-bind eyes for new rows
            });
    }

    // filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const status = btn.dataset.status;
            const url = `/sales/followups/filter?status=${status}`;
            loadFollowUps(url);
        });
    });

    // ====== INITIAL BIND ======
    bindPagination();
    bindViewButtons();
});
</script>

</x-sales-layout>


