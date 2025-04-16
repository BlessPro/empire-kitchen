{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | {{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head> --}}

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin | {{ $title ?? 'Dashboard' }}</title>

  {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://unpkg.com/feather-icons"></script>

  <script src="https://cdn.tailwindcss.com"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!--written on 14.04.2025-->
  <!--Modified on 15.04.1015-->
  <!--Modified for laravel/blade on 15.04.2025 -->
{{-- modified in laravel with controllers - 16.04.2025 --}}


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
