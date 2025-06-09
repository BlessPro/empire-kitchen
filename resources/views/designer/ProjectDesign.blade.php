<!-- Example for designer -->
   <x-Designer-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Designer Dashboard') }}
        </h2>

@include('admin.layouts.header')

    </x-slot>
        <main class="ml-64 mt-[50px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">

   {{-- navigation bar --}}
   <div class="flex items-center justify-between">

    <div class="flex items-center justify-between mb-6">
      <h1 class="mb-6 text-xl font-semibold">Upload Designs</h1>
    </div>
     <!-- ADD CLIENT BUTTON -->
     <a href="{{ route('designer.designs.viewuploads') }}">
     <button id="" class="px-6 py-2 text-semibold text-[15px] text-white rounded-[10px] bg-fuchsia-900 hover:bg-[#F59E0B]">
         View Upload
     </button>
    </a>
     </div>


 <div class=" w-[450px] items-center justify-center mx-auto">

                @if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="{{ route('design.store') }}" method="POST" enctype="multipart/form-data">
        {{-- <div class="mb-4">
        @csrf
          <label class="block mb-3 text-sm font-medium">Select the project for your design upload</label>

          <select class="w-full border-gray-200 rounded-[10px] px-4 py-2 mb-6" required>
        <option value="">-- Choose Project --</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select> --}}
        {{-- </div> --}}


{{--testing--}}
<div x-data="projectDropdown()" class="relative w-full mb-4">
    @csrf
    <label class="block mb-3 text-sm font-medium">Select the project for your design upload</label>

    <div class="relative">
        <input
            type="text"
            x-model="search"
            @focus="open = true"
            @click="open = true"
            @input="watchSearch()" <!-- triggers dropdown if empty --
            @keydown.escape="open = false"
            @keydown.arrow-down.prevent="focusNext()"
            @keydown.arrow-up.prevent="focusPrev()"
            placeholder="-- Search or select project --"
            class="w-full border-gray-200 rounded-[10px] px-4 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >

        <!-- Optional clear button -->
        <button type="button"
            @click="clearSelection"
            x-show="selectedId || search"
            class="absolute text-xl text-gray-400 right-3 top-2 hover:text-red-500"
        >
            &times;
        </button>

        <ul
            x-show="open"
            @click.away="open = false"
            class="absolute z-10 w-full mt-1 overflow-y-auto bg-white border border-gray-200 rounded-md shadow-lg max-h-60"
        >
            <template x-for="(project, index) in filteredProjects" :key="project.id">
                <li
                    :class="{'bg-blue-100': index === focusedIndex}"
                    @click="selectProject(project)"
                    @mouseenter="focusedIndex = index"
                    class="px-4 py-2 cursor-pointer hover:bg-blue-100"
                    x-text="project.name"
                ></li>
            </template>
            <li x-show="filteredProjects.length === 0" class="px-4 py-2 text-gray-500">No projects found.</li>
        </ul>

        <!-- Hidden input to actually submit selected project ID -->
        <input type="hidden" name="project_id" :value="selectedId">
    </div>
</div>



{{--testing--}}


        <div class="border-dashed border-2 border-gray-300 p-[40px] text-center rounded-[10px] mb-5  bg-white">
            <input type="file" name="images[]"  id="images" class="hidden" multiple required>
            {{-- <input type="file" name="images[]" multiple class="hidden" id="fileUpload" /> --}}
          <label for="images" class="items-center cursor-pointer">
            {{-- <div class="items-center font-bold text-purple-700"> <span class="bg-blue-900 rounded-full"><i data-feather="upload-cloud"> </i> </span></div> --}}
            <div class="mb-5 font-bold text-purple-700">Click here</div>
            <div class="mb-2 text-sm text-gray-500">to upload your file or drag.</div>
            <div class="mt-1 text-xs">Supported Format: SVG, JPG, PNG (10mb each)</div>
          </label>

        </div>

        <div>
          <label class="block mb-2 text-sm font-medium">Description (if any)</label>
          <textarea name="notes" rows="6" placeholder="Start typing here" class="w-full border-gray-200 rounded-[10px] px-4 py-2 bg-white"></textarea>

           {{-- <textarea name="notes" rows="4"></textarea> --}}

        </div>

        <div class="flex items-center justify-center mx-auto mt-4 text-center">

              <button class=" bg-fuchsia-900 hover:bg-purple-800 text-white px-6 py-2
               rounded-[10px] flex items-center justify-center space-x-2"
                type="submit"> <i class="w-4 h-4 mr-2 text-white" data-feather="upload"> </i> Submit Design</button>

        </div>
      </form>
    </div>



{{-- <script>
    function projectDropdown() {
        return {
            open: false,
            search: '',
            selectedId: '',
            selectedName: '',
            focusedIndex: -1,
            projects: @json($projects),
            filteredProjects() {
                return this.projects.filter(p =>
                    p.name.toLowerCase().includes(this.search.toLowerCase())
                );
            },
            selectProject(project) {
                this.selectedId = project.id;
                this.selectedName = project.name;
                this.search = project.name;
                this.open = false;
            },
            focusNext() {
                if (this.focusedIndex < this.filteredProjects().length - 1) {
                    this.focusedIndex++;
                }
            },
            focusPrev() {
                if (this.focusedIndex > 0) {
                    this.focusedIndex--;
                }
            }
        }
    }
</script> --}}
<script>
    function projectDropdown() {
        return {
            open: false,
            search: '',
            selectedId: '',
            selectedName: '',
            focusedIndex: -1,
            projects: @json($projects),

            get filteredProjects() {
                const term = this.search.toLowerCase();
                return this.projects.filter(p =>
                    p.name.toLowerCase().includes(term)
                );
            },

            selectProject(project) {
                this.selectedId = project.id;
                this.selectedName = project.name;
                this.search = project.name;
                this.open = false;
            },

            watchSearch() {
                if (this.search === '') {
                    this.open = true; // Show dropdown again
                    this.selectedId = '';
                    this.selectedName = '';
                }
            },

            clearSelection() {
                this.search = '';
                this.selectedId = '';
                this.selectedName = '';
                this.open = true;
                this.focusedIndex = -1;
            },

            focusNext() {
                if (this.focusedIndex < this.filteredProjects.length - 1) {
                    this.focusedIndex++;
                }
            },

            focusPrev() {
                if (this.focusedIndex > 0) {
                    this.focusedIndex--;
                }
            }
        }
    }
</script>
                </div>
</div>


</main>



</x-Designer-layout>


