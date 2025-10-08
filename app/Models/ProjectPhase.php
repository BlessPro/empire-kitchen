<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPhase extends Model
{
    protected $table = 'project_phases';

    protected $fillable = [
        'project_id',
        'phase_template_id',
        'name',       // keep legacy columns for display/backfill
        'sort_order',
        'is_checked',
        'checked_by',
        'checked_at',
        'note',
    ];

    protected $casts = [
        'is_checked' => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function template()
    {
        return $this->belongsTo(PhaseTemplate::class, 'phase_template_id');
    }
}
