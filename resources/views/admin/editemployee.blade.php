<x-layouts.app>
  <x-slot name="header">
    @include('admin.layouts.header')
  </x-slot>

  <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen items-center">
    <div class="p-6 bg-[#F9F7F7]">
      @include('admin.partials.employee-form', ['employee' => $employee])
    </div>
  </main>
</x-layouts.app>
