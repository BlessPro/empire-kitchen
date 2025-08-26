<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'client_id','admin_id','tech_supervisor_id','designer_id',
        'production_officer_id','installation_officer_id',
        'name','status','current_stage','booked_status','estimated_budget',
    ];

    protected $casts = [
        'estimated_budget' => 'decimal:2',
        'status'           => 'string',      // COMPLETED | ON_GOING | IN_REVIEW
        'current_stage'    => 'string',      // MEASUREMENT | DESIGN | PRODUCTION | INSTALLATION
        'booked_status'    => 'string',      // UNBOOKED | BOOKED
    ];

    /** Parents */
    public function client()            { return $this->belongsTo(Client::class); }
    public function admin()             { return $this->belongsTo(User::class, 'admin_id'); }
    public function techSupervisor()    { return $this->belongsTo(User::class, 'tech_supervisor_id'); }
    public function designer()          { return $this->belongsTo(User::class, 'designer_id'); }
    public function productionOfficer() { return $this->belongsTo(User::class, 'production_officer_id'); }
    public function installationOfficer(){ return $this->belongsTo(User::class, 'installation_officer_id'); }

    /** Children */
    public function products()          { return $this->hasMany(Product::class); }

    /** Handy scopes */
    public function scopeOngoing($q)    { return $q->where('status','ON_GOING'); }
    public function scopeBooked($q)     { return $q->where('booked_status','BOOKED'); }
}
