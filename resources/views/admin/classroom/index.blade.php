@extends('layouts.app')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>Class Management</h1>
        </div>

        <div class="section-body">
            <form method="GET" action="{{ route('classroom.index') }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search by classroom name or code" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <select name="major_id" class="form-control">
                            <option value="">All Majors</option>
                            @foreach($majors as $major)
                                <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </div>
            </form>                 
        </div>
    </section>

    <div class="card-header-action">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addClassroomModal">Create Classroom</button>
    </div>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Class List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Class Code</th>
                                <th>Class Name</th>
                                <th>Major </th> <!-- Added column for classes -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classroom as $class)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $class->code }}</td>
                                <td>{{ $class->name }}</td>
                                <td>
                                    {{ $class->major->name ?? '-' }}
                                </td>
                                <td class="align-middle">
                                    <!-- Action buttons here -->
                                    <button class="btn btn-primary btn-detail" data-id="{{ $class->id }}" data-toggle="modal" data-target="#detailClassroomModal">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-icon btn-primary" data-id="{{ $class->id }}" data-toggle="modal" data-target="#editClassroomModal" onclick="editClassroom({{ $class->id }})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <form action="{{ route('classroom.destroy', $class->id) }}" method="POST" style="display:inline;" onsubmit="return deleteClassroom(event, this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No ClassRoom Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
              <div class="card-footer text-right">
         
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

{{-- CREATE CLASSROOM --}}
<div class="modal fade" id="addClassroomModal" tabindex="-1" role="dialog" aria-labelledby="addClassroomModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addClassroomModalLabel">Create New Classroom</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form id="add-classroom-form" action="{{ route('classroom.store') }}" method="POST">
                @csrf
               
                <div class="form-group">
                    <label for="classroom-name">Classroom Name</label>
                    <input type="text" name="name" class="form-control" id="classroom-name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <label for="majors">Assign Major</label>
                    <select name="major_id" class="form-control select2" id="assignmajors" required>
                        @foreach($majors as $major)
                            <option value="{{ $major->id }}">{{ $major->name }}</option>
                        @endforeach
                    </select>

                </div>
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </form>
            

          </div>
      </div>
  </div>
</div>

{{-- EDIT CLASSROOM --}}
<div class="modal fade" id="editClassroomModal" tabindex="-1" role="dialog" aria-labelledby="editClassroomModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="editClassroomModalLabel">Edit Classroom</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form id="edit-classroom-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="classroom-id">
                <div class="form-group">
                    <label for="edit-classroom-code">Classroom Code</label>
                    <input type="text" name="code" class="form-control" id="edit-classroom-code" readonly>
                </div>
                <div class="form-group">
                    <label for="edit-classroom-name">Classroom Name</label>
                    <input type="text" name="name" class="form-control" id="edit-classroom-name" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <label for="majors">Assign Major</label>
                    <select name="major_id" class="form-control select2" id="edit-assignmajors" required>
                        @foreach($majors as $major)
                            <option value="{{ $major->id }}">{{ $major->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </form>
          </div>
      </div>
  </div>
</div>


{{-- Detail CLass Modal --}}
<div class="modal fade" id="detailClassroomModal" tabindex="-1" role="dialog" aria-labelledby="detailClassroomModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailClassroomModalLabel">Detail Classroom</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Class Code:</strong> <span id="class-code"></span></p>
                <p><strong>Class Name:</strong> <span id="class-name"></span></p>
                <p><strong>Major:</strong> <span id="class-major"></span></p>
                <p><strong>List of Students:</strong></p>
                <ul id="class-students"></ul>
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

function editClassroom(id) {
    $.ajax({
        url: '/classroom/' + id + '/edit',
        type: 'GET',
        success: function(response) {
            $('#classroom-id').val(response.classroom.id);
            $('#edit-classroom-code').val(response.classroom.code);
            $('#edit-classroom-name').val(response.classroom.name);
            $('#edit-assignmajors').val(response.selected_major_id).trigger('change'); // Set major yang sudah dipilih
            $('#edit-classroom-form').attr('action', '/classroom/' + id);
        }
    });
}

$('#add-classroom-form').on('submit', function(e) {
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
                text: 'Classroom successfully added.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); 
            });
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to add Classroom.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});

$('#edit-classroom-form').on('submit', function(e) {
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
                text: 'Classroom successfully updated.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); 
            });
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update Classroom.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});

function deleteClassroom(e, form) {
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this Classroom?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: $(form).attr('action'),
                method: 'DELETE',
                data: $(form).serialize(),
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'Classroom successfully deleted',
                        'success'
                    ).then(() => {
                        location.reload(); 
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'Failed to delete Classroom.',
                        'error'
                    );
                }
            });
        }
    });
}
$(document).ready(function () {
    $('.btn-detail').on('click', function () {
        var classId = $(this).data('id');

        $.ajax({
            url: `/classroom/${classId}`,
            type: 'GET',
            success: function (data) {
                $('#class-code').text(data.code);
                $('#class-name').text(data.name);
                $('#class-major').text(data.major ? data.major.name : '-');

                var studentsList = $('#class-students');
                studentsList.empty(); // Kosongkan daftar siswa sebelumnya

                if (data.students.length > 0) {
                    data.students.forEach(function (student, index) {
                        studentsList.append(`<li>${index + 1}. ${student.name}</li>`);
                    });
                } else {
                    studentsList.append('<li>No students found</li>');
                }

                $('#detailClassroomModal').modal('show');
            },
            error: function () {
                alert('Failed to load classroom details');
            }
        });
    });
});
</script>
@endsection
