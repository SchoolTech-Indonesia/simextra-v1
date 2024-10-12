@extends('layouts.guest')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Forgot Password') }}</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-sm text-gray-600">
                        {{ __('Masukkan NISN Anda Jika Lupa Password Akun, Pastikan Email Terdaftar Dalam Sistem Sehingga Kode OTP Dapat Masuk Ke Email Anda') }}
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

                    <div class="form-group">
                        <a href="/login" class="text-decoration-none">
                            {{ __('Kembali Login?') }}
                        </a>
                    </div>
                    <form method="POST" action="{{ route('password.forgot') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-group">
                            <label for="NISN_NIP">{{ __('NISN/NIP') }}</label>
                            <input id="NISN_NIP" type="text" class="form-control @error('NISN_NIP') is-invalid @enderror" name="NISN_NIP" value="{{ old('NISN_NIP') }}" required autofocus>
                            @error('NISN_NIP')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('Send OTP') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
