<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSummary extends Model
{
    //
    // app/Models/InvoiceSummary.php

protected $fillable = [
    'invoice_id',
    'subtotal',
    'vat',
    'total_amount',
];

}
