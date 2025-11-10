<x-layouts.app>
  <x-slot name="header">
    @include('admin.layouts.header')
  </x-slot>

  {{-- Make BOOKED projects available to JS --}}
  <style>
    /* Toolbar buttons */
    .fc .fc-button { background:#F7D847; border-color:#F7D847; color:#111827; box-shadow:none; }
    .fc .fc-button:disabled { opacity:.85; }
    .fc .fc-button-primary:not(:disabled).fc-button-active,
    .fc .fc-button-primary:not(:disabled):active,
    .fc .fc-button-primary:focus { background:#5A0562; border-color:#5A0562; color:#fff; }
    .fc .fc-button-primary:hover:not(:disabled){ filter:brightness(.95); }

    /* Event chip with vertical bar */
    .fc-event.custom-pill { border:0!important; background:transparent!important; padding:0!important; }
    .fc-event.custom-pill .pill{
      display:flex; align-items:center; gap:8px; border-radius:10px; padding:2px 8px;
      border:1px solid #e5e7eb; background:#fff;
    }
    .fc-event.custom-pill .bar{ width:6px; align-self:stretch; border-radius:4px; background:#ccc; }
    .fc-event.custom-pill .title{
      font-size:12px; color:#111827; line-height:1.2; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
      max-width:140px;
    }

    /* Simple popover shell */
    .install-pop{
      position:absolute; z-index:10050; width:360px; background:#fff; border:1px solid #eee;
      border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); padding:16px;
    }
    .install-pop .row{ display:flex; gap:8px; align-items:center; margin:6px 0; }
    .icon-btn{ width:34px; height:34px; border:1px solid #e5e7eb; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .btn-ghost{ border:1px solid #e5e7eb; border-radius:10px; padding:6px 10px; background:#fff; }
  </style>

  <main>

    <script>
      window.BOOKED_PROJECTS = @json($bookedProjects ?? []);
    </script>

    <div class="mb-3 flex items-center justify-between px-3 sm:px-4">
      <h2 class="text-lg font-semibold text-gray-900">Installations</h2>
      <button id="btn-open-create" class="px-4 py-2 rounded-full bg-fuchsia-700 text-white text-sm hover:bg-fuchsia-800">
        + New Installation
      </button>
    </div>

    <div class="p-3 sm:p-4">
      <div class="rounded-[20px] border border-gray-200 bg-white shadow-sm p-4">
        <div id="calendar"></div>
      </div>
    </div>

    {{-- Create Installation Modal --}}
    <div id="install-modal" class="fixed inset-0 z-[10000] hidden">
      <div class="absolute inset-0 bg-black/30"></div>
      <div class="absolute left-1/2 top-1/2 w-full max-w-[420px] -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white shadow-xl p-5">
        <div class="flex items-center justify-between mb-3">
          {{-- <h3 class="text-base font-semibold text-gray-900">New Installation</h3> --}}
          <h3 class="text-base font-semibold text-gray-900" id="install-modal-title">New Installation</h3>

          <button id="install-modal-close" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center">✕</button>
        </div>

        <form id="install-form" class="space-y-3">
          <div>
            <input type="hidden" id="install-id" value="">

            <label class="block text-sm font-medium text-gray-700">Project</label>
            <select id="install-project" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-fuchsia-600 focus:border-fuchsia-600" required>
              <option value="" selected disabled>Choose a booked project…</option>
              @forelse($bookedProjects as $p)
                <option value="{{ $p->id }}"> {{ $p->name }} (ID: {{ $p->id }})</option>
              @empty
                <option value="" disabled>No BOOKED projects found</option>
              @endforelse
            </select>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-sm font-medium text-gray-700">Date</label>
              <input type="date" id="install-date" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-fuchsia-600 focus:border-fuchsia-600" required>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Time</label>
              <input type="time" id="install-time" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-fuchsia-600 focus:border-fuchsia-600" required>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Notes</label>
            <textarea id="install-notes" rows="3" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-fuchsia-600 focus:border-fuchsia-600" placeholder="Optional"></textarea>
          </div>

          <p id="install-error" class="hidden mt-2 text-sm text-red-600"></p>

          <div class="pt-2 flex items-center justify-end gap-2">
            {{-- <button type="submit" class="w-full px-3 py-1.5 rounded-lg bg-fuchsia-900 text-white text-sm hover:bg-fuchsia-800">Schedule</button> --}}

        <button type="submit" id="install-submit-btn"
  class="w-full px-3 py-1.5 rounded-lg bg-fuchsia-900 text-white text-sm hover:bg-fuchsia-800">
  Reschedule
</button>
        </div>
        </form>
      </div>
    </div>
  </main>

  {{-- Iconify + FullCalendar --}}
  <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
  <link  href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

  <script>
  (function(){
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const csrf = '{{ csrf_token() }}';

    // --- Popover state & outside click guards ---
    let popEl = null;
    let popAnchorEl = null;         // the event element that spawned the pop
    let suppressDocCloseOnce = false; // ignore the opening click

    function closePop(){
      if (popEl){ popEl.remove(); popEl=null; }
      popAnchorEl = null;
    }

    document.addEventListener('click', (e)=>{
      if (!popEl) return;
      if (suppressDocCloseOnce) {   // ignore the click that opened the pop
        suppressDocCloseOnce = false;
        return;
      }
      // if click is inside the pop, do nothing
      if (popEl.contains(e.target)) return;
      // if click is on the event element that created the pop, do nothing
      if (popAnchorEl && popAnchorEl.contains(e.target)) return;
      closePop();
    });

    document.addEventListener('keydown', (e)=>{ if (e.key === 'Escape') closePop(); });

    // stable color per project (hash)
    const palette = ['#5A0562','#F59E0B','#10B981','#3B82F6','#EF4444','#8B5CF6','#14B8A6','#F43F5E'];
    function hashColor(key){
      const s = String(key||''); let h = 0;
      for (let i=0;i<s.length;i++){ h = (h<<5)-h + s.charCodeAt(i); h |= 0; }
      return palette[Math.abs(h) % palette.length];
    }
    function rgba(hex, a=.15){
      const m = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
      if(!m) return `rgba(90,5,98,${a})`;
      return `rgba(${parseInt(m[1],16)},${parseInt(m[2],16)},${parseInt(m[3],16)},${a})`;
    }
    function longDate(ymd){
      const d = new Date(ymd); if(Number.isNaN(d.getTime())) return '—';
      return d.toLocaleDateString(undefined,{weekday:'long', month:'long', day:'numeric'});
    }
// --- Popover builder ---
function buildInstallPopover({ anchorEl, title, dateStr, notes, figma_url, image_url, color, id, extProps }) {
  closePop();
  popAnchorEl = anchorEl;

  popEl = document.createElement('div');
  popEl.className = 'install-pop';
  popEl.innerHTML = `
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
      <div style="font-size:18px;font-weight:700">${title||'(Untitled)'}</div>
      <button type="button" id="btn-close" class="icon-btn" title="Close">✕</button>
    </div>

    <div class="row">
      <span class="iconify" data-icon="ph:calendar-blank" style="color:${color};font-size:18px"></span>
      <div>${longDate(dateStr)}</div>
    </div>

    ${image_url ? `
      <div style="margin:8px 0">
        <img src="${image_url}" alt="Attachment" style="width:100%; height:140px; object-fit:cover; border-radius:12px; border:1px solid #eee"/>
      </div>` : ''}

    <div class="row" style="align-items:flex-start">
      <span class="iconify" data-icon="ph:notepad" style="color:${color};font-size:18px"></span>
      <div style="color:#6b7280; line-height:1.25">${notes||'—'}</div>
    </div>

    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:10px">
      <div style="display:flex;gap:8px;align-items:center">
        ${figma_url ? `<a href="${figma_url}" target="_blank" class="btn-ghost" style="text-decoration:none">Open Figma</a>` : ''}
      </div>
      <div style="display:flex; gap:8px">
        <button class="icon-btn" id="btn-edit" title="Edit"><span class="iconify" data-icon="ph:pencil-simple-line"></span></button>
        <button class="icon-btn" id="btn-del" title="Delete"><span class="iconify" data-icon="ph:trash-simple"></span></button>
      </div>
    </div>
  `;
  document.body.appendChild(popEl);

  const rect = anchorEl.getBoundingClientRect();
  popEl.style.top  = (window.scrollY + rect.top + rect.height + 8) + 'px';
  popEl.style.left = Math.min(window.scrollX + rect.left, window.scrollX + window.innerWidth - 380) + 'px';

  popEl.querySelector('#btn-close')?.addEventListener('click', closePop);

  popEl.querySelector('#btn-del')?.addEventListener('click', async ()=>{
    if (!confirm('Delete this installation?')) return;
    await fetch(`{{ route('admin.installations.destroy', ['installation' => 'ID']) }}`.replace('ID', id), {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json' },
      credentials: 'same-origin'
    });
    closePop();
    window.__installCalendar?.refetchEvents();
  });

  // ⭐ NEW: Edit opens the same modal prefilled (uses global hook from your second <script>)
  popEl.querySelector('#btn-edit')?.addEventListener('click', () => {
    const prefill = {
      id,
      project_id: extProps?.project_id ?? null,
      date: extProps?.install_date || dateStr || '',
      time: extProps?.install_time || '',
      notes: extProps?.notes || ''
    };
    if (window.__openInstallEditor) window.__openInstallEditor(prefill);
    closePop();
  });

  // keep the pop from closing immediately on the same click
  suppressDocCloseOnce = true;
}


    // --- FullCalendar ---
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      timeZone: 'local',
      height: 'auto',
      headerToolbar: { left:'prev,next today', center:'title', right:'dayGridMonth,timeGridWeek,timeGridDay' },

      // Feed from DB – all-day using only install_date
      events: (info, success, failure) => {
        const url = '{{ route('admin.installations.feed') }}'
          + '?start=' + encodeURIComponent(info.startStr)
          + '&end='   + encodeURIComponent(info.endStr);

        fetch(url, { method:'GET', credentials:'same-origin', headers:{ 'Accept':'application/json' } })
          .then(async res => {
            const txt = await res.text();
            if (!res.ok) throw new Error(txt || ('HTTP '+res.status));
            const raw = JSON.parse(txt);

            const mapped = raw.map(ev => {
              const pid   = (ev.extendedProps && ev.extendedProps.project_id) ?? ev.title ?? ev.id;
              const color = (ev.extendedProps && ev.extendedProps.color) || hashColor(pid);
              return {
                ...ev,
                allDay: true,
                classNames: ['custom-pill'],
                extendedProps: { ...(ev.extendedProps||{}), color },
                backgroundColor: rgba(color, .15),
                borderColor: 'transparent',
                textColor: '#111827'
              };
            });
            success(mapped);
          })
          .catch(err => { console.error(err); alert('Failed to load installations.'); failure(err); });
      },

      eventClassNames(){ return ['custom-pill']; },
      eventContent(arg){
        const color = arg.event.extendedProps.color || '#5A0562';
        const title = arg.event.title || '(Untitled)';
        const root  = document.createElement('div');
        root.innerHTML = `
          <div class="pill" style="background:${rgba(color,.15)}">
            <div class="bar" style="background:${color}"></div>
            <div class="title" title="${title}">${title}</div>
          </div>`;
        return { domNodes: [root] };
      },

    eventClick(info){
  // prevent pop from closing on same click
  if (info.jsEvent && info.jsEvent.stopPropagation) info.jsEvent.stopPropagation();

  const x   = info.event.extendedProps || {};
  const ymd = x.install_date || info.event.startStr;

  buildInstallPopover({
    anchorEl: info.el,
    title: info.event.title,
    dateStr: ymd,
    notes: x.notes,
    figma_url: x.figma_url || null,
    image_url: x.image_url || null,
    color: x.color || '#5A0562',
    id: info.event.id,
    extProps: x       // ⭐ pass extendedProps to the popover
  });
}

    });

    window.__installCalendar = calendar;
    calendar.render();
  })();
  </script>

  <script>
(function(){
  const csrf = '{{ csrf_token() }}';

  const modal      = document.getElementById('install-modal');
  const btnOpen    = document.getElementById('btn-open-create');
  const btnClose   = document.getElementById('install-modal-close');
  const btnCancel  = document.getElementById('install-cancel');
  const form       = document.getElementById('install-form');
  const errBox     = document.getElementById('install-error');

  // NEW: edit-mode handles
  const fldId      = document.getElementById('install-id');
  const titleEl    = document.getElementById('install-modal-title');
  const submitEl   = document.getElementById('install-submit-btn');

  const fldProject = document.getElementById('install-project');
  const fldDate    = document.getElementById('install-date');
  const fldTime    = document.getElementById('install-time');
  const fldNotes   = document.getElementById('install-notes');

  function setMode(isEdit){
    if (titleEl)  titleEl.textContent  = isEdit ? 'Edit Installation' : 'New Installation';
    if (submitEl) submitEl.textContent = isEdit ? 'Save changes'      : 'Schedule';
  }

  function openModal(prefill = {}) {
    const isEdit = !!prefill.id;
    // id (empty = create, value = edit)
    if (fldId) fldId.value = isEdit ? String(prefill.id) : '';

    // prefill values
    fldProject.value = prefill.project_id ? String(prefill.project_id) : '';
    fldDate.value    = prefill.date || '';
    fldTime.value    = prefill.time || '';
    fldNotes.value   = prefill.notes || '';

    setMode(isEdit);
    errBox.classList.add('hidden');
    modal.classList.remove('hidden');
  }
  function closeModal(){ modal.classList.add('hidden'); }

  // expose for the popover “Edit” button (Part 1 calls this)
  window.__openInstallEditor = openModal;

  // existing create button → open in create mode (no prefill)
  btnOpen?.addEventListener('click', ()=> openModal());
  btnClose?.addEventListener('click', closeModal);
  btnCancel?.addEventListener('click', closeModal);
  document.addEventListener('keydown', (e)=>{ if (e.key === 'Escape') closeModal(); });

  form.addEventListener('submit', async (e)=>{
    e.preventDefault();
    errBox.classList.add('hidden');

    const isEdit = !!(fldId && fldId.value);

    const payload = {
      project_id: Number(fldProject.value),
      install_date: fldDate.value,  // YYYY-MM-DD
      install_time: fldTime.value,  // HH:MM
      notes: fldNotes.value || null
    };

    try {
      if (!payload.project_id) throw new Error('Please select a project.');
      if (!payload.install_date || !payload.install_time) throw new Error('Date and Time are required.');

      let url, method;
      if (isEdit) {
        // UPDATE
        url    = `{{ route('admin.installations.update', ['installation' => 'ID']) }}`.replace('ID', fldId.value);
        method = 'PATCH';
      } else {
        // CREATE (existing)
        url    = `{{ route('admin.installations.store') }}`;
        method = 'POST';
      }

      const res = await fetch(url, {
        method,
        headers: {
          'X-CSRF-TOKEN': csrf,
          'X-Requested-With': 'XMLHttpRequest',
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify(payload)
      });

      if (!res.ok) {
        const text = await res.text();
        let msg = `HTTP ${res.status}`;
        try {
          const j = JSON.parse(text);
          if (j?.errors) msg = Object.entries(j.errors).map(([k,v]) => `${k}: ${v.join(', ')}`).join('\n');
          else if (j?.message) msg = j.message; else msg = text.slice(0, 500);
        } catch { msg = text.slice(0, 500); }
        throw new Error(msg);
      }

      // refresh calendar & close
      window.__installCalendar?.refetchEvents();
      closeModal();
    } catch (err) {
      errBox.textContent = err.message || 'Failed to save.';
      errBox.classList.remove('hidden');
    }
  });
})();
</script>

</x-layouts.app>
