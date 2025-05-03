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
    protected $fillable = [
        'project_id', 'user_id', 'installation_image_path', 'installed_at'
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
