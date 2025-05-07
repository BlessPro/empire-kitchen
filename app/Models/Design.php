<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Design extends Model
// {
//     //
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
        'project_id', 'designer_id', 'design_image_path', 'uploaded_at'
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
