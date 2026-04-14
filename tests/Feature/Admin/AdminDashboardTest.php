<?php

namespace Tests\Feature\Admin;

use App\Models\ContactSubmission;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    // ---------- Akses ----------

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_guest_redirected_from_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_slash_redirects_to_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');
        $response->assertStatus(200);
    }

    // ---------- Stats dikirim ke view ----------

    public function test_dashboard_passes_portfolio_count(): void
    {
        Portfolio::create(['title' => 'P1', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        Portfolio::create(['title' => 'P2', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn ($page) =>
            $page->where('stats.portfolios', 2)
        );
    }

    public function test_dashboard_passes_service_count(): void
    {
        Service::create(['title' => 'S1', 'description' => 'D']);
        Service::create(['title' => 'S2', 'description' => 'D']);
        Service::create(['title' => 'S3', 'description' => 'D']);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn ($page) =>
            $page->where('stats.services', 3)
        );
    }

    public function test_dashboard_passes_team_member_count(): void
    {
        TeamMember::create(['name' => 'M1', 'role' => 'Dev', 'order' => 0]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn ($page) =>
            $page->where('stats.team_members', 1)
        );
    }

    public function test_dashboard_passes_submissions_count(): void
    {
        ContactSubmission::create(['name' => 'A', 'email' => 'a@x.com', 'subject' => 'S', 'message' => 'M']);
        ContactSubmission::create(['name' => 'B', 'email' => 'b@x.com', 'subject' => 'S', 'message' => 'M']);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn ($page) =>
            $page->where('stats.submissions', 2)
        );
    }

    public function test_dashboard_unread_count_is_correct(): void
    {
        ContactSubmission::create(['name' => 'Unread', 'email' => 'u@x.com', 'subject' => 'S', 'message' => 'M', 'is_read' => false]);
        ContactSubmission::create(['name' => 'Read',   'email' => 'r@x.com', 'subject' => 'S', 'message' => 'M', 'is_read' => true]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn ($page) =>
            $page->where('stats.unread', 1)
        );
    }

    public function test_dashboard_passes_recent_submissions(): void
    {
        ContactSubmission::create(['name' => 'Recent', 'email' => 'r@x.com', 'subject' => 'S', 'message' => 'M']);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn ($page) =>
            $page->has('recent_submissions', 1)
        );
    }

    public function test_dashboard_recent_submissions_limited_to_5(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            ContactSubmission::create([
                'name'    => "User {$i}",
                'email'   => "user{$i}@x.com",
                'subject' => 'S',
                'message' => 'M',
            ]);
        }

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn ($page) =>
            $page->has('recent_submissions', 5)
        );
    }

    public function test_dashboard_stats_zero_when_no_data(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn ($page) =>
            $page->where('stats.portfolios', 0)
                 ->where('stats.services', 0)
                 ->where('stats.team_members', 0)
                 ->where('stats.submissions', 0)
                 ->where('stats.unread', 0)
        );
    }

    // ---------- Soft deleted tidak terhitung ----------

    public function test_soft_deleted_portfolio_not_counted_in_stats(): void
    {
        $portfolio = Portfolio::create(['title' => 'P', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $portfolio->delete();

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn ($page) =>
            $page->where('stats.portfolios', 0)
        );
    }
}
