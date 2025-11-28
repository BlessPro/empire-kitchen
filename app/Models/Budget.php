<?php

// app/Models/Budget.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'main_amount',
        'currency',
        'effective_date',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date'     => 'date',
        'end_date'       => 'date',
        'effective_date' => 'date',
    ];

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

