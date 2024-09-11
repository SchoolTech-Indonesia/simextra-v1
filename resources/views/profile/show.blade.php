@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Profile') }}</h4>
                </div>
                <div class="card-body">
                    <!-- Profile Information Update Form -->
                    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                        <div class="section-title mt-3">
                            <h5>{{ __('Update Profile Information') }}</h5>
                        </div>
                        @livewire('profile.update-profile-information-form')
                        <div class="section-divider"></div>
                    @endif

                    <!-- Password Update Form -->
                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                        <div class="section-title mt-3">
                            <h5>{{ __('Update Password') }}</h5>
                        </div>
                        @livewire('profile.update-password-form')
                        <div class="section-divider"></div>
                    @endif

                    <!-- Two-Factor Authentication -->
                    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                        <div class="section-title mt-3">
                            <h5>{{ __('Two-Factor Authentication') }}</h5>
                        </div>
                        @livewire('profile.two-factor-authentication-form')
                        <div class="section-divider"></div>
                    @endif

                    <!-- Logout Other Browser Sessions -->
                    <div class="section-title mt-3">
                        <h5>{{ __('Logout Other Browser Sessions') }}</h5>
                    </div>
                    @livewire('profile.logout-other-browser-sessions-form')

                    <!-- Account Deletion -->
                    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                        <div class="section-divider mt-3"></div>
                        <div class="section-title mt-3">
                            <h5>{{ __('Delete Account') }}</h5>
                        </div>
                        @livewire('profile.delete-user-form')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
