<div class="section">
    <div class="section-header">
        <h1>{{ __('Browser Sessions') }}</h1>
    </div>

    <div class="section-body">
        <div class="alert alert-warning">
            {{ __('Manage and log out your active sessions on other browsers and devices.') }}
        </div>

        <p class="text-muted">
            {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
        </p>

        @if (count($this->sessions) > 0)
            <div class="mt-4">
                <!-- Other Browser Sessions -->
                @foreach ($this->sessions as $session)
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            @if ($session->agent->isDesktop())
                                <i class="fas fa-desktop fa-2x text-secondary"></i>
                            @else
                                <i class="fas fa-mobile-alt fa-2x text-secondary"></i>
                            @endif
                        </div>

                        <div class="ms-3">
                            <div class="text-sm text-muted">
                                {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} - {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                            </div>

                            <div class="text-xs text-muted">
                                {{ $session->ip_address }},

                                @if ($session->is_current_device)
                                    <span class="text-success font-weight-bold">{{ __('This device') }}</span>
                                @else
                                    {{ __('Last active') }} {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="d-flex align-items-center mt-4">
            <button class="btn btn-primary" onclick="confirmLogout()">
                {{ __('Log Out Other Browser Sessions') }}
            </button>

            <span class="ms-3 text-success" id="actionMessage" style="display: none;">
                {{ __('Done.') }}
            </span>
        </div>

        <!-- Log Out Other Devices Confirmation Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">{{ __('Log Out Other Browser Sessions') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}

                        <div class="form-group mt-4">
                            <input type="password" class="form-control" id="logoutPassword" placeholder="{{ __('Password') }}">
                        </div>
                        <div class="text-danger" id="passwordError" style="display: none;">
                            {{ __('Incorrect password.') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="button" class="btn btn-primary" onclick="logoutOtherBrowserSessions()">{{ __('Log Out Other Browser Sessions') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmLogout() {
        $('#logoutModal').modal('show');
    }

    function logoutOtherBrowserSessions() {
        var password = document.getElementById('logoutPassword').value;

        // Add your logic for logout here...

        $('#logoutModal').modal('hide');
        document.getElementById('actionMessage').style.display = 'inline-block';
    }
</script>
