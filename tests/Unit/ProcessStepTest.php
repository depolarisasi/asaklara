<?php

namespace Tests\Unit;

use App\Models\ProcessStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProcessStepTest extends TestCase
{
    use RefreshDatabase;

    private function makeStep(array $override = []): ProcessStep
    {
        return ProcessStep::create(array_merge([
            'step_number' => 1,
            'title'       => 'Discovery',
            'description' => 'Menggali kebutuhan klien secara mendalam.',
            'order'       => 0,
        ], $override));
    }

    // ---------- Fillable ----------

    public function test_process_step_has_correct_fillable(): void
    {
        $step = new ProcessStep();
        $this->assertContains('step_number', $step->getFillable());
        $this->assertContains('title', $step->getFillable());
        $this->assertContains('description', $step->getFillable());
        $this->assertContains('order', $step->getFillable());
    }

    // ---------- Casts ----------

    public function test_order_is_cast_to_integer(): void
    {
        $step = $this->makeStep(['order' => '3']);

        $this->assertIsInt($step->order);
        $this->assertEquals(3, $step->order);
    }

    // ---------- CRUD ----------

    public function test_process_step_can_be_created(): void
    {
        $step = $this->makeStep(['title' => 'Strategy', 'step_number' => 2]);

        $this->assertDatabaseHas('process_steps', [
            'title'       => 'Strategy',
            'step_number' => 2,
        ]);
        $this->assertNotNull($step->id);
    }

    public function test_process_step_can_be_updated(): void
    {
        $step = $this->makeStep();
        $step->update(['title' => 'Discovery Updated']);

        $this->assertDatabaseHas('process_steps', ['title' => 'Discovery Updated']);
    }

    public function test_process_step_can_be_deleted(): void
    {
        $step = $this->makeStep();
        $id   = $step->id;

        $step->delete();

        $this->assertDatabaseMissing('process_steps', ['id' => $id]);
        $this->assertNull(ProcessStep::find($id));
    }

    // ---------- Ordering ----------

    public function test_steps_are_ordered_by_order_column(): void
    {
        $this->makeStep(['title' => 'Step C', 'step_number' => 3, 'order' => 2]);
        $this->makeStep(['title' => 'Step A', 'step_number' => 1, 'order' => 0]);
        $this->makeStep(['title' => 'Step B', 'step_number' => 2, 'order' => 1]);

        $steps = ProcessStep::orderBy('order')->get();

        $this->assertEquals('Step A', $steps[0]->title);
        $this->assertEquals('Step B', $steps[1]->title);
        $this->assertEquals('Step C', $steps[2]->title);
    }

    // ---------- Multiple records ----------

    public function test_multiple_steps_can_exist(): void
    {
        $this->makeStep(['step_number' => 1, 'order' => 0]);
        $this->makeStep(['step_number' => 2, 'order' => 1]);
        $this->makeStep(['step_number' => 3, 'order' => 2]);

        $this->assertCount(3, ProcessStep::all());
    }
}
