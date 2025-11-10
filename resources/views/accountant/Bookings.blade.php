< <x-accountant-layout>

    <x-slot name="header">
        <script src="//unpkg.com/alpinejs" defer></script>
        <style>
            [x-cloak] {
                display: none !important
            }
        </style>
        @include('admin.layouts.header')
    </x-slot>
    <main class="bg-[#F9F7F7] min-h-screen">
        <div class="p-3 space-y-2 sm:p-4">

            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Bookings</h1>
            </div>
            <div class="bg-white rounded-[20px] shadow">


                <div class="flex items-center justify-between pt-5 pb-1 pl-6 pr-6">
                    <p class="text-gray-600 text-[18px] font-normal"> Manage all your Bookings here</p>

                    <form id="filterForm" method="GET" action="{{ route('accountant.Bookings') }}"
                        class="flex flex-wrap items-center gap-3 mb-4">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Search by client name..."
                            class="pt-2 pb-2 pl-5 pr-5 border border-gray-300 rounded-full focus:outline-none
                             focus:ring-2 focus:ring-[#5A0562]/20" />

                        <select name="booked_status"
                            class="pt-2 pb-2 pl-5 pr-5 border border-gray-300 rounded-full
                             focus:outline-none focus:ring-2 focus:ring-[#5A0562]/20">
                            <option value="">All</option>
                            <option value="BOOKED" {{ ($booked_status ?? '') === 'BOOKED' ? 'selected' : '' }}>BOOKED
                            </option>
                            <option value="UNBOOKED" {{ ($booked_status ?? '') === 'UNBOOKED' ? 'selected' : '' }}>
                                UNBOOKED</option>
                        </select>
                    </form>
                </div>

                <script>
                    const f = document.getElementById('filterForm');
                    const bs = f.querySelector('select[name="booked_status"]');
                    bs.addEventListener('change', () => f.submit());
                    const si = f.querySelector('input[name="search"]');
                    let t;
                    si.addEventListener('input', () => {
                        clearTimeout(t);
                        t = setTimeout(() => f.submit(), 300);
                    });
                </script>

                <table class="min-w-full text-left">
                    <thead class="items-center text-sm text-gray-600 bg-gray-100">
                        <tr>
                            <th class="p-4 font-medium text-[15px]">Client</th>
                            <th class="p-4 font-medium text-[15px]">Project</th>
                            <th class="p-4 font-medium text-[15px]">Location</th>
                            <th class="p-4 font-medium text-[15px]">Status</th>
                            <th class="p-4 font-mediumt  font-medium text-[15px]">Action</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700 divide-y divide-gray-100">
                        @forelse($projects as $i => $p)
                            <tr
                                class=" text-sm  border-t hover:bg-gray-50 {{ $p->booked_status === 'BOOKED' ? 'bg-white' : 'bg-white' }}">
                                {{-- <td class="p-4">{{ $projects->firstItem() + $i }}</td> --}}
                                <td class="p-4">

                                    <span class="font-normal text-[15px]">
                                        {{ $p->client->lastname . ' ' . $p->client->firstname ?? '—' }}
                                    </span>

                                </td>

                                <td class="p-4">
                                    <span class="font-normal text-[15px]">
                                        {{ $p->name }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    <span class="font-normal text-[15px]">
                                        {{ $p->location }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    <span
                                        class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                                        {{ $p->booked_status === 'BOOKED' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $p->booked_status }}
                                    </span>
                                </td>


                                <td class="p-4" x-data="{ open: false }">
                                    @php
                                        $viewPrefix =
                                            $viewPrefix ??
                                            (str_starts_with(Route::currentRouteName(), 'accountant.')
                                                ? 'accountant'
                                                : 'admin');
                                    @endphp

                                    <div class="relative" x-data="{ open: false }">
                                        <button type="button" @click="open = !open"
                                            class="p-2 rounded hover:bg-gray-100 focus:outline-none">
                                            <iconify-icon icon="mdi:dots-vertical"></iconify-icon>
                                        </button>

                                        <div x-show="open" x-cloak @click.outside="open=false"
                                            class="absolute right-0 z-10 w-56 mt-2 bg-white border shadow-lg rounded-xl">
                                            <div class="py-1">
                                                @if (($p->booked_status ?? 'UNBOOKED') === 'BOOKED')
                                                    {{-- Set as UNBOOKED --}}
                                                    <form method="POST"
                                                        action="{{ route($viewPrefix . '.bookings.unbook', $p) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="w-full px-4 py-2 text-sm text-left hover:bg-gray-50">
                                                            Set as Unbooked
                                                        </button>
                                                    </form>
                                                @else
                                                    {{-- Set as BOOKED --}}
                                                    <form method="POST"
                                                        action="{{ route($viewPrefix . '.bookings.book', $p) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="w-full px-4 py-2 text-sm text-left hover:bg-gray-50">
                                                            Set as Booked
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    No projects found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Measure / Booking Modal -->
            <script>
                const modal = document.getElementById('measureModal');
                const openBtn = document.getElementById('openModal');
                const projectSelect = document.getElementById('mm_project_id');
                const clientNameEl = document.getElementById('mm_client_name');
                const clientIdEl = document.getElementById('mm_client_id');
                const submitBtn = document.getElementById('mm_submit_btn');

                async function loadBookedProjects() {
                    try {
                        const res = await fetch(`{{ route('projects.booked') }}`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        if (!res.ok) return;
                        const projects = await res.json();
                        // populate select
                        projectSelect.innerHTML = '<option value="">— Select project —</option>';
                        projects.forEach(p => {
                            const o = document.createElement('option');
                            o.value = p.id;
                            o.textContent = p.name;
                            o.dataset.clientId = p.client?.id || '';
                            o.dataset.clientName = p.client?.name || '';
                            projectSelect.appendChild(o);
                        });
                    } catch (e) {
                        console.error(e);
                    }
                }

                function openModal() {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.classList.add('overflow-hidden');

                    // reset
                    clientNameEl.value = '';
                    clientIdEl.value = '';
                    submitBtn.disabled = true;

                    // load projects each time you open (or cache if you prefer)
                    loadBookedProjects();
                }

                function closeModal() {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                }

                // Open button
                openBtn?.addEventListener('click', openModal);

                // Close on ESC
                document.addEventListener('keydown', (e) => {
                    if (!modal.classList.contains('hidden') && e.key === 'Escape') closeModal();
                });

                // Close on backdrop click (but not inside the form)
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeModal();
                });

                // When a project is chosen, set the client fields and enable submit
                projectSelect?.addEventListener('change', async () => {
                    const id = projectSelect.value;
                    clientNameEl.value = '';
                    clientIdEl.value = '';
                    submitBtn.disabled = true;

                    if (!id) return;

                    try {
                        // you can read from option dataset OR call the endpoint; dataset avoids an extra fetch
                        const sel = projectSelect.options[projectSelect.selectedIndex];
                        const cNameFromDataset = sel?.dataset?.clientName || '';
                        const cIdFromDataset = sel?.dataset?.clientId || '';

                        if (cIdFromDataset && cNameFromDataset) {
                            clientIdEl.value = cIdFromDataset;
                            clientNameEl.value = cNameFromDataset;
                            submitBtn.disabled = false;
                        } else {
                            // fallback: fetch client name if dataset not present
                            const res = await fetch(`{{ url('/projects') }}/${id}/client`, {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            });
                            if (!res.ok) return;
                            const c = await res.json();
                            clientIdEl.value = c.id || '';
                            clientNameEl.value = c.name || '';
                            submitBtn.disabled = !(clientIdEl.value && clientNameEl.value);
                        }
                    } catch (e) {
                        console.error(e);
                    }
                });
            </script>


        </div>
    </main>



    <script>
        const f = document.getElementById('filterForm');
        const bs = f.querySelector('select[name="booked_status"]');
        bs.addEventListener('change', () => f.submit());
        const si = f.querySelector('input[name="search"]');
        let t;
        si.addEventListener('input', () => {
            clearTimeout(t);
            t = setTimeout(() => f.submit(), 300);
        });
    </script>

    <!---for single popup --->
    <script>
        const singleModalEl = document.getElementById('singleModal');
        const smProjectIdEl = document.getElementById('sm_project_id');
        const smProductNameEl = document.getElementById('sm_product_name');
        const smClientIdEl = document.getElementById('sm_client_id');
        const smClientNameEl = document.getElementById('sm_client_name');

        function singleOpenModal({
            projectId,
            productName = '',
            clientId = '',
            clientName = ''
        }) {
            // fill fields
            smProjectIdEl.value = projectId || '';
            smProductNameEl.value = productName || '';
            smClientIdEl.value = clientId || '';
            smClientNameEl.value = clientName || '';

            // show modal
            singleModalEl.classList.remove('hidden');
            singleModalEl.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function singleCloseModal() {
            singleModalEl.classList.add('hidden');
            singleModalEl.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        // ESC closes
        document.addEventListener('keydown', (e) => {
            if (!singleModalEl.classList.contains('hidden') && e.key === 'Escape') singleCloseModal();
        });

        // Backdrop click closes
        singleModalEl.addEventListener('click', (e) => {
            if (e.target === singleModalEl) singleCloseModal();
        });

        // Make it callable from your 3-dot menu:
        // singleOpenModal({ projectId: 123, productName: 'Island Set', clientId: 45, clientName: 'Ama Boateng' });
    </script>

    <script>
        // === OVERRIDE BOOKING MODAL (vanilla) ===
        const overrideEl = document.getElementById('overrideModal');
        const ovPwdInput = document.getElementById('ov_password');
        const ovErrorEl = document.getElementById('ov_error');
        const ovConfirmBtn = document.getElementById('ov_confirm_btn');

        // Keep context to reopen the single modal with data after success
        let ovProjectId = null;
        let ovProductName = ''; // optional; pass through from row if you have it

        function overrideOpen({
            projectId,
            productName = ''
        }) {
            ovProjectId = projectId;
            ovProductName = productName;
            ovPwdInput.value = '';
            ovErrorEl.textContent = '';

            overrideEl.classList.remove('hidden');
            overrideEl.classList.add('flex');
            document.body.classList.add('overflow-hidden');

            // focus
            setTimeout(() => ovPwdInput.focus(), 50);
        }

        function overrideClose() {
            overrideEl.classList.add('hidden');
            overrideEl.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (!overrideEl.classList.contains('hidden') && e.key === 'Escape') overrideClose();
        });

        // Close on backdrop click
        overrideEl.addEventListener('click', (e) => {
            if (e.target === overrideEl) overrideClose();
        });

        async function overrideSubmit() {
            ovErrorEl.textContent = '';
            const password = ovPwdInput.value.trim();
            if (!password) {
                ovErrorEl.textContent = 'Password is required.';
                return;
            }

            // Disable while submitting
            ovConfirmBtn.disabled = true;

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const res = await fetch(`{{ url('/projects') }}/${ovProjectId}/override-booking`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({
                        password
                    }),
                });

                if (res.status === 422) {
                    const data = await res.json();
                    ovErrorEl.textContent = data.message || 'Invalid password.';
                    return;
                }
                if (!res.ok) {
                    ovErrorEl.textContent = 'Request failed. Try again.';
                    return;
                }

                // Success → close this modal, prefetch client, open single measurement modal
                overrideClose();

                // Prefill client for the single modal
                let clientId = '',
                    clientName = '';
                try {
                    const cRes = await fetch(`{{ url('/projects') }}/${ovProjectId}/client`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (cRes.ok) {
                        const c = await cRes.json();
                        clientId = c.id || '';
                        clientName = c.name || '';
                    }
                } catch {}

                // Open your existing single modal (uses your vanilla singleOpenModal)
                singleOpenModal({
                    projectId: ovProjectId,
                    productName: ovProductName || '', // pass name if you had it
                    clientId,
                    clientName
                });

            } catch (e) {
                ovErrorEl.textContent = 'Unexpected error.';
                console.error(e);
            } finally {
                ovConfirmBtn.disabled = false;
            }
        }

        // Expose a helper that your table uses
        window.overridePrompt = ({
            projectId,
            productName = ''
        }) => overrideOpen({
            projectId,
            productName
        });
    </script>

    </x-accountant-layout>
