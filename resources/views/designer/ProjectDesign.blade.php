{{-- resources/views/designer/upload.blade.php --}}
<x-Designer-layout>

  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Designer Dashboard') }}
    </h2>
    @include('admin.layouts.header')
  </x-slot>

  <main class="ml-64 mt-[50px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
    <div class="p-6 bg-[#F9F7F7]">
      <div class="mb-[20px]">

        {{-- navigation bar --}}
        <div class="flex items-center justify-between">
          <div class="flex items-center justify-between mb-6">
            <h1 class="mb-6 text-xl font-semibold">Upload Designs</h1>
          </div>

          <a href="{{ route('designer.designs.viewuploads') }}">
            <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-[10px] bg-fuchsia-900 hover:bg-[#F59E0B]">
              View Upload
            </button>
          </a>
        </div>

        <div class="w-[450px] items-center justify-center mx-auto">

          @if(session('success'))
            <div class="mb-3 text-sm text-green-700 bg-green-100 border border-green-200 rounded px-3 py-2">
              {{ session('success') }}
            </div>
          @endif

          {{-- ========== PROJECT DROPDOWN (unchanged structure) ========== --}}
          <div x-data="projectDropdown()" class="relative w-full mb-4">
            @csrf
            <label class="block mb-3 text-sm font-medium">Select the project for your design upload</label>

            <div class="relative">
              <input
                type="text"
                x-model="search"
                @focus="open = true"
                @click="open = true"
                @input="watchSearch()"
                @keydown.escape="open = false"
                @keydown.arrow-down.prevent="focusNext()"
                @keydown.arrow-up.prevent="focusPrev()"
                @keydown.enter.prevent="if (filteredProjects[focusedIndex]) selectProject(filteredProjects[focusedIndex])"
                placeholder="-- Search or select project --"
                class="w-full border-gray-200 rounded-[10px] px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              >

              <!-- Optional clear button -->
              <button type="button"
                      @click="clearSelection"
                      x-show="selectedId || search"
                      class="absolute text-xl text-gray-400 right-3 top-2 hover:text-red-500">
                &times;
              </button>

              <ul
                x-show="open"
                @click.away="open = false"
                class="absolute z-10 w-full mt-1 overflow-y-auto bg-white border border-gray-200 rounded-md shadow-lg max-h-60"
              >
                <template x-for="(project, index) in filteredProjects" :key="project.id">
                  <li
                    :class="{'bg-blue-100': index === focusedIndex}"
                    @click="selectProject(project)"
                    @mouseenter="focusedIndex = index"
                    class="px-4 py-2 cursor-pointer hover:bg-blue-100"
                    x-text="project.name"
                  ></li>
                </template>
                <li x-show="filteredProjects.length === 0" class="px-4 py-2 text-gray-500">No projects found.</li>
              </ul>

              <!-- Hidden input (kept here for your UI logic) -->
              <input type="hidden" id="project_id_dropdown_hidden" name="project_id_dropdown" :value="selectedId">
            </div>
          </div>

          {{-- ========== FORM (kept) ========== --}}
          <form id="designUploadForm" action="{{ route('design.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- real project_id inside the form. We sync it from the dropdown via tiny JS -->
            <input type="hidden" id="project_id_form" name="project_id" value="">

            <div class="border-dashed border-2 border-gray-300 p-[40px] text-center rounded-[10px] mb-5  bg-white">
              <input type="file" name="images[]" id="images" class="hidden" multiple required accept=".svg,.jpg,.jpeg,.png">
              <label for="images" class="items-center cursor-pointer">
                <div class="mb-5 font-bold text-purple-700">Click here</div>
                <div class="mb-2 text-sm text-gray-500">to upload your file or drag.</div>
                <div class="mt-1 text-xs">Supported Format: SVG, JPG, PNG (10mb each)</div>
              </label>
            </div>

            <!-- PROGRESS CARD (now shows on file-pick; not on submit) -->
            {{-- <div id="progressCard" class="hidden w-full bg-[#000] text-white rounded-2xl p-4 mb-4">
              <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                  <span class="inline-flex h-6 w-6 rounded-full bg-green-500/15 items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                  </span>
                  <span id="progressFilename" class="text-black text-sm opacity-90">Preparing…</span>
                </div>
                <span id="progressPercentText" class="text-black text-sm opacity-90">0%</span>
              </div>

              <div class="h-3 bg-gray-700 rounded-full overflow-hidden">
                <div id="progressBar" class="h-3 bg-green-500 rounded-full transition-all duration-200" style="width:0%"></div>
              </div>
              <div id="progressStatus" class="mt-2 text-xs opacity-90">Preparing files…</div>
            </div> --}}


<div id="progressCard" class="hidden w-full rounded-2xl p-4 mb-4 bg-gradient-to-br from-gray-900 to-gray-800 text-white shadow-lg">

    <div class="flex items-center justify-between mb-2">
    <div class="flex items-center gap-3">
      <span class="inline-flex h-6 w-6 rounded-full bg-white/10 ring-1 ring-white/20 items-center justify-center">
        <!-- icon -->
      </span>
      <div class="flex flex-col">
        <span id="progressFilename" class="text-sm font-medium">Preparing…</span>
        <span id="progressMeta" class="text-[11px] text-white/70">0 file • 0 MB</span>
      </div>
    </div>
    <span id="progressPercentText" class="text-sm font-medium">0%</span>
  </div>
  <div class="h-3 bg-white/10 rounded-full overflow-hidden ring-1 ring-white/10">
    <div id="progressBar" class="h-3 rounded-full transition-all duration-200" style="width:0%; background:linear-gradient(90deg,#A78BFA,#22D3EE)"></div>
  </div>
  <div id="progressStatus" class="mt-2 text-xs text-white/80">Preparing files…</div>
</div>



<!-- PROGRESS CARD (shows right after file selection; ready to submit when 100%) -->
{{-- <div id="progressCard" class="hidden w-full rounded-2xl p-4 mb-4 bg-gradient-to-br from-gray-900 to-gray-800 text-white shadow-lg">
  <div class="flex items-center justify-between mb-2">
    <div class="flex items-center gap-3">
      <span class="inline-flex h-6 w-6 rounded-full bg-white/10 ring-1 ring-white/20 items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M16 12l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
      </span>
      <div class="flex flex-col">
        <span id="progressFilename" class="text-sm font-medium">Preparing…</span>
        <span id="progressMeta" class="text-[11px] text-white/70">0 file • 0 MB</span>
      </div>
    </div>
    <span id="progressPercentText" class="text-sm font-medium">0%</span>
  </div>

  <div class="h-3 bg-white/10 rounded-full overflow-hidden ring-1 ring-white/10">
    <div id="progressBar" class="h-3 rounded-full transition-all duration-200" style="width:0%; background:linear-gradient(90deg,#A78BFA,#22D3EE)"></div>
  </div>

  <div id="progressStatus" class="mt-2 text-xs text-white/80">Preparing files…</div>
</div> --}}







            <div>
              <label class="block mb-2 text-sm font-medium">Description (if any)</label>
              <textarea name="notes" rows="6" placeholder="Start typing here" class="w-full border-gray-200 rounded-[10px] px-4 py-2 bg-white"></textarea>
            </div>

            <div class="flex items-center justify-center mx-auto mt-4 text-center">
              <button class="bg-fuchsia-900 hover:bg-purple-800 text-white px-6 py-2 rounded-[10px] flex items-center justify-center space-x-2"
                      type="submit">
                <span>Submit Design</span>
              </button>
            </div>
          </form>

          <!-- SINGLE POPUP: INVOICE MODAL (shows ONLY after submit success) -->
          <div id="invoiceModal" class="hidden fixed inset-0 z-40 items-center justify-center bg-black/40">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
              <div class="flex items-start justify-between">
                <div class="flex items-center gap-2">
                  <span class="inline-flex h-6 w-6 rounded-full bg-purple-100 items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-700" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-7.25 7.25a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L8.5 11.086l6.543-6.543a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                  </span>
                  <h3 class="text-lg font-semibold">Your file has been successfully uploaded.</h3>
                </div>
                <button class="text-gray-400 hover:text-gray-600" id="invoiceCloseBtn">✕</button>
              </div>

              <p class="text-sm text-gray-600 mt-2">
                Do you want to create an invoice now?
              </p>

              <div class="flex items-center justify-end gap-3 mt-6">
                <button id="invoiceCancelBtn"
                        class="px-4 py-2 rounded-xl border border-gray-300 hover:bg-gray-50">
                  Cancel
                </button>

                {{-- You will wire this link to your real invoice route --}}
                <a href="{{ route('invoices.create') }}"
                   class="px-4 py-2 rounded-xl bg-fuchsia-900 text-white hover:bg-purple-800">
                  Create Invoice
                </a>
              </div>
            </div>
          </div>

        </div> {{-- /container --}}
      </div>
    </div>
  </main>

<script>
  // Alpine dropdown (unchanged; sync hidden project_id inside the form)
  function projectDropdown() {
    return {
      open: false,
      search: '',
      selectedId: '',
      selectedName: '',
      focusedIndex: -1,
      projects: @json($projects ?? []),

      get filteredProjects() {
        const term = (this.search || '').toLowerCase();
        return (this.projects || []).filter(p => (p.name || '').toLowerCase().includes(term));
      },

      selectProject(project) {
        this.selectedId   = project.id;
        this.selectedName = project.name;
        this.search       = project.name;
        this.open         = false;
        const formHidden = document.getElementById('project_id_form');
        if (formHidden) formHidden.value = project.id;
      },

      watchSearch() {
        if (this.search === '') {
          this.open = true;
          this.selectedId = '';
          this.selectedName = '';
          const formHidden = document.getElementById('project_id_form');
          if (formHidden) formHidden.value = '';
        }
      },

      clearSelection() {
        this.search = '';
        this.selectedId = '';
        this.selectedName = '';
        this.open = true;
        this.focusedIndex = -1;
        const formHidden = document.getElementById('project_id_form');
        if (formHidden) formHidden.value = '';
      },

      focusNext() { if (this.focusedIndex < this.filteredProjects.length - 1) this.focusedIndex++; },
      focusPrev() { if (this.focusedIndex > 0) this.focusedIndex--; }
    }
  }

  (function () {
    // Run after DOM is ready no matter where this script sits
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', init);
    } else {
      init();
    }

    function init() {
      const form        = document.getElementById('designUploadForm');
      if (!form) return;

      const filesInput  = document.getElementById('images');
      const projectIn   = document.getElementById('project_id_form');

      const card        = document.getElementById('progressCard');
      const bar         = document.getElementById('progressBar');
      const pctText     = document.getElementById('progressPercentText');
      const statusText  = document.getElementById('progressStatus');
      const fileNameLbl = document.getElementById('progressFilename');
      const progressMeta= document.getElementById('progressMeta'); // optional

      const invoiceModal     = document.getElementById('invoiceModal');
      const invoiceCancelBtn = document.getElementById('invoiceCancelBtn');
      const invoiceCloseBtn  = document.getElementById('invoiceCloseBtn');

      // Show/hide helpers
      const showBlock = el => { if (!el) return; el.classList.remove('hidden'); el.style.display = 'block'; };
      const hideBlock = el => { if (!el) return; el.style.display = 'none'; el.classList.add('hidden'); };
      const showFlex  = el => { if (!el) return; el.classList.remove('hidden'); el.style.display = 'flex'; };
      const hideFlex  = el => { if (!el) return; el.style.display = 'none'; el.classList.add('hidden'); };

      // Cancel/Close -> reload the page
      if (invoiceCancelBtn) invoiceCancelBtn.addEventListener('click', () => { hideFlex(invoiceModal); window.location.reload(); });
      if (invoiceCloseBtn)  invoiceCloseBtn.addEventListener('click', () => { hideFlex(invoiceModal); window.location.reload(); });

      // Progress animation (file pick)
      let prepRafId = null;
      function startPrepProgress(fileList) {
        if (!fileList || fileList.length === 0) { hideBlock(card); return; }

        // Cancel any previous animation
        if (prepRafId) { cancelAnimationFrame(prepRafId); prepRafId = null; }

        // Update filename + meta
        if (fileNameLbl) fileNameLbl.textContent = fileList.length === 1 ? fileList[0].name : `${fileList.length} files`;
        if (progressMeta) {
          const totalSizeMB = (Array.from(fileList).reduce((s, f) => s + (f.size || 0), 0) / (1024 * 1024)).toFixed(1);
          progressMeta.textContent = `${fileList.length} file${fileList.length > 1 ? 's' : ''} • ${totalSizeMB} MB`;
        }

        // Reset visuals and SHOW the card
        if (bar)      bar.style.width = '1%';
        if (pctText)  pctText.textContent = '1%';
        if (statusText) statusText.textContent = 'Preparing files…';
        showBlock(card);

        // Animate to 100%
        const totalSizeMBRaw = Array.from(fileList).reduce((s, f) => s + (f.size || 0), 0) / (1024 * 1024);
        const duration = Math.min(2000, 800 + Math.round(totalSizeMBRaw * 150)); // 0.8s + ~150ms/MB (cap 2s)
        const start = performance.now();

        const step = (ts) => {
          const elapsed = ts - start;
          const pct = Math.min(100, Math.max(1, Math.round((elapsed / duration) * 100)));
          if (bar)      bar.style.width = pct + '%';
          if (pctText)  pctText.textContent = pct + '%';
          if (statusText) statusText.textContent = pct < 100 ? 'Preparing files…' : 'Ready to submit';
          if (pct < 100) { prepRafId = requestAnimationFrame(step); } else { prepRafId = null; }
        };
        prepRafId = requestAnimationFrame(step);
      }

      // Listen to direct change on the input
      if (filesInput) {
        filesInput.addEventListener('change', function () {
          startPrepProgress(this.files);
        });
      }

      // Also listen in a delegated way (in case the input gets re-rendered)
      document.addEventListener('change', function (e) {
        if (e.target && e.target.id === 'images' && e.target.files) {
          startPrepProgress(e.target.files);
        }
      }, true);

      // Submit: upload to server (no progress update here), then show ONLY invoice modal on success
      form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!projectIn || !projectIn.value) { alert('Please select a project.'); return; }
        if (!filesInput || !filesInput.files || filesInput.files.length === 0) { alert('Please choose at least one file.'); return; }

        const fd = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', form.getAttribute('action'), true);

        xhr.onload = function () {
          if (xhr.status >= 200 && xhr.status < 300) {
            showFlex(invoiceModal); // only popup after successful submit
          } else {
            // fallback to normal submit to preserve original behavior on non-2xx
            form.submit();
          }
        };

        xhr.onerror = function () {
          form.submit();
        };

        xhr.send(fd);
      }, { passive: false });
    }
  })();
</script>


</x-Designer-layout>
