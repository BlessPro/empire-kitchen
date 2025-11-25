<x-Installation-layout>
    <div class="p-4 sm:p-6 bg-[#F9F7F7] min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Project Management</h1>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Production -->
            <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#22C55E]">
                    <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                        <h5 class="px-[10px] py-[10px] text-black">{{ ($productions ?? collect())->count() }}</h5>
                    </span>
                    Production
                </div>
                <div class="pt-2 space-y-5">
                    @include('admin.partials.project-stage-cards', [
                        'projects' => $productions ?? collect(),
                        'emptyMessage' => 'No project is currently in production',
                        'projectRouteName' => 'installation.projects.info',
                        'showActions' => false,
                    ])
                </div>
            </div>

            <!-- Installation -->
            <div class="pt-3.5 pr-3 pb-4 pl-3 bg-[#F8FAFC] rounded-[40px]">
                <div class="flex items-center pl-2 pr-5 py-2 text-white rounded-full bg-[#5A0562]">
                    <span class="mr-2 font-semibold bg-white rounded-full px-[10px] py-[0px]">
                        <h5 class="px-[10px] py-[10px] text-black">{{ ($installations ?? collect())->count() }}</h5>
                    </span>
                    Installation
                </div>
                <div class="pt-2 space-y-5">
                    @include('admin.partials.project-stage-cards', [
                        'projects' => $installations ?? collect(),
                        'emptyMessage' => 'No project is currently in installation',
                        'projectRouteName' => 'installation.projects.info',
                        'showActions' => false,
                    ])
                </div>
            </div>
        </div>
    </div>
</x-Installation-layout>
