@extends('layouts.guest')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Verify OTP') }}</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-sm text-gray-600">
                        {{ __('Enter the OTP you received to verify your identity.') }}
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('otp.verify') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-group">
                            <label for="otp">{{ __('OTP') }}</label>
                            <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" required autofocus>
                            @error('otp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('Verify OTP') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
