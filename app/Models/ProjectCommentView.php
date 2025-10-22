<?php
// app/Models/ProjectCommentView.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCommentView extends Model
{
    protected $fillable = ['project_id','user_id','last_seen_at'];
}
