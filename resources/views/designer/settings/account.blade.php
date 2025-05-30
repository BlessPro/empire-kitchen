<div class="items-center justify-between mb-4 ">
    <div><h2 class="mb-2 ml-6 text-[18px] font-semibold">Personal Information</h2>
    <p class="mb-3 ml-6 text-sm text-gray-500">You can change your profile here</p></div>
    {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
    <!-- ADD CLIENT BUTTON -->

    </div>

<form action="{{ route('designer.settings.profile_pic') }}" method="POST" enctype="multipart/form-data">
        @csrf
<!-- Form Card -->
     <div class="p-8 bg-white shadow rounded-2xl">

{{-- <div class="flex flex-col items-center cursor-pointer" onclick="document.getElementById('account_profile_input').click()">
    <img src="{{ asset('storage/' . auth()->user()->profile_pic) }}" id="account_profile_preview" class="w-24 h-24 bg-white rounded-full shadow">
    <p class="mt-2 text-sm text-center text-gray-500">This is where people will see your actual face</p>
</div> --}}

<!-- Hidden file input -->

        <div class="flex flex-col gap-8 md:flex-row">
          <!-- Profile Picture -->
          <div class="flex flex-col items-center">
            <img src="{{ asset('storage/' . auth()->user()->profile_pic) }}" id="account_profile_preview" id="account_profile_preview"  class="w-24 h-24 bg-white rounded-full shadow">
            <p class="mt-2 text-sm text-center text-gray-500">This is where people will see your actual face</p>
          </div>

          <!-- Upload Area -->
           <div onclick="document.getElementById('profile_pic').click()" class="flex items-center justify-center flex-1 h-32 text-center text-gray-500 border-2 border-dashed cursor-pointer rounded-xl hover:bg-gray-50">
            <div>
              <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="..."/></svg>
              <p><span class="font-medium text-purple-600">Click here</span> to upload your file or drag.</p>
              <p class="mt-1 text-xs text-gray-400">Supported format: SVG, JPG, PNG (10MB each)</p>
            </div>
            {{-- <input type="file" name="profile_pic" id="account_profile_input" class="hidden" onchange="previewProfile(event)"> --}}
        <input type="file" name="profile_pic" id="profile_pic" class="hidden mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:rounded-lg file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">

          </div>
        </div>


        <!-- Form -->

      <div id="accountTab" class="w-full mt-6">
        <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2">


            <div>
            <label class="block mb-1 text-sm font-medium">Full Name</label>
            <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" class="w-full px-4 py-2 border rounded-lg" disabled readonly>
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium">Email Address</label>
            <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-2 border rounded-lg" disabled readonly >
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" value="{{ auth()->user()->phone_number }}" class="w-full px-4 py-2 border rounded-lg" disabled readonly >
          </div>
          <div>
            <label class="block mb-2.5 text-sm font-medium text-gray-700">Role</label>
            <select disabled class="w-[270px] px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600">
                <option value="admin" {{ auth()->user()->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="tech_supervisor" {{ auth()->user()->role == 'tech_supervisor' ? 'selected' : '' }}>Tech Supervisor</option>
                <option value="designer" {{ auth()->user()->role == 'designer' ? 'selected' : '' }}>Designer</option>
                <option value="sales_accountant" {{ auth()->user()->role == 'sales_accountant' ? 'selected' : '' }}>Sales Accountant</option>
                <option value="accountant" {{ auth()->user()->role == 'accountant' ? 'selected' : '' }}>Accountant</option>
            </select>
            <input type="hidden" name="role" value="{{ auth()->user()->role }}">
        </div>
          <div>
            <label class="block mb-1 text-sm font-medium">Password</label>
            <div class="relative">
              <input type="password" name="password" id="password" placeholder="Leave blank to keep current password" class="w-full px-4 py-2 pr-10 border rounded-lg" disabled readonly>
              <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="..."/></svg>
              </button>
            </div>
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium">New Input</label>
            <div class="relative">
              <input type="new" class="w-full px-4 py-2 pr-10 border rounded-lg"  value="Coming soon" readonly disabled>
              <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="..."/></svg>
              </button>
            </div>
          </div>
        </div>

        <div class="flex justify-end mt-8 space-x-4">
    <button type="submit" class="px-4 py-2 text-fuchsia-900 bg-purple-200 border-2 rounded-[20px] hover:text-white   hover:bg-fuchsia-900">Upload</button>
          {{-- <button class="px-6 py-2 text-white bg-purple-700 rounded-lg">Edit Profile</button> --}}
        </div>
      </div>
    </div>
</form>


