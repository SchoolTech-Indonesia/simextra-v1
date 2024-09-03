@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Users Management</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create New Users</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>
                    <a href="{{ route('permissions.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('permissions.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection