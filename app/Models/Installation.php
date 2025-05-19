<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// class Installation extends Model
// {
//     //
// }
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    // protected $fillable = [
    //     'project_id', 'user_id', 'installation_image_path', 'installed_at'
    // ];

    protected $fillable = [
    'client_id',
    'project_id',
    'user_id',
    'installation_image_path',
    'installed_at',
    'start_time',
    'end_time',
    'notes',
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
