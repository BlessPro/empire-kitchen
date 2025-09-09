<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductAccessory extends Pivot
{
    protected $table = 'product_accessory';

    protected $fillable = [
        'product_id',
        'accessory_id',
        'quantity',
        'notes',
        'size',
        'type',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Example convenience accessor for UI
    public function getLabelAttribute(): string
    {
        $parts = [];
        if (!empty($this->type)) $parts[] = $this->type;
        if (!empty($this->size)) $parts[] = $this->size;
        return implode(' • ', $parts);
    }
}
