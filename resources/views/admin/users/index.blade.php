@extends('layouts.app')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>User Management</h1>
        </div>

        <div class="section-body">
        </div>
    </section>

    <div class="card-header-action">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal">Create New User</button>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>User List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 ?>
                                @foreach($users as $user)
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role ? $user->role->name : 'No Role' }}</td>

                                    <td>
                                        <button class="btn btn-icon btn-info" data-id="{{ $user->id }}" data-toggle="modal" data-target="#detailUserModal" onclick="detailUser({{ $user->id }})">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <button class="btn btn-icon btn-primary" data-id="{{ $user->id }}" data-toggle="modal" data-target="#editUserModal" onclick="editUser({{ $user->id }})">
                                            <i class="far fa-edit"></i>
                                        </button>

                                        <button class="btn btn-icon btn-danger delete-btn" data-id="{{ $user->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:none;" id="delete-form-{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                <?php $i++ ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add User Modal --}}
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Create New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Form to add user --}}
                <form id ="add-user-form" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="user-name">Name</label>
                        <input type="text" name="name" class="form-control" id="user-name" required>
                    </div>
                    <div class="form-group">
                        <label for="user-NISN_NIP">NISN/NIP</label>
                        <input type="text" name="NISN_NIP" class="form-control" id="user-NISN_NIP" required>
                    </div>
                    <div class="form-group">
                        <label for="user-email">Email</label>
                        <input type="email" name="email" class="form-control" id="user-email" required>
                    </div>
                    <div class="form-group">
                        <label for="user-phone_number">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" id="user-phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="user-password">Password</label>
                        <input type="password" name="password" class="form-control" id="user-password" required>
                    </div>
                    <div class="form-group">
                        <label for="user-password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="user-password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <label for="user-role_id">Role</label>
                        <select name="id_role" class="form-control" id="user-id_role" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_school">Sekolah</label>
                        <select name="id_school[]" class="form-control select2" id="id_school" multiple required>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit User Modal --}}
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-user-form" method="POST" action="/admin/users/{{ $user->id }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-user-id" name="id">
                    <div class="form-group">
                        <label for="edit-user-name">Name</label>
                        <input type="text" name="name" class="form-control" id="edit-user-name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-user-NISN_NIP">NISN/NIP</label>
                        <input type="text" name="NISN_NIP" class="form-control" id="edit-user-NISN_NIP" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-user-email">Email</label>
                        <input type="email" name="email" class="form-control" id="edit-user-email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-user-phone_number">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" id="edit-user-phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-user-id_role">Role</label>
                        <select name="id_role" class="form-control" id="edit-user-id_role" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-user-status">Status</label>
                        <select name="status" class="form-control" id="edit-user-status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-user-id_school">Sekolah</label>
                        <select name="id_school[]" class="form-control select2" id="edit-user-id_school" multiple required>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Detail User Modal --}}
<div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog" aria-labelledby="detailUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailUserModalLabel">Detail User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Name: </strong><span id="detail-user-name"></span></p>
                <p><strong>Email: </strong><span id="detail-user-email"></span></p>
                <p><strong>Phone: </strong><span id="detail-user-phone_number"></span></p>
                <p><strong>Role: </strong><span id="detail-user-role"></span></p>
                <p><strong>Status: </strong><span id="detail-user-status"></span></p>
                <p class="mb-0"><strong>Sekolah: </strong></p>
                <ul id="detail-user-school" class="list-group ml-3 mt-0">
                </ul>
            </div>
        </div>
    </div>
</div>


<script>
    function editUser(id) {
        $.ajax({
            url: '/admin/users/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                var user = response.user;
                var roles = response.roles;
                var schools = response.schools;
                var userSchoolIds = response.userSchoolIds;

                $('#edit-user-id').val(user.id);
                $('#edit-user-name').val(user.name);
                $('#edit-user-NISN_NIP').val(user.NISN_NIP);
                $('#edit-user-email').val(user.email);
                $('#edit-user-phone_number').val(user.phone_number);
                $('#edit-user-id_role').val(user.id_role);
                $('#edit-user-status').val(user.status);

                $('#edit-user-id_role').empty();
                $.each(roles, function(index, role) {
                    $('#edit-user-id_role').append(new Option(role.name, role.id, false, role.id == user.id_role));
                });

                $('#edit-user-id_school').empty();
                $.each(response.schools, function(index, school) {
                    var selected = response.userSchoolIds.includes(school.id) ? 'selected' : '';
                    $('#edit-user-id_school').append('<option value="'+school.id+'" '+selected+'>'+school.name+'</option>');
                });

                $('#edit-user-form').attr('action', '/admin/users/' + id);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    $('#add-user-form').on('submit', function(e) {
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
                    text: 'User Berhasil Ditambahkan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); 
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Email/NoHP/NISN/NIP Sudah Pernah Ditambahkan!',
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

    function detailUser(id) {
        $.ajax({
            url: '/admin/users/' + id,
            type: 'GET',
            success: function(response) {
                var user = response.user;
                var roles = {
                    1: 'Super Admin', 
                    2: 'Admin',
                    3: 'Koordinator',
                    4: 'Student'
                };

                var roleClasses = {
                    'Super Admin': 'badge-success',
                    'Admin': 'badge-primary',
                    'Koordinator': 'badge-warning',
                    'Student': 'badge-dark'
                };

                var statusClasses = {
                    1: 'badge-success',
                    0: 'badge-danger'
                };

                $('#detail-user-name').text(user.name);
                $('#detail-user-email').text(user.email);
                $('#detail-user-phone_number').text(user.phone_number);
                $('#detail-user-role').html(`<span class="badge ${roleClasses[user.role ? user.role.name : 'No Role']}">${user.role ? user.role.name : 'No Role'}</span>`);
                $('#detail-user-status').html(`<span class="badge ${statusClasses[user.status]}">${user.status === 1 ? 'Active' : 'Inactive'}</span>`);
                var schoolNames = user.schools.map(school => school.name).join(', ');
                $('#detail-user-school').empty();
                    if (user.schools.length > 0) {
                        $.each(user.schools, function(index, school) {
                            $('#detail-user-school').append(`<li>${school.name}</li>`);
                        });
                    } else {
                        $('#detail-user-school').append('<li>No School</li>');
                    }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }


    $('#edit-user-form').on('submit', function(e) {
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
                    text: 'User Berhasil Diubah.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); 
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Email/NoHP/NISN/NIP Sudah Pernah Ditambahkan!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    $('.delete-btn').on('click', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        var form = $(this).closest('tr').find('form');
        
        Swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: "Apakah Anda Yakin Ingin Menghapus User ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: $(form).serialize(),
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'User Berhasil Dihapus',
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'User Gagal Dihapus!.',
                            'error'
                        );
                    }
                });
            }
        });
    });


</script>
@endsection
