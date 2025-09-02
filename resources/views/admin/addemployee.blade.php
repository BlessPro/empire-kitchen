<x-layouts.app>
    <x-slot name="header">
        <script src="//unpkg.com/alpinejs" defer></script>
        <style>
            [x-cloak] {
                display: none !important
            }
        </style>
        @include('admin.layouts.header')
    </x-slot>

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen items-center">
        <div class="p-6 bg-[#F9F7F7]">
    <!-- Main -->
    <main class="flex-1">
      <!-- Top bar -->
      <header class="sticky top-0 z-10 bg-sand/80 backdrop-blur supports-[backdrop-filter]:bg-sand/60">
        <div class="flex items-center justify-between px-6 py-4">
          <!-- Breadcrumbs -->
          <nav class="text-sm text-gray-500">
            <ol class="flex items-center gap-2">
              <li><a href="#" class="hover:text-gray-700">Employees</a></li>
              <li class="text-gray-400">›</li>
              <li class="font-medium text-brandPurple">Add Employee</li>
            </ol>
          </nav>

          <!-- Right area -->
          <div class="flex items-center gap-6">
            <div class="text-sm text-gray-600"><span class="font-semibold">Staff ID:</span> 0032</div>

            <button class="relative">
              <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
              </svg>
              <span class="absolute -right-1 -top-1 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-brandPurple px-1 text-[10px] font-semibold text-white">12</span>
            </button>


          </div>
        </div>
      </header>

      <!-- Content -->
      <section class="px-6 py-8">
        <div class="max-w-5xl p-6 mx-auto rounded-2xl shadow-soft ring-1 ring-black/5 sm:p-8">
          <!-- Avatar + Upload -->
          {{-- <div class="flex items-center gap-5">
            <label for="avatar" class="grid w-20 h-20 overflow-hidden bg-gray-100 rounded-full cursor-pointer place-items-center ring-1 ring-gray-200">
              <svg class="w-10 h-10 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/>
              </svg>
              <img id="avatarPreview" class="hidden object-cover w-full h-full" alt="">
            </label>
            <input id="avatar" type="file" accept="image/*" class="hidden" />
            <button type="button" onclick="document.getElementById('avatar').click()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-900 rounded-lg bg-brandGold hover:brightness-95">
           <iconify-icon class="" width=""> <iconify-icon>
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M5 20h14v-9h-4V7H9v4H5v9zm6-13h2v2h2v2h-2v2h-2v-2H9V9h2V7z"/></svg>
              Upload profile picture
            </button>
          </div> --}}


















