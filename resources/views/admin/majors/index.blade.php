@extends('layouts.app')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>Major Management</h1>
        </div>

        <div class="section-body">
        </div>
    </section>
    
    <div class="card-header-action">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMajorsModal">Create Major</button>
    </div>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Major List</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Major Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i= 1 ?>
                    @foreach($majors as $major)
                    <tr>
                      <td class="text-center"><?= $i ?></td>
                      <td>{{ $major->name }}</td>
                      <td class="align-middle">
                        <button class="btn btn-icon btn-primary" data-id="{{ $major->id }}" data-name="{{ $major->name }}" data-toggle="modal" data-target="#editMajorsModal" onclick="editMajor({{ $major->id }})">
                          <i class="far fa-edit"></i>
                        </button>
                        <form action="{{ route('majors.destroy', $major->id) }}" method="POST" style="display:inline;" onsubmit="return deleteMajor(event, this);">
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

{{-- Add Major Modal --}}
<div class="modal fade" id="addMajorsModal" tabindex="-1" role="dialog" aria-labelledby="addMajorsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addMajorsModalLabel">Create New Major</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            {{-- Form to add Major --}}
            <form id="add-major-form" action="{{ route('majors.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="major-name">Major Name</label>
                    <input type="text" name="name" class="form-control" id="major-name" value="{{ old('name') }}" required>
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

{{-- Edit Major Modal --}}
<div class="modal fade" id="editMajorsModal" tabindex="-1" role="dialog" aria-labelledby="editMajorsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="editMajorsModalLabel">Edit Major</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form id="edit-major-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="major-id">
                <div class="form-group">
                    <label for="edit-major-name">Major Name</label>
                    <input type="text" name="name" class="form-control" id="edit-major-name" value="{{ old('name') }}" required>
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
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function editMajor(id) {
    $.ajax({
        url: '/majors/' + id + '/edit',
        type: 'GET',
        success: function(response) {
            $('#major-id').val(response.major.id);
            $('#edit-major-name').val(response.major.name);
            $('#edit-major-form').attr('action', '/majors/' + id);
        }
    });
}

$('#add-major-form').on('submit', function(e) {
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
                text: 'Major successfully added.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); 
            });
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to add Major.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});

$('#edit-major-form').on('submit', function(e) {
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
                text: 'Major successfully updated.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); 
            });
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update Major.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});

function deleteMajor(e, form) {
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this Major?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
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
                        'Major successfully deleted',
                        'success'
                    ).then(() => {
                        location.reload(); 
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'Failed to delete Major.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>
@endsection
