<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            ['name' => 'Juliana Silva',  'role' => 'Chief Executive Officer (CEO)', 'image' => 'https://picsum.photos/seed/juliana-silva/200/200',  'order' => 1],
            ['name' => 'Aaron Loeb',     'role' => 'Chief Operating Officer (COO)', 'image' => 'https://picsum.photos/seed/aaron-loeb/200/200',     'order' => 2],
            ['name' => 'Olivia Wilson',  'role' => 'Director',                      'image' => 'https://picsum.photos/seed/olivia-wilson/200/200',  'order' => 3],
            ['name' => 'Neil Tran',      'role' => 'Head Manager',                  'image' => 'https://picsum.photos/seed/neil-tran/200/200',      'order' => 4],
        ];

        foreach ($members as $m) {
            \App\Models\TeamMember::updateOrCreate(
                ['name' => $m['name']],
                array_merge($m, ['active' => true])
            );
        }
    }
}
