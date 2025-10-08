<?php
// database/seeders/BudgetExampleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\Budget;
use App\Models\BudgetCategory;
use App\Models\BudgetAllocation;

class BudgetExampleSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure categories exist
        $this->call(BudgetCategorySeeder::class);

        // Find the project (adjust if you prefer by id)
        $project = Project::where('name', 'Kasoa Kitchen')->first();

        if (!$project) {
            $this->command->warn('Project "Kasoa Kitchen" not found. Create it first.');
            return;
        }

        // Create/Update the budget (main = 2000 GHS)
        $budget = Budget::updateOrCreate(
            ['project_id' => $project->id],
            ['main_amount' => 2000, 'currency' => 'GHS', 'effective_date' => Carbon::now()->toDateString()]
        );

        // Helper to upsert a category allocation
        $alloc = function (string $catName, float $amount) use ($budget) {
            $cat = BudgetCategory::firstOrCreate(['name' => $catName], [
                'description' => null,
                'is_default'  => false, // user-added
            ]);
            BudgetAllocation::updateOrCreate(
                ['budget_id' => $budget->id, 'budget_category_id' => $cat->id],
                ['amount' => $amount]
            );
        };

        // Your example allocations
        $alloc('Measurement',   500);
        $alloc('Design',        500);
        $alloc('Installation',  300);
        $alloc('Production',    700); // user-added new category

        $total = $budget->allocations()->sum('amount');
        if ($total > $budget->main_amount) {
            $this->command->warn("Warning: Allocations (GHS {$total}) exceed main budget (GHS {$budget->main_amount}).");
        } else {
            $this->command->info("Kasoa Kitchen budget seeded. Allocated GHS {$total} / GHS {$budget->main_amount}");
        }
    }
}

