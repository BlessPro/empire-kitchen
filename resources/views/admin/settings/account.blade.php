<div class="items-center justify-between mb-4 ">
    <div><h2 class="mb-2 ml-6 text-[18px] font-semibold">Personal Information</h2>
    <p class="mb-3 ml-6 text-sm text-gray-500">You can change your profile here</p></div>
    {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
    <!-- ADD CLIENT BUTTON -->
    <div class="flex justify-end mt-8 space-x-4">
        <button class="px-6 py-2 text-gray-600 border rounded-lg">Save Changes</button>
        <button class="px-6 py-2 text-white bg-purple-700 rounded-lg">Edit Profile</button>
      </div>
    </div>


<!-- Form Card -->
     <div class="p-8 bg-white shadow rounded-2xl">


        <div class="flex flex-col gap-8 md:flex-row">
          <!-- Profile Picture -->
          <div class="flex flex-col items-center">
            <img src="https://i.pravatar.cc/100" alt="Profile" class="w-24 h-24 rounded-full">
            <p class="mt-2 text-sm text-center text-gray-500">This is where people will see your actual face</p>
          </div>

          <!-- Upload Area -->
          <div class="flex items-center justify-center flex-1 h-32 text-center text-gray-500 border-2 border-dashed cursor-pointer rounded-xl hover:bg-gray-50">
            <div>
              <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="..."/></svg>
              <p><span class="font-medium text-purple-600">Click here</span> to upload your file or drag.</p>
              <p class="mt-1 text-xs text-gray-400">Supported format: SVG, JPG, PNG (10MB each)</p>
            </div>
          </div>
        </div>

        <!-- Form -->
        <form class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2">
          <div>
            <label class="block mb-1 text-sm font-medium">Full Name</label>
            <input type="text" class="w-full px-4 py-2 border rounded-lg" value="Daniel Mensah">
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium">Email Address</label>
            <input type="email" class="w-full px-4 py-2 border rounded-lg" value="elementary221b@gmail.com">
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium">Phone Number</label>
            <input type="text" class="w-full px-4 py-2 border rounded-lg" value="+233 (0) 4526-9878">
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium">Account Type</label>
            <select class="w-full px-4 py-2 border rounded-lg">
              <option selected>Administrator</option>
              <option>User</option>
              <option>Manager</option>
            </select>
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium">Password</label>
            <div class="relative">
              <input type="password" class="w-full px-4 py-2 pr-10 border rounded-lg" value="***************">
              <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="..."/></svg>
              </button>
            </div>
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium">Re-Enter Password</label>
            <div class="relative">
              <input type="password" class="w-full px-4 py-2 pr-10 border rounded-lg" value="***************">
              <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="..."/></svg>
              </button>
            </div>
          </div>
        </form>

        <div class="flex justify-end mt-8 space-x-4">
          <button class="px-6 py-2 text-gray-600 border rounded-lg">Save Changes</button>
          <button class="px-6 py-2 text-white bg-purple-700 rounded-lg">Edit Profile</button>
        </div>
      </div>
