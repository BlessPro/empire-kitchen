<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Income;
use App\Models\Invoice;
use App\Models\InvoiceSummary;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class accountantPayController extends Controller
{
    public function index()
    {
        $clients             = Client::orderBy('firstname')->get();
        $projects            = Project::with('client')->orderBy('name')->get();
        $incomes             = Income::with(['client', 'project', 'category'])->latest()->get();
        $categories          = Category::orderBy('name')->get();
        $nextTransactionId   = $this->supportsTransactionId()
            ? $this->generateTransactionId()
            : null;

        return view('accountant.Payment.Pay', compact(
            'clients',
            'projects',
            'categories',
            'incomes',
            'nextTransactionId'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'     => ['required', 'exists:projects,id'],
            'amount'         => ['required', 'numeric', 'min:0.01'],
            'date'           => ['required', 'date'],
            'payment_method' => ['required', 'string', 'in:Cash,Bank Transfer,Mobile Money'],
            'transaction_id' => ['nullable', 'string', 'max:255'],
        ]);

        $project = Project::with('client')->findOrFail($validated['project_id']);

        $category = Category::firstOrCreate(['name' => 'General Payments']);

        $transactionId = null;

        if ($this->supportsTransactionId()) {
            $transactionId = $request->filled('transaction_id')
                ? $request->input('transaction_id')
                : $this->generateTransactionId();
        }

        $attributes = [
            'client_id'      => $project->client_id,
            'project_id'     => $project->id,
            'category_id'    => $category->id,
            'amount'         => $validated['amount'],
            'date'           => $validated['date'],
            'project_stage'  => null,
            'payment_method' => $validated['payment_method'],
        ];

        if ($transactionId !== null) {
            $attributes['transaction_id'] = $transactionId;
        }

        $income = Income::create([
            ...$attributes,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Payment recorded successfully.',
                'income'  => $income->only([
                    'id',
                    'project_id',
                    'amount',
                    'date',
                    'payment_method',
                    'transaction_id',
                ]),
            ]);
        }

        return redirect()->back()->with('success', 'Payment recorded successfully!');
    }

    public function getProjectsByClient1($clientId)
    {
        $clients = Project::where('client_id', $clientId)->get();

        return view('accountant.Payment.Pay', compact('clients'));
    }

    public function getByClient($id)
    {
        $projects = Project::where('client_id', $id)->get();

        return response()->json($projects);
    }

    public function projectFinancialSummary(Project $project)
    {
        $invoiceIds = Invoice::where('project_id', $project->id)->pluck('id');

        $invoiceTotal = $invoiceIds->isEmpty()
            ? 0
            : InvoiceSummary::whereIn('invoice_id', $invoiceIds)->sum('total_amount');

        $totalPaid = Income::where('project_id', $project->id)->sum('amount');

        $balance = max($invoiceTotal - $totalPaid, 0);

        return response()->json([
            'client_id'    => $project->client_id,
            'project_cost' => (float) $invoiceTotal,
            'total_paid'   => (float) $totalPaid,
            'balance'      => (float) $balance,
        ]);
    }

    protected function supportsTransactionId(): bool
    {
        static $supports = null;

        if ($supports === null) {
            $supports = Schema::hasColumn('incomes', 'transaction_id');
        }

        return $supports;
    }

    protected function generateTransactionId(): string
    {
        $latest = Income::whereNotNull('transaction_id')
            ->where('transaction_id', 'like', 'T-%')
            ->orderByDesc('transaction_id')
            ->value('transaction_id');

        $nextNumber = 1;

        if ($latest) {
            $numeric = (int) Str::after($latest, 'T-');
            $nextNumber = $numeric + 1;
        }

        return sprintf('T-%03d', $nextNumber);
    }
}
