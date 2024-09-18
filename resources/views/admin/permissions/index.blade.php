@extends('layouts.app')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>Permission Management</h1>
        </div>

        <div class="section-body">
        </div>
    </section>
    
    <div class="card-header-form">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPermissionsModal">Create Permission</button>
        <div class="form-group float-right mb-0">
            <div class="input-group">
                <input type="text" id="search-permission" class="form-control" placeholder="Search Permission">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    <div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Permission List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Permission Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="permission-table-body">
                                @foreach($permissions as $index => $permission)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-icon btn-primary" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}" data-toggle="modal" data-target="#editPermissionsModal" onclick="editPermission({{ $permission->id }})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;" onsubmit="return deletePermission(event, this);">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                    {{-- Previous button --}}
                                    <li class="page-item {{ $permissions->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $permissions->previousPageUrl() }}" tabindex="-1">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>

                                    {{-- Page numbers --}}
                                    @for ($i = 1; $i <= $permissions->lastPage(); $i++)
                                        <li class="page-item {{ $i == $permissions->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $permissions->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Next button --}}
                                    <li class="page-item {{ $permissions->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $permissions->nextPageUrl() }}">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Permissions Modal --}}
<div class="modal fade" id="addPermissionsModal" tabindex="-1" role="dialog" aria-labelledby="addPermissionsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPermissionsModalLabel">Create New Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Form to add Permission --}}
                <form id="add-permission-form" action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="permission-name">Permission Name</label>
                        <input type="text" name="name" class="form-control" id="permission-name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Permissions Modal --}}
<div class="modal fade" id="editPermissionsModal" tabindex="-1" role="dialog" aria-labelledby="editPermissionsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPermissionsModalLabel">Edit Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-permission-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="permission-id" name="permission-id">
                    <div class="form-group">
                        <label for="edit-permission-name">Permission Name</label>
                        <input type="text" name="name" class="form-control" id="edit-permission-name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#search-permission').on('keyup', function() {
        var query = $(this).val();

        $.ajax({
            url: "{{ route('permissions.index') }}",
            type: "GET",
            data: { 'query': query },
            success: function(data) {
                var rows = '';

                if (data.permissions.length > 0) {
                    data.permissions.forEach(function(permission, index) {
                        rows += `
                            <tr>
                                <td class="text-center">${index + 1}</td>
                                <td>${permission.name}</td>
                                <td class="align-middle">
                                    <button class="btn btn-icon btn-primary" data-id="${permission.id}" data-name="${permission.name}" data-toggle="modal" data-target="#editPermissionsModal" onclick="editPermission(${permission.id})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <form action="/admin/permissions/${permission.id}" method="POST" style="display:inline;" onsubmit="return deletePermission(event, this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    rows = '<tr><td colspan="3" class="text-center">No Permissions Found</td></tr>';
                }

                $('#permission-table-body').html(rows);
            }
        });
    });
});

function editPermission(id) {
    $.ajax({
        url: '/admin/permissions/' + id + '/edit',
        type: 'GET',
        success: function(response) {
            $('#permission-id').val(response.permission.id);
            $('#edit-permission-name').val(response.permission.name);
            $('#edit-permission-form').attr('action', '/admin/permissions/' + id);
        }
    });
}

$('#add-permission-form').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = form.serialize();

    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: formData,
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: 'Permission Berhasil Ditambahkan.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); 
            });
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Nama Sudah Pernah Ditambahkan!',
                icon: 'error',
                confirmButtonText: 'OK'
            });

            // Show validation errors
            var errors = xhr.responseJSON.errors;
            if (errors) {
                $.each(errors, function(key, value) {
                    $(`#${key}`).after(`<span class="text-danger">${value[0]}</span>`);
                });
            }
        }
    });
});

$('#edit-permission-form').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = form.serialize();

    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: formData,
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: 'Permission Berhasil Diperbarui.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); 
            });
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Nama Sudah Pernah Ditambahkan!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            var errors = xhr.responseJSON.errors;
            if (errors) {
                $.each(errors, function(key, value) {
                    $(`#${key}`).after(`<span class="text-danger">${value[0]}</span>`);
                });
            }
        }
    });
});
</script>
@endsection
