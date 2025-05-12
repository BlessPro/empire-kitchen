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
<div class="flex mb-6 border-b">
    <button class="px-4 py-2 text-[19px] text-gray-600 border-b-2 border-transparent hover:text-fuchsia-900 font-medium tab-btn focus:outline-none hover:border-fuchsia-900 flex" data-tab="team"> <i data-feather="users"
        class="w-[17.7px] h-[17.7px] mt-[5px] mr-[7px] text-black hover:text-fuchsia-900 feather-icon group "></i>Team Management</button>
    <button class="px-4 py-2 text-[19px] font-medium text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:border-fuchsia-900 flex hover:text-fuchsia-900" data-tab="notification"> <i data-feather="bell"
        class="w-[17.7px] h-[17.7px] mt-[7px] mr-[7px] text-black hover:text-fuchsia-900 feather-icon group "></i>Notification</button>
    <button class="px-4 py-2 text-[19px] font-medium text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:text-fuchsia-900 hover:border-fuchsia-900 flex" data-tab="account">
        <i data-feather="user"
        class="w-[17.7px] h-[17.7px] mt-[5px] mr-[7px] text-black hover:text-fuchsia-900 feather-icon group "></i>Account</button>
</div>

<!-- Tab Contents -->
<div id="tab-account" class="hidden tab-content">
    @include('admin.settings.account')
</div>
<div id="tab-team" class="tab-content">
    @include('admin.settings.team')
</div>
{{-- <div id="tab-team" class="tab-content">
    @include('admin.settings.notification')
</div> --}}

<div id="tab-notification" class="hidden tab-content">
    @include('admin.settings.notification')
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
