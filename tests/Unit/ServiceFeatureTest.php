<?php

namespace Tests\Unit;

use App\Models\Service;
use App\Models\ServiceFeature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function makeService(): Service
    {
        return Service::create([
            'title'       => 'Web Development',
            'description' => 'Layanan pembuatan website',
            'order'       => 0,
            'active'      => true,
        ]);
    }

    private function makeFeature(Service $service, array $override = []): ServiceFeature
    {
        return ServiceFeature::create(array_merge([
            'service_id' => $service->id,
            'feature'    => 'Responsive Design',
            'order'      => 0,
        ], $override));
    }

    // ---------- Fillable ----------

    public function test_service_feature_has_correct_fillable(): void
    {
        $feature = new ServiceFeature();
        $this->assertContains('service_id', $feature->getFillable());
        $this->assertContains('feature', $feature->getFillable());
        $this->assertContains('order', $feature->getFillable());
    }

    // ---------- Casts ----------

    public function test_order_is_cast_to_integer(): void
    {
        $service = $this->makeService();
        $feature = $this->makeFeature($service, ['order' => '2']);

        $this->assertIsInt($feature->order);
        $this->assertEquals(2, $feature->order);
    }

    // ---------- Relationship: belongsTo Service ----------

    public function test_service_feature_belongs_to_service(): void
    {
        $service = $this->makeService();
        $feature = $this->makeFeature($service);

        $this->assertInstanceOf(Service::class, $feature->service);
        $this->assertEquals($service->id, $feature->service->id);
    }

    // ---------- Relationship: hasMany ServiceFeature ----------

    public function test_service_has_many_features(): void
    {
        $service = $this->makeService();
        $this->makeFeature($service, ['feature' => 'SEO Friendly', 'order' => 0]);
        $this->makeFeature($service, ['feature' => 'CMS Integration', 'order' => 1]);
        $this->makeFeature($service, ['feature' => 'Mobile First', 'order' => 2]);

        $this->assertCount(3, $service->features);
    }

    // ---------- CRUD ----------

    public function test_service_feature_can_be_created(): void
    {
        $service = $this->makeService();
        $feature = $this->makeFeature($service, ['feature' => 'API Integration']);

        $this->assertDatabaseHas('service_features', [
            'service_id' => $service->id,
            'feature'    => 'API Integration',
        ]);
        $this->assertNotNull($feature->id);
    }

    public function test_service_feature_can_be_updated(): void
    {
        $service = $this->makeService();
        $feature = $this->makeFeature($service);

        $feature->update(['feature' => 'Responsive & Mobile Friendly']);

        $this->assertDatabaseHas('service_features', ['feature' => 'Responsive & Mobile Friendly']);
    }

    public function test_service_feature_can_be_deleted(): void
    {
        $service = $this->makeService();
        $feature = $this->makeFeature($service);
        $id      = $feature->id;

        $feature->delete();

        $this->assertDatabaseMissing('service_features', ['id' => $id]);
    }

    // ---------- Features milik service berbeda tidak tercampur ----------

    public function test_features_isolated_per_service(): void
    {
        $service1 = $this->makeService();
        $service2 = Service::create(['title' => 'Brand Engineering', 'description' => 'Desc', 'order' => 1, 'active' => true]);

        $this->makeFeature($service1, ['feature' => 'Feature S1']);
        $this->makeFeature($service2, ['feature' => 'Feature S2']);

        $this->assertCount(1, $service1->features);
        $this->assertCount(1, $service2->features);
        $this->assertEquals('Feature S1', $service1->features->first()->feature);
        $this->assertEquals('Feature S2', $service2->features->first()->feature);
    }

    // ---------- Ordering ----------

    public function test_features_ordered_by_order_column(): void
    {
        $service = $this->makeService();
        $this->makeFeature($service, ['feature' => 'C Feature', 'order' => 2]);
        $this->makeFeature($service, ['feature' => 'A Feature', 'order' => 0]);
        $this->makeFeature($service, ['feature' => 'B Feature', 'order' => 1]);

        $features = ServiceFeature::where('service_id', $service->id)->orderBy('order')->get();

        $this->assertEquals('A Feature', $features[0]->feature);
        $this->assertEquals('B Feature', $features[1]->feature);
        $this->assertEquals('C Feature', $features[2]->feature);
    }
}
