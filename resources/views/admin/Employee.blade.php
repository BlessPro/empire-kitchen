<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')

    </x-slot>

    <main class="ml-[280px] mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Employees</h1>
                    <a href="{{ route('admin.Employee') }}" class="hidden"></a>
                </div>
                <a href="addemployee">
                    <button
                        class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                        + Add Employee
                    </button>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="px-6 py-4">
                    <p class="text-gray-600">Manage all employees</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-6 py-3">Full Name</th>
                                <th class="px-6 py-3">Position</th>
                                <th class="px-6 py-3">Phone</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3 text-right">More</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($employees as $e)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-3">
                                            @php $avatar = $e->avatar_path ? asset('storage/'.$e->avatar_path) : asset('images/default-avatar.png'); @endphp
                                            <img src="{{ $avatar }}" class="w-9 h-9 rounded-full object-cover"
                                                alt="">
                                            <span class="font-medium text-gray-900">{{ $e->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3">{{ $e->designation }}</td>
                                    <td class="px-6 py-3">
                                        @if ($e->phone)
                                            <a href="tel:{{ $e->phone }}"
                                                class="text-fuchsia-900 hover:underline">{{ $e->phone }}</a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3">
                                        @if ($e->email)
                                            <a href="mailto:{{ $e->email }}"
                                                class="text-fuchsia-900 hover:underline">{{ $e->email }}</a>
                                        @endif
                                    </td>

                                    {{-- More (three-dot) --}}
                                    <td class="px-6 py-3 text-right relative" x-data="{ open: false }">
                                        <button @click="open = !open" class="p-2 rounded hover:bg-gray-100">
                                            <iconify-icon icon="mdi:dots-vertical"></iconify-icon>
                                        </button>

                                        <div x-show="open" x-cloak @click.away="open=false"
                                            class="absolute z-10 right-6 mt-2 w-48 bg-white border rounded-xl shadow-lg">
                                            {{-- <a href="{{ route('employees.edit', $e->id) }}"
                         class="block w-full text-left px-4 py-2 hover:bg-gray-50">Edit Employee</a> --}}
                                            <a href="{{ route('admin.editemployee', $e->id) }}"
                                                class="block w-full text-left px-4 py-2 hover:bg-gray-50">Edit
                                                Employee</a>


                                            <button class="block w-full text-left px-4 py-2 hover:bg-gray-50"
                                                onclick="openBiodataModal(this)" data-fullname="{{ $e->name }}"
                                                data-designation="{{ $e->designation }}"
                                                data-phone="{{ $e->phone }}" data-email="{{ $e->email }}"
                                                data-nationality="{{ $e->nationality }}"
                                                data-dob="{{ $e->dob }}" data-hometown="{{ $e->hometown }}"
                                                data-language="{{ $e->language }}" data-address="{{ $e->address }}"
                                                data-gps="{{ $e->gps }}" data-nok="{{ $e->next_of_kin }}"
                                                data-relation="{{ $e->relation }}"
                                                data-nokphone="{{ $e->nok_phone }}" data-bank="{{ $e->bank }}"
                                                data-branch="{{ $e->branch }}"
                                                data-account="{{ $e->account_number }}"
                                                data-commenced="{{ $e->commencement_date }}"
                                                data-avatar="{{ $avatar }}">
                                                View Biodata
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-6 text-center text-gray-500">No employees found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4">
                    {{ $employees->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </main>

    {{-- Biodata Modal --}}
    <div id="biodataModal" class="fixed inset-0 z-[140] hidden items-center justify-center bg-black/40">
        <div class="w-full max-w-2xl p-6 bg-white rounded-2xl shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <img id="bio_avatar" class="w-12 h-12 rounded-full object-cover" src="" alt="">
                    <div>
                        <h3 id="bio_name" class="text-lg font-semibold"></h3>
                        <p id="bio_designation" class="text-sm text-gray-600"></p>
                    </div>
                </div>
                <button type="button" onclick="closeBiodataModal()"
                    class="text-gray-500 hover:text-gray-700">✕</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-sm">
                <div><span class="text-gray-500">Phone:</span> <span id="bio_phone" class="ml-2"></span></div>
                <div><span class="text-gray-500">Email:</span> <span id="bio_email" class="ml-2"></span></div>
                <div><span class="text-gray-500">Nationality:</span> <span id="bio_nationality" class="ml-2"></span>
                </div>
                <div><span class="text-gray-500">Date of Birth:</span> <span id="bio_dob" class="ml-2"></span></div>
                <div><span class="text-gray-500">Hometown:</span> <span id="bio_hometown" class="ml-2"></span></div>
                <div><span class="text-gray-500">Language:</span> <span id="bio_language" class="ml-2"></span>
                </div>
                <div class="md:col-span-2"><span class="text-gray-500">Address:</span> <span id="bio_address"
                        class="ml-2"></span></div>
                <div><span class="text-gray-500">GPS:</span> <span id="bio_gps" class="ml-2"></span></div>
                <div><span class="text-gray-500">Commencement Date:</span> <span id="bio_commenced"
                        class="ml-2"></span></div>

                <div class="mt-2 md:col-span-2 border-t pt-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3">
                        <div><span class="text-gray-500">Next of Kin:</span> <span id="bio_nok"
                                class="ml-2"></span></div>
                        <div><span class="text-gray-500">Relation:</span> <span id="bio_relation"
                                class="ml-2"></span></div>
                        <div><span class="text-gray-500">NOK Phone:</span> <span id="bio_nokphone"
                                class="ml-2"></span></div>
                    </div>
                </div>

                <div class="mt-2 md:col-span-2 border-t pt-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-3">
                        <div><span class="text-gray-500">Bank:</span> <span id="bio_bank" class="ml-2"></span>
                        </div>
                        <div><span class="text-gray-500">Branch:</span> <span id="bio_branch" class="ml-2"></span>
                        </div>
                        <div><span class="text-gray-500">Account #:</span> <span id="bio_account"
                                class="ml-2"></span></div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeBiodataModal()"
                    class="px-4 py-2 border rounded-lg">Close</button>
            </div>
        </div>
    </div>

    {{-- Modal JS --}}
    <script>
        const bioModal = document.getElementById('biodataModal');

        function openBiodataModal(btn) {
            // Fill fields from data-* attributes
            const get = (k) => btn.getAttribute('data-' + k) || '';

            document.getElementById('bio_avatar').src = get('avatar');
            document.getElementById('bio_name').textContent = get('fullname');
            document.getElementById('bio_designation').textContent = get('designation');

            document.getElementById('bio_phone').textContent = get('phone');
            document.getElementById('bio_email').textContent = get('email');
            document.getElementById('bio_nationality').textContent = get('nationality');
            document.getElementById('bio_dob').textContent = get('dob');
            document.getElementById('bio_hometown').textContent = get('hometown');
            document.getElementById('bio_language').textContent = get('language');
            document.getElementById('bio_address').textContent = get('address');
            document.getElementById('bio_gps').textContent = get('gps');
            document.getElementById('bio_commenced').textContent = get('commenced');

            document.getElementById('bio_nok').textContent = get('nok');
            document.getElementById('bio_relation').textContent = get('relation');
            document.getElementById('bio_nokphone').textContent = get('nokphone');

            document.getElementById('bio_bank').textContent = get('bank');
            document.getElementById('bio_branch').textContent = get('branch');
            document.getElementById('bio_account').textContent = get('account');

            // Open
            bioModal.classList.remove('hidden');
            bioModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeBiodataModal() {
            bioModal.classList.add('hidden');
            bioModal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (!bioModal.classList.contains('hidden') && e.key === 'Escape') closeBiodataModal();
        });

        // Backdrop click closes
        bioModal.addEventListener('click', (e) => {
            if (e.target === bioModal) closeBiodataModal();
        });
    </script>
</x-layouts.app>
