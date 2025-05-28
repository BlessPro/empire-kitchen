<!-- Example for designer -->
   <x-Designer-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Designer Dashboard') }}
        </h2>
    </x-slot>
        <main class="ml-64 mt-[50px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">

   {{-- navigation bar --}}
   <div class="flex items-center justify-between">

    <div class="flex items-center justify-between mb-6">
      <h1 class="text-xl font-bold mb-6">Upload Designs</h1>
    </div>
     <!-- ADD CLIENT BUTTON -->
     <button id="" class="px-6 py-2 text-semibold text-[15px] text-white rounded-[10px] bg-fuchsia-900 hover:bg-[#F59E0B]">
         View Upload
     </button>
     </div>


 <div class=" w-[450px] items-center justify-center mx-auto">

                @if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="{{ route('design.store') }}" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
        @csrf
          <label class="block text-sm font-medium mb-3">Select the project for your design upload</label>

          <select class="w-full border-gray-200 rounded-[10px] px-4 py-2 mb-6" required>
        <option value="">-- Choose Project --</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>
        </div>

        <div class="border-dashed border-2 border-gray-300 p-[40px] text-center rounded-[10px] mb-5  bg-white">
            <input type="file" name="images[]"  id="images" class="hidden" multiple required>
            {{-- <input type="file" name="images[]" multiple class="hidden" id="fileUpload" /> --}}
          <label for="images" class="cursor-pointer items-center">
            {{-- <div class="text-purple-700 font-bold items-center"> <span class="bg-blue-900 rounded-full"><i data-feather="upload-cloud"> </i> </span></div> --}}
            <div class="text-purple-700 font-bold mb-5">Click here</div>
            <div class="text-sm text-gray-500 mb-2">to upload your file or drag.</div>
            <div class="text-xs mt-1">Supported Format: SVG, JPG, PNG (10mb each)</div>
          </label>
        </div>

        <div>
          <label class="block text-sm font-medium mb-2">Description (if any)</label>
          <textarea name="notes" rows="6" placeholder="Start typing here" class="w-full border-gray-200 rounded-[10px] px-4 py-2 bg-white"></textarea>

           {{-- <textarea name="notes" rows="4"></textarea> --}}

        </div>

        <div class="flex text-center items-center justify-center mx-auto mt-4">

              <button class=" bg-fuchsia-900 hover:bg-purple-800 text-white px-6 py-2
               rounded-[10px] flex items-center justify-center space-x-2"
                type="submit"> <i class="text-white w-4 h-4 mr-2" data-feather="upload"> </i> Submit Design</button>

        </div>
      </form>
    </div>
                </div>
</div>


</main>



</x-Designer-layout>


