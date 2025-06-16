<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\InvoiceItem;

class Invoice extends Model
{
    // protected $fillable = [
    //     'item_name', 
    //     'description', 
    //     'quantity', 
    //     'unit_price', 
    //     'tax_rate',
    // ];
        protected $fillable = ['invoice_code', 'due_date', 'client_id', 'project_id', 'send_email'];


    // Accessors (computed properties)
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    public function getVatAttribute()
    {
        return $this->subtotal * ($this->tax_rate / 100);
    }

    public function getTotalPriceAttribute()
    {
        return $this->subtotal + $this->vat;
    }
    // In Invoice.php
public function client() {
    return $this->belongsTo(Client::class);
}
public function items() {
    return $this->hasMany(InvoiceItem::class);
}


public function project() {
    return $this->belongsTo(Project::class);
}



public function summary() {
    return $this->hasOne(InvoiceSummary::class);
}









}
