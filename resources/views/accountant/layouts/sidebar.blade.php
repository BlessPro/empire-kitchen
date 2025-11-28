<!-- Sidebar -->

<aside x-cloak class="fixed top-0 left-0 z-50 flex flex-col justify-between w-64 h-screen text-white transition-transform duration-200 ease-in-out transform -translate-x-full shadow-lg bg-fuchsia-950 lg:translate-x-0"
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



        <a href="{{ route('accountant.dashboard') }}"
            class="group relative flex items-center p-5 text-[15px] transition
          {{ request()->routeIs('accountant.dashboard') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                 {{ request()->routeIs('accountant.dashboard') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                 transition-transform origin-left"></span>
            <i data-feather="grid"
                class="w-5 h-5 mr-3
              {{ request()->routeIs('accountant.dashboard') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Dashboard</span>
        </a>


        <a href="{{ route('accountant.Bookings') }}"
            class="group relative flex items-center p-5 text-[15px] transition
       {{ request()->routeIs('accountant.Bookings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
              {{ request()->routeIs('accountant.Bookings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
              transition-transform origin-left"></span>
            <i data-feather="users"
                class="w-5 h-5 mr-3
           {{ request()->routeIs('accountant.Bookings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Bookings</span>
        </a>

        <a href="{{ route('accountant.Payments') }}"
            class="group relative flex items-center p-5 text-[15px] transition
       {{ request()->routeIs('accountant.Payments') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
              {{ request()->routeIs('accountant.Payments') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
              transition-transform origin-left"></span>
            <i data-feather="users"
                class="w-5 h-5 mr-3
           {{ request()->routeIs('accountant.Payments') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Payments</span>
        </a>

        <a href="{{ route('accountant.Expenses') }}"
            class="group relative flex items-center p-5 text-[15px] transition
               {{ request()->routeIs('accountant.Expenses') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                      {{ request()->routeIs('accountant.Expenses') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                      transition-transform origin-left"></span>
            <i data-feather="layers"
                class="w-5 h-5 mr-3
                               {{ request()->routeIs('accountant.Expenses') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Expenses</span>
        </a>

        <a href="{{ route('accountant.Project-Financials') }}"
            class="group relative flex items-center p-5 text-[15px] transition
                          {{ request()->routeIs('accountant.Project-Financials') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('accountant.Project-Financials') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
            <i data-feather="calendar"
                class="w-5 h-5 mr-3
                              {{ request()->routeIs('accountant.Project-Financials') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>P and L Account</span>
        </a>


        <a href="{{ route('accountant.Settings') }}"
            class="group relative flex items-center p-5 text-[15px] transition
                                    {{ request()->routeIs('accountant.Settings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                            {{ request()->routeIs('accountant.Settings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                            transition-transform origin-left"></span>
            <i data-feather="settings"
                class="w-5 h-5 mr-3
                                         {{ request()->routeIs('accountant.Settings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Settings</span>
        </a>

        <a href="{{ route('accountant.Inbox') }}"
            class="group relative flex items-center p-5 text-[15px] transition
                    {{ request()->routeIs('accountant.Inbox') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                            {{ request()->routeIs('accountant.Inbox') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                            transition-transform origin-left"></span>
            <i data-feather="mail"
                class="w-5 h-5 mr-3
                    {{ request()->routeIs('accountant.Inbox') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            <span>Inbox</span>
        </a>
        <!--testing active Inbox?-->

        </nav>
    </div>

    <!--Logout-->


    <div class="px-4 py-6 text-center border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                class="inline-flex items-center text-sm transition hover:text-purple-300">
                <i data-feather="log-out" class="w-5 h-5 mr-3"></i> {{ __('Log Out') }}
            </a>
        </form>
    </div>

</aside>
