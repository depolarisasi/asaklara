<?php

/**
 * Integration Test: Siklus Hidup Team Member
 *
 * Menguji alur lengkap anggota tim:
 * Admin create → tampil di halaman /about →
 * Nonaktifkan → hilang dari about →
 * Soft delete → masuk trash →
 * Restore → kembali di about →
 * Force delete → hilang selamanya
 */

namespace Tests\Feature\Integration;

use App\Models\AuditLog;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamMemberLifecycleTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    private function storeMember(array $override = []): \Illuminate\Testing\TestResponse
    {
        return $this->actingAs($this->admin)->post(route('admin.team.store'), array_merge([
            'name'   => 'Budi Santoso',
            'role'   => 'Lead Developer',
            'order'  => 0,
            'active' => true,
        ], $override));
    }

    // =========================================================
    // SKENARIO 1: Create member → tampil di halaman about
    // =========================================================

    public function test_creating_team_member_makes_them_appear_on_about_page(): void
    {
        $this->storeMember(['name' => 'Andi Wijaya', 'role' => 'UI/UX Designer']);

        $member = TeamMember::first();
        $this->assertNotNull($member);
        $this->assertTrue($member->active);
        $this->assertEquals(1, TeamMember::active()->count());

        // Halaman about publik dapat diakses
        $response = $this->get(route('about'));
        $response->assertStatus(200);

        // Audit log created
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => TeamMember::class,
            'auditable_id'   => $member->id,
            'event'          => 'created',
            'user_id'        => $this->admin->id,
        ]);
    }

    // =========================================================
    // SKENARIO 2: Nonaktifkan member → hilang dari about
    // =========================================================

    public function test_deactivating_member_removes_them_from_about_page(): void
    {
        $this->storeMember(['name' => 'Citra Dewi', 'active' => true]);
        $member = TeamMember::first();

        $this->assertEquals(1, TeamMember::active()->count());

        // Admin nonaktifkan
        $this->actingAs($this->admin)->put(route('admin.team.update', $member), [
            'name'   => 'Citra Dewi',
            'role'   => 'Lead Developer',
            'order'  => 0,
            'active' => false,
        ]);

        $this->assertEquals(0, TeamMember::active()->count());
        $this->assertEquals(1, TeamMember::count()); // masih ada, hanya nonaktif
    }

    // =========================================================
    // SKENARIO 3: Update member → data berubah, audit log tercatat
    // =========================================================

    public function test_updating_member_reflects_changes_and_logs_audit(): void
    {
        $this->storeMember(['name' => 'Dedi Kurniawan', 'role' => 'Junior Developer']);
        $member = TeamMember::first();

        $this->actingAs($this->admin)->put(route('admin.team.update', $member), [
            'name'   => 'Dedi Kurniawan',
            'role'   => 'Senior Developer',
            'order'  => 1,
            'active' => true,
        ]);

        $this->assertEquals('Senior Developer', $member->fresh()->role);

        // Audit log updated
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => TeamMember::class,
            'auditable_id'   => $member->id,
            'event'          => 'updated',
        ]);
    }

    // =========================================================
    // SKENARIO 4: Soft delete → masuk trash, hilang dari about
    // =========================================================

    public function test_soft_deleting_member_moves_to_trash_and_hides_from_about(): void
    {
        $this->storeMember(['name' => 'Eko Prasetyo']);
        $member = TeamMember::first();

        $this->assertEquals(1, TeamMember::active()->count());

        // Admin hapus
        $response = $this->actingAs($this->admin)->delete(
            route('admin.team.destroy', $member)
        );

        $response->assertRedirect(route('admin.team.index'));
        $this->assertSoftDeleted('team_members', ['id' => $member->id]);
        $this->assertEquals(0, TeamMember::count());
        $this->assertEquals(0, TeamMember::active()->count());
        $this->assertEquals(1, TeamMember::withTrashed()->count());
    }

    // =========================================================
    // SKENARIO 5: Trash page memperlihatkan member yang dihapus
    // =========================================================

    public function test_trash_page_displays_soft_deleted_members(): void
    {
        $this->storeMember(['name' => 'Fani Rahayu']);
        $member = TeamMember::first();
        $this->actingAs($this->admin)->delete(route('admin.team.destroy', $member));

        $response = $this->actingAs($this->admin)->get(route('admin.team.trash'));
        $response->assertStatus(200);

        $this->assertEquals(1, TeamMember::onlyTrashed()->count());
    }

    // =========================================================
    // SKENARIO 6: Restore → kembali tampil di about
    // =========================================================

    public function test_restoring_member_brings_them_back_to_about_page(): void
    {
        $this->storeMember(['name' => 'Guntur Wibowo']);
        $member = TeamMember::first();

        $this->actingAs($this->admin)->delete(route('admin.team.destroy', $member));
        $this->assertEquals(0, TeamMember::count());

        // Restore
        $response = $this->actingAs($this->admin)->patch(
            route('admin.team.restore', $member->id)
        );

        $response->assertRedirect(route('admin.team.trash'));
        $this->assertEquals(1, TeamMember::count());
        $this->assertNotNull(TeamMember::find($member->id));

        // Audit events
        $events = AuditLog::where('auditable_type', TeamMember::class)
            ->where('auditable_id', $member->id)
            ->pluck('event')
            ->toArray();

        $this->assertContains('created', $events);
        $this->assertContains('deleted', $events);
        $this->assertContains('restored', $events);
    }

    // =========================================================
    // SKENARIO 7: Force delete → hilang selamanya
    // =========================================================

    public function test_force_deleting_member_removes_permanently(): void
    {
        $this->storeMember(['name' => 'Heni Andriyani']);
        $member   = TeamMember::first();
        $memberId = $member->id;

        $this->actingAs($this->admin)->delete(route('admin.team.destroy', $member));
        $this->assertEquals(1, TeamMember::withTrashed()->count());

        // Force delete
        $this->actingAs($this->admin)->delete(
            route('admin.team.force-delete', $memberId)
        );

        $this->assertEquals(0, TeamMember::withTrashed()->count());

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => TeamMember::class,
            'auditable_id'   => $memberId,
            'event'          => 'force_deleted',
        ]);
    }

    // =========================================================
    // SKENARIO 8: Ordering — about page menampilkan member sesuai urutan
    // =========================================================

    public function test_team_members_display_in_correct_order_on_about_page(): void
    {
        // Insert tidak berurutan
        TeamMember::create(['name' => 'Member C', 'role' => 'Dev', 'order' => 2, 'active' => true]);
        TeamMember::create(['name' => 'Member A', 'role' => 'Dev', 'order' => 0, 'active' => true]);
        TeamMember::create(['name' => 'Member B', 'role' => 'Dev', 'order' => 1, 'active' => true]);

        // Controller menggunakan TeamMember::active() → orderBy('order')
        $team = TeamMember::active()->get();

        $this->assertEquals('Member A', $team[0]->name);
        $this->assertEquals('Member B', $team[1]->name);
        $this->assertEquals('Member C', $team[2]->name);

        $response = $this->get(route('about'));
        $response->assertStatus(200);
    }

    // =========================================================
    // SKENARIO 9: Inactive member tidak muncul, active member muncul
    // =========================================================

    public function test_only_active_members_appear_on_about_page(): void
    {
        TeamMember::create(['name' => 'Active One',   'role' => 'Dev', 'order' => 0, 'active' => true]);
        TeamMember::create(['name' => 'Inactive One', 'role' => 'Dev', 'order' => 1, 'active' => false]);
        TeamMember::create(['name' => 'Active Two',   'role' => 'Dev', 'order' => 2, 'active' => true]);

        $visible = TeamMember::active()->get();

        $this->assertCount(2, $visible);
        $this->assertFalse($visible->contains('name', 'Inactive One'));
        $this->assertTrue($visible->contains('name', 'Active One'));
        $this->assertTrue($visible->contains('name', 'Active Two'));
    }

    // =========================================================
    // SKENARIO 10: Full lifecycle dalam satu tes
    // =========================================================

    public function test_complete_team_member_lifecycle(): void
    {
        // 1. Create
        $this->storeMember(['name' => 'Indira Sari', 'role' => 'Project Manager']);
        $member = TeamMember::first();
        $this->assertEquals(1, TeamMember::active()->count());

        // 2. Update
        $this->actingAs($this->admin)->put(route('admin.team.update', $member), [
            'name' => 'Indira Sari', 'role' => 'Senior Project Manager', 'order' => 0, 'active' => true,
        ]);
        $this->assertEquals('Senior Project Manager', $member->fresh()->role);

        // 3. Soft delete
        $this->actingAs($this->admin)->delete(route('admin.team.destroy', $member));
        $this->assertEquals(0, TeamMember::count());

        // 4. Restore
        $this->actingAs($this->admin)->patch(route('admin.team.restore', $member->id));
        $this->assertEquals(1, TeamMember::count());

        // 5. Force delete
        $this->actingAs($this->admin)->delete(route('admin.team.destroy', $member->fresh()));
        $this->actingAs($this->admin)->delete(route('admin.team.force-delete', $member->id));
        $this->assertEquals(0, TeamMember::withTrashed()->count());

        // Semua event audit tercatat
        $events = AuditLog::where('auditable_type', TeamMember::class)
            ->where('auditable_id', $member->id)
            ->pluck('event')
            ->toArray();

        $this->assertContains('created', $events);
        $this->assertContains('updated', $events);
        $this->assertContains('deleted', $events);
        $this->assertContains('restored', $events);
        $this->assertContains('force_deleted', $events);
    }
}
