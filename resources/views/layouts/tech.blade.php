{{-- built with love --}}

  <!--written on 16.05.2025-->
  <!--Modified on 16.05.1015-->
  <!--Modified for laravel/blade on 16.05.2025 -->


 @include('admin.layouts.header')

<body class="bg-gray-100 ">
    <div class="flex min-h-screen">

        {{-- Admin Sidebar --}}
        @include('tech.layouts.sidebar')

        {{-- Sidebar --}}


        {{-- Main Content --}}

        <div class="flex flex-col flex-1">

            {{-- Topbar/Profile Bar --}}
            @include('admin.layouts.topbar')

            <main class="p-4">
                @isset($header)
                    <div class="mb-6 text-2xl font-semibold text-gray-800">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}
            </main>
        </div>
    </div>
    <script>
        feather.replace();
      </script>
</body>
</html>
