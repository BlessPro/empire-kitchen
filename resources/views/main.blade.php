<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Empire Kitchens Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="h-screen bg-white flex overflow-hidden">
        <!-- Session Status -->
        {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}
    <!-- Left Section -->

    <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-8 py-12">

      <!-- Logo -->
      <div class=" mb-[-20px]">
        <!-- Replace with your logo image if needed -->
        <img src="/empire-kitchen-logo.png" alt="Empire Kitchens Logo" class="w-[170px] h-[170px] " />
      </div>

      <!-- Welcome Text -->
      <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 text-center">Welcome Back.</h2>
      <p class="text-sm text-gray-500 mb-8 text-center">Let's sign in to your account</p>

      <!-- Form -->
      {{-- <form class="w-full max-w-sm"> --}}

        <form method="POST" class="w-full max-w-sm" action="{{ route('login') }}">
@csrf
        <!-- Username -->
        <div class="mb-4">
            <x-input-label class="text-sm text-gray-700 block mb-1" for="email" :value="__('Username')" />

            <div class="relative">
              <span class="absolute left-3 top-2.5 text-gray-400">
                <!-- User Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 17.804A8.963 8.963 0 0112 15c2.21 0 4.215.805 5.879 2.136M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </span>
              <x-text-input id="email" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5a0562] focus:outline-none"
              type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />


            </div>
          </div>


          <!--password-->
          <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
              <span class="absolute left-3 top-2.5 text-gray-400">
                <!-- Lock Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c1.657 0 3-1.343 3-3V6a3 3 0 00-6 0v2c0 1.657 1.343 3 3 3zM5 11h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2z" />
                </svg>
              </span>

              <x-text-input id="password"  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5a0562] focus:outline-none"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />


            </div>
          </div>


        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between mb-6 text-sm">
          <label class="flex items-center">
            <input type="checkbox" class="form-checkbox text-[#5a0562] mr-2" checked />
            <span>Remember now</span>
          </label>
          <a href="#" class="[#5a0562] font-medium hover:underline">Forgot Password</a>
        </div>

        <!-- Sign In Button -->

        <button type="submit" class="w-full bg-[#5a0562] text-white py-2 rounded-md font-semibold hover:bg-[#5a0562]-600 transition duration-200">
            Sign In
          </button>
    </form>

    </div>
g

    <!-- Right Section (Image) -->
    <div class="hidden md:block md:w-1/2 h-full relative">
      <img
        src="/side-image.jpg"
        alt="side-image.jpg"
        class="absolute inset-0 w-full h-full object-cover opacity-100"
      />
      <div class="absolute inset-0 bg-gradient-to-r from-[#d9be8a] to-[#5a0562] opacity-65"></div>
    </div>

  </body>
</html>
