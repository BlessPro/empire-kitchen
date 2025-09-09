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
    public function installation()
    {
        return $this->hasOne(Installation::class);
    }

    // If you have tables/models for these, add them; otherwise remove their eager-loads in your query.
    public function design()
    {
        return $this->hasOne(Design::class);
    } // create Design model if needed
    // public function production()    { return $this->hasOne(Production::class); }     // create Production model if needed

    // If you're using comments on projects:
    // Adjust to morphMany if your Comment is polymorphic.
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
