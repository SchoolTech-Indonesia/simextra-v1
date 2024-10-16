@extends('layouts.app')

@section('content')
<h1>Presensi List</h1>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">Create Presensi</button>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($presensi as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->start_date }}</td>
            <td>{{ $item->end_date }}</td>
            <td>
                <button class="btn btn-warning" data-toggle="modal" data-target="#editModal" data-id="{{ $item->uuid }}" data-name="{{ $item->name }}" data-start="{{ $item->start_date }}" data-end="{{ $item->end_date }}">Edit</button>
                <form action="{{ route('presensi.destroy', $item->uuid) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
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
                    <input type="text" name="name" placeholder="Name" required class="form-control">
                    <input type="datetime-local" name="start_date" required class="form-control mt-2">
                    <input type="datetime-local" name="end_date" required class="form-control mt-2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Presensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="uuid" id="editUuid">
                    <input type="text" name="name" id="editName" required class="form-control" placeholder="Name">
                    <input type="datetime-local" name="start_date" id="editStartDate" required class="form-control mt-2">
                    <input type="datetime-local" name="end_date" id="editEndDate" required class="form-control mt-2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var name = button.data('name');
        var start = button.data('start');
        var end = button.data('end');

        var modal = $(this);
        modal.find('#editUuid').val(id);
        modal.find('#editName').val(name);
        modal.find('#editStartDate').val(start);
        modal.find('#editEndDate').val(end);
        modal.find('form').attr('action', '/admin/presensi/' + id);
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        if(confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    location.reload();
                }
            });
        }
    });
</script>
@endsection
