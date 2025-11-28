<?php

// app/Models/BudgetAllocation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetAllocation extends Model
{
    protected $fillable = ['budget_id','budget_category_id','amount','note'];

    public function budget() {
        return $this->belongsTo(Budget::class);
    }

    public function category() {
        return $this->belongsTo(BudgetCategory::class, 'budget_category_id');
    }
// app/Models/BudgetAllocation.php
public function costEntries() {
    return $this->hasMany(CostEntry::class);
}

public function spentTotal(): float {
    // sum on loaded relation if present, else query
    if ($this->relationLoaded('costEntries')) {
        return (float) $this->costEntries->sum('amount');
    }
    return (float) $this->costEntries()->sum('amount');
}

public function remaining(): float {
    return (float) $this->amount - $this->spentTotal();
}




}
