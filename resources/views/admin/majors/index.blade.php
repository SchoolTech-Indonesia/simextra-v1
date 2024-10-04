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
                        <div class="form-group">
                            <label for="major-name">Major Name</label>
                            <input type="text" class="form-control" id="major-name" name="name" required>
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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Major Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 ?>
                                @forelse($majors as $major)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $major->name }}</td>
                                    <td>
                                        <button class="btn btn-info btn-icon" data-id="{{ $major->id }}" data-toggle="modal" data-target="#majorDetailsModal" onclick="majorDetailsModals({{ $major->id }})">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <button class="btn btn-primary btn-icon" data-id="{{ $major->id }}" data-toggle="modal" data-target="#editModal" onclick="editMajor({{ $major->id }})">
                                            <i class="far fa-edit"></i>
                                        </button>
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
                                    <td colspan="4" class="text-center">Major is not found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade" id="majorDetailsModal" tabindex="-1" aria-labelledby="majorDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Major Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Major Name:</strong> <ul id="details-major-name"></ul></p>
                                    <p><strong>Classrooms:</strong><ul id="classroom-list"></ul></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Major</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="editMajorForm" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="major-id">
                                        <div class="form-group">
                                            <label for="edit-major-name">Major Name</label>
                                            <input type="text" name="name" class="form-control" id="edit-major-name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="majorsclassrooms">Assign Classrooms</label>
                                            <select name="classrooms[]" class="form-control select2" id="majorsclassrooms" multiple required>
                                                <!-- Options will be dynamically populated here -->
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right float-right">
                    <ul class="pagination mb-0">
                        <li class="page-item {{ $majors->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $majors->previousPageUrl() . (request('search') ? '&search=' . request('search') : '') }}" tabindex="-1">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $majors->lastPage(); $i++)
                            <li class="page-item {{ $i == $majors->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $majors->url($i) . (request('search') ? '&search=' . request('search') : '') }}">{{ $i }}</a>
                            </li>
                        @endfor
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

@endsection

<script>
    function majorDetailsModals(id) {
        $.ajax({
            url: `/majors/${id}`,  // Fetch the data for the selected major
            type: 'GET',
            success: function(response) {
                console.log(response);  // Log the response for debugging

                var major = response.major;

                // Populate modal fields with the major details
                $('#details-major-name').text(major.name || 'No name available');  // Handle undefined name

                // Clear the classroom list
                $('#classroom-list').empty();

                // Populate classroom list if there are classrooms
                if (major.classrooms && major.classrooms.length > 0) {
                    major.classrooms.forEach(function(classroom) {
                        $('#classroom-list').append('<li>' + classroom.name + '</li>');
                    });
                } else {
                    $('#classroom-list').append('<li>No classrooms available</li>');
                }

                // Show the modal
                $('#majorDetailsModal').modal('show');
            },
            error: function(xhr) {
                console.log(xhr.responseText);  // Log the error for debugging
                alert('Error fetching major data.');
            }
        });
    }

    window.editMajor = function(id) {
        $.ajax({
            url: '/majors/' + id + '/edit', // URL to fetch major and classroom details
            type: 'GET',
            success: function(response) {
                // Populate the form with the major name
                $('#edit-major-name').val(response.major.name);

                // Empty the classroom select box first
                $('#majorsclassrooms').empty();

                // Loop through all classrooms and add options to the select2 dropdown
                $.each(response.classrooms, function(key, classroom) {
                    // Check if the classroom is already associated with the major
                    var selected = response.majorClassrooms.includes(classroom.id) ? 'selected' : '';
                    
                    // Append the classroom option (with 'selected' if it's already associated)
                    $('#majorsclassrooms').append('<option value="'+classroom.id+'" '+selected+'>'+classroom.name+'</option>');
                });

                // Reinitialize the select2 to reflect the new data
                $('#majorsclassrooms').select2();

                // Set the form action dynamically
                $('#editMajorForm').attr('action', '/majors/' + id);
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
    };

    $('#editMajorForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(form[0]);
        formData.append('_method', 'PUT'); // Add this line to simulate PUT request

        $.ajax({
            url: url,
            method: 'POST', // Change this to POST
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#editModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Major updated successfully!'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                console.log('Error:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong while updating the major.'
                });
            }
        });
    });

    $('#add-classroom-button').on('click', function() {
        var selectedClassroomId = $('#edit-classrooms').val();
        var selectedClassroomName = $('#edit-classrooms option:selected').text();

        if (selectedClassroomId) {
            $('#selected-classrooms').append(`
                <div class="selected-classroom" data-id="${selectedClassroomId}">
                    ${selectedClassroomName} <button class="remove-classroom">Remove</button>
                </div>
            `);
            $(`#edit-classrooms option[value="${selectedClassroomId}"]`).remove();
        }
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
                form.submit();
            }
        });
    }
</script>


@endsection
