@php
  $isEdit = filled($employee ?? null);
  $title  = $isEdit ? 'Edit Employee' : 'Add Employee';
  $staffIdDisplay = $employee->staff_id ?? '—';
  $avatarUrl = $employee?->avatar_path ? asset('storage/'.$employee->avatar_path)
              : asset('images/default-avatar.png');
@endphp

<header class="sticky top-0 z-10 bg-sand/80 backdrop-blur supports-[backdrop-filter]:bg-sand/60">
  <div class="flex items-center justify-between px-6 py-4">
    <nav class="text-sm text-gray-500">
      <ol class="flex items-center gap-2">
        <li><a href="{{ route('admin.employee') }}" class="hover:text-gray-700">Employees</a></li>
        <li class="text-gray-400">›</li>
        <li class="font-medium text-brandPurple">{{ $title }}</li>
      </ol>
    </nav>
    <div class="text-sm text-gray-600">
      <span class="font-semibold">Staff ID:</span> {{ $staffIdDisplay }}
    </div>
  </div>
</header>

<section class="px-6 py-8">
  <div class="max-w-5xl p-6 mx-auto rounded-2xl shadow-soft ring-1 ring-black/5 sm:p-8">

    <form class="mt-8"
          action="{{ $isEdit ? route('admin.employees.update', $employee) : route('admin.employees.store') }}"
          method="POST"
          enctype="multipart/form-data">
      @csrf
      @if($isEdit) @method('PUT') @endif

      @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Avatar + Upload -->
      <div class="flex items-center gap-5 mb-10">
        <label for="avatar" class="grid w-20 h-20 overflow-hidden bg-gray-100 rounded-full cursor-pointer place-items-center ring-1 ring-gray-200">
          @if($isEdit && $employee->avatar_path)
            <img id="avatarPreview" class="object-cover w-full h-full" src="{{ $avatarUrl }}" alt="">
          @else
            <svg id="avatarPlaceholder" class="w-10 h-10 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/>
            </svg>
            <img id="avatarPreview" class="hidden object-cover w-full h-full" alt="">
          @endif
        </label>
        <input id="avatar" name="avatar" type="file" accept="image/*" class="hidden" />
        <div>
          <button type="button" onclick="document.getElementById('avatar').click()"
                  class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-900 rounded-lg hover:brightness-95">
            <iconify-icon></iconify-icon>
            Upload profile picture
          </button>
        </div>
      </div>

      <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-700">Name</label>
        <input name="name" value="{{ old('name', $employee->name ?? '') }}" type="text"
               class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" required />
      </div>

      <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 md:col-span-2">
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Designation</label>
            <div class="relative">
              @php $des = old('designation', $employee->designation ?? ''); @endphp
              <select name="designation"
                      class="w-full h-12 px-4 pr-10 bg-white border border-gray-200 appearance-none rounded-xl focus:border-gray-300 focus:outline-none">
                <option value="" disabled {{ $des ? '' : 'selected' }}>Select</option>
                <option value="Designer" {{ $des==='Designer'?'selected':'' }}>Designer</option>
                <option value="Technical Supervisor" {{ $des==='Technical Supervisor'?'selected':'' }}>Technical Supervisor</option>
                <option value="Sales" {{ $des==='Sales'?'selected':'' }}>Sales</option>
                <option value="Accountant" {{ $des==='Accountant'?'selected':'' }}>Accountant</option>
              </select>
              <svg class="absolute w-5 h-5 text-gray-500 -translate-y-1/2 pointer-events-none right-3 top-1/2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
              </svg>
            </div>
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Date of Commencement</label>
            <input name="commencement_date"
                   value="{{ old('commencement_date', $employee->commencement_date ?? '') }}"
                   type="date" class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
          </div>
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
          <input name="phone" value="{{ old('phone', $employee->phone ?? '') }}" type="tel"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Email Address</label>
          <input name="email" value="{{ old('email', $employee->email ?? '') }}" type="email"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Nationality</label>
          <input name="nationality" value="{{ old('nationality', $employee->nationality ?? '') }}" type="text"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Date of Birth</label>
          <input name="dob" value="{{ old('dob', $employee->dob ?? '') }}" type="date"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Hometown</label>
          <input name="hometown" value="{{ old('hometown', $employee->hometown ?? '') }}" type="text"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Language Spoken</label>
          <input name="language" value="{{ old('language', $employee->language ?? '') }}" type="text"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Permanent Address</label>
          <input name="address" value="{{ old('address', $employee->address ?? '') }}" type="text"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>
{{--         
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">GPS Address</label>
          <input name="gps" value="{{ old('gps', $employee->gps ?? '') }}" type="text"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div> --}}

        {{-- in <x-slot name="header"> or your layout’s <head> --}}
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


