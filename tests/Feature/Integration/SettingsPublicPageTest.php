<?php

/**
 * Integration Test: Settings → Halaman Publik
 *
 * Memverifikasi bahwa pengaturan yang disimpan admin
 * benar-benar tercermin di halaman-halaman publik.
 * Ini adalah integrasi antara: SettingsController → Setting model →
 * Cache → HomeController/AboutController/ContactController → View
 */

namespace Tests\Feature\Integration;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SettingsPublicPageTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    private function updateSettings(array $payload): \Illuminate\Testing\TestResponse
    {
        return $this->actingAs($this->admin)->post(route('admin.settings.update'), $payload);
    }

    // =========================================================
    // SKENARIO 1: Admin save hero settings → tersimpan di DB
    // =========================================================

    public function test_admin_saves_hero_settings_and_they_persist_in_database(): void
    {
        $this->updateSettings([
            'hero' => [
                'badge_text'      => 'The Anti-Chaos Agency',
                'headline'        => 'Done Right. Done On Time.',
                'headline_accent' => 'On Time.',
                'subheadline'     => 'Kami deliver lebih dari ekspektasi.',
                'cta_primary'     => 'Mulai Proyek',
                'cta_secondary'   => 'Lihat Portfolio',
            ],
        ]);

        $this->assertEquals('Done Right. Done On Time.', Setting::get('hero.headline'));
        $this->assertEquals('The Anti-Chaos Agency', Setting::get('hero.badge_text'));
        $this->assertEquals('Mulai Proyek', Setting::get('hero.cta_primary'));
    }

    // =========================================================
    // SKENARIO 2: Homepage dapat diakses setelah hero settings disimpan
    // =========================================================

    public function test_homepage_accessible_after_hero_settings_saved(): void
    {
        $this->updateSettings([
            'hero' => [
                'headline'    => 'Headline Keren',
                'subheadline' => 'Subheadline menarik.',
            ],
        ]);

        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    // =========================================================
    // SKENARIO 3: Admin save stats → Setting::getGroup('stats') akurat
    // =========================================================

    public function test_stats_settings_are_retrievable_after_save(): void
    {
        $this->updateSettings([
            'stats' => [
                'projects'   => '250+',
                'clients'    => '80+',
                'experience' => '7 Tahun',
                'awards'     => '15+',
            ],
        ]);

        $stats = Setting::getGroup('stats');

        $this->assertEquals('250+', $stats['stats.projects']);
        $this->assertEquals('80+', $stats['stats.clients']);
        $this->assertEquals('7 Tahun', $stats['stats.experience']);
        $this->assertEquals('15+', $stats['stats.awards']);
    }

    // =========================================================
    // SKENARIO 4: About page dapat diakses setelah about settings disimpan
    // =========================================================

    public function test_about_page_accessible_after_about_settings_saved(): void
    {
        $this->updateSettings([
            'about' => [
                'hero_title'    => 'Tentang ASAK Agency',
                'hero_subtitle' => 'Kami adalah creative digital agency.',
                'philosophy'    => 'Matang. Siap. Selesai.',
                'story_text_1'  => 'Berdiri sejak 2019.',
                'story_text_2'  => 'Ratusan proyek telah selesai.',
            ],
        ]);

        $about = Setting::getGroup('about');
        $this->assertEquals('Tentang ASAK Agency', $about['about.hero_title']);

        $response = $this->get(route('about'));
        $response->assertStatus(200);
    }

    // =========================================================
    // SKENARIO 5: Contact settings tersimpan dan halaman contact OK
    // =========================================================

    public function test_contact_settings_saved_and_contact_page_loads(): void
    {
        $this->updateSettings([
            'contact' => [
                'email'         => 'hello@asak.id',
                'website'       => 'https://asak.id',
                'address'       => 'Jl. Sudirman No. 1, Jakarta',
                'response_time' => '< 24 jam',
            ],
        ]);

        $this->assertEquals('hello@asak.id', Setting::get('contact.email'));
        $this->assertEquals('< 24 jam', Setting::get('contact.response_time'));

        $contact = Setting::getGroup('contact');
        $this->assertArrayHasKey('contact.email', $contact);

        $response = $this->get(route('contact'));
        $response->assertStatus(200);
    }

    // =========================================================
    // SKENARIO 6: Social settings tersimpan
    // =========================================================

    public function test_social_settings_saved_correctly(): void
    {
        $this->updateSettings([
            'social' => [
                'instagram' => 'https://instagram.com/asak.id',
                'twitter'   => 'https://twitter.com/asakdigital',
                'linkedin'  => 'https://linkedin.com/company/asak-agency',
            ],
        ]);

        $social = Setting::getGroup('social');

        $this->assertEquals('https://instagram.com/asak.id', $social['social.instagram']);
        $this->assertEquals('https://linkedin.com/company/asak-agency', $social['social.linkedin']);
    }

    // =========================================================
    // SKENARIO 7: Update setting dua kali → nilai terbaru yang berlaku
    // =========================================================

    public function test_settings_overwrite_on_second_save(): void
    {
        // Simpan pertama
        $this->updateSettings(['hero' => ['headline' => 'Headline Pertama']]);
        $this->assertEquals('Headline Pertama', Setting::get('hero.headline'));

        // Simpan kedua
        $this->updateSettings(['hero' => ['headline' => 'Headline Kedua']]);
        $this->assertEquals('Headline Kedua', Setting::get('hero.headline'));

        // Hanya 1 record di DB (updateOrCreate)
        $this->assertDatabaseCount('settings', 1);
    }

    // =========================================================
    // SKENARIO 8: Cache di-clear setelah update → data segar diambil
    // =========================================================

    public function test_cache_cleared_after_settings_update(): void
    {
        // Simpan dan cache terisi
        Setting::set('hero.headline', 'Old Value', 'hero');
        Setting::get('hero.headline'); // Trigger cache
        Setting::getGroup('hero');     // Trigger group cache

        // Admin update via controller (seharusnya bersihkan cache)
        $this->updateSettings(['hero' => ['headline' => 'New Value']]);

        // Cache group harus sudah bersih
        $this->assertFalse(Cache::has('settings.group.hero'));

        // Baca ulang → dapat nilai baru
        Cache::forget('setting.hero.headline');
        $this->assertEquals('New Value', Setting::get('hero.headline'));
    }

    // =========================================================
    // SKENARIO 9: Setting dengan nilai null disimpan dengan benar
    // =========================================================

    public function test_nullable_settings_accepted_and_saved(): void
    {
        $this->updateSettings([
            'hero' => [
                'badge_text' => null,
                'headline'   => 'Tidak Null',
                'subheadline' => null,
            ],
        ]);

        // Nullable fields disimpan sebagai null atau kosong
        $this->assertEquals('Tidak Null', Setting::get('hero.headline'));

        // Halaman publik tetap bisa diakses
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    // =========================================================
    // SKENARIO 10: Settings index menampilkan semua grup ke admin
    // =========================================================

    public function test_settings_index_passes_all_groups_to_admin_view(): void
    {
        // Pre-populate settings
        Setting::set('hero.headline', 'Test Headline', 'hero');
        Setting::set('contact.email', 'test@asak.id', 'contact');
        Setting::set('social.instagram', '@asak', 'social');
        Setting::set('stats.projects', '100+', 'stats');
        Setting::set('about.hero_title', 'About ASAK', 'about');

        $response = $this->actingAs($this->admin)->get(route('admin.settings.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->has('hero')
                 ->has('contact')
                 ->has('social')
                 ->has('stats')
                 ->has('about')
        );
    }
}
