@extends('layouts.app')

@section('title', 'Manajemen Ekstra')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>Extra Management</h1>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.extras.index') }}">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" style="max-width: 500px; width: 100%;" placeholder="Search Nama Ekstra" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <!-- Button to Add Extra -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#extraModal">
                Create New Extra
            </button>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Ekstra</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Nama Ekstra</th>
                                            <th>Logo</th>
                                            <th>Koordinator</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($extras as $index => $extra)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $extra->name }}</td>
                                                <td><img src="{{ asset('storage/' . $extra->logo) }}" alt="{{ $extra->name }}" width="50"></td>
                                                <td>
                                                    @foreach($extra->coordinators as $coordinator)
                                                        {{ $coordinator->name }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#editExtraModal{{ $extra->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('extras.destroy', $extra->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ekstra ini?')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
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

    <!-- Modal Tambah Ekstra -->
    <div class="modal fade" id="extraModal" tabindex="-1" role="dialog" aria-labelledby="extraModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="extraModalLabel">Create New Extra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.extras.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Ekstra</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control-file" id="logo" name="logo">
                        </div>
                        <div class="form-group">
                            <label for="coordinators">Koordinator</label>
                            <select multiple class="form-control" id="coordinators" name="coordinators[]" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Ekstra -->
    @foreach($extras as $extra)
        <div class="modal fade" id="editExtraModal{{ $extra->id }}" tabindex="-1" role="dialog" aria-labelledby="editExtraModalLabel{{ $extra->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editExtraModalLabel{{ $extra->id }}">Edit Ekstra</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('extras.update', $extra->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit_name{{ $extra->id }}">Nama Ekstra</label>
                                <input type="text" class="form-control" id="edit_name{{ $extra->id }}" name="name" value="{{ $extra->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_logo{{ $extra->id }}">Logo</label>
                                <input type="file" class="form-control-file" id="edit_logo{{ $extra->id }}" name="logo">
                                @if($extra->logo)
                                    <img src="{{ asset('storage/' . $extra->logo) }}" alt="{{ $extra->name }}" width="50" class="mt-2">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="edit_coordinators{{ $extra->id }}">Koordinator</label>
                                <select multiple class="form-control" id="edit_coordinators{{ $extra->id }}" name="coordinators[]" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $extra->coordinators->contains($user->id) ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection