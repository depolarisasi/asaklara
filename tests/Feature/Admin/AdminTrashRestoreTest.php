<?php

namespace Tests\Feature\Admin;

use App\Models\Portfolio;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTrashRestoreTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    // ---------- Portfolio Trash & Restore ----------

    public function test_admin_can_view_portfolio_trash(): void
    {
        $portfolio = Portfolio::create(['title' => 'Deleted P', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $portfolio->delete();

        $response = $this->actingAs($this->admin)->get(route('admin.portfolio.trash'));

        $response->assertStatus(200);
    }

    public function test_admin_can_restore_portfolio(): void
    {
        $portfolio = Portfolio::create(['title' => 'Restore Me', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $portfolio->delete();

        $response = $this->actingAs($this->admin)->patch(route('admin.portfolio.restore', $portfolio->id));

        $response->assertRedirect(route('admin.portfolio.trash'));
        $this->assertNotNull(Portfolio::find($portfolio->id));
    }

    public function test_admin_can_force_delete_portfolio(): void
    {
        $portfolio = Portfolio::create(['title' => 'Force Delete Me', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $portfolio->delete();

        $response = $this->actingAs($this->admin)->delete(route('admin.portfolio.force-delete', $portfolio->id));

        $response->assertRedirect(route('admin.portfolio.trash'));
        $this->assertNull(Portfolio::withTrashed()->find($portfolio->id));
    }

    // ---------- Team Trash & Restore ----------

    public function test_admin_can_view_team_trash(): void
    {
        $member = TeamMember::create(['name' => 'Deleted Member', 'role' => 'Dev', 'order' => 0]);
        $member->delete();

        $response = $this->actingAs($this->admin)->get(route('admin.team.trash'));

        $response->assertStatus(200);
    }

    public function test_admin_can_restore_team_member(): void
    {
        $member = TeamMember::create(['name' => 'Restore Member', 'role' => 'Dev', 'order' => 0]);
        $member->delete();

        $response = $this->actingAs($this->admin)->patch(route('admin.team.restore', $member->id));

        $response->assertRedirect(route('admin.team.trash'));
        $this->assertNotNull(TeamMember::find($member->id));
    }

    public function test_admin_can_force_delete_team_member(): void
    {
        $member = TeamMember::create(['name' => 'Force Delete Member', 'role' => 'Dev', 'order' => 0]);
        $member->delete();

        $response = $this->actingAs($this->admin)->delete(route('admin.team.force-delete', $member->id));

        $response->assertRedirect(route('admin.team.trash'));
        $this->assertNull(TeamMember::withTrashed()->find($member->id));
    }

    // ---------- Service Trash & Restore ----------

    public function test_admin_can_view_service_trash(): void
    {
        $service = Service::create(['title' => 'Deleted Service', 'description' => 'D']);
        $service->delete();

        $response = $this->actingAs($this->admin)->get(route('admin.services.trash'));

        $response->assertStatus(200);
    }

    public function test_admin_can_restore_service(): void
    {
        $service = Service::create(['title' => 'Restore Service', 'description' => 'D']);
        $service->delete();

        $response = $this->actingAs($this->admin)->patch(route('admin.services.restore', $service->id));

        $response->assertRedirect(route('admin.services.trash'));
        $this->assertNotNull(Service::find($service->id));
    }

    public function test_admin_can_force_delete_service(): void
    {
        $service = Service::create(['title' => 'Force Delete Service', 'description' => 'D']);
        $service->delete();

        $response = $this->actingAs($this->admin)->delete(route('admin.services.force-delete', $service->id));

        $response->assertRedirect(route('admin.services.trash'));
        $this->assertNull(Service::withTrashed()->find($service->id));
    }

    // ---------- Guest tidak bisa akses trash ----------

    public function test_guest_cannot_access_trash_pages(): void
    {
        $this->get(route('admin.portfolio.trash'))->assertRedirect(route('login'));
        $this->get(route('admin.team.trash'))->assertRedirect(route('login'));
        $this->get(route('admin.services.trash'))->assertRedirect(route('login'));
    }
}
