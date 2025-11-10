<x-Production-layout>
    <div class="p-3 sm:p-4 bg-[#F9F7F7]">
        <div class="mb-[20px]">

            <div class="overflow-x-auto">
                <div class="flex mb-6 border-b min-w-max">
                    <button class="px-4 py-2 text-sm md:text-base text-gray-600 border-b-2 border-transparent hover:text-fuchsia-900 font-medium tab-btn focus:outline-none hover:border-fuchsia-900 flex" data-tab="account">
                        <i data-feather="user" class="w-[16px] h-[16px] mt-[5px] mr-[7px] text-black hover:text-fuchsia-900 feather-icon group "></i>
                        Account
                    </button>
                    <button class="px-4 py-2 text-sm md:text-base font-medium text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:border-fuchsia-900 flex hover:text-fuchsia-900" data-tab="notification">
                        <i data-feather="bell" class="w-[16px] h-[16px] mt-[7px] mr-[7px] text-black hover:text-fuchsia-900 feather-icon group "></i>
                        Notification
                    </button>
                </div>
            </div>

            <div id="tab-account" class="tab-content">
                @include('production.settings.account')
            </div>
            <div id="tab-notification" class="hidden tab-content">
                @include('production.settings.notification')
            </div>

        </div>
    </div>

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('border-fuchsia-900', 'text-fuchsia-900'));
                const target = btn.getAttribute('data-tab');
                document.getElementById(`tab-${target}`).classList.remove('hidden');
                btn.classList.add('border-fuchsia-900', 'text-fuchsia-900');
            });
        });
    </script>
</x-Production-layout>
