<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectPhase;

class PhaseTemplate extends Model
{
    protected $table = 'phase_templates';

    protected $fillable = [
        'name', 'default_sort_order', 'product_type', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function projectPhases()
    {
        return $this->hasMany(ProjectPhase::class, 'phase_template_id');
    }

    public function scopeActive($q) { return $q->where('is_active', 1); }
}
