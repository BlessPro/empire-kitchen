<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSummary extends Model
{
  
protected $fillable = [
    'invoice_id',
    'subtotal',
    'vat',
    'total_amount',
];

}
