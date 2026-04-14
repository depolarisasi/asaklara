<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Hero
            ['key' => 'hero.badge_text',      'value' => 'The Anti-Chaos Agency',           'group' => 'hero'],
            ['key' => 'hero.headline',         'value' => 'Done Right.',                     'group' => 'hero'],
            ['key' => 'hero.headline_accent',  'value' => 'Done On Time.',                   'group' => 'hero'],
            ['key' => 'hero.subheadline',      'value' => 'We are the anti-chaos agency. We bridge the gap between creative disruption and operational excellence. We don\'t just "make things"—we build systems that scale.', 'group' => 'hero'],
            ['key' => 'hero.cta_primary',      'value' => 'Start a Project',                 'group' => 'hero'],
            ['key' => 'hero.cta_secondary',    'value' => 'View Our Work',                   'group' => 'hero'],

            // Stats
            ['key' => 'stats.projects',    'value' => '150+', 'group' => 'stats'],
            ['key' => 'stats.clients',     'value' => '50+',  'group' => 'stats'],
            ['key' => 'stats.experience',  'value' => '5+',   'group' => 'stats'],
            ['key' => 'stats.awards',      'value' => '15+',  'group' => 'stats'],

            // About
            ['key' => 'about.hero_title',    'value' => 'The Anti-Chaos Agency', 'group' => 'about'],
            ['key' => 'about.hero_subtitle', 'value' => 'Born from the high-volume demands of the global gig economy and refined for corporate scalability, we bridge the gap between creative disruption and operational excellence. We don\'t just "make things"—we build systems that scale.', 'group' => 'about'],
            ['key' => 'about.philosophy',    'value' => '"Asak" Means Mature. Ready.', 'group' => 'about'],
            ['key' => 'about.story_text_1',  'value' => 'It represents the final state of perfection after a rigorous process. In the digital world, "Asak" is our Definition of Done.', 'group' => 'about'],
            ['key' => 'about.story_text_2',  'value' => 'We believe that great ideas are worthless if they remain "raw" or poorly executed. At asak digital, we bridge the gap between abstract concepts and concrete reality.', 'group' => 'about'],
            ['key' => 'about.story_text_3',  'value' => 'We don\'t just deliver projects; we deliver maturity—fully tested, fully optimized, and ready for market impact.', 'group' => 'about'],

            // Contact
            ['key' => 'contact.email',         'value' => 'hello@asak.agency',                    'group' => 'contact'],
            ['key' => 'contact.website',        'value' => 'www.asak.agency',                      'group' => 'contact'],
            ['key' => 'contact.address',        'value' => 'Jakarta, Indonesia — International Projects Worldwide', 'group' => 'contact'],
            ['key' => 'contact.response_time',  'value' => 'Zero-Delay Protocol Active',           'group' => 'contact'],

            // Social
            ['key' => 'social.instagram', 'value' => '#', 'group' => 'social'],
            ['key' => 'social.twitter',   'value' => '#', 'group' => 'social'],
            ['key' => 'social.linkedin',  'value' => '#', 'group' => 'social'],
        ];

        foreach ($settings as $s) {
            \App\Models\Setting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
