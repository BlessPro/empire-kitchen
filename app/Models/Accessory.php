<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $fillable = [
        'name',
        'category',
        'length_mm',
        'width_mm',
        'height_mm',
        'diameter_mm',
        'size',      // keep as “default/typical” – not enforced
        'notes',
        'is_active', // add if you created this column
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_accessory')
            ->using(ProductAccessory::class)
            ->withPivot(['quantity','notes','size','type'])
            ->withTimestamps();
    }

    /** Per-accessory dynamic type options (if you created accessory_types) */
    public function types()
    {
        return $this->hasMany(AccessoryType::class);
    }

    /** Flat array of allowed type values */
    public function typeValues(): array
    {
        // Ensure relation loaded; call ->loadMissing('types') if you need
        return $this->relationLoaded('types') ? $this->types->pluck('value')->all() : [];
    }

    /** True if $type is allowed for this accessory (or no rules defined => allow any) */
    public function isTypeAllowed(?string $type): bool
    {
        $allowed = $this->typeValues();
        if (empty($allowed)) {
            // No specific rules defined → allow any/null
            return true;
        }
        return $type !== null && in_array($type, $allowed, true);
    }
}
