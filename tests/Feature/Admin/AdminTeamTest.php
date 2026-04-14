<?php

namespace Tests\Feature\Admin;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTeamTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    private function makeMember(array $override = []): TeamMember
    {
        return TeamMember::create(array_merge([
            'name'   => 'Andi Pratama',
            'role'   => 'Frontend Developer',
            'order'  => 0,
            'active' => true,
        ], $override));
    }

    // ---------- Index ----------

    public function test_admin_can_view_team_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.team.index'));
        $response->assertStatus(200);
    }

    public function test_guest_redirected_from_team_index(): void
    {
        $response = $this->get(route('admin.team.index'));
        $response->assertRedirect(route('login'));
    }

    // ---------- Store ----------

    public function test_admin_can_store_team_member(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.team.store'), [
            'name'   => 'Budi Setiawan',
            'role'   => 'UI/UX Designer',
            'order'  => 1,
            'active' => true,
        ]);

        $response->assertRedirect(route('admin.team.index'));
        $this->assertDatabaseHas('team_members', ['name' => 'Budi Setiawan']);
    }

    public function test_store_team_member_requires_name_and_role(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.team.store'), [
            'order'  => 0,
            'active' => true,
        ]);

        $response->assertSessionHasErrors(['name', 'role']);
    }

    // ---------- Update ----------

    public function test_admin_can_update_team_member(): void
    {
        $member = $this->makeMember();

        $response = $this->actingAs($this->admin)->put(route('admin.team.update', $member), [
            'name'   => 'Andi Updated',
            'role'   => 'Senior Developer',
            'order'  => 0,
            'active' => true,
        ]);

        $response->assertRedirect(route('admin.team.index'));
        $this->assertDatabaseHas('team_members', ['name' => 'Andi Updated']);
    }

    // ---------- Destroy (Soft Delete) ----------

    public function test_admin_can_soft_delete_team_member(): void
    {
        $member = $this->makeMember();

        $response = $this->actingAs($this->admin)->delete(route('admin.team.destroy', $member));

        $response->assertRedirect(route('admin.team.index'));
        $this->assertSoftDeleted('team_members', ['id' => $member->id]);
    }

    public function test_soft_deleted_member_not_visible(): void
    {
        $member = $this->makeMember();
        $member->delete();

        $this->assertEquals(0, TeamMember::count());
        $this->assertEquals(1, TeamMember::withTrashed()->count());
    }

    // ---------- Audit ----------

    public function test_audit_log_recorded_on_team_create(): void
    {
        $this->actingAs($this->admin)->post(route('admin.team.store'), [
            'name'   => 'Audit Member',
            'role'   => 'Tester',
            'order'  => 0,
            'active' => true,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => TeamMember::class,
            'event'          => 'created',
            'user_id'        => $this->admin->id,
        ]);
    }
}
