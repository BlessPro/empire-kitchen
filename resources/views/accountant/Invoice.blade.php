<x-accountant-layout>
    <main class="bg-[#F9F7F7] min-h-screen pt-20 px-4 sm:px-6">
        <div class="max-w-5xl mx-auto space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i data-feather="home" class="w-4 h-4 text-fuchsia-900"></i>
                    <i data-feather="chevron-right" class="w-4 h-4 text-fuchsia-900"></i>
                    <span class="font-semibold text-fuchsia-900">Create Invoice</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-lg space-y-6 text-sm">
                @if ($errors->any())
                    <div class="p-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded-lg">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="p-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('accountant.Invoice.store') }}" method="POST" id="invoice-form">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Invoice ID</label>
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
                                    <option value="{{ $client->id }}"
                                            data-phone="{{ $client->phone_number }}"
                                            data-email="{{ $client->email }}"
                                            data-location="{{ $client->location }}">
                                        {{ $client->firstname }} {{ $client->lastname }}
                                        @if(!empty($client->company_name))
                                            ({{ $client->company_name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Phone</label>
                            <input type="text"
                                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   id="client-phone" placeholder="Phone" readonly>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                            <input type="text"
                                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   id="client-email" placeholder="Email" readonly>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Location</label>
                            <input type="text"
                                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   id="client-location" placeholder="Location" readonly>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Due Date</label>
                            <input type="date"
                                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   name="due_date" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Select Project</label>
                            <select
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                name="project_id" id="project-select" required>
                                <option value="">--Select Project--</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2 pt-6">
                            <input type="checkbox" id="send-email" name="send_email"
                                   class="h-4 w-4 text-purple-600 border-gray-300 rounded"
                                   {{ old('send_email') ? 'checked' : '' }}>
                            <label for="send-email" class="text-sm text-gray-600">Send email to client</label>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-purple-800">Invoice Items</h3>
                            <button type="button" id="add-item-btn" class="px-4 py-2 text-white rounded-md bg-fuchsia-900 hover:bg-purple-800">
                                + Add Item
                            </button>
                        </div>
                        <div id="items-container" class="space-y-4">
                            <div class="item-row grid grid-cols-1 md:grid-cols-5 gap-3">
                                <input type="text" class="col-span-2 border border-gray-300 rounded-md px-3 py-2" name="items[0][item_name]" placeholder="Item name" required>
                                <input type="text" class="border border-gray-300 rounded-md px-3 py-2" name="items[0][description]" placeholder="Description">
                                <input type="number" class="border border-gray-300 rounded-md px-3 py-2 qty" name="items[0][quantity]" placeholder="Qty" min="1" required>
                                <input type="number" class="border border-gray-300 rounded-md px-3 py-2 unit" name="items[0][unit_price]" placeholder="Unit Price" step="0.01" min="0" required>
                                <strong class="text-right md:col-span-5">Total: GHS <span class="total">0.00</span></strong>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-purple-50 mt-6 p-4 rounded-xl">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Subtotal</h4>
                            <p class="text-lg font-semibold" id="subtotal">0.00</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700">VAT (12%)</h4>
                            <p class="text-lg font-semibold" id="vat">0.00</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Total</h4>
                            <p class="text-lg font-semibold" id="total">0.00</p>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 gap-3">
                        <a href="{{ route('accountant.Invoice') }}" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-full hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-6 py-2 text-white rounded-full bg-fuchsia-900 hover:bg-purple-800">
                            Save Invoice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('invoice-code');
            if (codeInput && !codeInput.value) {
                codeInput.value = `INV-${new Date().toISOString().slice(0, 10).replace(/-/g, '')}-${Date.now().toString().slice(-4)}`;
            }

            const clientSelect = document.getElementById('client-select');
            const projectSelect = document.getElementById('project-select');
            const itemsContainer = document.getElementById('items-container');
            const addItemBtn = document.getElementById('add-item-btn');

            const subtotalEl = document.getElementById('subtotal');
            const vatEl = document.getElementById('vat');
            const totalEl = document.getElementById('total');

            clientSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                document.getElementById('client-phone').value = selected?.dataset.phone || '';
                document.getElementById('client-email').value = selected?.dataset.email || '';
                document.getElementById('client-location').value = selected?.dataset.location || '';

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

            let itemIndex = 1;

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
                row.classList.add('item-row', 'grid', 'grid-cols-1', 'md:grid-cols-5', 'gap-3');
                row.innerHTML = `
                    <input type="text" class="col-span-2 border border-gray-300 rounded-md px-3 py-2" name="items[${itemIndex}][item_name]" placeholder="Item name" required>
                    <input type="text" class="border border-gray-300 rounded-md px-3 py-2" name="items[${itemIndex}][description]" placeholder="Description">
                    <input type="number" class="border border-gray-300 rounded-md px-3 py-2 qty" name="items[${itemIndex}][quantity]" placeholder="Qty" min="1" required>
                    <input type="number" class="border border-gray-300 rounded-md px-3 py-2 unit" name="items[${itemIndex}][unit_price]" placeholder="Unit Price" step="0.01" min="0" required>
                    <strong class="text-right md:col-span-5">Total: GHS <span class="total">0.00</span></strong>
                `;
                itemsContainer.appendChild(row);
                itemIndex++;

                row.querySelectorAll('.qty, .unit').forEach(input => {
                    input.addEventListener('input', calculateTotals);
                });
            });

            document.querySelectorAll('.qty, .unit').forEach(input => {
                input.addEventListener('input', calculateTotals);
            });
        });
    </script>
</x-accountant-layout>
