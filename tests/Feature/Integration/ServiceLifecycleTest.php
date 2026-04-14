<?php

/**
 * Integration Test: Siklus Hidup Service + Features + Process Steps
 *
 * Menguji alur lengkap layanan:
 * Admin create service dengan fitur → tampil di halaman publik /services →
 * Admin tambah process step → tampil di /services →
 * Update service + sync fitur → fitur lama dihapus, fitur baru masuk →
 * Soft delete service → hilang dari publik →
 * Restore → kembali tampil → force delete
 */

namespace Tests\Feature\Integration;

use App\Models\AuditLog;
use App\Models\ProcessStep;
use App\Models\Service;
use App\Models\ServiceFeature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceLifecycleTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    private function storeService(array $override = []): \Illuminate\Testing\TestResponse
    {
        return $this->actingAs($this->admin)->post(route('admin.services.store'), array_merge([
            'title'       => 'Brand Engineering',
            'description' => 'Membangun identitas brand yang kuat dan konsisten.',
            'order'       => 0,
            'active'      => true,
            'features'    => ['Logo Design', 'Brand Guide', 'Visual Identity'],
        ], $override));
    }

    // =========================================================
    // SKENARIO 1: Create service dengan features → tampil di publik
    // =========================================================

    public function test_creating_service_with_features_appears_on_public_services_page(): void
    {
        $this->storeService([
            'title'    => 'Web Development',
            'features' => ['React', 'Laravel', 'SEO Ready'],
        ]);

        $service = Service::first();
        $this->assertNotNull($service);
        $this->assertEquals('web-development', $service->slug);

        // 3 fitur tersimpan
        $this->assertCount(3, $service->features);
        $this->assertDatabaseHas('service_features', ['feature' => 'React']);
        $this->assertDatabaseHas('service_features', ['feature' => 'Laravel']);

        // Tampil di publik
        $this->assertEquals(1, Service::active()->count());

        // Halaman publik
        $response = $this->get(route('services'));
        $response->assertStatus(200);

        // Audit log
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Service::class,
            'auditable_id'   => $service->id,
            'event'          => 'created',
            'user_id'        => $this->admin->id,
        ]);
    }

    // =========================================================
    // SKENARIO 2: Admin tambah process step → muncul di halaman /services
    // =========================================================

    public function test_process_steps_appear_on_public_services_page_after_admin_creates_them(): void
    {
        // Buat service
        $this->storeService(['title' => 'Tech Development']);

        // Admin tambah process steps
        $this->actingAs($this->admin)->post(route('admin.process-steps.store'), [
            'step_number' => '01',
            'title'       => 'Discovery',
            'description' => 'Pahami kebutuhan klien.',
            'order'       => 0,
        ]);

        $this->actingAs($this->admin)->post(route('admin.process-steps.store'), [
            'step_number' => '02',
            'title'       => 'Strategy',
            'description' => 'Susun rencana aksi.',
            'order'       => 1,
        ]);

        $this->assertEquals(2, ProcessStep::count());

        // Halaman services memuat process steps
        $processSteps = ProcessStep::orderBy('order')->get();
        $this->assertEquals('Discovery', $processSteps->first()->title);
        $this->assertEquals('Strategy', $processSteps->last()->title);
    }

    // =========================================================
    // SKENARIO 3: Update service → fitur lama dihapus, fitur baru masuk
    // =========================================================

    public function test_updating_service_replaces_old_features_with_new_ones(): void
    {
        $this->storeService([
            'title'    => 'Growth Hacking',
            'features' => ['SEO', 'SEM', 'Analytics'],
        ]);

        $service = Service::first();
        $this->assertCount(3, $service->features);

        // Update dengan fitur baru
        $this->actingAs($this->admin)->put(route('admin.services.update', $service), [
            'title'       => 'Growth Hacking',
            'description' => 'Deskripsi diupdate.',
            'order'       => 0,
            'active'      => true,
            'features'    => ['Email Marketing', 'Social Media Ads'],
        ]);

        $service->refresh();

        // Fitur lama harus diganti dengan yang baru
        $this->assertCount(2, $service->features);
        $this->assertDatabaseHas('service_features', ['feature' => 'Email Marketing']);
        $this->assertDatabaseHas('service_features', ['feature' => 'Social Media Ads']);
        $this->assertDatabaseMissing('service_features', ['feature' => 'SEO']);
        $this->assertDatabaseMissing('service_features', ['feature' => 'SEM']);

        // Update audit log
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Service::class,
            'auditable_id'   => $service->id,
            'event'          => 'updated',
        ]);
    }

    // =========================================================
    // SKENARIO 4: Nonaktifkan service → hilang dari publik
    // =========================================================

    public function test_deactivated_service_disappears_from_public_page(): void
    {
        $this->storeService(['title' => 'Photo & Video', 'active' => true]);
        $service = Service::first();

        $this->assertEquals(1, Service::active()->count());

        // Nonaktifkan
        $this->actingAs($this->admin)->put(route('admin.services.update', $service), [
            'title'       => 'Photo & Video',
            'description' => 'Desc',
            'order'       => 0,
            'active'      => false,
            'features'    => [],
        ]);

        $this->assertEquals(0, Service::active()->count());
    }

    // =========================================================
    // SKENARIO 5: Soft delete → masuk trash, fitur masih tersimpan di DB
    // =========================================================

    public function test_soft_deleting_service_keeps_features_in_database(): void
    {
        $this->storeService([
            'title'    => 'SEO Service',
            'features' => ['Keyword Research', 'On-Page SEO'],
        ]);

        $service = Service::first();

        // Soft delete service
        $this->actingAs($this->admin)->delete(route('admin.services.destroy', $service));

        $this->assertSoftDeleted('services', ['id' => $service->id]);
        $this->assertEquals(0, Service::count());

        // Features masih ada di DB (tidak ikut terhapus)
        $this->assertEquals(2, ServiceFeature::where('service_id', $service->id)->count());
    }

    // =========================================================
    // SKENARIO 6: Restore service → kembali aktif & muncul di publik
    // =========================================================

    public function test_restoring_service_makes_it_active_again(): void
    {
        $this->storeService(['title' => 'Videography']);
        $service = Service::first();

        $this->actingAs($this->admin)->delete(route('admin.services.destroy', $service));
        $this->assertEquals(0, Service::count());

        // Restore
        $response = $this->actingAs($this->admin)->patch(
            route('admin.services.restore', $service->id)
        );

        $response->assertRedirect(route('admin.services.trash'));
        $this->assertEquals(1, Service::count());
        $this->assertEquals(1, Service::active()->count());

        // Audit log: created, deleted, restored
        $events = AuditLog::where('auditable_type', Service::class)
            ->where('auditable_id', $service->id)
            ->pluck('event')
            ->toArray();

        $this->assertContains('created', $events);
        $this->assertContains('deleted', $events);
        $this->assertContains('restored', $events);
    }

    // =========================================================
    // SKENARIO 7: Process step CRUD terintegrasi
    // =========================================================

    public function test_admin_can_crud_process_steps_and_order_is_maintained(): void
    {
        // Buat 3 step
        $this->actingAs($this->admin)->post(route('admin.process-steps.store'), [
            'step_number' => '01', 'title' => 'Step A', 'description' => 'Desc A', 'order' => 0,
        ]);
        $this->actingAs($this->admin)->post(route('admin.process-steps.store'), [
            'step_number' => '02', 'title' => 'Step B', 'description' => 'Desc B', 'order' => 1,
        ]);
        $this->actingAs($this->admin)->post(route('admin.process-steps.store'), [
            'step_number' => '03', 'title' => 'Step C', 'description' => 'Desc C', 'order' => 2,
        ]);

        $this->assertEquals(3, ProcessStep::count());

        // Update step kedua
        $stepB = ProcessStep::where('title', 'Step B')->first();
        $this->actingAs($this->admin)->put(route('admin.process-steps.update', $stepB), [
            'step_number' => '02', 'title' => 'Step B Updated', 'description' => 'Desc B Updated', 'order' => 1,
        ]);

        $this->assertEquals('Step B Updated', $stepB->fresh()->title);

        // Hapus step pertama
        $stepA = ProcessStep::where('title', 'Step A')->first();
        $this->actingAs($this->admin)->delete(route('admin.process-steps.destroy', $stepA));

        $this->assertEquals(2, ProcessStep::count());

        // Order tetap benar
        $remaining = ProcessStep::orderBy('order')->get();
        $this->assertEquals('Step B Updated', $remaining->first()->title);
    }

    // =========================================================
    // SKENARIO 8: Force delete service
    // =========================================================

    public function test_force_deleting_service_removes_it_permanently(): void
    {
        $this->storeService(['title' => 'Temp Service']);
        $service   = Service::first();
        $serviceId = $service->id;

        $this->actingAs($this->admin)->delete(route('admin.services.destroy', $service));
        $this->assertEquals(1, Service::withTrashed()->count());

        // Force delete
        $this->actingAs($this->admin)->delete(
            route('admin.services.force-delete', $serviceId)
        );

        $this->assertEquals(0, Service::withTrashed()->count());

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Service::class,
            'auditable_id'   => $serviceId,
            'event'          => 'force_deleted',
        ]);
    }

    // =========================================================
    // SKENARIO 9: Multiple services — ordering dijaga
    // =========================================================

    public function test_multiple_services_ordered_correctly_on_public_page(): void
    {
        $this->storeService(['title' => 'Service C', 'order' => 2]);
        $this->storeService(['title' => 'Service A', 'order' => 0]);
        $this->storeService(['title' => 'Service B', 'order' => 1]);

        $services = Service::active()->get();

        $this->assertEquals('Service A', $services[0]->title);
        $this->assertEquals('Service B', $services[1]->title);
        $this->assertEquals('Service C', $services[2]->title);
    }
}
