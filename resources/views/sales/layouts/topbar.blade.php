{{-- contains the profile --}}

    <!--Profile bar begins-->
    <div class="fixed top-0 left-0 right-0 z-40 pt-6 pb-2 pl-4 pr-4 bg-white shadow-md">
        <div class="flex items-center justify-between mb-6">

          <!-- Empty div for spacing on the left -->
          <div class="w-1/3"></div>

          <!-- Centered search bar -->
          <div class="flex justify-center w-1/3">
            <input
              type="text"
              placeholder="Search for anything"
              class="w-full max-w-md px-4 py-2 border border-gray-300 rounded"
            />
          </div>

          <!-- Right side: Notifications and Profile -->
          <div class="flex items-center justify-end w-1/3 space-x-4">
          
            <button class="relative">
              <i data-feather="bell"></i>
              <span class="absolute -top-2 -right-2 bg-purple-600 text-white rounded-full text-xs px-1.5">12</span>
            </button>

            <div class="flex items-center space-x-2">
              <div class="text-right">
                <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-500">{{ auth()->user()->role }}</div>
              </div>
              <img
              src="{{ auth()->user()->profile_pic ? asset('storage/' . auth()->user()->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
              alt="Profile Photo"
              class="w-10 h-10 border-2 border-yellow-300 rounded-[10px]"
          >
            </div>
          </div>

        </div>
      </div>
      <!--Profile bar ends-->
