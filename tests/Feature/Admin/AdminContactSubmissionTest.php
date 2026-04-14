<?php

namespace Tests\Feature\Admin;

use App\Models\ContactSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContactSubmissionTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    private function makeSubmission(array $override = []): ContactSubmission
    {
        return ContactSubmission::create(array_merge([
            'name'       => 'Citra Dewi',
            'email'      => 'citra@example.com',
            'subject'    => 'Pertanyaan layanan',
            'message'    => 'Saya ingin bertanya tentang harga.',
            'is_read'    => false,
            'ip_address' => '192.168.1.1',
        ], $override));
    }

    // ---------- Index ----------

    public function test_admin_can_view_submissions_index(): void
    {
        $this->makeSubmission();

        $response = $this->actingAs($this->admin)->get(route('admin.submissions.index'));

        $response->assertStatus(200);
    }

    public function test_guest_redirected_from_submissions(): void
    {
        $response = $this->get(route('admin.submissions.index'));
        $response->assertRedirect(route('login'));
    }

    // ---------- Show (mark as read) ----------

    public function test_admin_can_view_submission_detail(): void
    {
        $submission = $this->makeSubmission();

        $response = $this->actingAs($this->admin)->get(route('admin.submissions.show', $submission));

        $response->assertStatus(200);
    }

    public function test_viewing_submission_marks_it_as_read(): void
    {
        $submission = $this->makeSubmission(['is_read' => false]);

        $this->actingAs($this->admin)->get(route('admin.submissions.show', $submission));

        $this->assertTrue($submission->fresh()->is_read);
    }

    // ---------- Mark Read ----------

    public function test_admin_can_mark_submission_as_read(): void
    {
        $submission = $this->makeSubmission(['is_read' => false]);

        $response = $this->actingAs($this->admin)->patch(route('admin.submissions.read', $submission));

        $response->assertRedirect();
        $this->assertTrue($submission->fresh()->is_read);
    }

    // ---------- Destroy (Soft Delete) ----------

    public function test_admin_can_soft_delete_submission(): void
    {
        $submission = $this->makeSubmission();

        $response = $this->actingAs($this->admin)->delete(route('admin.submissions.destroy', $submission));

        $response->assertRedirect(route('admin.submissions.index'));
        $this->assertSoftDeleted('contact_submissions', ['id' => $submission->id]);
        $this->assertNull(ContactSubmission::find($submission->id));
    }

    public function test_soft_deleted_submission_not_in_default_query(): void
    {
        $submission = $this->makeSubmission();
        $submission->delete();

        $this->assertEquals(0, ContactSubmission::count());
        $this->assertEquals(1, ContactSubmission::withTrashed()->count());
    }

    // ---------- Audit ----------

    public function test_audit_log_on_submission_delete(): void
    {
        $submission = $this->makeSubmission();

        $this->actingAs($this->admin)->delete(route('admin.submissions.destroy', $submission));

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => ContactSubmission::class,
            'auditable_id'   => $submission->id,
            'event'          => 'deleted',
            'user_id'        => $this->admin->id,
        ]);
    }
}
