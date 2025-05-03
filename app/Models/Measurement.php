<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Measurement extends Model
// {
//     //
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $fillable = [
        'project_id', 'user_id', 'length', 'width', 'height', 'measured_at'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function techSupervisor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
