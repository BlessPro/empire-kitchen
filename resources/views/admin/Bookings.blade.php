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

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen items-center">
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

<!-- Measure / Booking Modal -->
<div id="measureModal"
     class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40"
     x-data="{
        clientId: '',
        projectId: '',
        projects: [],
        loading: false,
        async loadProjects() {
          this.projects = [];
          this.projectId = '';
          if (!this.clientId) { return; }
          this.loading = true;
          try {
            const res = await fetch(`{{ url('/clients') }}/${this.clientId}/projects`, {
              headers: { 'Accept':'application/json' }
            });
            if (!res.ok) { console.error('Fetch failed', res.status); return; }
            this.projects = await res.json();
          } catch (e) {
            console.error(e);
            this.projects = [];
          } finally {
            this.loading = false;
          }
        }
     }"
     x-cloak>

  <form action="{{ route('measurements.store') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-[520px]">
    @csrf

    <div class="w-full p-6 bg-white shadow-xl rounded-xl" @click.stop>
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">Schedule Measurement</h2>
        <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700">✕</button>
      </div>

      {{-- Client select --}}
      <label class="block mb-1 text-sm font-medium">Client</label>
      <select class="w-full px-3 py-2 mb-4 border rounded-lg"
              name="client_id"
              x-model="clientId"
              @change="loadProjects()"
              required>
        <option value="">— Select client —</option>
        @foreach($clients as $c)
          <option value="{{ $c->id }}">{{ $c->name ?? ($c->firstname.' '.$c->lastname) }}</option>
        @endforeach
      </select>

      {{-- Project select (populated via JSON) --}}
      <label class="block mb-1 text-sm font-medium">Project</label>
      <select class="w-full px-3 py-2 mb-2 border rounded-lg"
              name="project_id"
              x-model="projectId"
              :disabled="!projects.length"
              required>
        <option value="" x-show="!projects.length && !loading">— No projects —</option>
        <option value="" x-show="loading">Loading…</option>
        <template x-for="p in projects" :key="p.id">
          <option :value="p.id" x-text="p.name"></option>
        </template>
      </select>

      <div>
        <label class="block mb-1 text-sm font-medium">Measurement Date & Time</label>
        {{-- if you only want date, change to type="date" and keep name="scheduled_at" --}}
        <input type="datetime-local"
               id="start_time"
               name="scheduled_at"
               class="w-full px-3 py-2 mb-4 border rounded-lg"
               required />
      </div>

      {{-- optional notes --}}
      {{-- <textarea name="notes" class="w-full px-3 py-2 mb-2 border rounded-lg" placeholder="Notes (optional)"></textarea> --}}

      <div class="flex justify-end gap-2 mt-6">
        <button type="button" class="px-4 py-2 border rounded-lg" onclick="closeModal()">Cancel</button>
        <button type="submit"
                class="w-full px-4 py-2 rounded-[10px] text-white bg-[#5A0562] disabled:opacity-50"
                :disabled="!clientId || !projectId">
          Continue
        </button>
      </div>
    </div>
  </form>
</div>

{{-- <script>
  function closeModal() {
    document.getElementById('measureModal').classList.add('hidden');
  }
  // your openModal() should remove 'hidden' as you already do elsewhere
</script> --}}


            <!-- Measure / Booking Modal -->

<script>
  function openModal(){ const m=document.getElementById('measureModal'); m.classList.remove('hidden'); m.classList.add('flex'); }
  function closeModal(){ const m=document.getElementById('measureModal'); m.classList.add('hidden'); m.classList.remove('flex'); }
</script>


<script>
  const modal = document.getElementById('measureModal');
  const openBtn = document.getElementById('openModal');
  const closeBtn = document.getElementById('closeModal');

  function openModal() {
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  }
  function closeModal() {
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }

  openBtn?.addEventListener('click', openModal);
  closeBtn?.addEventListener('click', closeModal);

  // Close on ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
  });

  // Close on backdrop click
  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
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

</x-layouts.app>
