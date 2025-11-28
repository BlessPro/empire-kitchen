<x-accountant-layout>
    <main class="min-h-screen px-4 py-10 bg-gray-50">
        <div class="flex justify-between max-w-4xl mx-auto mb-4">
            <a href="{{ route('accountant.Payment.Pay') }}"
                class="px-4 py-2 text-sm font-semibold text-white rounded-full bg-fuchsia-900 hover:bg-fuchsia-800">
                Back
            </a>
            <button onclick="downloadReceipt()"
                class="px-4 py-2 text-sm font-semibold text-white rounded-full bg-fuchsia-900 hover:bg-fuchsia-800">
                Download PDF
            </button>
        </div>
        <div id="receipt-section" class="max-w-4xl mx-auto overflow-hidden bg-white shadow rounded-2xl">
            <div class="flex flex-col gap-4 p-6 border-b border-gray-200 sm:flex-row sm:items-start sm:justify-between">
                <div class="flex items-center gap-3">
                    <img src="/empire-kitchengold-icon.png" alt="Empire Kitchen" class="object-contain w-16 h-16">
                </div>
                <div class="text-right">
                    <div class="text-xl font-extrabold text-fuchsia-900">RECEIPT</div>
                    <div class="text-sm font-semibold text-gray-700">EMPIRE KITCHEN</div>
                    <div class="text-sm text-gray-600">Transaction ID: {{ $income->transaction_id ?? 'N/A' }}</div>
                    <div class="text-xs text-gray-500">empirekitchen.com | +233 54 2900 229</div>
                </div>
            </div>

            <div class="py-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900">Payment Added</h1>
                <p class="mt-1 text-sm text-gray-600">Receipt for payment recorded.</p>
            </div>

            <div class="px-6 pb-8 space-y-6">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="p-4 border border-gray-100 bg-gray-50 rounded-xl">
                        <div class="text-sm text-gray-600">Client</div>
                        <div class="text-base font-semibold text-gray-900">
                            {{ trim(($income->client->title ?? '') . ' ' . ($income->client->firstname ?? '') . ' ' . ($income->client->lastname ?? '')) ?: '-' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $income->client->email ?? '' }} {{ $income->client->phone_number ? '• '.$income->client->phone_number : '' }}
                        </div>
                    </div>
                    <div class="p-4 border border-gray-100 bg-gray-50 rounded-xl">
                        <div class="text-sm text-gray-600">Project</div>
                        <div class="text-base font-semibold text-gray-900">{{ $income->project->name ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $income->project->location ?? '' }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="p-4 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="text-xs text-gray-500 uppercase">Amount</div>
                        <div class="text-lg font-bold text-gray-900">GHS {{ number_format($income->amount ?? 0, 2) }}</div>
                    </div>
                    <div class="p-4 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="text-xs text-gray-500 uppercase">Payment Method</div>
                        <div class="text-base font-semibold text-gray-900">{{ $income->payment_method ?? '-' }}</div>
                    </div>
                    <div class="p-4 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="text-xs text-gray-500 uppercase">Date</div>
                        <div class="text-base font-semibold text-gray-900">
                            {{ optional($income->date)->format('d M Y') ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="p-4 border border-gray-100 bg-gray-50 rounded-xl">
                    <div class="mb-2 text-sm text-gray-600">Notes</div>
                    <p class="text-sm text-gray-800">
                        {{ $income->notes ?? 'No additional notes for this payment.' }}
                    </p>
                </div>
            </div>

            {{-- <div class="flex flex-col px-6 py-4 text-sm text-white bg-fuchsia-500 sm:flex-row sm:items-center sm:justify-between">
                <div>Thank you for your payment.</div>
                <div class="text-xs sm:text-sm">Empire Kitchen • empirekitchen.com • +233 54 2900 229</div>
            </div> --}}

              <div class="bg-[#6B1E7233] p-6 text-gray-800 text-sm grid grid-cols-1 md:grid-cols-2 gap-4 ">
                    <div class="text-left">
                        <h3 class="mb-2 font-semibold text-purple-800 uppercase">Payment Instructions</h3>
                        <p>Empire Kitchens</p>
                        <p>Bank name: ABSA Bank Limited</p>
                        <p>SWIFT: NZO201230012</p>
                        <p>Account number: 12-1234-123456-12</p>
                        <p>Please use <strong>Transaction ID: {{ $income->transaction_id ?? 'N/A' }}</strong> as a reference number</p>
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
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadReceipt() {
            const element = document.getElementById('receipt-section');
            const opt = {
                filename: 'receipt.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
</x-accountant-layout>
