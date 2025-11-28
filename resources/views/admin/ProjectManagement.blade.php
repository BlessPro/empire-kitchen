<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')
        <style>
            [x-cloak] {
                display: none !important
            }
        </style>
        <script src="//unpkg.com/alpinejs" defer></script>

    </x-slot>

    <div x-data="{ addOpen: false }">
    <main>
        <div class="p-3 sm:p-4">
            {{-- Top bar --}}
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Project Management</h1>
                <button @click="addOpen = true"
                        class="px-6 py-2 text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                    + Add Project
                </button>
            </div>

            {{-- Simple filter row (optional – uses $clients) --}}
            <div class="flex items-center justify-between mb-6">
                <form id="filterForm" method="GET" action="{{ route('admin.ProjectManagement.filter') }}"
                    class="flex gap-3">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        placeholder="Search projects..." class="pt-2 pb-2 pl-5 pr-5 border-gray-300 rounded-full" />
                    <select name="location" id="locationSelect"
                        class="pt-2 pb-2 pl-5 pr-5 border-gray-300 rounded-full">
                        <option value="">All Locations</option>
                        @foreach (($projectLocations ?? collect()) as $location)
                            <option value="{{ $location }}" @selected(request('location') == $location)>{{ $location }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            {{-- Columns --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                {{-- Measurement --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#F59E0B]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 id="measurementCount" class="px-[10px] py-[10px] text-black">
                                {{ ($measurements ?? collect())->count() }}
                            </h5>
                        </span>
                        Measurement
                    </div>
                    <div id="measurementList" class="pt-2 space-y-5">
                        @include('admin.partials.project-stage-cards', [
                            'projects' => $measurements ?? collect(),
                            'emptyMessage' => 'No project is currently under measurement',
                        ])

                    </div>

                </div>

                {{-- Design --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#4F46E5]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 id="designCount" class="px-[10px] py-[10px] text-black">
                                {{ ($designs ?? collect())->count() }}
                            </h5>
                        </span>
                        Design
                    </div>
                    <div id="designList" class="pt-2 space-y-5">
                        @include('admin.partials.project-stage-cards', [
                            'projects' => $designs ?? collect(),
                            'emptyMessage' => 'No project is currently in design',
                        ])

                    </div>
                </div>

                {{-- Production --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#22C55E]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 id="productionCount" class="px-[10px] py-[10px] text-black">
                                {{ ($productions ?? collect())->count() }}
                            </h5>
                        </span>
                        Production
                    </div>



                <div id="productionList" class="pt-2 space-y-5">
                        @include('admin.partials.project-stage-cards', [
                            'projects' => $productions ?? collect(),
                            'emptyMessage' => 'No project is currently in production',
                        ])

                    </div>

                </div>

                {{-- Installation --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center py-2 pl-2 pr-5 text-white rounded-full bg-fuchsia-500">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 id="installationCount" class="px-[10px] py-[10px] text-black">
                                {{ ($installations ?? collect())->count() }}
                            </h5>
                        </span>
                        Installation
                    </div>


                <div id="installationList" class="pt-2 space-y-5">
                        @include('admin.partials.project-stage-cards', [
                            'projects' => $installations ?? collect(),
                            'emptyMessage' => 'No project is currently in installation',
                        ])

                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- Quick add project modal --}}
    <div x-show="addOpen" x-cloak
         class="fixed inset-0 z-[120] flex items-center justify-center bg-black/50"
         @keydown.escape.window="addOpen = false">
        <div class="w-full max-w-md px-5 py-6 bg-white rounded-2xl shadow-xl"
             @click.stop>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Add Project</h2>
                <button type="button" class="text-xl text-gray-500 hover:text-gray-700"
                        @click="addOpen = false">&times;</button>
            </div>

            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Project name</label>
                        <input type="text" name="project[name]" required
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-200 focus:border-fuchsia-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                        <select name="project[client_id]" required
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-200 focus:border-fuchsia-500">
                            <option value="">Select client</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}">{{ trim($c->firstname . ' ' . ($c->lastname ?? '')) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" name="project[location]"
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-200 focus:border-fuchsia-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                        <input type="date" name="project[due_date]"
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-200 focus:border-fuchsia-500">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button"
                            class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50"
                            @click="addOpen = false">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-5 py-2 text-white rounded-lg bg-fuchsia-900 hover:bg-[#F59E0B]">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    </div>


    <style>
        [x-cloak] {
            display: none !important
        }
    </style>

    <div id="assignModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40">
        <div class="relative w-full max-w-md p-6 bg-white rounded-2xl">
            {{-- Top controls (badge left, close right) --}}
            <div class="flex items-start justify-between mb-4">
                {{-- <span class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 rounded-full">
        <iconify-icon icon="mdi:account-badge-outline" class="text-xl text-purple-700"></iconify-icon>
      </span> --}}
                <div>
                    <h2 class="text-lg font-semibold">Assign Technical Supervisor</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        For: <span id="assignProjectName" class="font-medium"></span>
                    </p>
                </div>
                <button type="button" id="assignClose"
                    class="text-2xl leading-none text-slate-500 hover:text-slate-700"
                    aria-label="Close">&times;</button>
            </div>



            <form id="assignForm" class="mt-4 space-y-4" method="POST"
                action="{{ route('tech.assignSupervisor') }}">
                @csrf
                <input type="hidden" name="project_id" id="assignProjectId">
                <input type="hidden" name="supervisor_id" id="assignSupervisorId">

                <div id="assignList" class="max-h-[360px] overflow-y-auto border border-gray-100 rounded-xl divide-y">
                    @foreach ($techSupervisors as $sup)
                        @php
                            $displayName = $sup->employee->name ?? ($sup->name ?? '—');
                            $avatar = $sup->employee?->avatar_path
                                ? asset('storage/' . $sup->employee->avatar_path)
                                : asset('images/default-avatar.png');
                            $assignedTo = $supervisorAssignments[$sup->id] ?? null; // project name if already assigned elsewhere
                        @endphp

                        <label class="block cursor-pointer assign-row" data-id="{{ $sup->id }}">
                            <input type="radio" class="sr-only" name="pick" value="{{ $sup->id }}">
                            <div class="flex items-center gap-3 p-3 hover:bg-gray-50">
                                <img src="{{ $avatar }}" alt=""
                                    class="object-cover w-10 h-10 rounded-full">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-800">{{ $displayName }}</div>
                                </div>

                                @if ($assignedTo)
                                    <span class="ml-2 text-xs px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">
                                        Assigned: {{ $assignedTo }}
                                    </span>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    {{-- <button type="button" id="assignCancel" class="px-4 py-2 border rounded-lg">Cancel</button> --}}
                    <button type="submit" id="assignSubmit"
                        class="w-full px-4 py-2 text-white rounded-lg bg-fuchsia-900 hover:bg-purple-800">
                        Proceed
                    </button>
                </div>
            </form>
        </div>
    </div>

   

@include('admin.partials.add-product')

    <!-- Project action modal -->
    <div id="projectActionModal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
        <div class="w-full max-w-sm p-5 bg-white rounded-xl shadow-lg">
            <h3 id="projectActionTitle" class="mb-2 text-lg font-semibold text-gray-800">Confirm</h3>
            <p id="projectActionMessage" class="mb-4 text-sm text-gray-600"></p>
            <input id="projectActionInput"
                   type="text"
                   class="hidden w-full mb-4 px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5A0562]" />
            <div class="flex justify-end gap-3">
                <button type="button"
                        id="projectActionCancel"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">
                    Cancel
                </button>
                <button type="button"
                        id="projectActionConfirm"
                        class="px-4 py-2 text-sm text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('projectActionModal');
            const titleEl = document.getElementById('projectActionTitle');
            const msgEl = document.getElementById('projectActionMessage');
            const inputEl = document.getElementById('projectActionInput');
            const cancelBtn = document.getElementById('projectActionCancel');
            const confirmBtn = document.getElementById('projectActionConfirm');
            let resolver = null;

            function openModal(options) {
                const opts = options || {};
                titleEl.textContent = opts.title || 'Confirm';
                msgEl.textContent = opts.message || '';

                if (opts.showInput) {
                    inputEl.classList.remove('hidden');
                    inputEl.value = opts.defaultValue || '';
                    setTimeout(() => {
                        inputEl.focus();
                        inputEl.select();
                    }, 0);
                } else {
                    inputEl.classList.add('hidden');
                    inputEl.value = '';
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                return new Promise((resolve) => {
                    resolver = resolve;
                });
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                resolver = null;
            }

            cancelBtn?.addEventListener('click', () => {
                if (resolver) resolver({ confirmed: false, value: null });
                closeModal();
            });

            confirmBtn?.addEventListener('click', () => {
                const value = inputEl.value;
                if (resolver) resolver({ confirmed: true, value });
                closeModal();
            });

            modal?.addEventListener('click', (e) => {
                if (e.target === modal) {
                    if (resolver) resolver({ confirmed: false, value: null });
                    closeModal();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    if (resolver) resolver({ confirmed: false, value: null });
                    closeModal();
                }
            });

            window.duplicateProject = async function (id) {
                const { confirmed } = await openModal({
                    title: 'Duplicate project',
                    message: 'Create a copy of this project and all its products?',
                });
                if (!confirmed) return;

                const res = await fetch(`{{ url('/admin/projects') }}/${id}/duplicate`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'text/html',
                    },
                    credentials: 'same-origin',
                });
                if (res.redirected) {
                    window.location = res.url;
                } else {
                    location.reload();
                }
            };

            window.renameProject = async function (id, currentName) {
                const { confirmed, value } = await openModal({
                    title: 'Rename project',
                    message: 'Enter a new name for this project.',
                    showInput: true,
                    defaultValue: currentName || '',
                });

                const newName = (value || '').trim();
                if (!confirmed || !newName || newName === currentName) return;

                const res = await fetch(`{{ url('/admin/projects') }}/${id}/name`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ name: newName }),
                });

                if (res.ok) {
                    location.reload();
                } else {
                    await openModal({
                        title: 'Error',
                        message: 'Could not rename project.',
                    });
                }
            };

            window.deleteProject = async function (id) {
                const { confirmed } = await openModal({
                    title: 'Delete project',
                    message: 'Are you sure you want to delete this project? This action cannot be undone.',
                });
                if (!confirmed) return;

                const res = await fetch(`{{ url('/admin/dashboard/projects') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'text/html',
                    },
                    credentials: 'same-origin',
                });

                if (res.redirected) {
                    window.location = res.url;
                } else {
                    location.reload();
                }
            };
        })();
    </script>
@include('admin.partials.add-products-js')


    <script>
        document.addEventListener('click', (e) => {
            // If click was inside something marked data-no-nav, do nothing
            if (e.target.closest('[data-no-nav]')) return;

            // Card click → navigate
            const card = e.target.closest('.project-card[data-href]');
            if (card) {
                window.location.href = card.getAttribute('data-href');
            }
        });

        // 3-dot menu toggle
        document.querySelectorAll('[data-more-trigger]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation(); // don’t bubble to card
                const id = btn.getAttribute('data-project');
                const menu = document.querySelector(`[data-more-menu][data-project="${id}"]`);
                document.querySelectorAll('[data-more-menu]').forEach(m => {
                    if (m !== menu) m.classList.add('hidden');
                });
                menu?.classList.toggle('hidden');
            });
        });

        // Close menus on outside click or ESC
        document.addEventListener('click', () => {
            document.querySelectorAll('[data-more-menu]').forEach(m => m.classList.add('hidden'));
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') document.querySelectorAll('[data-more-menu]').forEach(m => m.classList.add(
                'hidden'));
        });
    </script>



    <script>
        (function() {
            const modal = document.getElementById('assignModal');
            const form = document.getElementById('assignForm');
            const closeBtn = document.getElementById('assignClose');
            const cancel = document.getElementById('assignCancel');
            const list = document.getElementById('assignList');

            const fieldProjectId = document.getElementById('assignProjectId');
            const fieldProjName = document.getElementById('assignProjectName');
            const fieldSupId = document.getElementById('assignSupervisorId');

            function showModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }

            function hideModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
                // clear selection
                list.querySelectorAll('input[name="pick"]').forEach(r => r.checked = false);
                fieldSupId.value = '';
            }

            // Open from any .assign-trigger (event delegation)
            document.addEventListener('click', (e) => {
                const t = e.target.closest('.assign-trigger');
                if (!t) return;

                e.preventDefault();

                const pid = t.getAttribute('data-project-id');
                const pname = t.getAttribute('data-project-name') || '';
                const current = t.getAttribute('data-current-id') || '';

                fieldProjectId.value = pid;
                fieldProjName.textContent = pname;

                // preselect current supervisor if any
                if (current) {
                    const radio = list.querySelector(`input[name="pick"][value="${current}"]`);
                    if (radio) {
                        radio.checked = true;
                        fieldSupId.value = String(current);
                    } else {
                        fieldSupId.value = '';
                    }
                } else {
                    fieldSupId.value = '';
                }

                // If inside a dropdown, close it
                t.closest('[data-more-menu]')?.classList.add('hidden');

                showModal();
            });

            // Clicking a row sets selection + hidden field
            list.addEventListener('click', (e) => {
                const row = e.target.closest('.assign-row');
                if (!row) return;
                const id = row.getAttribute('data-id');
                const radio = row.querySelector('input[name="pick"]');
                if (radio) {
                    radio.checked = true;
                    fieldSupId.value = id;
                }
            });

            // Close actions
            closeBtn.addEventListener('click', hideModal);
            cancel.addEventListener('click', hideModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) hideModal();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) hideModal();
            });

            // Guard submit
            form.addEventListener('submit', (e) => {
                if (!fieldSupId.value) {
                    e.preventDefault();
                    alert('Please choose a supervisor.');
                }
            });
        })();
    </script>

    {{-- Page JS (single, consolidated) --}}
    <script>
        if (window.feather) feather.replace();

        // Close modal
        function closeTechModal() {
            const m = document.getElementById('assignTechModal222');
            m.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Open + fetch supervisors
        async function openTechModal(projectId, projectName) {
            const m = document.getElementById('assignTechModal222');
            const list = document.getElementById('supervisorList');
            const projectIdInput = document.getElementById('projectIdInput');
            const projectNameInput = document.getElementById('projectNameInput');
            const supervisorIdInput = document.getElementById('supervisorIdInput');

            // reset header/fields
            projectIdInput.value = projectId || '';
            projectNameInput.value = projectName || '';
            supervisorIdInput.value = '';

            // show modal
            m.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // loading
            list.innerHTML = `<div class="px-3 py-2 text-sm text-gray-500">Loading…</div>`;

            //   const url = `{{ url('/admin/projects') }}/${projectId}/supervisors`;
            const url = "{{ route('admin.projects.supervisors', ':id') }}".replace(':id', projectId);
            //   const url = `{{ url('/admin/projects') }}/${projectId}/supervisors`;

            try {
                const res = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) {
                    const text = await res.text();
                    console.error('Supervisors fetch failed:', res.status, text);
                    throw new Error(`HTTP ${res.status}`);
                }
                const data = await res.json();

                list.innerHTML = (data.supervisors || []).map(s => {
                    const badge = s.is_assigned_here ?
                        `<span class="ml-auto text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Assigned here</span>` :
                        (s.assigned_elsewhere ?
                            `<span class="ml-auto text-xs px-2 py-0.5 rounded-full bg-amber-100 text-amber-700" title="Assigned to ${s.assigned_project_name ?? 'another project'}">Assigned</span>` :
                            '');
                    return `
            <label class="block cursor-pointer">
              <input type="radio" name="supervisor_pick" value="${s.id}" class="sr-only peer">
              <div class="flex items-center gap-3 p-3 transition border-b border-gray-200 hover:bg-gray-50 peer-checked:border-2 peer-checked:border-fuchsia-800 peer-checked:rounded-xl">
                <img src="${s.avatar_url}" class="object-cover w-12 h-12 rounded-full" alt="">
                <span class="font-medium text-gray-800">${s.name}</span>
                ${badge}
              </div>
            </label>
          `;
                }).join('') || `<div class="px-3 py-2 text-sm text-gray-500">No supervisors found.</div>`;

                // auto-select current assignee
                const current = (data.supervisors || []).find(s => s.is_assigned_here);
                if (current) {
                    const radio = list.querySelector(`input[name="supervisor_pick"][value="${current.id}"]`);
                    if (radio) {
                        radio.checked = true;
                        supervisorIdInput.value = String(current.id);
                    }
                }

                // bind change once
                list.addEventListener('change', (e) => {
                    if (e.target && e.target.name === 'supervisor_pick') {
                        supervisorIdInput.value = e.target.value;
                    }
                }, {
                    once: true
                });

            } catch (err) {
                list.innerHTML = `<div class="px-3 py-2 text-sm text-red-600">Failed to load supervisors.</div>`;
            }
        }



        // Delegation for menus and assign action
        document.addEventListener('click', (e) => {
            // open/close a project's 3-dot menu
            const btn = e.target.closest('[data-more-trigger]');
            if (btn) {
                e.preventDefault();
                const pid = btn.getAttribute('data-project');
                const menu = document.querySelector(`[data-more-menu][data-project="${pid}"]`);
                if (menu) menu.classList.toggle('hidden');
                return;
            }

            // clicking outside any open menu closes it
            const openMenus = document.querySelectorAll('[data-more-menu]:not(.hidden)');
            if (openMenus.length && !e.target.closest('[data-more-menu]') && !e.target.closest(
                    '[data-more-trigger]')) {
                openMenus.forEach(m => m.classList.add('hidden'));
            }

            // Assign Supervisor trigger
            const a = e.target.closest('.assign-tech-trigger');
            if (a) {
                e.preventDefault();
                const id = a.dataset.projectId;
                const name = a.dataset.projectName || '';
                if (!id) return;
                openTechModal(id, name);
                const menu = a.closest('[data-more-menu]');
                if (menu) menu.classList.add('hidden');
            }
        });

        // Simple filter auto-submit (optional)
        (function wireFilters() {
            const f = document.getElementById('filterForm');
            if (!f) return;
            const si = f.querySelector('#searchInput');
            const sl = f.querySelector('#locationSelect');
            const endpoint = f.getAttribute('action');

            const lists = {
                measurement: document.getElementById('measurementList'),
                design: document.getElementById('designList'),
                production: document.getElementById('productionList'),
                installation: document.getElementById('installationList'),
            };

            const counts = {
                measurement: document.getElementById('measurementCount'),
                design: document.getElementById('designCount'),
                production: document.getElementById('productionCount'),
                installation: document.getElementById('installationCount'),
            };

            let controller;
            let timer;

            const applyFilters = () => {
                if (!endpoint) return;

                if (controller) {
                    controller.abort();
                }
                controller = new AbortController();

                const params = new URLSearchParams(new FormData(f));
                const url = `${endpoint}?${params.toString()}`;

                fetch(url, {
                    headers: { 'Accept': 'application/json' },
                    signal: controller.signal,
                })
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(`Request failed with status ${res.status}`);
                        }
                        return res.json();
                    })
                    .then(data => {
                        (['measurement', 'design', 'production', 'installation']).forEach(stage => {
                            if (lists[stage] && data[stage] !== undefined) {
                                lists[stage].innerHTML = data[stage];
                            }
                            if (counts[stage] && data.counts && data.counts[stage] !== undefined) {
                                counts[stage].textContent = data.counts[stage];
                            }
                        });
                    })
                    .catch(err => {
                        if (err.name === 'AbortError') return;
                        console.error('Project filter request failed', err);
                    });
            };

            const debouncedFilters = () => {
                clearTimeout(timer);
                timer = setTimeout(applyFilters, 300);
            };

            f.addEventListener('submit', (event) => {
                event.preventDefault();
                applyFilters();
            });

            si?.addEventListener('input', debouncedFilters);
            sl?.addEventListener('change', applyFilters);
        })();
    </script>


    <script>
        (function() {
            // ======= More menu toggle =======
            document.addEventListener('click', (e) => {
                // open/close a menu
                const btn = e.target.closest('.more-trigger');
                if (btn) {
                    e.stopPropagation();
                    const pid = btn.getAttribute('data-project');
                    // close others
                    document.querySelectorAll('.more-menu').forEach(m => m.classList.add('hidden'));
                    // toggle this one
                    const menu = document.querySelector(`.more-menu[data-project="${pid}"]`);
                    if (menu) menu.classList.toggle('hidden');
                    return;
                }

                // click inside a menu shouldn't bubble to card navigation
                if (e.target.closest('.more-menu')) {
                    e.stopPropagation();
                    return;
                }

                // click outside → close all menus
                document.querySelectorAll('.more-menu').forEach(m => m.classList.add('hidden'));
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.more-menu').forEach(m => m.classList.add('hidden'));
                }
            });

            // ======= Assign modal wiring (uses the existing #assignModal + form) =======
            const modal = document.getElementById('assignModal');
            const form = document.getElementById('assignForm');
            const closeX = document.getElementById('assignClose');
            const cancel = document.getElementById('assignCancel'); // may be absent
            const list = document.getElementById('assignList'); // radios list
            const fldPid = document.getElementById('assignProjectId');
            const fldPnm = document.getElementById('assignProjectName');
            const fldSid = document.getElementById('assignSupervisorId');

            function showModal() {
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }

            function hideModal() {
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
                if (list) list.querySelectorAll('input[name="pick"]').forEach(r => r.checked = false);
                if (fldSid) fldSid.value = '';
            }

            // open from menu item
            document.addEventListener('click', (e) => {
                const a = e.target.closest('.assign-trigger');
                if (!a) return;

                e.preventDefault();
                e.stopPropagation();
                // close any open menu
                document.querySelectorAll('.more-menu').forEach(m => m.classList.add('hidden'));

                const pid = a.getAttribute('data-project-id') || '';
                const pname = a.getAttribute('data-project-name') || '';
                const curId = a.getAttribute('data-current-id') || '';

                if (fldPid) fldPid.value = pid;
                if (fldPnm) fldPnm.textContent = pname;

                if (curId && list) {
                    const radio = list.querySelector(`input[name="pick"][value="${curId}"]`);
                    if (radio) {
                        radio.checked = true;
                        if (fldSid) fldSid.value = String(curId);
                    } else if (fldSid) {
                        fldSid.value = '';
                    }
                } else if (fldSid) {
                    fldSid.value = '';
                }

                showModal();
            });

            // choose a supervisor by clicking the row
            if (list) {
                list.addEventListener('click', (e) => {
                    const row = e.target.closest('.assign-row');
                    if (!row) return;
                    const id = row.getAttribute('data-id');
                    const radio = row.querySelector('input[name="pick"]');
                    if (radio) {
                        radio.checked = true;
                        if (fldSid) fldSid.value = id;
                    }
                });
            }

            closeX?.addEventListener('click', hideModal);
            cancel?.addEventListener('click', hideModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) hideModal();
            });
            modal?.addEventListener('click', (e) => e.stopPropagation());
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal?.classList.contains('hidden')) hideModal();
            });

            // guard submit (require a selected supervisor)
            form?.addEventListener('submit', (e) => {
                if (!fldSid?.value) {
                    e.preventDefault();
                    alert('Please choose a supervisor.');
                }
            });

            // ======= Placeholder handlers for the other two actions =======
            document.addEventListener('click', (e) => {
                const addBtn = e.target.closest('.add-project-trigger');
                if (addBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    document.querySelectorAll('.more-menu').forEach(m => m.classList.add('hidden'));
                    alert('Add new project — TODO: wire form/modal.');
                }

                const dupBtn = e.target.closest('.duplicate-project-trigger');
                if (dupBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    document.querySelectorAll('.more-menu').forEach(m => m.classList.add('hidden'));
                    alert('Duplicate project — TODO: implement endpoint.');
                }
            });

        })();
    </script>

    {{-- Floating Completed Projects button --}}
    <a href="{{ route('admin.ProjectManagement', ['status' => 'COMPLETED']) }}"
       class="fixed right-6 bottom-6 z-20 px-4 py-3 rounded-full bg-fuchsia-900 text-white text-sm font-semibold shadow-lg hover:bg-fuchsia-800">
        Completed Projects
    </a>

</x-layouts.app>