<div>
  <label class="block mb-2 text-sm font-medium text-gray-700">GPS Address</label>

  {{-- This will hold "lat,lng" --}}
  <input id="gpsField" name="gps"
         value="{{ old('gps', $employee->gps ?? '') }}"
         type="text"
         placeholder="e.g. 5.6037,-0.1870"
         class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none"
         readonly />

  {{-- optional hidden fields if you want them in controller --}}
  <input type="hidden" id="gpsLat" name="gps_lat" value="">
  <input type="hidden" id="gpsLng" name="gps_lng" value="">

  <div class="flex flex-wrap gap-2 mt-2">
    <button type="button"
            id="btnUseMyLocation"
            class="px-3 py-2 text-sm border rounded-lg hover:bg-gray-50">
      Use my location
    </button>
    <button type="button"
            id="btnPickOnMap"
            class="px-3 py-2 text-sm border rounded-lg hover:bg-gray-50">
      Pick on map
    </button>
    <button type="button"
            id="btnClearGps"
            class="px-3 py-2 text-sm border rounded-lg hover:bg-gray-50">
      Clear
    </button>
  </div>

  <p class="mt-1 text-xs text-gray-500">We’ll store coordinates as “lat,lng”.</p>
</div>

        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Next of Kin</label>
          <input name="next_of_kin" value="{{ old('next_of_kin', $employee->next_of_kin ?? '') }}" type="text"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Relation</label>
          <input name="relation" value="{{ old('relation', $employee->relation ?? '') }}" type="text"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Next of Kin Phone</label>
          <input name="nok_phone" value="{{ old('nok_phone', $employee->nok_phone ?? '') }}" type="tel"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Bank</label>
          <input name="bank" value="{{ old('bank', $employee->bank ?? '') }}" type="text"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Branch</label>
          <input name="branch" value="{{ old('branch', $employee->branch ?? '') }}" type="text"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Account Number</label>
          <input name="account_number" value="{{ old('account_number', $employee->account_number ?? '') }}" type="text"
                 class="w-full h-12 px-4 border border-gray-200 rounded-xl focus:border-gray-300 focus:outline-none" />
        </div>
      </div>

      <div class="flex items-center justify-end gap-3 mt-8">
        <a href="{{ route('admin.employee') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Cancel</a>
        <button type="submit" class="rounded-lg px-5 py-2.5 font-semibold text-white bg-[#5A0562] hover:bg-[#430349]">
          {{ $isEdit ? 'Save Changes' : 'Save Employee' }}
        </button>
      </div>
    </form>


    {{-- GPS Picker Modal --}}
