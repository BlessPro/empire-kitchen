{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html> --}}

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | {{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head> --}}


  <!--written on 14.04.2025-->
  <!--Modified on 15.04.1015-->
  <!--Modified for laravel/blade on 15.04.2025 -->


{{-- </style>
</head> --}}
<body class="bg-gray-100 ">
    <div class="flex min-h-screen">

        {{-- Admin Sidebar --}}

        @include('admin.layouts.sidebar')

        
        {{-- elseif(auth()->user()->role == 'tech'){
        @include('tech.layouts.sidebar')
        } --}}
        {{-- else{
        @include('admin.layouts.sidebar')
        } --}}
            @include('admin.layouts.topbar')

        {{-- Sidebar --}}

        @include('admin.layouts.header')

        {{-- Sidebar --}}


        {{-- Main Content --}}

        <div class="flex flex-col flex-1">

            {{-- Topbar/Profile Bar --}}
            {{-- @include('admin.layouts.topbar') --}}

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

