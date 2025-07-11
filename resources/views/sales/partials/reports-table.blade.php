<div class="bg-white shadow-md rounded-[15px] pb-1">

<table class=" min-w-full text-left">
    <thead class="bg-gray-100 text-left">
        <tr>
            <th class="p-4 font-medium text-[15px]">Project Name</th>
            <th class="p-4 font-medium text-[15px]">Status</th>
            <th class="p-4 font-medium text-[15px]">Tech Supervisor</th>
            <th class="p-4 font-medium text-[15px]">Client</th>
            <th class="p-4 font-medium text-[15px]">Location</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            <tr class="items-center  border-b hover:bg-gray-50">
                <td class="p-4 font-normal text-[15px]">{{ $project->name }}</td>
    <td class="p-2 font-normal text-[15px]">
            <span class="px-3 py-1 text-sm {{ $statusClasses[$project->status] ?? $defaultClass }}">{{ $project->status }}</span>
            </td>
                <td class="p-2 font-normal text-[15px]">
                    <div class="d-flex align-items-center p-2 font-normal text-[15px] flex items-center py-3 space-x-2 ">
                                <img src="{{ asset('storage/' . $project->techSupervisor->profile_pic) }}" alt="designer" width="40" height="40" class="object-cover w-8 h-8 rounded-full">
                                <span>{{ $project->techSupervisor->name }}</span>
                            </div>
                </td>
                <td class="p-2 font-normal text-[15px]">{{ $project->client->firstname }} {{ $project->client->lastname }}</td>
                <td class="p-2 font-normal text-[15px]">{{ $project->client->location ?? '—' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if ($projects->hasPages())
    <div class="mt-4 ml-5 mr-5 mb-3">
        {{ $projects->links('pagination::tailwind') }}
    </div>
@endif
</div>
