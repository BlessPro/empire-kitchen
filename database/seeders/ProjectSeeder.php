<?php
// database/seeders/ProjectSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Product;
use App\Models\Accessory;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $project = Project::create([
            'client_id' => 1,
            'name' => 'Demo Kitchen Project',
            'status' => 'ON_GOING',
            'booked_status' => 'BOOKED',
        ]);

        Product::create([
            'project_id' => $project->id,
            'name' => 'Island Cabinet',
            'product_type' => 'Kitchen',
            'type_of_finish' => 'Gloss',
            'finish_color_hex' => '#FF5733',
            'notes' => 'Demo seeded product',
        ]);

        // Attach random accessories to every product with random qty
    $accessoryIds = Accessory::pluck('id')->all();
    Product::query()->each(function ($product) use ($accessoryIds) {
        if (empty($accessoryIds)) return;

        $pick = collect($accessoryIds)->shuffle()->take(rand(1, 3));
        $attach = $pick->mapWithKeys(fn($id) => [$id => ['quantity' => rand(1, 2), 'notes' => null]])->all();

        $product->accessories()->syncWithoutDetaching($attach);
    });
    }
}

// namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use App\Models\Project;
// use App\Models\Client;


// class ProjectSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */ public function run(): void
//     {
//         $clients = Client::all();

//         foreach ($clients as $client) {
//             Project::factory()->count(3)->create([
//                 'client_id' => $client->id,
//             ]);
//         }
//     }
// }

