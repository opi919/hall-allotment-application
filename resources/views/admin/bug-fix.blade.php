@extends('layouts.app')

@section('title', 'Admin Bug Fix')

@section('content')
    <h1>Admin Bug Fix</h1>

    <h2>Users with Missing GPA Data</h2>
    @if ($users->isEmpty())
        <p>No users found with missing GPA data.</p>
    @else
        <h3>Total: {{ $users->count() }}</h3>
        <ul>
            @foreach ($users as $user)
                <li>{{ $user->username }}: Year: {{ $user->current_year }}, Semester: {{ $user->current_semester }},
                    GPA({{ min(($user->current_year - 1) * 2 + $user->current_semester, 8) }}):
                    {{ $user->{'semester_' . min(($user->current_year - 1) * 2 + $user->current_semester, 8) . '_gpa'} }}
                </li>
            @endforeach
        </ul>
    @endif
@endsection
