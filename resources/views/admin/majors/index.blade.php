@extends('layouts.app')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>Major Management</h1>
        </div>

        <div class="section-body">
            <form method="GET" action="{{ route('majors.index') }}">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" style="max-width: 500px; width: 100%;" placeholder="Search Jurusan atau Kode Jurusan" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="{{ route('majors.index') }}" class="ml-3 btn btn-primary d-flex align-items-center">Show All</a> <!-- Show All button -->
                    </div>
                </div>
            </form>
        </div>
    </section>

    <div class="card-header-action">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMajorsModal">Create Major</button>
    </div>
   
    <div class="modal fade" id="addMajorsModal" tabindex="-1" role="dialog" aria-labelledby="addMajorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addMajorLabel">Create Major</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('majors.store') }}">
            @csrf
            {{-- <div class="form-group">
              <label for="major-code">Major Code</label>
              <input type="text" class="form-control" id="major-code" name="code" required>
            </div> --}}
            <div class="form-group">
              <label for="major-name">Major Name</label>
              <input type="text" class="form-control" id="major-name" name="name" required>
            </div>
            <div class="form-group">
              <label for="koordinator">Coordinator</label>
              <select name="koordinator_id" class="form-control">
                  <option value="">-- Select Coordinator (Optional) --</option> <!-- Optional coordinator -->
                  @foreach($koordinators as $koordinator)
                      <option value="{{ $koordinator->id }}">{{ $koordinator->name }}</option>
                  @endforeach
              </select>
          </div>
          
          <div class="form-group">
              <label for="classroom">Classroom</label>
              <select name="classroom_id" class="form-control">
                  <option value="">-- Select Classroom (Optional) --</option> <!-- Optional classroom -->
                  @foreach($classrooms as $classroom)
                      <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                  @endforeach
              </select>
          </div>
          
            <button type="submit" class="btn btn-primary">Save Major</button>
          </form>
        </div>
      </div>
    </div>
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
                                <th>Major Code</th>
                                <th>Major Name</th>
                                <th>Coordinator</th>
                                <th>Class List</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($majors as $major)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $major->code }}</td>
                                <td>{{ $major->name }}</td>
                                <td>{{ $major->koordinator ? $major->koordinator->name : '-' }}</td>
                                <td>
                                    @if($major->classrooms->isEmpty())
                                        -
                                    @else
                                        @foreach($major->classrooms as $classroom)
                                            {{ $classroom->class_name }} ({{ $classroom->class_code }})
                                            @if(!$loop->last), @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <!-- View Details Button -->
                                    <button class="btn btn-info btn-icon" onclick="showMajorDetails({{ $major->id }})">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                
                                    <!-- Edit Button -->
                                    <button class="btn btn-primary btn-icon" onclick="editMajor({{ $major->id }})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                
                                    <!-- Delete Button -->
                                    <form action="{{ route('majors.destroy', $major->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event, this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Major is not found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $majors->links() }}
                </div>
              <div class="card-footer text-right">
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

<script>
function showMajorDetails(id) {
    $.ajax({
        url: '/majors/' + id,
        type: 'GET',
        success: function(response) {
            $('#detail-major-code').text(response.major.code);
            $('#detail-major-name').text(response.major.name);
            
            let coordinators = response.major.koordinator ? response.major.koordinator.name : '-';
            $('#detail-major-koordinator').text(coordinators);

            let classes = response.major.classrooms.map(classroom => `${classroom.class_name} (${classroom.class_code})`).join(', ');
            $('#detail-major-classes').text(classes || '-');

            $('#detailMajorsModal').modal('show');
        }
    });
}
function editMajor(id) {
    $.ajax({
        url: '/majors/' + id + '/edit',
        type: 'GET',
        success: function(response) {
            // SweetAlert to display edit form
            Swal.fire({
                title: 'Edit Major',
                html: `
                    <input id="edit-major-code" class="swal2-input" value="${response.major.code}" placeholder="Major Code">
                    <input id="edit-major-name" class="swal2-input" value="${response.major.name}" placeholder="Major Name">
                    <select id="edit-koordinator" class="swal2-input">
                        <option value="">-- Select Coordinator (Optional) --</option>
                        ${response.koordinators.map(koordinator => `<option value="${koordinator.id}" ${koordinator.id === response.major.koordinator_id ? 'selected' : ''}>${koordinator.name}</option>`).join('')}
                    </select>
                    <select id="edit-classroom" class="swal2-input">
                        <option value="">-- Select Classroom (Optional) --</option>
                        ${response.classrooms.map(classroom => `<option value="${classroom.id}" ${classroom.id === response.major.classroom_id ? 'selected' : ''}>${classroom.name}</option>`).join('')}
                    </select>
                `,
                focusConfirm: false,
                showCancelButton: true,
                preConfirm: () => {
                    return {
                        code: document.getElementById('edit-major-code').value,
                        name: document.getElementById('edit-major-name').value,
                        koordinator_id: document.getElementById('edit-koordinator').value,
                        classroom_id: document.getElementById('edit-classroom').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform AJAX request to update data
                    $.ajax({
                        url: '/majors/' + id,
                        type: 'PUT',
                        data: {
                            _token: "{{ csrf_token() }}",
                            code: result.value.code,
                            name: result.value.name,
                            koordinator_id: result.value.koordinator_id,
                            classroom_id: result.value.classroom_id
                        },
                        success: function() {
                            Swal.fire('Updated!', 'The major has been updated.', 'success')
                            location.reload();
                        },
                        error: function() {
                            Swal.fire('Error', 'There was an error updating the major.', 'error')
                        }
                    });
                }
            });
        }
    });
}

function confirmDelete(event, form) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // Submit the form if confirmed
        }
    });
}


</script>
@endsection
