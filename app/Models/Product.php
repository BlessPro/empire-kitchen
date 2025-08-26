<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'project_id','name','product_type','type_of_finish',
        'finish_color_hex','sample_finish_image_path',
        'glass_door_type',
        'worktop_type','worktop_color_hex','sample_worktop_image_path',
        'sink_top_type','handle','sink_color_hex','sample_sink_image_path',
        'installed_at','notes',
    ];

    protected $casts = [
        'installed_at' => 'datetime',
    ];

    /** Parents */
    public function project()       { return $this->belongsTo(Project::class); }

    /** Accessories via pivot */
    public function accessories()
    {
        return $this->belongsToMany(Accessory::class, 'product_accessory')
                    ->withPivot(['quantity','notes'])
                    ->withTimestamps();
    }
}
