<x-designer-layout>
    @php
        $designImages = collect($invoice->project->designs ?? [])->flatMap(fn($d) => $d->images ?? [])->filter()->values();
        $panes        = $designImages->isNotEmpty() ? $designImages : collect([null]);
        $summary      = optional($invoice->invoiceSummary);
        $client       = $invoice->client;
        $primaryLabel = function ($img) use ($invoice) {
            if ($img) {
                $filename = pathinfo($img, PATHINFO_FILENAME) ?: basename($img);
                return strtoupper($filename);
            }
            return strtoupper($invoice->invoiceItems->first()->item_name ?? optional($invoice->project)->name ?? 'DESIGN');
        };
        $totalAmount  = (float) ($summary->total_amount ?? 0);
        $discountAmt  = (float) ($summary->discount_amount ?? 0);
        $discountPct  = (float) ($summary->discount_percent ?? 0);
    @endphp
    <main class="bg-white min-h-screen p-4">
        <style>
            .quote-pane { page-break-inside: avoid; }
            .quote-pane + .quote-pane { page-break-before: always; }
        </style>

        <div class="flex justify-end max-w-6xl mx-auto mb-4 gap-3">
            <button id="send-to-client-btn" onclick="sendToClient()"
                class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-full text-[#5A0562] border border-[#5A0562] hover:bg-[#5A0562] hover:text-white">
                Send to Client
            </button>
            <button onclick="downloadInvoice()"
                class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-full text-white bg-[#5A0562] hover:bg-[#4a044c]">
                Download
            </button>
        </div>

        <div id="invoice-section" class="space-y-6">
            @foreach($panes as $img)
            <section class="w-full max-w-6xl mx-auto bg-white border border-gray-300 quote-pane text-[11px] leading-snug">
                <!-- Top Header -->
                <header class="border-b border-gray-300">
                    <div class="flex flex-col md:flex-row">
                        <!-- Logo / Brand -->
                        <div class="flex-1 flex items-center justify-center py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/images-one/empire logo-new.png') }}" alt="Empire Kitchens Logo" class="h-10 w-auto">
                                <div class="text-3xl font-extrabold tracking-[0.25em] text-purple-800">
                                    EMPIRE KITCHENS
                                </div>
                            </div>
                        </div>

                        <!-- Date & Client Details -->
                        <div class="w-full md:w-64 border-t md:border-t-0 md:border-l border-gray-300 text-[11px]">
                            <div class="flex justify-between border-b border-gray-300 px-3 py-2">
                                <span class="font-semibold">Date:</span>
                                <span>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d F Y') }}</span>
                            </div>

                            <div class="px-3 py-2 border-b border-gray-300">
                                <h2 class="text-blue-700 font-semibold text-[12px] mb-1">
                                    Client Details
                                </h2>
                                <div class="space-y-1">
                                    <p class="italic">{{ trim(($client->firstname ?? '') . ' ' . ($client->lastname ?? '')) ?: 'Client' }}</p>
                                    <p>{{ $client->phone_number ?? '-' }}</p>
                                    <p>{{ $client->location ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Body -->
                <div class="p-4 md:p-5 space-y-4">
                    <!-- Image + Details -->
                    <div class="grid md:grid-cols-3 gap-4">
                        <!-- Design Image -->
                        <div class="md:col-span-2 border border-gray-300">
                            <div class="h-60 md:h-64 bg-gray-100 flex items-center justify-center">
                                @if($img)
                                    <img src="{{ asset('storage/' . ltrim($img, '/')) }}" alt="Design image" class="object-contain max-h-full max-w-full h-auto w-auto">
                                @else
                                    <span class="text-gray-500 text-xs">NO DESIGN IMAGE ATTACHED</span>
                                @endif
                            </div>
                            <div class="border-t border-gray-300 py-1 text-center text-red-700 text-[11px] font-semibold">
                                {{ $primaryLabel($img) }}
                            </div>
                        </div>

                        <!-- Details table -->
                        <aside class="border border-gray-300 text-[11px]">
                            <div class="border-b border-gray-300 px-3 py-2 flex">
                                <span class="flex-1 font-semibold underline">Details</span>
                                <span class="w-20 text-right font-semibold underline">Price</span>
                            </div>

                            @foreach ($invoice->invoiceItems as $item)
                            <div class="px-3 py-2 border-b border-gray-300 flex">
                                <div class="flex-1">
                                    {{ $item->item_name }}
                                    @if(!is_null($item->quantity))
                                        <span class="text-red-600 font-semibold">{{ $item->quantity }}</span> pcs each @
                                        <span class="text-red-600 font-semibold">{{ number_format($item->unit_price, 2) }}</span>
                                    @else
                                        <span class="text-red-600 font-semibold">{{ number_format($item->unit_price, 2) }}</span>
                                    @endif
                                </div>
                                @php
                                    $lineTotal = $item->total_price ?? (($item->quantity ?? 1) * ($item->unit_price ?? 0));
                                @endphp
                                <div class="w-20 text-right">{{ number_format($lineTotal, 2) }}</div>
                            </div>
                            @endforeach

                            <div class="px-3 py-2 border-b border-gray-300 flex">
                                <div class="flex-1 font-semibold">Subtotal</div>
                                <div class="w-20 text-right">{{ number_format($summary->subtotal ?? 0, 2) }}</div>
                            </div>

                            @if($discountAmt > 0)
                            <div class="px-3 py-2 flex">
                                <div class="flex-1">Discount ({{ rtrim(rtrim(number_format($discountPct, 2), '0'), '.') }}%)</div>
                                <div class="w-20 text-right">-{{ number_format($discountAmt, 2) }}</div>
                            </div>
                            @endif
                        </aside>
                    </div>

                    <!-- Notes + Payment -->
                    <div class="grid md:grid-cols-3 gap-4 items-start">
                        <!-- Notes -->
                        <section class="md:col-span-2 border border-gray-300 px-4 py-3">
                            <h3 class="font-semibold mb-2">Client to kindly take note</h3>
                            <ul class="list-disc list-inside space-y-1">
                                <li>
                                    The above prices include cabinets, installation and transportation
                                    (within Greater Accra)
                                </li>
                                <li>Electricity to be provided by client whiles on site</li>
                                <li>
                                    A deposit of 70% shall be made before delivery and the balance paid
                                    before installation
                                </li>
                                <li>
                                    Plumbing connections, building works and connection of appliances
                                    are not included
                                </li>
                                <li>
                                    Above prices do not include appliances unless specifically requested
                                    for by client and they shall be priced separately
                                </li>
                                <li>
                                    Empire Kitchens reserves the right to repossess products not fully
                                    paid for
                                </li>
                            </ul>
                        </section>

                        <!-- Amount + Terms -->
                        <section class="border border-gray-300 px-4 py-3 space-y-2">
                            <div class="flex justify-between border-b border-gray-300 pb-2">
                                <span class="font-semibold">Amount Payable</span>
                                <span class="font-semibold text-red-600">{{ number_format($totalAmount, 2) }}</span>
                            </div>

                            <div>
                                <h4 class="font-semibold text-[11px] mb-1">Payment Terms</h4>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>
                                        70% before production
                                        <span class="text-red-600">({{ number_format($totalAmount * 0.70, 2) }})</span>
                                    </li>
                                    <li>
                                        30% before delivery
                                        <span class="text-red-600">({{ number_format($totalAmount * 0.30, 2) }})</span>
                                    </li>
                                </ul>
                            </div>

                            <p class="pt-1.5 text-right text-[11px] font-semibold text-red-600 leading-tight">
                                PRICES ARE SUBJECT TO<br />
                                ECONOMIC CHANGES
                            </p>
                        </section>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="border-t border-gray-300 text-center py-2.5 space-y-1">
                    <p class="text-red-700 font-semibold text-[11px] tracking-wide">
                        QUOTE IS VALID FOR 7 DAYS
                    </p>
                    <p class="text-[10px]">
                        Tel: 024 60 80 730 / 055 625 1770 / 057 540 4399 &nbsp; | &nbsp;
                        Email: info@empirekitchensltd.com &nbsp; | &nbsp;
                        Website: www.empirekitchensltd.com
                    </p>
                </footer>
            </section>
            @endforeach
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadInvoice() {
            const element = document.getElementById('invoice-section');
            const opt = {
                margin:       0.25,
                filename:     'invoice.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 0.95, useCORS: true },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' },
                pagebreak:    { mode: ['avoid-all','css'], after: '.quote-pane' }
            };
            html2pdf().set(opt).from(element).save();
        }

        async function sendToClient() {
            const btn = document.getElementById('send-to-client-btn');
            if (!btn) return;
            const original = btn.innerText;
            btn.disabled = true;
            btn.innerText = 'Sending...';

            try {
                const element = document.getElementById('invoice-section');
                const opt = {
                    margin:       0.25,
                    filename:     'invoice.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 0.95, useCORS: true },
                    jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' },
                    pagebreak:    { mode: ['avoid-all','css'], after: '.quote-pane' }
                };

                const dataUrl = await html2pdf().set(opt).from(element).outputPdf('datauristring');

                const response = await fetch("{{ route('designer.invoices.send', $invoice) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ pdf: dataUrl })
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || 'Unable to send quote.');
                }

                alert('Quote sent to client.');
            } catch (err) {
                console.error(err);
                alert(err.message || 'Unable to send quote.');
            } finally {
                btn.disabled = false;
                btn.innerText = original;
            }
        }
    </script>
</x-designer-layout>
