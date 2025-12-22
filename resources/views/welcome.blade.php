<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; margin: 2rem; }
        .wrap { max-width: 800px; margin: 0 auto; }
        .grid { display: grid; gap: 1rem; }
        .card { border: 1px solid #e5e7eb; border-radius: 8px; padding: 1rem; }
        a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrap">
    <h1>Task Manager</h1>
    <p>Clean start. Build fast. Learn deeply.</p>
    <div class="grid">
        <div class="card">
            <h3>Health check</h3>
            <p><a href="/health">View JSON</a></p>
        </div>
        <div class="card">
            <h3>Next steps</h3>
            <ul>
                <li>Design the database (projects, tasks, comments)</li>
                <li>Seed sample data</li>
                <li>Build CRUD</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
