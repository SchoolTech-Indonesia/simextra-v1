<div class="card">
    <div class="card-header">
        <h4>{{ __('Update Password') }}</h4>
    </div>
    <div class="card-body">
        <form id="password-form" wire:submit.prevent="updatePassword">
            <!-- Password fields -->
            <div class="row mb-3">
                <label for="current_password" class="col-sm-3 col-form-label">{{ __('Current Password') }}</label>
                <div class="col-sm-9">
                    <input type="password" id="current_password" class="form-control" wire:model="state.current_password" autocomplete="current-password">
                    @error('state.current_password')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-sm-3 col-form-label">{{ __('New Password') }}</label>
                <div class="col-sm-9">
                    <input type="password" id="password" class="form-control" wire:model="state.password" autocomplete="new-password">
                    @error('state.password')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password_confirmation" class="col-sm-3 col-form-label">{{ __('Confirm Password') }}</label>
                <div class="col-sm-9">
                    <input type="password" id="password_confirmation" class="form-control" wire:model="state.password_confirmation" autocomplete="new-password">
                    @error('state.password_confirmation')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Submit button -->
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" id="save-password-button">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('save-password-button').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default form submission
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to save the new password?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    document.getElementById('password-form').submit();
                }
            });
        });

        window.addEventListener('password-updated', event => {
            Swal.fire({
                icon: event.detail.type,
                title: event.detail.title,
                text: event.detail.text,
            });
        });
    </script>
@endpush
