# Task Manager Implementation Report (Dec 24, 2025)

This document summarizes the changes made to align the Laravel Task Manager project with the requested guide (layout, models, controllers, views, component, validation, auth, authorization, filters, and pagination), plus how to run and test.

## Summary
- Added Bootstrap layout with flash messages and navigation.
- Completed Eloquent models and relationships.
- Implemented `ProjectController` and `TaskController` with validation, authorization, and redirects.
- Built Blade views for projects and tasks including filter/search and pagination.
- Created a reusable `TaskCard` Blade component with authorization checks.
- Added Form Request validation for task create/update.
- Installed Breeze for auth; protected routes with `auth` middleware.
- Registered and enforced policies for `Project` and `Task`.

## Files Changed or Added
- Layout
  - [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php): Bootstrap 5, nav links, flash messages, `@yield('content')` and `@yield('scripts')`, delete confirm script.

- Models
  - [app/Models/Project.php](app/Models/Project.php): `$fillable = ['name','description','user_id']`; `owner()` and `tasks()` relationships.
  - [app/Models/Task.php](app/Models/Task.php): `$fillable = ['title','description','status','priority','due_date','project_id','user_id']`; `project()` and `assignee()` relationships.

- Controllers
  - [app/Http/Controllers/ProjectController.php](app/Http/Controllers/ProjectController.php):
    - `index()` uses `$this->authorize('viewAny', Project::class)` and lists latest projects.
    - `create()` / `store()` authorize `create`; `store()` validates inputs, uses `Auth::id()`; redirects to show with success flash.
    - `show()` loads `tasks` and authorizes `view`.
  - [app/Http/Controllers/TaskController.php](app/Http/Controllers/TaskController.php):
    - Full nested CRUD under a `Project`.
    - `index()` filters by `status`, `priority`, `search` and paginates (5 per page).
    - `create()`/`store()` use `StoreTaskRequest` and authorize `create` on `[Task::class, $project]`.
    - `edit()`/`update()` use `UpdateTaskRequest`, authorize `update`, pass dropdown options.
    - `destroy()` authorizes `delete`.

- Requests
  - [app/Http/Requests/StoreTaskRequest.php](app/Http/Requests/StoreTaskRequest.php)
  - [app/Http/Requests/UpdateTaskRequest.php](app/Http/Requests/UpdateTaskRequest.php)
    - Rules:
      - `title`: required|string|max:255
      - `description`: nullable|string
      - `status`: required|in:pending,in_progress,done
      - `priority`: required|in:low,medium,high
      - `due_date`: nullable|date

- Policies and Provider
  - [app/Policies/ProjectPolicy.php](app/Policies/ProjectPolicy.php): `viewAny`, `view`, `create` return `true`; `update`/`delete` restricted to project owner.
  - [app/Policies/TaskPolicy.php](app/Policies/TaskPolicy.php): `create` allowed for project owner; `update` for project owner or task assignee; `delete` for project owner.
  - [app/Providers/AuthServiceProvider.php](app/Providers/AuthServiceProvider.php): Registered `Project` and `Task` policies.

- Views (Projects)
  - [resources/views/projects/index.blade.php](resources/views/projects/index.blade.php): Bootstrap card list, link to create.
  - [resources/views/projects/create.blade.php](resources/views/projects/create.blade.php): Bootstrap form with CSRF and validation feedback.
  - [resources/views/projects/show.blade.php](resources/views/projects/show.blade.php): Project details, tasks via `<x-task-card>`, "New Task Page" button, and inline Quick Add form.

- Views (Tasks)
  - [resources/views/tasks/index.blade.php](resources/views/tasks/index.blade.php): Filter/search form (status, priority, keyword), lists tasks via `<x-task-card>`, pagination with `{{ $tasks->links() }}`.
  - [resources/views/tasks/create.blade.php](resources/views/tasks/create.blade.php): Bootstrap form with CSRF, errors, dropdowns.
  - [resources/views/tasks/edit.blade.php](resources/views/tasks/edit.blade.php): Bootstrap form with CSRF, errors, dropdowns prefilled.

- Blade Component
  - [resources/views/components/task-card.blade.php](resources/views/components/task-card.blade.php): Task title/description, status, priority, due date via Carbon, Edit/Delete buttons under `@can`.

- Routes
  - [routes/web.php](routes/web.php): Restored `Route::resource('projects', ...)` and `Route::resource('projects.tasks', ...)` inside `Route::middleware('auth')`. Breeze routes loaded via `require __DIR__.'/auth.php';`.

## Authorization Usage
- Controllers use `$this->authorize()`:
  - `ProjectController@index|create|store|show`
  - `TaskController@create|store|edit|update|destroy`
- Views use `@can`:
  - New Task button, Edit/Delete buttons in `TaskCard`.

## Validation
- Create/Update task validation centralized in `StoreTaskRequest` and `UpdateTaskRequest` and applied in `TaskController`.

## Filters & Pagination
- Implemented in `TaskController@index` with query params `status`, `priority`, and `search` (title/description), paginated by 5.
- UI wired in `tasks/index.blade.php` and uses `{{ $tasks->links() }}`.

## Authentication (Breeze)
- Installed Breeze (Blade stack) and ran asset build. Breeze updated `routes/web.php` and added auth scaffolding.
- Protected project/task resources with `auth` middleware.

## Commands Executed
```bash
php artisan breeze:install  # Blade, dark mode: yes, Pest
php artisan migrate --force
```
(Breeze also built assets via Vite during install.)

## How To Run
```bash
php artisan serve
npm run dev
```
- Register/login via Breeze, then visit:
  - Projects index: /projects
  - Create project, then manage tasks within a project (filters and pagination on the tasks index for that project).

## Notes & Next Steps
- If you want a global tasks index (across all projects) or additional filters (assignee, due date ranges), I can add them.
- Let me know if you want navigation links for auth (login/register) surfaced in the layout.
