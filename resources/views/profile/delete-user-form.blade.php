<div class="section">
    <div class="section-header">
        <h1>{{ __('Delete Account') }}</h1>
    </div>

    <div class="section-body">
        <div class="alert alert-warning">
            {{ __('Permanently delete your account.') }}
        </div>

        <p class="text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>

        <button class="btn btn-danger mt-3" onclick="confirmUserDeletion()">
            {{ __('Delete Account') }}
        </button>

        <!-- Delete User Confirmation Modal -->
        <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountModalLabel">{{ __('Delete Account') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                        <div class="form-group mt-4">
                            <input type="password" class="form-control" placeholder="{{ __('Password') }}" id="deleteAccountPassword">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="button" class="btn btn-danger" onclick="deleteUser()">{{ __('Delete Account') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmUserDeletion() {
        $('#deleteAccountModal').modal('show');
    }

    function deleteUser() {
        // Logic to delete the user
        $('#deleteAccountModal').modal('hide');
    }
</script>
