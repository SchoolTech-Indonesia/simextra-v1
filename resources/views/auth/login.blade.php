@extends('layouts.guest')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="login-brand">
              <img src="{{ asset('assets/img/logo/SchoolTech-Logo1.png') }}" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Login') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        @csrf

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="NISN_NIP">{{ __('NISN/NIP') }}</label>
                            <input id="NISN_NIP" type="text" class="form-control @error('NISN_NIP') is-invalid @enderror" name="NISN_NIP" value="{{ old('NISN_NIP') }}" required autofocus>
                            @error('NISN_NIP')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <a href="{{ route('password.forgot.form') }}" class="text-decoration-none">
                                {{ __('Lupa Password?') }}
                            </a>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                                {{ __('Masuk') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
