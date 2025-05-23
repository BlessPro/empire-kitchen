<x-tech-layout>
    <x-slot name="header">
        @include('admin.layouts.header')
    </x-slot>
          <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class=" bg-[#F9F7F7] items-center">
             <div class="mb-[20px] items-center">

{{-- navigation bar --}}
   <div class="flex items-center justify-between mb-6">
    <div class="flex items-center justify-between mb-6">
     <span><i data-feather="home" class="w-[5] h-[5] text-fuchsia-900 ml-[3px]"></i></span>
     <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
     <a href="{{ route('tech.ClientManagement') }}">
        <h3 class="font-sans font-normal text-black cursor-pointer hover:underline">Clients Management</h3>
    </a>

         {{-- <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span> --}}
        </h3>
        {{-- <span><span class="mr-[12px] font-normal text-black-900">{{$project->client->title . ' '.$project->client->firstname . ' '.$project->client->lastname }}</span> </span> --}}
        <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
        <h3 class="font-semibold text-fuchsia-900">Add Measurement</h3>

    </div>


 <!-- Top Navbar -->

 <button type="submit"
     id="openMeasurementModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
     Save Measurement
 </button>

     </div>

        {{--body--}}
            <div class="  p-6 bg-white rounded-2xl shadow-md space-y-8">
              <!-- Space Dimensions -->
              <div>
                <h2 class="text-lg font-semibold text-purple-800 mb-4">Space Dimensions</h2>
                <h2 class="text-lg font-semibold text-purple-800 mb-4"> {{ $project->name}}</h2>


                {{-- <form action="{{ route('measurements.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <!-- existing fields -->
              <input type="text" name="length" ... >
              <input type="text" name="height" ... >
              <input type="text" name="width" ... >

              <textarea name="notes" ...></textarea>

              <input type="file" name="images[]" multiple>

              <input type="radio" name="has_obstruction" value="yes">
              <input type="radio" name="has_obstruction" value="no">

              <textarea name="obstacles" ...></textarea>

              <button type="submit">Save Measurement</button>
            </form> --}}
{{-- action="{{ route('measurements.store') }}" method="POST" enctype="multipart/form-data" --}}

{{-- @if ($errors->any())
    <div class="text-red-500 bg-red-100 p-2 mb-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}


<form action="{{ route('tech.measurements.store') }}" method="POST" enctype="multipart/form-data">
   @csrf
               {{-- <input type="hidden" name="project_id" value="36"> --}}
               {{-- <input type="hidden" name="project_id" value="{{ $project->id }}"> --}}
    <input type="hidden" name="project_id" value="{{ request('project') }}">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>

        <label  class="block text-sm font-medium text-gray-700 mb-1">Length (in meters/feet)</label>
        <input type="text" name="length" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Height (in meters/feet)</label>
        <input type="text" name="height" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Width (in meters/feet)</label>
        <input type="text" name="width" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" />
      </div>
    </div>

    <!-- Notes -->
    <div class="mt-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes on Measurements</label>
      <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
    </div>
  </div>

  <!-- Site Photos -->
  <div>
    <h2 class="text-lg font-semibold text-purple-800 mb-4">Site Photos</h2>
    {{-- <div class="flex items-center justify-center border-2 border-dashed border-purple-600 rounded-xl p-6 text-center">
      <div>
        <svg class="mx-auto text-purple-600" width="24" height="24" fill="currentColor"><path d="..."/></svg>
        <p class="mt-2 text-sm"><span class="font-semibold text-purple-700 cursor-pointer">Click here</span> to upload your file or drag and drop here.</p>
        <p class="text-xs text-gray-500 mt-1">Supported Format: SVG, JPG, PNG (10mb each)</p>
      </div>
    </div> --}}
            <div onclick="document.getElementById('account_profile_input').click()"
            class="    border-purple-600  p-6  flex items-center justify-center
             flex-1 h-32 text-center text-gray-500 border-2 border-dashed cursor-pointer rounded-xl hover:bg-gray-50">
            <div>
              <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="..."/></svg>
              <p><span class="font-medium text-purple-600">Click here</span> to upload your file or drag.</p>
              <p class="mt-1 text-xs text-gray-400">Supported format: SVG, JPG, PNG (10MB each)</p>
            </div>
            {{-- <input type="file" name="profile_pic" id="account_profile_input" class="hidden" onchange="previewProfile(event)"> --}}
            <input type="file" name="images[]" id="account_profile_input" class="hidden" multiple onchange="previewProfile(event)">

          </div>
  </div>


  <!-- Obstruction Description -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
      Description of site conditions (e.g., obstacles, required modifications, access limitations):
    </label>
    <textarea name="obstacles" rows="3" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
  </div>
   <button type="submit"
     id="openMeasurementModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
     Save Measurement
 </button>
  </form>

</div>

            </div>
        </main>
</x-tech-layout>
