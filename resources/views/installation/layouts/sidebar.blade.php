<!-- Sidebar -->
<aside class="fixed top-0 left-0 z-50 flex flex-col justify-between w-64 h-screen text-white transition-transform duration-200 ease-in-out transform bg-fuchsia-950 shadow-lg -translate-x-full lg:translate-x-0"
       :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">

  <div class="flex-1 overflow-y-auto">
    <div class="flex items-center justify-between h-20 pt-8 pb-8 pl-8 pr-8 border-purple-700 mt-7 mb-7">
      <img src="/empire-kitchengold-icon.png" alt="Logo" class="w-[190px] h-[160px]" />
      <button type="button" class="p-2 rounded-md lg:hidden hover:bg-white/10" x-on:click="sidebarOpen = false">
        <i data-feather="x" class="w-5 h-5"></i>
      </button>
    </div>

    <a href="{{ route('installation.projects') }}"
       class="group relative flex items-center p-5 text-[15px] transition {{ request()->routeIs('installation.projects') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
      <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full {{ request()->routeIs('installation.projects') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }} transition-transform origin-left"></span>
      <i data-feather="clipboard" class="w-5 h-5 mr-3 {{ request()->routeIs('installation.projects') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
      <span>Project Management</span>
    </a>

    <a href="{{ route('installation.settings') }}"
       class="group relative flex items-center p-5 text-[15px] transition {{ request()->routeIs('installation.settings') ? 'bg-yellow-300/30 text-yellow-300' : 'hover:bg-yellow-300/30 hover:text-yellow-300 text-white' }}">
      <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full {{ request()->routeIs('installation.settings') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }} transition-transform origin-left"></span>
      <i data-feather="settings" class="w-5 h-5 mr-3 {{ request()->routeIs('installation.settings') ? 'stroke-yellow-300' : 'stroke-white group-hover:stroke-yellow-300' }}"></i>
      <span>Settings</span>
    </a>
  </div>

  <div class="px-4 py-6 text-center border-t border-white/10">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
         class="inline-flex items-center text-sm transition hover:text-purple-300">
        <i data-feather="log-out" class="w-5 h-5 mr-3"></i>
        Log out
      </a>
    </form>
  </div>
</aside>

