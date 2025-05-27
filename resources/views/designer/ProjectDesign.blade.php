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



{{--
<form action="{{ route('design.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="project_id">Select Project:</label>
    <select name="project_id" required>
        <option value="">-- Choose Project --</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>


    <label for="images">Upload Images (you can select more than one):</label>
    <input type="file" name="images[]" id="images" multiple required>


    <label for="notes">Description (optional):</label>
    <textarea name="notes" rows="4"></textarea>

    <button type="submit">Submit Design</button>
</form> --}}

{{-- new form --}}



 <div class="bg-white p-8 rounded-[20px] shadow-md w-full max-w-2xl mx-auto">
      <h1 class="text-xl font-bold mb-6">Upload Designs</h1>

                @if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="{{ route('design.store') }}" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
        @csrf
          <label class="block text-sm font-medium mb-2">Select the project for your design upload</label>
         
          <select class="w-full border rounded px-4 py-2" required>
        <option value="">-- Choose Project --</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>
        </div>

        <div class="border-dashed border-2 border-gray-300 p-6 text-center rounded-lg bg-gray-50">
            <input type="file" name="images[]"  id="images" class="hidden" multiple required>


            {{-- <input type="file" name="images[]" multiple class="hidden" id="fileUpload" /> --}}
          <label for="images" class="cursor-pointer">
            <div class="text-purple-700 font-bold">Click here</div>
            <div class="text-sm text-gray-500">to upload your file or drag.</div>
            <div class="text-xs mt-1">Supported Format: SVG, JPG, PNG (10mb each)</div>
          </label>
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Description (if any)</label>
          <textarea name="notes" rows="4" placeholder="Start typing here" class="w-full border rounded px-4 py-2"></textarea>

           {{-- <textarea name="notes" rows="4"></textarea> --}}

        </div>

        <div class="text-center">
          {{-- <button type="submit" class="bg-fuchsia-900 hover:bg-purple-800 text-white px-6 py-2 rounded-full flex items-center justify-center space-x-2">
            <span>Upload</span>
          </button> --}}
              <button class="bg-fuchsia-900 hover:bg-purple-800 text-white px-6 py-2
               rounded-full flex items-center justify-center space-x-2" type="submit">Submit Design</button>

        </div>
      </form>
    </div>
                </div>
</div>


</main>



</x-Designer-layout>


