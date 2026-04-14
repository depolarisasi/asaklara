<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Settings/Index', [
            'hero'    => Setting::getGroup('hero'),
            'about'   => Setting::getGroup('about'),
            'stats'   => Setting::getGroup('stats'),
            'contact' => Setting::getGroup('contact'),
            'social'  => Setting::getGroup('social'),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero.badge_text'       => 'nullable|string|max:100',
            'hero.headline'         => 'nullable|string|max:255',
            'hero.headline_accent'  => 'nullable|string|max:255',
            'hero.subheadline'      => 'nullable|string|max:500',
            'hero.cta_primary'      => 'nullable|string|max:100',
            'hero.cta_secondary'    => 'nullable|string|max:100',

            'about.hero_title'      => 'nullable|string|max:255',
            'about.hero_subtitle'   => 'nullable|string',
            'about.philosophy'      => 'nullable|string|max:255',
            'about.story_text_1'    => 'nullable|string',
            'about.story_text_2'    => 'nullable|string',
            'about.story_text_3'    => 'nullable|string',

            'stats.projects'        => 'nullable|string|max:20',
            'stats.clients'         => 'nullable|string|max:20',
            'stats.experience'      => 'nullable|string|max:20',
            'stats.awards'          => 'nullable|string|max:20',

            'contact.email'         => 'nullable|email|max:255',
            'contact.website'       => 'nullable|string|max:255',
            'contact.address'       => 'nullable|string|max:255',
            'contact.response_time' => 'nullable|string|max:100',

            'social.instagram'      => 'nullable|string|max:255',
            'social.twitter'        => 'nullable|string|max:255',
            'social.linkedin'       => 'nullable|string|max:255',
        ]);

        foreach ($validated as $group => $settings) {
            foreach ($settings as $key => $value) {
                Setting::set("{$group}.{$key}", $value, $group);
            }
            // Clear per-group cache setelah semua key di grup tersimpan
            Cache::forget("settings.group.{$group}");
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
