<?php

namespace Tests\Feature\Admin;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPortfolioTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    private function makePortfolio(array $override = []): Portfolio
    {
        return Portfolio::create(array_merge([
            'title'       => 'Sample Portfolio',
            'description' => 'Deskripsi portofolio',
            'client'      => 'Client X',
            'year'        => '2024',
            'category'    => 'Web Design',
            'active'      => true,
            'featured'    => false,
            'order'       => 0,
        ], $override));
    }

    // ---------- Index ----------

    public function test_admin_can_view_portfolio_index(): void
    {
        $this->makePortfolio(['title' => 'Portfolio A']);

        $response = $this->actingAs($this->admin)->get(route('admin.portfolio.index'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_view_portfolio_index(): void
    {
        $response = $this->get(route('admin.portfolio.index'));
        $response->assertRedirect(route('login'));
    }

    // ---------- Create ----------

    public function test_admin_can_view_portfolio_create_form(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.portfolio.create'));
        $response->assertStatus(200);
    }

    // ---------- Store ----------

    public function test_admin_can_store_portfolio(): void
    {
        $data = [
            'title'       => 'New Portfolio',
            'description' => 'Deskripsi baru',
            'client'      => 'Client Y',
            'year'        => '2024',
            'category'    => 'Web Design',
            'featured'    => false,
            'active'      => true,
            'order'       => 0,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.portfolio.store'), $data);

        $response->assertRedirect(route('admin.portfolio.index'));
        $this->assertDatabaseHas('portfolios', ['title' => 'New Portfolio']);
    }

    public function test_store_portfolio_requires_title(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.portfolio.store'), [
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_store_portfolio_requires_valid_year(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.portfolio.store'), [
            'title'       => 'Test',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => 'abcd',
            'category'    => 'Web',
        ]);

        $response->assertSessionHasErrors('year');
    }

    // ---------- Edit ----------

    public function test_admin_can_view_portfolio_edit_form(): void
    {
        $portfolio = $this->makePortfolio();

        $response = $this->actingAs($this->admin)->get(route('admin.portfolio.edit', $portfolio));

        $response->assertStatus(200);
    }

    // ---------- Update ----------

    public function test_admin_can_update_portfolio(): void
    {
        $portfolio = $this->makePortfolio();

        $response = $this->actingAs($this->admin)->put(route('admin.portfolio.update', $portfolio), [
            'title'       => 'Updated Title',
            'description' => 'Deskripsi diupdate',
            'client'      => 'Client Baru',
            'year'        => '2025',
            'category'    => 'Graphic Design',
            'featured'    => false,
            'active'      => true,
            'order'       => 1,
        ]);

        $response->assertRedirect(route('admin.portfolio.index'));
        $this->assertDatabaseHas('portfolios', ['title' => 'Updated Title']);
    }

    // ---------- Destroy (Soft Delete) ----------

    public function test_admin_can_soft_delete_portfolio(): void
    {
        $portfolio = $this->makePortfolio();

        $response = $this->actingAs($this->admin)->delete(route('admin.portfolio.destroy', $portfolio));

        $response->assertRedirect(route('admin.portfolio.index'));
        $this->assertSoftDeleted('portfolios', ['id' => $portfolio->id]);
        $this->assertNull(Portfolio::find($portfolio->id));
    }

    public function test_soft_deleted_portfolio_not_visible_in_index(): void
    {
        $portfolio = $this->makePortfolio(['title' => 'Hidden Portfolio']);
        $portfolio->delete();

        $response = $this->actingAs($this->admin)->get(route('admin.portfolio.index'));

        $response->assertStatus(200);
        $this->assertEquals(0, Portfolio::count());
    }

    // ---------- Audit Log terekam ----------

    public function test_audit_log_recorded_when_admin_creates_portfolio(): void
    {
        $this->actingAs($this->admin)->post(route('admin.portfolio.store'), [
            'title'       => 'Audit Portfolio',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
            'featured'    => false,
            'active'      => true,
            'order'       => 0,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Portfolio::class,
            'event'          => 'created',
            'user_id'        => $this->admin->id,
        ]);
    }

    public function test_audit_log_recorded_when_admin_deletes_portfolio(): void
    {
        $portfolio = $this->makePortfolio();

        $this->actingAs($this->admin)->delete(route('admin.portfolio.destroy', $portfolio));

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Portfolio::class,
            'auditable_id'   => $portfolio->id,
            'event'          => 'deleted',
            'user_id'        => $this->admin->id,
        ]);
    }
}
