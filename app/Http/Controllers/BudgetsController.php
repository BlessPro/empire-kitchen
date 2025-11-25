<?php
// app/Http/Controllers/BudgetsController.php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Budget;
use App\Models\BudgetAllocation;
use App\Models\BudgetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Activity;

class BudgetsController extends Controller
{
    // Show edit page for a project's budget (or redirect if none)
    public function edit(Project $project)
    {
        $project->load([
            'client:id,firstname,lastname,title',
            'budget.allocations.category',
            'budget.allocations.costEntries:id,budget_allocation_id,amount'
        ]);

        if (!$project->budget) {
            return redirect()
                ->route('accountant.Project-Financials')
                ->with('info', 'This project has no budget yet. Use “Create Budget”.');
        }

        // map allocations by category name for defaults
        $byName = collect($project->budget->allocations)->keyBy(fn($a) => $a->category?->name ?? 'Uncategorized');

        $defaults = ['Measurement','Design','Production','Installation'];
        $defaultRows = collect($defaults)->map(fn($n) => [
            'name'   => $n,
            'amount' => (float) optional($byName->get($n))->amount ?? 0,
            'category_id' => optional($byName->get($n))->budget_category_id,
        ]);

        // extras = anything not in defaults
        $extras = $byName->reject(fn($a, $name) => in_array($name, $defaults, true))
            ->values()
            ->map(fn($a) => [
                'name'        => $a->category?->name ?? 'Uncategorized',
                'amount'      => (float) $a->amount,
                'category_id' => $a->budget_category_id,
            ]);

        return view('accountant.edit-budget', [
            'project'      => $project,
            'defaults'     => $defaultRows,
            'extras'       => $extras,
            'main_amount'  => (float) $project->budget->main_amount,
            'currency'     => $project->budget->currency ?? 'GHS',
        ]);
    }

    public function create()
    {
        $projects = Project::doesntHave('budget')
            ->with(['client:id,firstname,lastname,title'])
            ->select('id','name','client_id')
            ->orderBy('name')
            ->get();

        $defaults = collect(['Measurement','Design','Production','Installation'])
            ->map(fn($name) => ['name' => $name, 'amount' => 0]);

        return view('accountant.Project-Financial.create-budget', [
            'projects'  => $projects,
            'defaults'  => $defaults,
            'currency'  => 'GHS',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'                 => ['required','exists:projects,id', Rule::unique('budgets','project_id')],
            'main_amount'                => ['required','numeric','min:0'],
            'currency'                   => ['nullable','string','max:3'],
            'defaults'                   => ['array'],
            'defaults.*.name'            => ['required','string','max:255'],
            'defaults.*.amount'          => ['nullable','numeric','min:0'],
            'extras'                     => ['array'],
            'extras.*.name'              => ['required_with:extras.*.amount','string','max:255'],
            'extras.*.amount'            => ['required_with:extras.*.name','numeric','min:0'],
        ], [
            'project_id.unique' => 'This project already has a budget.',
        ]);

        $mainAmount = (float) $validated['main_amount'];
        $defaults   = collect($validated['defaults'] ?? []);
        $extras     = collect($validated['extras'] ?? []);

        $allocTotal = $defaults->sum(fn($row) => (float) ($row['amount'] ?? 0))
            + $extras->sum(fn($row) => (float) ($row['amount'] ?? 0));

        if ($allocTotal > $mainAmount) {
            return back()
                ->withInput()
                ->withErrors(['main_amount' => 'Allocations ('.$allocTotal.') exceed the main budget ('.$mainAmount.'). Reduce some amounts.']);
        }

        DB::transaction(function () use ($validated, $defaults, $extras, $mainAmount) {
            $budget = Budget::create([
                'project_id'    => $validated['project_id'],
                'main_amount'   => $mainAmount,
                'currency'      => $validated['currency'] ?? 'GHS',
                'effective_date'=> now()->toDateString(),
            ]);
            $project = Project::find($validated['project_id']);
            Activity::log([
                'project_id' => $project->id,
                'type'       => 'budget.created',
                'message'    => (optional(auth()->user()->employee)->name ?? auth()->user()->name ?? 'Someone') . " created budget for '{$project->name}'",
            ]);

            $rows = $defaults->merge($extras)->filter(fn($row) => !empty(trim($row['name'] ?? '')));

            foreach ($rows as $row) {
                $name = trim($row['name']);
                $amount = (float) ($row['amount'] ?? 0);
                if ($amount <= 0) {
                    continue;
                }

                $category = BudgetCategory::firstOrCreate(
                    ['name' => $name],
                    [
                        'description' => $name.' (custom)',
                        'is_default'  => in_array($name, ['Measurement','Design','Production','Installation'], true),
                    ]
                );

                BudgetAllocation::updateOrCreate(
                    ['budget_id' => $budget->id, 'budget_category_id' => $category->id],
                    ['amount' => $amount]
                );
            }
        });

        return redirect()
            ->route('accountant.Project-Financials', ['tab' => 'Project-Budget'])
            ->with('success', 'Budget created successfully.');
    }

