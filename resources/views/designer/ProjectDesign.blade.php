<!-- Example for designer -->
   <x-Designer-layout>
    <div class="p-6 text-gray-900">Welcome designer!</div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Designer Dashboard') }}
        </h2>
    </x-slot>
        <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">



                @if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="{{ route('design.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="project_id">Select Project:</label>
    <select name="project_id" required>
        <option value="">-- Choose Project --</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>

    <label for="images">Upload Images:</label>
    <input type="file" name="images[]" multiple required>

    <label for="notes">Description (optional):</label>
    <textarea name="notes" rows="4"></textarea>

    <button type="submit">Submit Design</button>
</form>


                </div>
</div>
</main>
</x-Designer-layout>


