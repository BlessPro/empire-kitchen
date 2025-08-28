                <table class="min-w-full text-left">
                        <thead class="items-center text-sm text-gray-600 bg-gray-100">
                            <tr>
                                {{-- <th class="p-4 font-medium text-[15px]">#</th> --}}
                                <th class="p-4 font-medium text-[15px]">Client</th>
                                <th class="p-4 font-medium text-[15px]">Project</th>
                                <th class="p-4 font-medium text-[15px]">Location</th>
                                <th class="p-4 font-medium text-[15px]">Status</th>
                                {{-- <th class="p-4 font-mediumt  font-medium text-[15px]">Action</th> --}}
                            </tr>
                        </thead>

                        <tbody class="text-gray-700 divide-y divide-gray-100">
                            @forelse($projects as $i => $p)
                                <tr
                                    class=" text-sm  border-t hover:bg-gray-50 {{ $p->booked_status === 'BOOKED' ? 'bg-white' : 'bg-white' }}">
                                    {{-- <td class="p-4">{{ $projects->firstItem() + $i }}</td> --}}
                                    <td class="p-4">

                                        <span class="font-normal text-[15px]">
                                            {{ $p->client->firstname. ' '. $p->client->lastname ?? '—' }}
                                        </span>

                                    </td>

                                    <td class="p-4">
                                        <span class="font-normal text-[15px]">
                                            {{ $p->name }}
                                        </span>
                                    </td>

                                    <td class="p-4">
                                        <span class="font-normal text-[15px]">
                                            {{ $p->location }}
                                        </span>
                                    </td>

                                    <td class="p-4">
                                        <span
                                            class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                                        {{ $p->booked_status === 'BOOKED' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $p->booked_status }}
                                        </span>
                                    </td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        No projects found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
