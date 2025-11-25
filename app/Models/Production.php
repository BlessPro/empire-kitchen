<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


// app/Models/Production.php
class Production extends Model
{
    // Use default Laravel pluralization: 'productions' table
    // protected $table = 'productions';
    // public function project() { return $this->belongsTo(Project::class); }



    protected $fillable = [
        'project_id',
        'production_officer_id',
        'status',
        'start_date',
        'end_date',
        'notes',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
