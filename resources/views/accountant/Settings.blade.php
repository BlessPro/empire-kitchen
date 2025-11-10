<x-accountant-layout>
    <section class="space-y-4 p-3 sm:p-4">

        <header class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
                <p class="text-sm text-gray-500">Manage your account details and notification preferences.</p>
            </div>
        </header>

        <div class="bg-white shadow-md rounded-[20px]">
            <nav class="flex flex-wrap gap-2 border-b px-4">
                <button
                    class="tab-btn px-4 py-3 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-fuchsia-900 hover:border-fuchsia-900 focus:outline-none"
                    data-tab="account">
                    <i data-feather="user" class="w-4 h-4 mr-2"></i>
                    Account
                </button>
                <button
                    class="tab-btn px-4 py-3 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-fuchsia-900 hover:border-fuchsia-900 focus:outline-none"
                    data-tab="notification">
                    <i data-feather="bell" class="w-4 h-4 mr-2"></i>
                    Notification
                </button>
            </nav>

            <div class="p-4">
                <div id="tab-account" class="tab-panel">
                    @include('accountant.settings.account')
                </div>

                <div id="tab-notification" class="hidden tab-panel">
                    @include('accountant.settings.notification')
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

            const initial = buttons[0]?.getAttribute('data-tab') ?? 'account';
            activate(initial);

            buttons.forEach((btn) => {
                btn.addEventListener('click', () => activate(btn.getAttribute('data-tab')));
            });
        })();
    </script>
</x-accountant-layout>
