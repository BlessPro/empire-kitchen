<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Client;
use App\Models\Project;
class FollowUp extends Model
{
    protected $fillable = [
        'client_id',
        'client_name',
        'project_id',
        'follow_up_date',
        'follow_up_time',
        'reminder_at',
        'reminder_status',
        'priority',
        'status',
        'notes',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
        'follow_up_time' => 'string',
        'reminder_at'   => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
