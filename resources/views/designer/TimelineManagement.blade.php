<x-designer-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            .fc .fc-button {
                background-color: #5A0562;
                color: white;
                font-size: 1rem;
                padding: 0.25rem 0.75rem;
                border-radius: 0.375rem;
                border: none;
                margin: 0 0.25rem;
                transition: all 0.2s ease-in-out;
            }
            .fc .fc-button:hover {
                background-color: #ff7300;
            }
            .fc .fc-button.fc-button-active {
                background-color: #ff7300;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
            }
            .fc .fc-toolbar-title {
                font-weight: 600;
                color: #5A0562;
                font-size: 1.125rem;
            }
        </style>
    </x-slot>

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen items-center">
        <div class="p-6 bg-[#F9F7F7]">
            <div class="p-6 bg-white shadow-md rounded-xl">
                <div id="calendar"></div>
            </div>
        </div>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

    </main>


<script>

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    let activePopover = null;

    function closePopover() {
        if (activePopover) {
            activePopover.remove();
            activePopover = null;
        }
    }

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: "{{ route('designer.TimeManagement.events') }}",
        height: 'auto',
        eventColor: '#4F46E5',
        eventClick: function (info) {
            info.jsEvent.preventDefault();
            closePopover();

            const { extendedProps, title } = info.event;

            const pop = document.createElement('div');
            pop.className = 'designer-event-pop fixed z-50 w-72 rounded-2xl border border-slate-200 bg-white shadow-xl p-4 text-sm text-slate-700';
            pop.style.top = `${info.jsEvent.clientY + 12}px`;
            pop.style.left = `${info.jsEvent.clientX - 150}px`;

            const rows = [
                `<div class="text-sm font-semibold text-slate-900 mb-1">${title}</div>`,
                extendedProps.project_name ? `<div class="text-xs text-slate-500 mb-2">${extendedProps.project_name}</div>` : '',
                extendedProps.client_name ? `<div class="mb-2"><span class="font-medium text-slate-600">Client:</span> ${extendedProps.client_name}</div>` : '',
                `<div class="mb-1"><span class="font-medium text-slate-600">Design Date:</span> ${extendedProps.design_date_label ?? '—'}</div>`,
                extendedProps.schedule_date_label ? `<div class="mb-1"><span class="font-medium text-slate-600">Scheduled:</span> ${extendedProps.schedule_date_label}</div>` : '',
                (extendedProps.start_time_label || extendedProps.end_time_label)
                    ? `<div class="mb-1"><span class="font-medium text-slate-600">Time:</span> ${[extendedProps.start_time_label, extendedProps.end_time_label].filter(Boolean).join(' - ')}</div>`
                    : '',
                `<div class="mt-2"><span class="font-medium text-slate-600">Notes:</span><br><span class="text-slate-600">${extendedProps.notes ?? 'No notes added'}</span></div>`
            ].join('');

            pop.innerHTML = rows;
            document.body.appendChild(pop);
            activePopover = pop;

            setTimeout(() => {
                document.addEventListener('click', function handleOutside(e) {
                    if (activePopover && !activePopover.contains(e.target)) {
                        closePopover();
                        document.removeEventListener('click', handleOutside);
                    }
                });
            }, 0);
        }
    });

    calendar.render();
});
</script>
</x-designer-layout>
