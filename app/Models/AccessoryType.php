<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessoryType extends Model
{
    protected $fillable = ['accessory_id','value'];

    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }
}
