

    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta name="csrf-token" content="{{ csrf_token() }}">


      <title>Admin | {{ $title ?? 'Dashboard' }}</title>

      {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

      <script src="https://unpkg.com/feather-icons"></script>

      <script src="https://cdn.tailwindcss.com"></script>
      <style>[x-cloak]{display:none!important;}</style>

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script src="https://unpkg.com/alpinejs" defer></script>
{{-- <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script> --}}
<script src="https://code.iconify.design/iconify-icon/2.0.0/iconify-icon.min.js"></script>

<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
  crossorigin=""
/>
<script
  src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
  crossorigin=""
  defer
></script>

      <!--written on 14.04.2025-->
      <!--Modified on 15.04.1015-->
      <!--Modified for laravel/blade on 15.04.2025 -->
    {{-- modified in laravel with controllers - 16.04.2025 --}}
