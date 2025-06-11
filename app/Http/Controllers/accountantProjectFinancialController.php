<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Income;
use App\Models\Expense;

class accountantProjectFinancialController extends Controller
{
    //
   

// public function projectFinancials()
// {
//     $projects = Project::all();
//     $projects = Project::paginate(10); // 10 per page

//     $financials = $projects->map(function ($project) {
//         $totalIncome = $project->incomes()->sum('amount');
//         $totalExpense = $project->expenses()->sum('amount');
//         $netProfit = $totalIncome - $totalExpense;
//         $profitMargin = $totalIncome > 0 ? ($netProfit / $totalIncome) * 100 : 0;

//         return [
//             'project_name' => $project->name,
//             'total_income' => $totalIncome,
//             'total_expense' => $totalExpense,
//             'net_profit' => $netProfit,
//             'profit_margin' => round($profitMargin, 2),
//         ];
//     });

//     return view('accountant.Project-Financials', compact('financials'));
// }


public function projectFinancials()
{
    // Paginate the projects
    $projects = Project::paginate(10); // 10 per page

    // Manually attach calculated financials to each paginated project
    $projects->getCollection()->transform(function ($project) {
        $totalIncome = $project->incomes()->sum('amount');
        $totalExpense = $project->expenses()->sum('amount');
        $netProfit = $totalIncome - $totalExpense;
        $profitMargin = $totalIncome > 0 ? ($netProfit / $totalIncome) * 100 : 0;

        $project->total_income = $totalIncome;
        $project->total_expense = $totalExpense;
        $project->net_profit = $netProfit;
        $project->profit_margin = round($profitMargin, 2);

        return $project;
    });

    //for the cost tracking

    // Transform each project with stage-wise income totals
        // Paginate projects (10 per page)
    $projects1 = Project::with('incomes')->paginate(10);

    // Transform stage-wise totals for current page only
    $projectReports = $projects->map(function ($project1) {
        return [
            'project_name' => $project1->name,
            'measurement' => $project1->incomes->where('project_stage', 'Measurement')->sum('amount'),
            'design' => $project1->incomes->where('project_stage', 'Design')->sum('amount'),
            'production' => $project1->incomes->where('project_stage', 'Production')->sum('amount'),
            'installation' => $project1->incomes->where('project_stage', 'Installation')->sum('amount'),
        ];
    });

    // Return both reports and paginator
    // return view('accountant.Project-Financial.ProjectStageReport', [
    //     'projectReports' => $projectReports,
    //     'projects1' => $projects // for pagination links
    // ]);

    // return view('accountant.Project-Financial.ProjectStageReport', compact('projectReports'));


    return view('accountant.Project-Financials', compact('projects','projectReports', 'projects1'));
}

// public function incomeByProjectStage()
// {
//     // Get all projects
//     $projects1 = Project::with('incomes')->get();

//     // Transform each project with stage-wise income totals
//     $projectReports = $projects1->map(function ($project) {
//         return [
//             'project_name' => $project->name,
//             'measurement' => $project->incomes->where('project_stage', 'Measurement')->sum('amount'),
//             'design' => $project->incomes->where('project_stage', 'Design')->sum('amount'),
//             'production' => $project->incomes->where('project_stage', 'Production')->sum('amount'),
//             'installation' => $project->incomes->where('project_stage', 'Installation')->sum('amount'),
//         ];
//     });

//     return view('accountant.Project-Financial.ProjectStageReport', compact('projectReports'));


// }


}
