<x-sales-layout>
    <x-slot name="header">
        @include('sales.layouts.header')
    </x-slot>

    <div class="p-4 sm:p-6">
            <div class="mb-6 sm:mb-8 flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-2xl font-bold">Follow-up</h1>
                <button id="followup-create-btn"
                    class="flex items-center gap-2 rounded-full border border-fuchsia-800 bg-fuchsia-900 px-4 py-2 text-sm font-semibold text-white hover:bg-fuchsia-800">
                    <i data-feather="plus" class="text-white"></i>
                    Add Reminder
                </button>
            </div>

            <div class="filter-controls mb-4 flex flex-wrap gap-2" data-filter-target="#my-table-id">
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

    <!-- Create / Edit Modal -->
    <div id="followup-form-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="relative w-full max-w-xl rounded-2xl bg-white p-6 shadow-xl">
            <button type="button" id="followup-form-close" class="absolute top-4 right-5 text-2xl text-gray-500 hover:text-black">&times;</button>
            <h2 class="text-xl font-semibold" id="followup-form-title">Add Follow-Up</h2>

            <form id="followup-form" method="POST" action="{{ route('sales.followup.store') }}" class="mt-5 space-y-4">
                @csrf
                <input type="hidden" id="followup-form-method" name="_method" value="">

                <div class="relative">
                    <label class="mb-1 block text-sm font-medium text-gray-700">Client</label>
                    <input type="text" id="followup-client-search" placeholder="Search client..."
                           class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500"
                           autocomplete="off" required>
                    <input type="hidden" name="client_id" id="followup-client-id" required>
                    <div id="followup-client-suggestions"
                         class="absolute z-20 mt-1 hidden max-h-48 w-full overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg">
                    </div>
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

    <!-- Reminder Modal -->
    <div id="followup-reminder-modal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/60 px-4">
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            <button type="button" id="followup-reminder-close" class="absolute top-3 right-4 text-2xl text-gray-500 hover:text-black">&times;</button>
            <h3 class="text-lg font-semibold text-gray-900">Set Reminder</h3>
            <p class="mt-1 text-sm text-gray-600">Pick a date and time to get an alarm for this follow-up.</p>

            <div class="mt-4 space-y-3">
                <label class="block text-sm font-medium text-gray-700">Reminder date & time</label>
                <input type="datetime-local" id="followup-reminder-at" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500">
                <p id="followup-reminder-error" class="text-sm text-red-600"></p>
            </div>

            <div class="mt-5 flex justify-end gap-3">
                <button type="button" id="followup-reminder-cancel" class="rounded-full border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="button" id="followup-reminder-save" class="rounded-full bg-fuchsia-900 px-4 py-2 text-sm font-semibold text-white hover:bg-fuchsia-800">Save Reminder</button>
            </div>
        </div>
    </div>

    <!-- Alarm Overlay -->
    <div id="followup-alarm-overlay" class="fixed inset-0 z-[70] hidden items-center justify-center bg-black/70 px-4">
        <div class="relative w-full max-w-lg rounded-3xl bg-white p-8 text-center shadow-2xl">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100 text-red-600">
                <iconify-icon icon="solar:alarm-bold" width="34"></iconify-icon>
            </div>
            <h3 class="mt-4 text-xl font-semibold text-gray-900">Reminder Alert</h3>
            <p id="followup-alarm-text" class="mt-2 text-sm text-gray-700"></p>
            <div class="mt-6 flex justify-center">
                <button type="button" id="followup-alarm-dismiss" class="rounded-full bg-fuchsia-900 px-5 py-2 text-sm font-semibold text-white hover:bg-fuchsia-800">Dismiss</button>
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
const followUpReminderUrlTemplate = "{{ route('sales.followups.reminder', '__ID__') }}";
const followUpReminderAckUrlTemplate = "{{ route('sales.followups.reminder.ack', '__ID__') }}";
const followUpReminderFeedUrl = "{{ route('sales.followups.reminder.feed') }}";
const followUpClients = @json($clients->map(fn($c) => [
    'id' => $c->id,
    'label' => trim(($c->firstname ?? '') . ' ' . ($c->lastname ?? '')) ?: 'Client #'.$c->id,
])->values());

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

    // Reminder modal
    const reminderModal = document.getElementById('followup-reminder-modal');
    const reminderClose = document.getElementById('followup-reminder-close');
    const reminderCancel = document.getElementById('followup-reminder-cancel');
    const reminderSave = document.getElementById('followup-reminder-save');
    const reminderInput = document.getElementById('followup-reminder-at');
    const reminderError = document.getElementById('followup-reminder-error');
    let activeReminderFollowUpId = null;

    // Alarm overlay
    const alarmOverlay = document.getElementById('followup-alarm-overlay');
    const alarmText = document.getElementById('followup-alarm-text');
    const alarmDismiss = document.getElementById('followup-alarm-dismiss');
    let activeAlarmFollowUpId = null;
    let alarmTimer = null;

    // hide success after 3s
    if (successBanner) {
        setTimeout(() => successBanner.classList.add('hidden'), 3000);
    }

    // ====== CLIENT SEARCH/SELECT (searchable dropdown) ======
    const clientSearchInput = document.getElementById('followup-client-search');
    const clientSuggestions = document.getElementById('followup-client-suggestions');

    function renderSuggestions(term = '') {
        if (!clientSuggestions) return;
        clientSuggestions.innerHTML = '';
        const needle = term.trim().toLowerCase();
        const matches = followUpClients.filter(c => !needle || c.label.toLowerCase().includes(needle)).slice(0, 20);
        if (matches.length === 0) {
            const li = document.createElement('div');
            li.className = 'px-4 py-2 text-sm text-gray-500';
            li.textContent = 'No results';
            clientSuggestions.appendChild(li);
        } else {
            matches.forEach(c => {
                const li = document.createElement('button');
                li.type = 'button';
                li.className = 'block w-full px-4 py-2 text-left text-sm hover:bg-gray-50';
                li.textContent = c.label;
                li.addEventListener('click', () => {
                    if (clientSearchInput) clientSearchInput.value = c.label;
                    if (clientIdField) clientIdField.value = c.id;
                    clientSuggestions.classList.add('hidden');
                });
                clientSuggestions.appendChild(li);
            });
        }
        clientSuggestions.classList.remove('hidden');
    }

    if (clientSearchInput) {
        clientSearchInput.addEventListener('input', () => {
            if (clientIdField) clientIdField.value = '';
            renderSuggestions(clientSearchInput.value);
        });
        clientSearchInput.addEventListener('focus', () => renderSuggestions(clientSearchInput.value));
    }
    document.addEventListener('click', (e) => {
        if (clientSuggestions && !clientSuggestions.contains(e.target) && e.target !== clientSearchInput) {
            clientSuggestions.classList.add('hidden');
        }
    });

    // ====== FORM MODAL ======
    function resetForm() {
        if (!form) return;
        form.reset();
        if (prioritySelect) prioritySelect.value = 'Medium';
        if (statusSelect) statusSelect.value = 'Unsold';
        if (clientIdField) clientIdField.value = '';
        if (clientSearchInput) clientSearchInput.value = '';
        if (notesField) notesField.value = '';
    }

    function openFormModal(data = null) {
        if (!formModal || !form) return;

        if (data) {
            // EDIT MODE
            form.action = followUpUpdateUrlTemplate.replace('__ID__', data.id);
            methodField.value = 'PUT';
            methodField.disabled = false;

            if (clientSearchInput) clientSearchInput.value = data.client_name || '';
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

    function isoToLocalInput(value) {
        if (!value) return '';
        const d = new Date(value);
        if (Number.isNaN(d.getTime())) return '';
        const pad = (n) => String(n).padStart(2, '0');
        return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
    }

    function openReminderModalFor(id) {
        activeReminderFollowUpId = id;
        reminderError.textContent = '';
        const row = document.querySelector(`tr[data-id="${id}"]`);
        const existing = row?.dataset.reminderAt || '';
        const val = existing ? isoToLocalInput(existing) : '';
        reminderInput.value = val;
        const now = new Date();
        reminderInput.min = isoToLocalInput(now.toISOString());
        reminderModal.classList.remove('hidden');
        reminderModal.classList.add('flex');
    }

    function closeReminderModal() {
        reminderModal.classList.add('hidden');
        reminderModal.classList.remove('flex');
        activeReminderFollowUpId = null;
    }

    if (reminderClose) reminderClose.addEventListener('click', closeReminderModal);
    if (reminderCancel) reminderCancel.addEventListener('click', closeReminderModal);
    if (reminderModal) {
        reminderModal.addEventListener('click', (e) => {
            if (e.target === reminderModal) closeReminderModal();
        });
    }

    if (reminderSave) {
        reminderSave.addEventListener('click', async () => {
            if (!activeReminderFollowUpId) return;
            reminderError.textContent = '';
            const value = reminderInput.value;
            if (!value) {
                reminderError.textContent = 'Please choose a date and time.';
                return;
            }

            const url = followUpReminderUrlTemplate.replace('__ID__', activeReminderFollowUpId);
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ reminder_at: value }),
                });
                const data = await res.json().catch(() => ({}));
                if (!res.ok || data?.ok === false) {
                    reminderError.textContent = data?.message || 'Unable to save reminder.';
                    return;
                }

                const row = document.querySelector(`tr[data-id="${activeReminderFollowUpId}"]`);
                if (row) {
                    row.dataset.reminderAt = data.reminder_at || value;
                    row.dataset.reminderStatus = data.reminder_status || 'scheduled';
                }
                closeReminderModal();
            } catch (err) {
                reminderError.textContent = 'Network error. Please try again.';
            }
        });
    }

    function bindReminderButtons() {
        document.querySelectorAll('.followup-reminder').forEach(button => {
            if (button.dataset.bound === 'true') return;
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const id = button.dataset.id;
                if (id) openReminderModalFor(id);
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
                bindReminderButtons();
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

    // ====== Reminder feed & alarms ======
    const notifBadge = document.getElementById('notifBadge');
    const notifList = document.getElementById('notifList');
    const notifEmpty = document.getElementById('notifEmpty');

    function renderUpcoming(upcoming) {
        if (!notifBadge) return;
        if (!upcoming || upcoming.length === 0) {
            notifBadge.classList.add('hidden');
            if (notifList && notifEmpty) {
                notifList.innerHTML = '';
                notifEmpty.classList.remove('hidden');
            }
            return;
        }
        notifBadge.textContent = Math.min(upcoming.length, 9);
        notifBadge.classList.remove('hidden');
        if (notifList && notifEmpty) {
            notifList.innerHTML = '';
            notifEmpty.classList.add('hidden');
            upcoming.forEach(item => {
                const row = document.createElement('div');
                row.className = 'px-4 py-3 text-sm hover:bg-gray-50';
                const when = item.reminder_at ? new Date(item.reminder_at).toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' }) : '';
                row.textContent = `Reminder at ${when} for ${item.client_name || 'Client'}`;
                notifList.appendChild(row);
            });
        }
    }

    function playAlarm() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const duration = 0.25;
            const freq = 880;
            const beep = () => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.value = freq;
                osc.connect(gain);
                gain.connect(ctx.destination);
                gain.gain.setValueAtTime(0.15, ctx.currentTime);
                osc.start();
                osc.stop(ctx.currentTime + duration);
            };
            beep();
            alarmTimer = setInterval(beep, 700);
        } catch (e) {
            // ignore audio errors
        }
    }

    function stopAlarm() {
        if (alarmTimer) {
            clearInterval(alarmTimer);
            alarmTimer = null;
        }
    }

    function showAlarm(item) {
        if (!alarmOverlay || !alarmText) return;
        activeAlarmFollowUpId = item.id;
        const when = item.reminder_at ? new Date(item.reminder_at).toLocaleString() : 'now';
        alarmText.textContent = `Reminder for ${item.client_name || 'client'} is due (${when}).`;
        alarmOverlay.classList.remove('hidden');
        alarmOverlay.classList.add('flex');
        document.body.style.overflow = 'hidden';
        stopAlarm();
        playAlarm();
    }

    function closeAlarmOverlay() {
        if (!alarmOverlay) return;
        alarmOverlay.classList.add('hidden');
        alarmOverlay.classList.remove('flex');
        document.body.style.overflow = '';
        stopAlarm();
        activeAlarmFollowUpId = null;
    }

    if (alarmDismiss) {
        alarmDismiss.addEventListener('click', async () => {
            if (!activeAlarmFollowUpId) {
                closeAlarmOverlay();
                return;
            }
            const url = followUpReminderAckUrlTemplate.replace('__ID__', activeAlarmFollowUpId);
            try {
                await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                });
            } catch (e) {
                // ignore
            } finally {
                closeAlarmOverlay();
            }
        });
    }

    async function pollReminders() {
        try {
            const res = await fetch(followUpReminderFeedUrl, { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            const upcoming = data?.upcoming || [];
            const due = data?.due || [];
            renderUpcoming(upcoming);
            if (due.length && !activeAlarmFollowUpId) {
                showAlarm(due[0]);
            }
        } catch (err) {
            // swallow polling errors
        }
    }

    // ====== INITIAL BIND ======
    bindPagination();
    bindViewButtons();
    bindReminderButtons();
    pollReminders();
    setInterval(pollReminders, 15000);
});
</script>

</x-sales-layout>
