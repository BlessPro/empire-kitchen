<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $fillable = [
        'name','category','length_mm','width_mm','height_mm',
        'diameter_mm','size','notes',
    ];

    /** Reverse many-to-many */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_accessory')
                    ->withPivot(['quantity','notes'])
                    ->withTimestamps();
    }
}
