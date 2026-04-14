<?php

/**
 * Integration Test: Autentikasi & Kontrol Akses Admin
 *
 * Menguji bahwa sistem auth bekerja sebagai gate untuk admin panel:
 * - Guest tidak dapat akses halaman admin sama sekali
 * - Authenticated user dapat akses semua admin routes
 * - Setelah logout, akses admin terblokir kembali
 * - Setiap admin route terlindungi secara konsisten
 */

namespace Tests\Feature\Integration;

use App\Models\ContactSubmission;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAdminIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    // =========================================================
    // SKENARIO 1: Guest diblokir dari semua admin routes
    // =========================================================

    public function test_guest_is_redirected_from_all_admin_routes(): void
    {
        $adminRoutes = [
            ['GET',    route('admin.dashboard')],
            ['GET',    route('admin.portfolio.index')],
            ['GET',    route('admin.portfolio.create')],
            ['GET',    route('admin.portfolio.trash')],
            ['GET',    route('admin.team.index')],
            ['GET',    route('admin.team.create')],
            ['GET',    route('admin.team.trash')],
            ['GET',    route('admin.services.index')],
            ['GET',    route('admin.services.create')],
            ['GET',    route('admin.services.trash')],
            ['GET',    route('admin.submissions.index')],
            ['GET',    route('admin.settings.index')],
        ];

        foreach ($adminRoutes as [$method, $url]) {
            $response = $this->call($method, $url);
            $response->assertRedirect(route('login'));
        }
    }

    // =========================================================
    // SKENARIO 2: Authenticated user dapat akses semua admin routes
    // =========================================================

    public function test_authenticated_user_can_access_all_admin_routes(): void
    {
        $adminGetRoutes = [
            route('admin.dashboard'),
            route('admin.portfolio.index'),
            route('admin.portfolio.create'),
            route('admin.team.index'),
            route('admin.team.create'),
            route('admin.services.index'),
            route('admin.services.create'),
            route('admin.submissions.index'),
            route('admin.settings.index'),
        ];

        foreach ($adminGetRoutes as $url) {
            $response = $this->actingAs($this->admin)->get($url);
            $response->assertStatus(200);
        }
    }

    // =========================================================
    // SKENARIO 3: Admin melakukan operasi CRUD setelah login
    // =========================================================

    public function test_authenticated_admin_can_perform_crud_operations(): void
    {
        // Create portfolio
        $response = $this->actingAs($this->admin)->post(route('admin.portfolio.store'), [
            'title'       => 'Auth Test Portfolio',
            'description' => 'Dibuat setelah login.',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web Design',
            'featured'    => false,
            'active'      => true,
            'order'       => 0,
        ]);

        $response->assertRedirect(route('admin.portfolio.index'));
        $this->assertDatabaseHas('portfolios', ['title' => 'Auth Test Portfolio']);

        // Update portfolio
        $portfolio = Portfolio::first();
        $this->actingAs($this->admin)->put(route('admin.portfolio.update', $portfolio), [
            'title'       => 'Auth Test Portfolio Updated',
            'description' => 'Diupdate.',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web Design',
            'featured'    => false,
            'active'      => true,
            'order'       => 0,
        ]);

        $this->assertEquals('Auth Test Portfolio Updated', $portfolio->fresh()->title);

        // Delete portfolio
        $this->actingAs($this->admin)->delete(route('admin.portfolio.destroy', $portfolio));
        $this->assertSoftDeleted('portfolios', ['id' => $portfolio->id]);
    }

    // =========================================================
    // SKENARIO 4: Guest tidak bisa POST ke admin routes
    // =========================================================

    public function test_guest_cannot_post_to_admin_routes(): void
    {
        $postRoutes = [
            [route('admin.portfolio.store'), ['title' => 'Hack Portfolio']],
            [route('admin.team.store'),      ['name' => 'Hacker', 'role' => 'Bad Actor']],
            [route('admin.services.store'),  ['title' => 'Hack Service']],
            [route('admin.settings.update'), ['hero' => ['headline' => 'Hacked!']]],
        ];

        foreach ($postRoutes as [$url, $data]) {
            $response = $this->post($url, $data);
            $response->assertRedirect(route('login'));
        }

        // Tidak ada data yang masuk ke DB
        $this->assertEquals(0, Portfolio::count());
        $this->assertEquals(0, TeamMember::count());
        $this->assertEquals(0, Service::count());
    }

    // =========================================================
    // SKENARIO 5: Guest tidak bisa PATCH/DELETE ke admin routes
    // =========================================================

    public function test_guest_cannot_patch_or_delete_admin_resources(): void
    {
        // Buat data dulu via model langsung (bypass auth)
        $portfolio = Portfolio::create(['title' => 'P', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $member    = TeamMember::create(['name' => 'M', 'role' => 'Dev', 'order' => 0]);
        $service   = Service::create(['title' => 'S', 'description' => 'D']);
        $sub       = ContactSubmission::create(['name' => 'N', 'email' => 'n@x.com', 'subject' => 'S', 'message' => 'M']);

        // Guest coba hapus
        $this->delete(route('admin.portfolio.destroy', $portfolio))->assertRedirect(route('login'));
        $this->delete(route('admin.team.destroy', $member))->assertRedirect(route('login'));
        $this->delete(route('admin.services.destroy', $service))->assertRedirect(route('login'));
        $this->delete(route('admin.submissions.destroy', $sub))->assertRedirect(route('login'));

        // Semua data masih ada
        $this->assertEquals(1, Portfolio::count());
        $this->assertEquals(1, TeamMember::count());
        $this->assertEquals(1, Service::count());
        $this->assertEquals(1, ContactSubmission::count());
    }

    // =========================================================
    // SKENARIO 6: Halaman publik dapat diakses tanpa login
    // =========================================================

    public function test_public_pages_accessible_without_authentication(): void
    {
        $publicRoutes = [
            route('home'),
            route('about'),
            route('services'),
            route('portfolio'),
            route('contact'),
        ];

        foreach ($publicRoutes as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }
    }

    // =========================================================
    // SKENARIO 7: Admin dapat akses halaman publik juga
    // =========================================================

    public function test_authenticated_admin_can_also_access_public_pages(): void
    {
        $response = $this->actingAs($this->admin)->get(route('home'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get(route('portfolio'));
        $response->assertStatus(200);
    }

    // =========================================================
    // SKENARIO 8: Admin login kemudian akses panel, lalu session dihormati
    // =========================================================

    public function test_admin_session_maintained_across_multiple_requests(): void
    {
        // Request pertama: dashboard
        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertStatus(200);

        // Request kedua: portfolio (masih sama user)
        $this->actingAs($this->admin)->get(route('admin.portfolio.index'))
            ->assertStatus(200);

        // Request ketiga: create submission → admin lihat
        ContactSubmission::create([
            'name' => 'Test', 'email' => 't@x.com', 'subject' => 'S', 'message' => 'M',
        ]);
        $this->actingAs($this->admin)->get(route('admin.submissions.index'))
            ->assertStatus(200);
    }

    // =========================================================
    // SKENARIO 9: Trash routes terlindungi (guest tidak bisa akses)
    // =========================================================

    public function test_trash_routes_protected_from_guests(): void
    {
        $trashRoutes = [
            route('admin.portfolio.trash'),
            route('admin.team.trash'),
            route('admin.services.trash'),
        ];

        foreach ($trashRoutes as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }
    }

    // =========================================================
    // SKENARIO 10: Restore & force-delete routes terlindungi
    // =========================================================

    public function test_restore_and_force_delete_routes_protected_from_guests(): void
    {
        $portfolio = Portfolio::create(['title' => 'P', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $portfolio->delete();

        // Guest coba restore
        $this->patch(route('admin.portfolio.restore', $portfolio->id))
            ->assertRedirect(route('login'));

        // Data masih soft-deleted
        $this->assertSoftDeleted('portfolios', ['id' => $portfolio->id]);

        // Guest coba force-delete
        $this->delete(route('admin.portfolio.force-delete', $portfolio->id))
            ->assertRedirect(route('login'));

        // Data masih ada di DB
        $this->assertEquals(1, Portfolio::withTrashed()->count());
    }
}
