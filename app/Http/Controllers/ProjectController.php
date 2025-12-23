<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $projects = \App\Models\Project::all();
    return view('projects.index', compact('projects'));
}

public function create()
{
    return view('projects.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $ownerId = Auth::id();
    if (!$ownerId) {
        $ownerId = User::query()->value('id');
        if (!$ownerId) {
            $owner = User::create([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
            ]);
            $ownerId = $owner->id;
        }
    }

    $project = \App\Models\Project::create([
        'name' => $validated['name'],
        'description' => $validated['description'] ?? null,
        'user_id' => $ownerId,
    ]);

    return redirect()->route('projects.index');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = \App\Models\Project::with('tasks')->findOrFail($id);
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
