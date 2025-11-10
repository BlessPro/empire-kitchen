<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')
    </x-slot>

    <div class="p-4 sm:p-6 bg-[#F9F7F7] min-h-screen">
            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Edit Client</h1>
                        <p class="mt-1 text-sm text-gray-500">Update the client information and save your changes.</p>
                    </div>
                    <a href="{{ route('admin.ClientManagement') }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 border border-gray-200 rounded-full hover:bg-gray-50">
                        Cancel
                    </a>
                </div>

                @if ($errors->any())
                    <div class="p-4 mt-6 rounded-xl bg-red-50 text-sm text-red-600">
                        Please fix the errors below before submitting the form.
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('clients.update', $client->id) }}"
                      class="mt-6 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title"
                                   value="{{ old('title', $client->title) }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Other Names</label>
                            <input type="text" name="othernames"
                                   value="{{ old('othernames', $client->othernames) }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('othernames') border-red-500 @enderror">
                            @error('othernames')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="firstname"
                                   value="{{ old('firstname', $client->firstname) }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('firstname') border-red-500 @enderror">
                            @error('firstname')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="lastname"
                                   value="{{ old('lastname', $client->lastname) }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('lastname') border-red-500 @enderror">
                            @error('lastname')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phone_number"
                                   value="{{ old('phone_number', $client->phone_number) }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('phone_number') border-red-500 @enderror">
                            @error('phone_number')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Other Phone</label>
                            <input type="tel" name="other_phone"
                                   value="{{ old('other_phone', $client->other_phone) }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('other_phone') border-red-500 @enderror">
                            @error('other_phone')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Contact Person</label>
                            <input type="text" name="contact_person"
                                   value="{{ old('contact_person', $client->contact_person) }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('contact_person') border-red-500 @enderror">
                            @error('contact_person')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Contact Phone</label>
                            <input type="tel" name="contact_phone"
                                   value="{{ old('contact_phone', $client->contact_phone) }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('contact_phone') border-red-500 @enderror">
                            @error('contact_phone')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location"
                                   value="{{ old('location', $client->location) }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('location') border-red-500 @enderror">
                            @error('location')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $client->email) }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" rows="3"
                                      class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562] focus:outline-none @error('address') border-red-500 @enderror">{{ old('address', $client->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-end gap-3">
                        <a href="{{ route('admin.ClientManagement') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-6 py-2 text-sm font-semibold text-white rounded-lg bg-[#5A0562] hover:bg-[#430349]">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
</x-layouts.app>
