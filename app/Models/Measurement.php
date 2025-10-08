<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{


protected $fillable = [
    'project_id',
    'user_id',
    'length',
    'width',
    'location',
    'height',
    'obstacles',
    'images',
    'start_time',
    'end_time',
    'scheduled_date'
];



    protected $casts = [
    'images' => 'array',
    'start_time' => 'datetime',
    'end_time' => 'datetime',
    'scheduled_date' => 'date',

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
