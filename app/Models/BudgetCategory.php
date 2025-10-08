<?php
// app/Models/BudgetCategory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetCategory extends Model
{
    protected $fillable = ['name','description','is_default'];

    public function allocations() {
        return $this->hasMany(BudgetAllocation::class);
    }
}
