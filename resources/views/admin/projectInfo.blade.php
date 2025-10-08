{{-- resources/views/admin/projectInfo.blade.php --}}
<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')
    </x-slot>

    @php
        $phases = $project->phases ?? [];
        $total = max(1, count($phases));
        $done = collect($phases)->where('done', true)->count();
        $pct = (int) round(($done / $total) * 100);
        $chip =
            'inline-flex items-center h-6 rounded-full bg-gray-100 px-2.5 text-xs text-gray-800 ring-1 ring-gray-200';
        $editBtn =
            'inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-medium text-[#5A0562] ring-1 ring-[#E3C8F1] hover:bg-[#FBF7FE]';
    @endphp

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen">
        <div class="p-6">
            <div class="rounded-[20px] border border-gray-200 bg-white shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 p-5">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">{{ $project->name }}</h1>
                        <div class="mt-2 flex flex-wrap items-center gap-4 text-sm text-gray-600">
                            <span class="inline-flex items-center gap-2">
                                {{-- calendar --}}
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 2v3M16 2v3M3 9h18M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7z" />
                                </svg> <span class="font-medium">Installation:</span>
                                <span>{{ \Illuminate\Support\Carbon::parse($project->install_date)->format('M d, Y') }}</span>
                            </span>
                            <span class="inline-flex items-center gap-2">
                                {{-- user --}}
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4.5 20.25a8.25 8.25 0 1 1 15 0" />
                                </svg> <span class="font-medium">Client:</span>
                                <span>{{ $project->client_name }}</span>
                            </span>
                            <span class="inline-flex items-center gap-2">
                                {{-- pin --}}
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 21s7-4.686 7-11a7 7 0 0 0-14 0c0 6.314 7 11 7 11Z" />
                                    <circle cx="12" cy="10" r="2.5" stroke-width="1.5" />
                                </svg> <span>{{ $project->location_text }}</span>
                            </span>
                        </div>
                    </div>
                    <span
                        class="rounded-full bg-fuchsia-100 px-3 py-1 text-xs font-medium text-fuchsia-800">Installation</span>
                </div>

                {{-- Production Phases --}}
                <details open class="group">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-2 px-5 py-4">
                        <span class="text-sm font-semibold text-[#5A0562]">Production Phases</span>
                        <svg class="h-5 w-5 text-gray-500 transition group-open:rotate-180" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>

                    <div class="px-5 pb-4">
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                            @foreach ($phases as $p)
                                <label class="flex items-start gap-3 rounded-lg border border-gray-200 px-3 py-2">
                                    <input type="checkbox"
                                        class="mt-0.5 h-4 w-4 rounded border-gray-300 text-fuchsia-700" disabled
                                        @checked(data_get($p, 'done'))>
                                    <span class="text-sm text-gray-800">{{ data_get($p, 'name', '—') }}</span>
                                </label>
                            @endforeach
                        </div>

                        {{-- Completion --}}
                        <div class="mt-5">
                            <div class="mb-1 flex items-center justify-between text-xs text-gray-600">
                                <span>Completion</span><span>{{ $done }}/{{ $total }}</span>
                            </div>
                            <div class="relative h-[6px] w-full overflow-hidden rounded-full bg-gray-100"
                                role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                aria-valuenow="{{ $pct }}">
                                <div class="absolute left-0 top-0 h-[6px] rounded-full bg-[#1DC76B]"
                                    style="width: {{ $pct }}%"></div>
                            </div>
                            <div class="mt-1 text-right text-xs font-medium text-emerald-700">{{ $pct }}%</div>
                        </div>
                    </div>
                </details>

                {{-- Product Specifications --}}
                <div class="border-t border-gray-100"></div>
                <div class="px-5 py-4">
                    <h3 class="text-sm font-semibold text-[#5A0562]">Product Specifications</h3>

                    {{-- Product Type --}}
                    <div class="mt-3 rounded-xl border border-gray-200">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">Product Type</span>
                            <a href="#" class="{{ $editBtn }}">Edit</a>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-3">
                            <div class="flex flex-wrap items-center gap-2">
                                @foreach ($project->productTypes as $type)
                                    <span class="{{ $chip }}">{{ $type }}</span>
                                @endforeach
                                <button
                                    class="ml-2 inline-flex items-center h-7 rounded-[10px] bg-[#5A0562] px-3 text-xs font-medium text-white">+
                                    Add Product</button>
                            </div>
                        </div>
                    </div>

                    {{-- Type of Finish --}}
                    <div class="mt-3 rounded-xl border border-gray-200">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">Type of Finish</span>
                            <a href="#" class="{{ $editBtn }}">Edit</a>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-3">
                            <div class="flex flex-wrap items-center gap-2 text-sm">
                                <span class="{{ $chip }}">High Gloss</span>
                                <span class="{{ $chip }}">Color: <span
                                        class="ml-1 font-medium">{{ $project->finish['color'] }}</span></span>
                                <span class="inline-flex h-5 w-8 rounded-md ring-1 ring-gray-300"
                                    style="background: {{ e($project->finish['color']) }}"></span>
                                {{-- faux texture swatch --}}
                                <span class="inline-block h-5 w-8 rounded-md ring-1 ring-gray-300"
                                    style="background: linear-gradient(45deg,#a46d57,#774c3b)"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Type of Glass Door --}}
                    <div class="mt-3 rounded-xl border border-gray-200">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">Type of Glass Door</span>
                            <a href="#" class="{{ $editBtn }}">Edit</a>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-3 text-sm text-gray-800">
                            {{ $project->glass_door_type }}
                        </div>
                    </div>

                    {{-- Worktop Type --}}
                    <div class="mt-3 rounded-xl border border-gray-200">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">Worktop Type</span>
                            <a href="#" class="{{ $editBtn }}">Edit</a>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-3">
                            <div class="flex flex-wrap items-center gap-2 text-sm">
                                <span class="{{ $chip }}">{{ $project->worktop['label'] }}</span>
                                <span class="{{ $chip }}">Color: <span
                                        class="ml-1 font-medium">{{ $project->worktop['color'] }}</span></span>
                                <span class="inline-flex h-5 w-8 rounded-md ring-1 ring-gray-300"
                                    style="background: {{ e($project->worktop['color']) }}"></span>
                                {{-- faux granite thumb --}}
                                <span
                                    class="inline-block h-5 w-10 rounded-md ring-1 ring-gray-300 bg-[url('https://images.unsplash.com/photo-1582582485289-43a6e1b1f2e9?auto=format&fit=crop&w=80&q=60')] bg-cover bg-center"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Sink & Tap --}}
                    <div class="mt-3 rounded-xl border border-gray-200">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">Sink & Tap</span>
                            <a href="#" class="{{ $editBtn }}">Edit</a>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-3">
                            <div class="flex flex-wrap items-center gap-2 text-sm">
                                <span class="{{ $chip }}">{{ $project->sink_tap['bowl'] }}</span>
                                <span class="{{ $chip }}">Color: <span
                                        class="ml-1 font-medium">{{ $project->sink_tap['color'] }}</span></span>
                                <span class="inline-flex h-5 w-8 rounded-md ring-1 ring-gray-300"
                                    style="background: {{ e($project->sink_tap['color']) }}"></span>
                                <span class="{{ $chip }}">{{ $project->sink_tap['handle'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Appliances --}}
                <details class="group border-t border-gray-100" open>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-2 px-5 py-4">
                        <span class="text-sm font-semibold text-[#5A0562]">Appliances</span>
                        <svg class="h-5 w-5 text-gray-500 transition group-open:rotate-180" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>

                    <div class="px-5 pb-5">
                        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($project->appliances as $a)
                                <div
                                    class="rounded-xl border border-gray-200 p-4 shadow-[inset_0_0_0_1px_rgba(0,0,0,0.02)]">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100">
                                            {{-- generic device (appliance card icon) --}}
                                            <svg class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor">
                                                <rect x="4" y="6" width="16" height="12" rx="2"
                                                    stroke-width="1.5" />
                                                <path d="M4 10h16" stroke-width="1.5" />
                                            </svg>
                                        </div>
                                        <h4 class="text-sm font-semibold text-gray-900">{{ $a['name'] }}</h4>
                                    </div>
                                    <dl class="mt-3 grid grid-cols-2 gap-2 text-xs">
                                        <div>
                                            <dt class="text-gray-500">Size</dt>
                                            <dd class="font-medium text-gray-800">{{ $a['size'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-gray-500">Type</dt>
                                            <dd class="font-medium text-gray-800">{{ $a['type'] }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <a href="#" class="{{ $editBtn }}">Edit accessories</a>
                            <button
                                class="inline-flex items-center gap-2 rounded-lg bg-[#5A0562] px-3 py-1.5 text-xs font-medium text-white hover:bg-[#4a044c]">+
                                Add accessories</button>
                        </div>
                    </div>
                </details>

                {{-- Media --}}
                <details class="group border-t border-gray-100" open>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-2 px-5 py-4">
                        <span class="text-sm font-semibold text-[#5A0562]">Media</span>
                        <svg class="h-5 w-5 text-gray-500 transition group-open:rotate-180" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>

                    @php
                        $rows = [
                            ['Attachments after measurement', $project->media['attachments']],
                            ['Designs', $project->media['designs']],
                            ['Plans', $project->media['plans']],
                        ];
                    @endphp

                    <div class="px-5 pb-5">
                        <div class="divide-y divide-gray-100 rounded-xl border border-gray-200">
                            @foreach ($rows as [$label, $items])
                                <div class="flex items-center justify-between px-4 py-3">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $label }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ empty($items) ? 'No data to display' : count($items) . ' file(s)' }}
                                        </div>
                                    </div>
                                    @unless (empty($items))
                                        <a href="#"
                                            class="text-xs font-medium text-[#5A0562] hover:underline">View</a>
                                    @endunless
                                </div>
                            @endforeach
                        </div>
                    </div>
                </details>

            </div>
        </div>
    </main>
</x-layouts.app>
