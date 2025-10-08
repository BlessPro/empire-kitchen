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

                       <button
                           class="px-4 py-2 text-[19px] font-medium text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:text-fuchsia-900 hover:border-fuchsia-900 flex"
                           data-tab="project-budget">
                           Project Budget Overview</button>
                       <button
                           class="px-4 py-2 text-[19px] font-medium text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:border-fuchsia-900 flex hover:text-fuchsia-900"
                           data-tab="Profit-Loss"> Profit And Loss Analysis
                       </button>

                       <button
                           class="px-4 py-2 text-[19px] font-medium text-gray-600 border-b-2 border-transparent tab-btn focus:outline-none hover:border-fuchsia-900 flex hover:text-fuchsia-900"
                           data-tab="Cost-Tracking"> Cost tracking
                       </button>

                   </div>

                   <!-- Tab Contents -->

                   <div id="tab-project-budget" class="active tab-content">
                       @include('accountant.Project-Financial.ProjectBudget')
                   </div>

                   <div id="tab-Profit-Loss" class="hidden tab-content">
                       @include('accountant.Project-Financial.Profit-Loss')
                   </div>

                   <div id="tab-Cost-Tracking" class="hidden tab-content">
                       @include('accountant.Project-Financial.Cost-Tracking')
                   </div>

               </div>
           </div>
       </main>

       <script>
           (function() {
               const btns = document.querySelectorAll('.tab-btn');
               const contents = document.querySelectorAll('.tab-content');

               function activate(slug) {
                   // hide all contents
                   contents.forEach(c => c.classList.add('hidden'));
                   // remove active styles from all buttons
                   btns.forEach(b => b.classList.remove('border-fuchsia-900', 'text-fuchsia-900'));

                   // show the requested tab
                   const el = document.getElementById(`tab-${slug}`);
                   if (el) el.classList.remove('hidden');

                   // style the corresponding button
                   const btn = Array.from(btns).find(b => b.getAttribute('data-tab') === slug);
                   if (btn) btn.classList.add('border-fuchsia-900', 'text-fuchsia-900');
               }

               function setURLTab(slug) {
                   const url = new URL(window.location.href);
                   url.searchParams.set('tab', slug);
                   history.replaceState({}, '', url.toString());
               }

               // On click → activate + remember in URL
               btns.forEach(btn => {
                   btn.addEventListener('click', () => {
                       const slug = btn.getAttribute('data-tab');
                       activate(slug);
                       setURLTab(slug);
                   });
               });

               // On load → read ?tab= or default to first button's data-tab
               const url = new URL(window.location.href);
               const initial = url.searchParams.get('tab') || (btns[0] && btns[0].getAttribute('data-tab')) ||
                   'project-budget';
               activate(initial);
           })();
       </script>

   </x-accountant-layout>
