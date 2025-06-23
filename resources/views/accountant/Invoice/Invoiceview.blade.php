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
        <h3 class="font-semibold text-fuchsia-900">Invoice ID</h3>

    </div>
     <button onclick="downloadInvoice()"
   class="flex items-center gap-2 px-4 py-2 text-[16px] font-semibold border
    rounded-full text-fuchsia-800 border-fuchsia-800">
                <i data-feather="download" class="text-fuchsia-900 w-[22px] h-[22px]"> </i>
                    Download
            </button>
{{-- <button onclick="downloadInvoice()">Download PDF</button>
    <script>
        function downloadInvoice() {
            window.print();
        }
    </script> --}}
     </div>
<div id="invoice-section">

<div class="max-w-3xl mx-auto bg-white  rounded-md shadow-md text-sm text-gray-800 font-sans">
 

<div class="p-10">
  <div class="flex justify-between items-start mb-6">

    <!-- Left: Logo -->
    <div class="w-1/2">
      <img src="{{ asset('storage/images-one/empire logo-new.png') }}" alt="Empire Logo" class="h-16">
    </div>

    <!-- Right: Info block -->
    <div class="w-1/2 flex flex-col items-end space-y-4">

      <!-- Top: Title & Company Info (right-aligned) -->
      <div class="text-right">
        <h2 class="text-lg font-bold text-gray-900 uppercase mb-1">Invoice</h2>
        <p class="font-semibold">EMPIRE KITCHENS</p>
        <p>REG: 123000123000</p>
        <p>EmpireKitchens.com | +233 123 1234 123</p>
      </div>

      <!-- Bottom: Invoice Details (left-aligned in this right box) -->
     <div class="w-full space-y-1  ">
  <div class="  flex justify-between">
    <span class="font-semibold ml-[89px]">INVOICE NUMBER:</span>
    <span>{{ $invoice->invoice_code }}</span>
  </div>
  <div class="flex justify-between">
    <span class="font-semibold ml-[89px]">INVOICE DATE:</span>
    <span>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M, Y') }}</span>
  </div>
  <div class="flex justify-between">
    <span class="font-semibold ml-[89px]">DUE DATE:</span>
    <span>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M, Y') }}</span>
  </div>
</div>


    </div>

  </div>
</div>



 <div class="p-10">
    {{-- <div class="flex justify-between items-start mb-6"> --}}
    {{-- <img src="/logo.png" alt="Logo" class="h-16"> --}}
    {{-- <img class="h-16" src="{{ public_path('images-one/empire logo-new.png') }}"
     alt="EmpireKitchenLogo"> --}}
{{-- <img src="{{ asset('storage/images-one/empire logo-new.png') }}" class="h-16" alt="Logo" class="w-32"> --}}


    {{-- <div class="text-right">
      <h2 class="text-lg font-bold text-gray-900 uppercase mb-2">Invoice</h2>
      <p class="font-semibold">EMPIRE KITCHENS</p>
      <p>REG: 123000123000</p>
      <p>EmpireKitchens.com | +233 123 1234 123</p>
    </div>
  </div> --}}

  {{-- <div class="mb-6">
    <div class="text-right ">
      <p><span class="font-semibold items-left">INVOICE NUMBER:</span> {{$invoice->invoice_code}}</p>
      <p><span class="font-semibold">INVOICE DATE:</span> {{$invoice->due_date}}</p>
      <p><span class="font-semibold">DUE DATE:</span> {{$invoice->due_date}}</p>
    </div>
  </div> --}}

  <table class="w-full text-left border border-gray-200 mb-6">
    <thead class="bg-gray-100 text-sm font-medium text-gray-700">
      <tr>
        <th class="py-2 px-4 ">Item Description</th>
        <th class="py-2 px-4  text-right">Qty</th>
        <th class="py-2 px-4  text-right">Unit Price</th>
        <th class="py-2 px-4  text-right">Amount</th>
      </tr>
    </thead>
    <tbody>
      @foreach($invoice->invoiceItems as $item)
        <tr>
            <td class="py-2 px-4">{{ $item->item_name }}</td>
            <td class="py-2 px-4 text-right">{{ $item->quantity }}</td>
            <td class="py-2 px-4 text-right">{{ $item->unit_price }}</td>
            <td class="py-2 px-4 text-right">{{ $item->total_price }}</td>
        </tr>
    @endforeach
      {{-- <tr>
        <td class="py-2 px-4">Under Cabinet Lightning</td>
        <td class="py-2 px-4 text-center">2</td>
        <td class="py-2 px-4 text-right">20,000.00</td>
        <td class="py-2 px-4 text-right">20,000.00</td>
      </tr> --}}
    </tbody>
  </table>

  <div class="flex justify-end mb-8">
    <div class="w-1/2 sm:w-1/3 bg-gray-50 rounded p-4">
      <div class="flex justify-between py-1 ">
        <span>Sub total</span>
        <span>{{ number_format($invoice->invoiceSummary->subtotal, 2) }}</span>
      </div>
      <div class="flex justify-between py-1 ">
        <span>VAT</span>
        <span>{{ number_format($invoice->invoiceSummary->vat, 2) }}</span>
      </div>
      <div class="flex justify-between py-2 font-bold">
        <span>Total Amount</span>
        <span>{{ number_format($invoice->invoiceSummary->total_amount, 2) }}</span>
      </div>
    </div>
  </div>
