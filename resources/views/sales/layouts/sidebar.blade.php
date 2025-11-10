
    <!-- Sidebar -->


    <!-- Sidebar -->
    <aside x-cloak
           class="fixed top-0 left-0 z-50 flex flex-col justify-between w-64 h-screen text-white transition-transform duration-200 ease-in-out transform bg-fuchsia-950 shadow-lg -translate-x-full lg:translate-x-0"
           :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">

            {{-- <aside class="bg-fuchsia-950 text-white flex flex-col justify-between"> --}}

      <div>
        <div class="flex items-center justify-between h-20 pt-8 pr-8 pb-8 pl-8 mt-7 mb-7 border-purple-700">
            <img src="/empire-kitchengold-icon.png" alt="Logo" class="w-[190px] h-[160px]" />
            <button type="button" class="p-2 rounded-md lg:hidden hover:bg-white/10" x-on:click="sidebarOpen = false">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
          </div>



          <a href="{{ route('sales.dashboard') }}"
   class="group relative flex items-center p-5 transition
          {{ request()->routeIs('sales.dashboard') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
    <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                 {{ request()->routeIs('sales.dashboard') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                 transition-transform origin-left"></span>
    <i data-feather="grid"
       class="feather-icon mr-3 group
              {{ request()->routeIs('sales.dashboard') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
    Dashboard
</a>


                    <a href="{{ route('sales.FollowupManagement') }}"
                    class="group relative flex items-center p-5 transition
                           {{ request()->routeIs('sales.FollowupManagement') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                     <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('sales.FollowupManagement') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
                     <i data-feather="user-check"
                        class="feather-icon mr-3 group
                               {{ request()->routeIs('sales.FollowupManagement') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                              Follow up Management
                 </a>

                    <!--testing active TrackPayment?-->
                    <a href="{{ route('sales.TrackPayment') }}"
                    class="group relative flex items-center p-5 transition
                           {{ request()->routeIs('sales.TrackPayment') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                     <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                  {{ request()->routeIs('sales.TrackPayment') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                  transition-transform origin-left"></span>
                     <i data-feather="dollar-sign"
                        class="feather-icon mr-3 group
                               {{ request()->routeIs('sales.TrackPayment') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                               Track Payments
                 </a>

                  <a href="{{ route('sales.Settings') }}"
                  class="group relative flex items-center p-5 transition
                         {{ request()->routeIs('sales.Settings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
                   <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                                {{ request()->routeIs('sales.Settings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                                transition-transform origin-left"></span>
                   <i data-feather="settings"
                      class="feather-icon mr-3 group
                             {{ request()->routeIs('sales.Settings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                             Settings
               </a>


              <a href="{{ route('sales.Inbox') }}"
              class="group relative flex items-center p-5 transition
                     {{ request()->routeIs('sales.Inbox') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
               <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full
                            {{ request()->routeIs('sales.Inbox') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}
                            transition-transform origin-left"></span>
               <i data-feather="mail"
                  class="feather-icon mr-3 group
                         {{ request()->routeIs('sales.Inbox') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
                         Inbox
           </a>


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
