<x-accountant-layout>
    <x-slot name="header">
        @include('admin.layouts.header')
    </x-slot>
          <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class=" bg-[#F9F7F7] items-center">
             <div class="mb-[20px] items-center">

{{-- navigation bar --}}
   {{-- <div class="flex items-center justify-between mb-6">
    <div class="flex items-center justify-between mb-6">
     <span><i data-feather="home" class="w-[5] h-[5] text-fuchsia-900 ml-[3px]"></i></span>
     <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
     <a href="{{ route('accountant.Payments') }}">

        <h3 class="font-sans font-normal text-black cursor-pointer hover:underline">Payments</h3>

    </a>

        </h3>
        <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
        <h3 class="font-semibold text-fuchsia-900">Create New Invoice</h3>

    </div> --}}


 <!-- Top Navbar -->

     </div>

        {{--body--}}
            {{-- <div class="p-6 space-y-8 bg-white shadow-md rounded-2xl">
              <!-- Space Dimensions -->
              <div>
                <h2 class="mb-4 text-lg font-semibold text-purple-800">Space Dimensions</h2>
                <h2 class="mb-4 text-lg font-semibold text-purple-800"> </h2>


<form action="{{ route('accountant.Invoice.store') }}" method="POST" enctype="multipart/form-data">
   @csrf

               <input type="hidden" name="project_id" value="{{ request('project') }}">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
      <div>

        <label  class="block mb-1 text-sm font-medium text-gray-700">Length (in meters/feet)</label>
        <input type="text" name="length" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
      </div>
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Height (in meters/feet)</label>
        <input type="text" name="height" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
      </div>

    </div>

       <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
      <div>

        <label  class="block mb-1 text-sm font-medium text-gray-700">Length (in meters/feet)</label>
        <input type="text" name="length" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
      </div>
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Height (in meters/feet)</label>
        <input type="text" name="height" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
      </div>

    </div>

       <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
      <div>

        <label  class="block mb-1 text-sm font-medium text-gray-700">Length (in meters/feet)</label>
        <input type="text" name="length" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
      </div>
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Height (in meters/feet)</label>
        <input type="text" name="height" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
      </div>

    </div> --}}

    <!-- Notes -->
    {{-- <div class="mt-6">
      <label class="block mb-1 text-sm font-medium text-gray-700">Additional Notes on Measurements</label>
      <textarea name="notes" rows="3" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
    </div>
  </div> --}}

  <!-- Site Photos -->
  {{-- <div>
    <h2 class="mb-4 text-lg font-semibold text-purple-800">Site Photos</h2>

            <div onclick="document.getElementById('account_profile_input').click()"
            class="flex items-center justify-center flex-1 h-32 p-6 text-center text-gray-500 border-2 border-purple-600 border-dashed cursor-pointer rounded-xl hover:bg-gray-50">
            <div>
              <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="..."/></svg>
              <p><span class="font-medium text-purple-600">Click here</span> to upload your file or drag.</p>
              <p class="mt-1 text-xs text-gray-400">Supported format: SVG, JPG, PNG (10MB each)</p>
            </div> --}}
            {{-- <input type="file" name="profile_pic" id="account_profile_input" class="hidden" onchange="previewProfile(event)">
            <input type="file" name="images[]" id="account_profile_input" class="hidden" multiple onchange="previewProfile(event)"> --}}

          {{-- </div>
  </div> --}}


  <!-- Obstruction Description -->
  {{-- <div>
    <label class="block mb-1 text-sm font-medium text-gray-700">
      Description of site conditions (e.g., obstacles, required modifications, access limitations):
    </label>
    <textarea name="obstacles" rows="3" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
  </div>
   <button type="submit"
     class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
     Save Measurement
 </button>
  </form> --}}

<form action="" method="POST" id="invoice-form">
    @csrf

    <!-- Invoice Code (auto-filled) -->
    <label>Invoice Code</label>
    <input type="text" name="invoice_code" id="invoice-code" readonly>

    <!-- Client Dropdown -->
    <label>Select Client</label>
    <select name="client_id" id="client-select">
        <option value="">--Select Client--</option>
        @foreach($clients as $client)
            <option value="{{ $client->id }}" data-phone="{{ $client->phone_number }}" data-email="{{ $client->email }}" data-location="{{ $client->location }}">
                {{ $client->name }}
            </option>
        @endforeach
    </select>

    <!-- Auto-fill fields -->
    <input type="text" id="client-phone" disabled>
    <input type="text" id="client-email" disabled>
    <input type="text" id="client-location" disabled>

    <!-- Project Dropdown (populated by JS) -->
    <label>Select Project</label>
    <select name="project_id" id="project-select"></select>

    <!-- Due Date -->
    <label>Due Date</label>
    <input type="date" name="due_date">

    <!-- Send Email -->
    <label><input type="checkbox" name="send_email"> Send Email</label>

    <!-- Items -->
    <h4>Items</h4>
    <div id="items-container">
        <!-- Dynamic rows go here -->
    </div>
    <button type="button" id="add-item-btn">Add New Item</button>

    <button type="submit">Save Invoice</button>
</form>


<script>

document.addEventListener('DOMContentLoaded', function () {
    // Auto-generate invoice code
    const codeInput = document.getElementById('invoice-code');
    const timestamp = Date.now();
    codeInput.value = `INV-${new Date().toISOString().slice(0, 10).replace(/-/g, '')}-${timestamp.toString().slice(-4)}`;

    // Auto-fill client info + load projects
    const clientSelect = document.getElementById('client-select');
    const projectSelect = document.getElementById('project-select');
    clientSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        document.getElementById('client-phone').value = selected.dataset.phone || '';
        document.getElementById('client-email').value = selected.dataset.email || '';
        document.getElementById('client-location').value = selected.dataset.location || '';

        // Fetch projects via AJAX
        // fetch(`/api/client/${this.value}/projects`)
        fetch(`/accountant/client/${this.value}/projects`)

            .then(res => res.json())
            .then(data => {
                projectSelect.innerHTML = '';
                data.forEach(project => {
                    const opt = document.createElement('option');
                    opt.value = project.id;
                    opt.textContent = project.name;
                    projectSelect.appendChild(opt);
                });
            });
    });

    // Add new item row
    const addItemBtn = document.getElementById('add-item-btn');
    const itemsContainer = document.getElementById('items-container');
    addItemBtn.addEventListener('click', function () {
        const row = document.createElement('div');
        row.innerHTML = `
            <input type="text" name="items[][item_name]" placeholder="Item name" required>
            <input type="text" name="items[][description]" placeholder="Description">
            <input type="number" name="items[][quantity]" placeholder="Qty" required>
            <input type="number" name="items[][unit_price]" placeholder="Unit Price" step="0.01" required>
        `;
        itemsContainer.appendChild(row);
    });
});

</scrip>

</div>

            </div>
        </main>
</x-accountant-layout>
