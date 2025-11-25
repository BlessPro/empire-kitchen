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
            <div class="relative" id="notif-wrap">
              <button id="notifBtn" class="relative p-2 text-gray-600 transition bg-gray-100 rounded-md hover:bg-gray-200">
                <i data-feather="bell" class="w-5 h-5"></i>
                <span id="notifBadge" class="absolute top-0 right-0 px-1.5 text-xs text-white bg-purple-600 rounded-full translate-x-1/2 -translate-y-1/2 hidden">0</span>
              </button>
              <div id="notifPanel" class="absolute right-0 mt-2 w-80 max-w-[90vw] bg-white rounded-xl shadow-xl border border-gray-200 hidden z-50">
                <div class="px-4 py-2 border-b font-semibold text-sm text-gray-700">Notifications</div>
                <div id="notifList" class="max-h-80 overflow-y-auto divide-y"></div>
                <div id="notifEmpty" class="p-4 text-sm text-gray-500">No recent activity.</div>
              </div>
            </div>

          <div class="flex items-center gap-2">
              @php
                $user = auth()->user();
                $emp  = $user?->employee;
                $displayName = $emp->name ?? $user->name ?? 'User';
                $displayRole = $user->role ?? ($emp->designation ?? '');
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

      @if(auth()->user()?->role === 'administrator')
      <script>
        (function(){
          const btn = document.getElementById('notifBtn');
          const panel = document.getElementById('notifPanel');
          const list = document.getElementById('notifList');
          const empty = document.getElementById('notifEmpty');
          const badge = document.getElementById('notifBadge');
          const wrap = document.getElementById('notif-wrap');

          async function fetchFeed(){
            try{
              const res = await fetch('{{ route('admin.notifications.feed') }}', { headers: { 'Accept':'application/json' } });
              const json = await res.json();
              const items = json?.data || [];
              list.innerHTML = '';
              if(items.length === 0){ empty.classList.remove('hidden'); } else { empty.classList.add('hidden'); }
              items.forEach(it => {
                const row = document.createElement('a');
                row.href = it.project?.id ? `{{ url('/admin/projects') }}/${it.project.id}` : '#';
                row.className = 'block px-4 py-3 hover:bg-gray-50';
                row.innerHTML = `
                  <div class="text-sm text-gray-800">${escapeHtml(it.message || it.type)}</div>
                  <div class="mt-1 text-xs text-gray-500">${escapeHtml(it.project?.name || '')}</div>
                `;
                list.appendChild(row);
              });
              // Badge: simple count of items as a hint
              if(items.length>0){ badge.textContent = Math.min(items.length, 9); badge.classList.remove('hidden'); }
              else { badge.classList.add('hidden'); }
            }catch(e){ console.error('notif feed', e); }
          }

          function escapeHtml(text){
            const map = { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#039;' };
            return String(text||'').replace(/[&<>"']/g, m => map[m]);
          }

          btn?.addEventListener('click', (e)=>{
            e.stopPropagation();
            panel.classList.toggle('hidden');
            if(!panel.classList.contains('hidden')) fetchFeed();
          });
          document.addEventListener('click', (e)=>{ if(!wrap.contains(e.target)) panel.classList.add('hidden'); });
        })();
      </script>
      @endif
