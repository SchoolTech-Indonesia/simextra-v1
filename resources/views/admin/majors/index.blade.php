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
                    <input type="text" name="search" class="form-control" style="max-width: 500px; width: 100%;" placeholder="Search Jurusan atau Kode Jurusan, Kosongkan untuk melihat semua" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
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
            {{-- <div class="form-group">
              <label for="koordinator">Coordinator</label>
              <select name="koordinator_id" class="form-control">
                  <option value="">-- Select Coordinator (Optional) --</option> <!-- Optional coordinator -->
                  @foreach($koordinators as $koordinator)
                      <option value="{{ $koordinator->id }}">{{ $koordinator->name }}</option>
                  @endforeach
              </select>
          </div> --}}
          
          {{-- <div class="form-group">
              <label for="classroom">Classroom</label>
              <select name="classroom_id" class="form-control">
                  <option value="">-- Select Classroom (Optional) --</option> <!-- Optional classroom -->
                  @foreach($classrooms as $classroom)
                      <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                  @endforeach
              </select>
          </div> --}}
          
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($majors as $major)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $major->code }}</td>
                                <td>{{ $major->name }}</td>
                                {{-- <td>
                                    @if($major->classrooms->isEmpty())
                                        -
                                    @else
                                        @foreach($major->classrooms as $classroom)
                                            {{ $classroom->name }} ({{ $classroom->code }})
                                            @if(!$loop->last), @endif
                                        @endforeach
                                    @endif
                                </td> --}}
                                <td>
                                    <!-- View Details Button -->
                                    <button class="btn btn-info btn-icon" onclick="showMajorDetails({{ $major->id }})">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                            
                                    <!-- Edit Button -->
                                    <button class="btn btn-primary btn-icon btn-edit-major" data-id="{{ $major->id }}">
                                        <i class="far fa-edit"></i>
                                    </button>
                            
                                    <!-- Include the modals -->
                                    @include('admin.majors.detail-modal')
                                    @include('admin.majors.edit-modal')

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
                <div class="card-footer text-right float-right">
   
                    <ul class="pagination mb-0">
                        {{-- Previous button --}}
                        <li class="page-item {{ $majors->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $majors->previousPageUrl() . (request('search') ? '&search=' . request('search') : '') }}" tabindex="-1">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    
                        {{-- Page numbers --}}
                        @for ($i = 1; $i <= $majors->lastPage(); $i++)
                            <li class="page-item {{ $i == $majors->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $majors->url($i) . (request('search') ? '&search=' . request('search') : '') }}">{{ $i }}</a>
                            </li>
                        @endfor
                    
                        {{-- Next button --}}
                        <li class="page-item {{ $majors->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $majors->nextPageUrl() . (request('search') ? '&search=' . request('search') : '') }}">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
              </div>
            </div>
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
    // SweetAlert for success messages
    // @if (session('success'))
    //     Swal.fire({
    //         icon: 'success',
    //         title: 'Success',
    //         text: '{{ session('success') }}',
    //         confirmButtonText: 'OK'
    //     });
    // @endif

    function showMajorDetails(id) {
        $.ajax({
            url: `/majors/${id}`,  // Adjust the URL if needed
            method: 'GET',
            success: function(response) {
                // Populate the modal fields with data from the response
                $('#detail-major-code').text(response.major.code);
                $('#detail-major-name').text(response.major.name);

                // Populate classrooms in details
                let classrooms = response.major.classrooms.map(c => c.name).join(', ');
                $('#detail-major-classes').text(classrooms);

                // Show the modal
                $('#detailModal').modal('show');
            },
            error: function(xhr) {
                console.log('Error:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong while fetching major details.'
                });
            }
        });
    }
// Define the editMajor function
function editMajor(id) {
    $.ajax({
        url: `/admin/majors/${id}/edit`,  // Adjust the URL if needed
        method: 'GET',
        success: function(response) {
            // Populate the modal fields with data from the response
            $('#edit-major-name').val(response.major.name);

            // Populate classrooms in edit modal
            let selectedClassrooms = response.major.classrooms.map(c => c.id);
            $('#edit-classrooms').val(selectedClassrooms);

            // Show the modal
            $('#editModal').modal('show');
        },
        error: function(xhr) {
            console.log('Error:', xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong while fetching major details.'
            });
        }
    });
}

// Call the editMajor function when the button is clicked
$('.btn-edit-major').on('click', function() {
    var id = $(this).data('id');
    editMajor(id);
});

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
