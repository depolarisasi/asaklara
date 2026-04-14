<?php

namespace Tests\Feature;

use App\Models\ContactSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    // ---------- Submit Form Kontak ----------

    public function test_contact_form_can_be_submitted_successfully(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name'    => 'Dedi Wahyudi',
            'email'   => 'dedi@example.com',
            'subject' => 'Inquiry Harga',
            'message' => 'Saya ingin mengetahui harga pembuatan website.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_submissions', [
            'email'   => 'dedi@example.com',
            'subject' => 'Inquiry Harga',
        ]);
    }

    public function test_contact_form_requires_name(): void
    {
        $response = $this->post(route('contact.submit'), [
            'email'   => 'test@example.com',
            'subject' => 'Test',
            'message' => 'Pesan test',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_contact_form_requires_valid_email(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name'    => 'Test User',
            'email'   => 'bukan-email',
            'subject' => 'Test',
            'message' => 'Pesan test',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_contact_form_requires_message(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name'    => 'Test User',
            'email'   => 'test@example.com',
            'subject' => 'Test',
        ]);

        $response->assertSessionHasErrors('message');
    }

    public function test_new_submission_is_marked_unread_by_default(): void
    {
        $this->post(route('contact.submit'), [
            'name'    => 'User Baru',
            'email'   => 'user@example.com',
            'subject' => 'Halo',
            'message' => 'Ini pesan percobaan.',
        ]);

        $submission = ContactSubmission::first();
        $this->assertNotNull($submission);
        $this->assertFalse($submission->is_read);
    }

    public function test_submission_audit_log_created(): void
    {
        $this->post(route('contact.submit'), [
            'name'    => 'Audit User',
            'email'   => 'audit@example.com',
            'subject' => 'Audit Test',
            'message' => 'Testing audit log pada form kontak.',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => ContactSubmission::class,
            'event'          => 'created',
        ]);
    }
}
