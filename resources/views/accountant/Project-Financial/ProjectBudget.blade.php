<style>[x-cloak]{display:none!important}</style>

      @if(session('success'))
        <div class="px-3 py-2 mb-4 text-sm text-green-700 rounded bg-green-50">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="px-3 py-2 mb-4 text-sm text-red-700 rounded bg-red-50">
          <ul class="list-disc list-inside">
            @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
          </ul>
        </div>
      @endif


      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Budgets</h1>
        <button @click="wizardOpen=true"
                x-data="{wizardOpen:false}"
                @click.prevent="wizardOpen = true; $dispatch('open-wizard')"
                class="px-5 py-2 rounded-full text-white bg-fuchsia-900 hover:bg-[#F59E0B]">
          + Create Budget
        </button>
      </div>
        {{-- The wizard modal lives here and listens for the open event --}}

<div class="shadow-md rounded-[15px] bg-white">
  <table class="min-w-full mt-6 text-left bg-white rounded-[20px]">
    <thead class="text-sm text-gray-600 bg-gray-100">
      <tr>
        <th class="p-4 font-medium text-[15px]">Client Name</th>
        <th class="p-4 font-medium text-[15px]">Total Budget</th>
        <th class="p-4 font-medium text-[15px]">Cost</th>
        <th class="p-4 font-medium text-[15px]">Balance</th>
        <th class="p-4 font-medium text-[15px]">Status</th>
        <th class="p-4 font-medium text-[15px] text-right">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($projectsBudget as $p)
        @php
          $clientName = $p->client->firstname. ' '.$p->client->lastname
                        ?? trim(($p->client->firstname ?? '').' '.($p->client->lastname ?? ''))
                        ?: '—';
          $cur = $p->budget->currency ?? 'GHS';
          $fmt = fn($n) => number_format((float)$n, 2);

          // badge tones
          $tone = $p->budget_status['tone'] ?? 'gray';
          $badge = match ($tone) {
            'green' => 'bg-green-100 text-green-700 border-green-500',
            'amber' => 'bg-yellow-100 text-yellow-700 border-yellow-500',
            'red'   => 'bg-red-100 text-red-700 border-red-500',
            default => 'bg-gray-100 text-gray-700 border-gray-400',
          };
        @endphp

        <tr class="border-t hover:bg-gray-50">
          <td class="p-4 font-normal text-[15px]">{{ $clientName }}</td>
          <td class="p-4 font-normal text-[15px]">{{ $cur }} {{ $fmt($p->total_budget) }}</td>
          <td class="p-4 font-normal text-[15px]">{{ $cur }} {{ $fmt($p->total_cost) }}</td>
          <td class="p-4 font-normal text-[15px]">{{ $cur }} {{ $fmt($p->balance) }}</td>
          <td class="p-4">
            <span class="inline-block text-[13px] mt-1 px-4 py-[3px] border rounded-full {{ $badge }}">
              {{ $p->budget_status['label'] ?? 'No budget' }}
            </span>
          </td>

          {{-- Actions (three-dots) --}}
          {{-- <td class="p-4 text-right" x-data="{ open:false }">
            <button type="button" @click="open = !open" class="p-2 rounded hover:bg-gray-100">
              <iconify-icon icon="mdi:dots-vertical"></iconify-icon>
            </button>
            <div x-show="open" x-cloak @click.away="open=false"
                 class="absolute z-10 w-56 mt-2 bg-white border shadow-lg right-6 rounded-xl">
              <div class="py-1 text-sm">
                <button type="button"
                        class="w-full px-4 py-2 text-left hover:bg-gray-50"
                        @click="open=false; openCostFor({{ $p->id }})">
                  Edit Budget
                </button>
                <button type="button"
                        class="w-full px-4 py-2 text-left hover:bg-gray-50"
                        @click="open=false; $dispatch('open-wizard')">
                Delete Budget            </button>

              </div>
            </div>
          </td> --}}

     {{-- Inside @forelse ($projectsBudget as $p) --}}
<td class="p-4 text-right" x-data="{ open:false, confirm:false }">
  <button type="button" @click="open = !open" class="p-2 rounded hover:bg-gray-100">
    <iconify-icon icon="mdi:dots-vertical"></iconify-icon>
  </button>

  <div x-show="open" x-cloak @click.away="open=false"
       class="absolute z-10 w-56 mt-2 bg-white border shadow-lg right-6 rounded-xl">
    <div class="py-1 text-sm">
      @if($p->budget)
        {{-- <a href="{{ route('accountant.budgets.edit', $p->budget) }}"
           class="block px-4 py-2 hover:bg-gray-50">Edit Budget</a> --}}

           <a href="{{ route('accountant.budgets.edit', $p) }}"
   class="block px-4 py-2 hover:bg-gray-50">Edit Budget</a>

        <button type="button"
                class="w-full px-4 py-2 text-left text-red-700 hover:bg-red-50"
                @click="open=false; confirm=true">
          Delete Budget
        </button>



      @else
        <div class="px-4 py-2 text-gray-400">No budget to edit</div>
      @endif
    </div>
  </div>

  {{-- Confirm delete modal --}}
  @if($p->budget)
    <!-- Delete Modal (no shadow, single white card) -->
