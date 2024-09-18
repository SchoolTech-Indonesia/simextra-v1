@extends('layouts.app')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>User Management</h1>
        </div>

        <div class="section-body mb-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group" role="group" aria-label="Filter by Role">
                        <a href="{{ route('users.index') }}" class="btn btn-primary {{ request('role') == '' ? 'active' : '' }}">All Roles</a>
                        <a href="{{ route('users.index', ['role' => 3]) }}" class="btn btn-primary {{ request('role') == 3 ? 'active' : '' }}">Admin</a>
                        <a href="{{ route('users.index', ['role' => 2]) }}" class="btn btn-primary {{ request('role') == 2 ? 'active' : '' }}">Koordinator</a>
                        <a href="{{ route('users.index', ['role' => 1]) }}" class="btn btn-primary {{ request('role') == 1 ? 'active' : '' }}">Student</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </section>

    <div class="card-header-form d-flex justify-content-between align-items-center">
        <div class="form-group mb-0">
            <div class="input-group">
                <input type="text" name="search" id="search-user" class="form-control" placeholder="Search Name" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group mb-0">
            <div class="d-flex">
                <button class="btn btn-primary mb-3 mr-2" data-toggle="modal" data-target="#addUserModal">Create New User</button>
                <a href="{{ route('users.download-pdf') }}" class="btn btn-danger mb-3 mr-2" id="downloadBtn">
                    <i class="fas fa-download"></i> Download PDF
                </a>
                <form id="import-form" action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="file-input" name="file" accept=".xlsx, .xls" style="display: none;" required>
                    <button class="btn btn-success mb-3 mr-2" type="button" id="import-button"><i class="fas fa-file-excel"></i> Import Users</button>
                </form>
            </div>
        </div>
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
                            <tbody id="user-table-body">
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
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                    {{-- Previous button --}}
                                    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $users->previousPageUrl() . (request('role') ? '&role=' . request('role') : '') }}" tabindex="-1">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>

                                    {{-- Page numbers --}}
                                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                                        <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $users->url($i) . (request('role') ? '&role=' . request('role') : '') }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Next button --}}
                                    <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $users->nextPageUrl() . (request('role') ? '&role=' . request('role') : '') }}">
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
                <form id="add-user-form" action="{{ route('users.store') }}" method="POST">
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

                    {{-- Hilangkan dropdown role jika ada roleId --}}
                    @if(!request('role'))
                        <div class="form-group">
                            <label for="user-id_role">Role</label>
                            <select name="id_role" class="form-control" id="user-id_role" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="id_role" value="{{ request('role') }}">
                    @endif

                    <div class="form-group">
                        <label for="user-id_school">Sekolah</label>
                        <select name="id_school" class="form-control" id="user-id_school"required>
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

                    {{-- Hilangkan dropdown role jika ada roleId --}}
                    @if(!request('role'))
                        <div class="form-group">
                            <label for="edit-user-id_role">Role</label>
                            <select name="id_role" class="form-control" id="edit-user-id_role" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="id_role" value="{{ request('role') }}">
                    @endif

                    <div class="form-group">
                        <label for="edit-user-status">Status</label>
                        <select name="status" class="form-control" id="edit-user-status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-user-id_school">Sekolah</label>
                        <select name="id_school" class="form-control " id="edit-user-id_school" required>
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
                <p><strong>School: </strong><span id="detail-user-school"></span></p>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#search-user').on('keyup', function() {
            var query = $(this).val();
            var role = "{{ request('role') }}"; // Ambil role yang aktif
            $.ajax({
                url: "{{ route('users.index') }}",
                type: "GET",
                data: { 'search': query, 'role': role }, // Kirimkan query dan role
                success: function(data) {
                    var rows = '';

                    if (data.users.data.length > 0) {
                        data.users.data.forEach(function(user, index) {
                            rows += `
                                <tr>
                                    <td class="text-center">${index + 1}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${user.role ? user.role.name : 'No Role'}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-icon btn-info" data-id="${user.id}" data-toggle="modal" data-target="#detailUserModal" onclick="detailUser(${user.id})">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <button class="btn btn-icon btn-primary" data-id="${user.id}" data-toggle="modal" data-target="#editUserModal" onclick="editUser(${user.id})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <form action="/admin/users/${user.id}" method="POST" style="display:inline;" onsubmit="return deleteUser(event, this);">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        rows = '<tr><td colspan="5" class="text-center">No Users Found</td></tr>';
                    }

                    $('#user-table-body').html(rows);
                }
            });
        });
    });

    function editUser(id) {
        $.ajax({
            url: '/admin/users/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                var user = response.user;
                var roles = response.roles;
                var schools = response.schools;

                $('#edit-user-id').val(user.id);
                $('#edit-user-name').val(user.name);
                $('#edit-user-NISN_NIP').val(user.NISN_NIP);
                $('#edit-user-email').val(user.email);
                $('#edit-user-phone_number').val(user.phone_number);
                $('#edit-user-id_role').val(user.id_role);
                $('#edit-user-status').val(user.status);

                // Sesuaikan dropdown role jika ada roleId
                @if(request('role'))
                    $('#edit-user-id_role').prop('disabled', true);
                @else
                    $('#edit-user-id_role').prop('disabled', false);
                @endif

                $('#edit-user-id_school').empty();
                $.each(response.schools, function(index, school) {
                    var selected = user.id_school == school.id ? 'selected' : '';
                    $('#edit-user-id_school').append('<option value="'+school.id+'" '+selected+'>'+school.name+'</option>');
                });

                $('#edit-user-form').attr('action', '/admin/users/' + id);
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

                // Menampilkan nama sekolah jika ada
                if (user.school) {
                    $('#detail-user-school').text(user.school.name);
                } else {
                    $('#detail-user-school').text('No School');
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

    document.getElementById('import-button').addEventListener('click', function() {
        // Trigger file input click
        document.getElementById('file-input').click();
    });

    document.getElementById('file-input').addEventListener('change', function(event) {
        if (event.target.files.length > 0) {
            // Show SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Konfirmasi Import',
                text: 'Apakah Anda yakin ingin mengimpor data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, impor!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('import-form').submit();
                    document.getElementById('import-form').addEventListener('submit', function(event) {
                        event.preventDefault();
                        fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: new FormData(this)
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Sukses!',
                                    'Data telah berhasil diimpor.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat mengimpor data.',
                                    'error'
                                );
                            }
                        })
                    });
                }
            });
        }
    });



</script>
@endsection
