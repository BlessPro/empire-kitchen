<x-guest-layout>
    <div class="max-w-md mx-auto text-center space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Password Updated</h1>
            <p class="mt-2 text-sm text-gray-500">
                Your password has been reset successfully. You can now sign in with your new credentials.
            </p>
        </div>

        <div>
            <a href="{{ route('login') }}"
               class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Proceed to Dashboard
            </a>
        </div>
    </div>
</x-guest-layout>
