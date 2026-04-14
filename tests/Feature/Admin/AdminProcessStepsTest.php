<?php

namespace Tests\Feature\Admin;

use App\Models\ProcessStep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProcessStepsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    private function makeStep(array $override = []): ProcessStep
    {
        return ProcessStep::create(array_merge([
            'step_number' => '01',
            'title'       => 'Discovery',
            'description' => 'Menggali kebutuhan klien secara mendalam.',
            'order'       => 0,
        ], $override));
    }

    // ---------- Store ----------

    public function test_admin_can_store_process_step(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.process-steps.store'), [
            'step_number' => '01',
            'title'       => 'Discovery Phase',
            'description' => 'Identifikasi kebutuhan dan tujuan proyek.',
            'order'       => 0,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('process_steps', ['title' => 'Discovery Phase']);
    }

    public function test_store_process_step_requires_step_number(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.process-steps.store'), [
            'title'       => 'Strategy',
            'description' => 'Perencanaan strategi.',
        ]);

        $response->assertSessionHasErrors('step_number');
    }

    public function test_store_process_step_requires_title(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.process-steps.store'), [
            'step_number' => '02',
            'description' => 'Perencanaan strategi.',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_store_process_step_requires_description(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.process-steps.store'), [
            'step_number' => '03',
            'title'       => 'Execution',
        ]);

        $response->assertSessionHasErrors('description');
    }

    public function test_step_number_max_5_chars(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.process-steps.store'), [
            'step_number' => '123456',
            'title'       => 'Test',
            'description' => 'Desc.',
        ]);

        $response->assertSessionHasErrors('step_number');
    }

    public function test_guest_cannot_store_process_step(): void
    {
        $response = $this->post(route('admin.process-steps.store'), [
            'step_number' => '01',
            'title'       => 'Discovery',
            'description' => 'Desc.',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('process_steps', 0);
    }

    // ---------- Update ----------

    public function test_admin_can_update_process_step(): void
    {
        $step = $this->makeStep();

        $response = $this->actingAs($this->admin)->put(route('admin.process-steps.update', $step), [
            'step_number' => '01',
            'title'       => 'Discovery & Research',
            'description' => 'Menggali lebih dalam kebutuhan klien.',
            'order'       => 0,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('process_steps', ['title' => 'Discovery & Research']);
    }

    public function test_update_process_step_requires_title(): void
    {
        $step = $this->makeStep();

        $response = $this->actingAs($this->admin)->put(route('admin.process-steps.update', $step), [
            'step_number' => '01',
            'description' => 'Desc.',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_update_returns_404_for_nonexistent_step(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.process-steps.update', 9999), [
            'step_number' => '01',
            'title'       => 'Test',
            'description' => 'Desc.',
        ]);

        $response->assertStatus(404);
    }

    public function test_guest_cannot_update_process_step(): void
    {
        $step = $this->makeStep();

        $response = $this->put(route('admin.process-steps.update', $step), [
            'step_number' => '01',
            'title'       => 'Updated',
            'description' => 'Desc.',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('process_steps', ['title' => 'Discovery']);
    }

    // ---------- Destroy ----------

    public function test_admin_can_delete_process_step(): void
    {
        $step = $this->makeStep();

        $response = $this->actingAs($this->admin)->delete(route('admin.process-steps.destroy', $step));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('process_steps', ['id' => $step->id]);
        $this->assertNull(ProcessStep::find($step->id));
    }

    public function test_delete_returns_404_for_nonexistent_step(): void
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.process-steps.destroy', 9999));

        $response->assertStatus(404);
    }

    public function test_guest_cannot_delete_process_step(): void
    {
        $step = $this->makeStep();

        $response = $this->delete(route('admin.process-steps.destroy', $step));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('process_steps', ['id' => $step->id]);
    }

    // ---------- Multiple steps ----------

    public function test_deleting_one_step_does_not_affect_others(): void
    {
        $step1 = $this->makeStep(['step_number' => '01', 'title' => 'Step 1', 'order' => 0]);
        $step2 = $this->makeStep(['step_number' => '02', 'title' => 'Step 2', 'order' => 1]);

        $this->actingAs($this->admin)->delete(route('admin.process-steps.destroy', $step1));

        $this->assertNull(ProcessStep::find($step1->id));
        $this->assertNotNull(ProcessStep::find($step2->id));
    }
}
