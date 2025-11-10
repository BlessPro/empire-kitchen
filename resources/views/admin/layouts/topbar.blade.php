{{-- contains the profile --}}

    <!--Profile bar begins-->
    <div class="sticky top-0 z-40 w-full px-4 py-3 bg-white shadow-md">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-2">

          <!-- Left: Sidebar toggle / spacer -->
          <div class="flex items-center gap-3 order-1">
            @if (!empty($showSidebarToggle))
              <button type="button" class="p-2 text-gray-600 transition bg-gray-100 rounded-md hover:bg-gray-200 lg:hidden"
                x-on:click="sidebarOpen = true">
                <i data-feather="menu" class="w-5 h-5"></i>
              </button>
            @endif
          </div>

          <!-- Center: (search removed) -->

          <!-- Right: Notifications and Profile -->
          <div class="flex items-center gap-4 order-2 ml-auto sm:order-3">
            <button class="relative p-2 text-gray-600 transition bg-gray-100 rounded-md hover:bg-gray-200">
              <i data-feather="bell" class="w-5 h-5"></i>
              <span class="absolute top-0 right-0 px-1.5 text-xs text-white bg-purple-600 rounded-full translate-x-1/2 -translate-y-1/2">12</span>
            </button>

          <div class="flex items-center gap-2">
              @php
                $user = auth()->user();
                $emp  = $user?->employee;
                $displayName = $emp->name ?? $user->name ?? 'User';
                $displayRole = $emp->designation ?? ($user->role ?? '');
                $avatar = $emp?->avatar_path
                  ? asset('storage/' . ltrim($emp->avatar_path, '/'))
                  : ($user?->profile_pic
                      ? asset('storage/' . ltrim($user->profile_pic, '/'))
                      : 'https://ui-avatars.com/api/?name=' . urlencode($displayName));
              @endphp
              <div class="text-right">
                <div class="text-sm font-semibold text-gray-700">{{ $displayName }}</div>
                <div class="text-xs text-gray-500">{{ $displayRole }}</div>
              </div>
              <img
                src="{{ $avatar }}"
                alt="Profile Photo"
                class="w-10 h-10 border-2 border-yellow-300 rounded-[10px] object-cover"
              >
            </div>
          </div>

        </div>
      </div>
      <!--Profile bar ends-->
