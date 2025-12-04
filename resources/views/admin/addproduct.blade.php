{{-- addproject.blade.php --}}
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

    <main class="bg-[#F9F7F7] min-h-screen">
        <div class="p-3 space-y-3 sm:p-4">
            {{-- breadcrumbs … --}}
            {{-- navigation bar --}}
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center justify-between mb-6">
                    <span>
                        <iconify-icon icon="akar-icons:home" class="w-[5] h-[5] text-fuchsia-900 ml-[3px]"></iconify-icon>
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




            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data"
                x-data="productWizard()">
                @csrf
                @method('PATCH')

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
                <!-- STEP 1: Basics (READ-ONLY) -->

                <div x-show="step === 0" x-transition x-cloak>
                    <div class="w-full max-w-xl p-4 mx-auto space-y-4 bg-white shadow-sm rounded-2xl">

                        <div>
                            <label class="block text-[15px] mb-2 font-semibold text-gray-900">Product Name</label>
                            <input type="text" value="{{ old('product[name]', $product->name) }}" readonly
                                class="w-full px-3 py-2 text-gray-700 bg-gray-100 border rounded-lg">
                            <!-- submit the value even though it's readonly -->
                            <input type="hidden" name="product[name]"
                                value="{{ old('product[name]', $product->name) }}">
                        </div>

                        <div>
                            <label class="block text-[15px] mb-2 font-semibold text-gray-900">Product Type</label>
                            <input type="text" value="{{ $product->product_type }}" readonly
                                class="w-full px-3 py-2 text-gray-700 bg-gray-100 border rounded-lg">
                            <!-- submit the value even though it's readonly -->
                            <input type="hidden" name="product[product_type]" value="{{ $product->product_type }}">
                        </div>

                        {{-- (Optional) show project name too, still readonly; keep if you want it visible --}}

                    </div>
                </div>

                <!-- STEP 1: Finish -->
                <div x-show="step === 1" x-transition x-cloak>
                    <div class="w-full max-w-xl p-4 mx-auto bg-white shadow-sm rounded-2xl">
                        <div class="mt-4">
                            {{-- type of finish (select) --}}
                            <label class="block text-[15px] mb-2 font-semibold text-gray-900">Type of Finish</label>
                            <select name="product[type_of_finish]"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                                <option value="">— select finish —</option>
                                @foreach ($finishTypes ?? [] as $f)
                                    <option value="{{ $f }}">{{ $f }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col gap-3 mt-4 sm:flex-row">
                            {{-- color of finish (hex) --}}
                            <div class="flex-1">
                                <label class="block text-[15px] mb-2 font-semibold text-gray-900">Finish Color</label>
                                <input type="color" name="product[finish_color_hex]"
                                    class="w-full h-[44px] border rounded-lg">
                            </div>
                            {{-- sample finish image (file) --}}
                            <div class="flex-1">
                                <label class="block text-[15px] mb-2 font-semibold text-gray-900">Sample Finish
                                    Image</label>
                                <input type="file" name="product[sample_finish_image]" accept="image/*"
                                    class="w-full px-3 py-2 bg-white border rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Glassdoor -->
                <div x-show="step === 2" x-transition x-cloak>
                    <div class="w-full max-w-xl p-4 mx-auto bg-white shadow-sm rounded-2xl">
                        {{-- Type of glass door (select) --}}
                        <label class="block text-[15px] mb-2 font-semibold text-gray-900">Type of Glass Door</label>
                        <select name="product[glass_door_type]"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                            <option value="">— select glass —</option>
                            @foreach ($glassTypes ?? [] as $g)
                                <option value="{{ $g }}">{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- STEP 3: Worktop -->
                <div x-show="step === 3" x-transition x-cloak>
                    <div class="w-full max-w-xl p-4 mx-auto bg-white shadow-sm rounded-2xl">
                        {{-- Type of worktop (select) --}}
                        <label class="block text-[15px] mb-2 font-semibold text-gray-900">Type of Worktop</label>
                        <select name="product[worktop_type]"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                            <option value="">— select worktop —</option>
                            @foreach ($worktopTypes ?? [] as $w)
                                <option value="{{ $w }}">{{ $w }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col w-full max-w-xl gap-3 p-4 mx-auto mt-4 bg-white shadow-sm rounded-2xl sm:flex-row">
                        {{-- color of worktop --}}
                        <div class="flex-1">
                            <label class="block text-[15px] mb-2 font-semibold text-gray-900">Worktop Color</label>
                            <input type="color" name="product[worktop_color_hex]"
                                class="w-full h-[44px] border rounded-lg">
                        </div>
                        {{-- sample worktop image --}}
                        <div class="flex-1">
                            <label class="block text-[15px] mb-2 font-semibold text-gray-900">Sample Worktop
                                Image</label>
                            <input type="file" name="product[sample_worktop_image]" accept="image/*"
                                class="w-full px-3 py-2 bg-white border rounded-lg">
                        </div>
                    </div>
                </div>

                <!-- STEP 4: Sink & Top -->
                <div x-show="step === 4" x-transition x-cloak>
                    <div class="w-full max-w-xl p-4 mx-auto bg-white shadow-sm rounded-2xl">
                        {{-- Type of sink & top --}}
                        <label class="block text-[15px] mb-2 font-semibold text-gray-900">Sink & Top Type</label>
                        <select name="product[sink_top_type]"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                            <option value="">— select type —</option>
                            @foreach ($sinkTopTypes ?? [] as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full max-w-xl p-4 mx-auto bg-white shadow-sm rounded-2xl">
                        {{-- Handle type --}}
                        <label class="block text-[15px] mb-2 font-semibold text-gray-900">Handle Type</label>
                        <select name="product[handle]"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                            <option value="">— select handle —</option>
                            @foreach ($handleTypes ?? [] as $h)
                                <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col w-full max-w-xl gap-3 p-4 mx-auto mt-4 bg-white shadow-sm rounded-2xl sm:flex-row">
                        {{-- color of sink --}}
                        <div class="flex-1">
                            <label class="block text-[15px] mb-2 font-semibold text-gray-900">Sink Color</label>
                            <input type="color" name="product[sink_color_hex]"
                                class="w-full h-[44px] border rounded-lg">
                        </div>
                        {{-- sample sink image --}}
                        <div class="flex-1">
                            <label class="block text-[15px] mb-2 font-semibold text-gray-900">Sample Sink Image</label>
                            <input type="file" name="product[sample_sink_image]" accept="image/*"
                                class="w-full px-3 py-2 bg-white border rounded-lg">
                        </div>
                    </div>
                </div>

                <!-- STEP 5: Appliances -->
                <div x-show="step === 5" x-transition x-cloak>
                    <div class="w-full max-w-5xl p-4 mx-auto bg-white shadow-sm rounded-2xl">
                        {{-- 10 paginated appliances with checkbox to select --}}




                        {{-- put this in your <head> once --}}
                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        @php
                            // initial data from DB
                            // $catalog: list of accessories with ->id, ->name (+ eager-loaded ->types if you like)
                            // $sizes: global sizes list
                            // $initialRows: the current product’s selected accessories (for edit), or [] on create
                            $catalog = \App\Models\Accessory::with('types:id,accessory_id,value')
                                ->where('is_active', true)
                                ->get(['id', 'name']);
                            $sizes = ['45cm', '50cm', '54cm', '60cm', '70cm', '80cm', '90cm'];
                            $initialRows = old(
                                'accessories',
                                isset($product)
                                    ? $product->accessories
                                        ->map(
                                            fn($a) => [
                                                'accessory_id' => $a->id,
                                                'size' => $a->pivot->size,
                                                'type' => $a->pivot->type,
                                            ],
                                        )
                                        ->values()
                                        ->toArray()
                                    : [],
                            );
                        @endphp

                        <div x-data="accessoriesUI({
                            catalog: @js(
    $catalog->map(
        fn($a) => [
            'id' => $a->id,
            'name' => $a->name,
            'types' => $a->types?->pluck('value')->values()->all() ?? [],
        ],
    ),
),
                            sizes: @js($sizes),
                            initialRows: @js($initialRows),
                            storeUrl: '{{ route('accessories.ajax.store') }}',
                        })" class="p-4 space-y-4 border rounded-2xl">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold">Accessories</h3>
                                <div class="flex gap-2">
                                    <button type="button" @click="openNewAccessoryModal()"
                                        class="px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                                        + New accessory
                                    </button>
                                    <button type="button" @click="addRow()"
                                        class="px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                                        + Add row
                                    </button>
                                </div>
                            </div>

                            {{-- rows --}}
                            <template x-if="rows.length === 0">
                                <p class="text-sm text-gray-500">No accessories added yet.</p>
                            </template>

                            <template x-for="(row, i) in rows" :key="i">
                                <div class="p-3 space-y-3 border rounded-xl">
                                    {{-- Name select --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Accessory</label>
                                        <select class="w-full px-3 py-2 border rounded-lg"
                                                :name="`accessories[${i}][id]`"
                                                x-model="row.accessory_id"
                                                @change="selectAccessory(i, catalog.find(c => String(c.id) === String($event.target.value)) || {id:null})">
                                            <option value="">Select accessory</option>
                                            <template x-for="item in catalog" :key="item.id">
                                                <option :value="item.id" x-text="item.name"></option>
                                            </template>
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                        {{-- Size --}}
                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">Size</label>
                                            <select class="w-full px-3 py-2 border rounded-lg"
                                                :name="`accessories[${i}][size]`" x-model="row.size" required>
                                                <option value="">Select size</option>
                                                <template x-for="s in sizes" :key="s">
                                                    <option :value="s" x-text="s"></option>
                                                </template>
                                            </select>
                                        </div>

                                        {{-- Type (radios driven by selected accessory’s types) --}}
                                        <div class="md:col-span-2">
                                            <label class="block mb-1 text-sm font-medium text-gray-700">Type</label>
                                            <div class="flex flex-wrap gap-4 pt-1">
                                                <template x-if="(typesMap[row.accessory_id] || []).length === 0">
                                                    <span class="text-sm text-gray-500">No type required for this
                                                        accessory.</span>
                                                </template>
                                                <template x-for="t in (typesMap[row.accessory_id] || [])"
                                                    :key="t">
                                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                                        <input type="radio" :name="`accessories[${i}][type]`"
                                                            :value="t" :checked="row.type === t"
                                                            @change="row.type = t" required>
                                                        <span class="text-sm" x-text="t"></span>
                                                    </label>
                                                </template>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="button" @click="removeRow(i)"
                                            class="text-sm text-red-600 hover:underline">Remove</button>
                                    </div>
                                </div>
                            </template>

                            {{-- NEW ACCESSORY MODAL --}}
                            <div x-show="modal.open" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                <div class="w-full max-w-md p-5 bg-white shadow-xl rounded-2xl">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-semibold">New Accessory</h4>
                                        <button type="button" @click="closeNewAccessoryModal()"
                                            class="text-gray-500 hover:text-gray-700">✕</button>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium">Name</label>
                                            <input type="text" class="w-full px-3 py-2 border rounded-lg"
                                                x-model="modal.form.name" placeholder="e.g. Hood" />
                                            <p class="text-xs text-red-600" x-text="errors.name"></p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium">
                                                Type options <span class="text-gray-500">(comma-separated)</span>
                                            </label>
                                            <input type="text" class="w-full px-3 py-2 border rounded-lg"
                                                x-model="modal.form.types_csv"
                                                placeholder="e.g. Undercabinet, Chimney" />
                                            <p class="text-xs text-red-600" x-text="errors.types_csv"></p>
                                        </div>

                                        <div class="flex justify-end gap-2 pt-2">
                                            <button type="button" @click="closeNewAccessoryModal()"
                                                class="px-3 py-2 border rounded-lg">Cancel</button>
                                            <button type="button" @click="saveNewAccessory()"
                                                class="px-4 py-2 text-white rounded-lg bg-fuchsia-900">Save</button>
                                        </div>

                                        <p class="text-sm text-green-700" x-text="flash"></p>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>

                <!-- STEP 6: Information -->
                <div x-show="step === 6" x-transition x-cloak>
                    <div class="w-full max-w-xl p-4 mx-auto bg-white shadow-sm rounded-2xl">
                        {{-- Notes --}}
                        <label class="block text-[15px] mb-2 font-semibold text-gray-900">Deadline</label>
                        <input type="date" name="project[due_date]"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">

                        <label class="block text-[15px] mb-2 font-semibold text-gray-900">Notes</label>
                        <textarea name="product[notes]" class="w-full px-3 py-2 border rounded-lg min-h-[120px]"></textarea>
                    </div>

                </div>

                <!-- STEP 7: Summary / Preview -->
                <div x-show="step === 7" x-transition x-cloak>
                    <div class="w-full max-w-3xl p-4 mx-auto space-y-4 text-sm text-gray-800">
                        <div class="p-4 bg-white border border-gray-100 shadow-sm rounded-2xl">
                            <div class="text-base font-semibold text-gray-900">Product</div>
                            <dl class="mt-2 space-y-1" id="summary-product">
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Name</dt>
                                    <dd class="text-right" x-text="summary.product_name"></dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Type</dt>
                                    <dd class="text-right" x-text="summary.product_type"></dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Finish</dt>
                                    <dd class="text-right" x-text="summary.finish"></dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Finish color</dt>
                                    <dd class="flex items-center gap-2 text-right">
                                        <span class="inline-block w-4 h-4 border rounded-full"
                                              :style="`background:${summary.finish_color || '#fff'}`"></span>
                                        <span x-text="summary.finish_color"></span>
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Glass door</dt>
                                    <dd class="text-right" x-text="summary.glass"></dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Worktop</dt>
                                    <dd class="text-right" x-text="summary.worktop"></dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Worktop color</dt>
                                    <dd class="flex items-center gap-2 text-right">
                                        <span class="inline-block w-4 h-4 border rounded-full"
                                              :style="`background:${summary.worktop_color || '#fff'}`"></span>
                                        <span x-text="summary.worktop_color"></span>
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Sink & Top</dt>
                                    <dd class="text-right" x-text="summary.sink_top"></dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Handle</dt>
                                    <dd class="text-right" x-text="summary.handle"></dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Deadline</dt>
                                    <dd class="text-right" x-text="summary.deadline"></dd>
                                </div>
                            </dl>
                        </div>

                        <div class="p-4 bg-white border border-gray-100 shadow-sm rounded-2xl">
                            <div class="text-base font-semibold text-gray-900">Notes</div>
                            <p class="mt-2 text-sm text-gray-700 whitespace-pre-line" x-text="summary.notes"></p>
                        </div>
                    </div>
                </div>

                {{-- Controls --}}
                <div class="grid w-full max-w-xl grid-cols-1 gap-5 p-4 mx-auto mt-8 md:grid-cols-2">
                    <button type="button"
                        class="w-full rounded-[15px] px-[28px] py-[10px] text-fuchsia-900 bg-transparent border-2 border-[#5A0562] text-[17px] font-semibold hover:bg-[#5A0562]/10 focus:outline-none focus:ring-2 focus:ring-[#5A0562]/50"
                        :disabled="step === 0" @click="prev">
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


        {{-- for accesory --}}
        <script>
            function productWizard() {
                return {
                    step: {{ (int) request('step', 1) }},
                    steps: ['Basics', 'Finish', 'Glass Door', 'Worktop', 'Sink & Top', 'Appliances', 'Information', 'Summary'],
                    submitting: false,
                    summary: {
                        product_name: '',
                        product_type: '',
                        finish: '',
                        finish_color: '',
                        glass: '',
                        worktop: '',
                        worktop_color: '',
                        sink_top: '',
                        handle: '',
                        deadline: '',
                        notes: '',
                    },
                    populateSummary() {
                        const val = (name) => (document.querySelector(`[name="${name}"]`) || {}).value || '-';
                        const selectLabel = (name) => {
                            const el = document.querySelector(`[name="${name}"]`);
                            if (!el) return '-';
                            const opt = el.options[el.selectedIndex];
                            return (opt && opt.text.trim()) || el.value || '-';
                        };
                        this.summary.product_name = val('product[name]');
                        this.summary.product_type = val('product[product_type]');
                        this.summary.finish = selectLabel('product[type_of_finish]');
                        this.summary.finish_color = val('product[finish_color_hex]') || '-';
                        this.summary.glass = val('product[glass_door_type]') || '-';
                        this.summary.worktop = val('product[worktop_type]') || '-';
                        this.summary.worktop_color = val('product[worktop_color_hex]') || '-';
                        this.summary.sink_top = val('product[sink_top_type]') || '-';
                        this.summary.handle = val('product[handle]') || '-';
                        this.summary.deadline = val('project[due_date]') || '-';
                        this.summary.notes = (document.querySelector('[name="product[notes]"]') || {}).value || '-';
                    },
                    next() {
                        if (this.step < this.steps.length - 1) {
                            this.step++;
                            if (this.step === this.steps.length - 1) this.populateSummary();
                        }
                    },
                    prev() {
                        if (this.step > 0) this.step--;
                    },
                    init() {
                        if (this.step === this.steps.length - 1) this.populateSummary();
                    }
                };
            }

            document.addEventListener('alpine:init', () => {
                Alpine.data('accessoriesUI', (cfg) => ({
                    catalog: cfg.catalog ?? [],
                    sizes: cfg.sizes ?? [],
                    rows: cfg.initialRows?.map(r => ({
                        accessory_id: r.accessory_id ?? r.id ?? null,
                        size: r.size ?? '',
                        type: r.type ?? ''
                    })) ?? [],
                    // id -> array of type strings
                    typesMap: {},
                    modal: {
                        open: false,
                        form: {
                            name: '',
                            types_csv: ''
                        }
                    },
                    errors: {},
                    flash: '',
                    storeUrl: cfg.storeUrl,

                    init() {
                        // build typesMap from catalog
                        this.catalog.forEach(c => {
                            this.typesMap[c.id] = c.types || [];
                        });
                        if (this.rows.length === 0) this.addRow(); // start with one row, optional
                    },

                    addRow() {
                        this.rows.push({
                            accessory_id: '',
                            size: '',
                            type: ''
                        });
                    },
                    removeRow(i) {
                        this.rows.splice(i, 1);
                    },

                    selectAccessory(i, item) {
                        const id = item?.id ?? '';
                        this.rows[i].accessory_id = id;
                        // reset type to first allowed for this accessory (if any)
                        this.rows[i].type = id ? (this.typesMap[id]?.[0] ?? '') : '';
                    },

                    openNewAccessoryModal() {
                        this.modal.open = true;
                        this.modal.form = {
                            name: '',
                            types_csv: ''
                        };
                        this.errors = {};
                        this.flash = '';
                    },
                    closeNewAccessoryModal() {
                        this.modal.open = false;
                    },

                    async saveNewAccessory() {
                        this.errors = {};
                        this.flash = '';
                        try {
                            const res = await fetch(this.storeUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify(this.modal.form)
                            });
                            if (res.status === 422) {
                                const data = await res.json();
                                this.errors = data.errors || {};
                                return;
                            }
                            if (!res.ok) throw new Error('Failed');

                            const data = await res.json(); // { id, name, types: [...] }
                            // update local catalog + types map
                            this.catalog.push({
                                id: data.id,
                                name: data.name,
                                types: data.types || []
                            });
                            this.typesMap[data.id] = data.types || [];

                            // auto-select new accessory on the last row
                            if (this.rows.length === 0) this.addRow();
                            const i = this.rows.length - 1;
                            this.selectAccessory(i, {
                                id: data.id
                            });
                            this.flash = 'Accessory created!';
                            // close after a short delay
                            setTimeout(() => {
                                this.closeNewAccessoryModal();
                            }, 500);
                        } catch (e) {
                            this.flash = 'Failed to create accessory.';
                        }
                    }
                }))
            })
        </script>


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
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token')
                    },
                    body: formData
                });

                if (res.ok) {
                    const accessory = await res.json();

                    // Add to Step 5 accessory list dynamically
                    const list = document.querySelector(
                    '#accessoryList'); // make sure your Step 5 container has this id
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
                    steps: ['Basic', 'Finish', 'Glassdoor', 'Worktop', 'Sink & Top', 'Appliances', 'Information', 'Summary'],
                    step: 0,
                    submitting: false,
                    next() {
                        this.step = Math.min(this.step + 1, this.steps.length - 1);
                    },
                    prev() {
                        this.step = Math.max(this.step - 1, 0);
                    },
                    submit() {
                        this.submitting = true;
                        this.$el.submit();
                    } // native submit
                }
            }
        </script>
        </div>
    </main>
</x-layouts.app>
