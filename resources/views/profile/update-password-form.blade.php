<div class="card">
    <div class="card-header">
        <h4>{{ __('Update Password') }}</h4>
        <p>{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="updatePassword">
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

            <div class="d-flex justify-content-end">
                @if (session()->has('saved'))
                    <div class="alert alert-success me-3" role="alert">
                        {{ __('Saved.') }}
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>
</div>
