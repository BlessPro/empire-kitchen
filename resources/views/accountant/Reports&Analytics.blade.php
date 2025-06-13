   <x-accountant-layout>
   <x-slot name="header">
<!--written on 16.05.2025-->
        @include('admin.layouts.header')
         </x-slot>
        <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="">
             <div class="mb-[20px]">



                <!-- Tabs -->
<div class="flex mb-6 border-b">

     <button class="px-4 py-2 text-[19px] font-medium text-gray-600 border-b-2 border-transparent tab-btn
     focus:outline-none hover:text-fuchsia-900 hover:border-fuchsia-900 flex" data-tab="Revenue">
        <i data-feather="user"
        class="w-[17.7px] h-[17.7px] mt-[5px] mr-[7px] text-black hover:text-fuchsia-900 feather-icon group "></i>Revenue</button>
    <button class="px-4 py-2 text-[19px] font-medium text-gray-600 border-b-2 border-transparent tab-btn
    focus:outline-none hover:border-fuchsia-900 flex hover:text-fuchsia-900" data-tab="Expense"> <i data-feather="bell"
        class="w-[17.7px] h-[17.7px] mt-[7px] mr-[7px] text-black hover:text-fuchsia-900 feather-icon group ">
    </i>Expense
    </button>

      <button class="px-4 py-2 text-[19px] font-medium text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none
       hover:border-fuchsia-900 flex hover:text-fuchsia-900"
       data-tab="Profit&Loss"> <i data-feather="bell"
        class="w-[17.7px] h-[17.7px] mt-[7px] mr-[7px] text-black hover:text-fuchsia-900 feather-icon group ">
    </i>Profit & Loss
    </button>

</div>

<!-- Tab Contents -->

<div id="tab-Revenue" class="active tab-content">
    @include('accountant.Reports&Analytic.Revenue')
</div>

<div id="tab-Expense" class="hidden tab-content">
    @include('accountant.Reports&Analytic.Expense')
</div>

<div id="tab-Profit&Loss" class="hidden tab-content">
    @include('accountant.Reports&Analytic.Profit&Loss')
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


    </x-accountant-layout>


