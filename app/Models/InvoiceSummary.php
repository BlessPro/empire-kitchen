<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSummary extends Model
{
  
protected $fillable = [
    'invoice_id',
    'raw_subtotal',
    'discount_percent',
    'discount_amount',
    'subtotal',
    'vat',
    'total_amount',
];

}
