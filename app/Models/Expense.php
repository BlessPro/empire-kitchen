<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_name', 'amount', 'date', 'project_id',
        'category_id', 'accountant_id', 'notes', 'accountant_id'
    ];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:4', // Assuming you want to store amounts with two decimal places
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function accountant()
    {
        return $this->belongsTo(User::class, 'accountant_id');
    }
    public function client()
{
    return $this->belongsTo(Client::class);
}


}
