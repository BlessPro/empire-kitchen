<!-- Sidebar -->
<aside class="fixed top-0 left-0 z-50 flex flex-col justify-between w-64 h-screen text-white shadow-lg bg-fuchsia-950">

    {{-- <aside class="flex flex-col justify-between text-white bg-fuchsia-950"> --}}

    <div>
        <div class="flex items-center justify-center h-20 pt-8 pb-8 pl-8 pr-8 border-purple-700 mt-7 mb-7">
            <img src="/empire-kitchengold-icon.png" alt="Logo" class="w-[190px] h-[160px]" />
        </div>



        <!--testing active dashboard?-->
        <a href="{{ route('accountant.dashboard') }}"
            class="group relative flex items-center p-5 transition
          {{ request()->routeIs('accountant.dashboard') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                 {{ request()->routeIs('accountant.dashboard') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                 transition-transform origin-left"></span>
            <i data-feather="grid"
                class="feather-icon mr-3 group
              {{ request()->routeIs('accountant.dashboard') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            Dashboard
        </a>


        <!--testing active dashboard?-->
        <a href="{{ route('accountant.Bookings') }}"
            class="group relative flex items-center p-5 transition
       {{ request()->routeIs('accountant.Bookings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
              {{ request()->routeIs('accountant.Bookings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
              transition-transform origin-left"></span>
            <i data-feather="users"
                class="feather-icon mr-3 group
           {{ request()->routeIs('accountant.Bookings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            Bookings
        </a>

        <!--testing active dashboard?-->
        <a href="{{ route('accountant.Payments') }}"
            class="group relative flex items-center p-5 transition
       {{ request()->routeIs('accountant.Payments') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
              {{ request()->routeIs('accountant.Payments') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
              transition-transform origin-left"></span>
            <i data-feather="users"
                class="feather-icon mr-3 group
           {{ request()->routeIs('accountant.Payments') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            Payments
        </a>

        <!--testing active Expenses?-->
        <a href="{{ route('accountant.Expenses') }}"
            class="group relative flex items-center p-5 transition
               {{ request()->routeIs('accountant.Expenses') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                      {{ request()->routeIs('accountant.Expenses') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                      transition-transform origin-left"></span>
            <i data-feather="layers"
                class="feather-icon mr-3 group
                               {{ request()->routeIs('accountant.Expenses') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            Expenses
        </a>

        <!--testing active Expenses?-->


        <!--testing active Project Financial?-->
        <a href="{{ route('accountant.Project-Financials') }}"
            class="group relative flex items-center p-5 transition
                           {{ request()->routeIs('accountant.Project-Financials') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('accountant.Project-Financials') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
            <i data-feather="calendar"
                class="feather-icon mr-3 group
                               {{ request()->routeIs('accountant.Project-Financials') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            Project Financials
        </a>


        <!--testing active Settings?-->
        <a href="{{ route('accountant.Settings') }}"
            class="group relative flex items-center p-5 transition
                                     {{ request()->routeIs('accountant.Settings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                            {{ request()->routeIs('accountant.Settings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                            transition-transform origin-left"></span>
            <i data-feather="settings"
                class="feather-icon mr-3 group
                                         {{ request()->routeIs('accountant.Settings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            Settings
        </a>
        <!--testing active Settings?-->

        <!--testing active Settings?-->
        <a href="{{ route('accountant.Inbox') }}"
            class="group relative flex items-center p-5 transition
                     {{ request()->routeIs('accountant.Inbox') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
            <span
                class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                            {{ request()->routeIs('accountant.Inbox') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                            transition-transform origin-left"></span>
            <i data-feather="mail"
                class="feather-icon mr-3 group
                         {{ request()->routeIs('accountant.Inbox') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
            Inbox
        </a>
        <!--testing active Inbox?-->

        </nav>
    </div>

    <!--Logout-->


    <div class="px-4 py-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                class="flex items-center text-sm cursor-pointer hover:text-purple-300">
                <i data-feather="log-out" class="mr-2"></i> {{ __('Log Out') }}
            </a>
        </form>
    </div>

</aside>
