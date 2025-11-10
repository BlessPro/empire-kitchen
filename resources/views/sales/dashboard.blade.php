<!-- Example for sales -->
<x-sales-layout>


      @php
        $statusClasses = [
            'Medium' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
            'High' => 'bg-red-100 text-red-700 px-2 py-1 border border-red-500 rounded-full text-xs',
            'Low' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
        ];


        $defaultClass = 'bg-gray-100 text-gray-800';
    @endphp

 <main>
            <div class=" bg-[#F9F7F7]">
             <div class="mb-[20px]">
    <!-- main body -->


                          <div class="flex items-center justify-between mb-6">
                            <h2 class=" font-normal text-[15px] ml-5 text-gray-900">Total Projects</h2>

                            {{-- <div>
                              <select id="month1" class="p-2 rounded-[20px] text-[12px] pr-4 border border-gray-300 bg-white text-gray-700">

                              </select>

                            </div> --}}
                          </div>
                <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
                    <!-- Closed Deals -->
                    <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
                        <div>
                            <p class="mb-6 text-[22px] font-semibold text-gray-700">Closed Deals</p>
                            <h2 class="text-[50px] font-semibold ">
                                {{$soldFollowUpsCount}}
                            </h2>
                        </div>
                        <div class="flex items-center justify-center w-[70px] h-[70px] bg-orange-100 rounded-full">
                            {{-- <i class="w-5 h-5 text-orange-500 " data-feather="dollar-sign"></i> --}}
                            <iconify-icon icon="iconamoon:profile-light" width="24"
                                style="color: #ff9800;"></iconify-icon>
                        </div>
                    </div>

                    <!-- Revenue Generated -->
                    <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
                        <div>
                            <p class="mb-6 text-[22px] font-semibold text-gray-700">Due this week</p>
                            <h2 class="text-[50px] font-semibold">
                              {{ $dueThisWeekCount }}
                            </h2>
                        </div>
                        <div class="flex items-center justify-center w-[70px] h-[70px] bg-green-100 rounded-full">
                            {{-- <i class="w-5 h-5 text-green-500 " data-feather="dollar-sign"></i> --}}
                            <iconify-icon icon="lets-icons:check-ring-light" width="24"
                                class="text-green-500"></iconify-icon>

                        </div>
                    </div>

                    <!-- Completed Follow-ups -->
                    <div class="flex justify-between items-center bg-white shadow rounded-[20px] p-6">
                        <div>
                            <p class="mb-6 text-[22px] font-semibold text-gray-700">Overdue Followups</p>
                            <h2 class="text-[50px] font-semibold">
                              {{ $overdueCount }}
                            </h2>
                        </div>
                        <div class="flex items-center justify-center w-[70px] h-[70px] bg-red-100 rounded-full">

                            <iconify-icon icon="mynaui:danger-triangle" width="24"
                                class="text-red-500"></iconify-icon>

                        </div>
                    </div>
                </div>



  <div id="followups-table-wrapper" class="pt-4">
            {{-- @include('sales.partials.dashboard-table', ['followUps' => $recentFollowUps]) --}}
            @include('sales.partials.dashboard-table', ['followUps' => $recentFollowUps])

        {{-- @include('sales.partials.dashboard-table', ['projects' => $projects]) --}}


    </div>

</div>
            </div>
 </main>


{{-- Follow-up Pagination --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    loadFollowupPagination();

    function loadFollowupPagination() {
        document.querySelectorAll('#followups-table-wrapper .pagination a').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                const url = this.getAttribute('href');

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('followups-table-wrapper').innerHTML = html;
                    loadFollowupPagination(); // re-bind after pagination reload
                });
            });
        });
    }
});
</script>


</x-sales-layout>

