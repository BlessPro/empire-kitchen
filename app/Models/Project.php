<?php

// namespace App\Models;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Illuminate\Database\Eloquent\Model;
// // create a relationship between projects and clients
// use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// //created on 2025-04-23
// // app/Models/Project.php
// class Project extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'name', 'description', 'client_id', 'status', 'start_date',
//         'measurement_date', 'design_date', 'production_date', 'installation_date',
//         'first_assigned_tech_supervisor', 'second_assigned_tech_supervisor',
//         'first_assigned_designer', 'second_assigned_designer', 'cost'
//     ];
//     protected $casts = [
//         'start_date' => 'datetime',
//         'measurement_date' => 'datetime',
//         'design_date' => 'datetime',
//         'production_date' => 'datetime',
//         'installation_date' => 'datetime',
//     ];

//     protected $dates = ['start_date'];

//     public function client()
//     {
//         return $this->belongsTo(Client::class);
//     }
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Comments;
class Project extends Model
{

    use HasFactory;

    protected $fillable = [
        'name', 'description', 'additional_notes', 'cost', 'start_date','due_date',
        'client_id', 'status'
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'measurement_date' => 'datetime',
        'design_date' => 'datetime',
        'production_date' => 'datetime',
        'installation_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function measurement()
    {
        return $this->hasMany(Measurement::class);
    }

    public function design()
    {
        return $this->hasMany(Design::class);
    }

    public function installation()
    {
        return $this->hasMany(Installation::class);
    }
    public function Comments()
    {
        return $this->hasMany(Comment::class);
    }
}
