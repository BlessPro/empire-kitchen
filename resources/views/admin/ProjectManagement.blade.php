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

    <main class="ml-[280px] mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen">
        <div class="p-6">
            {{-- Top bar --}}
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Project Management</h1>
                <a href="{{ route('admin.addproject') }}">
                    <button class="px-6 py-2 text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                        + Add Project
                    </button>
                </a>
            </div>

            {{-- Simple filter row (optional – uses $clients) --}}
            <div class="flex items-center justify-between mb-6">
                <form id="filterForm" method="GET" action="{{ route('clients.index') }}" class="flex gap-3">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        placeholder="Search clients..." class="pt-2 pb-2 pl-5 pr-5 border-gray-300 rounded-full" />
                    <select name="location" id="locationSelect"
                        class="pt-2 pb-2 pl-5 pr-5 border-gray-300 rounded-full">
                        <option value="">All Locations</option>
                        @foreach (($clients ?? collect())->pluck('location')->filter()->unique() as $location)
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
                            <h5 class="px-[10px] py-[10px] text-black">{{ ($measurements ?? collect())->count() }}</h5>
                        </span>
                        Measurement
                    </div>
                    <div class="pt-2 space-y-5">
                        @forelse(($measurements ?? collect()) as $project)
                            <div class="relative p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">

                                {{-- makes the whole card clickable --}}
                                {{-- <a href="{{ route('admin.projectInfo') }}" class="absolute inset-0 z-10"
                                    aria-label="Open project info"></a> --}}
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="absolute inset-0 z-10"
                                    aria-label="Open {{ $project->name }}"></a>

                                {{-- card content sits above background but below menu --}}
                                <div class="relative z-20">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-normal text-gray-800 text-[15px]">{{ $project->name }}</h3>

                                        {{-- 3-dot menu stays above the stretched link --}}
                                        <div class="relative z-30">
                                            <div class="relative" data-no-nav>
                                                <button class="p-3 more-trigger" data-project="{{ $project->id }}"
                                                    aria-haspopup="menu" aria-expanded="false">
                                                    <iconify-icon icon="mingcute:more-2-line" width="22"
                                                        style="color:#5A0562;"></iconify-icon>
                                                </button>

                                                <div class="more-menu absolute right-0 z-50 hidden w-48 mt-2 bg-white border border-gray-100 shadow-lg rounded-xl"
                                                    data-project="{{ $project->id }}" role="menu">
                                                    <ul class="py-2 text-[15px] text-gray-700">
                                                        <li>
                                                            <a href="#"
                                                                class="assign-trigger block px-4 py-2 hover:bg-gray-100"
                                                                data-project-id="{{ $project->id }}"
                                                                data-project-name="{{ $project->name }}"
                                                                data-current-id="{{ $project->tech_supervisor_id ?? '' }}"
                                                                data-no-nav onclick="event.preventDefault();">
                                                                Assign Supervisor
                                                            </a>
                                                        </li>


                                                        <li>
                                                            <a href="#"
                                                                class="add-product-trigger block px-4 py-2 hover:bg-gray-100"
                                                                data-no-nav onclick="event.preventDefault();">
                                                                Add new product
                                                            </a>
                                                        </li>




                                                        <li>

                                                            <button type="button"
                                                                class="block w-full px-4 py-2 text-left hover:bg-gray-100"
                                                                onclick="duplicateProject({{ $project->id }})">
                                                                Duplicate project
                                                            </button>

                                                            {{-- <button type="button"
                                                                class="duplicate-project-trigger block w-full px-4 py-2 text-left text-red-600 hover:bg-gray-100"
                                                                data-project-id="{{ $project->id }}" data-no-nav>
                                                                Duplicate project
                                                            </button> --}}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            {{-- your dropdown… --}}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                        <iconify-icon icon="uis:calender" width="22"
                                            style="color:#5A0562;"></iconify-icon>
                                        {{ $project->due_date }}
                                    </div>

                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                class="w-8 h-8 rounded-full" alt="">
                                            <span class="text-sm text-gray-700">
                                                {{ $project->client?->title . ' ' . $project->client?->firstname . ' ' . $project->client?->lastname }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 mb-5 bg-white rounded-[20px] shadow">
                                <h3 class="font-semibold text-gray-800">No project is currently under measurement</h3>
                            </div>
                        @endforelse

                    </div>

                </div>

                {{-- Design --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#4F46E5]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 class="px-[10px] py-[10px] text-black">{{ ($designs ?? collect())->count() }}</h5>
                        </span>
                        Design
                    </div>

                    <div class="pt-5 space-y-5">
                        @forelse(($designs ?? collect()) as $project)
                            <a href="{{ route('admin.projects.info', $project->id) }}">
                                <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                    <h3 class="font-semibold text-gray-800">{{ $project->name }}</h3>
                                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                        <i data-feather="calendar" class="mr-3 text-black"></i>
                                        {{ $project->due_date }}
                                    </div>
                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client"
                                                class="w-8 h-8 rounded-full">
                                            <span class="text-sm text-gray-700">
                                                {{ $project->client?->title . ' ' . $project->client?->firstname . ' ' . $project->client?->lastname }}
                                            </span>
                                        </div>
                                        @php
                                            $unreadCount = ($project->comments ?? collect())
                                                ->filter(fn($c) => ($c->unread_by_admin ?? 1) === 0)
                                                ->count();
                                        @endphp
                                        <div class="text-sm text-gray-500">💬 {{ $unreadCount }}</div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-5 mb-5 bg-white rounded-[20px] shadow">
                                <h3 class="font-semibold text-gray-800">No project is currently under design</h3>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Production --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#22C55E]">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 class="px-[10px] py-[10px] text-black">{{ ($productions ?? collect())->count() }}</h5>
                        </span>
                        Production
                    </div>

                    <div class="pt-5 space-y-5">
                        @forelse(($productions ?? collect()) as $project)
                            <a href="{{ route('admin.projects.info', $project->id) }}">
                                <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                    <h3 class="font-semibold text-gray-800">{{ $project->name }}</h3>
                                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                        <i data-feather="calendar" class="mr-3 text-black"></i>
                                        {{ $project->due_date }}
                                    </div>
                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client"
                                                class="w-8 h-8 rounded-full">
                                            <span class="text-sm text-gray-700">
                                                {{ $project->client?->title . ' ' . $project->client?->firstname . ' ' . $project->client?->lastname }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-500">💬 0</div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-5 mb-5 bg-white rounded-[20px] shadow">
                                <h3 class="font-semibold text-gray-800">No project is currently under production</h3>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Installation --}}
                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center py-2 pl-2 pr-5 text-white rounded-full bg-fuchsia-500">
                        <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                            <h5 class="px-[10px] py-[10px] text-black">{{ ($installations ?? collect())->count() }}
                            </h5>
                        </span>
                        Installation
                    </div>

                    <div class="pt-5 space-y-5">
                        @forelse(($installations ?? collect()) as $project)
                            <a href="{{ route('admin.projects.info', $project->id) }}">
                                <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                                    <h3 class="font-semibold text-gray-800">{{ $project->name }}</h3>
                                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                        <i data-feather="calendar" class="mr-3 text-black"></i>
                                        {{ $project->due_date }}
                                    </div>
                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client"
                                                class="w-8 h-8 rounded-full">
                                            <span class="text-sm text-gray-700">Marilyn Stanton</span>
                                        </div>
                                        @php
                                            $unreadCount = ($project->comments ?? collect())
                                                ->filter(fn($c) => ($c->unread_by_admin ?? 1) === 0)
                                                ->count();
                                        @endphp
                                        <div class="text-sm text-gray-500">💬 {{ $unreadCount }}</div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-5 mb-5 bg-white rounded-[20px] shadow">
                                <h3 class="font-semibold text-gray-800">No project is currently under installation</h3>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>


    <style>
        [x-cloak] {
            display: none !important
        }
    </style>

    <div id="assignModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40">
        <div class="relative w-full max-w-md p-6 bg-white rounded-2xl">
            {{-- Top controls (badge left, close right) --}}
            <div class="flex items-start justify-between mb-4">
                {{-- <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-purple-100">
        <iconify-icon icon="mdi:account-badge-outline" class="text-purple-700 text-xl"></iconify-icon>
      </span> --}}
                <div>
                    <h2 class="text-lg font-semibold">Assign Technical Supervisor</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        For: <span id="assignProjectName" class="font-medium"></span>
                    </p>
                </div>
                <button type="button" id="assignClose"
                    class="text-slate-500 hover:text-slate-700 text-2xl leading-none"
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
                        class="px-4 py-2 text-white w-full rounded-lg bg-fuchsia-900 hover:bg-purple-800">
                        Proceed
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Add Product Modal --}}
    <div id="addProductModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/30 p-4">
        <div class="w-full max-w-md rounded-2xl bg-white shadow-lg">
            <div class="flex items-center justify-between border-b px-4 py-3">
                <h3 class="text-sm font-semibold text-gray-900">Add new product</h3>
                <button type="button" id="apmClose" class="p-2 hover:bg-gray-50 rounded-lg">
                    <span class="iconify" data-icon="ph:x"></span>
                </button>
            </div>

            <form id="addProductForm" class="px-4 py-4 space-y-3">
                {{-- Project select --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Project</label>
                    <select id="apmProject"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-fuchsia-600 focus:border-fuchsia-600"
                        required>
                        <option value="" selected disabled>Select a project…</option>
                        @foreach ($projects as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} (ID: {{ $p->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Product Type (static list you control) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Type</label>
                    <select id="apmType"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-fuchsia-600 focus:border-fuchsia-600"
                        required>
                        <option value="" selected disabled>Select type…</option>
                        @foreach (['Kitchen', 'Wardrobe', 'Bathroom', 'TV Unit', 'Office'] as $type)
                            <option value="{{ $type }}"> {{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Optional name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Name (optional)</label>
                    <input type="text" id="apmName"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-fuchsia-600 focus:border-fuchsia-600"
                        placeholder="e.g., Tetteh’s Kitchen (Island)">
                </div>



                <p id="apmErr" class="hidden text-sm text-red-600"></p>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" id="apmCancel"
                        class="px-3 py-1.5 rounded-lg border border-gray-200 text-sm">Cancel</button>
                    <button type="submit"
                        class="px-3 py-1.5 rounded-lg bg-fuchsia-900 text-white text-sm hover:bg-fuchsia-800">Create
                        product</button>
                </div>





            </form>
        </div>
    </div>





    <script>
        async function duplicateProject(id) {
            if (!confirm('Duplicate this project?')) return;
            const res = await fetch(`{{ url('/admin/projects') }}/${id}/duplicate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'text/html'
                },
                credentials: 'same-origin'
            });
            if (res.redirected) {
                window.location = res.url;
            } else {
                // fallback if not redirected server-side
                location.reload();
            }
        }
    </script>

    <script>
        (function() {
            const modal = document.getElementById('addProductModal');
            const form = document.getElementById('addProductForm');
            const fldProj = document.getElementById('apmProject');
            const fldType = document.getElementById('apmType');
            const fldName = document.getElementById('apmName');
            const errBox = document.getElementById('apmErr');
            const btnClose = document.getElementById('apmClose');
            const btnCancel = document.getElementById('apmCancel');
            const csrf = '{{ csrf_token() }}';

            function openModal() {
                errBox?.classList.add('hidden');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
                form?.reset();
            }

            // Open from menu item
            document.addEventListener('click', (e) => {
                const a = e.target.closest('.add-product-trigger');
                if (!a) return;
                e.preventDefault();
                e.stopPropagation();
                document.querySelectorAll('.more-menu').forEach(m => m.classList.add('hidden'));
                openModal();
            });

            btnClose?.addEventListener('click', closeModal);
            btnCancel?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });

            form?.addEventListener('submit', async (e) => {
                e.preventDefault();
                errBox?.classList.add('hidden');

                const payload = {
                    project_id: Number(fldProj?.value || 0),
                    product_type: String(fldType?.value || ''),
                    name: (fldName?.value || '').trim() || null,
                };

                try {
                    if (!payload.project_id) throw new Error('Please select a project.');
                    if (!payload.product_type) throw new Error('Please select a product type.');

                    const res = await fetch(`{{ route('admin.products.quickCreate') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify(payload)
                    });

                    const txt = await res.text();
                    if (!res.ok) {
                        let msg = `HTTP ${res.status}`;
                        try {
                            const j = JSON.parse(txt);
                            if (j?.errors) msg = Object.values(j.errors).flat().join('\n');
                            else if (j?.message) msg = j.message;
                            else msg = txt.slice(0, 500);
                        } catch {
                            msg = txt.slice(0, 500);
                        }
                        throw new Error(msg);
                    }

                    const j = JSON.parse(txt);
                    if (!j?.ok || !j?.next_url) throw new Error('Unexpected response.');
                    // Go straight to Step 2
                    window.location = j.next_url;

                } catch (err) {
                    if (errBox) {
                        errBox.textContent = err.message || 'Failed to create product.';
                        errBox.classList.remove('hidden');
                    }
                }
            });
        })();
    </script>




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
            let t;
            si?.addEventListener('input', () => {
                clearTimeout(t);
                t = setTimeout(() => f.submit(), 300);
            });
            sl?.addEventListener('change', () => f.submit());
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

</x-layouts.app>
