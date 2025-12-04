<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-6 w-full">
        @csrf

        @php
            $emailFromRequest = request()->input('email');
            $email = $emailFromRequest ?? old('email', $request->email);
        @endphp
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="email" value="{{ $email }}">

        @if ($errors->get('email'))
            <p class="text-sm text-red-600">{{ $errors->first('email') }}</p>
        @endif

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Enter Password</label>
            <div class="relative mt-1">
                <input id="password"
                       type="password"
                       name="password"
                       autocomplete="new-password"
                       required
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10">
                <button type="button"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500"
                        data-toggle-password="password"
                        aria-label="Toggle password visibility">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <div class="relative mt-1">
                <input id="password_confirmation"
                       type="password"
                       name="password_confirmation"
                       autocomplete="new-password"
                       required
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10">
                <button type="button"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500"
                        data-toggle-password="password_confirmation"
                        aria-label="Toggle password visibility">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center bg-[#5A0562] hover:bg-[#4a044c]">
            {{ __('Save Password') }}
        </x-primary-button>

        <p class="text-sm text-gray-600 text-center">
            After saving, you should be redirected to login. If not, use this link:
            <a href="{{ route('login') }}" class="text-fuchsia-900 hover:underline">Back to login</a>
        </p>
    </form>

    <script>
        document.querySelectorAll('[data-toggle-password]').forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-toggle-password');
                const input = document.getElementById(targetId);
                if (!input) return;

                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                button.classList.toggle('text-indigo-600', show);
            });
        });
    </script>
</x-guest-layout>
