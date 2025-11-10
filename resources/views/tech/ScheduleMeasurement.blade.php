<x-tech-layout>
  <x-slot name="header">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
  </x-slot>

  @php
      $projects = $projects ?? collect();
  @endphp

  <script>
    window.ASSIGNED_PROJECTS = @json($projects);
  </script>

  {{-- <main class="flex-1  min-h-screen bg-[#F9F7F7] pt-24 pb-12 overflow-x-hidden"> --}}
        <main>

    <div class="px-4 sm:px-6 lg:px-8">
      <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-2xl font-semibold text-slate-900">Measurement Schedule</h1>
          <p class="mt-1 text-sm text-slate-600">Manage measurement appointments for projects assigned to you.</p>
        </div>
        <button id="measurement-create-open" class="inline-flex items-center justify-center rounded-full bg-fuchsia-700 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-fuchsia-800 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:ring-offset-2">
          + Schedule Measurement
        </button>
      </div>

      <div class="rounded-[20px] border border-slate-200 bg-white shadow-sm p-4">
        <div id="measurement-calendar"></div>
      </div>
    </div>
  </main>

  {{-- Modal --}}
  <div id="measurement-modal" class="fixed inset-0 z-[10000] hidden">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="absolute left-1/2 top-1/2 w-full max-w-[420px] -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white p-5 shadow-xl">
      <div class="mb-4 flex items-center justify-between">
        <h3 id="measurement-modal-title" class="text-base font-semibold text-slate-900">Schedule Measurement</h3>
        <button id="measurement-modal-close" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-500 hover:text-slate-900">
          <span class="iconify" data-icon="ph:x-bold"></span>
        </button>
      </div>

      <form id="measurement-form" class="space-y-4">
        <input type="hidden" id="measurement-id">

        <div class="space-y-1.5">
          <label class="text-sm font-medium text-slate-700">Project</label>
          <select id="measurement-project" class="w-full rounded-lg border-slate-300 text-sm focus:border-fuchsia-600 focus:ring-fuchsia-600" required>
            <option value="" disabled selected>Select a project</option>
            @forelse($projects as $project)
              <option value="{{ $project->id }}">{{ $project->name }} (ID: {{ $project->id }})</option>
            @empty
              <option value="" disabled>No assigned projects found</option>
            @endforelse
          </select>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div class="space-y-1.5">
            <label class="text-sm font-medium text-slate-700">Date</label>
            <input type="date" id="measurement-date" class="w-full rounded-lg border-slate-300 text-sm focus:border-fuchsia-600 focus:ring-fuchsia-600" required>
          </div>
          <div class="space-y-1.5">
            <label class="text-sm font-medium text-slate-700">Start Time</label>
            <input type="time" id="measurement-time" class="w-full rounded-lg border-slate-300 text-sm focus:border-fuchsia-600 focus:ring-fuchsia-600" required>
          </div>
        </div>

        <div class="space-y-1.5">
          <label class="text-sm font-medium text-slate-700">Duration</label>
          <select id="measurement-duration" class="w-full rounded-lg border-slate-300 text-sm focus:border-fuchsia-600 focus:ring-fuchsia-600">
            <option value="60" selected>1 hour</option>
            <option value="90">1 hr 30 mins</option>
            <option value="120">2 hours</option>
            <option value="150">2 hr 30 mins</option>
            <option value="180">3 hours</option>
          </select>
        </div>

        <div class="space-y-1.5">
          <label class="text-sm font-medium text-slate-700">Notes</label>
          <textarea id="measurement-notes" rows="3" class="w-full rounded-lg border-slate-300 text-sm focus:border-fuchsia-600 focus:ring-fuchsia-600" placeholder="Optional details"></textarea>
        </div>

        <p id="measurement-error" class="hidden text-sm text-red-600"></p>

        <div class="flex items-center justify-end gap-2 pt-1">
          <button type="button" id="measurement-cancel" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-600 hover:border-slate-400">Cancel</button>
          <button id="measurement-submit" type="submit" class="rounded-lg bg-fuchsia-700 px-3 py-1.5 text-sm font-semibold text-white hover:bg-fuchsia-800">Schedule</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Popover template holder --}}
  <div id="measurement-popover-template" class="hidden">
    <div class="measurement-pop select-none">
      <div class="flex items-center justify-between">
        <h4 class="text-sm font-semibold text-slate-900"></h4>
        <button class="icon-btn" data-action="close" title="Close">
          <span class="iconify" data-icon="ph:x-bold"></span>
        </button>
      </div>
      <div class="mt-3 space-y-2 text-sm text-slate-600">
        <div class="row">
          <span class="iconify text-lg text-fuchsia-700" data-icon="ph:calendar-blank"></span>
          <span data-field="date"></span>
        </div>
        <div class="row">
          <span class="iconify text-lg text-fuchsia-700" data-icon="ph:clock"></span>
          <span data-field="time"></span>
        </div>
        <div class="row hidden" data-row="notes">
          <span class="iconify text-lg text-fuchsia-700" data-icon="ph:note"></span>
          <span data-field="notes"></span>
        </div>
      </div>
      <div class="mt-4 flex items-center gap-2">
        <button class="btn-ghost" data-action="edit">Edit</button>
        <button class="icon-btn text-red-500" data-action="delete" title="Delete">
          <span class="iconify text-xl" data-icon="ph:trash-simple"></span>
        </button>
      </div>
    </div>
  </div>

  <style>
    .fc .fc-button { background:#F7D847; border-color:#F7D847; color:#111827; box-shadow:none; }
    .fc .fc-button:disabled { opacity:.85; }
    .fc .fc-button-primary:not(:disabled).fc-button-active,
    .fc .fc-button-primary:not(:disabled):active,
    .fc .fc-button-primary:focus { background:#5A0562; border-color:#5A0562; color:#fff; }
    .fc .fc-button-primary:hover:not(:disabled){ filter:brightness(.95); }

    .fc-event.measurement-pill { border:0!important; background:transparent!important; padding:0!important; }
    .fc-event.measurement-pill .pill{
      display:flex; align-items:center; gap:8px; border-radius:10px; padding:2px 8px;
      border:1px solid #e5e7eb; background:#fff;
    }
    .fc-event.measurement-pill .bar{ width:6px; align-self:stretch; border-radius:4px; background:#ccc; }
    .fc-event.measurement-pill .title{
      font-size:12px; color:#111827; line-height:1.2; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
      max-width:140px;
    }

    .measurement-pop{
      position:absolute; z-index:10050; width:340px; background:#fff; border:1px solid #eee;
      border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); padding:16px;
    }
    .measurement-pop .row{ display:flex; gap:8px; align-items:center; margin:4px 0; }
    .icon-btn{ width:34px; height:34px; border:1px solid #e5e7eb; border-radius:10px; display:flex; align-items:center; justify-content:center; background:#fff; }
    .btn-ghost{ border:1px solid #e5e7eb; border-radius:10px; padding:6px 12px; background:#fff; font-size:0.875rem; font-weight:500; }
  </style>

  <script>
    (function(){
      const palette = ['#5A0562','#F59E0B','#10B981','#3B82F6','#EF4444','#8B5CF6','#14B8A6','#F43F5E'];
      function hashColor(key){
        const s = String(key || '');
        let h = 0;
        for (let i = 0; i < s.length; i++){
          h = (h << 5) - h + s.charCodeAt(i);
          h |= 0;
        }
        const idx = Math.abs(h) % palette.length;
        return palette[idx];
      }
      function rgba(hex, alpha){
        const v = hex.replace('#','');
        const bigint = parseInt(v, 16);
        const r = (bigint >> 16) & 255;
        const g = (bigint >> 8) & 255;
        const b = bigint & 255;
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
      }

      const calendarEl = document.getElementById('measurement-calendar');
      if (!calendarEl) return;

      const popTemplate = document.getElementById('measurement-popover-template');
      let popEl = null;
      let suppressDocCloseOnce = false;

      function closePopover(){
        if (popEl && popEl.parentNode){
          popEl.remove();
          popEl = null;
        }
      }

      document.addEventListener('click', () => {
        if (suppressDocCloseOnce){ suppressDocCloseOnce = false; return; }
        closePopover();
      });

      function openPopover({ anchorEl, event }){
        closePopover();
        if (!popTemplate) return;
        popEl = popTemplate.firstElementChild.cloneNode(true);
        const rect = anchorEl.getBoundingClientRect();
        popEl.style.top  = `${window.scrollY + rect.top + rect.height + 8}px`;
        popEl.style.left = `${Math.min(window.scrollX + rect.left, window.scrollX + window.innerWidth - 360)}px`;

        const ext = event.extendedProps || {};
        popEl.querySelector('h4').textContent = event.title || 'Measurement';

        const dateField = popEl.querySelector('[data-field="date"]');
        dateField.textContent = ext.measurement_date
          ? new Date(ext.measurement_date + 'T00:00:00').toLocaleDateString()
          : (event.start ? new Date(event.start).toLocaleDateString() : '—');

        const timeField = popEl.querySelector('[data-field="time"]');
        const startLabel = ext.startLabel || (event.start ? new Date(event.start).toLocaleTimeString() : null);
        const endLabel   = ext.endLabel || (event.end ? new Date(event.end).toLocaleTimeString() : null);
        if (startLabel && endLabel){
          timeField.textContent = `${startLabel} - ${endLabel}`;
        } else if (startLabel){
          timeField.textContent = startLabel;
        } else {
          timeField.textContent = '—';
        }

        const notesRow = popEl.querySelector('[data-row="notes"]');
        if (ext.notes){
          notesRow.classList.remove('hidden');
          notesRow.querySelector('[data-field="notes"]').textContent = ext.notes;
        } else {
          notesRow.classList.add('hidden');
        }

        popEl.querySelector('[data-action="close"]').addEventListener('click', closePopover);
        popEl.querySelector('[data-action="delete"]').addEventListener('click', () => {
          if (window.__deleteMeasurement) window.__deleteMeasurement(event.id);
          closePopover();
        });
        popEl.querySelector('[data-action="edit"]').addEventListener('click', () => {
          if (window.__openMeasurementEditor) window.__openMeasurementEditor({
            id: event.id,
            project_id: ext.project_id,
            date: ext.measurement_date || (event.start ? event.start.slice(0,10) : ''),
            time: ext.start_time || '',
            duration: ext.duration_minutes || 60,
            notes: ext.notes || ''
          });
          closePopover();
        });

        document.body.appendChild(popEl);
        suppressDocCloseOnce = true;
      }

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        timeZone: 'local',
        height: 'auto',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: (info, success, failure) => {
          const url = '{{ route('tech.measurements.feed') }}'
            + '?start=' + encodeURIComponent(info.startStr)
            + '&end='   + encodeURIComponent(info.endStr);

          fetch(url, {
            method: 'GET',
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json' }
          })
          .then(async res => {
            const text = await res.text();
            if (!res.ok) throw new Error(text || `HTTP ${res.status}`);
            const raw = JSON.parse(text || '[]');
            success(raw.map(ev => {
              const pid = ev.extendedProps?.project_id ?? ev.id;
              const color = ev.extendedProps?.color || hashColor(pid);
              return {
                ...ev,
                classNames: ['measurement-pill'],
                extendedProps: { ...(ev.extendedProps || {}), color },
                backgroundColor: rgba(color, 0.15),
                borderColor: 'transparent',
                textColor: '#111827'
              };
            }));
          })
          .catch(err => {
            console.error(err);
            alert('Failed to load measurements.');
            failure(err);
          });
        },
        eventClassNames(){ return ['measurement-pill']; },
        eventContent(arg){
          const color = arg.event.extendedProps.color || '#5A0562';
          const title = arg.event.title || '(Untitled)';
          const root = document.createElement('div');
          root.innerHTML = `
            <div class="pill" style="background:${rgba(color, .15)}">
              <div class="bar" style="background:${color}"></div>
              <div class="title" title="${title}">${title}</div>
            </div>`;
          return { domNodes: [root] };
        },
        eventClick(info){
          if (info.jsEvent?.stopPropagation) info.jsEvent.stopPropagation();
          openPopover({ anchorEl: info.el, event: info.event });
        }
      });

      calendar.render();
      window.__measurementCalendar = calendar;
    })();
  </script>

  <script>
    (function(){
      const csrf = document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content');

      const modal    = document.getElementById('measurement-modal');
      const btnOpen  = document.getElementById('measurement-create-open');
      const btnClose = document.getElementById('measurement-modal-close');
      const btnCancel= document.getElementById('measurement-cancel');
      const form     = document.getElementById('measurement-form');
      const errorBox = document.getElementById('measurement-error');
      const titleEl  = document.getElementById('measurement-modal-title');
      const submitEl = document.getElementById('measurement-submit');

      const fldId       = document.getElementById('measurement-id');
      const fldProject  = document.getElementById('measurement-project');
      const fldDate     = document.getElementById('measurement-date');
      const fldTime     = document.getElementById('measurement-time');
      const fldDuration = document.getElementById('measurement-duration');
      const fldNotes    = document.getElementById('measurement-notes');

      function setMode(isEdit){
        titleEl.textContent  = isEdit ? 'Edit Measurement' : 'Schedule Measurement';
        submitEl.textContent = isEdit ? 'Save changes' : 'Schedule';
      }

      function openModal(prefill = {}){
        const isEdit = Boolean(prefill.id);
        setMode(isEdit);
        fldId.value       = isEdit ? String(prefill.id) : '';
        fldProject.value  = prefill.project_id ? String(prefill.project_id) : '';
        fldDate.value     = prefill.date || '';
        fldTime.value     = prefill.time || '';
        fldDuration.value = prefill.duration ? String(prefill.duration) : '60';
        fldNotes.value    = prefill.notes || '';
        errorBox.classList.add('hidden');
        modal.classList.remove('hidden');
      }

      function closeModal(){
        modal.classList.add('hidden');
      }

      btnOpen?.addEventListener('click', () => openModal());
      btnClose?.addEventListener('click', closeModal);
      btnCancel?.addEventListener('click', closeModal);
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
      });

      window.__openMeasurementEditor = openModal;

      async function submitForm(e){
        e.preventDefault();
        errorBox.classList.add('hidden');

        const payload = {
          project_id: Number(fldProject.value),
          measurement_date: fldDate.value,
          measurement_time: fldTime.value,
          duration_minutes: Number(fldDuration.value || '60'),
          notes: fldNotes.value?.trim() || null
        };

        if (!payload.project_id){
          errorBox.textContent = 'Please choose a project.';
          errorBox.classList.remove('hidden');
          return;
        }
        if (!payload.measurement_date || !payload.measurement_time){
          errorBox.textContent = 'Date and start time are required.';
          errorBox.classList.remove('hidden');
          return;
        }

        const isEdit = Boolean(fldId.value);
        let url = '{{ route('tech.measurements.store') }}';
        let method = 'POST';
        if (isEdit){
          url = '{{ route('tech.measurements.update', ['measurement' => '__ID__']) }}'.replace('__ID__', fldId.value);
          method = 'PATCH';
        }

        try {
          const res = await fetch(url, {
            method,
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrf,
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify(payload)
          });

          if (!res.ok){
            const text = await res.text();
            let msg = `HTTP ${res.status}`;
            try {
              const data = JSON.parse(text);
              if (data?.errors){
                msg = Object.values(data.errors).flat().join(' ');
              } else if (data?.message){
                msg = data.message;
              }
            } catch(_){
              msg = text.slice(0, 400);
            }
            throw new Error(msg);
          }

          window.__measurementCalendar?.refetchEvents();
          closeModal();
        } catch (err){
          errorBox.textContent = err.message || 'Failed to save measurement.';
          errorBox.classList.remove('hidden');
        }
      }

      form?.addEventListener('submit', submitForm);

      async function deleteMeasurement(id){
        if (!confirm('Delete this measurement slot?')) return;
        try {
          const url = '{{ route('tech.measurements.destroy', ['measurement' => '__ID__']) }}'.replace('__ID__', id);
          const res = await fetch(url, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': csrf,
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json'
            },
            credentials: 'same-origin'
          });
          if (!res.ok){
            const text = await res.text();
            throw new Error(text || `HTTP ${res.status}`);
          }
          window.__measurementCalendar?.refetchEvents();
        } catch (err){
          alert(err.message || 'Failed to delete measurement.');
        }
      }

      window.__deleteMeasurement = deleteMeasurement;
    })();
  </script>
</x-tech-layout>
