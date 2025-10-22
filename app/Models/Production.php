<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


// app/Models/Production.php
class Production extends Model
{
    protected $table = 'production'; // <-- change to your actual table name
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
