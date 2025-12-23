<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_can_be_created_and_listed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('projects.store'), [
            'name' => 'My Test Project',
            'description' => 'Desc',
        ]);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', [
            'name' => 'My Test Project',
            'user_id' => $user->id,
        ]);

        $index = $this->get(route('projects.index'));
        $index->assertStatus(200);
    }

    public function test_task_can_be_created_under_project(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::create([
            'name' => 'Proj',
            'description' => 'D',
            'user_id' => $user->id,
        ]);

        $response = $this->post(route('projects.tasks.store', $project->id), [
            'title' => 'Task A',
            'description' => 'Details',
            'status' => 'pending',
            'priority' => 'medium',
            'due_date' => null,
        ]);

        $response->assertRedirect(route('projects.show', $project->id));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Task A',
            'project_id' => $project->id,
        ]);
    }

    public function test_task_validation_fails_for_bad_enum(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $project = Project::create([
            'name' => 'Proj',
            'description' => 'D',
            'user_id' => $user->id,
        ]);

        $response = $this->from(route('projects.tasks.create', $project->id))
            ->post(route('projects.tasks.store', $project->id), [
                'title' => 'Bad Task',
                'status' => 'invalid',
                'priority' => 'high',
            ]);

        $response->assertRedirect(route('projects.tasks.create', $project->id));
        $response->assertSessionHasErrors(['status']);
    }

    public function test_task_can_be_updated_and_deleted(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $project = Project::create([
            'name' => 'Proj',
            'description' => 'D',
            'user_id' => $user->id,
        ]);

        $task = $project->tasks()->create([
            'title' => 'Initial',
            'description' => null,
            'status' => 'pending',
            'priority' => 'low',
            'due_date' => null,
            'user_id' => $user->id,
        ]);

        // Update
        $update = $this->put(route('projects.tasks.update', [$project->id, $task->id]), [
            'title' => 'Updated',
            'description' => 'New',
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => null,
        ]);
        $update->assertRedirect(route('projects.show', $project->id));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated',
            'status' => 'in_progress',
            'priority' => 'high',
        ]);

        // Delete
        $delete = $this->delete(route('projects.tasks.destroy', [$project->id, $task->id]));
        $delete->assertRedirect(route('projects.show', $project->id));
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
