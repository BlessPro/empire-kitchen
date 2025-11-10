
    <!-- Sidebar -->
    <aside x-cloak
           class="fixed top-0 left-0 z-50 flex flex-col justify-between w-64 h-screen text-white transition-transform duration-200 ease-in-out transform bg-fuchsia-950 shadow-lg -translate-x-full lg:translate-x-0"
           :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">

            {{-- <aside class="flex flex-col justify-between text-white bg-fuchsia-950"> --}}

      <div class="pl-20px">
        <div class="flex items-center justify-between h-20 pt-8 pb-8 pl-8 pr-8 border-purple-700 mt-7 mb-7">
            <img src="/empire-kitchengold-icon.png" alt="Logo" class="w-[190px] h-[160px]" />
            <button type="button" class="p-2 rounded-md lg:hidden hover:bg-white/10" x-on:click="sidebarOpen = false">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
          </div>

          <!--dashboard-->
          <a href="{{ route('tech.dashboard') }}"
   class="group relative flex items-center p-5 transition
          {{ request()->routeIs('tech.dashboard') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
    <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                 {{ request()->routeIs('tech.dashboard') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                 transition-transform origin-left"></span>
    <i data-feather="grid"
       class="feather-icon mr-3 group
              {{ request()->routeIs('tech.dashboard') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
    Dashboard
</a>
          <!-- active dashboard?-->
    <a href="{{ route('tech.ScheduleMeasurement') }}"
                    class="group relative flex items-center p-5 transition
                           {{ request()->routeIs('tech.ScheduleMeasurement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                     <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('tech.ScheduleMeasurement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
                     <i data-feather="calendar"
                        class="feather-icon mr-3 group
                               {{ request()->routeIs('tech.ScheduleMeasurement') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                               Schedule Measurement
                </a>
                      </a>

                    <a href="{{ route('tech.AssignDesigners') }}"
                              class="group relative flex items-center p-5 transition
                                     {{ request()->routeIs('tech.AssignDesigners') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                               <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                            {{ request()->routeIs('tech.AssignDesigners') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                            transition-transform origin-left"></span>
                               <i data-feather="clipboard"
                                  class="feather-icon mr-3 group
                                         {{ request()->routeIs('tech.AssignDesigners') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                                         Assign Designers
                           </a>

              <!--Client Management-->

<!--testing active dashboard?-->
{{-- <a href="{{ route('tech.ClientManagement') }}"
class="group relative flex items-center p-5 transition
       {{ request()->routeIs('tech.ClientManagement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
 <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
              {{ request()->routeIs('tech.ClientManagement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
              transition-transform origin-left"></span>
 <i data-feather="users"
    class="feather-icon mr-3 group
           {{ request()->routeIs('tech.ClientManagement') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
           Client Management
</a> --}}

                    <!--testing active ProjectManagement?-->
                    <a href="{{ route('tech.ProjectManagement') }}"
                    class="group relative flex items-center p-5 transition
                           {{ request()->routeIs('tech.ProjectManagement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                     <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('tech.ProjectManagement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
                     <i data-feather="layers"
                        class="feather-icon mr-3 group
                               {{ request()->routeIs('tech.ProjectManagement') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                               Project Management

                         <!--Schedule Installation-->

                    <!--testing active ScheduleMeasurement?-->


                 {{--
                              <a href="{{ route('tech.ReportsandAnalytics') }}"
                              class="group relative flex items-center p-5 transition
                                     {{ request()->routeIs('tech.ReportsandAnalytics') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                               <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                            {{ request()->routeIs('tech.ReportsandAnalytics') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                            transition-transform origin-left"></span>
                               <i data-feather="bar-chart-2"
                                  class="feather-icon mr-3 group
                                         {{ request()->routeIs('tech.ReportsandAnalytics') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                                         Reports and Analytics
                           </a> --}}

                              <a href="{{ route('tech.Settings') }}"
                              class="group relative flex items-center p-5 transition
                                     {{ request()->routeIs('tech.Settings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                               <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                            {{ request()->routeIs('tech.Settings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                            transition-transform origin-left"></span>
                               <i data-feather="settings"
                                  class="feather-icon mr-3 group
                                         {{ request()->routeIs('tech.Settings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                                         Settings
                           </a>
                                     <!--testing active Settings?-->

           <!--Inbox-->

              <a href="{{ route('tech.Inbox') }}"
              class="group relative flex items-center p-5 transition
                     {{ request()->routeIs('tech.Inbox') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
               <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                            {{ request()->routeIs('tech.Inbox') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                            transition-transform origin-left"></span>
               <i data-feather="mail"
                  class="feather-icon mr-3 group
                         {{ request()->routeIs('tech.Inbox') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
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
