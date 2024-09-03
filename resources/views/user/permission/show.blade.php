@extends('layouts.app') {{-- Assuming this is your main Stisla layout --}}

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<section class="section">
    <div class="section-header">
        <h1>{{ __('Persmission Management') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Permissions List') }}</h4>
                        <div class="card-header-action">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addPermissionModal">{{ __('Add Permission') }}</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th>{{ __('Id') }}</th>
                                        <th>{{ __('Permission Slug') }}</th>
                                        <th>{{ __('Permission Name') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->id }}</td>
                                        <td>{{ $permission->slug }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPermissionModal" data-id="{{ $permission->id }}" data-slug="{{ $permission->slug }}" data-name="{{ $permission->name }}">{{ __('Edit') }}</button>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePermissionModal" data-id="{{ $permission->id }}">{{ __('Delete') }}</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        {{-- Optional: Add pagination or other actions --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Add Permission Modal --}}
<div class="modal fade" id="addPermissionModal" tabindex="-1" role="dialog" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPermissionModalLabel">{{ __('Add Permission') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Form to add permission --}}
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="permission-slug">{{ __('Permission Slug') }}</label>
                        <input type="text" name="slug" class="form-control" id="permission-slug" required>
                    </div>
                    <div class="form-group">
                        <label for="permission-name">{{ __('Permission Name') }}</label>
                        <input type="text" name="name" class="form-control" id="permission-name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Permission Modal --}}
<div class="modal fade" id="editPermissionModal" tabindex="-1" role="dialog" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPermissionModalLabel">{{ __('Edit Permission') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Form to edit permission --}}
                <form id="edit-permission-form" action="" method="POST">
                    @csrf
                    @method('PUT') 
                    <div class="form-group">
                        <label for="edit-permission-slug">{{ __('Permission Slug') }}</label>
                        <input type="text" name="slug" class="form-control" id="edit-permission-slug" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-permission-name">{{ __('Permission Name') }}</label>
                        <input type="text" name="name" class="form-control" id="edit-permission-name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </form>                     
            </div>
        </div>
    </div>
</div>

{{-- Delete Permission Modal --}}
<div class="modal fade" id="deletePermissionModal" tabindex="-1" role="dialog" aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePermissionModalLabel">{{ __('Delete Permission') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure you want to delete this permission?') }}</p>
                <form id="delete-permission-form" action="" method="POST">
                    @csrf
                    @method('DELETE') <!-- Metode DELETE untuk penghapusan -->
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>                
            </div>
        </div>
    </div>
</div>


<script>
$('#editPermissionModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var slug = button.data('slug');
    var name = button.data('name');

    var modal = $(this);
    modal.find('#edit-permission-slug').val(slug);
    modal.find('#edit-permission-name').val(name);
    modal.find('#edit-permission-form').attr('action', '/permissions/' + id);
});

$('#deletePermissionModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    
    var modal = $(this);
    modal.find('#delete-permission-form').attr('action', '/permissions/' + id);
});
</script>
@endsection
