<?php
// app/Http/Controllers/CostsController.php
namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostsController extends Controller
{
    // Save batch of actuals for allocations
    public function store(Request $request)
    {
        $data = $request->validate([
            'budget_id'  => ['required','exists:budgets,id'],
            'entries'    => ['array'],
            'entries.*.allocation_id' => ['required','integer','exists:budget_allocations,id'],
            'entries.*.amount'        => ['required','numeric','min:0'],
            'entries.*.spent_at'      => ['nullable','date'],
            'entries.*.description'   => ['nullable','string','max:2000'],
        ]);

        $budgetId = (int) $data['budget_id'];
        $entries   = $data['entries'] ?? [];

        // Load budget and ids we allow to write
        $budget = Budget::where('id', $budgetId)->with('allocations:id,budget_id')->firstOrFail();
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

        // Redirect back to the same budget so the grid refreshes with new totals
        return redirect()->route('accountant.Project-Financials', ['budget_id' => $budgetId, 'tab' => 'cost-tracking'])
            ->with('success', 'Costs saved.');
    }


    public function fragment(Request $request)
    {
        $budgetId = (int) $request->query('budget_id', 0);

        $budget = $budgetId
            ? Budget::with([
                'allocations.category',
                'allocations.costEntries',
            ])->find($budgetId)
            : null;

        // Return ONLY the inner modal body (no layout)
        return response()->view(
            'accountant.Project-Financial._cost_modal_body',
            ['budget' => $budget]
        );
    }


}
