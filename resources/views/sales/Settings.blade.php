   <x-sales-layout>
        <main>
        <!--head begins-->

            <div class="p-3 sm:p-4">
             <div class="mb-5">



                <!-- Tabs -->
<div class="overflow-x-auto">
<div class="flex mb-6 border-b min-w-max">

     <button class="px-4 py-2 text-[19px] font-medium text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:text-fuchsia-900 hover:border-fuchsia-900 flex" data-tab="account">
        <i data-feather="user"
        class="w-[17.7px] h-[17.7px] mt-[5px] mr-[7px] text-black hover:text-fuchsia-900 feather-icon group "></i>Account</button>
    <button class="px-4 py-2 text-[19px] font-medium text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:border-fuchsia-900 flex hover:text-fuchsia-900" data-tab="notification"> <i data-feather="bell"
        class="w-[17.7px] h-[17.7px] mt-[7px] mr-[7px] text-black hover:text-fuchsia-900 feather-icon group "></i>Notification</button>

 </div>
</div>

<!-- Tab Contents -->
<div id="tab-account" class="tab-content">
    @include('sales.settings.account')
</div>



<div id="tab-notification" class="hidden tab-content">
    @include('sales.settings.notification')
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


    </x-sales-layout>
