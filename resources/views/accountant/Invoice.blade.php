<x-accountant-layout>
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
     <a href="{{ route('accountant.Payments') }}">

        <h3 class="font-sans font-normal text-black cursor-pointer hover:underline">Payments</h3>

    </a>

        </h3>
        <span><i data-feather="chevron-right" class="w-[4] h-[3] text-fuchsia-900 ml-[3px]"></i></span>
        <h3 class="font-semibold text-fuchsia-900">Create New Invoice</h3>

    </div>


     </div>






{{--
     <div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-lg space-y-6 text-sm">
  <!-- Invoice + Client Info -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label class="block text-gray-700 mb-1">Invoice Number</label>
      <input type="text" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" value="INV450">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Due Date</label>
      <div class="relative">
        <input type="date" class="w-full rounded-md border border-gray-300 px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-purple-500">
        <span class="absolute right-3 top-2.5 text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7H3v10a2 2 0 002 2z" />
          </svg>
        </span>
      </div>
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Client Name</label>
      <input type="text" class="w-full rounded-md border border-gray-300 px-3 py-2" value="Yaw Boateng">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Location</label>
      <input type="text" class="w-full rounded-md border border-gray-300 px-3 py-2" value="Spintex, Baatsona">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Phone Number</label>
      <input type="text" class="w-full rounded-md border border-gray-300 px-3 py-2" value="0546782345">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Email</label>
      <input type="text" class="w-full rounded-md border border-gray-300 px-3 py-2" value="yawbboat@hotmail.com">
    </div>
  </div>

  <!-- Forward Email Option -->
  <div class="mt-2">
    <label class="block text-gray-700 mb-1">Forward Invoice to Client Email?</label>
    <div class="flex items-center gap-6">
      <label class="inline-flex items-center">
        <input type="radio" name="send_email" value="yes" class="text-purple-600 border-gray-300 focus:ring-purple-500">
        <span class="ml-2">Yes</span>
      </label>
      <label class="inline-flex items-center">
        <input type="radio" name="send_email" value="no" class="text-purple-600 border-gray-300 focus:ring-purple-500">
        <span class="ml-2">No</span>
      </label>
    </div>
  </div>

  <!-- Item List -->
  <div class="space-y-4">
    <div class="grid grid-cols-12 gap-3 font-medium text-gray-600">
      <div class="col-span-5">Item Description</div>
      <div class="col-span-2">Quantity</div>
      <div class="col-span-2">Unit Price</div>
      <div class="col-span-2">Total</div>
      <div class="col-span-1"></div>
    </div>

    <!-- Item Row -->
    <div class="grid grid-cols-12 gap-3 items-center">
      <input type="text" class="col-span-5 border border-gray-300 rounded-md px-3 py-2" value="Countertops (Granite, Quartz, Marble)">
      <input type="number" class="col-span-2 border border-gray-300 rounded-md px-3 py-2" value="2">
      <input type="number" class="col-span-2 border border-gray-300 rounded-md px-3 py-2" value="20000">
      <div class="col-span-2 text-gray-700 font-medium">$20,000</div>
      <button class="col-span-1 text-red-500 hover:text-red-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Item Row -->
    <div class="grid grid-cols-12 gap-3 items-center">
      <input type="text" class="col-span-5 border border-gray-300 rounded-md px-3 py-2" value="Under Cabinet Lightning">
      <input type="number" class="col-span-2 border border-gray-300 rounded-md px-3 py-2" value="2">
      <input type="number" class="col-span-2 border border-gray-300 rounded-md px-3 py-2" value="20000">
      <div class="col-span-2 text-gray-700 font-medium">$20,000</div>
      <button class="col-span-1 text-red-500 hover:text-red-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Add Item -->
    <button class="flex items-center text-purple-600 hover:text-purple-800 text-sm font-medium mt-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Add New Item
    </button>
  </div>

  <!-- Totals -->
  <div class="text-right space-y-1 text-gray-700 font-medium">
    <p>Sub Total: <span class="ml-2">$40,000</span></p>
    <p>VAT: <span class="ml-2">$5,000</span></p>
    <p class="text-lg">Total Amount: <span class="ml-2 font-semibold">$45,000</span></p>
  </div>

  <!-- Actions -->
  <div class="flex justify-end space-x-3 pt-4">
    <button class="px-4 py-2 border border-purple-600 text-purple-700 rounded-full hover:bg-purple-50">Cancel</button>
    <button class="px-6 py-2 bg-purple-700 text-white rounded-full hover:bg-purple-800">Create Invoice</button>
  </div>
</div> --}}


        {{--body--}}
            <div class="max-w-7xl mx-auto bg-white p-6 rounded-2xl shadow-lg space-y-6 text-sm">
              <!-- Space Dimensions -->
              <div>
                <h2 class="mb-4 text-lg font-semibold text-purple-800">Space Dimensions</h2>
                <h2 class="mb-4 text-lg font-semibold text-purple-800"> </h2>

                @if ($errors->any())
    <div style="color: red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('accountant.Invoice.store') }}" method="POST" id="invoice-form">
   @csrf

               <input type="hidden" name="project_id" value="{{ request('project') }}">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
      <div>

        <label  class="block mb-1 text-sm font-medium text-gray-700">Invoice ID </label>
      <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" name="invoice_code" id="invoice-code" readonly>
    </div>
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Select Client</label>
     <select class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" name="client_id" id="client-select" required>
        <option value="">--Select Client--</option>
        @foreach($clients as $client)
            <option value="{{ $client->id }}"
                data-phone="{{ $client->phone_number }}"
                data-email="{{ $client->email }}"
                data-location="{{ $client->location }}">
                {{ $client->firstname }} {{ $client->lastname }} ({{ $client->company_name }})
            </option>
        @endforeach
    </select>
    </div>

    </div>

       <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
      <div>

        <label  class="block mb-1 text-sm font-medium text-gray-700">Phone</label>

        <input type="text"class="w-full p-2 border border-gray-300 rounded-md
         focus:outline-none focus:ring-2 focus:ring-purple-500"
          id="client-phone" placeholder="Phone" readonly>

    </div>
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
        <input type="text" id="client-email"
        class="w-full p-2 border border-gray-300 rounded-md
         focus:outline-none focus:ring-2 focus:ring-purple-500"
          placeholder="Email" readonly>

    </div>

    </div>


       <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
 <div>

        <label  class="block mb-1 text-sm font-medium text-gray-700">Location</label>
        <input class="w-full p-2 border border-gray-300
        rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
         type="text" id="client-location" placeholder="Location" readonly>

    </div>
      <div>
      <label class="block mb-1 text-sm font-medium text-gray-700">Date</label>

        <input type="date" name="due_date" class="w-full p-2 border border-gray-300
        rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" required>

    </div>
       </div>



       <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

  <div>
   <label class="block mb-1 text-sm font-medium text-gray-700">Select Project</label>
      <select name="project_id"  class="w-full p-2 border border-gray-300 rounded-md
        focus:outline-none focus:ring-2 focus:ring-purple-500" id="project-select" required>
        <option value="">--Select Project--</option>
    </select>
    </div>

     <div class="mt-4">
           <label class="block mb-1 text-sm font-medium text-gray-700">Forward Invoice to Client Email?</label>

    <label>
        <input type="checkbox" name="send_email"> Send Email
    </label>
    </div>

    </div>
    <h4 class="mt-6 text-lg font-semibold text-purple-800">Items</h4>
    <div id="items-container" class="space-y-4">
        <!-- Item rows will be added here dynamically -->
    <div id="items-container"></div>
    <button type="button" id="add-item-btn">Add New Item</button>

    <br><br>
    </div>

   {{-- <button type="submit"
     class="px-6 py-2 text-semibold text-[15px]
      text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
     Save Measurement
 </button> --}}
   <!-- Totals -->
  <div class="text-right space-y-1 text-gray-700 font-medium">
    <p>Sub Total: <span id="subtotal" class="ml-2">00.00</span></p>
    <p>VAT (12%): <span id="vat" class="ml-2">00.00</span></p>
    <p class="text-lg">Total Amount: GHS <span id="total" class="ml-2 font-semibold">00.00</span></p>
  </div>


  <!-- Actions -->
  <div class="flex justify-end space-x-3 pt-4">
    <button class="px-4 py-2 border border-purple-600 text-purple-700 rounded-full hover:bg-purple-50">Cancel</button>
     <button  class="px-6 py-2 text-semibold text-[15px]
      text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]
      type="submit">Save Invoice</button>
  </div>


  </form>

