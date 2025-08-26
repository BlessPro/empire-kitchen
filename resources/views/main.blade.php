<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Empire Kitchens Login</title>
    <script src="https://cdn.tailwindcss.com"></script>

      {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

      <script src="https://unpkg.com/feather-icons"></script>

      <script src="https://cdn.tailwindcss.com"></script>

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script src="https://unpkg.com/alpinejs" defer></script>
<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
  </head>
  <body class="flex h-screen overflow-hidden bg-white">
        <!-- Session Status -->
        {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}
    <!-- Left Section -->

    <div class="flex flex-col items-center justify-center w-full px-8 py-12 md:w-1/2">

      <!-- Logo -->
      <div class=" mb-[-20px]">
        <!-- Replace with your logo image if needed -->
        <img src="/empire-kitchen-logo.png" alt="Empire Kitchens Logo" class="w-[170px] h-[170px] " />
      </div>

      <!-- Welcome Text -->
      <h2 class="mb-2 text-2xl font-bold text-center text-gray-800 md:text-3xl">Welcome Back.</h2>
      <p class="mb-8 text-sm text-center text-gray-500">Let's sign in to your account</p>

      <!-- Form -->
      {{-- <form class="w-full max-w-sm"> --}}

        <form method="POST" class="w-full max-w-sm" action="{{ route('login') }}">
@csrf
        <!-- Username -->
        <div class="mb-4">
            <x-input-label class="block mb-1 text-sm text-gray-700" for="name" :value="__('Username')" />

            <div class="relative">
              <span class="absolute left-3 top-2.5 text-gray-400">
                <!-- User Icon -->

             <iconify-icon icon="iconamoon:profile-light" width="24" "></iconify-icon>
 <!-- Default: eye -->
        {{-- <iconify-icon icon="iconamoon--profile-thin"
                      class="w-5 h-5"
                      x-show="!show"></iconify-icon> --}}
              </span>
              </span>
              <x-text-input id="name" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5a0562] focus:outline-none"
              type="name" name="name" :value="old('name')" required autofocus autocomplete="username" />
              <x-input-error :messages="$errors->get('name')" class="mt-2" />


            </div>
          </div>


          <!--password-->
          <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
              <span class="absolute left-3 top-2.5 text-gray-400">

             {{-- <iconify-icon icon="
material-symbols-light:lock-outline" width="24" "></iconify-icon> --}}
<iconify-icon icon="material-symbols-light:lock-outline" width="24" "></iconify-icon>
                <!-- Lock Icon -->
                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c1.657 0 3-1.343 3-3V6a3 3 0 00-6 0v2c0 1.657 1.343 3 3 3zM5 11h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2z" />
                </svg> --}}
              </span>

              {{-- <x-text-input id="password"  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5a0562] focus:outline-none"
                            type="password"
                            name="password"
                            required autocomplete="current-password" /> --}}
<div x-data="{ show: false }" class="relative">
    <x-text-input
        id="password"
        x-bind:type="show ? 'text' : 'password'"
        class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5a0562] focus:outline-none"
        name="password"
        required
        autocomplete="current-password"
    />

    <!-- Toggle Button -->
    <button type="button"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500"
            @click="show = !show">

        <!-- Default: eye -->
        <iconify-icon icon="ion:eye-outline"
                      class="w-5 h-5"
                      x-show="!show"></iconify-icon>

        <!-- When visible: eye-off -->
        <iconify-icon icon="mage:eye-off"
                      class="w-5 h-5"
                      x-show="show"></iconify-icon>
    </button>
</div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />


            </div>
          </div>


        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between mb-6 text-sm">
          <label class="flex items-center">
            <input type="checkbox" class="form-checkbox text-[#5a0562] mr-2" checked />
            <span onclick="window.location='{{ route('admin.clients.projects2'">Remember now</span>
          </label>
          <a href="#" class="[#5a0562] font-medium hover:underline">Forgot Password</a>
        </div>

        <!-- Sign In Button -->

        <button type="submit" class="w-full bg-[#5a0562] text-white py-2 rounded-md font-semibold hover:bg-[#5a0562]-600 transition duration-200">
            Sign In
          </button>
    </form>

    </div>


    <!-- Right Section (Image) -->
    <div class="relative hidden h-full md:block md:w-1/2">
      <img
        src="/side-image.jpg"
        alt="side-image.jpg"
        class="absolute inset-0 object-cover w-full h-full opacity-100"
      />
      <div class="absolute inset-0 bg-gradient-to-r from-[#d9be8a] to-[#5a0562] opacity-65"></div>
    </div>

  </body>
</html>
