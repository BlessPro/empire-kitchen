<x-layouts.app>
    <x-slot name="header">
        <script src="//unpkg.com/alpinejs" defer></script>
        <style>
            [x-cloak] {
                display: none !important
            }
        </style>
        @include('admin.layouts.header')
    </x-slot>

    <main class="ml-[280px] mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen items-center">
        <div class="p-6 bg-[#F9F7F7]">

                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-bold">Bookings</h1>
                        {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
                        <!-- ADD CLIENT BUTTON -->
                        <button
                        id="openModal"
                         @click="open = true"
                            class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                            + Set Measurement
                        </button>


                    </div>
            <div class="bg-white rounded-[20px] shadow">


                <div class="flex items-center justify-between pt-5 pb-1 pl-6 pr-6">
                    <p class="text-gray-600 text-[18px] font-normal"> Manage all your Bookings here</p>

                    <form id="filterForm" method="GET" action="{{ route('admin.Bookings') }}"
                        class="flex flex-wrap items-center gap-3 mb-4">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Search by client name..."
                            class="pt-2 pb-2 pl-5 pr-5 border border-gray-300 rounded-full focus:outline-none
                             focus:ring-2 focus:ring-[#5A0562]/20"/>

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

                <div class="overflow-x-auto">
                    @include('partials.bookings-table', ['projects' => $projects])

                    <div class="mt-4 mb-5 ml-5 mr-5">
                        {{ $projects->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>


{{-- another --}}






<!-- Measure / Booking Modal (vanilla JS version) -->
<div id="measureModal"
     class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/40">
  <form action="{{ route('measurements.store') }}" method="POST" class="w-full max-w-[520px]" onclick="event.stopPropagation()">
    @csrf

    <div class="w-full p-6 bg-white shadow-xl rounded-xl">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">Schedule Measurement</h2>
        <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700">✕</button>
      </div>

      <!-- Project (BOOKED only) -->
      <label class="block mb-1 text-sm font-medium">Project</label>
      <select class="w-full px-3 py-2 mb-4 border rounded-lg"
              name="project_id"
              id="mm_project_id"
              required>
        <option value="">— Select project —</option>
        <!-- options will be injected by JS fetch -->
      </select>

      <!-- Client (readonly) -->
      <div class="mb-4">
        <label class="block mb-1 text-sm font-medium">Client</label>
        <input type="text" class="w-full px-3 py-2 border rounded-lg bg-gray-50"
               id="mm_client_name" readonly>
        <input type="hidden" name="client_id" id="mm_client_id">
      </div>

      <!-- Measurement Date & Time -->
      <div>
        <label class="block mb-1 text-sm font-medium">Measurement Date & Time</label>
        <input type="date" name="scheduled_at" class="w-full px-3 py-2 mb-4 border rounded-lg" required />
      </div>

      <div class="flex justify-end gap-2 mt-6">
        <button type="button" class="px-4 py-2 border rounded-lg" onclick="closeModal()">Cancel</button>
        <button type="submit"
                class="px-4 py-2 rounded-[10px] text-white bg-[#5A0562] disabled:opacity-50"
                id="mm_submit_btn" disabled>
          Continue
        </button>
      </div>
    </div>
  </form>
</div>


<!-- Single Project Measurement Modal (vanilla JS) -->
<div id="singleModal"
     class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/40">
  <form action="{{ route('measurements.store') }}" method="POST" class="w-full max-w-[520px]" onclick="event.stopPropagation()">
    @csrf

    <div class="w-full p-6 bg-white shadow-xl rounded-xl">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">Set Measurement</h2>
        <button type="button" onclick="singleCloseModal()" class="text-gray-500 hover:text-gray-700">✕</button>
      </div>

      <!-- Product (readonly) -->
      <div class="mb-3">
        <label class="block mb-1 text-sm font-medium">Product</label>
        <input type="text" id="sm_product_name" class="w-full px-3 py-2 border rounded-lg bg-gray-50" readonly>
      </div>

      <!-- Client (readonly) -->
      <div class="mb-3">
        <label class="block mb-1 text-sm font-medium">Client</label>
        <input type="text" id="sm_client_name" class="w-full px-3 py-2 border rounded-lg bg-gray-50" readonly>
        <input type="hidden" name="client_id" id="sm_client_id">
      </div>

      <input type="hidden" name="project_id" id="sm_project_id">

      <div class="mb-4">
        <label class="block mb-1 text-sm font-medium">Measurement Date & Time</label>
        <input type="date" name="scheduled_at" class="w-full px-3 py-2 border rounded-lg" required />
      </div>

      <div class="flex justify-end gap-2 mt-6">
        <button type="button" class="px-4 py-2 border rounded-lg" onclick="singleCloseModal()">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded-[10px] text-white bg-[#5A0562]">Save</button>
      </div>
    </div>
  </form>
</div>




<!-- Override Booking Modal -->
<div id="overrideModal"
     class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/40">
  <div class="w-full max-w-sm p-5 bg-white rounded-xl shadow-xl" onclick="event.stopPropagation()">
    <div class="flex items-center justify-between mb-3">
      <h3 class="text-lg font-semibold">Override Booking Process</h3>
      <button type="button" onclick="overrideClose()" class="text-gray-500 hover:text-gray-700">✕</button>
    </div>

    <p class="mb-3 text-sm text-gray-600">
      Entering your password will update the project from <b>UNBOOKED</b> to <b>BOOKED</b> and
      might cause an oversight on the Accountants.
    </p>

    <label class="block mb-1 text-sm font-medium">Your Password</label>
    <input type="password" id="ov_password"
           class="w-full px-3 py-2 mb-2 border rounded-lg" placeholder="Enter password" />

    <p id="ov_error" class="min-h-[18px] text-sm text-red-600"></p>

    <div class="flex justify-end gap-2 mt-2">
      <button type="button" class="px-4 py-2 border rounded-lg" onclick="overrideClose()">Cancel</button>
      <button type="button" id="ov_confirm_btn"
              class="px-4 py-2 text-white rounded-lg bg-[#5A0562]"
              onclick="overrideSubmit()">Confirm</button>
    </div>
  </div>
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
      const res = await fetch(`{{ route('projects.booked') }}`, { headers: { 'Accept':'application/json' } });
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
        const res = await fetch(`{{ url('/projects') }}/${id}/client`, { headers: { 'Accept':'application/json' } });
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
  const singleModalEl   = document.getElementById('singleModal');
  const smProjectIdEl   = document.getElementById('sm_project_id');
  const smProductNameEl = document.getElementById('sm_product_name');
  const smClientIdEl    = document.getElementById('sm_client_id');
  const smClientNameEl  = document.getElementById('sm_client_name');

  function singleOpenModal({ projectId, productName = '', clientId = '', clientName = '' }) {
    // fill fields
    smProjectIdEl.value   = projectId || '';
    smProductNameEl.value = productName || '';
    smClientIdEl.value    = clientId || '';
    smClientNameEl.value  = clientName || '';

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
  const overrideEl     = document.getElementById('overrideModal');
  const ovPwdInput     = document.getElementById('ov_password');
  const ovErrorEl      = document.getElementById('ov_error');
  const ovConfirmBtn   = document.getElementById('ov_confirm_btn');

  // Keep context to reopen the single modal with data after success
  let ovProjectId   = null;
  let ovProductName = '';  // optional; pass through from row if you have it

  function overrideOpen({ projectId, productName = '' }) {
    ovProjectId   = projectId;
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
    if (!password) { ovErrorEl.textContent = 'Password is required.'; return; }

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
        body: JSON.stringify({ password }),
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
      let clientId = '', clientName = '';
      try {
        const cRes = await fetch(`{{ url('/projects') }}/${ovProjectId}/client`, { headers: { 'Accept':'application/json' } });
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
  window.overridePrompt = ({ projectId, productName = '' }) => overrideOpen({ projectId, productName });
</script>

</x-layouts.app>