<form class="mt-8" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
  @csrf

  {{-- (Optional) show validation errors --}}
  @if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Avatar --}}
  {{-- <input id="avatar" name="avatar" type="file" accept="image/*" class="hidden" />
    <div> 
    <iconify-icon class="solar:camera-broken" width="24" ></iconify-icon>
    </div> --}}

        <!-- Avatar + Upload -->
          <div class="flex items-center gap-5 mb-10">
            <label for="avatar" class="grid w-20 h-20 overflow-hidden bg-gray-100 rounded-full cursor-pointer place-items-center ring-1 ring-gray-200">
              <svg class="w-10 h-10 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/>
              </svg>
              <img id="avatarPreview" class="hidden object-cover w-full h-full" alt="">
            </label>
            <input id="avatar" type="file" accept="image/*" class="hidden" />
            <div >
            <button type="button" onclick="document.getElementById('avatar').click()" class="inline-flex items-center gap-2
             px-4 py-2 text-sm font-medium text-gray-900 rounded-lg hover:brightness-95">
           {{-- <iconify-icon class="" width=""> <iconify-icon> --}}
            <iconify-icon class="" width=""> </iconify-icon>  
             Upload your profile picture
             
                {{-- <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M5 20h14v-9h-4V7H9v4H5v9zm6-13h2v2h2v2h-2v2h-2v-2H9V9h2V7z"/></svg> --}}
             
            </button>
        </div>
          </div>

    <div class="mb-5">
      <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Name</label>
      <input id="name" name="name" value="{{ old('name') }}" type="text"
       class="w-full h-12 px-4 border border-gray-200 rounded-xl
        focus:border-gray-300 focus:outline-none" required />
    </div>

  <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    {{-- Name --}}

    {{-- Designation + Commencement --}}
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 md:col-span-2">
      <div>
        <label for="designation" class="block mb-2 text-sm font-medium text-gray-700">Designation</label>
        <div class="relative">
          <select id="designation" name="designation" class="w-full h-12 px-4 pr-10 bg-white border border-gray-200 appearance-none rounded-xl focus:border-gray-300 focus:outline-none">
            <option value="" disabled {{ old('designation') ? '' : 'selected' }}>Select</option>
            <option value="Designer" {{ old('designation')==='Designer'?'selected':'' }}>Designer</option>
            <option value="Technical Supervisor" {{ old('designation')==='Technical Supervisor'?'selected':'' }}>Technical Supervisor</option>
            <option value="Sales" {{ old('designation')==='Sales'?'selected':'' }}>Sales</option>
            <option value="Accountant" {{ old('designation')==='Accountant'?'selected':'' }}>Accountant</option>
          </select>
          <svg class="absolute w-5 h-5 text-gray-500 -translate-y-1/2 pointer-events-none right-3 top-1/2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
          </svg>
        </div>
      </div>
      <div>
        <label for="commencement" class="block mb-2 text-sm font-medium text-gray-700">Date of Commencement</label>
        <input id="commencement" name="commencement_date" value="{{ old('commencement_date') }}" type="date" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
      </div>
    </div>

    {{-- Phone / Email --}}
    <div>
      <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
      <input id="phone" name="phone" value="{{ old('phone') }}" type="tel" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>
    <div>
      <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email Address</label>
      <input id="email" name="email" value="{{ old('email') }}" type="email" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>

    {{-- Nationality / DOB --}}
    <div>
      <label for="nationality" class="block mb-2 text-sm font-medium text-gray-700">Nationality</label>
      <input id="nationality" name="nationality" value="{{ old('nationality') }}" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>
    <div>
      <label for="dob" class="block mb-2 text-sm font-medium text-gray-700">Date of Birth</label>
      <input id="dob" name="dob" value="{{ old('dob') }}" type="date" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>

    {{-- Hometown / Language --}}
    <div>
      <label for="hometown" class="block mb-2 text-sm font-medium text-gray-700">Hometown</label>
      <input id="hometown" name="hometown" value="{{ old('hometown') }}" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>
    <div>
      <label for="language" class="block mb-2 text-sm font-medium text-gray-700">Language Spoken</label>
      <input id="language" name="language" value="{{ old('language') }}" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>

    {{-- Address / GPS --}}
    <div>
      <label for="address" class="block mb-2 text-sm font-medium text-gray-700">Permanent Address</label>
      <input id="address" name="address" value="{{ old('address') }}" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>
    <div>
      <label for="gps" class="block mb-2 text-sm font-medium text-gray-700">GPS Address</label>
      <input id="gps" name="gps" value="{{ old('gps') }}" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>

    {{-- Next of kin / Relation --}}
    <div>
      <label for="nok" class="block mb-2 text-sm font-medium text-gray-700">Next of Kin</label>
      <input id="nok" name="next_of_kin" value="{{ old('next_of_kin') }}" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>
    <div>
      <label for="relation" class="block mb-2 text-sm font-medium text-gray-700">Relation</label>
      <input id="relation" name="relation" value="{{ old('relation') }}" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>

    {{-- Next of kin phone / Bank --}}
    <div>
      <label for="nokphone" class="block mb-2 text-sm font-medium text-gray-700">Next of Kin Phone</label>
      <input id="nokphone" name="nok_phone" value="{{ old('nok_phone') }}" type="tel" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>
    <div>
      <label for="bank" class="block mb-2 text-sm font-medium text-gray-700">Bank</label>
      <input id="bank" name="bank" value="{{ old('bank') }}" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>

    {{-- Branch / Account --}}
    <div>
      <label for="branch" class="block mb-2 text-sm font-medium text-gray-700">Branch</label>
      <input id="branch" name="branch" value="{{ old('branch') }}" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>
    <div>
      <label for="account" class="block mb-2 text-sm font-medium text-gray-700">Account Number</label>
      <input id="account" name="account_number" value="{{ old('account_number') }}" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
    </div>
  </div>

  <div class="flex items-center justify-end gap-3 mt-8">
    <button type="button" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Cancel</button>
    <button type="submit" class="rounded-lg bg-brandPurple px-5 py-2.5 font-semibold text-white hover:brightness-110">Save Employee</button>
  </div>
</form>

























{{--
          <!-- Form -->
          <form class="mt-8" method="POST" action="{{ route('employees.store') }}">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
              <!-- Row 1 -->
              <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Name</label>
                <input id="name" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>

              <div class="grid grid-cols-1 gap-5 md:grid-cols-2 md:col-span-2">
                <div>
                  <label for="designation" class="block mb-2 text-sm font-medium text-gray-700">Designation</label>
                  <div class="relative">
                    <select id="designation" class="w-full h-12 px-4 pr-10 bg-white border border-gray-200 appearance-none rounded-xl focus:border-gray-300 focus:outline-none">
                      <option value="" disabled selected>Select</option>
                      <option>Designer</option>
                      <option>Technical Supervisor</option>
                      <option>Sales</option>
                      <option>Accountant</option>
                    </select>
                    <svg class="absolute w-5 h-5 text-gray-500 -translate-y-1/2 pointer-events-none right-3 top-1/2" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                    </svg>
                  </div>
                </div>
                <div>
                  <label for="commencement" class="block mb-2 text-sm font-medium text-gray-700">Date of Commencement</label>
                  <input id="commencement" type="date" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
                </div>
              </div>

              <!-- Row 2 -->
              <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
                <input id="phone" type="tel" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>
              <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>

              <!-- Row 3 -->
              <div>
                <label for="nationality" class="block mb-2 text-sm font-medium text-gray-700">Nationality</label>
                <input id="nationality" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>
              <div>
                <label for="dob" class="block mb-2 text-sm font-medium text-gray-700">Date of Birth</label>
                <input id="dob" type="date" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>

              <!-- Row 4 -->
              <div>
                <label for="hometown" class="block mb-2 text-sm font-medium text-gray-700">Hometown</label>
                <input id="hometown" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>
              <div>
                <label for="language" class="block mb-2 text-sm font-medium text-gray-700">Language Spoken</label>
                <input id="language" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>

              <!-- Row 5 -->
              <div>
                <label for="address" class="block mb-2 text-sm font-medium text-gray-700">Permanent Address</label>
                <input id="address" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>
              <div>
                <label for="gps" class="block mb-2 text-sm font-medium text-gray-700">GPS Address</label>
                <input id="gps" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>

              <!-- Row 6 -->
              <div>
                <label for="nok" class="block mb-2 text-sm font-medium text-gray-700">Next of Kin</label>
                <input id="nok" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>
              <div>
                <label for="relation" class="block mb-2 text-sm font-medium text-gray-700">Relation</label>
                <input id="relation" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>

              <!-- Row 7 -->
              <div>
                <label for="nokphone" class="block mb-2 text-sm font-medium text-gray-700">Next of Kin Phone</label>
                <input id="nokphone" type="tel" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>
              <div>
                <label for="bank" class="block mb-2 text-sm font-medium text-gray-700">Bank</label>
                <input id="bank" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>

              <!-- Row 8 -->
              <div>
                <label for="branch" class="block mb-2 text-sm font-medium text-gray-700">Branch</label>
                <input id="branch" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>
              <div>
                <label for="account" class="block mb-2 text-sm font-medium text-gray-700">Account Number</label>
                <input id="account" type="text" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
              </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8">
              <button type="button" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Cancel</button>
              <button type="submit" class="rounded-lg bg-brandPurple px-5 py-2.5 font-semibold text-white hover:brightness-110">Save Employee</button>
            </div>
          </form>
        </div>
      </section>
    </main>
  </div> --}}

  <script>
    // simple avatar preview
    const input = document.getElementById('avatar');
    const preview = document.getElementById('avatarPreview');
    input?.addEventListener('change', (e) => {
      const file = e.target.files?.[0];
      if (!file) return;
      const url = URL.createObjectURL(file);
      preview.src = url;
      preview.classList.remove('hidden');
    });
  </script> 
    </main>
</x-layouts.app>
