{{-- resources/views/inbox.blade.php --}}
<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')

    </x-slot>
{{-- <body class="h-screen bg-neutral-50 text-neutral-800"> --}}
 <main class="ml-[260px] mt-[60px] bg-[#F9F7F7]">
        <div class="p-6 h-[calc(100vh-80px)] overflow-hidden">

  <div class="grid h-full grid-cols-12 gap-0">
    <!-- Left: Conversation List -->
    <aside class="flex flex-col h-full col-span-4 overflow-hidden bg-white border-r border-neutral-200">
      <!-- Top bar with search + New button -->
      <div class="flex items-center gap-2 p-3 border-b border-neutral-200">
        <div class="relative flex-1">
          <input id="convSearch" type="text" placeholder="Search chats, groups, roles…" class="w-full px-3 py-2 text-sm bg-white border rounded-xl border-neutral-300 pr-9 focus:outline-none focus:ring-2 focus:ring-fuchsia-500" />
          <span class="absolute right-3 top-2.5 text-neutral-400">⌕</span>
        </div>
        <button id="btnNew" class="px-3 py-2 text-sm text-white rounded-xl bg-fuchsia-900 hover:bg-fuchsia-700">New</button>
      </div>

      <!-- Conversations scroll -->
      <div id="convList" class="flex-1 overflow-y-auto divide-y divide-neutral-100"></div>

      <!-- Footer (optional presence hint) -->
      <div class="p-3 text-xs border-t text-neutral-500 border-neutral-200">Inbox • AJAX polling</div>
    </aside>

    <!-- Right: Conversation Thread -->
    <main class="flex flex-col h-full col-span-8 overflow-hidden bg-white">
      <!-- Header: selected conversation info -->
      <div id="threadHeader" class="h-[56px] border-b border-neutral-200 px-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <img id="threadAvatar" src="{{ asset('images/default-avatar.png') }}" class="object-cover rounded-full w-9 h-9 bg-neutral-200" alt="" />
          <div>
            <div id="threadTitle" class="font-semibold">Select a chat</div>
            <div id="threadSubtitle" class="text-xs text-neutral-500"></div>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <button id="btnStartGroup" class="hidden rounded-lg px-3 py-1.5 text-sm border border-neutral-300 hover:bg-neutral-100">New Group</button>
        </div>
      </div>

      <!-- Messages area -->
      <div id="messagesScroll" class="flex-1 p-4 space-y-2 overflow-y-auto bg-white">
        <div id="emptyState" class="grid w-full h-full place-items-center text-neutral-400">Open a conversation to begin</div>
        <div id="messages" class="flex flex-col hidden gap-2"></div>
      </div>

      <!-- Composer -->
      <div class="p-3 border-t border-neutral-200 bg-neutral-50">
        <form id="composer" class="flex items-end gap-2">
          <label class="inline-flex items-center gap-2 px-3 py-2 text-sm border rounded-lg cursor-pointer text-neutral-600 border-neutral-300 hover:bg-neutral-100">
            <input id="fileInput" type="file" class="hidden" accept="image/*,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
            <span>Attach</span>
            <span id="fileName" class="text-neutral-500"></span>
          </label>
          <textarea id="msgInput" rows="1" placeholder="Type a message" class="flex-1 px-3 py-2 text-sm bg-white border resize-none rounded-xl border-neutral-300 focus:outline-none focus:ring-2 focus:ring-fuchsia-500"></textarea>
          <button id="btnSend" class="px-4 py-2 text-sm text-white rounded-xl bg-fuchsia-800 hover:bg-fuchsia-900">Send</button>
        </form>
        <div id="composerHint" class="mt-1 text-xs text-neutral-400">Files: images, PDF, DOCX • Max 25MB • 1 file</div>
      </div>
    </main>
  </div>

  <!-- Modal: New (choose direct/group) -->
  <div id="modalNew" class="fixed inset-0 z-40 hidden bg-black/40">
    <div class="absolute inset-0 flex items-center justify-center p-4">
      <div class="w-full max-w-sm p-4 bg-white shadow-xl rounded-2xl">
        <div class="mb-3 font-semibold">Start</div>
        <div class="grid gap-2">
          <button id="startDirect" class="px-3 py-2 border rounded-xl border-neutral-300 hover:bg-neutral-100">New chat</button>
          <button id="startGroup" class="px-3 py-2 border rounded-xl border-neutral-300 hover:bg-neutral-100">New group</button>
        </div>
        <div class="mt-4 text-right">
          <button class="text-sm text-neutral-500 hover:text-neutral-700" onclick="hideModal('modalNew')">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: New chat (direct) -->
  <div id="modalDirect" class="fixed inset-0 z-40 hidden bg-black/40">
    <div class="absolute inset-0 flex items-center justify-center p-4">
      <div class="w-full max-w-lg p-4 bg-white shadow-xl rounded-2xl">
        <div class="mb-3 font-semibold">New chat</div>
        <div class="flex items-center gap-2 mb-3">
          <input id="userSearch" type="text" placeholder="Search people by name, role, email" class="flex-1 px-3 py-2 text-sm border rounded-xl border-neutral-300"/>
          <button id="userSearchBtn" class="px-3 py-2 text-sm border rounded-lg border-neutral-300 hover:bg-neutral-100">Search</button>
        </div>
        <div id="userResults" class="overflow-y-auto divide-y max-h-72 divide-neutral-100"></div>
        <div class="flex justify-end gap-2 mt-4">
          <button class="text-sm text-neutral-500 hover:text-neutral-700" onclick="hideModal('modalDirect')">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: New group -->
  <div id="modalGroup" class="fixed inset-0 z-40 hidden bg-black/40">
    <div class="absolute inset-0 flex items-center justify-center p-4">
      <div class="w-full max-w-xl p-4 bg-white shadow-xl rounded-2xl">
        <div class="mb-3 font-semibold">New group</div>
        <input id="groupName" type="text" placeholder="Group name" class="w-full px-3 py-2 mb-3 text-sm border rounded-xl border-neutral-300"/>
        <div class="flex items-center gap-2 mb-3">
          <input id="groupUserSearch" type="text" placeholder="Search people" class="flex-1 px-3 py-2 text-sm border rounded-xl border-neutral-300"/>
          <button id="groupSearchBtn" class="px-3 py-2 text-sm border rounded-lg border-neutral-300 hover:bg-neutral-100">Search</button>
        </div>
        <div id="groupUserResults" class="overflow-y-auto divide-y max-h-72 divide-neutral-100"></div>
        <div class="flex items-center justify-between mt-4">
          <div class="text-xs text-neutral-500">Max 10 members (including you)</div>
          <div class="flex gap-2">
            <button class="text-sm text-neutral-500 hover:text-neutral-700" onclick="hideModal('modalGroup')">Cancel</button>
            <button id="createGroupBtn" class="px-4 py-2 text-sm text-white rounded-xl bg-fuchsia-600 hover:bg-fuchsia-700">Create</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // ======= Config =======
    const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const ROUTES = {
      conversations: '/conversations',
      messages: (id) => `/conversations/${id}/messages`,
      markRead: (id) => `/conversations/${id}/read`,
      sendMessage: (id) => `/conversations/${id}/messages`,
      direct: '/conversations/direct',
      group: '/conversations/group',
      userSearch: '/users/search',
      hide: (mid) => `/messages/${mid}/hide`,
    };
    const PLACEHOLDER_AVATAR = "{{ asset('images/default-avatar.png') }}";

    // ======= State =======
    let state = {
      convPage: 1,
      query: '',
      conversations: [],
      selected: null, // { id, type, title, subtitle, avatar }
      messages: [],
      cursors: { before: null, after: null },
      pollingTimers: { list: null, thread: null },
      pendingFile: null,
    };

    // ======= Helpers =======
    function htmx(str){
      const t = document.createElement('template');
      t.innerHTML = str.trim();
      return t.content.firstChild;
    }
    function timeAgo(dt){
      if(!dt) return '';
      const d = new Date(dt);
      const diff = (Date.now() - d.getTime())/1000;
      if(diff < 60) return 'Now';
      if(diff < 3600) return Math.floor(diff/60)+' mins ago';
      if(diff < 86400) return Math.floor(diff/3600)+' hrs ago';
      return d.toLocaleDateString();
    }
    function fileSizeFmt(bytes){
      if(bytes == null) return '';
      const units=['B','KB','MB','GB'];
      let i=0; let v=bytes;
      while(v>=1024 && i<units.length-1){ v/=1024; i++; }
      return v.toFixed(1)+' '+units[i];
    }
    function showModal(id){ document.getElementById(id).classList.remove('hidden'); }
    function hideModal(id){ document.getElementById(id).classList.add('hidden'); }

    // ======= Conversation List =======
    async function fetchConversations(){
      const url = new URL(ROUTES.conversations, window.location.origin);
      if(state.query) url.searchParams.set('query', state.query);
      url.searchParams.set('page', state.convPage);
      const res = await fetch(url, { headers: { 'Accept':'application/json' } });
      const json = await res.json();
      state.conversations = json.data || [];
      renderConversations();
    }

    function renderConversations(){
      const box = document.getElementById('convList');
      box.innerHTML = '';
      state.conversations.forEach(item => {
        const avatar = item.avatar || PLACEHOLDER_AVATAR;
        const row = htmx(`
          <button type="button" class="flex items-center w-full gap-3 p-3 text-left hover:bg-neutral-50">
            <div class="relative">
              <img src="${avatar}" class="object-cover w-10 h-10 rounded-full bg-neutral-200"/>
              ${item.has_unread ? '<span class="absolute -right-0.5 -top-0.5 w-2.5 h-2.5 rounded-full bg-fuchsia-600"></span>' : ''}
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between gap-2">
                <div class="font-medium truncate">${item.title || 'Unknown'}</div>
                <div class="text-xs text-neutral-400">${timeAgo(item.last_message_at)}</div>
              </div>
              <div class="text-xs truncate text-neutral-500">${item.preview ? (item.preview_is_me ? 'You: ' : '') + item.preview : ''}</div>
              ${item.subtitle ? `<div class='text-[11px] text-neutral-400'>${item.subtitle}</div>` : ''}
            </div>
          </button>
        `);
        row.addEventListener('click', () => openConversation(item));
        box.appendChild(row);
      });
    }

    // ======= Open Conversation & Messages =======
    async function openConversation(item){
      state.selected = item;
      document.getElementById('threadAvatar').src = item.avatar || PLACEHOLDER_AVATAR;
      document.getElementById('threadTitle').textContent = item.title || '';
      document.getElementById('threadSubtitle').textContent = item.subtitle || '';

      document.getElementById('emptyState').classList.add('hidden');
      document.getElementById('messages').classList.remove('hidden');
      state.messages = [];
      state.cursors = { before:null, after:null };
      renderMessages();

      // initial fetch
      await fetchMessages(item.id);
      // mark read
      await fetch(ROUTES.markRead(item.id), { method:'POST', headers:{ 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' } });

      // start polling new messages every 10s
      if(state.pollingTimers.thread) clearInterval(state.pollingTimers.thread);
      state.pollingTimers.thread = setInterval(() => pollNewMessages(item.id), 10000);
    }

    async function fetchMessages(conversationId, beforeId=null){
      const url = new URL(ROUTES.messages(conversationId), window.location.origin);
      if(beforeId) url.searchParams.set('before_id', beforeId);
      url.searchParams.set('limit', 30);
      const res = await fetch(url, { headers:{ 'Accept':'application/json' } });
      const json = await res.json();
      const list = json.data || [];
      // We render newest at bottom -> we keep state.messages in ascending order of time.
      // API returns newest-first; so prepend in reverse by unshifting.
      state.messages = [...list.reverse(), ...state.messages];
      state.cursors.before = json.meta?.next_before_id || null;
      state.cursors.after  = json.meta?.next_after_id  || state.cursors.after;
      renderMessages();
      // scroll to bottom on first load
      const box = document.getElementById('messagesScroll');
      box.scrollTop = box.scrollHeight;
    }

    async function pollNewMessages(conversationId){
      const url = new URL(ROUTES.messages(conversationId), window.location.origin);
      if(state.cursors.after) url.searchParams.set('after_id', state.cursors.after);
      url.searchParams.set('limit', 30);
      const res = await fetch(url, { headers:{ 'Accept':'application/json' } });
      const json = await res.json();
      const list = json.data || [];
      if(list.length){
        // list is newest-first; we want to append in chronological order
        list.reverse().forEach(m => state.messages.push(m));
        state.cursors.after = json.meta?.next_after_id || state.cursors.after;
        renderMessages();
        const box = document.getElementById('messagesScroll');
        box.scrollTop = box.scrollHeight;
      }
    }

    function renderMessages(){
      const wrap = document.getElementById('messages');
      wrap.innerHTML = '';
      state.messages.forEach(m => {
        const mine = m.is_me;
        const bubble = htmx(`
          <div class="flex ${mine ? 'justify-end' : 'justify-start'}">
            <div class="max-w-[70%] rounded-2xl px-3 py-2 text-sm ${mine ? 'bg-fuchsia-600 text-white' : 'bg-neutral-100 text-neutral-800'}">
              ${m.type === 'text' ? `<div class="whitespace-pre-wrap">${escapeHtml(m.body || '')}</div>` : ''}
              ${m.type === 'file' ? fileChip(m.file, mine) : ''}
              ${m.type === 'system' ? `<div class='text-xs text-neutral-500'>${escapeHtml(m.body || '')}</div>` : ''}
              <div class="mt-1 text-[10px] ${mine ? 'text-fuchsia-100' : 'text-neutral-500'} flex items-center gap-1 justify-end">
                <span>${m.created_at_time || ''}</span>
                ${m.type !== 'system' ? `<span>${m.ticks || '✓'}</span>` : ''}
              </div>
              <div class="mt-1 text-[10px] text-neutral-400 ${mine ? 'hidden' : ''}">
                <button class="underline" onclick="hideMessage(${m.id})">Delete for me</button>
              </div>
            </div>
          </div>
        `);
        wrap.appendChild(bubble);
      });
    }

    function fileChip(file, mine){
      if(!file) return '';
      const name = escapeHtml(file.name || 'file');
      const size = fileSizeFmt(file.size);
      const url  = file.url || '#';
      const mime = file.mimetype || '';
      return `
        <a href="${url}" target="_blank" class="block rounded-lg ${mine ? 'bg-fuchsia-700/30' : 'bg-white'} border border-neutral-200 px-3 py-2 mt-1">
          <div class="text-xs font-medium truncate">${name}</div>
          <div class="text-[10px] text-neutral-500">${mime} • ${size}</div>
        </a>
      `;
    }

    async function hideMessage(messageId){
      await fetch(ROUTES.hide(messageId), { method:'POST', headers:{ 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' } });
      // remove locally
      state.messages = state.messages.filter(x => x.id !== messageId);
      renderMessages();
    }

    // ======= Composer =======
    document.getElementById('fileInput').addEventListener('change', (e)=>{
      const f = e.target.files[0];
      state.pendingFile = f || null;
      document.getElementById('fileName').textContent = f ? `(${f.name})` : '';
    });

    document.getElementById('composer').addEventListener('submit', async (e)=>{
      e.preventDefault();
      if(!state.selected) return;
      const convId = state.selected.id;

      if(state.pendingFile){
        // validate 25MB
        if(state.pendingFile.size > 25*1024*1024){
          alert('File too large. Max 25MB.');
          return;
        }
        const fd = new FormData();
        fd.append('type', 'file');
        fd.append('file', state.pendingFile);
        const res = await fetch(ROUTES.sendMessage(convId), { method:'POST', headers:{ 'X-CSRF-TOKEN': CSRF }, body: fd });
        const json = await res.json();
        if(json?.data){ state.messages.push(json.data); renderMessages(); document.getElementById('messagesScroll').scrollTop = document.getElementById('messagesScroll').scrollHeight; }
        state.pendingFile = null; document.getElementById('fileInput').value=''; document.getElementById('fileName').textContent='';
        return;
      }

      const body = document.getElementById('msgInput').value.trim();
      if(!body) return;
      const payload = { type:'text', body };
      const res = await fetch(ROUTES.sendMessage(convId), { method:'POST', headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' }, body: JSON.stringify(payload) });
      const json = await res.json();
      if(json?.data){ state.messages.push(json.data); renderMessages(); document.getElementById('messagesScroll').scrollTop = document.getElementById('messagesScroll').scrollHeight; }
      document.getElementById('msgInput').value='';
    });

    // ======= New Buttons & Modals =======
    document.getElementById('btnNew').addEventListener('click', ()=> showModal('modalNew'));
    document.getElementById('startDirect').addEventListener('click', ()=> {
      hideModal('modalNew');
      showModal('modalDirect');
      document.getElementById('userSearch').value = '';
      fetchUsers('#userResults', '');
    });
    document.getElementById('startGroup').addEventListener('click', ()=> {
      hideModal('modalNew');
      showModal('modalGroup');
      document.getElementById('groupUserSearch').value = '';
      fetchUsers('#groupUserResults', '', true);
    });

    // Search users for Direct
    document.getElementById('userSearchBtn').addEventListener('click', ()=> fetchUsers('#userResults', document.getElementById('userSearch').value));
    document.getElementById('userSearch').addEventListener('keydown', (e)=>{ if(e.key==='Enter'){ e.preventDefault(); fetchUsers('#userResults', e.target.value); }});

    // Search users for Group
    document.getElementById('groupSearchBtn').addEventListener('click', ()=> fetchUsers('#groupUserResults', document.getElementById('groupUserSearch').value, true));
    document.getElementById('groupUserSearch').addEventListener('keydown', (e)=>{ if(e.key==='Enter'){ e.preventDefault(); fetchUsers('#groupUserResults', e.target.value, true); }});

    async function fetchUsers(targetSelector, q='', withCheckbox=false){
      const url = new URL(ROUTES.userSearch, window.location.origin);
      if(q) url.searchParams.set('q', q);
      const res = await fetch(url, { headers:{ 'Accept':'application/json' } });
      const json = await res.json();
      const list = json.data || [];
      const box = document.querySelector(targetSelector);
      box.innerHTML = '';

      if(list.length === 0){
        box.innerHTML = '<div class="p-3 text-sm text-neutral-500">No users found.</div>';
        return;
      }

      list.forEach(u => {
        const avatar = u.avatar || PLACEHOLDER_AVATAR;
        if(withCheckbox){
          const row = htmx(`
            <div class="flex items-center gap-3 p-2 transition-colors border border-transparent rounded-lg cursor-pointer group-user-row hover:bg-neutral-100" role="button" tabindex="0">
              <input type='checkbox' value='${u.id}' class='w-4 h-4 mr-2 rounded group-user-checkbox text-fuchsia-600 border-neutral-300'>
              <img src="${avatar}" class="object-cover w-8 h-8 rounded-full bg-neutral-200"/>
              <div class="flex-1 min-w-0">
                <div class="text-sm font-medium truncate">${escapeHtml(u.name || 'Unknown')}</div>
                <div class="text-xs truncate text-neutral-500">${escapeHtml(u.designation || '')}</div>
              </div>
            </div>
          `);
          const checkbox = row.querySelector('.group-user-checkbox');
          const refresh = () => {
            if (checkbox.checked) {
              row.classList.add('bg-fuchsia-50', 'border-fuchsia-200');
              row.classList.remove('border-transparent');
            } else {
              row.classList.remove('bg-fuchsia-50', 'border-fuchsia-200');
              row.classList.add('border-transparent');
            }
          };
          row.addEventListener('click', (e) => {
            if (e.target !== checkbox) { 
              checkbox.checked = !checkbox.checked;
              refresh();
            }
          });
          checkbox.addEventListener('change', refresh);
          row.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              checkbox.checked = !checkbox.checked;
              refresh();
            }
          });
          refresh();
          box.appendChild(row);
        } else {
          const row = htmx(`
            <button type="button" class="flex items-center w-full gap-3 p-2 text-left rounded-lg hover:bg-neutral-100">
              <img src="${avatar}" class="object-cover w-8 h-8 rounded-full bg-neutral-200"/>
              <div class="flex-1 min-w-0">
                <div class="text-sm font-medium truncate">${escapeHtml(u.name || 'Unknown')}</div>
                <div class="text-xs truncate text-neutral-500">${escapeHtml(u.designation || '')}</div>
              </div>
            </button>
          `);
          row.addEventListener('click', ()=> createDirect(u.id));
          box.appendChild(row);
        }
      });
    }

    async function createDirect(userId){
      const res = await fetch(ROUTES.direct, { method:'POST', headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' }, body: JSON.stringify({ user_id: userId }) });
      const json = await res.json();
      hideModal('modalDirect');
      // refresh list and open
      await fetchConversations();
      const conv = state.conversations.find(c => c.id === json.data?.id);
      if(conv) openConversation(conv);
    }

    document.getElementById('createGroupBtn').addEventListener('click', async ()=>{
      const title = document.getElementById('groupName').value.trim();
      if(!title){ alert('Enter group name'); return; }
      const ids = Array.from(document.querySelectorAll('.group-user-checkbox:checked')).map(cb => parseInt(cb.value,10));
      if(ids.length === 0){ alert('Select at least one member'); return; }
      if(ids.length + 1 > 10){ alert('Max 10 members including you'); return; }
      const res = await fetch(ROUTES.group, { method:'POST', headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' }, body: JSON.stringify({ title, member_ids: ids }) });
      const json = await res.json();
      hideModal('modalGroup'); document.getElementById('groupName').value='';
      await fetchConversations();
      const conv = state.conversations.find(c => c.id === json.data?.id);
      if(conv) openConversation(conv);
    });

    // ======= Search conversations =======
    document.getElementById('convSearch').addEventListener('input', (e)=>{
      state.query = e.target.value;
      fetchConversations();
    });

    // ======= Left list polling =======
    function startListPolling(){
      if(state.pollingTimers.list) clearInterval(state.pollingTimers.list);
      state.pollingTimers.list = setInterval(fetchConversations, 15000);
    }

    // ======= Utilities =======
    function escapeHtml(text){
      const map = { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#039;' };
      return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // ======= Init =======
    (async function init(){
      await fetchConversations();
      startListPolling();
    })();
  </script>
  </div>
</main>


</x-layouts.app>
