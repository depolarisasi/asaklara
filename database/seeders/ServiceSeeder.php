<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title'       => 'Brand Engineering',
                'slug'        => 'brand-engineering',
                'description' => 'Identity, UI/UX, Visual System, Graphic & Video. We don\'t just create brands—we engineer them for scalability and market dominance. Every pixel, every line, tracked and transparent.',
                'image'       => 'https://picsum.photos/seed/brand-engineering/600/600',
                'order'       => 1,
                'features'    => ['Brand identity systems', 'UI/UX design', 'Visual system development', 'Logo & brand guidelines', 'Marketing collateral', 'Motion graphics'],
            ],
            [
                'title'       => 'Tech Development',
                'slug'        => 'tech-development',
                'description' => 'Web, Apps, & Custom Software. We build scalable digital solutions that perform flawlessly. Military precision, zero delays, and systems that grow with your business.',
                'image'       => 'https://picsum.photos/seed/tech-development/600/600',
                'order'       => 2,
                'features'    => ['Custom web applications', 'Mobile app development', 'E-commerce platforms', 'API development', 'System integration', 'Performance optimization'],
            ],
            [
                'title'       => 'Growth Hacking',
                'slug'        => 'growth-hacking',
                'description' => 'Data-Driven Marketing & SEO. Strategic campaigns with full transparency on every metric. We hit milestones and respect your timeline as much as your budget.',
                'image'       => 'https://picsum.photos/seed/growth-hacking/600/600',
                'order'       => 3,
                'features'    => ['SEO optimization', 'Paid advertising (PPC)', 'Social media marketing', 'Content strategy', 'Analytics & reporting', 'Conversion optimization'],
            ],
            [
                'title'       => 'Photo & Videography',
                'slug'        => 'photo-videography',
                'description' => 'Professional visual content with global standards. From product shots to corporate videos, we deliver mature content—fully edited, fully optimized, ready for impact.',
                'image'       => 'https://picsum.photos/seed/photo-videography/600/600',
                'order'       => 4,
                'features'    => ['Product photography', 'Corporate videos', 'Event coverage', 'Brand storytelling', 'Social media content', 'Drone videography'],
            ],
        ];

        foreach ($services as $s) {
            $features = $s['features'];
            unset($s['features']);

            $service = \App\Models\Service::updateOrCreate(['slug' => $s['slug']], array_merge($s, ['active' => true]));

            // Only seed features if none exist yet
            if ($service->features()->count() === 0) {
                foreach ($features as $i => $feature) {
                    $service->features()->create(['feature' => $feature, 'order' => $i + 1]);
                }
            }
        }
    }
}
