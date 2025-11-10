<!-- User Permissions -->
<h2 class="text-lg font-medium">User Permissions</h2>
<p class="mb-4 text-sm text-gray-500">Manage users who have access to the system</p>

<!-- Table Card -->
<div class="p-6 bg-white shadow rounded-2xl">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-semibold">My Team</h3>

        <button id="openAddUserModal"
            class="px-6 py-2 text-semibold text-sm text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
            Create
        </button>
    </div>
    <p class="mb-4 text-sm text-gray-500">You can manage your team here</p>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-t">
            <thead>
                <tr class="text-sm text-gray-500">
                    <th class="py-2">Staff</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Last Active</th>
                    <th class="py-2">User Role</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>



            <tbody class="text-gray-700">
                @foreach ($users as $user)
                    @php
                        $employee = $user->employee;
                        $avatar = $employee?->avatar_path
                            ? asset('storage/' . ltrim($employee->avatar_path, '/'))
                            : 'https://i.pravatar.cc/30';
                        $lastSeen = $user->last_seen_at;
                        $online = $lastSeen && $lastSeen->gt(now()->subMinutes(5));
                    @endphp
                    <tr class="border-t">
                        <td class="flex items-center text-[15px] py-3 space-x-2">
                            <img src="{{ $avatar }}" class="object-cover w-8 h-8 rounded-full" alt="">
                            <span class="text-[15px]">{{ $employee?->name ?? 'Unknown User' }}</span>
                        </td>
                        <td>
                            @if ($online)
                                <span class="px-2 py-1 text-xs text-green-600 bg-green-100 rounded-full">Online</span>
                            @else
                                <span class="px-2 py-1 text-xs text-gray-600 bg-gray-100 rounded-full">Offline</span>
                            @endif
                        </td>

                        <td class="text-sm text-gray-600">
                            {{ $lastSeen ? $lastSeen->diffForHumans() : 'Never active' }}
                        </td>

                        <td class="text-[15px]">{{ $user->role }}</td>
                        <td class="flex space-x-2">
                            <form action="{{ route('settings.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-gray-500 hover:text-red-500">
                                    <i data-feather="trash" class="mr-3"></i>
                                </button>
                            </form>

                            <button
                                type="button"
                                class="text-gray-500 hover:text-fuchsia-700 btn btn-primary editUserBtn"
                                data-id="{{ $user->id }}"
                                data-name="{{ $employee?->name ?? '' }}"
                                data-role="{{ $user->role }}">
                                <i data-feather="edit-3" class="mr-3"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach

                <!-- Add more rows similarly -->
            </tbody>
        </table>
    </div>



    <div class="mt-4 mb-5 ml-5 mr-5">
        {{ $users->links('pagination::tailwind') }}
    </div>
    <!-- Pagination -->


</div>
</div>



{{-- Add User Modal --}}
<div id="addUserModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50">
    <div class="bg-white rounded-lg p-6 w-[600px] relative">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Create Account</h2>
            <button type="button" id="cancelAddUser" class="p-2 rounded hover:bg-gray-100">
                <i data-feather="x" class="feather-icon"></i>
            </button>
        </div>

        <form id="addUserForm" action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Show validation errors --}}
            @if ($errors->any())
                <div class="p-3 text-sm text-red-700 border border-red-200 rounded-md bg-red-50">
                    <ul class="pl-5 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Employee select --}}
            <div class="flex flex-col gap-4 sm:flex-row">
                <div class="w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Employee</label>
                    <div class="relative">
                        <select name="employee_id"
                            class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="" disabled selected>Select employee</option>
                            @foreach ($employees as $emp)
                                <option value="{{ $emp->id }}">
                                    {{ $emp->name }}{{ $emp->staff_id ? ' — ' . $emp->staff_id : '' }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="absolute w-5 h-5 text-gray-500 -translate-y-1/2 pointer-events-none right-3 top-1/2"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Role select --}}
            <div class="flex flex-col gap-4 sm:flex-row">
                <div class="w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Account Type</label>
                    <div class="relative">
                        <select name="role"
                            class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="" disabled selected>Select account type</option>
                            <option value="admin">Admin</option>
                            <option value="tech_supervisor">Technical Supervisor</option>
                            <option value="designer">Designer</option>
                            <option value="sales_account">Sales Account</option>
                            <option value="accountant">Accountant</option>
                            <option value="production_officer">Production Officer</option>
                            <option value="installation_officer">Installation Officer</option>
                        </select>
                        <svg class="absolute w-5 h-5 text-gray-500 -translate-y-1/2 pointer-events-none right-3 top-1/2"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Passwords --}}
            <div class="flex flex-col gap-4 sm:flex-row">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Re-enter Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
            </div>

            <button type="submit" class="bg-fuchsia-900 w-full text-[20px] text-white px-4 py-2 rounded">
                Save
            </button>
        </form>
    </div>
</div>





<div id="successModal1" tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg">
        <div class="flex items-center justify-center w-10 h-10 mb-[10px] bg-fuchsia-100 rounded-full">
            <i data-feather="edit" class="text-fuchsia-900 ml-[3px]"></i>
        </div>
        <h2 class="mb-4 text-lg font-semibold text-left">User successfully added</h2>

        <!-- Right-Aligned Button -->
        <div class="flex justify-end">
            <button id="successOkBtn1" class="px-4 py-2 text-white rounded-full bg-fuchsia-900">
                OK
            </button>
        </div>
    </div>
</div>
{{-- add user pop up  ends --}}



{{-- user edit pop up --}}
<style>[x-cloak]{display:none!important}</style>

