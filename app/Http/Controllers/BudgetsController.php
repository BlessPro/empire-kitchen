<?php
// app/Http/Controllers/BudgetsController.php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Budget;
use App\Models\BudgetAllocation;
use App\Models\BudgetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BudgetsController extends Controller
{
    // optional landing page -> send users to create form
    public function index()
    {
        return redirect()->route('accountant.budgets.create');
    }

    public function edit(Budget $budget)
    {
        $budget->load([
            'allocations.category',
            'allocations.costEntries:id,budget_allocation_id,amount',
        ]);

        $extras = $budget->allocations->map(fn($allocation) => [
            'name'        => $allocation->category?->name ?? '',
            'amount'      => (float) $allocation->amount,
            'category_id' => $allocation->budget_category_id,
            'note'        => $allocation->note,
        ])->values();

        return view('accountant.edit-budget', [
            'budget'      => $budget,
            'extras'      => $extras,
            'main_amount' => (float) $budget->main_amount,
            'currency'    => $budget->currency ?? 'GHS',
        ]);
    }

    public function create()
    {
        return view('accountant.Project-Financial.create-budget', [
            'currency' => 'GHS',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255', Rule::unique('budgets', 'name')],
            'start_date'        => ['required', 'date'],
            'end_date'          => ['required', 'date', 'after_or_equal:start_date'],
            'main_amount'       => ['required', 'numeric', 'min:0'],
            'currency'          => ['nullable', 'string', 'max:3'],
            'extras'            => ['array'],
            'extras.*.name'     => ['required_with:extras.*.amount', 'string', 'max:255'],
            'extras.*.amount'   => ['required_with:extras.*.name', 'numeric', 'min:0'],
            'extras.*.note'     => ['nullable','string','max:2000'],
        ]);

        $name = trim($validated['name']);
        $mainAmount = (float) $validated['main_amount'];
        $extras     = collect($validated['extras'] ?? []);

        $allocTotal = $extras->sum(fn($row) => (float) ($row['amount'] ?? 0));

        if ($allocTotal > $mainAmount) {
            return back()
                ->withInput()
                ->withErrors(['main_amount' => 'Allocations ('.$allocTotal.') exceed the main budget ('.$mainAmount.'). Reduce some amounts.']);
        }

        DB::transaction(function () use ($validated, $extras, $mainAmount, $name) {
            $budget = Budget::create([
                'name'           => $name,
                'project_id'     => null,
                'main_amount'    => $mainAmount,
                'currency'       => $validated['currency'] ?? 'GHS',
                'effective_date' => $validated['start_date'],
                'start_date'     => $validated['start_date'],
                'end_date'       => $validated['end_date'],
            ]);

            // Log after commit so any failures do not poison this transaction (Postgres 25P02)
            DB::afterCommit(function () use ($budget) {
                Activity::log([
                    'project_id' => null,
                    'type'       => 'budget.created',
                    'message'    => (optional(auth()->user()->employee)->name ?? auth()->user()->name ?? 'Someone') . " created budget '{$budget->name}'",
                ]);
            });

            $rows = $extras->filter(fn($row) => !empty(trim($row['name'] ?? '')) && (float) ($row['amount'] ?? 0) > 0);

            foreach ($rows as $row) {
                $name   = trim($row['name']);
                $amount = (float) ($row['amount'] ?? 0);
                $note   = $row['note'] ?? null;

                $category = BudgetCategory::firstOrCreate(
                    ['name' => $name],
                    [
                        'description' => $name.' (custom)',
                        'is_default'  => false,
                    ]
                );

                BudgetAllocation::updateOrCreate(
                    ['budget_id' => $budget->id, 'budget_category_id' => $category->id],
                    ['amount' => $amount, 'note' => $note]
                );
            }
        });

        return redirect()
            ->route('accountant.Project-Financials', ['tab' => 'Project-Budget'])
            ->with('success', 'Budget created successfully.');
    }

    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255', Rule::unique('budgets', 'name')->ignore($budget->id)],
            'start_date'        => ['required', 'date'],
            'end_date'          => ['required', 'date', 'after_or_equal:start_date'],
            'main_amount'       => ['required', 'numeric', 'min:0'],
            'currency'          => ['nullable', 'string', 'max:3'],
            'extras'            => ['array'],
            'extras.*.name'     => ['required_with:extras.*.amount', 'string', 'max:255'],
            'extras.*.amount'   => ['required_with:extras.*.name', 'numeric', 'min:0'],
            'extras.*.note'     => ['nullable','string','max:2000'],
        ]);

        $name = trim($validated['name']);
        $extras = collect($validated['extras'] ?? []);
        $mainAmount = (float) $validated['main_amount'];

        $allocTotal = $extras->sum(fn($row) => (float) ($row['amount'] ?? 0));
        if ($allocTotal > $mainAmount) {
            return back()
                ->withInput()
                ->withErrors(['main_amount' => 'Allocations ('.$allocTotal.') exceed the main budget ('.$mainAmount.'). Reduce some amounts.']);
        }

        DB::transaction(function () use ($budget, $validated, $extras, $mainAmount, $name) {
            $budget->update([
                'name'           => $name,
                'main_amount'    => $mainAmount,
                'currency'       => $validated['currency'] ?? $budget->currency,
                'start_date'     => $validated['start_date'],
                'end_date'       => $validated['end_date'],
                'effective_date' => $validated['start_date'],
            ]);

            $rows = $extras->filter(fn($row) => !empty(trim($row['name'] ?? '')));

            $catIdsByName = BudgetCategory::query()
                ->whereIn('name', $rows->pluck('name')->unique()->values())
                ->pluck('id', 'name');

            $toUpsert = [];
            foreach ($rows as $row) {
                $name   = trim($row['name']);
                $amount = (float) ($row['amount'] ?? 0);
                $note   = $row['note'] ?? null;

                $catId = $catIdsByName[$name] ?? null;
                if (!$catId) {
                    $cat = BudgetCategory::create([
                        'name'        => $name,
                        'description' => $name.' (custom)',
                        'is_default'  => false,
                    ]);
                    $catId = $cat->id;
                    $catIdsByName[$name] = $catId;
                }

                $toUpsert[] = [
                    'budget_id'          => $budget->id,
                    'budget_category_id' => $catId,
                    'amount'             => $amount,
                    'note'               => $note,
                    'updated_at'         => now(),
                    'created_at'         => now(),
                ];
            }

            foreach ($toUpsert as $row) {
                BudgetAllocation::updateOrCreate(
                    [
                        'budget_id'          => $row['budget_id'],
                        'budget_category_id' => $row['budget_category_id'],
                    ],
                    ['amount' => $row['amount'], 'note' => $row['note']]
                );
            }

            $keepCatIds = collect($toUpsert)->pluck('budget_category_id')->unique()->all();
            BudgetAllocation::where('budget_id', $budget->id)
                ->whereNotIn('budget_category_id', $keepCatIds)
                ->delete();
        });

        return redirect()
            ->route('accountant.Project-Financials')
            ->with('success', 'Budget updated successfully.');
    }

    public function destroy(Budget $budget)
    {
        DB::transaction(function () use ($budget) {
            foreach ($budget->allocations as $alloc) {
                $alloc->costEntries()->delete();
            }
            $budget->allocations()->delete();
            $budget->delete();
        });

        return redirect()
            ->route('accountant.Project-Financials')
            ->with('success', 'Budget deleted.');
    }

    public function show(Budget $budget)
    {
        $budget->load([
            'allocations.category',
            'allocations.costEntries:id,budget_allocation_id,amount',
        ]);

        $currency = $budget->currency ?? 'GHS';

        $allocations = $budget->allocations->map(function ($alloc) use ($currency) {
            $costTotal = $alloc->costEntries->sum('amount');
            return [
                'name'       => $alloc->category?->name ?? 'Category',
                'amount'     => (float) $alloc->amount,
                'note'       => $alloc->note,
                'cost_total' => (float) $costTotal,
                'balance'    => (float) $alloc->amount - $costTotal,
            ];
        });

        $totals = [
            'budget'  => (float) ($budget->main_amount ?? 0),
            'cost'    => (float) $allocations->sum('cost_total'),
            'balance' => (float) (($budget->main_amount ?? 0) - $allocations->sum('cost_total')),
        ];

        return view('accountant.Project-Financial.show-budget', [
            'budget'      => $budget,
            'currency'    => $currency,
            'allocations' => $allocations,
            'totals'      => $totals,
        ]);
    }
}
