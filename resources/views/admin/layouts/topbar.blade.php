{{-- contains the profile --}}

    <!--Profile bar begins-->
    <div class="bg-white pt-6 pb-2 pr-4 pl-4">
        <div class="flex justify-between items-center mb-6">

          <!-- Empty div for spacing on the left -->
          <div class="w-1/3"></div>

          <!-- Centered search bar -->
          <div class="w-1/3 flex justify-center">
            <input
              type="text"
              placeholder="Search for anything"
              class="w-full max-w-md border border-gray-300 rounded px-4 py-2"
            />
          </div>

          <!-- Right side: Notifications and Profile -->
          <div class="flex items-center space-x-4 w-1/3 justify-end">
            <!-- <button class="relative">
              <i data-feather="bell"></i>
              <span class="absolute -top-2 -right-2 bg-purple-600 text-white rounded-full text-xs px-1.5">12</span>
            </button> -->
            <button class="relative">
              <i data-feather="bell"></i>
              <span class="absolute -top-2 -right-2 bg-purple-600 text-white rounded-full text-xs px-1.5">12</span>
            </button>
            <div class="flex items-center space-x-2">
              <div class="text-right">
                <div class="text-sm font-semibold">Daniel Mensah</div>
                <div class="text-xs text-gray-500">Administrator</div>
              </div>
              <img src="profilepic.JPG" alt="Avatar" class="w-10 h-10 rounded-full" />
            </div>
          </div>

        </div>
      </div>
      <!--Profile bar ends-->