<div id="gpsPickerModal"
     class="fixed inset-0 z-[200] hidden items-center justify-center bg-black/40">
  <div class="w-full max-w-2xl mx-3 bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="flex items-center justify-between px-4 py-3 border-b">
      <h3 class="font-semibold">Pick location on map</h3>
      <button type="button" id="gpsPickerClose" class="text-gray-500 hover:text-gray-700">✕</button>
    </div>
    <div class="p-4">
      <div id="gpsMap" class="w-full h-[420px] rounded-lg"></div>
      <div class="flex items-center justify-between mt-3 text-sm">
        <div>
          <span class="text-gray-600">Selected:</span>
          <span id="gpsCoords" class="font-medium">—</span>
        </div>
        <div class="flex gap-2">
          <button type="button" id="gpsPickerCancel" class="px-3 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
          <button type="button" id="gpsPickerSave" class="px-3 py-2 text-white rounded-lg bg-[#5A0562] hover:brightness-110">
            Use this location
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

    <script>
      const input = document.getElementById('avatar');
      const preview = document.getElementById('avatarPreview');
      const placeholder = document.getElementById('avatarPlaceholder');
      input?.addEventListener('change', (e) => {
        const file = e.target.files?.[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        preview.src = url;
        preview?.classList.remove('hidden');
        placeholder?.classList.add('hidden');
      });
    </script>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const gpsField = document.getElementById('gpsField');
  const gpsLat   = document.getElementById('gpsLat');
  const gpsLng   = document.getElementById('gpsLng');
  const btnUse   = document.getElementById('btnUseMyLocation');
  const btnPick  = document.getElementById('btnPickOnMap');
  const btnClear = document.getElementById('btnClearGps');

  const modal      = document.getElementById('gpsPickerModal');
  const closeX     = document.getElementById('gpsPickerClose');
  const cancelBtn  = document.getElementById('gpsPickerCancel');
  const saveBtn    = document.getElementById('gpsPickerSave');
  const coordsSpan = document.getElementById('gpsCoords');

  let map, marker, chosen = null;

  function setFields(lat, lng) {
    const v = `${lat.toFixed(6)},${lng.toFixed(6)}`;
    gpsField.value = v;
    if (gpsLat) gpsLat.value = lat;
    if (gpsLng) gpsLng.value = lng;
  }

  function parseExisting() {
    const v = (gpsField.value || '').trim();
    if (!v.includes(',')) return null;
    const [la, ln] = v.split(',').map(n => parseFloat(n));
    if (isFinite(la) && isFinite(ln)) return { lat: la, lng: ln };
    return null;
  }

  // Use my location (HTML5 geolocation)
  btnUse?.addEventListener('click', () => {
    if (!navigator.geolocation) {
      alert('Geolocation is not supported by your browser.');
      return;
    }
    navigator.geolocation.getCurrentPosition(
      pos => {
        const { latitude, longitude } = pos.coords;
        setFields(latitude, longitude);
      },
      err => {
        alert('Could not get your location.');
        console.error(err);
      },
      { enableHighAccuracy: true, timeout: 10000 }
    );
  });

  // Open the map modal
  btnPick?.addEventListener('click', () => {
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // init Leaflet once
    setTimeout(() => {
      if (!map) {
        // Center on Ghana by default
        const defaultCenter = [7.9465, -1.0232];
        const start = parseExisting() || { lat: defaultCenter[0], lng: defaultCenter[1] };

        map = L.map('gpsMap').setView([start.lat, start.lng], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        marker = L.marker([start.lat, start.lng], { draggable: true }).addTo(map);
        chosen = { lat: start.lat, lng: start.lng };
        coordsSpan.textContent = `${chosen.lat.toFixed(6)},${chosen.lng.toFixed(6)}`;

        marker.on('dragend', e => {
          const { lat, lng } = e.target.getLatLng();
          chosen = { lat, lng };
          coordsSpan.textContent = `${lat.toFixed(6)},${lng.toFixed(6)}`;
        });

        map.on('click', e => {
          const { lat, lng } = e.latlng;
          marker.setLatLng([lat, lng]);
          chosen = { lat, lng };
          coordsSpan.textContent = `${lat.toFixed(6)},${lng.toFixed(6)}`;
        });
      } else {
        // If re-opening, recenter to current value
        const start = parseExisting();
        if (start) {
          map.setView([start.lat, start.lng], 12);
          marker.setLatLng([start.lat, start.lng]);
          chosen = { lat: start.lat, lng: start.lng };
          coordsSpan.textContent = `${chosen.lat.toFixed(6)},${chosen.lng.toFixed(6)}`;
        }
      }
      // Fix map resize after modal shown
      setTimeout(() => map.invalidateSize(), 50);
    }, 0);
  });

  function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  closeX?.addEventListener('click', closeModal);
  cancelBtn?.addEventListener('click', closeModal);

  // Save selection back to the field
  saveBtn?.addEventListener('click', () => {
    if (!chosen) {
      alert('Please pick a point on the map.');
      return;
    }
    setFields(chosen.lat, chosen.lng);
    closeModal();
  });

  btnClear?.addEventListener('click', () => {
    gpsField.value = '';
    if (gpsLat) gpsLat.value = '';
    if (gpsLng) gpsLng.value = '';
  });

  // Close on backdrop click
  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
  });

  // Close on ESC
  document.addEventListener('keydown', (e) => {
    if (!modal.classList.contains('hidden') && e.key === 'Escape') closeModal();
  });
});
</script>

