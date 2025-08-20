<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Project;

class Client extends Model
{
    //creating a relationship between projects and clients
    // app/Models/Client.php

    use HasFactory;

protected $fillable = [
    'title',
    'firstname',
    'lastname',
    'othernames',
    'phone_number',
    'email',
    'other_phone',
    'contact_person',
    'contact_phone',
    'location',
    'address',
    'profile_pic',
    'email',
];

    public function projects()
    {
        return $this->hasMany(Project::class);

    }
    public function incomes() {
        return $this->hasMany(Income::class);
    }

public function invoices() {
    return $this->hasMany(Invoice::class);

}


public function followUps()
{
    return $this->hasMany(FollowUp::class);
}

}
