<?php
// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
 // App/Models/Project.php
protected $fillable = [
    'client_id',
    'name',
    'location',
    'admin_id',
    'tech_supervisor_id',
    'designer_id',
    'production_officer_id',
    'installation_officer_id',
    'status',
    'current_stage',
    'booked_status',
    'estimated_budget',
    'due_date',          // <-- remove leading space
];

protected $casts = [
    'estimated_budget' => 'decimal:2',
    'status'           => 'string',
    'current_stage'    => 'string',
    'booked_status'    => 'string',
    'due_date'         => 'date',
];

// app/Models/Project.php
public function commentViews() {
    return $this->hasMany(\App\Models\ProjectCommentView::class);
}

    /** Parents */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function techSupervisor()
    {
        return $this->belongsTo(User::class, 'tech_supervisor_id');
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }
    public function productionOfficer()
    {
        return $this->belongsTo(User::class, 'production_officer_id');
    }
    public function installationOfficer()
    {
        return $this->belongsTo(User::class, 'installation_officer_id');
    }

    /** Children */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // 🔧 Add these:
    public function measurement()
    {
        return $this->hasOne(Measurement::class);
    }
    // in App\Models\Project.php
public function measurements()
{
    return $this->hasMany(Measurement::class, 'project_id');
}
// public function production()
// {
//     return $this->hasOne(Production::class);
// }

public function production()
{
    return $this->hasmany(Production::class);
}
    public function installation()
    {
        return $this->hasOne(Installation::class);
    }

    public function design()
    {
        return $this->hasOne(Design::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
     public function activities()
    {
        return $this->hasMany(Activity::class);
    }




// If a project can have many installation rows, use the latest by install_date:
public function latestInstallation()
{
    return $this->hasOne(Installation::class)->latestOfMany('install_date');
}
// If it's strictly one installation per project, name it installation() and use hasOne(Installation::class).



 public function incomes() {
        return $this->hasMany(Income::class); // FK: incomes.project_id
    }
    public function expenses() {
        return $this->hasMany(Expense::class); // if you also need it
    }

    // App/Models/Project.php

    // assumes projects table has: id, name, tech_supervisor_id, client_id, ...



    // Stage tables (each owns many rows per project)

    public function designs()
    {
        return $this->hasMany(Design::class); // <-- your Design table/model
    }

    public function productions()
    {
        return $this->hasMany(Production::class); // <-- your Production table/model
    }

    public function installations()
    {
        return $this->hasMany(Installation::class); // <-- your Installation table/model
    }

// Project model
public function budget() { return $this->hasOne(Budget::class); }
public function projectPhases()
{
    return $this->hasMany(\App\Models\ProjectPhase::class);
}

public function phaseTemplates()
{
    return $this->belongsToMany(
        \App\Models\PhaseTemplate::class,
        'project_phases',
        'project_id',
        'phase_template_id'
    )->withPivot(['is_checked','checked_by','checked_at','note','sort_order'])
     ->withTimestamps();
}







}
