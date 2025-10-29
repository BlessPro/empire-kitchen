<x-tech-layout>
    <x-slot name="header">
        @include('admin.layouts.header')
        <style>[x-cloak]{display:none!important}</style>
    </x-slot>

    <main class="flex-1  min-h-screen bg-[#F9F7F7] pt-24 pb-12 lg:ml-64">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Project Management</h1>
            </div>

            {{-- <div class="flex items-center justify-between mb-6">
                <form id="filterForm" method="GET" action="{{ route('tech.ProjectManagement.filter') }}" class="flex flex-wrap gap-3">
                    <input
                        type="text"
                        name="search"
                        id="searchInput"
                        value="{{ request('search') }}"
                        placeholder="Search projects..."
                        class="pt-2 pb-2 pl-5 pr-5 border border-gray-300 rounded-full focus:border-fuchsia-700 focus:ring-2 focus:ring-fuchsia-700"
                    />
                    <select
                        name="location"
                        id="locationSelect"
                        class="pt-2 pb-2 pl-5 pr-5 border border-gray-300 rounded-full focus:border-fuchsia-700 focus:ring-2 focus:ring-fuchsia-700"
                    >
                        <option value="">All Locations</option>
                        @foreach (($projectLocations ?? collect()) as $location)
                            <option value="{{ $location }}">{{ $location }}</option>
                        @endforeach
                    </select>
                </form>
            </div> --}}

            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
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
                            'projectRouteName' => 'tech.projects.info',
                            'showActions' => false,
                        ])
                    </div>
                </div>

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
                            'projectRouteName' => 'tech.projects.info',
                            'showActions' => false,
                        ])
                    </div>
                </div>

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
                            'projectRouteName' => 'tech.projects.info',
                            'showActions' => false,
                        ])
                    </div>
                </div>

                <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                    <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#5A0562]">
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
                            'projectRouteName' => 'tech.projects.info',
                            'showActions' => false,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        (function () {
            const form = document.getElementById('filterForm');
            if (!form) return;

            const searchInput = form.querySelector('#searchInput');
            const locationSelect = form.querySelector('#locationSelect');
            const endpoint = form.getAttribute('action');

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

            let controller = null;
            let debounce = null;

            const updateLists = (payload) => {
                ['measurement', 'design', 'production', 'installation'].forEach((key) => {
                    if (lists[key] && payload[key] !== undefined) {
                        lists[key].innerHTML = payload[key];
                    }
                });
            };

            const updateCounts = (payload) => {
                if (!payload) return;
                Object.entries(payload).forEach(([key, value]) => {
                    if (counts[key]) {
                        counts[key].textContent = value;
                    }
                });
            };

            const applyFilters = () => {
                if (!endpoint) return;

                if (controller) {
                    controller.abort();
                }
                controller = new AbortController();

                const params = new URLSearchParams(new FormData(form));
                const url = `${endpoint}?${params.toString()}`;

                fetch(url, {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    signal: controller.signal,
                })
                    .then((response) => {
                        if (!response.ok) throw response;
                        return response.json();
                    })
                    .then((data) => {
                        updateLists(data);
                        updateCounts(data.counts || {});
                    })
                    .catch((error) => {
                        if (error.name === 'AbortError') return;
                        console.error('Failed to filter projects', error);
                    });
            };

            const schedule = () => {
                if (debounce) clearTimeout(debounce);
                debounce = setTimeout(applyFilters, 300);
            };

            form.addEventListener('submit', (e) => e.preventDefault());
            searchInput?.addEventListener('input', schedule);
            locationSelect?.addEventListener('change', schedule);
        })();
    </script>
</x-tech-layout>
