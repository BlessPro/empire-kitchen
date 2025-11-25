<!-- Sidebar -->
<aside class="fixed top-0 left-0 z-50 flex flex-col justify-between w-64 h-screen text-white transition-transform duration-200 ease-in-out transform bg-fuchsia-950 shadow-lg -translate-x-full lg:translate-x-0"
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen
    }">

    {{-- <aside class="flex flex-col justify-between text-white bg-fuchsia-950"> --}}

    <div class="flex-1 overflow-y-auto">
        <div class="flex items-center justify-between h-20 pt-8 pb-8 pl-8 pr-8 border-purple-700 mt-7 mb-7">
            <img src="/empire-kitchengold-icon.png" alt="Logo" class="w-[190px] h-[160px]" />
            <button type="button" class="p-2 rounded-md lg:hidden hover:bg-white/10" x-on:click="sidebarOpen = false">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>



        <a href="{{ route('admin.dashboard') }}"
            class="group relative flex items-center p-5 text-[15px] transition {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                 {{ request()->routeIs('admin.dashboard') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                 transition-transform origin-left"></span>
            <i data-feather="grid" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.ClientManagement') }}"
            class="group relative flex items-center p-5 text-[15px] transition {{ request()->routeIs('admin.ClientManagement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
              {{ request()->routeIs('admin.ClientManagement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
              transition-transform origin-left"></span>
            <i data-feather="users" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.ClientManagement') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Client Management</span>
        </a>

        <a href="{{ route('admin.ProjectManagement') }}"
            class="group relative flex items-center p-5 text-[15px] transition {{ request()->routeIs('admin.ProjectManagement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('admin.ProjectManagement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
            <i data-feather="clipboard" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.ProjectManagement') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Project Management</span>
        </a>
        <!-- Bookings-->
        <a href="{{ route('admin.Bookings') }}"
            class="group relative flex items-center p-5 text-[15px] transition {{ request()->routeIs('admin.Bookings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('admin.Bookings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
            <i data-feather="calendar" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.Bookings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Bookings</span>
        </a>



         <a href="{{ route('admin.ScheduleInstallation') }}"
            class="group relative flex items-center p-5 text-[15px] transition {{ request()->routeIs('admin.ScheduleInstallation') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('admin.ScheduleInstallation') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
            <i data-feather="tool" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.ScheduleInstallation') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Schedule Installation</span>
        </a>

          <a href="{{ route('admin.Employee') }}"
            class="group relative flex items-center p-5 text-[15px] transition {{ request()->routeIs('admin.Employee') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('admin.Employee') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
            <i data-feather="users" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.Employee') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Employee</span>
        </a>


  

        <!--testing active Settings?-->
        <a href="{{ route('admin.Settings') }}"
            class="group relative flex items-center p-5 text-[15px] transition
                                     {{ request()->routeIs('admin.Settings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                            {{ request()->routeIs('admin.Settings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                            transition-transform origin-left"></span>
            <i data-feather="settings" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.Settings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Settings</span>
        </a>
        <!--testing active Settings?-->


        <!--testing active Settings?-->
        <a href="{{ route('admin.Inbox', [], false) }}"
            class="group relative flex items-center p-5 text-[15px] transition
                     {{ request()->routeIs('admin.Inbox') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                            {{ request()->routeIs('admin.Inbox') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                            transition-transform origin-left"></span>
            <i data-feather="mail" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.Inbox') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Inbox</span>
        </a>
        </nav>

    </div>

    <div class="px-4 py-6 text-center border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="inline-flex items-center text-sm transition hover:text-purple-300">
                <i data-feather="log-out" class="w-5 h-5 mr-3"></i>
                Log out
            </button>
        </form>
    </div>
    <!--Logout-->




</aside>

