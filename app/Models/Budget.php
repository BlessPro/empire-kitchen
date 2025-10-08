<?php

// app/Models/Budget.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = ['project_id','main_amount','currency','effective_date'];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function allocations() {
        return $this->hasMany(BudgetAllocation::class);
    }

    // Helpers
    public function totalAllocated(): float {
        return (float) $this->allocations()->sum('amount');
    }

    public function remaining(): float {
        return (float) $this->main_amount - $this->totalAllocated();
    }
}

