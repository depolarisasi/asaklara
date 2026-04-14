<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = [
            ['step_number' => '01', 'title' => 'Discovery',  'description' => 'We learn about your business, goals, and target audience to understand your unique needs.', 'order' => 1],
            ['step_number' => '02', 'title' => 'Strategy',   'description' => 'We develop a comprehensive strategy tailored to achieve your objectives effectively.', 'order' => 2],
            ['step_number' => '03', 'title' => 'Creation',   'description' => 'Our creative team brings the strategy to life with exceptional design and development.', 'order' => 3],
            ['step_number' => '04', 'title' => 'Launch',     'description' => 'We deliver the final product and provide support for a successful launch.', 'order' => 4],
        ];

        foreach ($steps as $s) {
            \App\Models\ProcessStep::updateOrCreate(
                ['step_number' => $s['step_number']],
                $s
            );
        }
    }
}
