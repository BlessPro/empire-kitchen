<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhaseTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            'Work Order',
            'Setting Up (First)',
            'Setting up (Final)',
            'Cutting List',
            'Corner Post and Finishes',
            'Briefing',
            'Cutting',
            'Shelf Pin Holes',
            'Waybill / Crosscheck',
            'Lipping and Cleaning',
            'Drawers',
            'Delivery',
            'Profile Cutting',
            'Doors',
            'Installation',
            'Assembly',
            'Hinges Holes',
            'Feedback from site',
        ];

        $now = now();
        $data = [];
        foreach ($rows as $i => $name) {
            $data[] = [
                'name' => $name,
                'default_sort_order' => $i + 1,
                'product_type' => 'Kitchen', // or null if you don’t want to scope
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Upsert avoids duplicates if you run seeder multiple times
        DB::table('phase_templates')->upsert(
            $data,
            uniqueBy: ['name','product_type'],
            update: ['default_sort_order','is_active','updated_at']
        );
    }
}
