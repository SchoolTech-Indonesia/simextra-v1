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
                    <input type="text" name="search" class="form-control" placeholder="Search by major name or code" value="{{ request('search') }}">
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
                                <th>Koordinator</th>
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
                                    {{-- Waiting for classroom tables... --}}
                                    {{-- @if($major->classrooms->isEmpty())
                                        -
                                    @else
                                        @foreach($major->classrooms as $classroom)
                                            {{ $classroom->class_name }} ({{ $classroom->class_code }})
                                            @if(!$loop->last), @endif
                                        @endforeach
                                    @endif --}}
                                </td>
                                <td class="align-middle">
                                    <!-- Action buttons here -->
                                    <button class="btn btn-icon btn-info" data-id="{{ $major->id }}" data-toggle="modal" data-target="#detailMajorsModal" onclick="showMajorDetails({{ $major->id }})">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    <button class="btn btn-icon btn-primary" data-id="{{ $major->id }}" data-toggle="modal" data-target="#editMajorsModal" onclick="editMajor({{ $major->id }})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <form action="{{ route('majors.destroy', $major->id) }}" method="POST" style="display:inline;" onsubmit="return deleteMajor(event, this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No Majors Found</td>
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
            
            let coordinators = response.major.koordinator.map(koor => koor.name).join(', ');
            $('#detail-major-koordinator').text(coordinators);

            let classes = response.major.classrooms.map(classroom => `${classroom.class_name} (${classroom.class_code})`).join(', ');
            $('#detail-major-classes').text(classes);

            $('#detailMajorsModal').modal('show');
        }
    });
}
</script>
@endsection