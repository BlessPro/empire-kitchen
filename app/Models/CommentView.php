<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentView extends Model
{
    protected $table = 'comment_views'; // explicitly name the table

    protected $fillable = ['user_id', 'comment_id'];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
