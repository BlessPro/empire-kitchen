<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignerInvoiceAreaController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $invoices = Invoice::with(['project:id,name', 'client:id,firstname,lastname'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('designer.Invoice.Area', compact('invoices'));
    }
}
