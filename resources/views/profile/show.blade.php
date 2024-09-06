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
                    <!-- Informasi Profil -->
                    <div class="mb-4">
                        <h5>Informasi Pribadi</h5>
                        
                        <!-- Display Profile Picture -->
                        <div class="mb-4 text-center">
                            <img id="profile-photo-display" src="{{ Auth::user()->profile_photo_url }}" alt="Profile Picture" class="rounded-circle" width="150" height="150">
                        </div>
                        
                        <!-- Button to Open Modal for Photo Upload -->
                        <div class="mb-4 text-center">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadPhotoModal">
                                Upload Foto Profil
                            </button>
                        </div>

                        <ul class="list-group">
                            <li class="list-group-item"><strong>Nama:</strong> {{ Auth::user()->name }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ Auth::user()->email }}</li>
                            <li class="list-group-item"><strong>Peran:</strong> {{ Auth::user()->role }}</li>
                            <li class="list-group-item"><strong>NISN/NIP:</strong> {{ Auth::user()->NISN_NIP }}</li>

                            <!-- Menampilkan informasi tambahan berdasarkan peran pengguna -->
                            @if(Auth::user()->role == 'superadmin')
                                <li class="list-group-item"><strong>Sekolah yang Ditugaskan:</strong> Semua Sekolah</li>
                                <li class="list-group-item"><strong>Hak Akses:</strong> Akses penuh ke seluruh sistem</li>
                            @elseif(Auth::user()->role == 'admin')
                                <li class="list-group-item"><strong>Sekolah yang Ditugaskan:</strong> Springfield Elementary</li> <!-- Contoh sekolah yang ditugaskan -->
                                <li class="list-group-item"><strong>Hak Akses:</strong> Manajemen sekolah dan guru</li>
                            @elseif(Auth::user()->role == 'coordinator')
                                <li class="list-group-item"><strong>Ekstrakurikuler:</strong> Basket</li> <!-- Contoh ekstrakurikuler yang diampu -->
                                <li class="list-group-item"><strong>Sekolah:</strong> Springfield Elementary</li> <!-- Contoh sekolah -->
                            @elseif(Auth::user()->role == 'student')
                                <li class="list-group-item"><strong>Kelas:</strong> 10-A</li> <!-- Contoh kelas -->
                                <li class="list-group-item"><strong>Jurusan:</strong> IPA</li> <!-- Contoh jurusan -->
                                <li class="list-group-item"><strong>Ekstrakurikuler:</strong> Badminton</li> <!-- Contoh jurusan -->
                            @endif
                        </ul>
                    </div>

                    <!-- Fitur Update Informasi Profil -->
                    <div class="section-title mt-3">
                        <h5>{{ __('Update Profile Information') }}</h5>
                    </div>
                    <div class="section-content">
                        @livewire('profile.update-profile-information-form')
                    </div>

                    <!-- Fitur Update Kata Sandi -->
                    <div class="section-divider my-4"></div>
                    <div class="section-title mt-3">
                        <h5>{{ __('Update Password') }}</h5>
                    </div>
                    <div class="section-content">
                        @livewire('profile.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- 
                    <!-- Fitur Two-Factor Authentication -->
                    <div class="section-divider my-4"></div>
                    <div class="section-title mt-3">
                        <h5>{{ __('Two-Factor Authentication') }}</h5>
                    </div>
                    <div class="section-content">
                        @livewire('profile.two-factor-authentication-form')
                    </div>

                    <!-- Fitur Logout dari Sesi Browser Lain -->
                    <div class="section-divider my-4"></div>
                    <div class="section-title mt-3">
                        <h5>{{ __('Logout Other Browser Sessions') }}</h5>
                    </div>
                    <div class="section-content">
                        @livewire('profile.logout-other-browser-sessions-form')
                    </div>

                    <!-- Fitur Penghapusan Akun -->
                    <div class="section-divider my-4"></div>
                    <div class="section-title mt-3">
                        <h5>{{ __('Delete Account') }}</h5>
                    </div>
                    <div class="section-content">
                        @livewire('profile.delete-user-form')
                    </div> --}}
                {{-- </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- Include the Modal Here -->
@include('modals.upload-photo-modal')
@endsection