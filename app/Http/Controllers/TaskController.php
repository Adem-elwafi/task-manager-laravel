<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class TaskController extends Controller
{
    private array $statusOptions = ['pending','in_progress','done'];
    private array $priorityOptions = ['low','medium','high'];

    /**
     * Display a listing of the tasks for a project.
     */
    public function index(Project $project)
    {
        $query = $project->tasks();

        // Filter by status
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Filter by priority
        if (request('priority')) {
            $query->where('priority', request('priority'));
        }

        // Search by title/description
        if (request('search')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%'.request('search').'%')
                ->orWhere('description', 'like', '%'.request('search').'%');
            });
        }

        $tasks = $query->paginate(5); // 5 per page
        return view('tasks.index', compact('project','tasks'));
    }

    /**
     * Show the form for creating a new task for a project.
     */
    public function create(Project $project)
    {
        $this->authorize('create', [Task::class, $project]);

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
        $this->authorize('create', [Task::class, $project]);

        $task = $project->tasks()->create($request->validated() + ['user_id' => Auth::id()]);

        // Log activity
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'created_task',
            'subject_id' => $task->id,
            'subject_type' => Task::class,
        ]);

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

        $this->authorize('update', $task);

        return view('tasks.edit', [
            'project' => $project,
            'task' => $task,
            'statusOptions' => $this->statusOptions,
            'priorityOptions' => $this->priorityOptions,
        ]);
    }

    /**
     * Update the specified task in storage.
     */public function update(UpdateTaskRequest $request, Project $project, Task $task)
{
    if ($task->project_id !== $project->id) {
        abort(404);
    }

    $this->authorize('update', $task);

    $task->update($request->validated());

    // ✅ Log activity
    Activity::create([
        'user_id' => Auth::id(),
        'action' => 'updated_task',
        'subject_id' => $task->id,
        'subject_type' => Task::class,
    ]);

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

    $this->authorize('delete', $task);

    $task->delete();

    // ✅ Log activity
    Activity::create([
        'user_id' => Auth::id(),
        'action' => 'deleted_task',
        'subject_id' => $task->id,
        'subject_type' => Task::class,
    ]);

    return redirect()
        ->route('projects.show', $project)
        ->with('success', 'Task deleted.');
}

}