<div id="editUserModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40">
  <div class="w-full max-w-md p-6 bg-white rounded-2xl">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold">Edit User</h3>
      <button type="button" id="euClose" class="text-2xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
    </div>

    <form id="editUserForm"
          method="POST"
          action=""   {{-- set dynamically in JS --}}
          data-action-template="{{ url('/admin/users/__ID__') }}"
          class="mt-4 space-y-4">
      @csrf

      <input type="hidden" id="euUserId" name="id" value="">

      {{-- Full name --}}
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Full name</label>
        <input type="text" id="euName" name="name"
               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-800"
               placeholder="Enter full name" required>
      </div>

      {{-- Role --}}
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Account type</label>
        <select id="euRole" name="role"
                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-800" required>
          <option value="admin">Admin</option>
          <option value="tech_supervisor">Technical Supervisor</option>
          <option value="designer">Designer</option>
          <option value="sales_account">Sales Account</option>
          <option value="accountant">Accountant</option>
          <option value="production_officer">Production Officer</option>
          <option value="installation_officer">Installation Officer</option>
        </select>
      </div>

      {{-- Password reset (optional) --}}
      <div class="p-3 border rounded-xl">
        <div class="mb-2 text-sm font-medium text-gray-700">Reset password</div>
        <div class="grid gap-3">
          <input type="password" id="euPassword" name="password"
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-800"
                 placeholder="New password (leave blank to keep current)">
          <input type="password" id="euPasswordConfirm" name="password_confirmation"
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-800"
                 placeholder="Re-enter new password">
        </div>
        <p class="mt-2 text-xs text-gray-500">Leave both password fields empty to keep existing password.</p>
      </div>

      <div class="flex justify-end gap-3 pt-2">
        <button type="button" id="euCancel" class="px-4 py-2 border rounded-lg">Cancel</button>
        <button type="submit" class="px-4 py-2 text-white rounded-lg bg-fuchsia-900 hover:bg-purple-800">
          Save Changes
        </button>
      </div>
    </form>
  </div>
</div>





<!-- Success Modal -->

<div id="successModal" tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg">
        <div class="flex items-center justify-center w-10 h-10 mb-[10px] bg-fuchsia-100 rounded-full">
            <i data-feather="edit" class="text-fuchsia-900 ml-[3px]"></i>
        </div>
        <h2 class="mb-4 text-lg font-semibold text-left">User successfully updated</h2>

        <!-- Right-Aligned Button -->
        <div class="flex justify-end">
            <button id="successOkBtn" class="px-4 py-2 text-white rounded-full bg-fuchsia-900">
                OK
            </button>
        </div>
    </div>
</div>



{{-- another modal for user edit --}}
<script>
(function(){
  const modal   = document.getElementById('editUserModal');
  const form    = document.getElementById('editUserForm');
  const tpl     = form?.getAttribute('data-action-template') || '';
  const closeBt = document.getElementById('euClose');
  const cancel  = document.getElementById('euCancel');

  const fId     = document.getElementById('euUserId');
  const fName   = document.getElementById('euName');
  const fRole   = document.getElementById('euRole');
  const fPass   = document.getElementById('euPassword');
  const fPass2  = document.getElementById('euPasswordConfirm');

  function show() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
  }
  function hide() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
    // clear sensitive fields
    fPass.value = '';
    fPass2.value = '';
  }

  // Open from any .editUserBtn (event delegation)
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.editUserBtn');
    if (!btn) return;

    e.preventDefault();

    const id   = btn.getAttribute('data-id');
    const name = btn.getAttribute('data-name') || '';
    const role = btn.getAttribute('data-role') || '';

    // Set form action to /admin/users/{id}
    if (tpl && id) form.action = tpl.replace('__ID__', id);

    // Fill fields
    fId.value   = id || '';
    fName.value = name;
    fRole.value = role;

    // If inside a dropdown, close it
    btn.closest('[data-more-menu]')?.classList.add('hidden');

    show();
  });

  // Close handlers
  closeBt?.addEventListener('click', hide);
  cancel?.addEventListener('click', hide);
  modal.addEventListener('click', (e) => { if (e.target === modal) hide(); });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) hide();
  });

  // Optional client-side guard: if one password is filled, require both
  form.addEventListener('submit', (e) => {
    const p1 = fPass.value.trim();
    const p2 = fPass2.value.trim();
    if ((p1 && !p2) || (!p1 && p2)) {
      e.preventDefault();
      alert('Please enter both password fields (or leave both empty).');
    }
  });
})();
</script>





<script>


    // Success Modal OK
    document.getElementById('successOkBtn').addEventListener('click', function() {
        location.reload();
    });


    // });
    document.getElementById('openAddUserModal').addEventListener('click', function() {
        document.getElementById('addUserModal').classList.remove('hidden');
    });
    // for the close (X) button
    document.getElementById('cancelAddUser').addEventListener('click', function() {
        document.getElementById('addUserModal').classList.add('hidden');
    });



    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate password
        const form = e.target;
        const formData = new FormData(form);

        fetch("{{ route('admin.users.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json' // Tell Laravel you want JSON
                },
                body: formData,
            })
            .then(async response => {
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Validation failed');
                }
                return response.json();
            })
            .then(data => {

                // document.getElementById('successModal').classList.remove('hidden');
                // // Optionally refresh data here
                if (data)
                    console.log(data);
                {

                    document.getElementById('addUserModal').classList.add('hidden');
                    document.getElementById('successModal1').classList.remove('hidden');

                    //  alert('Project created successfully!');

                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
    });


    //reloading the page
    document.getElementById('successOkBtn1').addEventListener('click', function() {
        document.getElementById('successModal1').classList.add('hidden');
        location.reload(); // refresh to update the table
    });
</script>