<div x-show="confirm" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
     @click.self="confirm = false" @keydown.escape.window="confirm = false">

  <div class="relative w-full max-w-3xl mx-4 rounded-[24px] bg-white p-10">

 <!-- Header: badge left, close right -->
<div class="flex items-start justify-between mb-6">
  <!-- left badge -->
  <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-red-100">
    <iconify-icon icon="mdi:close-thick" class="text-red-600 text-xl"></iconify-icon>
  </span>

  <!-- right close -->
  <button type="button"
          @click="confirm = false"
          class="text-slate-500 hover:text-slate-700 text-2xl leading-none"
          aria-label="Close">
    &times;
  </button>
</div>


    <!-- title + subtext -->
    <div class="text-left">
      <h3 class="text-[34px] leading-tight font-extrabold tracking-tight text-slate-800">
        Delete payments?
      </h3>
      <p class="mt-4 text-[20px] leading-8 text-slate-500">
        Are you sure you want to delete the selected payment?
      </p>
    </div>

    <!-- actions (right-aligned) -->
    <div class="mt-10 flex items-center justify-end gap-4">
      <button type="button" @click="confirm = false"
              class="px-7 py-2.5 rounded-full border border-slate-300 text-slate-700
                     hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-300/60">
        Cancel
      </button>

      {{-- Update this route to the resource you’re deleting --}}
      <form method="POST" action="{{ route('accountant.budgets.destroy', $p) }}">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="px-8 py-2.5 rounded-full bg-red-600 text-white font-semibold
                       hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400/60">
          Delete
        </button>
      </form>
    </div>

  </div>
</div>

  @endif
</td>


        </tr>
      @empty
        <tr>
          <td colspan="6" class="p-6 text-center text-gray-500">No projects found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4 mb-5 ml-5 mr-5">
    {{ $projectsBudget->links('pagination::tailwind') }}
  </div>

