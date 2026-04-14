<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolios = [
            [
                'title'       => 'TechFlow Rebrand',
                'slug'        => 'techflow-rebrand',
                'category'    => 'Graphic Design',
                'description' => 'Complete visual identity redesign for a leading tech startup, including logo, brand guidelines, and marketing collateral.',
                'client'      => 'TechFlow Inc.',
                'year'        => '2024',
                'image'       => 'https://picsum.photos/seed/techflow-brand/1200/600',
                'featured'    => true,
                'order'       => 1,
            ],
            [
                'title'       => 'Urban Eats Platform',
                'slug'        => 'urban-eats-platform',
                'category'    => 'Web Design',
                'description' => 'Modern e-commerce platform for a food delivery service with seamless ordering experience.',
                'client'      => 'Urban Eats',
                'year'        => '2024',
                'image'       => 'https://picsum.photos/seed/urban-eats/800/600',
                'featured'    => true,
                'order'       => 2,
            ],
            [
                'title'       => 'Horizon Corporate Film',
                'slug'        => 'horizon-corporate-film',
                'category'    => 'Photo & Video',
                'description' => 'Cinematic brand story video showcasing company culture and values for investor relations.',
                'client'      => 'Horizon Group',
                'year'        => '2024',
                'image'       => 'https://picsum.photos/seed/horizon-film/800/600',
                'featured'    => true,
                'order'       => 3,
            ],
            [
                'title'       => 'GreenLife Campaign',
                'slug'        => 'greenlife-campaign',
                'category'    => 'Digital Marketing',
                'description' => 'Integrated digital marketing campaign driving 300% increase in engagement for sustainable living brand.',
                'client'      => 'GreenLife Co.',
                'year'        => '2023',
                'image'       => 'https://picsum.photos/seed/greenlife-campaign/800/600',
                'featured'    => false,
                'order'       => 4,
            ],
            [
                'title'       => 'Artisan Coffee Website',
                'slug'        => 'artisan-coffee-website',
                'category'    => 'Web Design',
                'description' => 'Elegant website design with online ordering system for premium coffee roaster.',
                'client'      => 'Artisan Coffee',
                'year'        => '2023',
                'image'       => 'https://picsum.photos/seed/artisan-coffee/800/600',
                'featured'    => false,
                'order'       => 5,
            ],
            [
                'title'       => 'Fashion Forward Lookbook',
                'slug'        => 'fashion-forward-lookbook',
                'category'    => 'Photo & Video',
                'description' => 'High-fashion photography and video campaign for seasonal collection launch.',
                'client'      => 'Fashion Forward',
                'year'        => '2023',
                'image'       => 'https://picsum.photos/seed/fashion-lookbook/800/600',
                'featured'    => false,
                'order'       => 6,
            ],
            [
                'title'       => 'FinTech App Identity',
                'slug'        => 'fintech-app-identity',
                'category'    => 'Graphic Design',
                'description' => 'Modern brand identity for innovative financial technology application targeting millennials.',
                'client'      => 'PaySmart',
                'year'        => '2023',
                'image'       => 'https://picsum.photos/seed/fintech-app/800/600',
                'featured'    => false,
                'order'       => 7,
            ],
            [
                'title'       => 'Travel Social Strategy',
                'slug'        => 'travel-social-strategy',
                'category'    => 'Digital Marketing',
                'description' => 'Social media strategy and content creation for luxury travel agency reaching global audience.',
                'client'      => 'Wanderlust Travel',
                'year'        => '2023',
                'image'       => 'https://picsum.photos/seed/travel-social/800/600',
                'featured'    => false,
                'order'       => 8,
            ],
        ];

        foreach ($portfolios as $p) {
            \App\Models\Portfolio::updateOrCreate(['slug' => $p['slug']], array_merge($p, ['active' => true]));
        }
    }
}
