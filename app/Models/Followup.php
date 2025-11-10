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
        'priority',
        'status',
        'notes',
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
