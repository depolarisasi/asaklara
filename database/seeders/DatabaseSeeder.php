<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@asak.agency'],
            [
                'name'     => 'ASAK Admin',
                'email'    => 'admin@asak.agency',
                'password' => bcrypt('asak2024!'),
            ]
        );

        $this->call([
            SettingSeeder::class,
            TeamSeeder::class,
            ServiceSeeder::class,
            ProcessStepSeeder::class,
            PortfolioSeeder::class,
        ]);
    }
}
