<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    //
    protected $fillable = [
    'client_id',
    'project_id',
    'category_id',
    'amount',
    'date',
    'project_stage',
    'payment_method',
     'notes',
     'status'

];
    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2', // Assuming you want to store amounts with two decimal places
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
