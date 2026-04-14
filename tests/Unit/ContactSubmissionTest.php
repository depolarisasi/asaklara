<?php

namespace Tests\Unit;

use App\Models\ContactSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactSubmissionTest extends TestCase
{
    use RefreshDatabase;

    private function makeSubmission(array $override = []): ContactSubmission
    {
        return ContactSubmission::create(array_merge([
            'name'       => 'Budi Santoso',
            'email'      => 'budi@example.com',
            'subject'    => 'Inquiry',
            'message'    => 'Halo, saya ingin bertanya tentang layanan.',
            'is_read'    => false,
            'ip_address' => '127.0.0.1',
        ], $override));
    }

    // ---------- Fillable & Casts ----------

    public function test_contact_submission_has_correct_fillable(): void
    {
        $submission = new ContactSubmission();
        $this->assertContains('name', $submission->getFillable());
        $this->assertContains('email', $submission->getFillable());
        $this->assertContains('message', $submission->getFillable());
        $this->assertContains('is_read', $submission->getFillable());
    }

    public function test_is_read_cast_to_boolean(): void
    {
        $submission = $this->makeSubmission(['is_read' => 0]);
        $this->assertIsBool($submission->is_read);
        $this->assertFalse($submission->is_read);
    }

    // ---------- Scopes ----------

    public function test_unread_scope_returns_only_unread(): void
    {
        $this->makeSubmission(['is_read' => false]);
        $this->makeSubmission(['email' => 'read@example.com', 'is_read' => true]);

        $results = ContactSubmission::unread()->get();
        $this->assertCount(1, $results);
        $this->assertFalse($results->first()->is_read);
    }

    public function test_unread_scope_returns_empty_when_all_read(): void
    {
        $this->makeSubmission(['is_read' => true]);

        $this->assertCount(0, ContactSubmission::unread()->get());
    }

    // ---------- Soft Delete ----------

    public function test_contact_submission_can_be_soft_deleted(): void
    {
        $submission = $this->makeSubmission();
        $submission->delete();

        $this->assertSoftDeleted('contact_submissions', ['id' => $submission->id]);
        $this->assertNull(ContactSubmission::find($submission->id));
    }

    public function test_soft_deleted_submission_accessible_with_trashed(): void
    {
        $submission = $this->makeSubmission();
        $submission->delete();

        $this->assertNotNull(ContactSubmission::withTrashed()->find($submission->id));
    }

    public function test_contact_submission_can_be_restored(): void
    {
        $submission = $this->makeSubmission();
        $submission->delete();
        $submission->restore();

        $this->assertNotNull(ContactSubmission::find($submission->id));
    }

    // ---------- Audit Log ----------

    public function test_audit_log_on_create(): void
    {
        $this->makeSubmission();

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => ContactSubmission::class,
            'event'          => 'created',
        ]);
    }

    public function test_audit_log_on_update(): void
    {
        $submission = $this->makeSubmission();
        $submission->update(['is_read' => true]);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => ContactSubmission::class,
            'auditable_id'   => $submission->id,
            'event'          => 'updated',
        ]);
    }

    public function test_audit_log_on_delete(): void
    {
        $submission = $this->makeSubmission();
        $submission->delete();

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => ContactSubmission::class,
            'auditable_id'   => $submission->id,
            'event'          => 'deleted',
        ]);
    }
}
