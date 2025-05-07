<x-layouts.app>
    <x-slot name="header">
<!--written on 07.05.2025 @ 9:45-->
    <!-- Main Content -->

    @include('admin.layouts.header')

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">

            <!-- FullCalendar Styles -->
<!-- Tailwind Styles already included in your layout -->
<div class="p-6 bg-white shadow-md rounded-xl">
    <div id="calendar"></div>
</div>
</div>
</div>
</main>
<!-- FullCalendar Script -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

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
            events: '/api/calendar/events', // Laravel route returning JSON events
            eventColor: '#7C3AED', // Tailwind's purple-700
            height: 'auto',
        });

        calendar.render();
    });
</script>

    </x-slot>
</x-layouts.app>
