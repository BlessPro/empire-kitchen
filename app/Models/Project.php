<?php
// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['client_id', 'name', 'location', 'admin_id', 'tech_supervisor_id', 'designer_id', 'production_officer_id', 'installation_officer_id', 'name', 'status', 'current_stage', 'booked_status', 'estimated_budget', ' due_date'];

    protected $casts = [
        'estimated_budget' => 'decimal:2',
        'status' => 'string', // COMPLETED | ON_GOING | IN_REVIEW
        'current_stage' => 'string', // measurement | design | production | installation
        'booked_status' => 'string', // UNBOOKED | BOOKED
        'due_date' => 'date',
    ];

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



}
