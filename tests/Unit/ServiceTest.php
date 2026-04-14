<?php

namespace Tests\Unit;

use App\Models\AuditLog;
use App\Models\Service;
use App\Models\ServiceFeature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    private function makeService(array $override = []): Service
    {
        return Service::create(array_merge([
            'title'       => 'Web Development',
            'description' => 'Layanan pembuatan website',
            'order'       => 0,
            'active'      => true,
        ], $override));
    }

    // ---------- Fillable & Casts ----------

    public function test_service_has_correct_fillable_fields(): void
    {
        $service = new Service();
        $this->assertContains('title', $service->getFillable());
        $this->assertContains('description', $service->getFillable());
        $this->assertContains('active', $service->getFillable());
    }

    public function test_service_casts_active_to_boolean(): void
    {
        $service = $this->makeService(['active' => 1]);
        $this->assertIsBool($service->active);
        $this->assertTrue($service->active);
    }

    // ---------- Slug ----------

    public function test_service_auto_generates_slug(): void
    {
        $service = $this->makeService(['title' => 'Brand Engineering']);
        $this->assertEquals('brand-engineering', $service->slug);
    }

    // ---------- Relationship ----------

    public function test_service_has_many_features(): void
    {
        $service = $this->makeService();
        ServiceFeature::create(['service_id' => $service->id, 'feature' => 'Fitur A', 'order' => 0]);
        ServiceFeature::create(['service_id' => $service->id, 'feature' => 'Fitur B', 'order' => 1]);

        $this->assertCount(2, $service->features);
        $this->assertInstanceOf(ServiceFeature::class, $service->features->first());
    }

    // ---------- Scopes ----------

    public function test_active_scope_filters_inactive_services(): void
    {
        $this->makeService(['title' => 'Active Service', 'active' => true]);
        $this->makeService(['title' => 'Inactive Service', 'active' => false]);

        $results = Service::active()->get();
        $this->assertCount(1, $results);
        $this->assertEquals('Active Service', $results->first()->title);
    }

    // ---------- Image URL ----------

    public function test_image_url_falls_back_to_picsum(): void
    {
        $service = $this->makeService();
        $this->assertStringContainsString('picsum.photos', $service->image_url);
    }

    public function test_image_url_returns_external_url_unchanged(): void
    {
        $service = $this->makeService(['image' => 'https://cdn.example.com/img.png']);
        $this->assertEquals('https://cdn.example.com/img.png', $service->image_url);
    }

    // ---------- Soft Delete ----------

    public function test_service_can_be_soft_deleted(): void
    {
        $service = $this->makeService();
        $service->delete();

        $this->assertSoftDeleted('services', ['id' => $service->id]);
        $this->assertNull(Service::find($service->id));
    }

    public function test_service_can_be_restored(): void
    {
        $service = $this->makeService();
        $service->delete();
        $service->restore();

        $this->assertNotNull(Service::find($service->id));
    }

    // ---------- Audit Log ----------

    public function test_audit_log_fires_on_create(): void
    {
        $this->makeService();

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Service::class,
            'event'          => 'created',
        ]);
    }

    public function test_audit_log_fires_on_update(): void
    {
        $service = $this->makeService();
        $service->update(['title' => 'Updated Title']);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Service::class,
            'auditable_id'   => $service->id,
            'event'          => 'updated',
        ]);
    }

    public function test_audit_log_fires_on_delete(): void
    {
        $service = $this->makeService();
        $service->delete();

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Service::class,
            'auditable_id'   => $service->id,
            'event'          => 'deleted',
        ]);
    }
}
