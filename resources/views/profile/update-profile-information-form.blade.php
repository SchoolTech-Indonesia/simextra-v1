<div class="card">
    <div class="card-header">
        <h4>{{ __('Profile Information') }}</h4>
    </div>

    <div class="card-body">
        <p class="text-muted">{{ __('Update your account\'s profile information and email address.') }}</p>

        <form wire:submit.prevent="updateProfileInformation">
            <!-- Profile Photo -->
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div x-data="{photoName: null, photoPreview: null}" class="form-group">
                    <!-- Profile Photo File Input -->
                    <input type="file" id="photo" class="d-none"
                           wire:model.live="photo"
                           x-ref="photo"
                           x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                           " />

                    <label for="photo" class="form-label">{{ __('Photo') }}</label>

                    <!-- Current Profile Photo -->
                    <div class="mt-2" x-show="! photoPreview">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-circle" style="height: 80px; width: 80px; object-fit: cover;">
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <span class="block rounded-circle" style="height: 80px; width: 80px; background-image: url('{{ photoPreview }}'); background-size: cover; background-position: center;">
                        </span>
                    </div>

                    <button type="button" class="btn btn-secondary mt-2" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select A New Photo') }}
                    </button>

                    @if ($this->user->profile_photo_path)
                        <button type="button" class="btn btn-secondary mt-2" wire:click="deleteProfilePhoto">
                            {{ __('Remove Photo') }}
                        </button>
                    @endif

                    <div class="text-danger mt-2" x-show="$errors.has('photo')">
                        @error('photo') {{ $message }} @enderror
                    </div>
                </div>
            @endif

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input id="name" type="text" class="form-control" wire:model="state.name" required autocomplete="name">
                <div class="text-danger mt-2" x-show="$errors.has('state.name')">
                    @error('state.name') {{ $message }} @enderror
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control" wire:model="state.email" required autocomplete="username">
                <div class="text-danger mt-2" x-show="$errors.has('state.email')">
                    @error('state.email') {{ $message }} @enderror
                </div>

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                    <p class="text-sm mt-2">
                        {{ __('Your email address is unverified.') }}

                        <button type="button" class="btn btn-link text-muted" wire:click.prevent="sendEmailVerification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if ($this->verificationLinkSent)
                        <p class="mt-2 text-success font-weight-bold text-sm">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                @endif
            </div>

            <div class="form-group mt-3">
                @if (session()->has('saved'))
                    <div class="alert alert-success">
                        {{ __('Saved.') }}
                    </div>
                @endif

                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="photo">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>
</div>
