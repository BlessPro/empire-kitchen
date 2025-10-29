<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Design extends Model
{
    protected $fillable = [
        'project_id',
        'designer_id',
        'images',
        'notes',
        'design_date',
        'schedule_date',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'images'        => 'array',
        'design_date'   => 'datetime',
        'schedule_date' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }
}
