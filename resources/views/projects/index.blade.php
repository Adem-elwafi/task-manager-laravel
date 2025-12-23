@extends('layouts.app')

@section('content')
    <h1>Projects</h1>
    <ul>
        @foreach($projects as $project)
            <li>{{ $project->name }}</li>
        @endforeach
    </ul>
@endsection
