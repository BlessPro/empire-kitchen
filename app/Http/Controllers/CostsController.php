<?php
// app/Http/Controllers/CostsController.php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Budget;
use App\Models\BudgetAllocation;
use App\Models\CostEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CostsController extends Controller
{
    // Show the project selector + grid of budget items for the selected project
    public function create(Request $request)
    {
        // Projects that HAVE budgets
        $projects = Project::has('budget')
            ->select('id','name')
            ->orderBy('name')
            ->get();

        $selectedId = (int) $request->query('project_id', 0);
        $project = null;

        if ($selectedId) {
            $project = Project::with([
                'budget.allocations.category',
                'budget.allocations.costEntries' // to show spent-to-date
            ])->find($selectedId);
        }

        return view('accountant.Project-Financials', compact('projects','project','selectedId'));
    }

    // Save batch of actuals for allocations
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => ['required','exists:projects,id'],
            'entries'    => ['array'],
            'entries.*.allocation_id' => ['required','integer','exists:budget_allocations,id'],
            'entries.*.amount'        => ['required','numeric','min:0'],
            'entries.*.spent_at'      => ['nullable','date'],
            'entries.*.description'   => ['nullable','string','max:2000'],
        ]);

        $projectId = (int) $data['project_id'];
        $entries   = $data['entries'] ?? [];

        // Load budget and ids we allow to write
        $budget = Budget::where('project_id', $projectId)->with('allocations:id,budget_id')->firstOrFail();
        $allowedAllocationIds = $budget->allocations->pluck('id')->all();

        // Filter: only valid allocation ids for this project's budget, and non-zero amounts
        $toInsert = [];
        foreach ($entries as $row) {
            $allocId = (int) ($row['allocation_id'] ?? 0);
            $amount  = (float) ($row['amount'] ?? 0);
            if ($allocId && $amount > 0 && in_array($allocId, $allowedAllocationIds, true)) {
                $toInsert[] = [
                    'budget_allocation_id' => $allocId,
                    'amount'      => $amount,
                    'spent_at'    => $row['spent_at'] ?? now()->toDateString(),
                    'description' => $row['description'] ?? null,
                    'created_by'  => optional($request->user())->id,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }

        if (empty($toInsert)) {
            return back()->withInput()->with('info', 'Nothing to save. Enter at least one amount.');
        }

        DB::table('cost_entries')->insert($toInsert);

        // Redirect back to the same project so the grid refreshes with new totals
        return redirect()->route('accountant.Project-Financials', ['project_id' => $projectId])
            ->with('success', 'Costs saved.');
    }


    public function fragment(Request $request)
{
    $projectId = (int) $request->query('project_id', 0);

    $projectBudget = $projectId
        ? Project::with([
            'budget.allocations.category',
            'budget.allocations.costEntries',
        ])->find($projectId)
        : null;

    // Return ONLY the inner modal body (no layout)
    return response()->view(
        'accountant.Project-Financial._cost_modal_body',
        ['projectBudget' => $projectBudget]
    );
}


}
