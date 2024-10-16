@extends('layouts.app')
@section('content')
    <div class="container">
        <section class="section">
            <div class="section-header">
                <h1>Presensi List</h1>
            </div>

            <div class="mb-3">
                <form action="{{ route('presensi.index') }}" method="GET">
                    <input type="text" name="search" class="form-control" placeholder="Search Name Presensi"
                        aria-label="Search" value="{{ request()->get('search') }}">
                    <button type="submit" class="btn btn-primary mt-2">Search</button>
                </form>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#createModal">Create
                    New Presensi</button>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Presensi</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Nama </th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($presensi as $index => $presen)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $presen->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($presen->start_date)->format('Y-m-d H:i') }}
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($presen->end_date)->format('Y-m-d H:i') }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-icon btn-primary" data-toggle="modal"
                                                            data-target="#editModal{{ $presen->uuid }}"><i
                                                                class="fas fa-edit"></i></button>

                                                        <button type="button" class="btn btn-icon btn-danger delete-btn"
                                                            data-id="{{ $presen->uuid }}">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <form action="{{ route('presensi.destroy', $presen->uuid) }}"
                                                            method="POST" style="display: inline;" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Create Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('presensi.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Create Presensi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name Presensi</label>
                                <input type="text" name="name" id="name" placeholder="Name" required
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="datetime-local" name="start_date" id="start_date" required
                                    class="form-control mt-2">
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="datetime-local" name="end_date" id="end_date" required
                                    class="form-control mt-2">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Modal -->
        @foreach ($presensi as $presen)
            <div class="modal fade" id="editModal{{ $presen->uuid }}" tabindex="-1" role="dialog"
                aria-labelledby="editModalLabel{{ $presen->uuid }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('presensi.update', $presen->uuid) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $presen->uuid }}">Edit Presensi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name{{ $presen->uuid }}">Name Presensi</label>
                                    <input type="text" name="name" id="name{{ $presen->uuid }}"
                                        placeholder="Name" value="{{ $presen->name }}" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="start_date{{ $presen->uuid }}">Start Date</label>
                                    <input type="datetime-local" name="start_date" id="start_date{{ $presen->uuid }}"
                                        value="{{ \Carbon\Carbon::parse($presen->start_date)->format('Y-m-d\TH:i') }}"
                                        required class="form-control mt-2">
                                </div>
                                <div class="form-group">
                                    <label for="end_date{{ $presen->uuid }}">End Date</label>
                                    <input type="datetime-local" name="end_date" id="end_date{{ $presen->uuid }}"
                                        value="{{ \Carbon\Carbon::parse($presen->end_date)->format('Y-m-d\TH:i') }}"
                                        required class="form-control mt-2">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach


        <script>
            $(document).ready(function() {
                $('.delete-btn').on('click', function(e) {
                    e.preventDefault();
                    var presensiUuid = $(this).data('uuid');
                    var form = $(this).closest('tr').find('.delete-form');

                    Swal.fire({
                        title: 'Apakah Anda Yakin ?',
                        text: "Apakah Anda Yakin Ingin Menghapus presensi ini?",
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
                                        'Presensi Berhasil Dihapus',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Error!',
                                        'Presensi Gagal Dihapus!.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            });
        </script>
    </div>
@endsection
