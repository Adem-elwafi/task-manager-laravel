<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status', 'priority', 'due_date', 'project_id', 'user_id'
    ];

    // A task belongs to a project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // A task may be assigned to a user
    public function assignee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function activities() {
    return $this->morphMany(Activity::class, 'subject');
}

}
