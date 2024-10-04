@extends('layouts.app')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>Roles Management</h1>
        </div>

        <div class="section-body">
        </div>
    </section>

    <div class="card-header-action">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addRolesModal">Create Add Roles</button>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Role List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped"  >
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Role Name</th>
                                    <th>Detail Permission</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i= 1 ?>
                                @foreach($roles as $role)
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td>{{ $role->name }}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-primary btn-detail" data-id="{{ $role->id }}" data-toggle="modal" data-target="#detailRolesModal">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-primary" data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-toggle="modal" data-target="#editRolesModal" onclick="editRole({{ $role->id }})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;" class="delete-role-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $i++ ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-right">
                        {{-- Optional: Add pagination or other actions --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Role Modal --}}
<div class="modal fade" id="addRolesModal" tabindex="-1" role="dialog" aria-labelledby="addRolesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRolesModalLabel">Create New Roles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Form to add roles --}}
                <form action="{{ route('roles.store') }}" method="POST" id="add-role-form">
                    @csrf
                    <div class="form-group">
                        <label for="role-name">Role Name</label>
                        <input type="text" name="name" class="form-control" id="role-name" required>
                    </div>
                    <div class="form-group">
                        <label for="rolespermission">Assign Permissions</label>
                        <select name="rolespermission[]" class="form-control select2" id="rolespermission" multiple required>
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Role Modal --}}
<div class="modal fade" id="editRolesModal" tabindex="-1" role="dialog" aria-labelledby="editRolesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRolesModalLabel">Edit Roles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-role-form" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="role-id">
                    <div class="form-group">
                        <label for="edit-role-name">Role Name</label>
                        <input type="text" name="name" class="form-control" id="edit-role-name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-rolespermission">Assign Permissions</label>
                        <select name="rolespermission[]" class="form-control select2" id="edit-rolespermission" multiple required>
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Detail Role Modal --}}
<div class="modal fade" id="detailRolesModal" tabindex="-1" role="dialog" aria-labelledby="detailRolesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailRolesModalLabel">Role Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 id="role-name"></h5>
                <p><strong>Permissions:</strong></p>
                <table class="table table-bordered table-md">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Permission Name</th>
                        </tr>
                    </thead>
                    <tbody id="role-permissions">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select permissions",
        allowClear: true
    });

    window.editRole = function(id) {
        $.ajax({
            url: '/admin/roles/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#role-id').val(response.role.id);
                $('#edit-role-name').val(response.role.name);

                $('#edit-rolespermission').empty();

                $.each(response.permissions, function(key, permission) {
                    var selected = response.rolePermissions.includes(permission.id) ? 'selected' : '';
                    $('#edit-rolespermission').append('<option value="'+permission.id+'" '+selected+'>'+permission.name+'</option>');
                });

                $('#edit-role-form').attr('action', '/admin/roles/' + id);
            }
        });
    }

    $('.btn-detail').click(function() {
        var roleId = $(this).data('id');
        $.ajax({
            url: '/admin/roles/' + roleId,
            type: 'GET',
            success: function(response) {
                $('#role-name').text(response.role.name);
                var permissionsList = '';
                $.each(response.permissions, function(index, permission) {
                    permissionsList += '<tr><td class="text-center">' + (index + 1) + '</td><td>' + permission.name + '</td></tr>';
                });
                $('#role-permissions').html(permissionsList);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });


    $('.delete-role-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);

        Swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: "Apakah Anda Yakin Ingin Menghapus Role ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.off('submit').submit();
            }
        });
    });

    $('#add-role-form, #edit-role-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var formData = form.serialize();

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Role Berhasil Ditambahkan!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); 
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Role Sudah Pernah Ditambahkan',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
@endsection
