<div class="bg-white shadow-md rounded-[15px] pb-1">

<table class=" min-w-full text-left">
    <thead class="bg-gray-100 text-left">
        <tr>
            <th class="p-4 font-mediumt text-[15px]">Project Name</th>
            <th class="p-4 font-mediumt text-[15px]">Status</th>
            <th class="p-4 font-mediumt text-[15px]">Supervisor</th>
            <th class="p-4 font-mediumt text-[15px]">Client</th>
            <th class="p-4 font-mediumt text-[15px]">Location</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            <tr class="items-center p-2 border-t hover:bg-gray-50">
                <td class="p-4 font-normal text-[15px]">{{ $project->name }}</td>
                <td class="p-4 font-normal text-[15px]">{{ $project->status }}</td>
                <td class="p-4 font-normal text-[15px]">{{ $project->techSupervisor->name ?? '—' }}</td>
                <td class="p-4 font-normal text-[15px]">{{ $project->client->firstname }} {{ $project->client->lastname }}</td>
                <td class="p-4 font-normal text-[15px]">{{ $project->client->location ?? '—' }}</td>
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
