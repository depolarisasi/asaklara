<?php

namespace Tests\Unit;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    // ---------- Fillable ----------

    public function test_setting_has_correct_fillable_fields(): void
    {
        $setting = new Setting();
        $this->assertContains('key', $setting->getFillable());
        $this->assertContains('value', $setting->getFillable());
        $this->assertContains('group', $setting->getFillable());
    }

    // ---------- set() & get() ----------

    public function test_set_creates_new_setting(): void
    {
        Setting::set('site.name', 'ASAK Agency');

        $this->assertDatabaseHas('settings', [
            'key'   => 'site.name',
            'value' => 'ASAK Agency',
        ]);
    }

    public function test_get_returns_stored_value(): void
    {
        Setting::set('site.tagline', 'The Anti-Chaos Agency');

        $this->assertEquals('The Anti-Chaos Agency', Setting::get('site.tagline'));
    }

    public function test_get_returns_default_when_key_not_found(): void
    {
        $value = Setting::get('nonexistent.key', 'default_value');

        $this->assertEquals('default_value', $value);
    }

    public function test_get_returns_null_default_when_not_specified(): void
    {
        $value = Setting::get('totally.missing.key');

        $this->assertNull($value);
    }

    public function test_set_updates_existing_setting(): void
    {
        Setting::set('hero.headline', 'Headline Lama');
        Setting::set('hero.headline', 'Headline Baru');

        $this->assertEquals('Headline Baru', Setting::get('hero.headline'));
        $this->assertDatabaseCount('settings', 1);
    }

    public function test_set_stores_group_correctly(): void
    {
        Setting::set('hero.badge', 'Badge Text', 'hero');

        $this->assertDatabaseHas('settings', [
            'key'   => 'hero.badge',
            'group' => 'hero',
        ]);
    }

    // ---------- Cache ----------

    public function test_get_caches_result(): void
    {
        Setting::set('cached.key', 'cached_value');

        // Panggil pertama — masuk cache
        Setting::get('cached.key');

        $this->assertTrue(Cache::has('setting.cached.key'));
    }

    public function test_set_clears_cache_for_key(): void
    {
        Setting::set('cache.test', 'old');
        Setting::get('cache.test'); // cache diisi

        Setting::set('cache.test', 'new'); // cache dibersihkan

        $this->assertFalse(Cache::has('setting.cache.test'));
    }

    // ---------- getGroup() ----------

    public function test_get_group_returns_all_keys_in_group(): void
    {
        Setting::set('contact.email', 'hello@asak.id', 'contact');
        Setting::set('contact.phone', '+62812345678', 'contact');
        Setting::set('social.instagram', '@asak.id', 'social');

        $contact = Setting::getGroup('contact');

        $this->assertArrayHasKey('contact.email', $contact);
        $this->assertArrayHasKey('contact.phone', $contact);
        $this->assertArrayNotHasKey('social.instagram', $contact);
        $this->assertEquals('hello@asak.id', $contact['contact.email']);
    }

    public function test_get_group_returns_empty_array_for_unknown_group(): void
    {
        $result = Setting::getGroup('nonexistent_group');

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function test_get_group_caches_result(): void
    {
        Setting::set('stats.projects', '100+', 'stats');

        Setting::getGroup('stats');

        $this->assertTrue(Cache::has('settings.group.stats'));
    }
}
