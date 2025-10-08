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

                {{-- body --}}
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

                                    <label class="block mb-1 text-sm font-medium text-gray-700">Invoice ID </label>
                                    <input type="text"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        name="invoice_code" id="invoice-code" readonly>
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Select Client</label>
                                    <select
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        name="client_id" id="client-select" required>
                                        <option value="">--Select Client--</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" data-phone="{{ $client->phone_number }}"
                                                data-email="{{ $client->email }}"
                                                data-location="{{ $client->location }}">
                                                {{ $client->firstname }} {{ $client->lastname }}
                                                ({{ $client->company_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
                                <div>

                                    <label class="block mb-1 text-sm font-medium text-gray-700">Phone</label>

                                    <input type="text"class="w-full p-2 border border-gray-300 rounded-md
                                         focus:outline-none focus:ring-2 focus:ring-purple-500" id="client-phone"
                                        placeholder="Phone" readonly>
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

                                    <label class="block mb-1 text-sm font-medium text-gray-700">Location</label>
                                    <input
                                        class="w-full p-2 border border-gray-300
                                        rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        type="text" id="client-location" placeholder="Location" readonly>
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Date</label>

                                    <input type="date" name="due_date"
                                        class="w-full p-2 border border-gray-300
                                        rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Select Project</label>
                                    <select name="project_id"
                                        class="w-full p-2 border border-gray-300 rounded-md
                                        focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        id="project-select" required>
                                        <option value="">--Select Project--</option>
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Forward Invoice to
                                        Client Email?</label>

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
                            <!-- Totals -->
                            <div class="text-right space-y-1 text-gray-700 font-medium">
                                <p>Sub Total: <span id="subtotal" class="ml-2">00.00</span></p>
                                <p>VAT (12%): <span id="vat" class="ml-2">00.00</span></p>
                                <p class="text-lg">Total Amount: GHS <span id="total"
                                        class="ml-2 font-semibold">00.00</span></p>
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-end space-x-3 pt-4">
                                <button
                                    class="px-4 py-2 border border-purple-600 text-purple-700 rounded-full hover:bg-purple-50">Cancel</button>
                                <button
                                    class="px-6 py-2 text-semibold text-[15px]
                                    text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]
                                    type="submit">Save
                                    Invoice</button>
                            </div>
                        </form>
                    </div>
                  </div>
                    </main>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const codeInput = document.getElementById('invoice-code');
                            codeInput.value =
                                `INV-${new Date().toISOString().slice(0, 10).replace(/-/g, '')}-${Date.now().toString().slice(-4)}`;

                            const clientSelect = document.getElementById('client-select');
                            const projectSelect = document.getElementById('project-select');
                            const itemsContainer = document.getElementById('items-container');
                            const addItemBtn = document.getElementById('add-item-btn');

                            const subtotalEl = document.getElementById('subtotal');
                            const vatEl = document.getElementById('vat');
                            const totalEl = document.getElementById('total');

                            clientSelect.addEventListener('change', function() {
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

                            addItemBtn.addEventListener('click', function() {
                                const row = document.createElement('div');
                                row.classList.add('item-row');
                                row.innerHTML = `
                            <input type="text" class="col-span-5 border border-gray-300 rounded-md px-3 py-2" name="items[${itemIndex}][item_name]" placeholder="Item name" required>
                            <input type="text" class="col-span-5 border border-gray-300 rounded-md px-3 py-2" name="items[${itemIndex}][description]" placeholder="Description">
                            <input type="number" class="col-span-5 border border-gray-300 rounded-md px-3 py-2 qty" name="items[${itemIndex}][quantity]"  placeholder="Qty" min="1" required>
                            <input type="number" class="col-span-5 border border-gray-300 rounded-md px-3 py-2 unit" name="items[${itemIndex}][unit_price]"  placeholder="Unit Price" step="0.01" min="0" required>
                            <strong>Total: GHS <span class="total">0.00</span></strong>
                            <br><br> `;
                                itemsContainer.appendChild(row);
                                itemIndex++;

                                row.querySelectorAll('.qty, .unit').forEach(input => {
                                    input.addEventListener('input', calculateTotals);
                                });
                            });
                        });
                    </script>

</x-accountant-layout>
