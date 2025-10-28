@php
    $user = auth()->user();
    $employee = $user->employee;
    $roles = [
        'admin' => 'Admin',
        'tech_supervisor' => 'Technical Supervisor',
        'designer' => 'Designer',
        'sales_accountant' => 'Sales Accountant',
        'accountant' => 'Accountant',
        'production_officer' => 'Production Officer',
        'installation_officer' => 'Installation Officer',
    ];
@endphp

<div class="items-center justify-between mb-4">
    <div>
        <h2 class="mb-2 ml-6 text-[18px] font-semibold">Personal Information</h2>
        <p class="mb-3 ml-6 text-sm text-gray-500">Update the details tied to your account.</p>
    </div>
</div>

<form id="accountForm" action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <div class="p-8 bg-white shadow rounded-2xl">
        @if ($errors->any())
            <div class="p-3 mb-4 text-sm text-red-700 border border-red-200 rounded-md bg-red-50">
                <ul class="pl-5 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-2">
            <div>
                <label class="block mb-1 text-sm font-medium">Full Name</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $employee->name ?? '') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-800 focus:border-fuchsia-800"
                    required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Email Address</label>
                <input type="email" name="email" id="email"
                    value="{{ old('email', $employee->email ?? '') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-800 focus:border-fuchsia-800"
                    required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Phone Number</label>
                <input type="text" name="phone" id="phone"
                    value="{{ old('phone', $employee->phone ?? '') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-800 focus:border-fuchsia-800"
                    required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Role</label>
                <select name="role" id="role"
                    class="w-full px-4 py-2 border rounded-lg bg-white focus:ring-2 focus:ring-fuchsia-800 focus:border-fuchsia-800"
                    required>
                    @foreach ($roles as $value => $label)
                        <option value="{{ $value }}" @selected(old('role', $user->role) === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">New Password</label>
                <input type="password" name="password" id="password"
                    placeholder="Leave blank to keep current password"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-800 focus:border-fuchsia-800">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-fuchsia-800 focus:border-fuchsia-800">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">New Inputs</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-50 text-gray-500" readonly value="Coming soon">
            </div>
        </div>

        <div class="flex justify-end mt-8 space-x-4">
            <button type="submit" class="px-6 py-2 text-white rounded-lg bg-fuchsia-900 hover:bg-fuchsia-800">Save Changes</button>
        </div>
    </div>
</form>
