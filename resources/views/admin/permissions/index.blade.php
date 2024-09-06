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
    
    <div class="card-header-action">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPermissionsModal">Create Permission</button>
    </div>
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
                      <th>Permission Slug</th>
                      <th>Permission Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i= 1 ?>
                    @foreach($permissions as $permission)
                    <tr>
                      <td class="text-center"><?= $i ?></td>
                      <td>{{ $permission->slug }}</td>
                      <td>{{ $permission->name }}</td>
                      <td class="align-middle">
                        <button class="btn btn-icon btn-primary" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}" data-slug="{{ $permission->slug }}" data-toggle="modal" data-target="#editPermissionsModal" onclick="editPermission({{ $permission->id }})">
                          <i class="far fa-edit"></i>
                        </button>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;" onsubmit="return deletePermission(event, this);">
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
                    <label for="permission-slug">Permission Slug</label>
                    <input type="text" name="slug" class="form-control" id="permission-slug" value="{{ old('slug') }}" required>
                    @error('slug')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
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
          <form id="edit-permission-form" action="{{ route('permissions.update', $permission->id) }}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" id="permission-id">
              <div class="form-group">
                  <label for="edit-permission-slug">Permission Slug</label>
                  <input type="text" name="slug" class="form-control" id="edit-permission-slug" value="{{ old('slug') }}" required>
                  @error('slug')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
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
    $('.select2').select2({
        placeholder: "Select permissions",  
        allowClear: true  
    });
});

function editPermission(id) {
    $.ajax({
        url: '/admin/permissions/' + id + '/edit',
        type: 'GET',
        success: function(response) {
            $('#permission-id').val(response.permission.id);
            $('#edit-permission-slug').val(response.permission.slug);
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
                text: 'Nama/Slug Sudah Pernah Ditambahkan!',
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
                text: 'Permission Berhasil Diubah.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); 
            });
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Nama/Slug Sudah Pernah Ditambahkan!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});

function deletePermission(e, form) {
    e.preventDefault();

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Apakah Anda Yakin ingin Menghapus Permission ini?",
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
                        'Permission Berhasil Dihapus',
                        'success'
                    ).then(() => {
                        location.reload(); 
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'Permission Gagal Dihapus!.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>
@endsection
