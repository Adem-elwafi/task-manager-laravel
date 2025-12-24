<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];

    // A project belongs to a user (owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A project has many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activities() {
    return $this->morphMany(Activity::class, 'subject');
}

}
