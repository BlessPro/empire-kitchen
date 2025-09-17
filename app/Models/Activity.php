<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// App/Models/Activity.php
class Activity extends Model
{
    // example columns: id, project_id, user_id, type, message, created_at
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

