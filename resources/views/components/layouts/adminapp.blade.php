

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
<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">


        {{-- Admin Sidebar --}}
        @include('admin.layouts.sidebar')

        <div class="flex-1 flex flex-col">

            {{-- Topbar/Profile Bar --}}
            @include('admin.layouts.topbar')

                @isset($header)
                    <div class="mb-6 text-2xl font-semibold text-gray-800">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}
        </div>
    </div>
</body>
</html>
