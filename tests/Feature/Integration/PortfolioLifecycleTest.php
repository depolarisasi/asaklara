<?php

/**
 * Integration Test: Siklus Hidup Portfolio — End-to-End
 *
 * Menguji seluruh perjalanan sebuah portfolio:
 * Admin create → tampil di admin list → tampil di halaman publik →
 * featured di homepage → edit (slug regenerasi) → nonaktifkan →
 * hilang dari publik → soft delete → masuk trash → restore →
 * kembali ke publik → force delete → hilang selamanya
 */

namespace Tests\Feature\Integration;

use App\Models\AuditLog;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioLifecycleTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    private function storePortfolio(array $override = []): \Illuminate\Testing\TestResponse
    {
        return $this->actingAs($this->admin)->post(route('admin.portfolio.store'), array_merge([
            'title'       => 'Redesign Website Kopi Nusantara',
            'description' => 'Redesign total untuk brand kopi lokal terkemuka.',
            'client'      => 'Kopi Nusantara',
            'year'        => '2024',
            'category'    => 'Web Design',
            'featured'    => false,
            'active'      => true,
            'order'       => 0,
        ], $override));
    }

    // =========================================================
    // SKENARIO 1: Admin create → tampil di admin list & publik
    // =========================================================

    public function test_admin_creates_portfolio_and_it_appears_on_public_page(): void
    {
        $this->storePortfolio(['title' => 'Website Batik Jogja', 'active' => true]);

        $portfolio = Portfolio::first();
        $this->assertNotNull($portfolio);

        // Tampil di admin index
        $adminResponse = $this->actingAs($this->admin)->get(route('admin.portfolio.index'));
        $adminResponse->assertStatus(200);
        $this->assertEquals(1, Portfolio::count());

        // Tampil di halaman publik (active)
        $this->assertEquals(1, Portfolio::active()->count());

        // Audit log tercatat
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Portfolio::class,
            'auditable_id'   => $portfolio->id,
            'event'          => 'created',
            'user_id'        => $this->admin->id,
        ]);
    }

    // =========================================================
    // SKENARIO 2: Portfolio featured → muncul di homepage
    // =========================================================

    public function test_featured_portfolio_appears_on_homepage(): void
    {
        // Buat 2 portfolio: 1 featured, 1 biasa
        Portfolio::create(['title' => 'Featured P',  'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web', 'featured' => true,  'active' => true,  'order' => 0]);
        Portfolio::create(['title' => 'Regular P',   'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web', 'featured' => false, 'active' => true,  'order' => 1]);

        // Homepage mengambil featured dulu
        $featured = Portfolio::active()->where('featured', true)->take(3)->get();
        $this->assertCount(1, $featured);
        $this->assertEquals('Featured P', $featured->first()->title);

        // Halaman publik
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    // =========================================================
    // SKENARIO 3: Admin edit portfolio → slug auto-regenerasi saat title berubah
    // =========================================================

    public function test_slug_auto_regenerates_when_title_changes_on_update(): void
    {
        $this->storePortfolio(['title' => 'Website Lama']);
        $portfolio = Portfolio::first();
        $originalSlug = $portfolio->slug;

        $this->assertEquals('website-lama', $originalSlug);

        // Update dengan title baru, slug kosong (trigger auto-regen)
        $this->actingAs($this->admin)->put(route('admin.portfolio.update', $portfolio), [
            'title'       => 'Website Baru Keren',
            'description' => 'Deskripsi baru',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web Design',
            'featured'    => false,
            'active'      => true,
            'order'       => 0,
        ]);

        $this->assertEquals('website-baru-keren', $portfolio->fresh()->slug);
        $this->assertNotEquals($originalSlug, $portfolio->fresh()->slug);
    }

    // =========================================================
    // SKENARIO 4: Admin nonaktifkan portfolio → hilang dari publik
    // =========================================================

    public function test_deactivating_portfolio_removes_it_from_public_view(): void
    {
        $this->storePortfolio(['title' => 'Portfolio Aktif', 'active' => true]);
        $portfolio = Portfolio::first();

        $this->assertEquals(1, Portfolio::active()->count());

        // Admin nonaktifkan
        $this->actingAs($this->admin)->put(route('admin.portfolio.update', $portfolio), [
            'title'       => 'Portfolio Aktif',
            'description' => 'Deskripsi',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web Design',
            'featured'    => false,
            'active'      => false, // dinonaktifkan
            'order'       => 0,
        ]);

        $this->assertEquals(0, Portfolio::active()->count());
        $this->assertEquals(1, Portfolio::count()); // masih ada, hanya tidak aktif
    }

    // =========================================================
    // SKENARIO 5: Filter kategori di halaman publik portfolio
    // =========================================================

    public function test_category_filter_on_public_portfolio_page(): void
    {
        Portfolio::create(['title' => 'Web Project',   'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web Design',    'active' => true,  'order' => 0]);
        Portfolio::create(['title' => 'Graphic Work',  'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Graphic Design', 'active' => true,  'order' => 1]);
        Portfolio::create(['title' => 'Photo Project', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web Design',    'active' => true,  'order' => 2]);

        // Filter Web Design → hanya 2 yang tampil
        $filtered = Portfolio::active()->where('category', 'Web Design')->get();
        $this->assertCount(2, $filtered);

        // Filter Graphic Design → 1
        $filtered2 = Portfolio::active()->where('category', 'Graphic Design')->get();
        $this->assertCount(1, $filtered2);

        // Publik route dengan query filter
        $response = $this->get(route('portfolio') . '?category=Web+Design');
        $response->assertStatus(200);
    }

    // =========================================================
    // SKENARIO 6: Soft delete → masuk trash → tidak muncul di publik/admin-index
    // =========================================================

    public function test_soft_delete_moves_portfolio_to_trash_and_hides_from_public(): void
    {
        $this->storePortfolio(['title' => 'Portfolio Dihapus']);
        $portfolio = Portfolio::first();

        $this->assertEquals(1, Portfolio::count());
        $this->assertEquals(1, Portfolio::active()->count());

        // Admin soft delete
        $response = $this->actingAs($this->admin)->delete(
            route('admin.portfolio.destroy', $portfolio)
        );

        $response->assertRedirect(route('admin.portfolio.index'));
        $this->assertEquals(0, Portfolio::count());         // tidak ada di default query
        $this->assertEquals(0, Portfolio::active()->count()); // tidak di publik
        $this->assertEquals(1, Portfolio::withTrashed()->count()); // ada di withTrashed
        $this->assertSoftDeleted('portfolios', ['id' => $portfolio->id]);
    }

    // =========================================================
    // SKENARIO 7: Trash page menampilkan item soft deleted
    // =========================================================

    public function test_trash_page_shows_soft_deleted_portfolios(): void
    {
        $this->storePortfolio(['title' => 'Akan Dihapus']);
        $portfolio = Portfolio::first();
        $this->actingAs($this->admin)->delete(route('admin.portfolio.destroy', $portfolio));

        $response = $this->actingAs($this->admin)->get(route('admin.portfolio.trash'));
        $response->assertStatus(200);

        $this->assertEquals(1, Portfolio::onlyTrashed()->count());
    }

    // =========================================================
    // SKENARIO 8: Restore → kembali ke publik, audit log tercatat
    // =========================================================

    public function test_restore_brings_portfolio_back_to_public(): void
    {
        $this->storePortfolio(['title' => 'Portfolio Restore']);
        $portfolio = Portfolio::first();

        // Hapus
        $this->actingAs($this->admin)->delete(route('admin.portfolio.destroy', $portfolio));
        $this->assertEquals(0, Portfolio::count());

        // Restore
        $response = $this->actingAs($this->admin)->patch(
            route('admin.portfolio.restore', $portfolio->id)
        );

        $response->assertRedirect(route('admin.portfolio.trash'));
        $this->assertEquals(1, Portfolio::count()); // kembali ada
        $this->assertNotNull(Portfolio::find($portfolio->id));

        // Audit log: created, deleted, restored
        $events = AuditLog::where('auditable_type', Portfolio::class)
            ->where('auditable_id', $portfolio->id)
            ->pluck('event')
            ->toArray();

        $this->assertContains('created', $events);
        $this->assertContains('deleted', $events);
        $this->assertContains('restored', $events);
    }

    // =========================================================
    // SKENARIO 9: Force delete → hilang selamanya dari DB
    // =========================================================

    public function test_force_delete_permanently_removes_portfolio(): void
    {
        $this->storePortfolio(['title' => 'Portfolio Force Delete']);
        $portfolio = Portfolio::first();
        $portfolioId = $portfolio->id;

        // Soft delete dulu
        $this->actingAs($this->admin)->delete(route('admin.portfolio.destroy', $portfolio));
        $this->assertEquals(1, Portfolio::withTrashed()->count());

        // Force delete
        $response = $this->actingAs($this->admin)->delete(
            route('admin.portfolio.force-delete', $portfolioId)
        );

        $response->assertRedirect(route('admin.portfolio.trash'));
        $this->assertEquals(0, Portfolio::withTrashed()->count()); // benar-benar hilang

        // Audit log force_deleted tercatat
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Portfolio::class,
            'auditable_id'   => $portfolioId,
            'event'          => 'force_deleted',
        ]);
    }

    // =========================================================
    // SKENARIO 10: Full lifecycle lengkap dalam satu tes
    // =========================================================

    public function test_complete_portfolio_lifecycle(): void
    {
        // 1. Create
        $this->storePortfolio(['title' => 'Full Lifecycle Portfolio', 'active' => true]);
        $portfolio = Portfolio::first();
        $this->assertEquals(1, Portfolio::active()->count());

        // 2. Edit
        $this->actingAs($this->admin)->put(route('admin.portfolio.update', $portfolio), [
            'title' => 'Full Lifecycle Portfolio Updated', 'description' => 'D',
            'client' => 'C', 'year' => '2024', 'category' => 'Web Design',
            'featured' => false, 'active' => true, 'order' => 0,
        ]);
        $this->assertEquals('Full Lifecycle Portfolio Updated', $portfolio->fresh()->title);

        // 3. Soft delete
        $this->actingAs($this->admin)->delete(route('admin.portfolio.destroy', $portfolio));
        $this->assertEquals(0, Portfolio::active()->count());

        // 4. Restore
        $this->actingAs($this->admin)->patch(route('admin.portfolio.restore', $portfolio->id));
        $this->assertEquals(1, Portfolio::active()->count());

        // 5. Force delete
        $this->actingAs($this->admin)->delete(route('admin.portfolio.destroy', $portfolio->fresh()));
        $this->actingAs($this->admin)->delete(route('admin.portfolio.force-delete', $portfolio->id));
        $this->assertEquals(0, Portfolio::withTrashed()->count());

        // Semua event terekam
        $events = AuditLog::where('auditable_type', Portfolio::class)
            ->where('auditable_id', $portfolio->id)
            ->pluck('event')
            ->toArray();

        $this->assertContains('created', $events);
        $this->assertContains('updated', $events);
        $this->assertContains('deleted', $events);
        $this->assertContains('restored', $events);
        $this->assertContains('force_deleted', $events);
    }
}
