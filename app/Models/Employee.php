<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Employee extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'staff_id',
    //     'name','designation','commencement_date','phone','email',
    //     'nationality','dob','hometown','language',
    //     'address','gps',
    //     'next_of_kin','relation','nok_phone',
    //     'bank','branch','account_number',
    //     'avatar_path',
    // ];

    // protected $casts = [
    //     'commencement_date' => 'date',
    //     'dob' => 'date',
    // ];


    protected $fillable = [
    'staff_id',
    'name',
    'designation',
    'commencement_date',
    'phone',
    'email',
    'nationality',
    'dob',
    'hometown',
    'language',
    'address',
    'gps',   // ✅ string
    'next_of_kin',
    'relation',
    'nok_phone',
    'bank',
    'branch',
    'account_number',
    'avatar_path',   // ✅ added
];

protected $casts = [
    'commencement_date' => 'date',
    'dob'               => 'date',
    'created_at'        => 'datetime',
    'updated_at'        => 'datetime',
];

public function getAvatarUrlAttribute()
{
    return $this->avatar_path
        ? asset('storage/'.$this->avatar_path)
        : asset('images/default-avatar.png');
}


    // App\Models\User.php
public function employee()
{
    return $this->belongsTo(Employee::class);
}

    public function user() { return $this->hasOne(User::class); }
    // public function isAdmin(): bool { return $this->user && $this->user->role === 'administrator'; }
}