</div>





  <main class="ml-[280px] mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen">
    <div class="p-6">
{{--
      @if(session('success'))
        <div class="px-3 py-2 mb-4 text-sm text-green-700 rounded bg-green-50">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="px-3 py-2 mb-4 text-sm text-red-700 rounded bg-red-50">
          <ul class="list-disc list-inside">
            @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
          </ul>
        </div>
      @endif


      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Budgets</h1>
        <button @click="wizardOpen=true"
                x-data="{wizardOpen:false}"
                @click.prevent="wizardOpen = true; $dispatch('open-wizard')"
                class="px-5 py-2 rounded-full text-white bg-fuchsia-900 hover:bg-[#F59E0B]">
          + Create Budget
        </button>
      </div> --}}

      {{-- The wizard modal lives here and listens for the open event --}}
      <div x-data="budgetWizard()"
           @open-wizard.window="open()">

        <!-- Modal -->
        <div x-show="show" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
          <div class="w-full max-w-xl p-6 bg-white shadow-xl rounded-2xl">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-lg font-semibold">Create Budget</h2>
              <button class="text-gray-400 hover:text-gray-600" @click="close()">✕</button>
            </div>

            <!-- Step indicator -->
            <div class="mb-4 text-sm text-gray-600">
              Step <span x-text="step"></span> of 6
            </div>

            <!-- FORM -->
            <form id="budgetWizardForm" method="POST" action="{{ route('accountant.budgets.storeWizard') }}">
              @csrf

              <!-- Step 1: Project + Main -->
              <div x-show="step===1" x-cloak>
                <label class="block mb-2 text-sm font-medium">Select Project (no budget yet)</label>
                <select name="project_id" x-model="form.project_id"
                        class="w-full px-3 py-2 mb-4 border rounded-lg">
                  <option value="">— Select project —</option>
                  @foreach($projects as $proj)
                    <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                  @endforeach
                </select>

                <label class="block mb-2 text-sm font-medium">Main Budget (GHS)</label>
                <input type="number" step="0.01" min="0"
                       name="main_amount" x-model="form.main_amount"
                       class="w-full px-3 py-2 border rounded-lg" placeholder="e.g. 2000" />
              </div>

              <!-- Step 2: Measurement -->
              <div x-show="step===2" x-cloak>
                <label class="block mb-2 text-sm font-medium">Measurement Amount (GHS)</label>
                <input type="number" step="0.01" min="0"
                       name="amounts[Measurement]" x-model="form.amounts.Measurement"
                       class="w-full px-3 py-2 border rounded-lg" placeholder="e.g. 500" />
              </div>

              <!-- Step 3: Design -->
              <div x-show="step===3" x-cloak>
                <label class="block mb-2 text-sm font-medium">Design Amount (GHS)</label>
                <input type="number" step="0.01" min="0"
                       name="amounts[Design]" x-model="form.amounts.Design"
                       class="w-full px-3 py-2 border rounded-lg" placeholder="e.g. 500" />
              </div>

              <!-- Step 4: Production -->
              <div x-show="step===4" x-cloak>
                <label class="block mb-2 text-sm font-medium">Production Amount (GHS)</label>
                <input type="number" step="0.01" min="0"
                       name="amounts[Production]" x-model="form.amounts.Production"
                       class="w-full px-3 py-2 border rounded-lg" placeholder="e.g. 700" />
              </div>

              <!-- Step 5: Installation -->
              <div x-show="step===5" x-cloak>
                <label class="block mb-2 text-sm font-medium">Installation Amount (GHS)</label>
                <input type="number" step="0.01" min="0"
                       name="amounts[Installation]" x-model="form.amounts.Installation"
                       class="w-full px-3 py-2 border rounded-lg" placeholder="e.g. 300" />
              </div>

              <!-- Step 6: Extra items (dynamic rows) -->
              <div x-show="step===6" x-cloak>
                <div class="flex items-center justify-between mb-2">
                  <label class="block text-sm font-medium">Extra Items (optional)</label>
                  <button type="button" @click="addExtra()"
                          class="px-3 py-1 text-sm bg-gray-100 rounded-lg hover:bg-gray-200">
                    + Add Item
                  </button>
                </div>

                <template x-for="(row, idx) in form.extras" :key="idx">
                  <div class="grid grid-cols-12 gap-2 mb-2">
                    <input type="text" class="col-span-7 px-3 py-2 border rounded-lg"
                           :name="`extras[${idx}][name]`"
                           x-model="row.name" placeholder="Item name (e.g. Custom Category)" />
                    <input type="number" step="0.01" min="0"
                           class="col-span-4 px-3 py-2 border rounded-lg"
                           :name="`extras[${idx}][amount]`"
                           x-model="row.amount" placeholder="Amount" />
                    <button type="button" class="col-span-1 text-red-600" @click="removeExtra(idx)">✕</button>
                  </div>
                </template>

                <!-- Summary -->
                <div class="mt-4 text-sm text-gray-700">
                  <div class="flex justify-between"><span>Main budget:</span><span x-text="fmt(form.main_amount)"></span></div>
                  <div class="flex justify-between"><span>Allocated (core + extras):</span><span x-text="fmt(totalAllocated())"></span></div>
                  <div class="flex justify-between font-semibold"><span>Remaining:</span><span x-text="fmt(remaining())"></span></div>
                </div>
              </div>

              <!-- Footer buttons -->
              <div class="flex items-center justify-between mt-6">
                <button type="button" class="px-4 py-2 border rounded-lg" @click="back()" x-show="step>1">Back</button>

                <div class="ml-auto">
                  <button type="button" class="px-4 py-2 text-white rounded-lg bg-fuchsia-900 hover:bg-purple-800"
                          @click="next()"
                          x-show="step<6">
                    Next
                  </button>

                  <button type="submit" class="px-4 py-2 text-white rounded-lg bg-fuchsia-900 hover:bg-purple-800"
                          x-show="step===6" @click="return submitAllowed()">
                    Create Budget
                  </button>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>

    </div>
  </main>

  <script>
    function budgetWizard () {
      return {
        show: false,
        step: 1,
        form: {
          project_id: '',
          main_amount: '',
          amounts: { Measurement: '', Design: '', Production: '', Installation: '' },
          extras: []
        },
        open(){ this.show=true; this.step=1; },
        close(){ this.show=false; },
        back(){ if(this.step>1) this.step--; },
        next(){
          // simple step validation
          if(this.step===1){
            if(!this.form.project_id){ alert('Please select a project.'); return; }
            if(!this.form.main_amount || Number(this.form.main_amount)<0){ alert('Enter a valid main budget.'); return; }
          }
          this.step++;
        },
        addExtra(){ this.form.extras.push({name:'', amount:''}); },
        removeExtra(i){ this.form.extras.splice(i,1); },
        totalAllocated(){
          const core = ['Measurement','Design','Production','Installation']
            .map(k => Number(this.form.amounts[k]||0)).reduce((a,b)=>a+b,0);
          const extras = (this.form.extras||[]).map(r => Number(r.amount||0)).reduce((a,b)=>a+b,0);
          return core + extras;
        },
        remaining(){
          return Number(this.form.main_amount||0) - this.totalAllocated();
        },
        submitAllowed(){
          const rem = this.remaining();
          if(rem < 0){
            alert('Allocations exceed main budget. Please reduce some amounts.');
            return false;
          }
          return true;
        },
        fmt(v){
          const n = Number(v||0);
          return '₵' + n.toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2});
        }
      }
    }
  </script>

