<x-designer-layout>
    <x-slot name="header">
        @include('admin.layouts.header')
    </x-slot>

    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen items-center">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Invoice {{ $invoice->invoice_code }}</h1>
                    <p class="text-sm text-slate-500">Due {{ optional($invoice->due_date)->format('M d, Y') ?? 'N/A' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-500">Created by</p>
                    <p class="text-base font-medium text-slate-800">{{ optional($invoice->user)->name ?? 'Designer' }}</p>
                    <span class="inline-flex mt-1 px-3 py-1 text-xs font-semibold rounded-full bg-violet-100 text-violet-700 uppercase">{{ $invoice->invoice_type }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-violet-50 rounded-xl p-4">
                    <h2 class="text-sm font-semibold text-violet-900 mb-2">Client</h2>
                    <p class="text-base font-medium text-slate-800">{{ $invoice->client->firstname }} {{ $invoice->client->lastname }}</p>
                    <p class="text-sm text-slate-600">{{ $invoice->client->email }}</p>
                    <p class="text-sm text-slate-600">{{ $invoice->client->phone_number }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4">
                    <h2 class="text-sm font-semibold text-slate-900 mb-2">Project</h2>
                    <p class="text-base font-medium text-slate-800">{{ $invoice->project->name ?? 'N/A' }}</p>
                    <p class="text-sm text-slate-600">{{ $invoice->project->location ?? '—' }}</p>
                </div>
            </div>

            <div class="overflow-hidden border border-slate-200 rounded-xl mb-8">
                <table class="w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Item</th>
                            <th class="px-4 py-3 text-left">Description</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-right">Unit Price</th>
                            <th class="px-4 py-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->invoiceItems as $item)
                            <tr class="border-t border-slate-200">
                                <td class="px-4 py-3 text-slate-800">{{ $item->item_name }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $item->description ?? '—' }}</td>
                                <td class="px-4 py-3 text-right text-slate-600">{{ number_format($item->quantity) }}</td>
                                <td class="px-4 py-3 text-right text-slate-600">GHS {{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-4 py-3 text-right text-slate-800 font-medium">GHS {{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-end gap-4">
                <div class="bg-slate-50 rounded-xl px-5 py-4 w-full md:w-80">
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-600">Subtotal</dt>
                            <dd class="text-slate-800 font-medium">GHS {{ number_format(optional($invoice->invoiceSummary)->subtotal ?? 0, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-600">VAT</dt>
                            <dd class="text-slate-800 font-medium">GHS {{ number_format(optional($invoice->invoiceSummary)->vat ?? 0, 2) }}</dd>
                        </div>
                        <div class="flex justify-between text-base font-semibold text-slate-900">
                            <dt>Total</dt>
                            <dd>GHS {{ number_format(optional($invoice->invoiceSummary)->total_amount ?? 0, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </main>
</x-designer-layout>
