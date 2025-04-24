
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 w-64 h-screen bg-fuchsia-950 text-white shadow-lg z-50 flex flex-col justify-between">

            {{-- <aside class="bg-fuchsia-950 text-white flex flex-col justify-between"> --}}

      <div>
        <div class="flex items-center justify-center h-20 border-purple-700 pt-8 pr-8 pb-8 pl-8 mt-7 mb-7">
            <img src="/empire-kitchengold-icon.png" alt="Logo" class="w-[190px] h-[160px]" />
          </div>

           <!--nav-items-->
        <nav class="">
          <!--dashboard-->
          <a href="{{route('admin.dashboard')}}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
            <!-- Feather Icon -->
            <i data-feather="grid" class="feather-icon mr-3 stroke-white group-hover:stroke-yellow-300 transition-all duration-300"></i>
            Dashboard
          </a>

             <!--Client Management-->
          <a href="{{ route('admin.ClientManagement') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
            <!-- Feather Icon -->
            <i data-feather="users" class="mr-3"></i> Client Management
          </a>

             <!--Project Management-->
          <a href="{{ route('admin.ProjectManagement') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
            <i data-feather="layers" class="mr-3"></i> Project Management
          </a>

          <!--Schedule Installation-->
          <a href="{{ route('admin.ScheduleInstallation') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>

            <i data-feather="calendar" class="mr-3"></i> Schedule Installation
          </a>

          <!--Reports and Analytics-->
          <a href="{{ route('admin.ReportsandAnalytics') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>

            <i data-feather="bar-chart-2" class="mr-3"></i> Reports and Analytics
          </a>

          <!--Project Management-->
          <a href="{{ route('admin.Settings') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>

            <i data-feather="settings" class="mr-3"></i> Settings
          </a>

          <!--Inbox-->
          <a href="{{ route('admin.Inbox') }}" class="group relative flex items-center  p-5 hover:bg-yellow-300/30 hover:text-yellow-300 text-white transition">
            <span class="absolute left-0 top-0 h-full w-2 bg-[#edc75a] rounded-r-full scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
            <!-- Feather Icon -->
            <i data-feather="mail" class="mr-3"></i> Inbox
          </a>

        </nav>
      </div>

      <!--Logout-->


      <div class="px-4 py-6">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center text-sm hover:text-purple-300">
            <i data-feather="log-out" class="mr-2"></i> {{ __('Log Out') }}
          </a>
        </form>
      </div>
{{--
        <form method="POST" action="{{ route('logout') }}">
            @csrf
      <div class="px-4 py-6">
        <a  :href="route('logout')"onclick="event.preventDefault();this.closest('form').submit();" hover{cursor:pointer;} class="flex items-center text-sm hover:text-purple-300">
          <i data-feather="log-out" class="mr-2"></i> {{ __('Log Out') }}

        </a>

      </div>
        </form> --}}
    </aside>
