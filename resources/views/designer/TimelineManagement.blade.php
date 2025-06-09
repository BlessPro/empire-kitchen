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
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '/designer/TimeManagement/events',
        eventColor: '#0036BF',
        height: 'auto',
        eventClick: function (info) {
            const { extendedProps, title, start } = info.event;

            const popup = document.createElement('div');
            popup.className = 'bg-white shadow-md rounded p-4 border border-gray-300 fixed z-50';
            popup.style.position = 'fixed';
            popup.style.width = '260px';
            popup.style.top = `${info.jsEvent.clientY + 10}px`;
            popup.style.left = `${info.jsEvent.clientX}px`;

            popup.innerHTML = `
                <div class="mb-2 font-bold text-gray-800">${title}</div>
                <div class="mb-1 text-sm"><strong>Design Date:</strong> ${extendedProps.design_date ?? 'N/A'}</div>
                <div class="text-sm"><strong>Notes:</strong> ${extendedProps.notes ?? 'None'}</div>
            `;

            document.body.appendChild(popup);

            function removePopup() {
                popup.remove();
                document.removeEventListener('click', outsideClickListener);
            }

            function outsideClickListener(e) {
                if (!popup.contains(e.target)) {
                    removePopup();
                }
            }

            setTimeout(() => {
                document.addEventListener('click', outsideClickListener);
            }, 0);
        }
    });

    calendar.render();
});
</script>
</x-designer-layout>