    // Update budget: main amount + allocations (defaults + extras)
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'main_amount'                 => ['required','numeric','min:0'],
            'currency'                    => ['nullable','string','max:3'],
            'defaults'                    => ['array'],
            'defaults.*.name'             => ['required','string','max:255'],
            'defaults.*.amount'           => ['nullable','numeric','min:0'],
            'extras'                      => ['array'],
            'extras.*.name'               => ['required','string','max:255'],
            'extras.*.amount'             => ['nullable','numeric','min:0'],
        ]);

        DB::transaction(function () use ($project, $validated) {
            // ensure budget exists
            $budget = $project->budget ?: Budget::create([
                'project_id'   => $project->id,
                'main_amount'  => 0,
                'currency'     => $validated['currency'] ?? 'GHS',
            ]);

            // update main amount/currency
            $budget->update([
                'main_amount' => (float) $validated['main_amount'],
                'currency'    => $validated['currency'] ?? $budget->currency,
            ]);

            $rows = collect($validated['defaults'] ?? [])
                ->merge($validated['extras'] ?? [])
                ->filter(fn($r) => ($r['name'] ?? '') !== '');

            // Build/lookup categories (create if not exists for extras)
            $catIdsByName = BudgetCategory::query()
                ->whereIn('name', $rows->pluck('name')->unique()->values())
                ->pluck('id','name');

            $toUpsert = [];
            foreach ($rows as $r) {
                $name   = trim($r['name']);
                $amount = (float) ($r['amount'] ?? 0);

                // resolve/create category
                $catId = $catIdsByName[$name] ?? null;
                if (!$catId) {
                    $cat = BudgetCategory::create([
                        'name'        => $name,
                        'description' => $name.' (custom)',
                        'is_default'  => in_array($name, ['Measurement','Design','Production','Installation'], true) ? 1 : 0,
                    ]);
                    $catId = $cat->id;
                    $catIdsByName[$name] = $catId;
                }

                $toUpsert[] = [
                    'budget_id'          => $budget->id,
                    'budget_category_id' => $catId,
                    'amount'             => $amount,
                    'updated_at'         => now(),
                    'created_at'         => now(),
                ];
            }

            // Upsert allocations by (budget_id, budget_category_id)
            // If you don’t have a unique index on that pair, consider adding one.
            foreach ($toUpsert as $row) {
                BudgetAllocation::updateOrCreate(
                    [
                        'budget_id'          => $row['budget_id'],
                        'budget_category_id' => $row['budget_category_id'],
                    ],
                    ['amount' => $row['amount']]
                );
            }

            // Optionally remove allocations that were deleted in the form
            $keepCatIds = collect($toUpsert)->pluck('budget_category_id')->unique()->all();
            BudgetAllocation::where('budget_id', $budget->id)
                ->whereNotIn('budget_category_id', $keepCatIds)
                ->delete();
        });

        return redirect()
            ->route('accountant.Project-Financials')
            ->with('success', 'Budget updated successfully.');
    }

    // Delete budget (and children)
    public function destroy(Project $project)
    {
        if (!$project->budget) {
            return back()->with('info', 'This project has no budget to delete.');
        }

        DB::transaction(function () use ($project) {
            // If FK cascades are not set, delete children manually:
            foreach ($project->budget->allocations as $alloc) {
                $alloc->costEntries()->delete();
            }
            $project->budget->allocations()->delete();
            $project->budget()->delete();
        });

        return redirect()
            ->route('accountant.Project-Financials')
            ->with('success', 'Budget deleted.');
    }
}
