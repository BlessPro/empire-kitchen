<x-accountant-layout>
    @php
        $designImages = collect($invoice->project->designs ?? [])->flatMap(fn($d) => $d->images ?? [])->filter()->values();
    @endphp
    <main class="bg-[#F9F7F7] min-h-screen pt-4 px-4 sm:px-6">
        <div class="flex items-center justify-between max-w-6xlmb-4">
            <div class="flex items-center gap-2 text-sm text-slate-600">
                <i data-feather="home" class="w-4 h-4 text-fuchsia-900"></i>
                <i data-feather="chevron-right" class="w-4 h-4 text-fuchsia-900"></i>
                <span class="font-semibold text-fuchsia-900">Invoice</span>
            </div>
            <button onclick="downloadInvoice()"
                class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-full text-white bg-[#5A0562] hover:bg-[#4a044c]">
                <i data-feather="download" class="w-4 h-4"></i>
                Download
            </button>
        </div>
        <div class="max-w-5xl mx-auto space-y-6">

            <div id="invoice-section" class="p-8 space-y-8 text-sm text-gray-800 bg-white shadow rounded-2xl">
                <div class="flex items-start justify-between">
                    <div class="w-1/2">
                        <img src="{{ asset('storage/images-one/empire logo-new.png') }}" alt="Empire Logo" class="h-16">
                    </div>
                    <div class="flex flex-col items-end w-1/2 space-y-4">
                        <div class="text-right">
                            <h2 class="mb-1 text-lg font-bold text-gray-900 uppercase">Invoice</h2>
                            <p class="font-semibold">EMPIRE KITCHENS</p>
                            <p>REG: 123000123000</p>
                            <p>EmpireKitchens.com | +233 123 1234 123</p>
                        </div>
                        <div class="w-full space-y-1 text-right">
                            <div class="flex justify-between">
                                <span class="font-semibold">INVOICE NUMBER:</span>
                                <span>{{ $invoice->invoice_code }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">INVOICE DATE:</span>
                                <span>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">DUE DATE:</span>
                                <span>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="w-full overflow-hidden text-left border border-gray-200 rounded-lg">
                    <thead class="text-sm font-medium text-gray-700 bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Item Description</th>
                            <th class="px-4 py-2 text-right">Qty</th>
                            <th class="px-4 py-2 text-right">Unit Price</th>
                            <th class="px-4 py-2 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->invoiceItems as $item)
                            <tr class="border-t border-gray-200">
                                <td class="px-4 py-2">{{ $item->item_name }}</td>
                                <td class="px-4 py-2 text-right">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end">
                    <div class="w-full p-4 rounded sm:w-1/3 bg-gray-50">
                        <div class="flex justify-between py-1">
                            <span>Sub total</span>
                            <span>{{ number_format($invoice->invoiceSummary->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span>VAT</span>
                            <span>{{ number_format($invoice->invoiceSummary->vat, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 font-bold">
                            <span>Total Amount</span>
                            <span>{{ number_format($invoice->invoiceSummary->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-[#6B1E7233] p-6 text-gray-800 text-sm grid grid-cols-1 md:grid-cols-2 gap-4 rounded-xl">
                    <div class="text-left">
                        <h3 class="mb-2 font-semibold text-purple-800 uppercase">Payment Instructions</h3>
                        <p>Empire Kitchens</p>
                        <p>Bank name: ABSA Bank Limited</p>
                        <p>SWIFT: NZO201230012</p>
                        <p>Account number: 12-1234-123456-12</p>
                        <p>Please use <strong>{{ $invoice->invoice_code }}</strong> as a reference number</p>
                        <p class="mt-4">
                            For any questions please contact us at
                            <a href="mailto:info@empirekitchen.com" class="text-purple-800 underline">info@empirekitchen.com</a>
                        </p>
                    </div>
                    <div class="flex items-start justify-end">
                        <div class="text-right">
                            <p>Pay online</p>
                            <img src="{{ asset('storage/images-one/blank_qr_code.png') }}" alt="QR Code" class="w-32 mt-2">
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-lg font-semibold text-slate-900">CLIENT TO KINDLY TAKE NOTE</h3>
                    <ul class="space-y-2 text-sm list-disc list-inside text-slate-700">
                        <li>The above prices include cabinets, installation and transportation (within Greater Accra)</li>
                        <li>Electricity to be provided by client when on site</li>
                        <li>A deposit of 70% shall be made before delivery and the balance paid before installation</li>
                        <li>Plumbing connections, building works and connections of appliances are not included</li>
                        <li>Above prices do not include appliances unless specifically requested for by client and they shall be priced separately</li>
                        <li>Above prices do not include appliances unless specifically requested for by client and they shall be priced separately</li>
                    </ul>
                </div>

                @if($designImages->isNotEmpty())
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-900">DESIGNS</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach($designImages as $img)
                            <div class="w-full overflow-hidden border border-gray-200 rounded-xl">
                                <img src="{{ asset('storage/' . ltrim($img, '/')) }}" alt="Design image" class="object-cover w-full h-full">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadInvoice() {
            const element = document.getElementById('invoice-section');
            const opt = {
                filename: 'invoice.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
</x-accountant-layout>
