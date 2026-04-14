<?php

namespace Tests\Unit;

use App\Models\AuditLog;
use App\Models\Portfolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    // ---------- Fillable & Casts ----------

    public function test_portfolio_has_correct_fillable_fields(): void
    {
        $portfolio = new Portfolio();
        $this->assertContains('title', $portfolio->getFillable());
        $this->assertContains('slug', $portfolio->getFillable());
        $this->assertContains('description', $portfolio->getFillable());
        $this->assertContains('client', $portfolio->getFillable());
        $this->assertContains('category', $portfolio->getFillable());
        $this->assertContains('featured', $portfolio->getFillable());
        $this->assertContains('active', $portfolio->getFillable());
    }

    public function test_portfolio_casts_boolean_fields(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'Test Portfolio',
            'description' => 'Deskripsi test',
            'client'      => 'Client X',
            'year'        => '2024',
            'category'    => 'Web Design',
            'featured'    => 1,
            'active'      => 1,
        ]);

        $this->assertIsBool($portfolio->featured);
        $this->assertIsBool($portfolio->active);
    }

    // ---------- Slug Auto-Generate ----------

    public function test_portfolio_auto_generates_slug_on_create(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'My Awesome Project',
            'description' => 'Desc',
            'client'      => 'Client A',
            'year'        => '2024',
            'category'    => 'Web Design',
        ]);

        $this->assertEquals('my-awesome-project', $portfolio->slug);
    }

    public function test_portfolio_uses_provided_slug_if_given(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'My Project',
            'slug'        => 'custom-slug',
            'description' => 'Desc',
            'client'      => 'Client A',
            'year'        => '2024',
            'category'    => 'Web Design',
        ]);

        $this->assertEquals('custom-slug', $portfolio->slug);
    }

    // ---------- Scopes ----------

    public function test_active_scope_returns_only_active_portfolios(): void
    {
        Portfolio::create(['title' => 'Active One', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web', 'active' => true]);
        Portfolio::create(['title' => 'Inactive One', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web', 'active' => false]);

        $result = Portfolio::active()->get();

        $this->assertCount(1, $result);
        $this->assertEquals('Active One', $result->first()->title);
    }

    // ---------- Image URL Accessor ----------

    public function test_image_url_returns_picsum_when_no_image(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'No Image Portfolio',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
        ]);

        $this->assertStringContainsString('picsum.photos', $portfolio->image_url);
    }

    public function test_image_url_returns_external_url_as_is(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'External Image',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
            'image'       => 'https://example.com/img.jpg',
        ]);

        $this->assertEquals('https://example.com/img.jpg', $portfolio->image_url);
    }

    // ---------- Soft Delete ----------

    public function test_portfolio_can_be_soft_deleted(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'To Be Deleted',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
        ]);

        $portfolio->delete();

        $this->assertSoftDeleted('portfolios', ['id' => $portfolio->id]);
        $this->assertNull(Portfolio::find($portfolio->id));
    }

    public function test_portfolio_can_be_restored_after_soft_delete(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'Restorable',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
        ]);

        $portfolio->delete();
        $portfolio->restore();

        $this->assertNotNull(Portfolio::find($portfolio->id));
    }

    public function test_soft_deleted_portfolio_excluded_from_default_query(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'Hidden',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
        ]);
        $portfolio->delete();

        $this->assertCount(0, Portfolio::all());
        $this->assertCount(1, Portfolio::withTrashed()->get());
    }

    // ---------- Audit Log ----------

    public function test_audit_log_created_on_portfolio_create(): void
    {
        Portfolio::create([
            'title'       => 'Audit Test',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Portfolio::class,
            'event'          => 'created',
        ]);
    }

    public function test_audit_log_created_on_portfolio_update(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'Before Update',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
        ]);

        $portfolio->update(['title' => 'After Update']);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Portfolio::class,
            'auditable_id'   => $portfolio->id,
            'event'          => 'updated',
        ]);
    }

    public function test_audit_log_created_on_portfolio_soft_delete(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'Delete Me',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
        ]);

        $portfolio->delete();

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Portfolio::class,
            'auditable_id'   => $portfolio->id,
            'event'          => 'deleted',
        ]);
    }

    public function test_audit_log_created_on_portfolio_restore(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'Restore Me',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
        ]);

        $portfolio->delete();
        $portfolio->restore();

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Portfolio::class,
            'auditable_id'   => $portfolio->id,
            'event'          => 'restored',
        ]);
    }
}
