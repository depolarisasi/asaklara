<?php

namespace Tests\Unit;

use App\Models\AuditLog;
use App\Models\Portfolio;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    // ---------- Struktur ----------

    public function test_audit_log_has_correct_fillable(): void
    {
        $log = new AuditLog();
        $this->assertContains('auditable_type', $log->getFillable());
        $this->assertContains('auditable_id', $log->getFillable());
        $this->assertContains('event', $log->getFillable());
        $this->assertContains('old_values', $log->getFillable());
        $this->assertContains('new_values', $log->getFillable());
    }

    public function test_audit_log_casts_values_to_array(): void
    {
        $log = AuditLog::create([
            'auditable_type' => Portfolio::class,
            'auditable_id'   => 1,
            'event'          => 'created',
            'old_values'     => null,
            'new_values'     => ['title' => 'Test'],
        ]);

        $this->assertIsArray($log->new_values);
        $this->assertEquals('Test', $log->new_values['title']);
    }

    // ---------- Scope ----------

    public function test_for_model_scope_filters_by_type_and_id(): void
    {
        $portfolio1 = Portfolio::create(['title' => 'P1', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $portfolio2 = Portfolio::create(['title' => 'P2', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);

        $logs = AuditLog::forModel(Portfolio::class, $portfolio1->id)->get();

        // Semua log harus milik portfolio1
        $this->assertTrue($logs->every(fn ($l) => $l->auditable_id === $portfolio1->id));
        $this->assertFalse($logs->contains('auditable_id', $portfolio2->id));
    }

    // ---------- Multiple events terekam ----------

    public function test_multiple_events_are_recorded_for_one_model(): void
    {
        $portfolio = Portfolio::create(['title' => 'Multi Event', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $portfolio->update(['title' => 'Updated']);
        $portfolio->delete();

        $logs = AuditLog::forModel(Portfolio::class, $portfolio->id)->get();
        $events = $logs->pluck('event')->toArray();

        $this->assertContains('created', $events);
        $this->assertContains('updated', $events);
        $this->assertContains('deleted', $events);
    }

    // ---------- Old/New values ----------

    public function test_audit_log_stores_old_and_new_values_on_update(): void
    {
        $portfolio = Portfolio::create(['title' => 'Original', 'description' => 'D', 'client' => 'C', 'year' => '2024', 'category' => 'Web']);
        $portfolio->update(['title' => 'Changed']);

        $updateLog = AuditLog::where('auditable_type', Portfolio::class)
            ->where('auditable_id', $portfolio->id)
            ->where('event', 'updated')
            ->first();

        $this->assertNotNull($updateLog);
        $this->assertEquals('Original', $updateLog->old_values['title']);
        $this->assertEquals('Changed', $updateLog->new_values['title']);
    }

    // ---------- User tracking ----------

    public function test_audit_log_records_authenticated_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $member = TeamMember::create(['name' => 'Audit User', 'role' => 'Dev', 'order' => 0]);

        $log = AuditLog::where('auditable_type', TeamMember::class)
            ->where('event', 'created')
            ->first();

        $this->assertEquals($user->id, $log->user_id);
        $this->assertEquals(User::class, $log->user_type);
    }

    public function test_audit_log_null_user_when_unauthenticated(): void
    {
        $member = TeamMember::create(['name' => 'No Auth', 'role' => 'Dev', 'order' => 0]);

        $log = AuditLog::where('auditable_type', TeamMember::class)
            ->where('event', 'created')
            ->first();

        $this->assertNull($log->user_id);
    }
}
