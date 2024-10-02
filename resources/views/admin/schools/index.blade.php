@extends('layouts.app')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>School Management</h1>
        </div>
        <div class="section-body">
        </div>
    </section>

    <div class="card-header-action">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSchoolModal">Create New School</button>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>List Sekolah</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 ?>
                                @foreach($schools as $school)
                                <tr>
                                    <td class="text-center">{{ $i }}</td>                            
                                    <td><img src="{{ asset('storage/' . $school->logo_img) }}" alt="Logo" width="100" height="100"></td>
                                    <td>{{ $school->name }}</td>
                                    <td>{{ $school->address }}</td>
                                    <td>
                                        <button class="btn btn-icon btn-info" data-id="{{ $school->id }}" data-toggle="modal" data-target="#detailSchoolModal" onclick="showSchoolDetails({{ $school->id }})">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <button class="btn btn-icon btn-primary" data-id="{{ $school->id }}" data-toggle="modal" data-target="#editSchoolModal" onclick="editSchool({{ $school->id }})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <button class="btn btn-icon btn-danger delete-btn"><i class="fas fa-times"></i></button>
                                        <form action="{{ route('schools.destroy', $school->id) }}" method="POST" style="display:inline;" >
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

{{-- Add School Modal --}}
<div class="modal fade" id="addSchoolModal" tabindex="-1" role="dialog" aria-labelledby="addSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSchoolModalLabel">Create New School</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Form to add school --}}
                <form id="add-school-form" action="{{ route('schools.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="school-logo">Logo</label>
                        <input type="file" name="logo_img" class="form-control" id="school-logo" required>
                    </div>
                    <div class="form-group">
                        <label for="school-name">Name</label>
                        <input type="text" name="name" class="form-control" id="school-name" required>
                    </div>
                    <div class="form-group">
                        <label for="school-address">Address</label>
                        <input type="text" name="address" class="form-control" id="school-address" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit School Modal --}}
<div class="modal fade" id="editSchoolModal" tabindex="-1" role="dialog" aria-labelledby="editSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSchoolModalLabel">Edit School</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-school-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    @method('PUT')
                    <input type="hidden" id="school-id" name="id">
                    <div class="form-group">
                        <label for="edit-school-logo">Logo</label>
                        <input type="file" name="logo_img" class="form-control" id="edit-school-logo">
                        <img id="current-logo" src="" alt="Current Logo" width="100" height="100" style="display:none;">
                    </div>
                    <div class="form-group">
                        <label for="edit-school-name">Name</label>
                        <input type="text" name="name" class="form-control" id="edit-school-name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-school-address">Address</label>
                        <input type="text" name="address" class="form-control" id="edit-school-address" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Detail School Modal --}}
<div class="modal fade" id="detailSchoolModal" tabindex="-1" role="dialog" aria-labelledby="detailSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailSchoolModalLabel">Detail Sekolah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>Logo Sekolah</strong></label>
                    <div id="detail-logo">
                        <!-- Logo will be loaded here -->
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>Nama Sekolah</strong></label>
                    <div id="detail-name"></div>
                </div>
                <div class="form-group">
                    <label><strong>Alamat Sekolah</strong></label>
                    <div id="detail-address"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('#add-school-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this)[0]; 
        var formData = new FormData(form); 
        
        $.ajax({
            url: $(form).attr('action'),
            method: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Sekolah Berhasil Ditambahkan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); 
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Nama Sekolah Sudah Pernah Ditambahkan!!',
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

    function editSchool(id) {
    $.ajax({
        url: '/admin/schools/' + id + '/edit',
        type: 'GET',
        success: function(response) {
            $('#school-id').val(response.school.id);
            $('#edit-school-name').val(response.school.name);
            $('#edit-school-address').val(response.school.address);

            var logoUrl = response.school.logo_img ? '/storage/' + response.school.logo_img : '';
            if (logoUrl) {
                $('#current-logo').attr('src', logoUrl).show();
            } else {
                $('#current-logo').hide();
            }

            $('#edit-school-form').attr('action', '/admin/schools/' + id);
        }
    });
}

    $('.delete-btn').on('click', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        var form = $(this).closest('tr').find('form');
        
        Swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: "Apakah Anda Yakin Ingin Menghapus Sekolah ini?",
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
                            'Sekolah Berhasil Dihapus',
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Sekolah Gagal Dihapus!.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    function showSchoolDetails(id) {
        $.ajax({
            url: '/admin/schools/' + id,
            type: 'GET',
            success: function(response) {
                $('#detail-name').text(response.school.name);
                $('#detail-address').text(response.school.address);

                var logoUrl = response.school.logo_img ? '/storage/' + response.school.logo_img : '';
                if (logoUrl) {
                    $('#detail-logo').html('<img src="' + logoUrl + '" alt="Logo" width="100" height="100">');
                } else {
                    $('#detail-logo').text('No logo available');
                }
            }
        });
    }

</script>
@endsection
