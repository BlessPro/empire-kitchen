@php
    $user = auth()->user();
    $employee = $user->employee;
    $roles = [
        'admin' => 'Admin',
        'tech_supervisor' => 'Technical Supervisor',
        'designer' => 'Designer',
        'sales_account' => 'Sales Account',
        'accountant' => 'Accountant',
        'production_officer' => 'Production Officer',
        'installation_officer' => 'Installation Officer',
    ];
@endphp

<div class="mb-6 ml-6">
    <h2 class="text-[18px] font-semibold">Account Information</h2>
    <p class="mt-1 text-sm text-gray-500">Details are read-only for this profile.</p>
    </div>

<div class="p-8 bg-white shadow rounded-2xl">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-600">Full Name</label>
            <input type="text"
                   value="{{ $employee->name ?? $user->name ?? '�?"' }}"
                   readonly
                   class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-700 cursor-not-allowed">
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-600">Email Address</label>
            <input type="text"
                   value="{{ $employee->email ?? $user->email ?? '�?"' }}"
                   readonly
                   class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-700 cursor-not-allowed">
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-600">Phone Number</label>
            <input type="text"
                   value="{{ $employee->phone ?? $user->phone_number ?? '�?"' }}"
                   readonly
                   class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-700 cursor-not-allowed">
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-600">Account Type</label>
            <input type="text"
                   value="{{ $roles[$user->role] ?? ucfirst(str_replace('_', ' ', $user->role ?? '')) }}"
                   readonly
                   class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-700 cursor-not-allowed">
        </div>

        <div class="md:col-span-2">
            <label class="block mb-2 text-sm font-medium text-gray-600">Password</label>
            <input type="password"
                   value="********"
                   readonly
                   class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-700 cursor-not-allowed">
            <p class="mt-2 text-sm text-fuchsia-900">
                <a href="{{ route('password.request') }}" class="hover:underline">Reset password</a>
            </p>
        </div>
    </div>
</div>

