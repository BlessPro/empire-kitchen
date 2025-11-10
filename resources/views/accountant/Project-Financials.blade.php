<x-accountant-layout>
    <section class="space-y-4 p-3 sm:p-4">

        <header class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Project Financials</h1>
                <p class="text-sm text-gray-500">
                    Switch between budget overviews, profit &amp; loss, and cost tracking without leaving the page.
                </p>
            </div>
        </header>

        <div class="bg-white shadow-md rounded-[20px]">
            <nav class="flex flex-wrap gap-2 border-b px-4">
                <button
                    class="tab-btn px-4 py-3 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-fuchsia-900 hover:border-fuchsia-900 focus:outline-none"
                    data-tab="project-budget">
                    Project Budget Overview
                </button>
                <button
                    class="tab-btn px-4 py-3 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-fuchsia-900 hover:border-fuchsia-900 focus:outline-none"
                    data-tab="profit-loss">
                    Profit &amp; Loss Analysis
                </button>
                <button
                    class="tab-btn px-4 py-3 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-fuchsia-900 hover:border-fuchsia-900 focus:outline-none"
                    data-tab="cost-tracking">
                    Cost Tracking
                </button>
            </nav>

            <div class="p-4">
                <div id="tab-project-budget" class="tab-panel">
                    @include('accountant.Project-Financial.ProjectBudget')
                </div>

                <div id="tab-profit-loss" class="hidden tab-panel">
                    @include('accountant.Project-Financial.Profit-Loss')
                </div>

                <div id="tab-cost-tracking" class="hidden tab-panel">
                    @include('accountant.Project-Financial.Cost-Tracking')
                </div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            const buttons = document.querySelectorAll('.tab-btn');
            const panels = document.querySelectorAll('.tab-panel');

            function activate(slug) {
                panels.forEach((panel) => {
                    panel.classList.toggle('hidden', panel.id !== `tab-${slug}`);
                });

                buttons.forEach((btn) => {
                    const isActive = btn.getAttribute('data-tab') === slug;
                    btn.classList.toggle('text-fuchsia-900', isActive);
                    btn.classList.toggle('border-fuchsia-900', isActive);
                });
            }

            function remember(slug) {
                const url = new URL(window.location.href);
                url.searchParams.set('tab', slug);
                history.replaceState({}, '', url.toString());
            }

            buttons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const slug = btn.getAttribute('data-tab');
                    activate(slug);
                    remember(slug);
                });
            });

            const initial =
                new URL(window.location.href).searchParams.get('tab') ||
                (buttons[0] && buttons[0].getAttribute('data-tab')) ||
                'project-budget';

            activate(initial);
        })();
    </script>
</x-accountant-layout>
