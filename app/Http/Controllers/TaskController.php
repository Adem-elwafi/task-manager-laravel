<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private array $statusOptions = ['pending','in_progress','done'];
    private array $priorityOptions = ['low','medium','high'];

    /**
     * Display a listing of the tasks for a project.
     */
    public function index(Project $project)
    {
        $tasks = $project->tasks()->latest()->get();
        return view('tasks.index', compact('project', 'tasks'));
    }

    /**
     * Show the form for creating a new task for a project.
     */
    public function create(Project $project)
    {
        return view('tasks.create', [
            'project' => $project,
            'statusOptions' => $this->statusOptions,
            'priorityOptions' => $this->priorityOptions,
        ]);
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        $project->tasks()->create($request->validated() + ['user_id' => Auth::id()]);

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified task.
     */
    public function show(Project $project, Task $task)
    {
        if ($task->project_id !== $project->id) {
            abort(404);
        }

        // Reuse project show to keep UI consistent
        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Project $project, Task $task)
    {
        if ($task->project_id !== $project->id) {
            abort(404);
        }

        return view('tasks.edit', [
            'project' => $project,
            'task' => $task,
            'statusOptions' => $this->statusOptions,
            'priorityOptions' => $this->priorityOptions,
        ]);
    }

    /**
     * Update the specified task in storage.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        if ($task->project_id !== $project->id) {
            abort(404);
        }

        $task->update($request->validated());

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        if ($task->project_id !== $project->id) {
            abort(404);
        }

        $task->delete();

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Task deleted successfully.');
    }
}
