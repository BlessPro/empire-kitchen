<?php
// database/seeders/AccessorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accessory;

class AccessorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Bosch Oven', 'category' => 'Appliance', 'notes' => 'Electric oven'],
            ['name' => 'Samsung Microwave', 'category' => 'Appliance', 'notes' => '800W microwave'],
            ['name' => 'Dishwasher', 'category' => 'Appliance', 'notes' => 'Full size'],
            ['name' => 'Cooker Hood', 'category' => 'Appliance', 'notes' => 'Stainless steel'],
            ['name' => 'Fridge Freezer', 'category' => 'Appliance', 'notes' => 'Double door'],
        ];

        foreach ($items as $item) {
            Accessory::create($item);
        }
    }
}
