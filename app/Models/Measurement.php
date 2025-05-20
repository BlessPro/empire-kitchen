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
    'project_id', 'user_id', 'length', 'width', 'height', 'obstacles', 'measured_at', 'images'
    ];
    
    protected $casts = [
        'images' => 'array',
    ];
    

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function techSupervisor()
    {
        return $this->belongsTo(User::class, 'tech_supervisor_id');
    }
}
