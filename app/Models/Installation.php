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
    'created_at',
    'start_time',
    'end_time',
    'notes',

];
protected $casts = [
    'created_at' => 'datetime',
    'start_time' => 'datetime',
    'end_time' => 'datetime',
];



    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function techSupervisor()
    {
        return $this->belongsTo(User::class, 'tech_supervisor_id');
    }

    public function client()
{
    return $this->belongsTo(Client::class);
}



}
