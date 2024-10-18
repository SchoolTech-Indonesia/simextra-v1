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
                                <td>{{ $applicant->extracurricular->name ?? '-' }}</td>
                                <td>{{ $applicant->statusApplicant->name }}</td>
                                <td class="align-middle">
                                    <button class="btn btn-primary btn-detail" data-id="{{ $applicant->id }}" data-toggle="modal" data-target="#detailApplicantModal">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-icon btn-primary" data-id="{{ $applicant->id }}" data-toggle="modal" data-target="#editApplicantModal" onclick="editApplicant({{ $applicant->id }})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <form action="{{ route('applicant.destroy', $applicant->id) }}" method="POST" style="display:inline;" onsubmit="return deleteApplicant(event, this);">
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
    <div class="text-center">
        <button id="register-extracurricular-btn" class="btn btn-success">Loading...</button>
    </div>
</div>

{{-- EDIT APPLICANT --}}
<div class="modal fade" id="editApplicantModal" tabindex="-1" role="dialog" aria-labelledby="editApplicantModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="editApplicantModalLabel">Edit Applicant</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form id="edit-applicant-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="applicant-id">
                <div class="form-group">
                    <label for="edit-applicant-name">Applicant Name</label>
                    <input type="text" name="name" class="form-control" id="edit-applicant-name" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <label for="edit-extracurricular">Assign Extracurricular</label>
                    <select name="extracurricular_id" class="form-control select2" id="edit-extracurricular" required>
                        @foreach($extracurriculars as $extracurricular)
                            <option value="{{ $extracurricular->id }}">{{ $extracurricular->name }}</option>
                        @endforeach
                    </select>

                    <label for="edit-status">Application Status</label>
                    <select name="status_applicant_id" class="form-control select2" id="edit-status" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
      </div>
  </div>
</div>

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
                <p><strong>Name:</strong> <span id="applicant-name-detail"></span></p>
                <p><strong>Extracurricular:</strong> <span id="applicant-extracurricular-detail"></span></p>
                <p><strong>Status:</strong> <span id="applicant-status-detail"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $.ajax({
        url: '/api/extracurriculars',
        type: 'GET',
        success: function(response) {
            const extracurricular = response.data[0]; 
                $('#register-extracurricular-btn').text('Daftar Extrakurikuler (' + extracurricular.name + ')');
                $('#register-extracurricular-btn').click(function() {
                    
                    registerApplicant(extracurricular.id);
                });
            } else {
                $('#register-extracurricular-btn').text('No Extracurricular Found');
            }
        },
        error: function() {
            $('#register-extracurricular-btn').text('Failed to load extracurricular');
        }
    });
});

function registerApplicant(extracurricularId) {
    $.ajax({
        url: '/applicant', /
        type: 'POST',
        data: {
            extracurricular_id: extracurricularId,
            status_applicant_id: 1, 
        success: function() {
            alert('Successfully registered!');
            location.reload(); 
        },
        error: function() {
            alert('Failed to register applicant');
        }
    });
}
</script>

@endsection
