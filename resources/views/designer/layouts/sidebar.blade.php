
    <!-- Sidebar -->
    <aside x-cloak
           class="fixed top-0 left-0 z-50 flex flex-col justify-between w-64 h-screen text-white transition-transform duration-200 ease-in-out transform bg-fuchsia-950 shadow-lg -translate-x-full lg:translate-x-0"
           :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">

      <div>
        <div class="flex items-center justify-between h-20 pt-8 pr-8 pb-8 pl-8 mt-7 mb-7 border-purple-700">
            <img src="/empire-kitchengold-icon.png" alt="Logo" class="w-[190px] h-[160px]" />
            <button type="button" class="p-2 rounded-md lg:hidden hover:bg-white/10" x-on:click="sidebarOpen = false">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>



          <!-- active dashboard?-->
          <a href="{{ route('designer.dashboard') }}"
   class="group relative flex items-center p-5 transition
          {{ request()->routeIs('designer.dashboard') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
    <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                 {{ request()->routeIs('designer.dashboard') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                 transition-transform origin-left"></span>
    <i data-feather="grid"
       class="feather-icon mr-3 group
              {{ request()->routeIs('designer.dashboard') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
    Dashboard
</a>
          <!-- active dashboard?-->


<!-- active dashboard?-->
<a href="{{ route('designer.AssignedProjects') }}"
class="group relative flex items-center p-5 transition
       {{ request()->routeIs('designer.AssignedProjects') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
 <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
              {{ request()->routeIs('designer.AssignedProjects') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
              transition-transform origin-left"></span>
 <i data-feather="users"
    class="feather-icon mr-3 group
           {{ request()->routeIs('designer.AssignedProjects') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
           Assigned Projects
</a>

                    <!-- active ProjectManagement?-->
                    <a href="{{ route('designer.ProjectDesign') }}"
                    class="group relative flex items-center p-5 transition
                           {{ request()->routeIs('designer.ProjectDesign') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                     <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('designer.ProjectDesign') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
                     <i data-feather="layers"
                        class="feather-icon mr-3 group
                               {{ request()->routeIs('designer.ProjectDesign') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                               Project Design
                 </a>

                           <!-- active ProjectDesign?-->


                    <!-- active ScheduleInstallation?-->
                    <a href="{{ route('designer.TimeManagement') }}"
                    class="group relative flex items-center p-5 transition
                           {{ request()->routeIs('designer.TimeManagement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                     <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('designer.TimeManagement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
                     <i data-feather="calendar"
                        class="feather-icon mr-3 group
                               {{ request()->routeIs('designer.TimeManagement') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                               Timeline Management
                 </a>


              <!-- active Settings?-->
              <a href="{{ route('designer.Settings') }}"
              class="group relative flex items-center p-5 transition
                     {{ request()->routeIs('designer.Settings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
               <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                            {{ request()->routeIs('designer.Settings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                            transition-transform origin-left"></span>
               <i data-feather="settings"
                  class="feather-icon mr-3 group
                         {{ request()->routeIs('designer.Settings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                         Settings
           </a>
                     <!-- active Settings?-->

              <!-- active Settings?-->
              <a href="{{ route('designer.inbox') }}"
              class="group relative flex items-center p-5 transition
                     {{ request()->routeIs('designer.inbox') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
               <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                            {{ request()->routeIs('designer.inbox') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                            transition-transform origin-left"></span>
               <i data-feather="mail"
                  class="feather-icon mr-3 group
                         {{ request()->routeIs('designer.inbox') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                         Inbox
           </a>
                     <!-- active Inbox?-->

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
