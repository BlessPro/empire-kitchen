<x-designer-layout>
    <x-slot name="header">
        @include('admin.layouts.header')
    </x-slot>

    <main class="bg-[#F9F7F7] min-h-screen">
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">Invoice Area</h1>
            </div>

            <div class="p-6 bg-white rounded-2xl shadow">
                @if($invoices->isEmpty())
                    <p class="text-sm text-gray-600">No invoices found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-800">
                            <thead>
                                <tr class="text-xs text-gray-500 uppercase bg-gray-50">
                                    <th class="px-4 py-2">Project</th>
                                    <th class="px-4 py-2">Invoice ID</th>
                                    <th class="px-4 py-2">Amount</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($invoices as $inv)
                                    <tr>
                                        <td class="px-4 py-2">
                                            {{ $inv->project?->name ?? '—' }}
                                        </td>
                                        <td class="px-4 py-2 font-semibold text-gray-900">
                                            {{ $inv->invoice_code ?? ('INV-'.$inv->id) }}
                                        </td>
                                        <td class="px-4 py-2">
                                            @php
                                                $amount = optional($inv->summary)->grand_total
                                                    ?? optional($inv->invoiceSummary)->grand_total
                                                    ?? optional($inv->invoiceSummary)->total
                                                    ?? null;
                                            @endphp
                                            {{ $amount !== null ? number_format($amount, 2) : '—' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('designer.invoices.show', $inv) }}"
                                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white rounded-md bg-[#5A0562] hover:bg-[#4a044c]">
                                                    View
                                                </a>
                                                <a href="{{ route('designer.invoices.show', $inv) }}"
                                                   class="inline-flex items-center justify-center w-9 h-9 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50"
                                                   title="View">
                                                    <span class="iconify text-lg" data-icon="ph:eye"></span>
                                                </a>
                                                @can('update', $inv)
                                                <a href="{{ route('designer.invoices.show', $inv) }}"
                                                   class="inline-flex items-center justify-center w-9 h-9 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50"
                                                   title="Edit">
                                                    <span class="iconify text-lg" data-icon="ph:pencil-simple"></span>
                                                </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $invoices->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</x-designer-layout>
