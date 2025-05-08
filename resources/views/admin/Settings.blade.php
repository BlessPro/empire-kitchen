<x-layouts.app>
    <x-slot name="header">
<!--written on 30.04.2025 @ 9:45-->
    <!-- Main Content -->

    @include('admin.layouts.header')

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">

<!-- Tabs -->
<div class="flex mb-4 border-b">
    <button class="px-4 py-2 text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:border-fuchsia-900" data-tab="team">Team Management</button>
    <button class="px-4 py-2 text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:border-fuchsia-900" data-tab="notification">Notification</button>
    <button class="px-4 py-2 text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:border-fuchsia-900" data-tab="account">Account</button>
</div>

<!-- Tab Contents -->
<div id="tab-team" class="tab-content">
    @include('admin.settings.team')
</div>

<div id="tab-notification" class="hidden tab-content">
    @include('admin.settings.notification')
</div>

<div id="tab-account" class="hidden tab-content">
    @include('admin.settings.account')
</div>



      </div>
     </div>
     </main>

     <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
    
                // Remove active border for all buttons
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('border-fuchsia-900', 'text-fuchsia-900');
                });
    
                // Show selected tab content
                const target = btn.getAttribute('data-tab');
                document.getElementById(`tab-${target}`).classList.remove('hidden');
    
                // Add active class to clicked button
                btn.classList.add('border-fuchsia-900', 'text-fuchsia-900');
            });
        });
    </script>
    
    </x-slot>
</x-layouts.app>
