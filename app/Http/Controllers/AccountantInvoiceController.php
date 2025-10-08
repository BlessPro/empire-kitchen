<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  use App\Models\Client;
  use App\Models\Project;
  use App\Models\InvoiceSummary;
  use App\Models\Invoice;
  use App\Models\InvoiceItem;
  use Illuminate\Support\Facades\Storage;


class AccountantInvoiceController extends Controller
{

public function index()
{
    $clients = Client::all(); // Fetch all clients
    return view('accountant.Invoice', compact('clients'));
}


public function invoiceview($id)
{

     $invoice = Invoice::with(['client', 'project', 'invoiceItems', 'invoiceSummary'])
                ->findOrFail($id);

       // Data you want encoded in QR (could also be a URL)
    // $qrData = route('accountant.Invoice.Invoiceview', $invoice->id);

    // // Generate PNG QR code
    // $qrImage = QrCode::format('png')->size(200)->generate($qrData);

    // // Save to storage/app/public/qrcodes/


    return view('accountant.Invoice.Invoiceview', compact('invoice'));
}


public function getProjectsByClient($client_id)
{
    $projects = Project::where('client_id', $client_id)->get();
    return response()->json($projects); // return projects as JSON
}

 public function getClientProjects($clientId)
    {
        $projects = Project::where('client_id', $clientId)->get(['id', 'name']);
        return response()->json($projects);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'invoice_code' => 'required|string|unique:invoices,invoice_code',
        'client_id' => 'required|exists:clients,id',
        'project_id' => 'required|exists:projects,id',
        'due_date' => 'required|date',
        'items' => 'required|array|min:1',
        'items.*.item_name' => 'required|string',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.description' => 'nullable|string',
        'send_email' => 'nullable|boolean',
    ]);

    // 1. Save invoice
    $invoice = Invoice::create([
        'invoice_code' => $validated['invoice_code'],
        'client_id' => $validated['client_id'],
        'project_id' => $validated['project_id'],
        'due_date' => $validated['due_date'],
        'send_email' => $request->has('send_email'),
    ]);

    // 2. Save items and calculate subtotal
    $subtotal = 0;

    foreach ($validated['items'] as $item) {
        $total = $item['quantity'] * $item['unit_price'];
        $subtotal += $total;

        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'item_name' => $item['item_name'],
            'description' => $item['description'] ?? null,
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'total_price' => $total,
        ]);
    }

    // 3. Calculate VAT and total
    $vat = $subtotal * 0.15; // 15% VAT
    $totalAmount = $subtotal + $vat;

    // 4. Save summary
    InvoiceSummary::create([
        'invoice_id' => $invoice->id,
        'subtotal' => $subtotal,
        'vat' => $vat,
        'total_amount' => $totalAmount,
    ]);

    // 5. Redirect or return success
  return redirect()->back()->with('success', 'Invoice saved successfully!');

}



}
