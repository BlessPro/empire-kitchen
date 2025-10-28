@props([
    'projects' => collect(),
    'emptyMessage' => 'No projects available',
])

@forelse($projects as $project)
    <div class="relative p-5 mb-5 bg-white rounded-[20px] shadow hover:bg-gray-100">
        <a href="{{ route('admin.projects.show', $project->id) }}" class="absolute inset-0 z-10"
            aria-label="Open {{ $project->name }}"></a>

        <div class="relative z-20">
            <div class="flex items-center justify-between">
                <h3 class="font-normal text-gray-800 text-[15px]">{{ $project->name }}</h3>

                <div class="relative z-30">
                    <div class="relative" data-no-nav>
                        <button class="p-3 more-trigger" data-project="{{ $project->id }}" aria-haspopup="menu"
                            aria-expanded="false">
                            <iconify-icon icon="mingcute:more-2-line" width="22" style="color:#5A0562;"></iconify-icon>
                        </button>

                        <div class="absolute right-0 z-50 hidden w-48 mt-2 bg-white border border-gray-100 shadow-lg more-menu rounded-xl"
                            data-project="{{ $project->id }}" role="menu">
                            <ul class="py-2 text-[15px] text-gray-700">
                                <li>
                                    <a href="#" class="block px-4 py-2 assign-trigger hover:bg-gray-100"
                                        data-project-id="{{ $project->id }}"
                                        data-project-name="{{ $project->name }}"
                                        data-current-id="{{ $project->tech_supervisor_id ?? '' }}"
                                        data-no-nav onclick="event.preventDefault();">
                                        Assign Supervisor
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 add-product-trigger hover:bg-gray-100"
                                        data-project-id="{{ $project->id }}"
                                        data-project-name="{{ $project->name }}"
                                        onclick="event.preventDefault();">
                                        Add new product
                                    </a>
                                </li>
                                <li>
                                    <button type="button"
                                        class="block w-full px-4 py-2 text-left hover:bg-gray-100"
                                        onclick="duplicateProject({{ $project->id }})">
                                        Duplicate project
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                <iconify-icon icon="uis:calender" width="22" style="color:#5A0562;"></iconify-icon>
                {{ $project->due_date }}
            </div>

            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center gap-3">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-8 h-8 rounded-full" alt="">
                    <span class="text-sm text-gray-700">
                        {{ $project->client?->title . ' ' . $project->client?->firstname . ' ' . $project->client?->lastname }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="p-5 mb-5 bg-white rounded-[20px] shadow">
        <h3 class="font-semibold text-gray-800">{{ $emptyMessage }}</h3>
    </div>
@endforelse

