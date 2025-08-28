<table class="min-w-full text-left">
    <thead class="text-sm text-gray-600 bg-gray-100">
      <tr>
        {{-- <th class="p-4 font-medium">
          <input type="checkbox" id="selectAll" />
        </th> --}}
        <th class="p-4 font-mediumt text-[15px]">Client Name</th>
        <th class="p-4 font-mediumt text-[15px]">Location</th>
        <th class="p-4 font-mediumt text-[15px]">status</th>
      </tr>
    </thead>
<!-- Add other columns as needed -->
</tr>
</thead>
<tbody>
@foreach($projects as $project)
<tr class="border-t hover:bg-gray-50">
   {{-- <td class="p-4"><input type="checkbox" class="child-checkbox" /></td> --}}
   {{-- <td class="p-4 font-normal text-[15px]">{{ $project->name }}</td> --}}
      <td  class="px-3 py-1 text-sm ">{{ $project->client->firstname . ' ' . $project->client->lastname}}</td>
      <td  class="px-3 py-1 text-sm ">{{ $project->client->location}}</td>
      <td class="p-4">
       <span class="px-3 py-1 text-sm {{ $statusClasses[$project->status] ?? $defaultClass }}">{{ $project->status }}</span>
   </td>

</tr>
@endforeach

</table>
