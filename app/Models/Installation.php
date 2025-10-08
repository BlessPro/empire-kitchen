<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{


protected $fillable = [
  'client_id','project_id','user_id',
  'install_date','install_time','start_time',
  'notes','is_done','done_at',
];
protected $casts = [
  'install_date' => 'date',
  'start_time'   => 'datetime',
  'is_done'      => 'boolean',
  'done_at'      => 'datetime',
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

public function user(){ return $this->belongsTo(\App\Models\User::class); }




}
