<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{

    protected $fillable = [
    'project_id',
    'designer_id',
    'images', // ✅ This was missing!
    'notes',  // ✅ If you're saving notes too
    'uploaded_at',
    'design_date',
    'scheduled_date',
];

protected $casts = [
    'images' => 'array',
    'design_date' => 'datetime',
    'scheduled_date' => 'datetime',

];

    protected $dates = [
        'uploaded_at',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }


}
