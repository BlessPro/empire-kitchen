<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Accessory;
use App\Models\ProductAccessory;

class Product extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'product_type',
        'type_of_finish',
        'finish_color_hex',
        'sample_finish_image_path',
        'glass_door_type',
        'worktop_type',
        'worktop_color_hex',
        'sample_worktop_image_path',
        'sink_top_type',
        'handle',
        'sink_color_hex',
        'sample_sink_image_path',
        'installed_at',
        'notes',
        // ⛔ legacy columns intentionally NOT here:
        // 'accessory_name','accessory_size','accessory_type'
    ];

    protected $casts = [
        'installed_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /** Product ↔ Accessories (catalog) with pivot data size/type/quantity/notes */
    public function accessories(): BelongsToMany
    {
        return $this->belongsToMany(Accessory::class, 'product_accessory')
            ->using(ProductAccessory::class)
            ->withPivot(['quantity','notes','size','type'])
            ->withTimestamps();
    }

    /** -------- Helpers -------- */

    /**
     * Sync accessories from normalized rows:
     *   [
     *     ['id'=>12, 'size'=>'60cm', 'type'=>'Freestanding', 'quantity'=>1, 'notes'=>null],
     *     ...
     *   ]
     */
    public function syncAccessories(array $rows): void
    {
        $attach = [];
        foreach ($rows as $r) {
            if (!isset($r['id'])) continue;
            $attach[(int)$r['id']] = [
                'size'     => $r['size']     ?? null,
                'type'     => $r['type']     ?? null,
                'quantity' => $r['quantity'] ?? 1,
                'notes'    => $r['notes']    ?? null,
            ];
        }
        $this->accessories()->sync($attach);
        $this->load('accessories');
    }

    /** -------- Scopes (handy for filtering) -------- */

    public function scopeWithAccessory($q, string $name)
    {
        return $q->whereHas('accessories', fn($qq) => $qq->where('name', $name));
    }

    public function scopeWithAccessoryType($q, string $name, string $type)
    {
        return $q->whereHas('accessories', function ($qq) use ($name, $type) {
            $qq->where('name', $name)->wherePivot('type', $type);
        });
    }

    public function scopeWithAccessorySize($q, string $name, string $size)
    {
        return $q->whereHas('accessories', function ($qq) use ($name, $size) {
            $qq->where('name', $name)->wherePivot('size', $size);
        });
    }
}
