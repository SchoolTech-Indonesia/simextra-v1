@extends('layouts.app') {{-- Assuming this is your main Stisla layout --}}

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Profile') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Permissions List') }}</h4>
                        <div class="card-header-action">
                            <!-- Button to trigger the modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPermissionModal">
                                {{ __('Add Permission') }}
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th>{{ __('Permission Slug') }}</th>
                                        <th>{{ __('Permission Name') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="permissionTable">
                                    @foreach($permissions as $permission)
                                    <tr id="permission-{{ $permission->id }}">
                                        <td>{{ $permission->slug }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        {{-- Optional: Add pagination or other actions --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Create Permission Modal -->
<div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPermissionModalLabel">{{ __('Create Permission') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createPermissionForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('Permission Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Permission Slug') }}</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Generate slug from permission name
        $('#name').on('input', function() {
            let slug = $(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            $('#slug').val(slug);
        });

        // Handle form submission
        $('#createPermissionForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route("permissions.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Append the new permission to the table
                    $('#permissionTable').append(`
                        <tr id="permission-${response.id}">
                            <td>${response.slug}</td>
                            <td>${response.name}</td>
                            <td>
                                <a href="{{ route('permissions.edit', '') }}/${response.id}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                                <form action="{{ route('permissions.destroy', '') }}/${response.id}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    `);

                    // Close the modal and reset the form
                    $('#createPermissionModal').modal('hide');
                    $('#createPermissionForm')[0].reset();

                    // Optionally, show a success message
                    alert('Permission created successfully.');
                },
                error: function(xhr) {
                    // Handle errors here
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>
@endsection
