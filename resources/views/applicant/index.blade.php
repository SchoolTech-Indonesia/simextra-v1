@extends('layouts.app')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>Applicant Management</h1>
        </div>

        <div class="section-body">
            <!-- No filter for now -->
        </div>
    </section>

    <!-- Search Form -->
    <form action="{{ route('applicant.index') }}" method="GET" class="mb-4">
        <div class="form-row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by Applicant Name" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Applicant List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Applicant Name</th>
                                <th>Extracurricular</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applicants as $applicant)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $applicant->user->name }}</td>
                                <td>{{ $applicant->ekstrakurikuler->name ?? '-' }}</td>
                                <td>{{ $applicant->statusApplicant->name }}</td>
                                <td class="align-middle">
                                    <button class="btn btn-primary btn-detail" data-id="{{ $applicant->id }}" data-toggle="modal" data-target="#detailApplicantModal" onclick = "showApplicantDetails({{ $applicant->id }})">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-icon btn-primary" data-id="{{ $applicant->id }}" data-toggle="modal" data-target="#editApplicantModal" onclick="editApplicant({{ $applicant->id }})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <form action="{{ route('applicant.destroy', $applicant->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event, '{{ $applicant->id }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No Applicants Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
              <div class="card-footer text-right">
                <!-- Pagination if necessary -->
              </div>
            </div>
          </div>
        </div>
      </div>

    <!-- Register Extracurricular Button -->
    <div class="text-center" id="extracurricular-buttons">
        <!-- Buttons will be dynamically appended here -->
    </div>
    @foreach ($applicants as $applicant)
{{-- EDIT APPLICANT --}}
<div class="modal fade" id="editApplicantModal" tabindex="-1" role="dialog" aria-labelledby="editApplicantModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal -header">
              <h5 class="modal-title" id="editApplicantModalLabel">Edit Applicant</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">

            <form action="{{ route('applicant.update', $applicant->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="applicant-id">
                <div class="form-group">


                    <label for="edit-status">Application Status</label>
                    <select name="status_applicant_id" class="form-control select2" id="edit-status" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>

   
          </div>
      </div>
  </div>
</div>
@endforeach
{{-- DETAIL APPLICANT --}}
<div class="modal fade" id="detailApplicantModal" tabindex="-1" role="dialog" aria-labelledby="detailApplicantModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailApplicantModalLabel">Applicant Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="detail-name"></span></p>
                <p><strong>Status:</strong> <span id="detail-status"></span></p>
                <p><strong>Kode Applicant:</strong> <span id="detail-code"></span></p>
                
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Fetch extracurriculars for the buttons
    $.ajax({
        url: '/api/extracurriculars',
        type: 'GET',
        success: function(response) {
            if (response.data && response.data.length > 0) {
                // Clear existing buttons
                $('#extracurricular-buttons').empty();

                // Loop through each extracurricular and create a button
                response.data.forEach(function(extracurricular) {
                    const button = $('<button>')
                        .addClass('btn btn-success')
                        .text('Daftar Extrakurikuler (' + extracurricular.name + ')')
                        .click(function() {
                            confirmRegistration(extracurricular.id);
                        });

                    // Append the button to the container
                    $('#extracurricular-buttons').append(button);
                });
            } else {
                $('#extracurricular-buttons').text('No Extracurricular Found').prop('disabled', true);
            }
        },
        error: function() {
            $('#extracurricular-buttons').text('Failed to load extracurricular').prop('disabled', true);
        }
    });
});

function confirmRegistration(extracurricular_id) {
    Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah anda yakin untuk mendaftar ekstrakurikuler ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Daftar!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            registerApplicant(extracurricular_id);
        }
    });
}

function registerApplicant(extracurricular_id) {
    $.ajax({
        url: '/applicant',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}', // Add CSRF token
            extracurricular_id: extracurricular_id,
            status_applicant_id: 3  // Default status (pending)
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Successfully registered for extracurricular!',
                    icon: 'success'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response.message || 'Failed to register',
                    icon: 'error'
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: xhr.responseJSON?.message || 'Failed to register applicant',
                icon: 'error'
            });
        }
    });
}
function showApplicantDetails(id) {
    $.ajax({
        url: `/applicant/${id}`,
        method: 'GET',
        success: function(response) {
            // Populate the modal fields with data from the response
            $('#detail-name').text(response.applicant.user.name);
            $('#detail-code').text(response.applicant.applicant_code);
            $('#detail-extracurricular').text(response.applicant.ekstrakurikuler.name || '-');
            $('#detail-status').text(response.applicant.statusApplicant.name);

            //apabila sudah bisa nyambung classroom
            // $('#detail-class').text(response.applicant.classroom.name);
            // Show the modal
            $('#detailApplicantModal').modal('show');
        },
        error: function(xhr) {
            console.log('Error:', xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong while fetching applicant details.'
            });
        }
    });
}



// Function to show edit modal and populate data
function editApplicant(id) {
    $.ajax({
        url: `/applicant/${applicant}/edit`,
        method: 'GET',
        success: function(response) {
            const applicant = response.applicant;
            
            // Set the applicant ID in hidden input
            $('#applicant-id').val(applicant.id);
            
            // Set selected values in dropdowns
           
            $('#edit-status').val(applicant.id_status_applicant).trigger('change');
            
            // Show the modal
            $('#editApplicantModal').modal('show');
        },
        error: function(xhr) {
            console.log('Error:', xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: xhr.responseJSON.error || 'Something went wrong while fetching applicant details.'
            });
        }
    });
}

// // Handle form submission
// $(document).ready(function() {
//     $('#edit-applicant-form').on('submit', function(e) {
//         e.preventDefault();
        
//         const id = $('#applicant-id').val();
//         const formData = {
//             extracurricular_id: $('#edit-extracurricular').val(),
//             status_applicant_id: $('#edit-status').val(),
//             _token: $('meta[name="csrf-token"]').attr('content'),
//             _method: 'PUT'
//         };

//         $.ajax({
//             url: `/applicant/${id}`,
//             method: 'POST',
//             data: formData,
//             success: function(response) {
//                 // Close the modal
//                 $('#editApplicantModal').modal('hide');
                
//                 // Show success message
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'Success!',
//                     text: response.message
//                 }).then((result) => {
//                     // Reload the page or update the table row
//                     location.reload();
//                 });
//             },
//             error: function(xhr) {
//                 console.log('Error:', xhr.responseText);
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Oops...',
//                     text: xhr.responseJSON.error || 'Something went wrong while updating applicant.'
//                 });
//             }
//         });
//     });
function confirmDelete(event, applicantId) {
    event.preventDefault(); // Prevent the form from submitting immediately

    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah anda yakin ingin menghapus pendaftar ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, submit the form programmatically
            const form = event.target; // Get the form element
            form.submit(); // Submit the form
        }
    });
}

    // Initialize Select2 if you're using it
    $('.select2').select2({
        dropdownParent: $('#editApplicantModal')
    });
// });
</script>

@endsection
