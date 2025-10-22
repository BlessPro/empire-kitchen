<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommentView;

class Comment extends Model
{
    protected $fillable = [
        'project_id', 'user_id', 'comment', 'comment_date'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


public function viewers()
{
    return $this->belongsToMany(User::class, 'comment_views')
                ->withTimestamps();
}

public function views()
{
    return $this->hasMany(CommentView::class, 'comment_id');
}




}
