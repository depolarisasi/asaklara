<?php

/**
 * Integration Test: Alur Form Kontak — End-to-End
 *
 * Menguji keseluruhan siklus kontak:
 * Visitor submit form → tersimpan di DB → audit log tercatat →
 * Admin melihat inbox → submission ditandai terbaca →
 * Admin menghapus → hilang dari inbox
 */

namespace Tests\Feature\Integration;

use App\Models\AuditLog;
use App\Models\ContactSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormFlowTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    // =========================================================
    // SKENARIO 1: Visitor mengisi form → tersimpan lengkap di DB
    // =========================================================

    public function test_visitor_submits_contact_form_and_data_persisted_correctly(): void
    {
        $payload = [
            'name'    => 'Rina Marlina',
            'email'   => 'rina@example.com',
            'subject' => 'Inquiry Pembuatan Website',
            'message' => 'Halo, saya ingin tahu lebih lanjut soal pembuatan landing page.',
        ];

        $response = $this->post(route('contact.submit'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'name'    => 'Rina Marlina',
            'email'   => 'rina@example.com',
            'subject' => 'Inquiry Pembuatan Website',
        ]);

        $submission = ContactSubmission::first();
        $this->assertFalse($submission->is_read); // default unread
    }

    // =========================================================
    // SKENARIO 2: Submit form → audit log otomatis tercatat
    // =========================================================

    public function test_contact_submission_creates_audit_log_automatically(): void
    {
        $this->post(route('contact.submit'), [
            'name'    => 'Dodi Purnama',
            'email'   => 'dodi@example.com',
            'subject' => 'Penawaran Kolaborasi',
            'message' => 'Tertarik untuk berkolaborasi.',
        ]);

        $submission = ContactSubmission::first();

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => ContactSubmission::class,
            'auditable_id'   => $submission->id,
            'event'          => 'created',
            'user_id'        => null, // unauthenticated visitor
        ]);
    }

    // =========================================================
    // SKENARIO 3: Submission muncul di admin inbox setelah submit
    // =========================================================

    public function test_new_submission_appears_in_admin_inbox(): void
    {
        // Visitor submit
        $this->post(route('contact.submit'), [
            'name'    => 'Fajar Nugroho',
            'email'   => 'fajar@example.com',
            'subject' => 'Tanya Harga',
            'message' => 'Berapa harga paket website company profile?',
        ]);

        // Admin membuka halaman submissions
        $response = $this->actingAs($this->admin)->get(route('admin.submissions.index'));

        $response->assertStatus(200);
        $this->assertEquals(1, ContactSubmission::count());
        $this->assertEquals(1, ContactSubmission::unread()->count());
    }

    // =========================================================
    // SKENARIO 4: Admin membuka detail → otomatis ditandai terbaca
    // =========================================================

    public function test_admin_viewing_submission_marks_it_as_read(): void
    {
        // Visitor submit
        $this->post(route('contact.submit'), [
            'name'    => 'Gita Lestari',
            'email'   => 'gita@example.com',
            'subject' => 'Portfolio Review',
            'message' => 'Bisa saya lihat portfolio terbaru Anda?',
        ]);

        $submission = ContactSubmission::first();
        $this->assertFalse($submission->is_read);

        // Admin buka detail
        $this->actingAs($this->admin)->get(route('admin.submissions.show', $submission));

        // Submission seharusnya sudah terbaca
        $this->assertTrue($submission->fresh()->is_read);
        $this->assertEquals(0, ContactSubmission::unread()->count());
    }

    // =========================================================
    // SKENARIO 5: Admin tandai terbaca via PATCH endpoint
    // =========================================================

    public function test_admin_can_manually_mark_submission_read(): void
    {
        $submission = ContactSubmission::create([
            'name'    => 'Hendra Kusuma',
            'email'   => 'hendra@example.com',
            'subject' => 'Kerja Sama',
            'message' => 'Ingin diskusi lebih lanjut.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->patch(
            route('admin.submissions.read', $submission)
        );

        $response->assertRedirect();
        $this->assertTrue($submission->fresh()->is_read);

        // Audit log tercatat untuk update
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => ContactSubmission::class,
            'auditable_id'   => $submission->id,
            'event'          => 'updated',
            'user_id'        => $this->admin->id,
        ]);
    }

    // =========================================================
    // SKENARIO 6: Admin menghapus submission → hilang dari inbox
    // =========================================================

    public function test_admin_deletes_submission_and_it_disappears_from_inbox(): void
    {
        $this->post(route('contact.submit'), [
            'name'    => 'Irma Suryani',
            'email'   => 'irma@example.com',
            'subject' => 'Complaint',
            'message' => 'Ada masalah dengan website kami.',
        ]);

        $submission = ContactSubmission::first();

        // Admin hapus
        $response = $this->actingAs($this->admin)->delete(
            route('admin.submissions.destroy', $submission)
        );

        $response->assertRedirect(route('admin.submissions.index'));
        $this->assertSoftDeleted('contact_submissions', ['id' => $submission->id]);
        $this->assertEquals(0, ContactSubmission::count()); // tidak muncul di inbox
        $this->assertEquals(1, ContactSubmission::withTrashed()->count()); // masih ada di DB

        // Audit log delete tercatat
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => ContactSubmission::class,
            'auditable_id'   => $submission->id,
            'event'          => 'deleted',
            'user_id'        => $this->admin->id,
        ]);
    }

    // =========================================================
    // SKENARIO 7: Multiple submissions — unread count akurat
    // =========================================================

    public function test_unread_count_is_accurate_after_multiple_submissions_and_reads(): void
    {
        // 3 submission masuk
        foreach (['a@x.com', 'b@x.com', 'c@x.com'] as $email) {
            ContactSubmission::create([
                'name' => 'User', 'email' => $email,
                'subject' => 'S', 'message' => 'M', 'is_read' => false,
            ]);
        }

        $this->assertEquals(3, ContactSubmission::unread()->count());

        // Admin baca 2 dari 3
        $submissions = ContactSubmission::take(2)->get();
        foreach ($submissions as $sub) {
            $this->actingAs($this->admin)->patch(route('admin.submissions.read', $sub));
        }

        $this->assertEquals(1, ContactSubmission::unread()->count());
    }

    // =========================================================
    // SKENARIO 8: Validasi form — submission tidak tersimpan jika invalid
    // =========================================================

    public function test_invalid_form_does_not_create_submission_or_audit_log(): void
    {
        // Email tidak valid
        $this->post(route('contact.submit'), [
            'name'    => 'Test User',
            'email'   => 'bukan-email',
            'subject' => 'Test',
            'message' => 'Pesan test.',
        ]);

        $this->assertEquals(0, ContactSubmission::count());
        $this->assertEquals(0, AuditLog::count());
    }

    // =========================================================
    // SKENARIO 9: Full cycle — submit, view, read, delete
    // =========================================================

    public function test_full_contact_submission_lifecycle(): void
    {
        // 1. Visitor submit
        $this->post(route('contact.submit'), [
            'name'    => 'Joko Widodo',
            'email'   => 'joko@example.com',
            'subject' => 'Partnership',
            'message' => 'Mari berkolaborasi untuk proyek pemerintah.',
        ]);

        $submission = ContactSubmission::first();
        $this->assertNotNull($submission);
        $this->assertFalse($submission->is_read);
        $this->assertEquals(1, AuditLog::where('event', 'created')->count());

        // 2. Admin buka detail (auto-read)
        $this->actingAs($this->admin)->get(route('admin.submissions.show', $submission));
        $this->assertTrue($submission->fresh()->is_read);

        // 3. Admin hapus
        $this->actingAs($this->admin)->delete(route('admin.submissions.destroy', $submission));
        $this->assertEquals(0, ContactSubmission::count());
        $this->assertSoftDeleted('contact_submissions', ['id' => $submission->id]);

        // 4. Total audit log: created + updated (mark read) + deleted
        $logs = AuditLog::where('auditable_type', ContactSubmission::class)
            ->where('auditable_id', $submission->id)
            ->pluck('event')
            ->toArray();

        $this->assertContains('created', $logs);
        $this->assertContains('updated', $logs);
        $this->assertContains('deleted', $logs);
    }
}
