<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

use PHPStan\Rules\PhpDoc\FunctionConditionalReturnTypeRule;

class accountantPaymentController extends Controller
{

public function index()
{
    $invoices = Invoice::with(['client', 'summary'])
        ->latest()
        ->get();

    return view('accountant.Payments', compact('invoices'));
}


}
