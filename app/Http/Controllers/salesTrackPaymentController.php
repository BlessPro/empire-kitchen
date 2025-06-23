<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;


class salesTrackPaymentController extends Controller
{
    //
    public function index()
{
    $incomes = Income::paginate(10);

    return view('sales.TrackPayment', compact('incomes'));
}
}
