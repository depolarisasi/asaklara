<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            ['name' => 'TechCorp'],
            ['name' => 'InnovateInc'],
            ['name' => 'GlobalBuild'],
            ['name' => 'FinServe'],
            ['name' => 'DataStream'],
            ['name' => 'NextGen'],
            ['name' => 'Quantum'],
            ['name' => 'Nebula'],
        ];

        foreach ($clients as $index => $client) {
            \App\Models\Client::create([
                'name' => $client['name'],
                'image_url' => 'https://picsum.photos/seed/' . $client['name'] . '/200/100',
                'is_active' => true,
                'sort_order' => $index,
            ]);
        }
    }
}
