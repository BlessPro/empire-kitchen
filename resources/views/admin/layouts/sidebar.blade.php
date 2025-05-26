
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 w-64 h-screen bg-fuchsia-950 text-white shadow-lg z-50 flex flex-col justify-between">

            {{-- <aside class="bg-fuchsia-950 text-white flex flex-col justify-between"> --}}

      <div>
        <div class="flex items-center justify-center h-20 border-purple-700 pt-8 pr-8 pb-8 pl-8 mt-7 mb-7">
            <img src="/empire-kitchengold-icon.png" alt="Logo" class="w-[190px] h-[160px]" />
          </div>

           <!--nav-items-->
        {{-- <nav class="">
          <!--dashboard-->
          <a href="{{route('admin.dashboard')}}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
            <!-- Feather Icon -->
            <i data-feather="grid" class="feather-icon mr-3 stroke-white group-hover:stroke-yellow-300 transition-all duration-300"></i>
            Dashboard
          </a> --}}

          <!--testing active dashboard?-->
          <a href="{{ route('admin.dashboard') }}"
   class="group relative flex items-center p-5 transition
          {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
    <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                 {{ request()->routeIs('admin.dashboard') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                 transition-transform origin-left"></span>
    <i data-feather="grid"
       class="feather-icon mr-3 group
              {{ request()->routeIs('admin.dashboard') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
    Dashboard
</a>
          <!--testing active dashboard?-->


             {{-- <!--Client Management-->
          <a href="{{ route('admin.ClientManagement') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
            <!-- Feather Icon -->
            <i data-feather="users" class="mr-3"></i> Client Management
          </a> --}}
<!--testing active dashboard?-->
<a href="{{ route('admin.ClientManagement') }}"
class="group relative flex items-center p-5 transition
       {{ request()->routeIs('admin.ClientManagement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
 <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
              {{ request()->routeIs('admin.ClientManagement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
              transition-transform origin-left"></span>
 <i data-feather="users"
    class="feather-icon mr-3 group
           {{ request()->routeIs('admin.ClientManagement') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
           Client Management
</a>
       <!--testing active dashboard?-->


             <!--Project Management-->
          {{-- <a href="{{ route('admin.ProjectManagement') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
            <i data-feather="layers" class="mr-3"></i> Project Management
          </a> --}}

                    <!--testing active ProjectManagement?-->
                    <a href="{{ route('admin.ProjectManagement') }}"
                    class="group relative flex items-center p-5 transition
                           {{ request()->routeIs('admin.ProjectManagement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                     <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('admin.ProjectManagement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
                     <i data-feather="layers"
                        class="feather-icon mr-3 group
                               {{ request()->routeIs('admin.ProjectManagement') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                               Project Management
                 </a>

                           <!--testing active ProjectManagement?-->
          <!--Schedule Installation-->
          {{-- <a href="{{ route('admin.ScheduleInstallation') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>

            <i data-feather="calendar" class="mr-3"></i> Schedule Installation
          </a> --}}

                    <!--testing active ScheduleInstallation?-->
                    <a href="{{ route('admin.ScheduleInstallation') }}"
                    class="group relative flex items-center p-5 transition
                           {{ request()->routeIs('admin.ScheduleInstallation') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                     <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('admin.ScheduleInstallation') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
                     <i data-feather="calendar"
                        class="feather-icon mr-3 group
                               {{ request()->routeIs('admin.ScheduleInstallation') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                               Schedule Installation
                 </a>
                           <!--testing active ScheduleInstallation?-->

          {{-- <!--Reports and Analytics-->
          <a href="{{ route('admin.ReportsandAnalytics') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>

            <i data-feather="bar-chart-2" class="mr-3"></i> Reports and Analytics
          </a> --}}

                              <!--testing active ReportsandAnalytics?-->
                              <a href="{{ route('admin.ReportsandAnalytics') }}"
                              class="group relative flex items-center p-5 transition
                                     {{ request()->routeIs('admin.ReportsandAnalytics') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                               <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                            {{ request()->routeIs('admin.ReportsandAnalytics') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                            transition-transform origin-left"></span>
                               <i data-feather="bar-chart-2"
                                  class="feather-icon mr-3 group
                                         {{ request()->routeIs('admin.ReportsandAnalytics') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                                         Reports and Analytics
                           </a>
                                     <!--testing active ReportsandAnalytics?-->

          {{-- <!--Project Management-->
          <a href="{{ route('admin.Settings') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>

            <i data-feather="settings" class="mr-3"></i> Settings
          </a> --}}
                              <!--testing active Settings?-->
                              <a href="{{ route('admin.Settings') }}"
                              class="group relative flex items-center p-5 transition
                                     {{ request()->routeIs('admin.Settings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                               <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                            {{ request()->routeIs('admin.Settings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                            transition-transform origin-left"></span>
                               <i data-feather="settings"
                                  class="feather-icon mr-3 group
                                         {{ request()->routeIs('admin.Settings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                                         Settings
                           </a>
                                     <!--testing active Settings?-->

          {{-- <!--Inbox-->
          <a href="{{ route('admin.Inbox') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
            <!-- Feather Icon -->
            <i data-feather="mail" class="mr-3"></i> Inbox
          </a> --}}
              <!--testing active Settings?-->
              <a href="{{ route('admin.Inbox') }}"
              class="group relative flex items-center p-5 transition
                     {{ request()->routeIs('admin.Inbox') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
               <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                            {{ request()->routeIs('admin.Inbox') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                            transition-transform origin-left"></span>
               <i data-feather="mail"
                  class="feather-icon mr-3 group
                         {{ request()->routeIs('admin.Inbox') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                         Inbox
           </a>
                     <!--testing active Inbox?-->

        </nav>
      </div>

      <!--Logout-->

      <div class="px-4 py-6">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <a href="{{ route('logout') }}"
             onclick="event.preventDefault(); this.closest('form').submit();"
             class="flex items-center text-sm hover:text-purple-300 cursor-pointer">
            <i data-feather="log-out" class="mr-2"></i> {{ __('Log Out') }}
          </a>
        </form>
      </div>


    </aside>
