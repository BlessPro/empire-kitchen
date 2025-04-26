<h2 class="mb-4 text-lg font-bold">Recent Projects</h2>

<ul>
    @forelse ($projects as $project)
        <li class="mb-2">
            <strong>{{ $project->title }}</strong><br>
            {{ $project->description ?? 'No description' }}
        </li>
    @empty
        <li>No projects available.</li>
    @endforelse
</ul>



<table class="table table-bordered">
    <thead>
        <tr>
            <th>Project Name</th>
            <th>Status</th>
            <th>Client Name</th>
            <th>Duration</th>
            <th>Cost</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($projects as $project)
            <tr>
                <td>{{ $project->title }}</td>
                <td>{{ $project->status }}</td>
                <td>{{ $project->client->name ?? 'N/A' }}</td>
                <td>
                    {{ $project->created_at->diffForHumans() }}
                    {{-- Or you can use: $project->created_at->diff(now())->format('%w weeks') --}}
                </td>
                <td>GH₵ {{ number_format($project->cost, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h2 class="mb-4 text-lg font-bold">Recent Projects</h2>

<ul>
    @forelse ($projects as $project)
        <li class="mb-2">
            <strong>{{ $project->title }}</strong><br>
            {{ $project->description ?? 'No description' }}
        </li>
    @empty
        <li>No projects available.</li>
    @endforelse
</ul>
