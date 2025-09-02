<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'name','designation','commencement_date','phone','email',
        'nationality','dob','hometown','language',
        'address','gps',
        'next_of_kin','relation','nok_phone',
        'bank','branch','account_number',
        'avatar_path',
    ];

    protected $casts = [
        'commencement_date' => 'date',
        'dob' => 'date',
    ];
}
