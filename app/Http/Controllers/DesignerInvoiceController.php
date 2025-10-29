<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceSummary;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignerInvoiceController extends Controller
{
    public function create(Request $request)
    {
        $designerId = Auth::id();

        $clients = Client::whereHas('projects', function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            })
            ->with(['projects' => function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            }])
            ->orderBy('firstname')
            ->get();

        $selectedProject = null;
        $selectedClient = null;

        if ($request->filled('project')) {
            $selectedProject = Project::where('designer_id', $designerId)
                ->where('id', $request->query('project'))
                ->with('client')
                ->first();

            $selectedClient = $selectedProject?->client;
        }

        return view('designer.Invoice', [
            'clients'         => $clients,
            'selectedProject' => $selectedProject,
            'selectedClient'  => $selectedClient,
        ]);
    }

    public function projects(Client $client)
    {
        $designerId = Auth::id();

        $projects = Project::where('designer_id', $designerId)
            ->where('client_id', $client->id)
            ->get(['id', 'name']);

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $designerId = Auth::id();

        $validated = $request->validate([
            'invoice_code'          => ['required','string','unique:invoices,invoice_code'],
            'client_id'             => ['required','exists:clients,id'],
            'project_id'            => ['required','exists:projects,id'],
            'due_date'              => ['required','date'],
            'items'                 => ['required','array','min:1'],
            'items.*.item_name'     => ['required','string'],
            'items.*.quantity'      => ['required','integer','min:1'],
            'items.*.unit_price'    => ['required','numeric','min:0'],
            'items.*.description'   => ['nullable','string'],
            'send_email'            => ['nullable','boolean'],
        ]);

        $project = Project::where('id', $validated['project_id'])
            ->where('designer_id', $designerId)
            ->firstOrFail();

        if ((int) $project->client_id !== (int) $validated['client_id']) {
            return back()->withErrors('Selected project does not belong to the chosen client.')->withInput();
        }

        $invoice = Invoice::create([
            'invoice_code' => $validated['invoice_code'],
            'client_id'    => $validated['client_id'],
            'project_id'   => $project->id,
            'user_id'      => $designerId,
            'invoice_type' => 'design',
            'due_date'     => $validated['due_date'],
            'send_email'   => $request->boolean('send_email'),
        ]);

        $subtotal = 0;

        foreach ($validated['items'] as $item) {
            $total = $item['quantity'] * $item['unit_price'];
            $subtotal += $total;

            InvoiceItem::create([
                'invoice_id'   => $invoice->id,
                'item_name'    => $item['item_name'],
                'description'  => $item['description'] ?? null,
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],
                'total_price'  => $total,
            ]);
        }

        $vat = $subtotal * 0.15;
        $totalAmount = $subtotal + $vat;

        InvoiceSummary::create([
            'invoice_id'   => $invoice->id,
            'subtotal'     => $subtotal,
            'vat'          => $vat,
            'total_amount' => $totalAmount,
        ]);

        return redirect()->route('designer.invoices.show', $invoice)->with('success', 'Invoice saved successfully!');
    }

    public function show(Invoice $invoice)
    {
        $designerId = Auth::id();

        $invoice->load(['client', 'project', 'invoiceItems', 'invoiceSummary']);

        if (optional($invoice->project)->designer_id !== $designerId) {
            abort(403);
        }

        return view('designer.Invoice.show', compact('invoice'));
    }
}

