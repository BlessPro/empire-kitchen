<x-layouts.app>
    <section class="p-3 space-y-4 sm:p-4">
        @php
            $statusClasses = [
                'ON_GOING' => 'bg-yellow-100 text-yellow-700 px-3 py-1 border border-yellow-500 rounded-full text-xs',
                'COMPLETED' => 'bg-green-100 text-green-700 px-3 py-1 border border-green-500 rounded-full text-xs',
                'IN_REVIEW' => 'bg-blue-100 text-blue-700 px-3 py-1 border border-blue-500 rounded-full text-xs',
            ];

            $defaultClass = 'bg-gray-100 text-gray-700 px-3 py-1 border border-gray-300 rounded-full text-xs';
        @endphp

        <header class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Overview</h1>
                <p class="text-sm text-gray-500">Track client intake, project pipeline, and current projects.</p>
            </div>
        </header>

        <div class="grid gap-4 lg:grid-cols-2">
            <div class="bg-white shadow rounded-[20px]">
                <div class="flex flex-col gap-4 p-5">
                    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                        <h2 class="text-base font-medium text-gray-900">Total Incoming Clients</h2>
                        <select id="dashboardRange"
                            class="w-full px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-full sm:w-auto">
                            <option value="7days">Last 7 Days</option>
                            <option value="this_month" selected>This Month</option>
                            <option value="3months">Last 3 Months</option>
                            <option value="6months">Last 6 Months</option>
                            <option value="year_to_date">Year to Date</option>
                            <option value="last_year">Last Year</option>
                            <option value="all_time">All Time</option>
                        </select>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="flex items-center justify-center w-full max-w-[240px] mx-auto">
                            <canvas id="clientsChart" class="w-full h-full"></canvas>
                        </div>

                        <div class="flex items-center justify-center">
                            <ul class="space-y-3 text-sm font-medium text-gray-700">
                                <li class="flex items-center">
                                    <span class="w-10 h-5 mr-3 bg-orange-500 rounded-full"></span>
                                    <span id="legend-clients">New Clients (0)</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="w-10 h-5 mr-3 bg-purple-900 rounded-full"></span>
                                    <span id="legend-projects">New Projects (0)</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="w-10 h-5 mr-3 bg-indigo-500 rounded-full"></span>
                                    <span id="legend-bookings">New Bookings (0)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.ProjectManagement') }}" class="block">
                <div class="bg-white shadow rounded-[20px] h-full">
                    <div class="flex flex-col gap-4 p-5">
                        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                            <h2 class="text-base font-medium text-gray-900">Project Pipeline</h2>
                            <ul id="pipelineLegend"
                                class="flex flex-wrap items-center gap-3 text-sm font-medium text-gray-700"></ul>
                        </div>

                        <div class="w-full">
                            <canvas id="ProjectsPipeline" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <section class="space-y-3">
            <header class="px-2">
                <h2 class="text-xl font-semibold text-gray-900">My Projects</h2>
                <p class="text-sm text-gray-500">Easily manage your projects here.</p>
            </header>

            <div class="bg-white shadow rounded-[20px]">
                <div class="px-5 py-4">
                    <div id="projectsTableContainer">
                        @include('partials.projects-table', ['projects' => $projects])
                    </div>
                </div>

                <div class="px-5 pb-5">
                    {{ $projects->links('pagination::tailwind') }}
                </div>
            </div>
        </section>
    </section>

    <script>
        document.getElementById("selectAll")?.addEventListener("change", function() {
            const isChecked = this.checked;
            document.querySelectorAll(".child-checkbox").forEach(cb => cb.checked = isChecked);
        });

        const childCheckboxes = document.querySelectorAll(".child-checkbox");
        childCheckboxes.forEach(cb => {
            cb.addEventListener("change", () => {
                const allChecked = Array.from(childCheckboxes).every(c => c.checked);
                const selectAll = document.getElementById("selectAll");
                if (selectAll) selectAll.checked = allChecked;
            });
        });

        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                const status = this.dataset.status;

                fetch(`/admin/projects/filter?status=${status}`)
                    .then(response => response.text())
                    .then(html => {
                        const container = document.getElementById('projectsTableContainer');
                        if (container) container.innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching filtered projects:', error));
            });
        });
    </script>

    @vite(['resources/js/app.js'])
</x-layouts.app>
