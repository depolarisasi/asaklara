<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    // ---------- Index ----------

    public function test_admin_can_view_settings_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.settings.index'));
        $response->assertStatus(200);
    }

    public function test_guest_redirected_from_settings(): void
    {
        $response = $this->get(route('admin.settings.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_settings_page_passes_setting_groups_to_view(): void
    {
        Setting::set('hero.headline', 'Anti-Chaos', 'hero');
        Setting::set('contact.email', 'hello@asak.id', 'contact');

        $response = $this->actingAs($this->admin)->get(route('admin.settings.index'));

        $response->assertInertia(fn ($page) =>
            $page->has('hero')
                 ->has('about')
                 ->has('stats')
                 ->has('contact')
                 ->has('social')
        );
    }

    // ---------- Update ----------

    public function test_admin_can_update_hero_settings(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'hero' => [
                'badge_text'      => 'The Anti-Chaos Agency',
                'headline'        => 'Done Right. Done On Time.',
                'headline_accent' => 'On Time.',
                'subheadline'     => 'We build things that work.',
                'cta_primary'     => 'Get Started',
                'cta_secondary'   => 'View Portfolio',
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertEquals('Done Right. Done On Time.', Setting::get('hero.headline'));
    }

    public function test_admin_can_update_contact_settings(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'contact' => [
                'email'         => 'hello@asak.id',
                'website'       => 'https://asak.id',
                'address'       => 'Jakarta, Indonesia',
                'response_time' => '24 hours',
            ],
        ]);

        $response->assertRedirect();
        $this->assertEquals('hello@asak.id', Setting::get('contact.email'));
        $this->assertEquals('24 hours', Setting::get('contact.response_time'));
    }

    public function test_admin_can_update_social_settings(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'social' => [
                'instagram' => '@asak.id',
                'twitter'   => '@asakdigital',
                'linkedin'  => 'asak-agency',
            ],
        ]);

        $response->assertRedirect();
        $this->assertEquals('@asak.id', Setting::get('social.instagram'));
    }

    public function test_admin_can_update_stats_settings(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'stats' => [
                'projects'   => '200+',
                'clients'    => '50+',
                'experience' => '5 Years',
                'awards'     => '10+',
            ],
        ]);

        $response->assertRedirect();
        $this->assertEquals('200+', Setting::get('stats.projects'));
    }

    public function test_settings_update_clears_group_cache(): void
    {
        // Pre-populate cache
        Cache::put('settings.group.hero', ['hero.headline' => 'Old Headline'], 3600);

        $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'hero' => ['headline' => 'New Headline'],
        ]);

        $this->assertFalse(Cache::has('settings.group.hero'));
    }

    // ---------- Validasi ----------

    public function test_contact_email_must_be_valid_email(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'contact' => [
                'email' => 'bukan-email-valid',
            ],
        ]);

        $response->assertSessionHasErrors('contact.email');
    }

    public function test_hero_badge_text_max_100_chars(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'hero' => [
                'badge_text' => str_repeat('A', 101),
            ],
        ]);

        $response->assertSessionHasErrors('hero.badge_text');
    }

    public function test_hero_headline_max_255_chars(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'hero' => [
                'headline' => str_repeat('X', 256),
            ],
        ]);

        $response->assertSessionHasErrors('hero.headline');
    }

    public function test_empty_settings_payload_is_accepted(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), []);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_null_values_are_accepted_for_optional_settings(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'hero' => [
                'badge_text' => null,
                'headline'   => null,
            ],
        ]);

        $response->assertSessionHasNoErrors();
    }

    // ---------- updateOrCreate behavior ----------

    public function test_update_setting_overwrites_previous_value(): void
    {
        Setting::set('hero.headline', 'Lama', 'hero');

        $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'hero' => ['headline' => 'Baru'],
        ]);

        $this->assertEquals('Baru', Setting::get('hero.headline'));
        $this->assertDatabaseCount('settings', 1);
    }
}
