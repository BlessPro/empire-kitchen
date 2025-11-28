<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Budget;

class accountantProjectFinancialController extends Controller
{





    
// public function projectFinancials(Request $request)
// {
//     // Paginate the projects
//     $projects = Project::paginate(10); // 10 per page

//     // Manually attach calculated financials to each paginated project
//     $projects->getCollection()->transform(function ($project) {
//         $totalIncome = $project->incomes()->sum('amount');
//         $totalExpense = $project->expenses()->sum('amount');
//         $netProfit = $totalIncome - $totalExpense;
//         $profitMargin = $totalIncome > 0 ? ($netProfit / $totalIncome) * 100 : 0;

//         $project->total_income = $totalIncome;
//         $project->total_expense = $totalExpense;
//         $project->net_profit = $netProfit;
//         $project->profit_margin = round($profitMargin, 2);

//         return $project;
//     });

//     //for the cost tracking

//     // Transform each project with stage-wise income totals
//         // Paginate projects (10 per page)
//     $projects1 = Project::with('incomes')->paginate(10);

//     // Transform stage-wise totals for current page only
//     $projectReports = $projects->map(function ($project1) {
//         return [
//             'project_name' => $project1->name,
//             'measurement' => $project1->incomes->where('project_stage', 'Measurement')->sum('amount'),
//             'design' => $project1->incomes->where('project_stage', 'Design')->sum('amount'),
//             'production' => $project1->incomes->where('project_stage', 'Production')->sum('amount'),
//             'installation' => $project1->incomes->where('project_stage', 'Installation')->sum('amount'),
//         ];
//     });

// // Projects that HAVE budgets
//         $projectsAudit = Project::has('budget')
//             ->select('id','name')
//             ->orderBy('name')
//             ->get();

//         $selectedId = (int) $request->query('project_id', 0);
//         $projectBudget = null;

//         if ($selectedId) {
//             $projectBudget = Project::with([
//                 'budget.allocations.category',
//                 'budget.allocations.costEntries' // to show spent-to-date
//             ])->find($selectedId);
//         }



//     return view('accountant.Project-Financials', compact('projects','projectReports', 'projects1','projectsAudit','projectBudget','selectedId'));
// }


public function projectFinancials(Request $request)
{
    // ===== Existing: Profit & Loss list =====
    $projects = Project::paginate(10); // 10 per page

    $projects->getCollection()->transform(function ($project) {
        $totalIncome  = $project->incomes()->sum('amount');
        $totalExpense = $project->expenses()->sum('amount');
        $netProfit    = $totalIncome - $totalExpense;
        $profitMargin = $totalIncome > 0 ? ($netProfit / $totalIncome) * 100 : 0;

        $project->total_income   = $totalIncome;
        $project->total_expense  = $totalExpense;
        $project->net_profit     = $netProfit;
        $project->profit_margin  = round($profitMargin, 2);
        return $project;
    });

    // ===== Existing: Stage-wise income report =====
    $projects1 = Project::with('incomes')->paginate(10);

    $projectReports = $projects->map(function ($project1) {
        return [
            'project_name' => $project1->name,
            'measurement'  => $project1->incomes->where('project_stage', 'Measurement')->sum('amount'),
            'design'       => $project1->incomes->where('project_stage', 'Design')->sum('amount'),
            'production'   => $project1->incomes->where('project_stage', 'Production')->sum('amount'),
            'installation' => $project1->incomes->where('project_stage', 'Installation')->sum('amount'),
        ];
    });

    // ===== Cost tracking modal data =====
    $budgetsAudit = Budget::select('id','name')
        ->orderBy('name')
        ->get();

    $selectedBudgetId = (int) $request->query('budget_id', 0);
    $selectedBudget = $selectedBudgetId
        ? Budget::with([
            'allocations.category',
            'allocations.costEntries',
        ])->find($selectedBudgetId)
        : null;

    // ===== Budget overview table dataset =====
    $budgets = Budget::with([
        'project.client:id,firstname,lastname,title',
        'allocations:id,budget_id,amount',
        'allocations.costEntries:id,budget_allocation_id,amount',
    ])
    ->orderBy('created_at','desc')
    ->paginate(10)
    ->withQueryString();

    $budgets->getCollection()->transform(function ($budget) {
        $totalBudget = (float) ($budget->main_amount ?? 0);
        $totalCost   = (float) $budget->allocations->flatMap->costEntries->sum('amount');
        $balance     = $totalBudget - $totalCost;

        if ($totalBudget <= 0 && $totalCost <= 0) {
            $status = ['label' => 'No budget', 'tone' => 'gray'];
        } elseif ($totalBudget <= 0 && $totalCost > 0) {
            $status = ['label' => 'Over budget', 'tone' => 'red'];
        } else {
            $ratio = $totalCost / max($totalBudget, 1);
            if ($ratio < 0.80)       $status = ['label' => 'On track',   'tone' => 'green'];
            elseif ($ratio <= 1.00)  $status = ['label' => 'At risk',    'tone' => 'amber'];
            else                      $status = ['label' => 'Over budget','tone' => 'red'];
        }

        $budget->total_budget  = $totalBudget;
        $budget->total_cost    = $totalCost;
        $budget->balance       = $balance;
        $budget->budget_status = $status;
        return $budget;
    });

    // ---- COST TRACKING TABLE DATA (paginated) ----
    $defaults = ['Measurement','Design','Production','Installation'];

    $costBudgets = Budget::with([
        'project.client:id,firstname,lastname,title',
        'allocations.category:id,name',
        'allocations.costEntries:id,budget_allocation_id,amount',
    ])
    ->orderBy('created_at', 'desc')
    ->paginate(10, ['*'], 'cost_page')   // unique page name so it won't clash
    ->withQueryString();

    $costBudgets->getCollection()->transform(function ($budget) use ($defaults) {
        // roll up costs by category name
        $byCat = collect();

        foreach ($budget->allocations as $alloc) {
            $cat = $alloc->category?->name ?? 'Uncategorized';
            $sum = (float) $alloc->costEntries->sum('amount');
            $byCat[$cat] = ($byCat[$cat] ?? 0) + $sum;
        }

        // pick defaults; everything else is "Others"
        $measurement  = (float) ($byCat['Measurement']  ?? 0);
        $design       = (float) ($byCat['Design']       ?? 0);
        $production   = (float) ($byCat['Production']   ?? 0);
        $installation = (float) ($byCat['Installation'] ?? 0);

        $others = $byCat->except($defaults)->values()->sum();
        $total  = $byCat->values()->sum();

        // attach for blade
        $budget->cost_measurement  = $measurement;
        $budget->cost_design       = $design;
        $budget->cost_production   = $production;
        $budget->cost_installation = $installation;
        $budget->cost_others       = (float) $others;
        $budget->cost_total        = (float) $total;

        return $budget;
    });


    // PROFIT/LOSS TABLE (budget centric)
    $profitBudgetId = (int) $request->query('budget_id', 0);

    $projectSummary = \App\Models\Budget::with([
        'allocations.costEntries:id,budget_allocation_id,amount',
    ])
    ->when($profitBudgetId, fn ($q) => $q->where('id', $profitBudgetId))
    ->orderBy('created_at', 'desc')
    ->paginate(10, ['*'], 'pl_summary_page')
    ->withQueryString();

    $projectSummary->getCollection()->transform(function ($budget) {
        $totalBudget  = (float) ($budget->main_amount ?? 0);
        $totalExpense = (float) $budget->allocations->flatMap->costEntries->sum('amount');
        $netProfit    = $totalBudget - $totalExpense;
        $margin       = $totalBudget > 0 ? ($netProfit / $totalBudget) * 100 : 0;

        $budget->sum_total_budget  = $totalBudget;
        $budget->sum_total_expense = $totalExpense;
        $budget->sum_net_profit    = $netProfit;
        $budget->sum_margin_pct    = round($margin, 2);

        return $budget;
    });





    // Merge view data into a single associative array and pass it to the view
    $viewDataMerged = array_merge($viewData ?? [], [
        'projects'       => $projects,
        'projectReports' => $projectReports,
        'projects1'      => $projects1,
        'budgetsAudit'   => $budgetsAudit,
        'selectedBudget' => $selectedBudget,
        'selectedBudgetId' => $selectedBudgetId,
        'budgets'        => $budgets,
        'costBudgets'    => $costBudgets,
        'projectSummary'=> $projectSummary,
        'defaults'       => $defaults,
    ]);

    return view('accountant.Project-Financials', $viewDataMerged);
}


}
