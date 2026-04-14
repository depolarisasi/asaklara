<?php

namespace Tests\Feature;

use App\Models\ContactSubmission;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    // ---------- Halaman Publik ----------

    public function test_homepage_returns_200(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    public function test_about_page_returns_200(): void
    {
        $response = $this->get(route('about'));
        $response->assertStatus(200);
    }

    public function test_services_page_returns_200(): void
    {
        $response = $this->get(route('services'));
        $response->assertStatus(200);
    }

    public function test_portfolio_page_returns_200(): void
    {
        $response = $this->get(route('portfolio'));
        $response->assertStatus(200);
    }

    public function test_contact_page_returns_200(): void
    {
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
    }

    // ---------- Public pages tidak menampilkan data soft deleted ----------

    public function test_soft_deleted_portfolio_not_shown_on_portfolio_page(): void
    {
        $portfolio = Portfolio::create([
            'title'       => 'Deleted Portfolio',
            'description' => 'Desc',
            'client'      => 'Client',
            'year'        => '2024',
            'category'    => 'Web',
            'active'      => true,
        ]);
        $portfolio->delete();

        $this->assertEquals(0, Portfolio::active()->count());
    }

    public function test_soft_deleted_service_not_in_active_query(): void
    {
        $service = Service::create([
            'title'       => 'Deleted Service',
            'description' => 'Desc',
            'active'      => true,
        ]);
        $service->delete();

        $this->assertEquals(0, Service::active()->count());
    }

    public function test_soft_deleted_team_member_not_in_active_query(): void
    {
        $member = TeamMember::create([
            'name'   => 'Deleted Member',
            'role'   => 'Dev',
            'active' => true,
        ]);
        $member->delete();

        $this->assertEquals(0, TeamMember::active()->count());
    }
}
