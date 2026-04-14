<?php

namespace Tests\Feature\Admin;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    private function makeService(array $override = []): Service
    {
        return Service::create(array_merge([
            'title'       => 'Web Development',
            'description' => 'Layanan pembuatan website',
            'order'       => 0,
            'active'      => true,
        ], $override));
    }

    // ---------- Index ----------

    public function test_admin_can_view_services_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.services.index'));
        $response->assertStatus(200);
    }

    public function test_guest_redirected_from_services_index(): void
    {
        $response = $this->get(route('admin.services.index'));
        $response->assertRedirect(route('login'));
    }

    // ---------- Store ----------

    public function test_admin_can_store_service(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title'       => 'Brand Engineering',
            'description' => 'Membangun identitas brand',
            'order'       => 1,
            'active'      => true,
            'features'    => ['Logo Design', 'Brand Guide'],
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['title' => 'Brand Engineering']);
        $this->assertDatabaseHas('service_features', ['feature' => 'Logo Design']);
    }

    public function test_store_service_requires_title_and_description(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'order'  => 0,
            'active' => true,
        ]);

        $response->assertSessionHasErrors(['title', 'description']);
    }

    // ---------- Update ----------

    public function test_admin_can_update_service(): void
    {
        $service = $this->makeService();

        $response = $this->actingAs($this->admin)->put(route('admin.services.update', $service), [
            'title'       => 'Updated Service',
            'description' => 'Deskripsi diupdate',
            'order'       => 0,
            'active'      => true,
            'features'    => ['New Feature'],
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['title' => 'Updated Service']);
    }

    // ---------- Destroy (Soft Delete) ----------

    public function test_admin_can_soft_delete_service(): void
    {
        $service = $this->makeService();

        $response = $this->actingAs($this->admin)->delete(route('admin.services.destroy', $service));

        $response->assertRedirect(route('admin.services.index'));
        $this->assertSoftDeleted('services', ['id' => $service->id]);
    }

    // ---------- Audit ----------

    public function test_audit_log_on_service_create(): void
    {
        $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title'       => 'Audit Service',
            'description' => 'Desc',
            'order'       => 0,
            'active'      => true,
            'features'    => [],
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Service::class,
            'event'          => 'created',
            'user_id'        => $this->admin->id,
        ]);
    }

    public function test_audit_log_on_service_delete(): void
    {
        $service = $this->makeService();

        $this->actingAs($this->admin)->delete(route('admin.services.destroy', $service));

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Service::class,
            'auditable_id'   => $service->id,
            'event'          => 'deleted',
        ]);
    }
}
