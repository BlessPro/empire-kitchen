<?php

// app/Models/CostEntry.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostEntry extends Model
{
    protected $fillable = ['budget_allocation_id','amount','spent_at','description','created_by'];

    public function allocation() {
        return $this->belongsTo(BudgetAllocation::class, 'budget_allocation_id');
    }
}
