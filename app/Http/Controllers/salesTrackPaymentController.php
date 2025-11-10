<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class salesTrackPaymentController extends Controller
{
    //
//     public function index()
// {
//     $incomes = Income::paginate(10);

//     return view('sales.TrackPayment', compact('incomes'));
// }





public function index()
{
    // 1) total cost per client (sum of all invoice_summaries for all client projects)
    $costSub = DB::table('clients')
        ->leftJoin('projects', 'projects.client_id', '=', 'clients.id')
        ->leftJoin('invoices', 'invoices.project_id', '=', 'projects.id')
        ->leftJoin('invoice_summaries', 'invoice_summaries.invoice_id', '=', 'invoices.id')
        ->selectRaw('clients.id as client_id, COALESCE(SUM(invoice_summaries.total_amount), 0) as total_cost')
        ->groupBy('clients.id');

    // 2) total paid per client (sum of all incomes for all client projects)
    $paidSub = DB::table('clients')
        ->leftJoin('projects', 'projects.client_id', '=', 'clients.id')
        ->leftJoin('incomes', 'incomes.project_id', '=', 'projects.id')
        ->selectRaw('clients.id as client_id, COALESCE(SUM(incomes.amount), 0) as total_paid')
        ->groupBy('clients.id');

    // 3) main query: clients + joins to the two rollups above
    $clients = DB::table('clients')
        ->leftJoinSub($costSub, 'costs', function ($join) {
            $join->on('costs.client_id', '=', 'clients.id');
        })
        ->leftJoinSub($paidSub, 'payments', function ($join) {
            $join->on('payments.client_id', '=', 'clients.id');
        })
        ->selectRaw("
            clients.id,
            CONCAT(clients.firstname, ' ', clients.lastname) as client_name,
            clients.location,
            COALESCE(costs.total_cost, 0) as cost,
            COALESCE(payments.total_paid, 0) as paid,
            (COALESCE(costs.total_cost, 0) - COALESCE(payments.total_paid, 0)) as balance,
            CASE
                WHEN COALESCE(payments.total_paid, 0) >= COALESCE(costs.total_cost, 0) AND COALESCE(costs.total_cost, 0) > 0
                    THEN 'Paid'
                WHEN COALESCE(payments.total_paid, 0) > 0
                    THEN 'Partially Paid'
                WHEN COALESCE(costs.total_cost, 0) = 0 AND COALESCE(payments.total_paid, 0) = 0
                    THEN 'No Invoice'
                ELSE 'Pending'
            END as status
        ")
        ->orderBy('client_name')
        ->paginate(10);

    return view('sales.TrackPayment', compact('clients'));
}


}
