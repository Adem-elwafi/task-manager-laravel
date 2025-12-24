<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $this->authorize('viewAny', Project::class);

    $projects = Project::query()->latest()->get();
    return view('projects.index', compact('projects'));
}

public function create()
{
    $this->authorize('create', Project::class);

    return view('projects.create');
}


public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $this->authorize('create', Project::class);

    $ownerId = Auth::id();
    if (!$ownerId) {
        return redirect()
            ->route('projects.index')
            ->with('error', 'You must be logged in to create a project.');
    }

    $project = Project::create([
        'name' => $validated['name'],
        'description' => $validated['description'] ?? null,
        'user_id' => $ownerId,
    ]);

    // ✅ Log activity
    Activity::create([
        'user_id' => $ownerId,
        'action' => 'created_project',
        'subject_id' => $project->id,
        'subject_type' => Project::class,
    ]);

    return redirect()
        ->route('projects.show', $project->id)
        ->with('success', 'Project created successfully.');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with('tasks')->findOrFail($id);
        $this->authorize('view', $project);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
