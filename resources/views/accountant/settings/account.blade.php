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

<div class="space-y-4">
    <div class="bg-white shadow rounded-2xl">
        <div class="grid gap-6 p-6 sm:p-8 sm:grid-cols-2">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-600">Full Name</label>
                <input type="text"
                    value="{{ $employee->name ?? $user->name ?? '—' }}"
                    readonly
                    class="w-full px-4 py-2 text-gray-700 bg-gray-100 border rounded-lg cursor-not-allowed" />
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-600">Email Address</label>
                <input type="text"
                    value="{{ $employee->email ?? $user->email ?? '—' }}"
                    readonly
                    class="w-full px-4 py-2 text-gray-700 bg-gray-100 border rounded-lg cursor-not-allowed" />
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-600">Phone Number</label>
                <input type="text"
                    value="{{ $employee->phone ?? $user->phone_number ?? '—' }}"
                    readonly
                    class="w-full px-4 py-2 text-gray-700 bg-gray-100 border rounded-lg cursor-not-allowed" />
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-600">Account Type</label>
                <input type="text"
                    value="{{ $roles[$user->role] ?? ucfirst(str_replace('_', ' ', $user->role ?? '')) }}"
                    readonly
                    class="w-full px-4 py-2 text-gray-700 bg-gray-100 border rounded-lg cursor-not-allowed" />
            </div>

            <div class="space-y-2 sm:col-span-2">
                <label class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" value="********" readonly
                    class="w-full px-4 py-2 text-gray-700 bg-gray-100 border rounded-lg cursor-not-allowed" />

                @if (session('status'))
                    <p class="text-sm text-green-600">{{ session('status') }}</p>
                @endif

                @error('email')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <form method="POST" action="{{ route('account.password.email') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center mt-2 text-sm font-medium text-fuchsia-900 hover:underline">
                        Reset password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
