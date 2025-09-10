<x-layouts.app>
  <x-slot name="header">
    @include('admin.layouts.header')
    <style>[x-cloak]{display:none!important}</style>
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
                 placeholder="Search clients..."
                 class="pt-2 pb-2 pl-5 pr-5 border-gray-300 rounded-full" />
          <select name="location" id="locationSelect"
                  class="pt-2 pb-2 pl-5 pr-5 border-gray-300 rounded-full">
            <option value="">All Locations</option>
            @foreach(($clients ?? collect())->pluck('location')->filter()->unique() as $location)
              <option value="{{ $location }}" @selected(request('location') == $location)>{{ $location }}</option>
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
              <div class="p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
                <div class="flex items-center justify-between">
                  <h3 class="font-normal text-gray-800 text-[15px]">{{ $project->name }}</h3>

                  {{-- 3-dot menu (unique per project via data attributes) --}}
                  <div class="relative">
                    <button class="p-3" data-more-trigger data-project="{{ $project->id }}">
                      <iconify-icon icon="mingcute:more-2-line" width="22" style="color:#5A0562;"></iconify-icon>
                    </button>

                    <div class="absolute right-0 z-50 hidden w-48 mt-2 bg-white border border-gray-100 shadow-lg rounded-xl"
                         data-more-menu data-project="{{ $project->id }}">
                      <ul class="py-2 text-[15px] text-gray-700">
                        <li>
                          <a href="#"
                             class="block px-4 py-2 hover:bg-gray-100 assign-tech-trigger"
                             data-project-id="{{ $project->id }}"
                             data-project-name="{{ $project->name }}">
                            Assign Supervisor
                          </a>
                        </li>
                        <li>
                          <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                            Add new project
                          </a>
                        </li>
                        <li>
                          <button type="button"
                                  class="block w-full px-4 py-2 text-left text-red-600 hover:bg-gray-100">
                            Duplicate project
                          </button>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                  <iconify-icon icon="uis:calender" width="22" style="color:#5A0562;"></iconify-icon>
                  {{ $project->due_date }}
                </div>

                <div class="flex items-center justify-between mt-4">
                  <div class="flex items-center gap-3">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg"
                         alt="Client" class="w-8 h-8 rounded-full">
                    <span class="text-sm text-gray-700">
                      {{ $project->client?->title.' '.$project->client?->firstname.' '.$project->client?->lastname }}
                    </span>
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
                      <img src="https://randomuser.me/api/portraits/women/44.jpg"
                           alt="Client" class="w-8 h-8 rounded-full">
                      <span class="text-sm text-gray-700">
                        {{ $project->client?->title.' '.$project->client?->firstname.' '.$project->client?->lastname }}
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
                      <img src="https://randomuser.me/api/portraits/women/44.jpg"
                           alt="Client" class="w-8 h-8 rounded-full">
                      <span class="text-sm text-gray-700">
                        {{ $project->client?->title.' '.$project->client?->firstname.' '.$project->client?->lastname }}
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
              <h5 class="px-[10px] py-[10px] text-black">{{ ($installations ?? collect())->count() }}</h5>
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
                      <img src="https://randomuser.me/api/portraits/women/44.jpg"
                           alt="Client" class="w-8 h-8 rounded-full">
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

  {{-- Assign Technical Supervisor Modal --}}
  <div id="assignTechModal"
       class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/50">
    <div class="w-full max-w-md p-6 bg-white shadow-xl rounded-2xl">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold">Assign Technical Supervisor</h2>
        <button type="button" onclick="closeTechModal()" class="text-gray-500 hover:text-gray-700">
          <i data-feather="x"></i>
        </button>
      </div>

      <form id="assignTechForm" method="POST" action="{{ route('tech.assignSupervisor') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="project_id" id="projectIdInput">
        <input type="hidden" name="supervisor_id" id="supervisorIdInput">

        <div>
          <input type="text" id="projectNameInput" disabled readonly
                 class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-purple-500">
        </div>

        <div id="supervisorList" class="max-h-[320px] overflow-y-auto space-y-3"></div>

        <button type="submit"
                class="w-full py-3 text-lg font-medium text-white rounded-full bg-fuchsia-900 hover:brightness-110">
          Proceed
        </button>
      </form>
    </div>
  </div>



  {{-- Page JS (single, consolidated) --}}
  <script>
    if (window.feather) feather.replace();

    // Close modal
    function closeTechModal() {
      const m = document.getElementById('assignTechModal');
      m.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    }

    // Open + fetch supervisors
    async function openTechModal(projectId, projectName) {
      const m  = document.getElementById('assignTechModal');
      const list = document.getElementById('supervisorList');
      const projectIdInput    = document.getElementById('projectIdInput');
      const projectNameInput  = document.getElementById('projectNameInput');
      const supervisorIdInput = document.getElementById('supervisorIdInput');

      // reset header/fields
      projectIdInput.value    = projectId || '';
      projectNameInput.value  = projectName || '';
      supervisorIdInput.value = '';

      // show modal
      m.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');

      // loading
      list.innerHTML = `<div class="px-3 py-2 text-sm text-gray-500">Loading…</div>`;

      const url = `{{ url('/admin/projects') }}/${projectId}/supervisors`;

      try {
        const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
        if (!res.ok) {
          const text = await res.text();
          console.error('Supervisors fetch failed:', res.status, text);
          throw new Error(`HTTP ${res.status}`);
        }
        const data = await res.json();

        list.innerHTML = (data.supervisors || []).map(s => {
          const badge = s.is_assigned_here
            ? `<span class="ml-auto text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Assigned here</span>`
            : (s.assigned_elsewhere
                ? `<span class="ml-auto text-xs px-2 py-0.5 rounded-full bg-amber-100 text-amber-700" title="Assigned to ${s.assigned_project_name ?? 'another project'}">Assigned</span>`
                : '');
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
          if (radio) { radio.checked = true; supervisorIdInput.value = String(current.id); }
        }

        // bind change once
        list.addEventListener('change', (e) => {
          if (e.target && e.target.name === 'supervisor_pick') {
            supervisorIdInput.value = e.target.value;
          }
        }, { once: true });

      } catch (err) {
        list.innerHTML = `<div class="px-3 py-2 text-sm text-red-600">Failed to load supervisors.</div>`;
      }
    }

    // Backdrop + ESC
    (function wireBackdrop() {
      const modal = document.getElementById('assignTechModal');
      if (!modal) return;
      modal.addEventListener('click', (e) => { if (e.target === modal) closeTechModal(); });
      document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeTechModal(); });
    })();

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
      if (openMenus.length && !e.target.closest('[data-more-menu]') && !e.target.closest('[data-more-trigger]')) {
        openMenus.forEach(m => m.classList.add('hidden'));
      }

      // Assign Supervisor trigger
      const a = e.target.closest('.assign-tech-trigger');
      if (a) {
        e.preventDefault();
        const id   = a.dataset.projectId;
        const name = a.dataset.projectName || '';
        if (!id) return;
        openTechModal(id, name);
        const menu = a.closest('[data-more-menu]');
        if (menu) menu.classList.add('hidden');
      }
    });

    // Simple filter auto-submit (optional)
    (function wireFilters(){
      const f  = document.getElementById('filterForm');
      if (!f) return;
      const si = f.querySelector('#searchInput');
      const sl = f.querySelector('#locationSelect');
      let t;
      si?.addEventListener('input', () => {
        clearTimeout(t); t = setTimeout(()=> f.submit(), 300);
      });
      sl?.addEventListener('change', ()=> f.submit());
    })();
  </script>
</x-layouts.app>
