 {{-- Add Product Modal --}}
    <div id="addProductModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/30 p-4">
        <div class="w-full max-w-md rounded-2xl bg-white shadow-lg">
            <div class="flex items-center justify-between border-b px-4 py-3">
                <h3 class="text-sm font-semibold text-gray-900">Add new product</h3>
                <button type="button" id="apmClose" class="p-2 hover:bg-gray-50 rounded-lg">
                    <span class="iconify" data-icon="ph:x"></span>
                </button>
            </div>

            <form id="addProductForm" class="px-4 py-4 space-y-3">
                {{-- Project select --}}
               {{-- Project (read-only) --}}
                <div>
                  <label class="block text-sm font-medium text-gray-700">Project</label>
                  <div class="mt-1">
                    <span id="apmProjectLabel" class="text-sm font-semibold text-gray-900"></span>
                  </div>
                  <input type="hidden" id="apmProjectHidden" name="project_id" value="">
                </div>
                

                {{-- Product Type (static list you control) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Type</label>
                    <select id="apmType"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-fuchsia-600 focus:border-fuchsia-600"
                        required>
                        <option value="" selected disabled>Select type…</option>
                        @foreach (['Kitchen', 'Wardrobe', 'Bathroom', 'TV Unit', 'Office'] as $type)
                            <option value="{{ $type }}"> {{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Optional name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Name (optional)</label>
                    <input type="text" id="apmName"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-fuchsia-600 focus:border-fuchsia-600"
                        placeholder="e.g., Tetteh’s Kitchen (Island)">
                </div>



                <p id="apmErr" class="hidden text-sm text-red-600"></p>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" id="apmCancel"
                        class="px-3 py-1.5 rounded-lg border border-gray-200 text-sm">Cancel</button>
                    <button type="submit"
                        class="px-3 py-1.5 rounded-lg bg-fuchsia-900 text-white text-sm hover:bg-fuchsia-800">Create
                        product</button>
                </div>





            </form>
        </div>
    </div>