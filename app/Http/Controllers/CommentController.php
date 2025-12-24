<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;

class CommentController extends Controller
{
    public function store(Request $request, Project $project, Task $task)
{
    $request->validate([
        'body' => 'required|string|max:1000',
    ]);

    $task->comments()->create([
        'body' => $request->body,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('projects.show', $project)
                     ->with('success', 'Comment added successfully.');
}

    //
}