</div>
<div class="bg-[#6B1E7233] p-6 text-gray-800 text-sm grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

  <!-- LEFT SECTION -->
  <div class="text-left">
    <h3 class="font-semibold mb-2 text-purple-800 uppercase">Payment Instructions</h3>
    <p>Empire Kitchens</p>
    <p>Bank name: ABSA Bank Limited</p>
    <p>SWIFT: NZO201230012</p>
    <p>Account number: 12–1234–123456–12</p>
    <p>Please use <strong>{{ $invoice->invoice_code }}</strong> as a reference number</p>
    <p class="mt-4">
      For any questions please contact us at
      <a href="mailto:info@empirekitchen.com" class="text-purple-800 underline">info@empirekitchen.com</a>
    </p>
  </div>

  <!-- RIGHT SECTION -->
  <div class="flex justify-end items-start">
    <div class="text-right">
      <p>Pay online</p>
      {{-- Optional: add payment link --}}
      {{-- <a href="https://buy.stripe.com/" class="text-purple-800 underline">https://buy.stripe.com/</a> --}}
      
      {{-- QR Code --}}
      <img src="{{ asset('storage/images-one/blank_qr_code.png') }}" alt="QR Code" class="w-32 mt-2">
    </div>
  </div>
</div>


{{-- 
  <div class="bg-fuchsia-100 p-6 justify-between text-gray-800 text-sm grid grid-cols-1 gap-4 md:grid-cols-2 mb-4">

    <div>
    <h3 class="font-semibold mb-2 text-purple-800 uppercase">Payment Instructions</h3>
    <p>Empire Kitchens</p>
    <p>Bank name: ABSA Bank Limited</p>
    <p>SWIFT: NZO201230012</p>
    <p>Account number: 12–1234–123456–12</p>
    <p>Please use as {{$invoice->invoice_code}} as a reference number</p>
    <div>
        <p>For any questions please contact us at <a href="mailto:info@empirekitchen.com" class="text-purple-800 underline">info@empirekitchen.com</a></p>
      </div>
    </div> --}}


    {{-- <div class="flex justify-between items-center mt-4">
      
      <div class="text-right">
        <p>Pay online</p> --}}
        {{-- <a href="https://buy.stripe.com/" class="text-purple-800 underline">https://buy.stripe.com/</a> --}}
        {{-- <img src="/qr-code.png" alt="QR Code" class="w-16 mt-1"> --}}
        {{-- <img class="w-16 mt-1" src="{{ asset('storage/images-one/blank_qr_code.png') }}" class="h-16" alt="Logo" class="w-32"> --}}

        {{-- <div class="mt-4">
    <img src="{{ $qrPath }}" alt="QR Code" class="w-32 h-32 object-contain">
</div> --}}


      {{-- </div>
    </div>
  </div> --}}

  

</div>

</div>






      </div>
</div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

{{--exporting as pdf--}}
<script>
function downloadInvoice() {
    const element = document.getElementById('invoice-section');

    const opt = {
        // margin:       0.3,
        filename:     'invoice.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save();
}
</script>

 </x-accountant-layout>
