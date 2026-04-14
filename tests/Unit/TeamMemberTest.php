<?php

namespace Tests\Unit;

use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamMemberTest extends TestCase
{
    use RefreshDatabase;

    private function makeMember(array $override = []): TeamMember
    {
        return TeamMember::create(array_merge([
            'name'   => 'John Doe',
            'role'   => 'Developer',
            'order'  => 0,
            'active' => true,
        ], $override));
    }

    // ---------- Fillable & Casts ----------

    public function test_team_member_has_correct_fillable(): void
    {
        $member = new TeamMember();
        $this->assertContains('name', $member->getFillable());
        $this->assertContains('role', $member->getFillable());
        $this->assertContains('active', $member->getFillable());
    }

    public function test_active_cast_to_boolean(): void
    {
        $member = $this->makeMember(['active' => 1]);
        $this->assertIsBool($member->active);
    }

    // ---------- Scopes ----------

    public function test_active_scope_excludes_inactive_members(): void
    {
        $this->makeMember(['name' => 'Active Member', 'active' => true]);
        $this->makeMember(['name' => 'Inactive Member', 'active' => false]);

        $results = TeamMember::active()->get();

        $this->assertCount(1, $results);
        $this->assertEquals('Active Member', $results->first()->name);
    }

    // ---------- Image URL ----------

    public function test_image_url_returns_ui_avatars_when_no_image(): void
    {
        $member = $this->makeMember();
        $this->assertStringContainsString('ui-avatars.com', $member->image_url);
    }

    public function test_image_url_returns_external_url_as_is(): void
    {
        $member = $this->makeMember(['image' => 'https://example.com/photo.jpg']);
        $this->assertEquals('https://example.com/photo.jpg', $member->image_url);
    }

    // ---------- Soft Delete ----------

    public function test_team_member_can_be_soft_deleted(): void
    {
        $member = $this->makeMember();
        $member->delete();

        $this->assertSoftDeleted('team_members', ['id' => $member->id]);
    }

    public function test_soft_deleted_member_not_in_default_query(): void
    {
        $member = $this->makeMember();
        $member->delete();

        $this->assertCount(0, TeamMember::all());
    }

    public function test_team_member_can_be_restored(): void
    {
        $member = $this->makeMember();
        $member->delete();
        $member->restore();

        $this->assertNotNull(TeamMember::find($member->id));
    }

    // ---------- Audit Log ----------

    public function test_audit_log_on_create(): void
    {
        $this->makeMember();

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => TeamMember::class,
            'event'          => 'created',
        ]);
    }

    public function test_audit_log_on_update(): void
    {
        $member = $this->makeMember();
        $member->update(['role' => 'Senior Developer']);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => TeamMember::class,
            'auditable_id'   => $member->id,
            'event'          => 'updated',
        ]);
    }

    public function test_audit_log_on_delete(): void
    {
        $member = $this->makeMember();
        $member->delete();

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => TeamMember::class,
            'auditable_id'   => $member->id,
            'event'          => 'deleted',
        ]);
    }

    public function test_audit_log_on_restore(): void
    {
        $member = $this->makeMember();
        $member->delete();
        $member->restore();

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => TeamMember::class,
            'auditable_id'   => $member->id,
            'event'          => 'restored',
        ]);
    }
}
