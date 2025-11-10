

  <!--written on 14.04.2025-->
  <!--Modified on 15.04.1015-->
  <!--Modified for laravel/blade on 15.04.2025 -->
{{-- modified in laravel with controllers - 16.04.2025 --}}
@include('admin.layouts.header')

    <style>
        /* Custom styles for the admin layout */
        body {
            background-color: #f8fafc; /* Tailwind's bg-gray-50 */
        }
        .sidebar {
            width: 250px;
            background-color: #1f2937; /* Tailwind's bg-gray-800 */
        }
        .topbar {
            background-color: #111827; /* Tailwind's bg-gray-900 */
        }
    </style>
    <style>
        /* Custom styles for the admin layout */
        body {
            background-color: #f8fafc; /* Tailwind's bg-gray-50 */
        }

  </style>
</head>
<body class="bg-[#F9F7F7] font-sans"
      x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
      x-on:keydown.window.escape="sidebarOpen = false"
      x-init="window.addEventListener('resize', () => sidebarOpen = window.innerWidth >= 1024)"
      x-effect="document.body.classList.toggle('overflow-hidden', sidebarOpen && window.innerWidth < 1024)">

    {{-- Sidebar --}}
    @include('admin.layouts.sidebar')

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
        if (window.feather) feather.replace();
    </script>
</body>
</html>
