   <x-Installation-layout>

    @php
        $phases = $project->phases ?? [];
        $total = max(1, count($phases));
        $done = collect($phases)->where('done', true)->count();
        $pct = (int) round(($done / $total) * 100);
        $chip = 'inline-flex items-center h-6 rounded-full bg-gray-100 px-2.5 text-xs text-gray-800 ring-1 ring-gray-200';
        $editBtn = 'inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-medium text-[#5A0562] ring-1 ring-[#E3C8F1] hover:bg-[#FBF7FE]';

        $installDate = data_get($project, 'install_date');
        $clientName = data_get($project, 'client_name', '—');
        $locationText = data_get($project, 'location_text', '—');
    @endphp

    <div class="p-4 sm:p-6">
            {{-- navigation bar --}}
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center justify-between mb-6">
                    <span><i data-feather="home" class="w-[5] h-[5] text-fuchsia-900 ml-[3px]"></i></span>
                    <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
                    <a href="{{ route('production.projects') }}">
                        <h3 class="font-sans font-normal text-black cursor-pointer hover:underline">Project Management
                        </h3>
                    </a>
                    <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
                    </span> <span class="font-semibold text-fuchsia-900 ">
                        {{-- {{ $project->client->firstname . '  '.$project->client->lastname }} --}}
                    </span>
                </div>


                {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
                <!-- ADD CLIENT BUTTON -->
                {{-- Comments: Button + Drawer --}}
                @include('production.partials.comments-drawer', ['project' => $project])


            </div>


            <div class="rounded-[20px] border border-gray-200 bg-white shadow-sm overflow-hidden">
                {{-- Header --}}
                <div class="flex flex-wrap items-center justify-between gap-3 p-5 border-b border-gray-100">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">{{ $project->name }}</h1>
                        <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-600">
                            <span class="inline-flex items-center gap-2">
                                {{-- calendar --}}
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 2v3M16 2v3M3 9h18M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7z" />
                                </svg> <span class="font-medium">Installation:</span>
                                <span>{{ $installDate ? \Illuminate\Support\Carbon::parse($installDate)->format('M d, Y') : 'N/A' }}</span>
                            </span>
                            <span class="inline-flex items-center gap-2">
                                {{-- user --}}
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4.5 20.25a8.25 8.25 0 1 1 15 0" />
                                </svg> <span class="font-medium">Client:</span>
                                <span>{{ $clientName }}</span>
                            </span>
                            <span class="inline-flex items-center gap-2">
                                {{-- pin --}}
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 21s7-4.686 7-11a7 7 0 0 0-14 0c0 6.314 7 11 7 11Z" />
                                    <circle cx="12" cy="10" r="2.5" stroke-width="1.5" />
                                </svg> <span>{{ $locationText }}</span>
                            </span>
                        </div>
                    </div>
                    <span
                        class="px-3 py-1 text-xs font-medium rounded-full bg-fuchsia-100 text-fuchsia-800">Installation</span>
                </div>

                @php
                    $chip =
                        'inline-flex items-center h-6 rounded-full bg-gray-100 px-2.5 text-xs text-gray-800 ring-1 ring-gray-200';
                    $editBtn =
                        'inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-medium text-[#5A0562] ring-1 ring-[#E3C8F1] hover:bg-[#FBF7FE]';

                    $phases = $project->phases ?? [];
                    $done = $project->phases_meta['done'] ?? 0;
                    $total = $project->phases_meta['total'] ?? max(1, count($phases));
                    $pct = $project->phases_meta['pct'] ?? (int) round(($done / max(1, $total)) * 100);
                    $prodType = $project->phases_meta['product_type'] ?? null;
                @endphp

                <details open class="group">
                    <summary class="flex items-center justify-between gap-2 px-5 py-4 list-none cursor-pointer">
                        <span class="text-sm font-semibold text-[#5A0562]">Production Phases</span>
                        <svg class="w-5 h-5 text-gray-500 transition group-open:rotate-180" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>

                    <div class="px-5 pb-4">
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">


                            @foreach ($project->phases as $p)
                                <label class="flex items-start gap-3 px-3 py-2 border border-gray-200 rounded-lg">
                                    <input type="checkbox"
                                        class="mt-0.5 h-4 w-4 rounded border-gray-300 text-fuchsia-700 phase-toggle"
                                        data-url="{{ route('admin.projects.phases.toggle', [
                                            'project' => $project->__meta['project_id'],
                                            'template' => $p['template_id'],
                                        ]) }}"
                                        @checked($p['done'])>
                                    <span class="text-sm text-gray-800">{{ $p['name'] }}</span>
                                </label>
                            @endforeach




                        </div>

                        {{-- Completion --}}
                        <div class="mt-5">
                            <div class="flex items-center justify-between mb-1 text-xs text-gray-600">
                                <span>Completion</span><span><span
                                        id="phase-done">{{ $done }}</span>/{{ $total }}</span>
                            </div>
                            <div class="relative h-[6px] w-full overflow-hidden rounded-full bg-gray-100"
                                role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                aria-valuenow="{{ $pct }}">
                                <div id="phase-bar" class="absolute left-0 top-0 h-[6px] rounded-full bg-[#1DC76B]"
                                    style="width: {{ $pct }}%"></div>
                            </div>
                            <div id="phase-pct" class="mt-1 text-xs font-medium text-right text-emerald-700">
                                {{ $pct }}%</div>
                        </div>
                    </div>

                </details>
                {{-- Product switcher (by product name) --}}
                @if (!empty($project->products))
                    <div class="flex items-center gap-2 px-4 py-3 mt-3 overflow-x-auto">
                        <span class="mr-1 text-xs text-gray-500"></span>
                        @foreach ($project->products as $p)
                            @php
                                $isActive = $p['active'] ?? false;
                                $cls = $isActive
                                    ? 'bg-[#5A0562] text-white ring-[#E3C8F1]'
                                    : 'bg-gray-100 text-gray-800 ring-gray-200 hover:bg-gray-200';
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['product_id' => $p['id']]) }}"
                                class="inline-flex items-center h-7 rounded-full px-3 text-xs font-medium ring-1 {{ $cls }}"
                                title="{{ $p['product_type'] ?? '' }}">
                                {{ $p['name'] }}
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Product Specifications --}}
                <div class="border-t border-gray-100"></div>
                <div class="px-5 py-4">
                    <h3 class="text-sm font-semibold text-[#5A0562]">Product Specifications</h3>

                    {{-- Product Type --}}
                    <div class="mt-3 border border-gray-200 rounded-xl">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">Product Type</span>
                            {{-- <a href="#" class="{{ $editBtn }}">Edit</a> --}}

                            @php
                                // id of the currently selected product (from your VM)
                                $activeProductId =
                                    collect($project->products ?? [])->firstWhere('active', true)['id'] ?? null;
                                $activeType = $project->selected_product_type ?? '—';
                            @endphp

                            <a href="#" id="btn-edit-product-type"
                                class="{{ $editBtn }} {{ $activeProductId ? '' : 'pointer-events-none opacity-50' }}"
                                data-product-id="{{ $activeProductId }}" data-current-type="{{ $activeType }}">
                                Edit
                            </a>


                        </div>
                        <div class="px-4 py-3 border-t border-gray-100">
                            <div class="flex flex-wrap items-center gap-2">
                                {{-- @foreach ($project->productTypes as $type)
                                    <span class="{{ $chip }}">{{ $type }}</span>
                                @endforeach --}}
                                <span id="chip-product-type"
                                    class="inline-flex items-center h-6 rounded-full bg-gray-100 px-2.5 text-xs text-gray-800 ring-1 ring-gray-200">
                                    {{ $project->selected_product_type ?? '—' }}
                                </span>

                                <button
                                    class="ml-2 inline-flex items-center h-7 rounded-[10px] bg-[#5A0562] px-3 text-xs font-medium text-white">+
                                    Add Product</button>

                                <a href="#" class="block px-4 py-2 add-product-trigger hover:bg-gray-100"
                                    data-project-id="{{ $project->id }}" data-project-name="{{ $project->name }}"
                                    onclick="event.preventDefault();">
                                    Add new product
                                </a>


                            </div>
                        </div>
                    </div>

                    {{-- Type of Finish --}}
                    <div class="mt-3 border border-gray-200 rounded-xl">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">Type of Finish</span>
                            {{-- <a href="#" class="{{ $editBtn }}">Edit</a> --}}
                            @php
                                $activeProduct = collect($project->products ?? [])->firstWhere('active', true);
                                $activeProductId = $activeProduct['id'] ?? null;
                            @endphp

                            <a href="#" id="btn-edit-finish"
                                class="{{ $editBtn }} {{ $activeProductId ? '' : 'pointer-events-none opacity-50' }}"
                                data-product-id="{{ $activeProductId }}"
                                data-current-label="{{ data_get($project, 'finish.label', '—') }}"
                                data-current-color="{{ data_get($project, 'finish.color', '') }}"
                                data-current-image="{{ data_get($project, 'finish.image_url', '') }}">
                                Edit
                            </a>

                        </div>


                        <div class="flex flex-wrap items-center gap-2 px-4 py-3 text-sm">
                            <span id="finish-label" class="{{ $chip }}">{{ data_get($project, 'finish.label', '—') }}</span>
                            <span class="{{ $chip }}">Color: <span class="ml-1 font-medium">{{ data_get($project, 'finish.color', '—') }}</span></span>
                            @if (data_get($project, 'finish.color'))
                                <span id="finish-color" class="inline-flex w-8 h-5 rounded-md ring-1 ring-gray-300" style="background: {{ e(data_get($project, 'finish.color')) }}"></span>
                            @else
                                <span id="finish-color" class="inline-flex hidden w-8 h-5 rounded-md ring-1 ring-gray-300"></span>
                            @endif

                            @if (data_get($project, 'finish.image_url'))
                                <span id="finish-image" class="inline-block w-10 h-5 bg-center bg-cover rounded-md ring-1 ring-gray-300" style="background-image: url('{{ data_get($project, 'finish.image_url') }}')"></span>
                            @else
                                <span id="finish-image" class="hidden inline-block w-10 h-5 bg-center bg-cover rounded-md ring-1 ring-gray-300"></span>
                            @endif
                        </div>



                    </div>

                    {{-- Type of Glass Door --}}
                    <div class="mt-3 border border-gray-200 rounded-xl">
                        @php
                            $activeProduct = collect($project->products ?? [])->firstWhere('active', true);
                            $activeProductId = $activeProduct['id'] ?? null;
                        @endphp

                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">Type of Glass Door</span>
                            <a href="#" id="btn-edit-glass"
                                class="{{ $editBtn }} {{ $activeProductId ? '' : 'pointer-events-none opacity-50' }}"
                                data-product-id="{{ $activeProductId }}"
                                data-current="{{ $project->glass_door_type ?? '—' }}">
                                Edit
                            </a>
                        </div>

                        <div class="px-4 py-3 text-sm text-gray-800 border-t border-gray-100">
                            <span id="glass-door-value" class="">{{ $project->glass_door_type ?? '—' }}</span>
                        </div>



                    </div>

                    {{-- Worktop Type --}}
                    <div class="mt-3 border border-gray-200 rounded-xl">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">Worktop Type</span>
                            {{-- <a href="#" class="{{ $editBtn }}">Edit</a> --}}

                            @php
                                $activeProduct = collect($project->products ?? [])->firstWhere('active', true);
                                $activeProductId = $activeProduct['id'] ?? null;
                            @endphp

                            <a href="#" id="btn-edit-worktop"
                                class="{{ $editBtn }} {{ $activeProductId ? '' : 'pointer-events-none opacity-50' }}"
                                data-product-id="{{ $activeProductId }}"
                                data-current-label="{{ data_get($project, 'worktop.label', '—') }}"
                                data-current-color="{{ data_get($project, 'worktop.color', '') }}"
                                data-current-image="{{ data_get($project, 'worktop.image_url', '') }}">
                                Edit
                            </a>

                        </div>


                        <div class="flex flex-wrap items-center gap-2 px-4 py-3 text-sm">
                            <span id="worktop-label" class="{{ $chip }}">{{ data_get($project, 'worktop.label', '—') }}</span>

                            @if (data_get($project, 'worktop.color'))
                                <span class="{{ $chip }}">Color: <span class="ml-1 font-medium">{{ data_get($project, 'worktop.color') }}</span></span>
                                <span id="worktop-color" class="inline-flex w-8 h-5 rounded-md ring-1 ring-gray-300" style="background: {{ e(data_get($project, 'worktop.color')) }}"></span>
                            @else
                                <span id="worktop-color" class="inline-flex hidden w-8 h-5 rounded-md ring-1 ring-gray-300"></span>
                            @endif

                            @if (data_get($project, 'worktop.image_url'))
                                <span id="worktop-image" class="inline-block w-10 h-5 bg-center bg-cover rounded-md ring-1 ring-gray-300" style="background-image: url('{{ data_get($project, 'worktop.image_url') }}')"></span>
                            @else
                                <span id="worktop-image" class="hidden inline-block w-10 h-5 bg-center bg-cover rounded-md ring-1 ring-gray-300"></span>
                            @endif
                        </div>


                    </div>

                    {{-- Sink & Tap --}}
                    <div class="mt-3 border border-gray-200 rounded-xl">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">Sink & Tap</span>
                            {{-- <a href="#" class="{{ $editBtn }}">Edit</a> --}}

                            @php
                                $activeProduct = collect($project->products ?? [])->firstWhere('active', true);
                                $activeProductId = $activeProduct['id'] ?? null;
                            @endphp

                            <a href="#" id="btn-edit-sinktap"
                                class="{{ $editBtn }} {{ $activeProductId ? '' : 'pointer-events-none opacity-50' }}"
                                data-product-id="{{ $activeProductId }}"
                                data-current-sink="{{ data_get($project, 'sink_tap.bowl', '—') }}"
                                data-current-tap="{{ data_get($project, 'sink_tap.handle', '—') }}"
                                data-current-color="{{ data_get($project, 'sink_tap.color', '') }}"
                                data-current-image="{{ data_get($project, 'sink_tap.image_url', '') }}">
                                Edit
                            </a>


                        </div>

                        {{-- On-page chips (make sure these exist in your Sink & Tap section) --}}
                        <div class="flex flex-wrap items-center gap-2 px-4 py-3 text-sm">
                            <span id="sink-bowl-label" class="{{ $chip }}">{{ data_get($project, 'sink_tap.bowl', '—') }}</span>

                            @if (data_get($project, 'sink_tap.color'))
                                <span id="sink-color" class="inline-flex w-8 h-5 rounded-md ring-1 ring-gray-300" style="background: {{ e(data_get($project, 'sink_tap.color')) }}"></span>
                                <span class="{{ $chip }}">Color: <span id="sinktap-color-hex" class="ml-1 font-medium">{{ data_get($project, 'sink_tap.color') }}</span></span>
                            @else
                                <span id="sink-color" class="inline-flex hidden w-8 h-5 rounded-md ring-1 ring-gray-300"></span>
                            @endif

                            <span id="sink-handle-label" class="{{ $chip }}">{{ data_get($project, 'sink_tap.handle', '—') }}</span>

                            @if (data_get($project, 'sink_tap.image_url'))
                                <span id="sink-image" class="inline-block w-10 h-5 bg-center bg-cover rounded-md ring-1 ring-gray-300" style="background-image: url('{{ data_get($project, 'sink_tap.image_url') }}')"></span>
                            @else
                                <span id="sink-image" class="hidden inline-block w-10 h-5 bg-center bg-cover rounded-md ring-1 ring-gray-300"></span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Appliances --}}
                <details class="border-t border-gray-100 group" open>
                    <summary class="flex items-center justify-between gap-2 px-5 py-4 list-none cursor-pointer">
                        <span class="text-sm font-semibold text-[#5A0562]">Appliances</span>
                        <svg class="w-5 h-5 text-gray-500 transition group-open:rotate-180" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>

                    <div class="px-5 pb-5">
                        {{-- Appliances grid (existing) --}}
                        <div id="appliances-grid" class="grid gap-3 mt-3 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach ($project->appliances as $a)
                                <div
                                    class="rounded-xl border border-gray-200 p-4 shadow-[inset_0_0_0_1px_rgba(0,0,0,0.02)]">
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg">
                                            <svg class="w-5 h-5 text-gray-600" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor">
                                                <rect x="4" y="6" width="16" height="12" rx="2"
                                                    stroke-width="1.5" />
                                                <path d="M4 10h16" stroke-width="1.5" />
                                            </svg>
                                        </div>
                                        <h4 class="text-sm font-semibold text-gray-900">{{ $a['name'] }}</h4>
                                    </div>
                                    <dl class="grid grid-cols-2 gap-2 mt-3 text-xs">
                                        <div>
                                            <dt class="text-gray-500">Size</dt>
                                            <dt class="text-gray-500">Type</dt>

                                        </div>
                                        <div>
                                            <dd class="font-medium text-gray-800">{{ $a['size'] ?? '—' }}</dd>

                                            <dd class="font-medium text-gray-800">{{ $a['type'] ?? '—' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center gap-2 mt-4">

                            @php
                                $activeProduct = collect($project->products ?? [])->firstWhere('active', true);
                                $activeProductId = $activeProduct['id'] ?? null;
                                $activeProductName = $activeProduct['name'] ?? 'Product #' . ($activeProductId ?? '');
                            @endphp

                            <div class="flex items-center gap-2 mt-4">
                                {{-- EDIT MODAL TRIGGER --}}
                                {{-- <a href="#"
     id="btn-edit-accessories"
     class="{{ $editBtn }} {{ $activeProductId ? '' : 'pointer-events-none opacity-50' }}"
     data-product-id="{{ $activeProductId }}"
     data-product-name="{{ $activeProductName }}">
    Edit accessories
  </a> --}}

                                <button id="btn-edit-accessories" type="button"
                                    class="{{ $editBtn ?? 'px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50' }} {{ $activeProductId ?? ($product->id ?? null) ? '' : 'pointer-events-none opacity-50' }}"
                                    data-product-id="{{ $activeProductId ?? ($product->id ?? '') }}"
                                    data-product-name="{{ $activeProductName ?? ($product->name ?? 'Project') }}">
                                    Edit accessories
                                </button>


                                {{-- TRIGGER (uses active product vars) --}}
                                {{-- <a href="#"
   id="btn-edit-accessories_old"
   class="{{ $editBtn }} {{ $activeProductId ? '' : 'pointer-events-none opacity-50' }}"
   data-product-id="{{ $activeProductId }}"
   data-product-name="{{ $activeProductName }}">
  Edit accessories
</a> --}}


                                {{-- ADD MODAL TRIGGER --}}
                                <button type="button" id="btn-add-accessories"
                                    class="inline-flex items-center gap-2 rounded-lg bg-[#5A0562] px-3 py-1.5 text-xs font-medium text-white hover:bg-[#4a044c]
                 {{ $activeProductId ? '' : 'pointer-events-none opacity-50' }}"
                                    data-product-id="{{ $activeProductId }}"
                                    data-product-name="{{ $activeProductName }}">
                                    + Add accessories
                                </button>
                            </div>




                        </div>
                    </div>
                </details>

                {{-- Media --}}
                <details class="border-t border-gray-100 group" open>
                    <summary class="flex items-center justify-between gap-2 px-5 py-4 list-none cursor-pointer">
                        <span class="text-sm font-semibold text-[#5A0562]">Media</span>
                        <svg class="w-5 h-5 text-gray-500 transition group-open:rotate-180" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>


                    @php
                        $rows = [
                            ['Measurement', $project->media['measurement'] ?? []],
                            ['Designs', $project->media['designs'] ?? []],
                        ];
                    @endphp




                    @php
                        $mediaRows = [
                            ['Attachments after measurement', $project->media['measurement'] ?? []],
                            ['Designs', $project->media['designs'] ?? []],
                        ];
                    @endphp

                    <div class="px-5 pb-5">
                        <div class="border border-gray-200 divide-y divide-gray-100 rounded-xl">
                            @foreach ($mediaRows as [$label, $items])
                                <div class="px-4 py-3">
                                    <div class="mb-2 text-sm font-medium text-gray-900">{{ $label }}</div>

                                    @if (empty($items))
                                        <div class="text-xs text-gray-500">No files to display</div>
                                    @else
                                        <ul class="space-y-3">
                                            @foreach ($items as $it)
                                                <li class="flex items-center justify-between">
                                                    <div class="flex items-center min-w-0 gap-3">
                                                        @if (!empty($it['thumb_url']))
                                                            <img src="{{ $it['thumb_url'] }}" alt=""
                                                                class="object-cover w-12 h-12 rounded-md">
                                                        @else
                                                            <div
                                                                class="w-12 h-12 bg-gray-100 rounded-md ring-1 ring-gray-300">
                                                            </div>
                                                        @endif
                                                        <div class="min-w-0">
                                                            <div class="text-sm text-gray-800 truncate">
                                                                {{ $it['name'] ?? '—' }}</div>
                                                            <div class="text-xs text-gray-500">
                                                                @if (!empty($it['uploaded_at_label']))
                                                                    Uploaded on {{ $it['uploaded_at_label'] }}
                                                                @endif
                                                                @if (!empty($it['size_label']))
                                                                    <span
                                                                        class="mx-1">•</span>{{ $it['size_label'] }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-3 shrink-0">
                                                        @if (!empty($it['url']))
                                                            <a href="{{ $it['url'] }}" target="_blank"
                                                                class="text-gray-700 hover:text-gray-900"
                                                                title="View">
                                                                <iconify-icon icon="mdi:eye-outline"
                                                                    class="text-xl"></iconify-icon>
                                                            </a>
                                                        @endif
                                                        @if (!empty($it['download_url']))
                                                            <a href="{{ $it['download_url'] }}" download
                                                                class="text-[#5A0562] hover:text-[#43044a]"
                                                                title="Download">
                                                                <iconify-icon icon="mdi:download-outline"
                                                                    class="text-xl"></iconify-icon>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>





                </details>

            </div>
        </div>

    </div>

    {{-- -pop for the edits- --}}

    <!-- product type pop up--->
    {{-- Product Type Modal --}}
    <div id="product-type-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/40"></div>

        <div
            class="absolute left-1/2 top-1/2 w-[420px] max-w-[94vw] -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white shadow-xl">
            <div class="flex items-center justify-between px-5 py-3 border-b">
                <div class="text-base font-semibold">Edit Product Type</div>
                <button id="pt-close" class="p-2 rounded-lg hover:bg-gray-100">&times;</button>
            </div>

            <form id="pt-form" class="p-5 space-y-4">
                @csrf
                <input type="hidden" id="pt-product-id">

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Product Type</label>
                    <select id="pt-select"
                        class="w-full border-gray-300 rounded-lg focus:ring-fuchsia-600 focus:border-fuchsia-600"
                        required>
                        {{-- Use whatever set you prefer; tweak freely --}}
                        @php
                            $typeOptions = ['Kitchen', 'Wardrobe', 'Bathroom', 'TV Unit', 'Office', 'Others'];
                        @endphp
                        @foreach ($typeOptions as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>
                    <p id="pt-error" class="hidden mt-2 text-sm text-red-600"></p>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    {{-- <button type="button" id="pt-cancel" class="px-3 py-1.5 rounded-lg border text-sm">Cancel</button> --}}
                    <button type="submit"
                        class="px-3 py-1.5 rounded-lg bg-fuchsia-900 text-white text-sm w-full">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Finish (matches your screenshot) --}}
    <div id="finish-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/40"></div>

        <div
            class="absolute left-1/2 top-1/2 w-[600px] max-w-[94vw] -translate-x-1/2 -translate-y-1/2 rounded-[20px] bg-white shadow-xl">
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Edit Finish</h3>
                <button id="finish-close" class="p-2 rounded-full hover:bg-gray-100">&times;</button>
            </div>

            <form id="finish-form" class="px-6 py-5 space-y-6" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="finish-product-id">

                {{-- Type of Finish --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-800">Type of Finish</label>
                    <div class="relative">
                        <select id="finish-type"
                            class="w-full h-12 pl-4 pr-10 text-gray-900 bg-white border border-gray-300 rounded-2xl focus:border-fuchsia-600 focus:outline-none focus:ring-2 focus:ring-fuchsia-600/30"
                            required>
                            @php
                                $finishOptions = [
                                    'High Gloss',
                                    'Matte',
                                    'Satin',
                                    'Textured',
                                    'Laminate',
                                    'Painted',
                                    'Veneer',
                                    'Others',
                                ];
                            @endphp
                            @foreach ($finishOptions as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                        <span class="absolute text-gray-400 -translate-y-1/2 pointer-events-none right-3 top-1/2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="m6 9 6 6 6-6" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Color + Sample Image (two columns) --}}
                <div class="grid gap-6 md:grid-cols-2">
                    {{-- Color of Finish --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-800">Color of Finish</label>
                        <div class="flex items-center">
                            {{-- visible color chip --}}
                            <span id="finish-color-chip"
                                class="inline-block w-6 h-6 mr-3 rounded-md ring-1 ring-gray-300"></span>
                            {{-- hex input with dropdown chevron look --}}
                            <div class="relative flex-1">
                                <input type="text" id="finish-color-hex"
                                    class="w-full h-12 pl-4 pr-10 text-gray-900 bg-white border border-gray-300 rounded-2xl placeholder:text-gray-400 focus:border-fuchsia-600 focus:outline-none focus:ring-2 focus:ring-fuchsia-600/30"
                                    placeholder="#9E00FF">
                                <span
                                    class="absolute text-gray-400 -translate-y-1/2 pointer-events-none right-3 top-1/2">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="m6 9 6 6 6-6" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            {{-- hidden native color input (kept for accessibility / syncing) --}}
                            <input type="color" id="finish-color-input" class="sr-only">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Paste a hex like <code>#112233</code> or click the chip
                            to pick.</p>
                    </div>

                    {{-- Sample Finish Image --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-800">Sample Finish Image</label>

                        {{-- Hidden file input; use the styled button to trigger it --}}
                        <input type="file" id="finish-image-input" accept="image/png,image/jpeg,image/webp"
                            class="hidden">

                        <div class="flex items-center gap-3">
                            <button id="finish-upload-btn" type="button"
                                class="h-12 px-5 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-2xl hover:bg-gray-200">
                                Upload
                            </button>

                            {{-- Square preview with tiny trash overlay --}}
                            <div class="relative">
                                <div id="finish-image-preview"
                                    class="w-12 h-12 bg-center bg-cover rounded-lg ring-1 ring-gray-300"></div>
                                <button type="button" id="finish-image-clear"
                                    class="absolute hidden p-1 text-gray-700 bg-white rounded-full shadow -right-2 -top-2 hover:text-red-600"
                                    title="Remove">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M3 6h18M8 6v12m8-12v12M5 6l1 14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-14"
                                            stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M10 6V4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <p id="finish-error" class="hidden -mt-2 text-sm text-red-600"></p>

                {{-- Primary --}}
                <div class="pb-1">
                    <button type="submit"
                        class="h-12 w-full rounded-2xl bg-[#4B0066] text-white text-base font-semibold hover:bg-[#3d0053]">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- glass door- --}}

    {{-- Edit Glass Door Type Modal --}}
    <div id="glass-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/40"></div>

        <div
            class="absolute left-1/2 top-1/2 w-[480px] max-w-[94vw] -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white shadow-xl">
            <div class="flex items-center justify-between px-5 py-4 border-b">
                <div class="text-base font-semibold">Edit Glass Door Type</div>
                <button id="glass-close" class="p-2 rounded-lg hover:bg-gray-100">&times;</button>
            </div>

            <form id="glass-form" class="p-5 space-y-4">
                @csrf
                <input type="hidden" id="glass-product-id">

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-800">Type of Glass Door</label>
                    <div class="relative">
                        <select id="glass-select"
                            class="w-full h-12 pl-4 pr-10 text-gray-900 bg-white border border-gray-300 rounded-2xl focus:border-fuchsia-600 focus:outline-none focus:ring-2 focus:ring-fuchsia-600/30"
                            required>
                            @php
                                // tweak this list to your real options
                                $glassOptions = [
                                    'Clear',
                                    'Frosted',
                                    'Tinted',
                                    'Smoked',
                                    'Textured',
                                    'Reeded',
                                    'Laminated',
                                    'Others',
                                ];
                            @endphp
                            @foreach ($glassOptions as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                        <span class="absolute text-gray-400 -translate-y-1/2 pointer-events-none right-3 top-1/2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="m6 9 6 6 6-6" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                    <p id="glass-error" class="hidden mt-2 text-sm text-red-600"></p>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="h-12 w-full rounded-2xl bg-[#4B0066] text-white text-base font-semibold hover:bg-[#3d0053]">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- -worktop edit modal --}}

    {{-- Edit Worktop Modal --}}
    <div id="worktop-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/40"></div>

        <div
            class="absolute left-1/2 top-1/2 w-[600px] max-w-[94vw] -translate-x-1/2 -translate-y-1/2 rounded-[20px] bg-white shadow-xl">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Edit Worktop</h3>
                <button id="worktop-close" class="p-2 rounded-full hover:bg-gray-100">&times;</button>
            </div>

            <form id="worktop-form" class="px-6 py-5 space-y-6" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="worktop-product-id">

                {{-- Type of Worktop --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-800">Type of Worktop</label>
                    <div class="relative">
                        <select id="worktop-type"
                            class="w-full h-12 pl-4 pr-10 text-gray-900 bg-white border border-gray-300 rounded-2xl focus:border-fuchsia-600 focus:outline-none focus:ring-2 focus:ring-fuchsia-600/30"
                            required>
                            @php
                                $worktopOptions = [
                                    'Granite',
                                    'Quartz',
                                    'Marble',
                                    'Solid Surface',
                                    'Laminate',
                                    'Wood',
                                    'Porcelain',
                                    'Others',
                                ];
                            @endphp
                            @foreach ($worktopOptions as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                        <span class="absolute text-gray-400 -translate-y-1/2 pointer-events-none right-3 top-1/2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="m6 9 6 6 6-6" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Color + Sample Image (two columns) --}}
                <div class="grid gap-6 md:grid-cols-2">
                    {{-- Color --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-800">Color</label>
                        <div class="flex items-center">
                            <span id="worktop-color-chip"
                                class="inline-block w-6 h-6 mr-3 rounded-md ring-1 ring-gray-300"></span>
                            <div class="relative flex-1">
                                <input type="text" id="worktop-color-hex"
                                    class="w-full h-12 pl-4 pr-10 text-gray-900 bg-white border border-gray-300 rounded-2xl placeholder:text-gray-400 focus:border-fuchsia-600 focus:outline-none focus:ring-2 focus:ring-fuchsia-600/30"
                                    placeholder="#9E00FF">
                                <span
                                    class="absolute text-gray-400 -translate-y-1/2 pointer-events-none right-3 top-1/2">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="m6 9 6 6 6-6" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <input type="color" id="worktop-color-input" class="sr-only">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Paste a hex like <code>#112233</code> or click the chip
                            to pick.</p>
                    </div>

                    {{-- Sample Worktop Image --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-800">Sample Worktop Image</label>

                        <input type="file" id="worktop-image-input" accept="image/png,image/jpeg,image/webp"
                            class="hidden">

                        <div class="flex items-center gap-3">
                            <button id="worktop-upload-btn" type="button"
                                class="h-12 px-5 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-2xl hover:bg-gray-200">
                                Upload
                            </button>

                            <div class="relative">
                                <div id="worktop-image-preview"
                                    class="w-12 h-12 bg-center bg-cover rounded-lg ring-1 ring-gray-300"></div>
                                <button type="button" id="worktop-image-clear"
                                    class="absolute hidden p-1 text-gray-700 bg-white rounded-full shadow -right-2 -top-2 hover:text-red-600"
                                    title="Remove">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M3 6h18M8 6v12m8-12v12M5 6l1 14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-14"
                                            stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M10 6V4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <p id="worktop-error" class="hidden -mt-2 text-sm text-red-600"></p>

                <div class="pb-1">
                    <button type="submit"
                        class="h-12 w-full rounded-2xl bg-[#4B0066] text-white text-base font-semibold hover:bg-[#3d0053]">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- -pop for sin & tap --}}
    {{-- Edit Sink & Tap Modal (with color + image) --}}
    <div id="sinktap-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/40"></div>

        <div
            class="absolute left-1/2 top-1/2 w-[600px] max-w-[94vw] -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white shadow-xl">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <div class="text-base font-semibold">Edit Sink & Tap</div>
                <button id="sinktap-close" class="p-2 rounded-lg hover:bg-gray-100">&times;</button>
            </div>

            <form id="sinktap-form" class="px-6 py-5 space-y-6" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="sinktap-product-id">

                {{-- Two selects --}}
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-800">Sink (Bowl) Type</label>
                        <div class="relative">
                            <select id="sinktap-sink"
                                class="w-full h-12 pl-4 pr-10 text-gray-900 bg-white border border-gray-300 rounded-2xl focus:border-fuchsia-600 focus:outline-none focus:ring-2 focus:ring-fuchsia-600/30"
                                required>
                                @php
                                    $sinkOptions = [
                                        'Single Bowl',
                                        'Double Bowl',
                                        'Farmhouse',
                                        'Undermount',
                                        'Topmount',
                                        'Integrated',
                                        'Others',
                                    ];
                                @endphp
                                @foreach ($sinkOptions as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                            <span class="absolute text-gray-400 -translate-y-1/2 pointer-events-none right-3 top-1/2">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="m6 9 6 6 6-6" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-800">Tap / Handle</label>
                        <div class="relative">
                            <select id="sinktap-tap"
                                class="w-full h-12 pl-4 pr-10 text-gray-900 bg-white border border-gray-300 rounded-2xl focus:border-fuchsia-600 focus:outline-none focus:ring-2 focus:ring-fuchsia-600/30"
                                required>
                                @php
                                    $tapOptions = [
                                        'Single Lever',
                                        'Dual Handle',
                                        'Pull-Out',
                                        'Pull-Down',
                                        'Bridge',
                                        'Wall-Mounted',
                                        'Knob',
                                        'Bar Handle',
                                        'Others',
                                    ];
                                @endphp
                                @foreach ($tapOptions as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                            <span class="absolute text-gray-400 -translate-y-1/2 pointer-events-none right-3 top-1/2">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="m6 9 6 6 6-6" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Color + Image --}}
                <div class="grid gap-6 md:grid-cols-2">
                    {{-- Color --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-800">Color</label>
                        <div class="flex items-center">
                            <span id="sinktap-color-chip"
                                class="inline-block w-6 h-6 mr-3 rounded-md ring-1 ring-gray-300"></span>
                            <div class="relative flex-1">
                                <input type="text" id="sinktap-color-hex"
                                    class="w-full h-12 pl-4 pr-10 text-gray-900 bg-white border border-gray-300 rounded-2xl placeholder:text-gray-400 focus:border-fuchsia-600 focus:outline-none focus:ring-2 focus:ring-fuchsia-600/30"
                                    placeholder="#9E00FF">
                                <span
                                    class="absolute text-gray-400 -translate-y-1/2 pointer-events-none right-3 top-1/2">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="m6 9 6 6 6-6" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <input type="color" id="sinktap-color-input" class="sr-only">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Paste a hex like <code>#112233</code> or click the chip
                            to pick.</p>
                    </div>

                    {{-- Sample image --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-800">Sample Sink Image</label>

                        <input type="file" id="sinktap-image-input" accept="image/png,image/jpeg,image/webp"
                            class="hidden">

                        <div class="flex items-center gap-3">
                            <button id="sinktap-upload-btn" type="button"
                                class="h-12 px-5 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-2xl hover:bg-gray-200">
                                Upload
                            </button>

                            <div class="relative">
                                <div id="sinktap-image-preview"
                                    class="w-12 h-12 bg-center bg-cover rounded-lg ring-1 ring-gray-300"></div>
                                <button type="button" id="sinktap-image-clear"
                                    class="absolute hidden p-1 text-gray-700 bg-white rounded-full shadow -right-2 -top-2 hover:text-red-600"
                                    title="Remove">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M3 6h18M8 6v12m8-12v12M5 6l1 14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-14"
                                            stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M10 6V4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <p id="sinktap-error" class="hidden mt-1 text-sm text-red-600"></p>

                <div class="pt-1 pb-1">
                    <button type="submit"
                        class="h-12 w-full rounded-2xl bg-[#4B0066] text-white text-base font-semibold hover:bg-[#3d0053]">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- EDIT ACCESSORIES MODAL --}}
    <div id="acc-edit-modal" class="fixed inset-0 z-[70] hidden">
        <div class="absolute inset-0 bg-black/40"></div>

        <div
            class="absolute left-1/2 top-1/2 w-[860px] max-w-[95vw] -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white shadow-xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-xl font-semibold text-gray-900">
                    Edit Appliances <span id="acc-edit-product-name" class="ml-2 text-base text-gray-500"></span>
                </h3>
                <button id="acc-edit-close" class="p-2 rounded-full hover:bg-gray-100">&times;</button>
            </div>

            <div id="acc-edit-root" x-data="accEditEditor({
                listUrlTpl: `{{ route('admin.products.accessories.list', ['product' => '__ID__']) }}`,
                bulkUrlTpl: `{{ route('admin.products.accessories.bulk', ['product' => '__ID__']) }}`,
                csrf: `{{ csrf_token() }}`
            })"
                class="relative max-h-[75vh] overflow-y-auto px-6 py-4 space-y-4">

                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Adjust sizes, types, quantities or notes. Toggle “Remove” to detach.
                    </p>
                    <div class="flex gap-2">
                        <button type="button" class="px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50"
                            @click="addRow()">+ Add row</button>
                    </div>
                </div>

                <div class="overflow-x-auto border rounded-xl">
                    <table class="min-w-full text-sm">
                        <thead class="text-gray-600 bg-gray-50">
                            <tr>
                                <th class="w-56 px-3 py-2 text-left">Accessory</th>
                                <th class="px-3 py-2 text-left">Type</th>
                                <th class="w-40 px-3 py-2 text-left">Size</th>
                                <th class="w-24 px-3 py-2 text-left">Qty</th>
                                <th class="px-3 py-2 text-left">Notes</th>
                                <th class="w-24 px-3 py-2 text-left">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-if="!rows.length">
                                <tr>
                                    <td colspan="6" class="px-3 py-6 text-center text-gray-500">No accessories yet.
                                    </td>
                                </tr>
                            </template>

                            <template x-for="(row, i) in rows" :key="row._key">
                                <tr class="border-t">
                                    <!-- Accessory (select so you can change it) -->
                                    <td class="px-3 py-2">
                                        <select class="w-full px-2 py-1.5 border rounded-lg"
                                            x-model.number="row.accessory_id" @change="onAccessoryChange(i)">
                                            <template x-if="!catalog.length">
                                                <option value="">Loading…</option>
                                            </template>
                                            <template x-if="catalog.length">
                                                <option value="">Select accessory</option>
                                            </template>
                                            <template x-for="opt in catalog" :key="opt.id">
                                                <option :value="opt.id" x-text="opt.name"></option>
                                            </template>
                                        </select>
                                    </td>

                                    <!-- Type -->
                                    <td class="px-3 py-2">
                                        <div class="flex flex-wrap gap-2">
                                            <template
                                                x-if="!(typesMap[row.accessory_id] && typesMap[row.accessory_id].length)">
                                                <span class="text-gray-500">—</span>
                                            </template>
                                            <template x-for="t in (typesMap[row.accessory_id] || [])"
                                                :key="t">
                                                <label class="inline-flex items-center gap-1">
                                                    <input type="radio" :name="`type_${row._key}`"
                                                        :value="t" class="w-4 h-4 text-fuchsia-700"
                                                        :checked="row.type === t" @change="row.type = t">
                                                    <span x-text="t"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </td>

                                    <!-- Size (select if sizes[] provided; ensure saved value appears even if custom) -->
                                    <td class="px-3 py-2">
                                        <template x-if="sizes.length">
                                            <select class="w-full px-2 py-1.5 border rounded-lg" x-model="row.size">
                                                <option value="">Select size</option>
                                                <template
                                                    x-for="s in (sizes.includes(row.size) ? sizes : [row.size, ...sizes].filter(Boolean))"
                                                    :key="s">
                                                    <option :value="s" x-text="s"></option>
                                                </template>
                                            </select>
                                        </template>
                                        <template x-if="!sizes.length">
                                            <input class="w-full px-2 py-1.5 border rounded-lg" type="text"
                                                placeholder="e.g. 45cm x 40cm" x-model="row.size">
                                        </template>
                                    </td>

                                    <!-- Qty -->
                                    <td class="px-3 py-2">
                                        <input class="w-20 px-2 py-1.5 border rounded-lg" type="number"
                                            min="0" x-model.number="row.quantity">
                                    </td>

                                    <!-- Notes -->
                                    <td class="px-3 py-2">
                                        <input class="w-full px-2 py-1.5 border rounded-lg" type="text"
                                            x-model="row.notes" placeholder="Optional">
                                    </td>

                                    <!-- Remove -->
                                    <td class="px-3 py-2">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="checkbox" class="w-4 h-4" x-model="row._deleted">
                                            <span class="text-xs text-gray-600">Detach</span>
                                        </label>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="sticky bottom-0 left-0 right-0 px-6 py-4 -mx-6 -mb-4 border-t bg-white/90 backdrop-blur">
                    <div class="flex items-center justify-between gap-3">
                        <p id="acc-edit-error" class="hidden text-sm text-red-600"></p>
                        <div class="flex gap-2">
                            <button type="button" id="acc-edit-cancel"
                                class="px-4 py-2 border rounded-lg">Cancel</button>
                            <button type="button" class="px-6 py-2 rounded-lg bg-[#4B0066] text-white"
                                @click="save()">Save changes</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



@include('production.partials.add-product', ['project' => $project])


    <script>
        function accEditEditor({
            listUrlTpl,
            bulkUrlTpl,
            csrf
        }) {
            return {
                productId: null,
                catalog: [],
                sizes: [],
                typesMap: {},
                rows: [], // [{_key, accessory_id, type, size, quantity, notes, _deleted?}]

                async open(pid, pname) {
                    if (!pid) {
                        this._err('No product selected.');
                        return;
                    }
                    this.productId = pid;
                    document.getElementById('acc-edit-product-name').textContent = pname ? `— ${pname}` : '';

                    const url = listUrlTpl.replace('__ID__', encodeURIComponent(pid));
                    let data;
                    try {
                        const res = await fetch(url, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        });
                        if (!res.ok) throw new Error(await res.text());
                        data = await res.json();
                    } catch (e) {
                        console.error('[accEdit] list error:', e);
                        this._err('Could not load accessories. Please refresh.');
                        return;
                    }

                    // Normalize
                    const cat = Array.isArray(data.catalog) ? data.catalog : [];
                    const siz = Array.isArray(data.sizes) ? data.sizes : [];
                    const typ = (data.types && typeof data.types === 'object') ? data.types : {};
                    const items = Array.isArray(data.items) ? data.items : [];

                    this.catalog = cat.map(x => ({
                        id: Number(x.id),
                        name: String(x.name ?? '')
                    }));
                    this.sizes = siz.map(String);
                    this.typesMap = {
                        ...typ
                    };

                    // Ensure preselect works (IDs as numbers) and include placeholder if current accessory is missing from catalog
                    const catalogIds = new Set(this.catalog.map(c => c.id));

                    this.rows = items.map(it => {
                        const aid = Number(it.accessory_id);
                        const size = it.size ? String(it.size) : '';
                        const type = it.type ? String(it.type) : '';

                        if (!catalogIds.has(aid)) {
                            this.catalog.push({
                                id: aid,
                                name: `(Unknown #${aid})`
                            });
                            catalogIds.add(aid);
                        }

                        const allowed = this.typesMap[aid] || [];
                        const safeType = allowed.length && !allowed.includes(type) ? '' : type;

                        return {
                            _key: 'e-' + aid + '-' + Math.random().toString(36).slice(2),
                            accessory_id: aid,
                            type: safeType,
                            size: size,
                            quantity: (it.quantity ?? null),
                            notes: it.notes || '',
                            _deleted: false
                        };
                    });
                },

                addRow() {
                    this.rows.push({
                        _key: 'e-' + Date.now() + Math.random(),
                        accessory_id: '',
                        type: '',
                        size: '',
                        quantity: 1,
                        notes: '',
                        _deleted: false
                    });
                },

                onAccessoryChange(i) {
                    const row = this.rows[i];
                    const allowed = this.typesMap[row.accessory_id] || [];
                    if (!allowed.includes(row.type)) row.type = '';
                },

                async save() {
                    // Validate
                    for (const r of this.rows) {
                        if (r._deleted) continue;
                        if (!r.accessory_id) return this._err('Select an accessory for each active row.');
                        if (!r.size || !String(r.size).trim()) return this._err('Provide a size for each active row.');
                        const allowed = this.typesMap[r.accessory_id] || [];
                        if (allowed.length && !r.type) return this._err('Choose a type where required.');
                    }

                    const url = bulkUrlTpl.replace('__ID__', encodeURIComponent(this.productId));
                    const payload = {
                        items: this.rows.map(r => ({
                            accessory_id: r.accessory_id ? Number(r.accessory_id) : null,
                            size: r.size || null,
                            type: r.type || null,
                            quantity: r.quantity ?? null,
                            notes: r.notes || null,
                            _deleted: !!r._deleted
                        }))
                    };

                    let data;
                    try {
                        const res = await fetch(url, {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify(payload)
                        });
                        if (!res.ok) throw new Error(await res.text());
                        data = await res.json();
                    } catch (e) {
                        console.error('[accEdit] save error:', e);
                        return this._err('Could not save changes. Check inputs.');
                    }

                    // Rebuild front grid (same markup as your Add modal)
                    const gridEl = document.getElementById('appliances-grid');
                    if (gridEl) {
                        const items = data.items || [];
                        gridEl.innerHTML = items.length ? items.map(a => `
          <div class="rounded-xl border border-gray-200 p-4 shadow-[inset_0_0_0_1px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-2">
              <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <rect x="4" y="6" width="16" height="12" rx="2" stroke-width="1.5" />
                  <path d="M4 10h16" stroke-width="1.5" />
                </svg>
              </div>
              <h4 class="text-sm font-semibold text-gray-900">${this._esc(a.name || 'Accessory')}</h4>
            </div>
            <dl class="grid grid-cols-2 gap-2 mt-3 text-xs">
              <div><dt class="text-gray-500">Size</dt><dd class="font-medium text-gray-800">${this._esc(a.size ?? '—')}</dd></div>
              <div><dt class="text-gray-500">Type</dt><dd class="font-medium text-gray-800">${this._esc(a.type ?? '—')}</dd></div>
            </dl>
          </div>
        `).join('') : `<div class="p-6 text-center text-gray-500 border border-dashed rounded-xl">No accessories attached.</div>`;
                    }

                    document.getElementById('acc-edit-modal')?.classList.add('hidden');
                },

                _err(msg) {
                    const el = document.getElementById('acc-edit-error');
                    if (el) {
                        el.textContent = msg;
                        el.classList.remove('hidden');
                    }
                },
                _esc(s) {
                    return (s ?? '').toString().replace(/[&<>"]/g, c => ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;'
                    } [c] || c));
                }
            };
        }

        // wire open/close for EDIT modal
        (function() {
            const btn = document.getElementById('btn-edit-accessories');
            const modal = document.getElementById('acc-edit-modal');
            const closeX = document.getElementById('acc-edit-close');

            async function openModal(pid, pname) {
                const root = document.getElementById('acc-edit-root');
                const comp = root?._x_dataStack?.[0] || root?.__x?.$data;
                if (comp?.open) await comp.open(pid, pname);
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            btn?.addEventListener('click', (e) => {
                e.preventDefault();
                const pid = btn.dataset.productId;
                if (pid) openModal(pid, btn.dataset.productName || '');
            });
            closeX?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
        })();
    </script>

    {{-- ADD ACCESSORIES MODAL --}}
    <div id="acc-add-modal" class="fixed inset-0 z-[70] hidden">
        <div class="absolute inset-0 bg-black/40"></div>

        <div
            class="absolute left-1/2 top-1/2 w-[720px] max-w-[94vw] -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white shadow-xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Add Appliances
                    <span id="acc-add-product-name" class="ml-2 text-base text-gray-500"></span>
                </h3>
                <button id="acc-add-close" class="p-2 rounded-full hover:bg-gray-100">&times;</button>
            </div>

            <div id="acc-add-root" x-data="accAddEditor({
                listUrlTpl: `{{ route('admin.products.accessories.list', ['product' => '__ID__']) }}`,
                attachUrlTpl: `{{ route('admin.products.accessories.attach', ['product' => '__ID__']) }}`,
                createUrl: `{{ route('admin.accessories.store') }}`,
                csrf: `{{ csrf_token() }}`
            })"
                class="relative max-h-[70vh] overflow-y-auto px-6 py-4 space-y-6">

                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600"
                        x-text="rows.length ? `${rows.length} to add` : 'Add one or more appliances'"></div>
                    <div class="flex gap-2">
                        <button type="button" class="px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50"
                            @click="openNewAccessory()">+ New accessory</button>
                        <button type="button" class="px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50"
                            @click="addRow()">+ Add row</button>
                    </div>
                </div>

                <template x-if="rows.length === 0">
                    <div class="p-4 text-sm text-gray-500 border border-dashed rounded-xl">No rows yet. Click “Add
                        row”.</div>
                </template>

                <template x-for="(row, i) in rows" :key="row._key">
                    <div class="p-4 space-y-4 border rounded-2xl">
                        {{-- Accessory select --}}
                        <div>
                            <label class="block text-sm text-gray-600">Accessory</label>
                            <select class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-xl"
                                x-model.number="row.accessory_id" @change="onAccessoryChange(i)">
                                <template x-if="!catalog.length">
                                    <option value="">Loading accessories…</option>
                                </template>
                                <template x-if="catalog.length">
                                    <option value="">Select accessory</option>
                                </template>
                                <template x-for="opt in catalog" :key="opt.id">
                                    <option :value="opt.id" x-text="opt.name"></option>
                                </template>
                            </select>
                        </div>

                        {{-- Types radios (if any) --}}
                        <div>
                            <label class="block text-sm text-gray-600">Type</label>
                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                <template x-if="!(typesMap[row.accessory_id] && typesMap[row.accessory_id].length)">
                                    <span class="text-sm text-gray-500">No type required</span>
                                </template>
                                <template x-for="t in (typesMap[row.accessory_id] || [])" :key="t">
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <input type="radio" :name="`type_${row._key}`" :value="t"
                                            class="w-4 h-4 text-fuchsia-700" :checked="row.type === t"
                                            @change="row.type = t">
                                        <span class="text-sm text-gray-800" x-text="t"></span>
                                    </label>
                                </template>
                            </div>
                        </div>

                        {{-- Size: select if sizes[] present, otherwise free text --}}
                        <div>
                            <label class="block text-sm text-gray-600">Size</label>

                            <template x-if="sizes.length">
                                <select class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-xl"
                                    x-model="row.size">
                                    <option value="">Select size</option>
                                    <template x-for="s in sizes" :key="s">
                                        <option :value="s" x-text="s"></option>
                                    </template>
                                </select>
                            </template>

                            <template x-if="!sizes.length">
                                <div class="mt-1">
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-xl"
                                        x-model="row.size" list="size-suggestions" placeholder="e.g. 45cm x 40cm" />
                                    <datalist id="size-suggestions">
                                        <option value="45cm x 40cm"></option>
                                        <option value="50cm x 70cm"></option>
                                        <option value="54cm x 40cm"></option>
                                        <option value="60cm x 66cm"></option>
                                        <option value="70cm x 34cm"></option>
                                        <option value="80cm x 55cm"></option>
                                        <option value="90cm x 88cm"></option>
                                    </datalist>
                                    <p class="mt-1 text-xs text-gray-500">You can type any custom size.</p>
                                </div>
                            </template>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="block text-sm text-gray-600">Quantity</label>
                                <input type="number" min="0"
                                    class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-xl"
                                    x-model.number="row.quantity">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600">Notes</label>
                                <input type="text" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-xl"
                                    x-model="row.notes" placeholder="Optional">
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="button" class="text-sm text-red-600 hover:underline"
                                @click="remove(i)">Remove</button>
                        </div>
                    </div>
                </template>

                <div class="sticky bottom-0 left-0 right-0 px-6 py-4 -mx-6 -mb-4 border-t bg-white/90 backdrop-blur">
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" id="acc-add-cancel"
                            class="px-4 py-2 border rounded-lg">Cancel</button>
                        <button type="button" class="px-6 py-2 rounded-lg bg-[#4B0066] text-white"
                            @click="save()">Add</button>
                    </div>
                    <p id="acc-add-error" class="hidden mt-2 text-sm text-red-600"></p>
                </div>

                {{-- NEW ACCESSORY MINI MODAL --}}
                <div x-show="modal.open" x-cloak
                    class="fixed inset-0 z-[80] flex items-center justify-center bg-black/30">
                    <div class="w-full max-w-md p-5 bg-white shadow-xl rounded-2xl">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold">New Accessory</h4>
                            <button type="button" @click="closeNewAccessory()"
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
                                    x-model="modal.form.types_csv" placeholder="e.g. Under, Chimney" />
                                <p class="text-xs text-red-600" x-text="errors.types_csv"></p>
                            </div>

                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="closeNewAccessory()"
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

    <script>
        function accAddEditor({
            listUrlTpl,
            attachUrlTpl,
            createUrl,
            csrf
        }) {
            return {
                productId: null,
                catalog: [],
                sizes: [],
                typesMap: {},
                rows: [],
                modal: {
                    open: false,
                    form: {
                        name: '',
                        types_csv: ''
                    }
                },
                errors: {},
                flash: '',

                async open(pid, pname) {
                    this.productId = pid;
                    document.getElementById('acc-add-product-name').textContent = pname ? `— ${pname}` : '';

                    const url = listUrlTpl.replace('__ID__', encodeURIComponent(pid));
                    console.log('[accAdd] fetching list:', url);

                    let data;
                    try {
                        const res = await fetch(url, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        });
                        if (!res.ok) {
                            const text = await res.text();
                            console.error('[accAdd] list fetch failed:', res.status, text);
                            this._err('Could not load accessories. Please refresh.');
                            this.catalog = [];
                            this.sizes = [];
                            this.typesMap = {};
                            this.rows = [{
                                _key: 'r-' + Date.now(),
                                accessory_id: '',
                                type: '',
                                size: '',
                                quantity: 1,
                                notes: ''
                            }];
                            return;
                        }
                        data = await res.json();
                    } catch (e) {
                        console.error('[accAdd] list fetch error:', e);
                        this._err('Network error loading accessories.');
                        this.catalog = [];
                        this.sizes = [];
                        this.typesMap = {};
                        this.rows = [{
                            _key: 'r-' + Date.now(),
                            accessory_id: '',
                            type: '',
                            size: '',
                            quantity: 1,
                            notes: ''
                        }];
                        return;
                    }

                    console.log('[accAdd] list response:', data);

                    // Defensive coercions for Alpine reactivity
                    const cat = Array.isArray(data.catalog) ? data.catalog : [];
                    const siz = Array.isArray(data.sizes) ? data.sizes : [];
                    const typ = (data.types && typeof data.types === 'object') ? data.types : {};

                    this.catalog = cat.map(x => ({
                        id: Number(x.id),
                        name: String(x.name ?? '')
                    }));
                    this.sizes = siz.map(String);
                    this.typesMap = {
                        ...typ
                    };

                    this.rows = [{
                        _key: 'r-' + Date.now(),
                        accessory_id: '',
                        type: '',
                        size: '',
                        quantity: 1,
                        notes: ''
                    }];

                    // Tiny in-UI debug so you can confirm counts without DevTools
                    const debug = document.getElementById('acc-add-error');
                    if (debug) {
                        debug.classList.remove('hidden');
                        debug.textContent = `Loaded: ${this.catalog.length} accessories • ${this.sizes.length} sizes`;
                    }
                },

                addRow() {
                    this.rows.push({
                        _key: 'r-' + Date.now() + Math.random(),
                        accessory_id: '',
                        type: '',
                        size: '',
                        quantity: 1,
                        notes: ''
                    });
                },
                remove(i) {
                    this.rows.splice(i, 1);
                },

                onAccessoryChange(i) {
                    const row = this.rows[i];
                    const allowed = this.typesMap[row.accessory_id] || [];
                    if (!allowed.includes(row.type)) row.type = '';
                    // If sizes become accessory-specific later, also: row.size = '';
                },

                openNewAccessory() {
                    this.modal.open = true;
                    this.modal.form = {
                        name: '',
                        types_csv: ''
                    };
                    this.errors = {};
                    this.flash = '';
                },
                closeNewAccessory() {
                    this.modal.open = false;
                },

                async saveNewAccessory() {
                    this.errors = {};
                    this.flash = '';
                    const res = await fetch(createUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            name: this.modal.form.name,
                            types_csv: this.modal.form.types_csv
                        })
                    });
                    if (!res.ok) {
                        if (res.status === 422) {
                            const j = await res.json();
                            this.errors = j.errors || {};
                        } else {
                            this.errors = {
                                name: 'Failed to save accessory.'
                            };
                        }
                        return;
                    }
                    const data = await res.json(); // {id,name,types[]}
                    this.catalog = [...this.catalog, {
                        id: data.id,
                        name: data.name
                    }]; // new reference for reactivity
                    this.typesMap = {
                        ...this.typesMap,
                        [data.id]: (data.types || [])
                    }; // new reference
                    this.flash = 'Accessory created.';
                    const last = this.rows[this.rows.length - 1];
                    if (last) {
                        last.accessory_id = data.id;
                        const allowed = this.typesMap[data.id] || [];
                        last.type = allowed.length ? '' : null;
                    }
                    setTimeout(() => this.closeNewAccessory(), 600);
                },

                async save() {
                    // quick client checks
                    for (const r of this.rows) {
                        if (!r.accessory_id) return this._err('Please select accessory for all rows.');
                        if (!r.size || !String(r.size).trim()) return this._err('Please provide size for all rows.');
                        const allowed = this.typesMap[r.accessory_id] || [];
                        if (allowed.length && !r.type) return this._err('Please choose type where required.');
                    }

                    const url = attachUrlTpl.replace('__ID__', encodeURIComponent(this.productId));
                    const payload = {
                        items: this.rows.map(r => ({
                            accessory_id: Number(r.accessory_id),
                            size: r.size,
                            type: r.type || null,
                            quantity: r.quantity ?? null,
                            notes: r.notes || null
                        }))
                    };

                    const res = await fetch(url, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify(payload)
                    });
                    if (!res.ok) return this._err('Failed to add accessories. Check inputs.');
                    const data = await res.json();

                    // Rebuild front grid
                    const gridEl = document.getElementById('appliances-grid');
                    if (gridEl) {
                        const items = data.items || [];
                        gridEl.innerHTML = items.length ? items.map(a => `
          <div class="rounded-xl border border-gray-200 p-4 shadow-[inset_0_0_0_1px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-2">
              <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <rect x="4" y="6" width="16" height="12" rx="2" stroke-width="1.5" />
                  <path d="M4 10h16" stroke-width="1.5" />
                </svg>
              </div>
              <h4 class="text-sm font-semibold text-gray-900">${this._esc(a.name || 'Accessory')}</h4>
            </div>
            <dl class="grid grid-cols-2 gap-2 mt-3 text-xs">
              <div><dt class="text-gray-500">Size</dt><dd class="font-medium text-gray-800">${this._esc(a.size ?? '—')}</dd></div>
              <div><dt class="text-gray-500">Type</dt><dd class="font-medium text-gray-800">${this._esc(a.type ?? '—')}</dd></div>
            </dl>
          </div>
        `).join('') : `<div class="p-6 text-center text-gray-500 border border-dashed rounded-xl">No accessories attached.</div>`;
                    }

                    document.getElementById('acc-add-modal')?.classList.add('hidden');
                },

                _err(msg) {
                    const el = document.getElementById('acc-add-error');
                    if (el) {
                        el.textContent = msg;
                        el.classList.remove('hidden');
                    }
                },
                _esc(s) {
                    return (s ?? '').toString().replace(/[&<>"]/g, c => ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;'
                    } [c] || c));
                }
            };
        }

        // wire open/close for ADD modal
        (function() {
            const btn = document.getElementById('btn-add-accessories');
            const modal = document.getElementById('acc-add-modal');
            const closeX = document.getElementById('acc-add-close');
            const cancel = document.getElementById('acc-add-cancel');

            async function openModal(pid, pname) {
                const root = document.getElementById('acc-add-root');
                // Alpine v3 safe access
                const comp = root?._x_dataStack?.[0] || root?.__x?.$data;
                if (comp?.open) await comp.open(pid, pname);
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            btn?.addEventListener('click', (e) => {
                e.preventDefault();
                const pid = btn.dataset.productId;
                if (pid) openModal(pid, btn.dataset.productName || '');
            });
            closeX?.addEventListener('click', closeModal);
            cancel?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
        })();
    </script>


    {{-- -new js for the color show and upload preview (finish) --}}
    <script>
        (function() {
            const modal = document.getElementById('finish-modal');
            const closeX = document.getElementById('finish-close');
            const upload = document.getElementById('finish-upload-btn');
            const fileIn = document.getElementById('finish-image-input');
            const preview = document.getElementById('finish-image-preview');
            const clearBn = document.getElementById('finish-image-clear');
            const chip = document.getElementById('finish-color-chip');
            const hexIn = document.getElementById('finish-color-hex');
            const colorIn = document.getElementById('finish-color-input');
            const errEl = document.getElementById('finish-error');
            const openBtn = document.getElementById('btn-edit-finish'); // from earlier step

            // helper
            function setPreview(url) {
                if (url) {
                    preview.style.backgroundImage = `url('${url}')`;
                    clearBn.classList.remove('hidden');
                } else {
                    preview.style.backgroundImage = '';
                    clearBn.classList.add('hidden');
                }
            }

            function setChip(color) {
                chip.style.backgroundColor = color || '#cccccc';
            }

            function validHex(v) {
                return /^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test((v || '').trim());
            }

            // open (prefill from data-* on the trigger button)
            openBtn?.addEventListener('click', (e) => {
                e.preventDefault();
                // set chip & inputs from current values
                const currentHex = openBtn.dataset.currentColor || '';
                setChip(validHex(currentHex) ? currentHex : '#9E00FF');
                hexIn.value = currentHex;
                // preview
                setPreview(openBtn.dataset.currentImage || '');
                // select label
                const label = openBtn.dataset.currentLabel || '';
                const sel = document.getElementById('finish-type');
                Array.from(sel.options).forEach(o => o.selected = (o.value === label));
                // show
                errEl.classList.add('hidden');
                errEl.textContent = '';
                modal.classList.remove('hidden');
            });

            // close
            closeX?.addEventListener('click', () => modal.classList.add('hidden'));
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) modal.classList.add('hidden');
            });

            // chip opens native color picker
            chip.addEventListener('click', () => colorIn.click());
            colorIn.addEventListener('input', () => {
                setChip(colorIn.value);
                hexIn.value = colorIn.value;
            });
            hexIn.addEventListener('input', () => {
                const v = hexIn.value.trim();
                if (validHex(v)) setChip(v);
            });

            // upload button → hidden input
            upload.addEventListener('click', () => fileIn.click());

            // live image preview
            fileIn.addEventListener('change', () => {
                const f = fileIn.files?.[0];
                if (!f) return setPreview('');
                const reader = new FileReader();
                reader.onload = e => setPreview(e.target.result);
                reader.readAsDataURL(f);
            });

            // clear chosen image (just clears the pending selection & preview)
            clearBn.addEventListener('click', () => {
                fileIn.value = '';
                setPreview('');
            });
        })();
    </script>


    {{-- -js for pop up edits --}}
    {{-- -for the product type --}}
    <script>
        (function() {
            const btn = document.getElementById('btn-edit-product-type');
            const modal = document.getElementById('product-type-modal');
            const closeX = document.getElementById('pt-close');
            const cancel = document.getElementById('pt-cancel');
            const form = document.getElementById('pt-form');
            const sel = document.getElementById('pt-select');
            const hidId = document.getElementById('pt-product-id');
            const errEl = document.getElementById('pt-error');
            const chip = document.getElementById('chip-product-type');
            const csrf = '{{ csrf_token() }}';

            function openModal(productId, currentType) {
                if (!productId) return;
                hidId.value = productId;
                // Pre-select current type if present in options
                Array.from(sel.options).forEach(o => {
                    o.selected = (o.value === currentType);
                });
                errEl.classList.add('hidden');
                errEl.textContent = '';
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            btn?.addEventListener('click', (e) => {
                e.preventDefault();
                openModal(btn.dataset.productId, btn.dataset.currentType);
            });
            closeX?.addEventListener('click', closeModal);
            cancel?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            form?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const productId = hidId.value;
                const value = sel.value;

                try {
                    const res = await fetch(
                        `{{ route('admin.products.updateType', ['product' => '__ID__']) }}`
                        .replace('__ID__', encodeURIComponent(productId)), {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify({
                                product_type: value
                            })
                        });

                    if (!res.ok) {
                        const txt = await res.text();
                        console.error('Update type failed:', res.status, txt);
                        throw new Error('Save failed');
                    }
                    const data = await res.json();

                    // Update the visible chip immediately
                    if (chip && typeof data.product_type === 'string') {
                        chip.textContent = data.product_type || '—';
                    }
                    // Also update the button's data-current-type for next time
                    if (btn) btn.dataset.currentType = data.product_type || '—';

                    closeModal();
                } catch (err) {
                    errEl.textContent = 'Failed to save product type. Please try again.';
                    errEl.classList.remove('hidden');
                }
            });
        })();
    </script>


    {{-- type of finish js --}}
    <script>
        (function() {
            const btn = document.getElementById('btn-edit-finish');
            const modal = document.getElementById('finish-modal');
            const closeX = document.getElementById('finish-close');
            const cancel = document.getElementById('finish-cancel');
            const form = document.getElementById('finish-form');
            const hidId = document.getElementById('finish-product-id');
            const selType = document.getElementById('finish-type');
            const colorIn = document.getElementById('finish-color-input');
            const colorHx = document.getElementById('finish-color-hex');
            const fileIn = document.getElementById('finish-image-input');
            const preview = document.getElementById('finish-image-preview');
            const errEl = document.getElementById('finish-error');
            const csrf = '{{ csrf_token() }}';

            const chipLabel = document.getElementById('finish-label');
            const chipColor = document.getElementById('finish-color');
            const chipImage = document.getElementById('finish-image');

            function setPreview(url) {
                if (url) {
                    preview.style.backgroundImage = `url('${url}')`;
                    preview.classList.remove('hidden');
                } else {
                    preview.style.backgroundImage = '';
                    preview.classList.add('hidden');
                }
            }

            function openModal(productId, label, color, imageUrl) {
                hidId.value = productId || '';
                // prefill
                Array.from(selType.options).forEach(o => {
                    o.selected = (o.value === label);
                });
                colorIn.value = /^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test(color || '') ? color : '#000000';
                colorHx.value = color || '';
                setPreview(imageUrl || '');
                errEl.classList.add('hidden');
                errEl.textContent = '';
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            // Sync color text & picker
            colorIn.addEventListener('input', () => {
                colorHx.value = colorIn.value;
            });
            colorHx.addEventListener('input', () => {
                const v = colorHx.value.trim();
                if (/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test(v)) colorIn.value = v;
            });

            // Live image preview
            fileIn.addEventListener('change', () => {
                const f = fileIn.files?.[0];
                if (!f) return setPreview('');
                const reader = new FileReader();
                reader.onload = (e) => setPreview(e.target.result);
                reader.readAsDataURL(f);
            });

            // Open
            btn?.addEventListener('click', (e) => {
                e.preventDefault();
                openModal(
                    btn.dataset.productId,
                    btn.dataset.currentLabel || '—',
                    btn.dataset.currentColor || '',
                    btn.dataset.currentImage || ''
                );
            });

            closeX?.addEventListener('click', closeModal);
            cancel?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            // Submit
            form?.addEventListener('submit', async (e) => {
                e.preventDefault();
                errEl.classList.add('hidden');
                errEl.textContent = '';

                const productId = hidId.value;
                if (!productId) {
                    errEl.textContent = 'No product selected.';
                    errEl.classList.remove('hidden');
                    return;
                }

                const fd = new FormData();
                fd.append('type_of_finish', selType.value);
                if (colorHx.value.trim()) fd.append('finish_color_hex', colorHx.value.trim());
                if (fileIn.files?.[0]) fd.append('sample_finish_image', fileIn.files[0]);

                try {
                    const res = await fetch(
                        `{{ route('admin.products.updateFinish', ['product' => '__ID__']) }}`
                        .replace('__ID__', encodeURIComponent(productId)), {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            },
                            body: fd
                        });
                    if (!res.ok) {
                        const txt = await res.text();
                        console.error('Update finish failed:', res.status, txt);
                        throw new Error('Save failed');
                    }
                    const data = await res.json();
                    const f = data.finish || {};

                    // Update on-page UI immediately
                    if (chipLabel) chipLabel.textContent = f.label || '—';

                    if (chipColor) {
                        if (f.color) {
                            chipColor.style.background = f.color;
                            chipColor.classList.remove('hidden');
                        } else {
                            chipColor.style.background = '';
                            chipColor.classList.add('hidden');
                        }
                    }

                    if (chipImage) {
                        if (f.image_url) {
                            chipImage.style.backgroundImage = `url('${f.image_url}')`;
                            chipImage.classList.remove('hidden');
                        } else {
                            chipImage.style.backgroundImage = '';
                            chipImage.classList.add('hidden');
                        }
                    }

                    // Also sync the trigger’s data-* for the next edit
                    btn.dataset.currentLabel = f.label || '—';
                    btn.dataset.currentColor = f.color || '';
                    btn.dataset.currentImage = f.image_url || '';

                    closeModal();
                } catch (err) {
                    errEl.textContent = 'Failed to save. Please check your inputs and try again.';
                    errEl.classList.remove('hidden');
                }
            });
        })();
    </script>


    {{-- js for glass door update- --}}
    <script>
        (function() {
            const btn = document.getElementById('btn-edit-glass');
            const modal = document.getElementById('glass-modal');
            const closeX = document.getElementById('glass-close');
            const form = document.getElementById('glass-form');
            const hidId = document.getElementById('glass-product-id');
            const select = document.getElementById('glass-select');
            const errEl = document.getElementById('glass-error');
            const valueEl = document.getElementById('glass-door-value');
            const csrf = '{{ csrf_token() }}';

            function openModal(productId, current) {
                hidId.value = productId || '';
                Array.from(select.options).forEach(o => {
                    o.selected = (o.value === current);
                });
                errEl.classList.add('hidden');
                errEl.textContent = '';
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            btn?.addEventListener('click', (e) => {
                e.preventDefault();
                openModal(btn.dataset.productId, btn.dataset.current || '');
            });
            closeX?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            form?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const productId = hidId.value;
                const v = select.value;

                try {
                    const res = await fetch(
                        `{{ route('admin.products.updateGlassDoor', ['product' => '__ID__']) }}`
                        .replace('__ID__', encodeURIComponent(productId)), {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify({
                                glass_door_type: v
                            })
                        });
                    if (!res.ok) {
                        const txt = await res.text();
                        console.error('Update glass door failed:', res.status, txt);
                        throw new Error('Save failed');
                    }
                    const data = await res.json();

                    // Live update on page
                    if (valueEl && typeof data.glass_door_type === 'string') {
                        valueEl.textContent = data.glass_door_type || '—';
                    }
                    // remember on the trigger for next time
                    btn.dataset.current = data.glass_door_type || '—';

                    closeModal();
                } catch (err) {
                    errEl.textContent = 'Failed to save. Please try again.';
                    errEl.classList.remove('hidden');
                }
            });
        })();
    </script>


    {{-- js for worktop edit --}}

    <script>
        (function() {
            const openBtn = document.getElementById('btn-edit-worktop');
            const modal = document.getElementById('worktop-modal');
            const closeX = document.getElementById('worktop-close');

            const form = document.getElementById('worktop-form');
            const hidId = document.getElementById('worktop-product-id');
            const selType = document.getElementById('worktop-type');

            const colorChip = document.getElementById('worktop-color-chip');
            const colorHex = document.getElementById('worktop-color-hex');
            const colorIn = document.getElementById('worktop-color-input');

            const fileIn = document.getElementById('worktop-image-input');
            const upload = document.getElementById('worktop-upload-btn');
            const preview = document.getElementById('worktop-image-preview');
            const clearBn = document.getElementById('worktop-image-clear');

            const errEl = document.getElementById('worktop-error');
            const csrf = '{{ csrf_token() }}';

            // On-page elements to update after save
            const chipLabel = document.getElementById('worktop-label');
            const chipColor = document.getElementById('worktop-color');
            const chipImage = document.getElementById('worktop-image');

            function validHex(v) {
                return /^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test((v || '').trim());
            }

            function setChip(color) {
                colorChip.style.backgroundColor = color || '#cccccc';
            }

            function setPreview(url) {
                if (url) {
                    preview.style.backgroundImage = `url('${url}')`;
                    clearBn.classList.remove('hidden');
                } else {
                    preview.style.backgroundImage = '';
                    clearBn.classList.add('hidden');
                }
            }

            function openModal(productId, label, color, imageUrl) {
                hidId.value = productId || '';
                Array.from(selType.options).forEach(o => o.selected = (o.value === label));
                setChip(validHex(color) ? color : '#9E00FF');
                colorHex.value = color || '';
                setPreview(imageUrl || '');
                errEl.classList.add('hidden');
                errEl.textContent = '';
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            // trigger open
            openBtn?.addEventListener('click', (e) => {
                e.preventDefault();
                openModal(
                    openBtn.dataset.productId,
                    openBtn.dataset.currentLabel || '—',
                    openBtn.dataset.currentColor || '',
                    openBtn.dataset.currentImage || ''
                );
            });

            // close
            closeX?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            // color sync
            colorChip.addEventListener('click', () => colorIn.click());
            colorIn.addEventListener('input', () => {
                setChip(colorIn.value);
                colorHex.value = colorIn.value;
            });
            colorHex.addEventListener('input', () => {
                const v = colorHex.value.trim();
                if (validHex(v)) setChip(v);
            });

            // upload flow
            upload.addEventListener('click', () => fileIn.click());
            fileIn.addEventListener('change', () => {
                const f = fileIn.files?.[0];
                if (!f) return setPreview('');
                const reader = new FileReader();
                reader.onload = e => setPreview(e.target.result);
                reader.readAsDataURL(f);
            });
            clearBn.addEventListener('click', () => {
                fileIn.value = '';
                setPreview('');
            });

            // submit
            form?.addEventListener('submit', async (e) => {
                e.preventDefault();

                const productId = hidId.value;
                if (!productId) {
                    errEl.textContent = 'No product selected.';
                    errEl.classList.remove('hidden');
                    return;
                }

                const fd = new FormData();
                fd.append('worktop_type', selType.value);
                if (colorHex.value.trim()) fd.append('worktop_color_hex', colorHex.value.trim());
                if (fileIn.files?.[0]) fd.append('sample_worktop_image', fileIn.files[0]);

                try {
                    const res = await fetch(
                        `{{ route('admin.products.updateWorktop', ['product' => '__ID__']) }}`
                        .replace('__ID__', encodeURIComponent(productId)), {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            },
                            body: fd
                        });
                    if (!res.ok) {
                        const txt = await res.text();
                        console.error('Update worktop failed:', res.status, txt);
                        throw new Error('Save failed');
                    }
                    const data = await res.json();
                    const w = data.worktop || {};

                    // Update on-page chips immediately
                    if (chipLabel) chipLabel.textContent = w.label || '—';

                    if (chipColor) {
                        if (w.color) {
                            chipColor.style.background = w.color;
                            chipColor.classList.remove('hidden');
                        } else {
                            chipColor.style.background = '';
                            chipColor.classList.add('hidden');
                        }
                    }

                    if (chipImage) {
                        if (w.image_url) {
                            chipImage.style.backgroundImage = `url('${w.image_url}')`;
                            chipImage.classList.remove('hidden');
                        } else {
                            chipImage.style.backgroundImage = '';
                            chipImage.classList.add('hidden');
                        }
                    }

                    // keep trigger’s data-* fresh
                    openBtn.dataset.currentLabel = w.label || '—';
                    openBtn.dataset.currentColor = w.color || '';
                    openBtn.dataset.currentImage = w.image_url || '';

                    closeModal();
                } catch (err) {
                    errEl.textContent = 'Failed to save. Please try again.';
                    errEl.classList.remove('hidden');
                }
            });
        })();
    </script>

    {{-- js for sin&tap --}}
    <script>
        (function() {
            const btn = document.getElementById('btn-edit-sinktap');
            const modal = document.getElementById('sinktap-modal');
            const closeX = document.getElementById('sinktap-close');

            const form = document.getElementById('sinktap-form');
            const hidId = document.getElementById('sinktap-product-id');
            const selSink = document.getElementById('sinktap-sink');
            const selTap = document.getElementById('sinktap-tap');

            const colorChip = document.getElementById('sinktap-color-chip');
            const colorHex = document.getElementById('sinktap-color-hex');
            const colorIn = document.getElementById('sinktap-color-input');

            const fileIn = document.getElementById('sinktap-image-input');
            const upload = document.getElementById('sinktap-upload-btn');
            const preview = document.getElementById('sinktap-image-preview');
            const clearBn = document.getElementById('sinktap-image-clear');

            const errEl = document.getElementById('sinktap-error');
            const csrf = '{{ csrf_token() }}';

            // on-page chips
            const bowlEl = document.getElementById('sink-bowl-label');
            const tapEl = document.getElementById('sink-handle-label');
            const colorEl = document.getElementById('sink-color');
            const imgEl = document.getElementById('sink-image');

            function validHex(v) {
                return /^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test((v || '').trim());
            }

            function setChip(color) {
                colorChip.style.backgroundColor = color || '#cccccc';
            }

            function setPreview(url) {
                if (url) {
                    preview.style.backgroundImage = `url('${url}')`;
                    clearBn.classList.remove('hidden');
                } else {
                    preview.style.backgroundImage = '';
                    clearBn.classList.add('hidden');
                }
            }

            function openModal(pid, sink, tap, hex, img) {
                hidId.value = pid || '';
                Array.from(selSink.options).forEach(o => o.selected = (o.value === sink));
                Array.from(selTap.options).forEach(o => o.selected = (o.value === tap));

                setChip(validHex(hex) ? hex : '#9E00FF');
                colorHex.value = hex || '';
                setPreview(img || '');

                errEl.classList.add('hidden');
                errEl.textContent = '';
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            // open from trigger
            btn?.addEventListener('click', (e) => {
                e.preventDefault();
                openModal(
                    btn.dataset.productId,
                    btn.dataset.currentSink || '',
                    btn.dataset.currentTap || '',
                    btn.dataset.currentColor || '',
                    btn.dataset.currentImage || ''
                );
            });

            // close interactions
            closeX?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            // color sync
            colorChip.addEventListener('click', () => colorIn.click());
            colorIn.addEventListener('input', () => {
                setChip(colorIn.value);
                colorHex.value = colorIn.value;
            });
            colorHex.addEventListener('input', () => {
                const v = colorHex.value.trim();
                if (validHex(v)) setChip(v);
            });

            // upload flow
            upload.addEventListener('click', () => fileIn.click());
            fileIn.addEventListener('change', () => {
                const f = fileIn.files?.[0];
                if (!f) return setPreview('');
                const reader = new FileReader();
                reader.onload = e => setPreview(e.target.result);
                reader.readAsDataURL(f);
            });
            clearBn.addEventListener('click', () => {
                fileIn.value = '';
                setPreview('');
            });

            // submit
            form?.addEventListener('submit', async (e) => {
                e.preventDefault();

                const productId = hidId.value;
                const sink = selSink.value;
                const tap = selTap.value;
                const hex = colorHex.value.trim();

                const fd = new FormData();
                fd.append('sink_top_type', sink);
                fd.append('handle', tap);
                if (hex) fd.append('sink_color_hex', hex);
                if (fileIn.files?.[0]) fd.append('sample_sink_image', fileIn.files[0]);

                try {
                    const res = await fetch(
                        `{{ route('admin.products.updateSinkTap', ['product' => '__ID__']) }}`
                        .replace('__ID__', encodeURIComponent(productId)), {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            },
                            body: fd
                        });
                    if (!res.ok) {
                        const txt = await res.text();
                        console.error('Update sink&tap failed:', res.status, txt);
                        throw new Error('Save failed');
                    }
                    const data = await res.json();
                    const st = data.sink_tap || {};

                    // live update chips
                    if (bowlEl) bowlEl.textContent = st.bowl || '—';
                    if (tapEl) tapEl.textContent = st.handle || '—';

                    if (colorEl) {
                        if (st.color) {
                            colorEl.style.background = st.color;
                            colorEl.classList.remove('hidden');
                        } else {
                            colorEl.style.background = '';
                            colorEl.classList.add('hidden');
                        }
                    }
                    if (imgEl) {
                        if (st.image_url) {
                            imgEl.style.backgroundImage = `url('${st.image_url}')`;
                            imgEl.classList.remove('hidden');
                        } else {
                            imgEl.style.backgroundImage = '';
                            imgEl.classList.add('hidden');
                        }
                    }

                    // keep trigger dataset fresh
                    btn.dataset.currentSink = st.bowl || '—';
                    btn.dataset.currentTap = st.handle || '—';
                    btn.dataset.currentColor = st.color || '';
                    btn.dataset.currentImage = st.image_url || '';

                    closeModal();
                } catch (err) {
                    errEl.textContent = 'Failed to save. Please try again.';
                    errEl.classList.remove('hidden');
                }
            });


        })();
    </script>
    <script>
        function accAddEditor({
            listUrlTpl,
            attachUrlTpl,
            createUrl,
            csrf
        }) {
            return {
                productId: null,
                catalog: [],
                sizes: [],
                typesMap: {},
                rows: [],
                modal: {
                    open: false,
                    form: {
                        name: '',
                        types_csv: ''
                    }
                },
                errors: {},
                flash: '',

                async open(pid, pname) {
                    this.productId = pid;
                    document.getElementById('acc-add-product-name').textContent = pname ? `— ${pname}` : '';

                    const url = listUrlTpl.replace('__ID__', encodeURIComponent(pid));
                    const res = await fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });
                    const data = await res.json();
                    this.catalog = data.catalog || [];
                    this.sizes = data.sizes || [];
                    this.typesMap = data.types || {};

                    // start with one empty row
                    this.rows = [{
                        _key: 'r-' + Date.now(),
                        accessory_id: '',
                        type: '',
                        size: '',
                        quantity: 1,
                        notes: ''
                    }];
                },

                addRow() {
                    this.rows.push({
                        _key: 'r-' + Date.now() + Math.random(),
                        accessory_id: '',
                        type: '',
                        size: '',
                        quantity: 1,
                        notes: ''
                    });
                },
                remove(i) {
                    this.rows.splice(i, 1);
                },
                onAccessoryChange(i) {
                    const row = this.rows[i];
                    const allowed = this.typesMap[row.accessory_id] || [];
                    if (!allowed.includes(row.type)) row.type = '';
                },

                openNewAccessory() {
                    this.modal.open = true;
                    this.modal.form = {
                        name: '',
                        types_csv: ''
                    };
                    this.errors = {};
                    this.flash = '';
                },
                closeNewAccessory() {
                    this.modal.open = false;
                },

                async saveNewAccessory() {
                    this.errors = {};
                    this.flash = '';
                    const res = await fetch(createUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            name: this.modal.form.name,
                            types_csv: this.modal.form.types_csv
                        })
                    });
                    if (!res.ok) {
                        if (res.status === 422) {
                            const j = await res.json();
                            this.errors = j.errors || {};
                        } else {
                            this.errors = {
                                name: 'Failed to save accessory.'
                            };
                        }
                        return;
                    }
                    const data = await res.json(); // {id,name,types[]}
                    // inject into catalog + typesMap
                    this.catalog.push({
                        id: data.id,
                        name: data.name
                    });
                    this.typesMap[data.id] = data.types || [];
                    this.flash = 'Accessory created.';
                    // optional: auto-select in the last row
                    const last = this.rows[this.rows.length - 1];
                    if (last) {
                        last.accessory_id = data.id;
                        last.type = '';
                    }
                    setTimeout(() => this.closeNewAccessory(), 600);
                },

                async save() {
                    // validate quickly on client
                    for (const r of this.rows) {
                        if (!r.accessory_id) return this._err('Please select accessory for all rows.');
                        if (!r.size) return this._err('Please choose size for all rows.');
                        const allowed = this.typesMap[r.accessory_id] || [];
                        if (allowed.length && !r.type) return this._err('Please choose type where required.');
                    }

                    const url = attachUrlTpl.replace('__ID__', encodeURIComponent(this.productId));
                    const payload = {
                        items: this.rows.map(r => ({
                            accessory_id: Number(r.accessory_id),
                            size: r.size,
                            type: r.type || null,
                            quantity: r.quantity ?? null,
                            notes: r.notes || null
                        }))
                    };

                    const res = await fetch(url, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify(payload)
                    });
                    if (!res.ok) return this._err('Failed to add accessories. Check inputs.');

                    const data = await res.json();
                    // Rebuild your front grid (#appliances-grid) with returned items
                    const gridEl = document.getElementById('appliances-grid');
                    if (gridEl) {
                        const items = data.items || [];
                        gridEl.innerHTML = items.length ? items.map(a => `
          <div class="rounded-xl border border-gray-200 p-4 shadow-[inset_0_0_0_1px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-2">
              <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <rect x="4" y="6" width="16" height="12" rx="2" stroke-width="1.5" />
                  <path d="M4 10h16" stroke-width="1.5" />
                </svg>
              </div>
              <h4 class="text-sm font-semibold text-gray-900">${this._esc(a.name || 'Accessory')}</h4>
            </div>
            <dl class="grid grid-cols-2 gap-2 mt-3 text-xs">
              <div><dt class="text-gray-500">Size</dt><dd class="font-medium text-gray-800">${this._esc(a.size ?? '—')}</dd></div>
              <div><dt class="text-gray-500">Type</dt><dd class="font-medium text-gray-800">${this._esc(a.type ?? '—')}</dd></div>
            </dl>
          </div>
        `).join('') : `<div class="p-6 text-center text-gray-500 border border-dashed rounded-xl">No accessories attached.</div>`;
                    }

                    // close modal
                    document.getElementById('acc-add-modal')?.classList.add('hidden');
                },

                _err(msg) {
                    const el = document.getElementById('acc-add-error');
                    if (el) {
                        el.textContent = msg;
                        el.classList.remove('hidden');
                    }
                },
                _esc(s) {
                    return (s ?? '').toString().replace(/[&<>"]/g, c => ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;'
                    } [c] || c));
                }
            };
        }

        // wire up open/close
        (function() {
            const btn = document.getElementById('btn-add-accessories');
            const modal = document.getElementById('acc-add-modal');
            const closeX = document.getElementById('acc-add-close');
            const cancel = document.getElementById('acc-add-cancel');

            async function openModal(pid, pname) {
                const comp = document.getElementById('acc-add-root')?.__x?.$data;
                if (comp?.open) await comp.open(pid, pname);
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            btn?.addEventListener('click', (e) => {
                e.preventDefault();
                const pid = btn.dataset.productId;
                if (pid) openModal(pid, btn.dataset.productName || '');
            });
            closeX?.addEventListener('click', closeModal);
            cancel?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
        })();
    </script>




    {{-- js for phase toggle --}}
    <script>
        (function() {
            const csrf = '{{ csrf_token() }}';
            document.querySelectorAll('.phase-toggle').forEach(cb => {
                cb.addEventListener('change', async (e) => {
                    const el = e.currentTarget;
                    el.disabled = true;

                    try {
                        const res = await fetch(el.dataset.url, {
                            method: 'POST',
                            credentials: 'same-origin', // ← important
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf, // ← CSRF header
                            },
                            body: JSON.stringify({
                                checked: el.checked ? 1 : 0
                            }),
                        });

                        if (!res.ok) {
                            const txt = await res.text();
                            console.error('Toggle failed:', res.status, txt); // ← see exact reason
                            throw new Error('Toggle failed ' + res.status);
                        }

                        const data = await res.json();
                        // update progress UI
                        const doneEl = document.getElementById('phase-done');
                        const barEl = document.getElementById('phase-bar');
                        const pctEl = document.getElementById('phase-pct');
                        if (doneEl && typeof data.done === 'number') doneEl.textContent = data.done;
                        if (barEl && typeof data.pct === 'number') barEl.style.width = data.pct +
                            '%';
                        if (pctEl && typeof data.pct === 'number') pctEl.textContent = data.pct +
                            '%';
                    } catch (err) {
                        el.checked = !el.checked; // revert on failure
                        alert('Failed to save. Check console for details.');
                    } finally {
                        el.disabled = false;
                    }
                });
            });
        })();
    </script>



    <script>
        function accAddEditor({
            listUrlTpl,
            attachUrlTpl,
            createUrl,
            csrf
        }) {
            return {
                productId: null,
                catalog: [],
                sizes: [],
                typesMap: {},
                rows: [],
                modal: {
                    open: false,
                    form: {
                        name: '',
                        types_csv: ''
                    }
                },
                errors: {},
                flash: '',

                async open(pid, pname) {
                    this.productId = pid;
                    document.getElementById('acc-add-product-name').textContent = pname ? `— ${pname}` : '';

                    const url = listUrlTpl.replace('__ID__', encodeURIComponent(pid));
                    const res = await fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });
                    const data = await res.json();
                    this.catalog = data.catalog || [];
                    this.sizes = data.sizes || [];
                    this.typesMap = data.types || {};

                    // start with one empty row
                    this.rows = [{
                        _key: 'r-' + Date.now(),
                        accessory_id: '',
                        type: '',
                        size: '',
                        quantity: 1,
                        notes: ''
                    }];
                },

                addRow() {
                    this.rows.push({
                        _key: 'r-' + Date.now() + Math.random(),
                        accessory_id: '',
                        type: '',
                        size: '',
                        quantity: 1,
                        notes: ''
                    });
                },
                remove(i) {
                    this.rows.splice(i, 1);
                },
                onAccessoryChange(i) {
                    const row = this.rows[i];
                    const allowed = this.typesMap[row.accessory_id] || [];
                    if (!allowed.includes(row.type)) row.type = '';
                },

                openNewAccessory() {
                    this.modal.open = true;
                    this.modal.form = {
                        name: '',
                        types_csv: ''
                    };
                    this.errors = {};
                    this.flash = '';
                },
                closeNewAccessory() {
                    this.modal.open = false;
                },

                async saveNewAccessory() {
                    this.errors = {};
                    this.flash = '';
                    const res = await fetch(createUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            name: this.modal.form.name,
                            types_csv: this.modal.form.types_csv
                        })
                    });
                    if (!res.ok) {
                        if (res.status === 422) {
                            const j = await res.json();
                            this.errors = j.errors || {};
                        } else {
                            this.errors = {
                                name: 'Failed to save accessory.'
                            };
                        }
                        return;
                    }
                    const data = await res.json(); // {id,name,types[]}
                    // inject into catalog + typesMap
                    this.catalog.push({
                        id: data.id,
                        name: data.name
                    });
                    this.typesMap[data.id] = data.types || [];
                    this.flash = 'Accessory created.';
                    // optional: auto-select in the last row
                    const last = this.rows[this.rows.length - 1];
                    if (last) {
                        last.accessory_id = data.id;
                        last.type = '';
                    }
                    setTimeout(() => this.closeNewAccessory(), 600);
                },

                async save() {
                    // validate quickly on client
                    for (const r of this.rows) {
                        if (!r.accessory_id) return this._err('Please select accessory for all rows.');
                        if (!r.size) return this._err('Please choose size for all rows.');
                        const allowed = this.typesMap[r.accessory_id] || [];
                        if (allowed.length && !r.type) return this._err('Please choose type where required.');
                    }

                    const url = attachUrlTpl.replace('__ID__', encodeURIComponent(this.productId));
                    const payload = {
                        items: this.rows.map(r => ({
                            accessory_id: Number(r.accessory_id),
                            size: r.size,
                            type: r.type || null,
                            quantity: r.quantity ?? null,
                            notes: r.notes || null
                        }))
                    };

                    const res = await fetch(url, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify(payload)
                    });
                    if (!res.ok) return this._err('Failed to add accessories. Check inputs.');

                    const data = await res.json();
                    // Rebuild your front grid (#appliances-grid) with returned items
                    const gridEl = document.getElementById('appliances-grid');
                    if (gridEl) {
                        const items = data.items || [];
                        gridEl.innerHTML = items.length ? items.map(a => `
          <div class="rounded-xl border border-gray-200 p-4 shadow-[inset_0_0_0_1px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-2">
              <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <rect x="4" y="6" width="16" height="12" rx="2" stroke-width="1.5" />
                  <path d="M4 10h16" stroke-width="1.5" />
                </svg>
              </div>
              <h4 class="text-sm font-semibold text-gray-900">${this._esc(a.name || 'Accessory')}</h4>
            </div>
            <dl class="grid grid-cols-2 gap-2 mt-3 text-xs">
              <div><dt class="text-gray-500">Size</dt><dd class="font-medium text-gray-800">${this._esc(a.size ?? '—')}</dd></div>
              <div><dt class="text-gray-500">Type</dt><dd class="font-medium text-gray-800">${this._esc(a.type ?? '—')}</dd></div>
            </dl>
          </div>
        `).join('') : `<div class="p-6 text-center text-gray-500 border border-dashed rounded-xl">No accessories attached.</div>`;
                    }

                    // close modal
                    document.getElementById('acc-add-modal')?.classList.add('hidden');
                },

                _err(msg) {
                    const el = document.getElementById('acc-add-error');
                    if (el) {
                        el.textContent = msg;
                        el.classList.remove('hidden');
                    }
                },
                _esc(s) {
                    return (s ?? '').toString().replace(/[&<>"]/g, c => ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;'
                    } [c] || c));
                }
            };
        }

        // wire up open/close
        (function() {
            const btn = document.getElementById('btn-add-accessories');
            const modal = document.getElementById('acc-add-modal');
            const closeX = document.getElementById('acc-add-close');
            const cancel = document.getElementById('acc-add-cancel');

            async function openModal(pid, pname) {
                const comp = document.getElementById('acc-add-root')?.__x?.$data;
                if (comp?.open) await comp.open(pid, pname);
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            btn?.addEventListener('click', (e) => {
                e.preventDefault();
                const pid = btn.dataset.productId;
                if (pid) openModal(pid, btn.dataset.productName || '');
            });
            closeX?.addEventListener('click', closeModal);
            cancel?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
        })();
    </script>

    {{-- Comments: Drawer Script --}}
@include('production.partials.comments-drawer-script')

@include('production.partials.add-products-js', ['project' => $project])

</x-Installation-layout>
