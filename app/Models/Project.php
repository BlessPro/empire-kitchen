<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
// create a relationship between projects and clients
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
//created on 2025-04-23
// app/Models/Project.php
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'client_id', 'status', 'start_date',
        'measurement_date', 'design_date', 'production_date', 'installation_date',
        'first_assigned_tech_supervisor', 'second_assigned_tech_supervisor',
        'first_assigned_designer', 'second_assigned_designer', 'cost'
    ];

    protected $dates = ['start_date'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

