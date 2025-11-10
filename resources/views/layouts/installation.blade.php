{{-- Installation layout --}}
@include('installation.layouts.header')

<body class="bg-[#F9F7F7]"
      x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
      x-on:keydown.window.escape="sidebarOpen = false"
      x-init="window.addEventListener('resize', () => sidebarOpen = window.innerWidth >= 1024)"
      x-effect="document.body.classList.toggle('overflow-hidden', sidebarOpen && window.innerWidth < 1024)">

    {{-- Sidebar --}}
    @include('installation.layouts.sidebar')

    {{-- Main Content --}}
    <div class="min-h-screen lg:pl-64 transition-[padding] duration-200 ease-in-out">
        <div class="flex flex-col min-h-screen">

            {{-- Topbar/Profile Bar --}}
            @include('admin.layouts.topbar', ['showSidebarToggle' => true])

            <main class="flex-1 px-4 pt-4 pb-6">
                @isset($header)
                    <div class="mb-6 text-2xl font-semibold text-gray-800">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Mobile overlay --}}
    <div x-cloak x-show="sidebarOpen" x-transition.opacity
         class="fixed inset-0 z-40 bg-black/50 lg:hidden"
         x-on:click="sidebarOpen = false"></div>

    <script>
        feather.replace();
    </script>
</body>
</html>

