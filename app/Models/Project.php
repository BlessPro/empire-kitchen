<?php

// namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Comments;
class Project extends Model
{

    use HasFactory;
protected $fillable = [
    'name', 'description', 'additional_notes', 'cost', 'start_date', 'due_date',
    'client_id', 'status', 'current_stage','location', 'admin_id', 'designer_id',
    'tech_supervisor_id', 'sales_accountant_id', 'accountant_id'
];

    // protected $fillable = [
    //     'name', 'description', 'additional_notes', 'cost', 'start_date', 'due_date',
    //     'client_id', 'status', 'current_stage' // ✅ added this
    // ];

    protected $casts = [
        'start_date' => 'datetime',
        // 'measurement_date' => 'datetime',
        // 'design_date' => 'datetime',
        // 'production_date' => 'datetime',
        // 'installation_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

public function measurements()
{
    return $this->hasMany(Measurement::class);
}
public function measurement()
{
    return $this->hasMany(Measurement::class);
}
public function design()
{
    return $this->hasMany(Design::class);
}
 public function designs()
{
    return $this->hasMany(Design::class);
}
 public function installation()
{
    return $this->hasMany(Installation::class);
}
public function Comments()
{
return $this->hasMany(Comment::class);
}
public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}

public function designer()
{
    return $this->belongsTo(User::class, 'designer_id');
}

public function techSupervisor()
{
    return $this->belongsTo(User::class, 'tech_supervisor_id');
}

public function salesAccountant()
{
    return $this->belongsTo(User::class, 'sales_accountant_id');
}

public function accountant()
{
    return $this->belongsTo(User::class, 'accountant_id');
}


// 3. Project model - Add latestDesign relationship

// In App\Models\Project.php
public function latestDesign()
{
    return $this->hasOne(Design::class)->latestOfMany();
}

// 4. Comment model - Add viewers relationship

// In App\Models\Comment.php
public function viewers()
{
    return $this->belongsToMany(User::class, 'comment_views')->withTimestamps();
}

// 5. User model - Add viewedComments relationship

// In App\Models\User.php
public function viewedComments()
{
    return $this->belongsToMany(Comment::class, 'comment_views')->withTimestamps();
}

public function incomes()
{
    return $this->hasMany(Income::class);
}

public function expenses()
{
    return $this->hasMany(Expense::class);
}

public function measurementSchedules()
{
    return $this->hasMany(MeasurementSchedule::class);
}


public function unreadCommentsFor($adminId)
{
    return $this->comments()->whereDoesntHave('views', function ($query) use ($adminId) {
        $query->where('user_id', $adminId);
    });
}


}