{{--
@if ($errors->any())
    <div style="color: red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

{{-- <form action="{{ route('accountant.Invoice.store') }}" method="POST" id="invoice-form">
    @csrf

    <label>Invoice Code</label>
    <input type="text" name="invoice_code" id="invoice-code" readonly> --}}
{{--
    <label>Select Client</label>
    <select name="client_id" id="client-select" required>
        <option value="">--Select Client--</option>
        @foreach($clients as $client)
            <option value="{{ $client->id }}"
                data-phone="{{ $client->phone_number }}"
                data-email="{{ $client->email }}"
                data-location="{{ $client->location }}">
                {{ $client->firstname }} {{ $client->lastname }} ({{ $client->company_name }})
            </option>
        @endforeach
    </select> --}}

    {{-- <input type="text" id="client-phone" placeholder="Phone" readonly>
    <input type="text" id="client-email" placeholder="Email" readonly>
    <input type="text" id="client-location" placeholder="Location" readonly>

    <label>Select Project</label>
    <select name="project_id" id="project-select" required>
        <option value="">--Select Project--</option>
    </select>

    <label>Due Date</label>
    <input type="date" name="due_date" required>

    <label>
        <input type="checkbox" name="send_email"> Send Email
    </label> --}}

    {{-- <h4>Items</h4>
    <div id="items-container"></div>
    <button type="button" id="add-item-btn">Add New Item</button>

    <br><br> --}}

    <!-- Subtotal, VAT, Total -->
    {{-- <div>
        <p>Subtotal: GHS <span id="subtotal">0.00</span></p>
        <p>VAT (12%): GHS <span id="vat">0.00</span></p>
        <p><strong>Total: GHS <span id="total">0.00</span></strong></p>
    </div> --}}

    {{-- <button type="submit">Save Invoice</button>
</form> --}}


</div>

            </div>
        </main>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const codeInput = document.getElementById('invoice-code');
    codeInput.value = `INV-${new Date().toISOString().slice(0, 10).replace(/-/g, '')}-${Date.now().toString().slice(-4)}`;

    const clientSelect = document.getElementById('client-select');
    const projectSelect = document.getElementById('project-select');
    const itemsContainer = document.getElementById('items-container');
    const addItemBtn = document.getElementById('add-item-btn');

    const subtotalEl = document.getElementById('subtotal');
    const vatEl = document.getElementById('vat');
    const totalEl = document.getElementById('total');

    clientSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        document.getElementById('client-phone').value = selected.dataset.phone || '';
        document.getElementById('client-email').value = selected.dataset.email || '';
        document.getElementById('client-location').value = selected.dataset.location || '';

        fetch(`/accountant/Invoice/${this.value}/projects`)
            .then(res => res.json())
            .then(data => {
                projectSelect.innerHTML = '<option value="">--Select Project--</option>';
                data.forEach(project => {
                    const opt = document.createElement('option');
                    opt.value = project.id;
                    opt.textContent = project.name;
                    projectSelect.appendChild(opt);
                });
            });
    });

    let itemIndex = 0;

    function calculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.unit').value) || 0;
            const total = qty * price;
            row.querySelector('.total').textContent = total.toFixed(2);
            subtotal += total;
        });
        const vat = subtotal * 0.12;
        const grand = subtotal + vat;

        subtotalEl.textContent = subtotal.toFixed(2);
        vatEl.textContent = vat.toFixed(2);
        totalEl.textContent = grand.toFixed(2);
    }

    addItemBtn.addEventListener('click', function () {
        const row = document.createElement('div');
        row.classList.add('item-row');
        row.innerHTML = `
            <input type="text" class="col-span-5 border border-gray-300 rounded-md px-3 py-2" name="items[${itemIndex}][item_name]" placeholder="Item name" required>
            <input type="text" class="col-span-5 border border-gray-300 rounded-md px-3 py-2" name="items[${itemIndex}][description]" placeholder="Description">
            <input type="number" class="col-span-5 border border-gray-300 rounded-md px-3 py-2 qty" name="items[${itemIndex}][quantity]"  placeholder="Qty" min="1" required>
            <input type="number" class="col-span-5 border border-gray-300 rounded-md px-3 py-2 unit" name="items[${itemIndex}][unit_price]"  placeholder="Unit Price" step="0.01" min="0" required>
            <strong>Total: GHS <span class="total">0.00</span></strong>
            <br><br>
        `;
        itemsContainer.appendChild(row);
        itemIndex++;

        row.querySelectorAll('.qty, .unit').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });
    });
});
</script>

</x-accountant-layout>
