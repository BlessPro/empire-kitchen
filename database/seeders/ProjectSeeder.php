<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Client;


class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */ public function run(): void
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            Project::factory()->count(3)->create([
                'client_id' => $client->id,
            ]);
        }
    }
}

