<h2 class="text-2xl font-bold mb-4">{{ $client->name }}'s Projects</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    {{-- Pending --}}
    <div>
        <h3 class="text-lg font-semibold bg-yellow-500 text-white p-2 rounded">Pending ({{ $pending->count() }})</h3>
        @foreach ($pending as $project)
            <div onclick="window.location='{{ route('projects.show', $project->id) }}'" class="bg-white shadow p-3 mt-2 rounded cursor-pointer hover:bg-gray-100">
                <p class="font-medium">{{ $project->title }}</p>
                <p class="text-sm">{{ $project->created_at->format('F j, Y') }}</p>
                <p class="text-sm">Client: {{ $project->client->name }}</p>
            </div>
        @endforeach
    </div>

    {{-- Ongoing --}}
    <div>
        <h3 class="text-lg font-semibold bg-blue-600 text-white p-2 rounded">Ongoing ({{ $ongoing->count() }})</h3>
        @foreach ($ongoing as $project)
            <div onclick="window.location='{{ route('projects.show', $project->id) }}'" class="bg-white shadow p-3 mt-2 rounded cursor-pointer hover:bg-gray-100">
                <p class="font-medium">{{ $project->title }}</p>
                <p class="text-sm">{{ $project->created_at->format('F j, Y') }}</p>
                <p class="text-sm">Client: {{ $project->client->name }}</p>
            </div>
        @endforeach
    </div>

    {{-- Completed --}}
    <div>
        <h3 class="text-lg font-semibold bg-green-600 text-white p-2 rounded">Completed ({{ $completed->count() }})</h3>
        @foreach ($completed as $project)
            <div onclick="window.location='{{ route('projects.show', $project->id) }}'" class="bg-white shadow p-3 mt-2 rounded cursor-pointer hover:bg-gray-100">
                <p class="font-medium">{{ $project->title }}</p>
                <p class="text-sm">{{ $project->created_at->format('F j, Y') }}</p>
                <p class="text-sm">Client: {{ $project->client->name }}</p>
            </div>
        @endforeach
    </div>
</div>
