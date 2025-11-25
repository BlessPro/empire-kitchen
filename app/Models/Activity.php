<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Throwable;

// App/Models/Activity.php
class Activity extends Model
{
    protected $fillable = [
        'project_id','user_id','type','message','meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function log(array $attrs): self
    {
        // Soft-guard: avoid crashing if migration hasn't run yet
        try {
            if (!Schema::hasTable('activities')) {
                return new static($attrs);
            }
            $attrs['user_id'] = $attrs['user_id'] ?? optional(auth()->user())->id;
            return static::create($attrs);
        } catch (Throwable $e) {
            // Swallow logging errors to never block main flow
            return new static($attrs);
        }
    }
}

