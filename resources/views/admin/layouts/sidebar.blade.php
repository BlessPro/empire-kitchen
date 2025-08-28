<!-- Sidebar -->
 @include('admin.layouts.header')
<aside class="fixed top-0 left-0 z-50 flex flex-col justify-between h-screen text-white shadow-lg w-[280px] bg-fuchsia-950">

    {{-- <aside class="flex flex-col justify-between text-white bg-fuchsia-950"> --}}

    <div class="">
        <div class="flex items-center justify-center h-20 pt-8 pb-8 pl-8 pr-8 border-purple-700 mt-7 mb-7">
            <img src="/empire-kitchengold-icon.png" alt="Logo" class="w-[190px] h-[160px]" />
        </div>



        <a href="{{ route('admin.dashboard') }}"
            class=" justify  group relative flex items-center pt-3 pr-5 pb-3 pl-[40px] mb-[13px] mt-[10px] text-[16px] transition 
          {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-300/30 text-yellow-300' : 
          'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-1 bg-[#edc75a] rounded-r-full
                 {{ request()->routeIs('admin.dashboard') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                 transition-transform origin-left"></span>
          <iconify-icon
  icon="hugeicons:dashboard-square-01" width="22"
                                class=" mr-6  {{ request()->routeIs('admin.Bookings') ?
            'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></iconify-icon>

            Dashboard
        </a>

        <a href="{{ route('admin.ClientManagement') }}"
            class="  group relative flex items-center pt-3 pr-5 pb-3 pl-[40px] mb-[15px] mt-[10px] text-[16px] transition
       {{ request()->routeIs('admin.ClientManagement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
              {{ request()->routeIs('admin.ClientManagement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
              transition-transform origin-left"></span>
   <iconify-icon
  icon="fluent:people-32-light" width="22"
                                class=" mr-6  {{ request()->routeIs('admin.ClientManagement') ?
            'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}">
            </iconify-icon>

           Client Management
        </a>

        <a href="{{ route('admin.ProjectManagement') }}"
            class="group relative flex items-center p-5 transition pt-3 pr-5 pb-3 pl-[40px] mb-[15px] mt-[10px] text-[16px]
                           {{ request()->routeIs('admin.ProjectManagement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('admin.ProjectManagement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
 <iconify-icon
  icon="fluent:tasks-app-28-regular" width="22"
                                class=" mr-6  {{ request()->routeIs('admin.ProjectManagement') ?
            'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}">
            </iconify-icon>
            Project Management
        </a>
        <!-- Bookings-->
        <a href="{{ route('admin.Bookings') }}"
            class="group relative flex items-center p-5 transition pt-3 pr-5 pb-3 pl-[40px] mb-[15px] mt-[10px] text-[16px]
                           {{ request()->routeIs('admin.Bookings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('admin.Bookings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>

                                  <iconify-icon icon="hugeicons:appointment-02" width="22"
                                class=" mr-6  {{ request()->routeIs('admin.Bookings') ?
            'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></iconify-icon>
                               Bookings
        </a>




         <a href="{{ route('admin.ScheduleInstallation') }}"
            class="group relative flex items-center p-5 transition pt-3 pr-5 pb-3 pl-[40px] mb-[15px] mt-[10px] text-[16px]
                           {{ request()->routeIs('admin.ScheduleInstallation') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('admin.ScheduleInstallation') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
            <i data-feather="calendar"
                class="feather-icon mr-6 group
                               {{ request()->routeIs('admin.ScheduleInstallation') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            Schedule Installation
        </a>


          <a href="{{ route('admin.Employee') }}"
            class="group relative flex items-center p-5 transition pt-3 pr-5 pb-3 pl-[40px] mb-[15px] mt-[10px] text-[16px]
                           {{ request()->routeIs('admin.Employee') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('admin.Employee') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
            <i data-feather="calendar"
                class="feather-icon mr-6 group
                               {{ request()->routeIs('admin.Employee') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            Employee
        </a>


        <a href="{{ route('admin.ReportsandAnalytics') }}"
            class="group relative flex items-center p-5 transition pt-3 pr-5 pb-3 pl-[40px] mb-[15px] mt-[10px] text-[16px]
                                     {{ request()->routeIs('admin.ReportsandAnalytics') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-[48px] w-1 bg-[#edc75a] rounded-r-full
                                            {{ request()->routeIs('admin.ReportsandAnalytics') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                            transition-transform origin-left"></span>
            <i data-feather="bar-chart-2"
                class="feather-icon mr-6 group
                                         {{ request()->routeIs('admin.ReportsandAnalytics') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            Reports and Analytics
        </a>

        <!--testing active Settings?-->
        <a href="{{ route('admin.Settings') }}"
            class="group relative flex items-center p-5 transition pt-3 pr-5 pb-3 pl-[40px] mb-[15px] mt-[10px] text-[16px]
                                     {{ request()->routeIs('admin.Settings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-[48px] w-1 bg-[#edc75a] rounded-r-full
                                            {{ request()->routeIs('admin.Settings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                            transition-transform origin-left"></span>
                <iconify-icon
  icon="hugeicons:dashboard-square-01" width="22"
                                class=" mr-6  {{ request()->routeIs('admin.Bookings') ?
            'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></iconify-icon>
            Settings
        </a>
        <!--testing active Settings?-->


        <!--testing active Settings?-->
        <a href="{{ route('admin.Inbox') }}"
            class="group relative flex items-center p-5 transition pt-2 pr-5 pb-2 pl-[40px] mb-[100px] mt-4 text-[13px]
                     {{ request()->routeIs('admin.Inbox') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-[48px] w-1 bg-[#edc75a] rounded-r-full
                            {{ request()->routeIs('admin.Inbox') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                            transition-transform origin-left"></span>
    <iconify-icon
  icon="hugeicons:dashboard-square-01" width="22"
                                class=" mr-6  {{ request()->routeIs('admin.Bookings') ?
            'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></iconify-icon>
            Inbox
        </a>
        <!--testing active Inbox?-->

        </nav>


         <div class="px-4 py-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                class="flex items-center text-sm cursor-pointer hover:text-purple-300">
                <i data-feather="log-out" class="mr-2"></i> {{ __('Log Out') }}
            </a>
        </form>
    </div>
    </div>

    <!--Logout-->

   


</aside>
