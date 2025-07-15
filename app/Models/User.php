<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_pic',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

protected $casts = [
    'last_seen_at' => 'datetime',
];

    public function measurements()
{
    return $this->hasMany(Measurement::class, 'user_id');
}

public function designs()
{
    return $this->hasMany(Design::class, 'user_id');
}

public function installations()
{
    return $this->hasMany(Installation::class, 'user_id');
}

public function Comments()
{
    return $this->hasMany(Comment::class);
}

public function designedProjects() {
    return $this->hasMany(Project::class, 'designer_id');
}
public function techSupervisedProjects() {
    return $this->hasMany(Project::class, 'tech_supervisor_id');

}

public function viewedComments()
{
    return $this->belongsToMany(Comment::class, 'comment_views')
                ->withTimestamps();
}
public function expenses()
{
    return $this->hasMany(Expense::class, 'accountant_id');
}

}

