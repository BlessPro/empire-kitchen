{{-- addproject.blade.php --}}
<x-layouts.app>
  <x-slot name="header">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>[x-cloak]{display:none!important}</style>
    @include('admin.layouts.header')
  </x-slot>

  <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen items-center">
    <div class="p-6 bg-[#F9F7F7]">
      {{-- breadcrumbs … --}}
{{-- navigation bar --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <span>
                            <iconify-icon icon="akar-icons:home"
                                class="w-[5] h-[5] text-fuchsia-900 ml-[3px]"></iconify-icon>
                        </span>
                        <span>
                            <iconify-icon icon="mingcute:right-line" width="23px"
                                class=" text-gray-300 mr-[8px] ml-[8px] mt-[4px] "></iconify-icon>
                        </span>
                        <a href="{{ route('admin.ProjectManagement') }}">
                            <h3 class="font-sans font-normal text-black cursor-pointer text-[15px] hover:underline">
                                Project Management</h3>
                        </a>
                        <span>
                            <iconify-icon icon="mingcute:right-line" width="23px"
                                class=" text-gray-300 mr-[8px] ml-[8px] mt-[4px] "></iconify-icon>
                        </span>
                        <!-- ADD CLIENT BUTTON -->
                        <h3 class="font-sans font-semibold cursor-pointer text-[15px] text-fuchsia-900">
                            Add New Project</h3>


                    </div>

                </div>



 
        <form method="POST"
              action="{{ route('projects.store') }}"
              enctype="multipart/form-data"
              x-data="projectWizard()"
              @submit.prevent="submit">
          @csrf

          {{-- STEP HEADER --}}
          <div class="max-w-5xl mx-auto mt-2 mb-6 select-none">
            <div class="flex items-center gap-6 pointer-events-none">
              <template x-for="(name, i) in steps" :key="i">
                <div class="flex-1">
                  <div class="mb-2 text-sm font-medium text-center"
                       :class="i === step ? 'text-fuchsia-900' : 'text-gray-400'">
                    <span x-text="name"></span>
                  </div>
                  <div class="h-1 transition-colors duration-300 rounded-full"
                       :class="i <= step ? 'bg-[#5A0562]' : 'bg-gray-200'"></div>
                </div>
              </template>
            </div>
          </div>

          <!-- STEP 0: Basic -->
          <div x-show="step === 0" x-transition x-cloak>
            <div class="p-4 mx-auto w-[450px]">

              <div class="mt-4">
                {{-- Select client (from clients table) --}}
                <label class="block text-[15px] mb-2 font-semibold text-gray-900">Select Client</label>
                <select name="project[client_id]" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                  <option value="">— choose client —</option>
                  @foreach($clients ?? [] as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mt-4">
                {{-- Project Name --}}
                <label class="block text-[15px] mb-2 font-semibold text-gray-900">Project Name</label>
                <input type="text" name="project[name]" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
              </div>

              <div class="mt-4">
                {{-- Product type (select) --}}
                <label class="block text-[15px] mb-2 font-semibold text-gray-900">Product Type</label>
                <select name="product[product_type]" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                  <option value="">— choose type —</option>
                  @foreach($productTypes ?? [] as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                  @endforeach
                </select>
              </div>

            </div>
          </div>

          <!-- STEP 1: Finish -->
          <div x-show="step === 1" x-transition x-cloak>
            <div class="p-4 mx-auto w-[450px]">
              <div class="mt-4">
                {{-- type of finish (select) --}}
                <label class="block text-[15px] mb-2 font-semibold text-gray-900">Type of Finish</label>
                <select name="product[type_of_finish]" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                  <option value="">— select finish —</option>
                  @foreach($finishTypes ?? [] as $f)
                    <option value="{{ $f }}">{{ $f }}</option>
                  @endforeach
                </select>
              </div>
              <div class="flex justify-between gap-3 mt-4">
                {{-- color of finish (hex) --}}
                <div class="flex-1">
                  <label class="block text-[15px] mb-2 font-semibold text-gray-900">Finish Color</label>
                  <input type="color" name="product[finish_color_hex]" class="w-full h-[44px] border rounded-lg">
                </div>
                {{-- sample finish image (file) --}}
                <div class="flex-1">
                  <label class="block text-[15px] mb-2 font-semibold text-gray-900">Sample Finish Image</label>
                  <input type="file" name="product[sample_finish_image]" accept="image/*" class="w-full px-3 py-2 bg-white border rounded-lg">
                </div>
              </div>
            </div>
          </div>

          <!-- STEP 2: Glassdoor -->
          <div x-show="step === 2" x-transition x-cloak>
            <div class="p-4 mx-auto w-[450px]">
              {{-- Type of glass door (select) --}}
              <label class="block text-[15px] mb-2 font-semibold text-gray-900">Type of Glass Door</label>
              <select name="product[glass_door_type]" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                <option value="">— select glass —</option>
                @foreach($glassTypes ?? [] as $g)
                  <option value="{{ $g }}">{{ $g }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- STEP 3: Worktop -->
          <div x-show="step === 3" x-transition x-cloak>
            <div class="p-4 mx-auto w-[450px]">
              {{-- Type of worktop (select) --}}
              <label class="block text-[15px] mb-2 font-semibold text-gray-900">Type of Worktop</label>
              <select name="product[worktop_type]" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                <option value="">— select worktop —</option>
                @foreach($worktopTypes ?? [] as $w)
                  <option value="{{ $w }}">{{ $w }}</option>
                @endforeach
              </select>
            </div>
            <div class="flex justify-between mt-4 gap-3 p-4 mx-auto w-[450px]">
              {{-- color of worktop --}}
              <div class="flex-1">
                <label class="block text-[15px] mb-2 font-semibold text-gray-900">Worktop Color</label>
                <input type="color" name="product[worktop_color_hex]" class="w-full h-[44px] border rounded-lg">
              </div>
              {{-- sample worktop image --}}
              <div class="flex-1">
                <label class="block text-[15px] mb-2 font-semibold text-gray-900">Sample Worktop Image</label>
                <input type="file" name="product[sample_worktop_image]" accept="image/*" class="w-full px-3 py-2 bg-white border rounded-lg">
              </div>
            </div>
          </div>

          <!-- STEP 4: Sink & Top -->
          <div x-show="step === 4" x-transition x-cloak>
            <div class="p-4 mx-auto w-[450px]">
              {{-- Type of sink & top --}}
              <label class="block text-[15px] mb-2 font-semibold text-gray-900">Sink & Top Type</label>
              <select name="product[sink_top_type]" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                <option value="">— select type —</option>
                @foreach($sinkTopTypes ?? [] as $s)
                  <option value="{{ $s }}">{{ $s }}</option>
                @endforeach
              </select>
            </div>
            <div class="p-4 mx-auto w-[450px]">
              {{-- Handle type --}}
              <label class="block text-[15px] mb-2 font-semibold text-gray-900">Handle Type</label>
              <select name="product[handle]" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                <option value="">— select handle —</option>
                @foreach($handleTypes ?? [] as $h)
                  <option value="{{ $h }}">{{ $h }}</option>
                @endforeach
              </select>
            </div>
            <div class="flex justify-between mt-4 gap-3 p-4 mx-auto w-[450px]">
              {{-- color of sink --}}
              <div class="flex-1">
                <label class="block text-[15px] mb-2 font-semibold text-gray-900">Sink Color</label>
                <input type="color" name="product[sink_color_hex]" class="w-full h-[44px] border rounded-lg">
              </div>
              {{-- sample sink image --}}
              <div class="flex-1">
                <label class="block text-[15px] mb-2 font-semibold text-gray-900">Sample Sink Image</label>
                <input type="file" name="product[sample_sink_image]" accept="image/*" class="w-full px-3 py-2 bg-white border rounded-lg">
              </div>
            </div>
          </div>

          <!-- STEP 5: Appliances -->
          <div x-show="step === 5" x-transition x-cloak>
            <div class="p-4 mx-auto w-[450px]">
              {{-- 10 paginated appliances with checkbox to select --}}
              <div id="accessoryList" class="space-y-2">
                @forelse(($appliances ?? []) as $a)
                  <label class="flex items-center gap-3 p-2 bg-white border rounded-lg hover:bg-gray-50">
                    <input type="checkbox" name="accessories[]" value="{{ $a->id }}">
                    <span class="text-sm">{{ $a->name }}</span>
                    <span class="ml-auto text-xs text-gray-500">{{ $a->category }}</span>
                  </label>
                @empty
                  <p class="text-sm text-gray-500">No accessories found.</p>
                @endforelse
              </div>

              {{-- (Optional) + Add New Accessory modal trigger (AJAX) --}}
              {{-- <button type="button" onclick="openAccessoryModal()" class="mt-3 text-sm text-[#5A0562] underline">+ Add New Accessory</button> --}}
            </div>
          </div>

          <!-- STEP 6: Information -->
          <div x-show="step === 6" x-transition x-cloak>
            <div class="p-4 mx-auto w-[450px]">
              {{-- Notes --}}
            <label class="block text-[15px] mb-2 font-semibold text-gray-900">Deadline</label>
            <input type="date" name="product[deadline]" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
              
              <label class="block text-[15px] mb-2 font-semibold text-gray-900">Notes</label>
              <textarea name="product[notes]" class="w-full px-3 py-2 border rounded-lg min-h-[120px]"></textarea>
            </div>
          
          </div>

          <!-- STEP 7: Summary / Preview -->
          <div x-show="step === 7" x-transition x-cloak>
            {{-- A summary of all the selected options (optional to render now) --}}
            <div class="p-4 mx-auto w-[450px] text-sm text-gray-700">
              Review your entries, then Submit.
            </div>
          </div>

          {{-- Controls --}}
          <div class="grid w-[450px] grid-cols-1 gap-5 p-4 mx-auto mt-8 md:grid-cols-2">
            <button type="button"
                    class="w-full rounded-[15px] px-[28px] py-[10px] text-fuchsia-900 bg-transparent border-2 border-[#5A0562] text-[17px] font-semibold hover:bg-[#5A0562]/10 focus:outline-none focus:ring-2 focus:ring-[#5A0562]/50"
                    :disabled="step === 0"
                    @click="prev">
              PREVIOUS
            </button>

            <template x-if="step < steps.length - 1">
              <button type="button"
                      class="w-full rounded-[15px] px-[28px] py-[10px] text-white bg-[#5A0562] text-[17px] font-semibold hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-[#5A0562]/50"
                      @click="next">
                NEXT
              </button>
            </template>

            <template x-if="step === steps.length - 1">
              <button type="submit"
                      class="w-full rounded-[18px] px-8 py-4 text-white bg-[#5A0562] text-[20px] font-semibold hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-[#5A0562]/50"
                      :disabled="submitting">
                <span x-show="!submitting">Submit</span>
                <span x-show="submitting">Submitting…</span>
              </button>
            </template>
          </div>
        </form>
  </div>
</div>


<script>
function openAccessoryModal() {
  document.getElementById('accessoryModal').classList.remove('hidden');
  document.getElementById('accessoryModal').classList.add('flex');
}
function closeAccessoryModal() {
  document.getElementById('accessoryModal').classList.add('hidden');
  document.getElementById('accessoryModal').classList.remove('flex');
}

// Handle AJAX submit
document.getElementById('accessoryForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  const res = await fetch("{{ route('accessories.store') }}", {
    method: "POST",
    headers: { 'X-CSRF-TOKEN': formData.get('_token') },
    body: formData
  });

  if (res.ok) {
    const accessory = await res.json();

    // Add to Step 5 accessory list dynamically
    const list = document.querySelector('#accessoryList'); // make sure your Step 5 container has this id
    const label = document.createElement('label');
    label.className = "flex items-center gap-3 p-2 border rounded-lg bg-white hover:bg-gray-50";
    label.innerHTML = `
      <input type="checkbox" name="accessories[]" value="${accessory.id}" checked>
      <span class="text-sm">${accessory.name}</span>
      <span class="ml-auto text-xs text-gray-500">${accessory.category}</span>
    `;
    list.appendChild(label);

    closeAccessoryModal();
    this.reset();
  } else {
    alert("Failed to create accessory");
  }
});
</script>

        {{-- Alpine Controller --}}
        <script>
          function projectWizard() {
            return {
              steps: ['Basic','Finish','Glassdoor','Worktop','Sink & Top','Appliances','Information','Summary'],
              step: 0,
              submitting: false,
              next(){ this.step = Math.min(this.step + 1, this.steps.length - 1); },
              prev(){ this.step = Math.max(this.step - 1, 0); },
              submit(){ this.submitting = true; this.$el.submit(); } // native submit
            }
          }
        </script>
    </div>
  </main>
</x-layouts.app>
