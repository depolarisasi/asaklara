<?php

/**
 * Integration Test: Dashboard Stats — Akurasi Real-Time
 *
 * Memverifikasi bahwa stats di dashboard admin selalu mencerminkan
 * kondisi nyata database setelah berbagai operasi CRUD.
 * Integrasi: DashboardController ↔ Portfolio/Service/TeamMember/ContactSubmission models
 */

namespace Tests\Feature\Integration;

use App\Models\ContactSubmission;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\ServiceFeature;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardStatsIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    private function getDashboardStats(): array
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);

        // Hitung langsung dari model (sama seperti yang dilakukan DashboardController)
        return [
            'portfolios'   => Portfolio::count(),
            'services'     => Service::count(),
            'team_members' => TeamMember::count(),
            'submissions'  => ContactSubmission::count(),
            'unread'       => ContactSubmission::unread()->count(),
        ];
    }

    // =========================================================
    // SKENARIO 1: Stats awal = 0 saat database kosong
    // =========================================================

    public function test_dashboard_shows_zero_stats_on_empty_database(): void
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

    // =========================================================
    // SKENARIO 2: Buat records → stats naik
    // =========================================================

    public function test_dashboard_stats_increase_as_records_are_created(): void
    {
        // Tambah 2 portfolio
        Portfolio::create(['title' => 'P1', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        Portfolio::create(['title' => 'P2', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);

        $response1 = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response1->assertInertia(fn ($p) => $p->where('stats.portfolios', 2));

        // Tambah 1 service
        Service::create(['title' => 'S1', 'description' => 'D']);

        $response2 = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response2->assertInertia(fn ($p) => $p->where('stats.services', 1));

        // Tambah 1 member
        TeamMember::create(['name' => 'M1', 'role' => 'Dev', 'order' => 0]);

        $response3 = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response3->assertInertia(fn ($p) => $p->where('stats.team_members', 1));
    }

    // =========================================================
    // SKENARIO 3: Soft delete → stats turun, withTrashed tetap ada
    // =========================================================

    public function test_soft_deleted_records_not_counted_in_dashboard_stats(): void
    {
        $p1 = Portfolio::create(['title' => 'P1', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $p2 = Portfolio::create(['title' => 'P2', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);

        // Verifikasi 2 portfolio
        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertInertia(fn ($p) => $p->where('stats.portfolios', 2));

        // Hapus satu
        $p1->delete();

        // Stats harus turun ke 1
        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertInertia(fn ($p) => $p->where('stats.portfolios', 1));
    }

    // =========================================================
    // SKENARIO 4: Unread submissions count akurat saat mark-read
    // =========================================================

    public function test_unread_count_decreases_when_submissions_marked_read(): void
    {
        // 4 unread submissions
        for ($i = 1; $i <= 4; $i++) {
            ContactSubmission::create([
                'name' => "User {$i}", 'email' => "u{$i}@x.com",
                'subject' => 'S', 'message' => 'M', 'is_read' => false,
            ]);
        }

        // Dashboard awal: 4 unread
        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertInertia(fn ($p) => $p->where('stats.unread', 4));

        // Mark 2 sebagai terbaca
        $subs = ContactSubmission::take(2)->get();
        foreach ($subs as $sub) {
            $this->actingAs($this->admin)->patch(route('admin.submissions.read', $sub));
        }

        // Dashboard: 2 unread tersisa
        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertInertia(fn ($p) => $p->where('stats.unread', 2));
    }

    // =========================================================
    // SKENARIO 5: Restore → stats naik kembali
    // =========================================================

    public function test_stats_recover_after_restore(): void
    {
        $service = Service::create(['title' => 'Temp Service', 'description' => 'D']);

        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertInertia(fn ($p) => $p->where('stats.services', 1));

        // Soft delete
        $service->delete();
        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertInertia(fn ($p) => $p->where('stats.services', 0));

        // Restore
        $service->restore();
        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertInertia(fn ($p) => $p->where('stats.services', 1));
    }

    // =========================================================
    // SKENARIO 6: Recent submissions — 5 terbaru (bukan semua)
    // =========================================================

    public function test_recent_submissions_shows_latest_5_only(): void
    {
        // Buat 8 submissions
        for ($i = 1; $i <= 8; $i++) {
            ContactSubmission::create([
                'name'    => "Pengirim {$i}",
                'email'   => "p{$i}@x.com",
                'subject' => "Pesan {$i}",
                'message' => 'Isi pesan.',
                'is_read' => false,
            ]);
        }

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertInertia(fn ($page) =>
            $page->where('stats.submissions', 8)
                 ->has('recent_submissions', 5)
        );
    }

    // =========================================================
    // SKENARIO 7: Recent submissions — query mengembalikan jumlah yang benar
    // =========================================================

    public function test_recent_submissions_query_returns_correct_count(): void
    {
        // Buat 3 submissions
        ContactSubmission::create(['name' => 'Pertama', 'email' => 'a@x.com', 'subject' => 'S', 'message' => 'M']);
        ContactSubmission::create(['name' => 'Kedua',   'email' => 'b@x.com', 'subject' => 'S', 'message' => 'M']);
        ContactSubmission::create(['name' => 'Ketiga',  'email' => 'c@x.com', 'subject' => 'S', 'message' => 'M']);

        // latest() membatasi dengan take(5) — verifikasi count dan semua nama ada
        $latest = ContactSubmission::latest('id')->take(5)->get();
        $this->assertCount(3, $latest);

        $names = $latest->pluck('name')->toArray();
        $this->assertContains('Pertama', $names);
        $this->assertContains('Kedua', $names);
        $this->assertContains('Ketiga', $names);

        // Record dengan ID terbesar paling dulu (order by id desc)
        $byId = ContactSubmission::orderByDesc('id')->take(5)->get();
        $this->assertEquals('Ketiga', $byId->first()->name);
        $this->assertEquals('Pertama', $byId->last()->name);
    }

    // =========================================================
    // SKENARIO 8: Semua stats berubah bersamaan dalam satu siklus
    // =========================================================

    public function test_all_stats_reflect_mixed_crud_operations(): void
    {
        // Buat data awal
        $p = Portfolio::create(['title' => 'P', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $s = Service::create(['title' => 'S', 'description' => 'D']);
        $m = TeamMember::create(['name' => 'M', 'role' => 'Dev', 'order' => 0]);
        ContactSubmission::create(['name' => 'N', 'email' => 'n@x.com', 'subject' => 'Sub', 'message' => 'Msg', 'is_read' => false]);

        // Stats awal semua = 1
        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertInertia(fn ($page) =>
                $page->where('stats.portfolios', 1)
                     ->where('stats.services', 1)
                     ->where('stats.team_members', 1)
                     ->where('stats.submissions', 1)
                     ->where('stats.unread', 1)
            );

        // Hapus portfolio, tambah service, hapus member
        $p->delete();
        Service::create(['title' => 'S2', 'description' => 'D2']);
        $m->delete();

        // Stats setelah operasi campuran
        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertInertia(fn ($page) =>
                $page->where('stats.portfolios', 0)   // dihapus
                     ->where('stats.services', 2)      // ditambah 1
                     ->where('stats.team_members', 0)  // dihapus
                     ->where('stats.submissions', 1)   // tidak berubah
                     ->where('stats.unread', 1)        // masih unread
            );
    }

    // =========================================================
    // SKENARIO 9: Submission dibaca → unread turun, total tidak berubah
    // =========================================================

    public function test_reading_submission_affects_unread_not_total(): void
    {
        $sub1 = ContactSubmission::create(['name' => 'A', 'email' => 'a@x.com', 'subject' => 'S', 'message' => 'M', 'is_read' => false]);
        $sub2 = ContactSubmission::create(['name' => 'B', 'email' => 'b@x.com', 'subject' => 'S', 'message' => 'M', 'is_read' => false]);

        // Mark sub1 as read
        $this->actingAs($this->admin)->patch(route('admin.submissions.read', $sub1));

        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertInertia(fn ($page) =>
                $page->where('stats.submissions', 2) // total tidak berubah
                     ->where('stats.unread', 1)       // unread turun
            );
    }
}
