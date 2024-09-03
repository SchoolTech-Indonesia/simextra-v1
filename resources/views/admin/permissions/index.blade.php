@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Permission Management</h1>
    <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">Create New Permission</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
                <td>
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
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