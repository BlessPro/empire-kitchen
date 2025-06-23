@forelse($clients as $client)
<tr>
    <td class="border px-3 py-2">{{ $client->firstname }} {{ $client->lastname }}</td>
    <td class="border px-3 py-2">{{ $client->email }}</td>
    <td class="border px-3 py-2">{{ $client->phone_number }}</td>
    <td class="border px-3 py-2">{{ $client->location }}</td>
    <td class="border px-3 py-2">{{ $client->created_at->format('d M, Y') }}</td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center py-4">No clients found.</td>
</tr>
@endforelse
