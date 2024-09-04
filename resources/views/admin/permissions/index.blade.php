@extends('layouts.app')

@section('content')
<div class="container">
    <section class="section">
        <div class="section-header">
            <h1>Permission Management</h1>
        </div>

        <div class="section-body">
        </div>
    </section>
    
    <div class="card-header-action">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPermissionsModal">Create Permission</button>
    </div>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Permission List</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Permission Slug</th>
                      <th>Permission Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i= 1 ?>
                    @foreach($permissions as $permission)
                    <tr>
                      <td class="text-center"><?= $i ?></td>
                      <td>{{ $permission->slug }}</td>
                      <td>{{ $permission->name }}</td>
                      <td class="align-middle">
                        <button class="btn btn-primary btn-detail" data-id="{{ $permission->id }}" data-toggle="modal" data-target="#detailPermissionsModal">
                          <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-icon btn-primary" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}" data-slug="{{ $permission->slug }}" data-toggle="modal" data-target="#editPermissionsModal" onclick="editPermission({{ $permission->id }})">
                          <i class="far fa-edit"></i>
                        </button>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></button>
                        </form>
                      </td>
                    </tr>
                    <?php $i++ ?>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer text-right">
                {{-- Optional: Add pagination or other actions --}}
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

{{-- Add Permissions Modal --}}
<div class="modal fade" id="addPermissionsModal" tabindex="-1" role="dialog" aria-labelledby="addPermissionsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addPermissionsModalLabel">Create New Permission</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            {{-- Form to add Permission --}}
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="permission-slug">Permission Slug</label>
                    <input type="text" name="slug" class="form-control" id="permission-slug" required>
                </div>
                <div class="form-group">
                    <label for="permission-name">Permission Name</label>
                    <input type="text" name="name" class="form-control" id="permission-name" required>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </form>
          </div>
      </div>
  </div>
</div>

{{-- Edit Permissions Modal --}}
<div class="modal fade" id="editPermissionsModal" tabindex="-1" role="dialog" aria-labelledby="editPermissionsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="editPermissionsModalLabel">Edit Permission</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form id="edit-permission-form" action="{{ route('permissions.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="permission-id">
                    <div class="form-group">
                        <label for="edit-permission-slug">Permission Slug</label>
                        <input type="text" name="slug" class="form-control" id="edit-permission-slug" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-permission-name">Permission Name</label>
                        <input type="text" name="name" class="form-control" id="edit-permission-name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
          </div>
      </div>
  </div>
</div>

{{-- Detail Permission Modal --}}
<div class="modal fade" id="detailPermissionsModal" tabindex="-1" role="dialog" aria-labelledby="detailPermissionsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="detailPermissionsModalLabel">Permission Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <h5 id="permission-name"></h5>
              <p><strong>Slug:</strong> <span id="permission-slug"></span></p>
          </div>
      </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select permissions",  
        allowClear: true  
    });
});

function editPermission(id) {
    $.ajax({
        url: '/admin/permissions/' + id + '/edit',
        type: 'GET',
        success: function(response) {
            $('#permission-id').val(response.permission.id);
            $('#edit-permission-slug').val(response.permission.slug);
            $('#edit-permission-name').val(response.permission.name);

            $('#edit-permission-form').attr('action', '/admin/permissions/' + id);
        }
    });
}


$('.btn-detail').click(function() {
    var permissionId = $(this).data('id');
    $.ajax({
        url: '/admin/permissions/' + permissionId,
        type: 'GET',
        success: function(response) {
            $('#permission-name').text(response.permission.name);
            $('#permission-slug').text(response.permission.slug);
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
});
</script>
@endsection
