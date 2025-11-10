<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Income;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Budget;
use App\Models\BudgetCategory;
use App\Models\BudgetAllocation;

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

    // ===== Existing: Cost tracking modal data =====
    $projectsAudit = Project::has('budget')
        ->select('id','name')
        ->orderBy('name')
        ->get();

    $selectedId = (int) $request->query('project_id', 0);
    $projectBudget = null;

    if ($selectedId) {
        $projectBudget = Project::with([
            'budget.allocations.category',
            'budget.allocations.costEntries',
        ])->find($selectedId);
    }

    // ===== NEW: Dataset for the Budget Status table =====
    $projectsBudget = Project::with([
        'client:id,firstname,lastname,title',
        'budget:id,project_id,main_amount,currency',
        'budget.allocations:id,budget_id,amount',
        'budget.allocations.costEntries:id,budget_allocation_id,amount',
    ])
    ->orderBy('created_at','desc')
    ->paginate(10)
    ->withQueryString();

    // Compute totals & status per row
    $projectsBudget->getCollection()->transform(function ($p) {
        $totalBudget = (float) ($p->budget->main_amount ?? 0);
        $totalCost   = $p->budget
            ? (float) $p->budget->allocations->flatMap->costEntries->sum('amount')
            : 0.0;
        $balance     = $totalBudget - $totalCost;

        // Status pill logic
        if (!$p->budget) {
            $status = ['label' => 'No budget', 'tone' => 'gray'];
        } elseif ($totalBudget <= 0 && $totalCost > 0) {
            $status = ['label' => 'Over budget', 'tone' => 'red'];
        } else {
            $ratio = $totalBudget > 0 ? ($totalCost / $totalBudget) : 0;
            if ($ratio < 0.80)       $status = ['label' => 'On track',   'tone' => 'green'];
            elseif ($ratio <= 1.00)  $status = ['label' => 'At risk',    'tone' => 'amber'];
            else                      $status = ['label' => 'Over budget','tone' => 'red'];
        }

        $p->total_budget  = $totalBudget;
        $p->total_cost    = $totalCost;
        $p->balance       = $balance;
        $p->budget_status = $status;
        return $p;
    });


// ---- COST TRACKING TABLE DATA (paginated) ----
$costProjects = \App\Models\Project::with([
    'client:id,firstname,lastname,title',
    'budget.allocations.category:id,name',
    'budget.allocations.costEntries:id,budget_allocation_id,amount',
])
->orderBy('created_at', 'desc')
->paginate(10, ['*'], 'cost_page')   // unique page name so it won't clash
->withQueryString();

$defaults = ['Measurement','Design','Production','Installation'];

$costProjects->getCollection()->transform(function ($p) use ($defaults) {
    // roll up costs by category name
    $byCat = collect();

    if ($p->budget) {
        foreach ($p->budget->allocations as $alloc) {
            $cat = $alloc->category?->name ?? 'Uncategorized';
            $sum = (float) $alloc->costEntries->sum('amount');
            $byCat[$cat] = ($byCat[$cat] ?? 0) + $sum;
        }
    }

    // pick defaults; everything else is "Others"
    $measurement  = (float) ($byCat['Measurement']  ?? 0);
    $design       = (float) ($byCat['Design']       ?? 0);
    $production   = (float) ($byCat['Production']   ?? 0);
    $installation = (float) ($byCat['Installation'] ?? 0);

    $others = $byCat->except($defaults)->values()->sum();
    $total  = $byCat->values()->sum();

    // attach for blade
    $p->cost_measurement  = $measurement;
    $p->cost_design       = $design;
    $p->cost_production   = $production;
    $p->cost_installation = $installation;
    $p->cost_others       = (float) $others;
    $p->cost_total        = (float) $total;

    return $p;
});


// PROJECT-LEVEL SUMMARY TABLE
$projectSummary = \App\Models\Project::with([
    'budget:id,project_id,main_amount',
    'budget.allocations.costEntries:id,budget_allocation_id,amount',
    'incomes:id,project_id,amount',
])
->orderBy('created_at', 'desc')
->paginate(10, ['*'], 'pl_summary_page')
->withQueryString();

$projectSummary->getCollection()->transform(function ($row) {
    $totalBudget  = (float) ($row->budget->main_amount ?? 0);
    $totalExpense = (float) ($row->budget
        ? $row->budget->allocations->flatMap->costEntries->sum('amount')
        : 0);
    $totalIncome  = (float) $row->incomes->sum('amount');
    $netProfit    = $totalIncome - $totalExpense;
    $margin       = $totalIncome > 0 ? ($netProfit / $totalIncome) * 100 : 0;

    $row->sum_total_budget  = $totalBudget;
    $row->sum_total_expense = $totalExpense;
    $row->sum_total_income  = $totalIncome;
    $row->sum_net_profit    = $netProfit;
    $row->sum_margin_pct    = round($margin, 2);

    return $row;
});





    // Merge view data into a single associative array and pass it to the view
    $viewDataMerged = array_merge($viewData ?? [], [
        'projects'       => $projects,
        'projectReports' => $projectReports,
        'projects1'      => $projects1,
        'projectsAudit'  => $projectsAudit,
        'projectBudget'  => $projectBudget,
        'selectedId'     => $selectedId,
        'projectsBudget' => $projectsBudget,
        'costProjects'   => $costProjects,
        'projectSummary'=> $projectSummary,
        'defaults'       => $defaults,
    ]);

    return view('accountant.Project-Financials', $viewDataMerged);
}


}
