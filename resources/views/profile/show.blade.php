@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row ">

        <!-- Profile Title Card -->
        <div class="col-md-12 mb-4">
            <div class="card" style="position: relative; top: -50px; z-index: 1;">
                <div class="card-body text-center">
                    <h1 style="font-size: 40px;">{{ __('Profile') }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-1" style="position: relative; top: -100px; z-index: 1;">
            @if(Auth::user()->role->name == 'Super Admin')
                <div class="alert alert-info">
                    <strong>Hi, Superadmin!</strong> Change the information about yourself on this page.
                </div>
            @elseif(Auth::user()->role->name == 'Admin')
                <div class="alert alert-info">
                    <strong>Hi, Admin!</strong> Change the information about yourself on this page.
                </div>
            @elseif(Auth::user()->role->name == 'Coordinator')
                <div class="alert alert-info">
                    <strong>Hi, Coordinator!</strong> Change the information about yourself on this page.
                </div>
            @elseif(Auth::user()->role->name == 'Student')
                <div class="alert alert-info">
                    <strong>Hi, Student!</strong> Change the information about yourself on this page.
                </div>
            @endif
        </div>
        <!-- Informasi Pribadi Card -->
        <div class="col-12 mb-4" style="margin-top: -20px">
            <div class="card">
                <div class="card-header text-center">
   
                </div>
                <div class="card-body position-relative">
                    <!-- Display Profile Picture -->
                    <div class="text-center position-absolute" style="top: -150px; left: 50%; transform: translateX(-50%);">
                        <div id="profile-photo-container" class="position-relative" style="width: 150px; height: 150px;">
                            <!-- Profile Photo -->
                            <img id="profile-photo-display" src="{{ asset(Auth::user()->profile_photo_path) }}" alt="Profile Picture"
                                class="rounded-circle border border-white" width="150" height="150"
                                style="cursor: {{ Auth::user()->profile_photo_path !== 'https://freesvg.org/img/abstract-user-flat-4.png' ? 'pointer' : 'default' }}; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);"
                                onclick="{{ Auth::user()->profile_photo_path !== 'https://freesvg.org/img/abstract-user-flat-4.png' ? 'confirmRemoveProfilePhoto()' : '' }}">
                            <!-- Remove icon overlay (optional for better UX) -->
                            @if(Auth::user()->profile_photo_path !== 'https://freesvg.org/img/abstract-user-flat-4.png')
                                <div class="position-absolute" style="top: 0; right: 0; width: 30px; height: 30px; background: rgba(0, 0, 0, 0.5); border-radius: 50%;">
                                    <i class="fa fa-times text-white" style="line-height: 30px;"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                  <!-- Button to Open Modal for Photo Upload -->
                  <div class="text-center mt-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadPhotoModal">
                        Upload Foto Profil
                    </button>
                </div>
                <div class="text-center ml-1 mt-2 pt-5 mb-5">
                <h5 style="font-size: 16px; color: #6777ef">{{ __('Informasi Pribadi') }}</h5>
                </div>
                    <!-- Display Profile Information in 2x2 Grid -->
                    <div class="row ml-3 mt-2 pt-2">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <h5><strong>Nama</strong></h5>
                                <p>{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <h5><strong>Email</strong></h5>
                                <p>{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <h5><strong>Peran</strong></h5>
                                <p>{{ Auth::user()->role->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <h5><strong>NISN/NIP</strong></h5>
                                <p>{{ Auth::user()->NISN_NIP }}</p>
                            </div>
                        </div>

                        <!-- Additional Information Based on Role -->
                        @if(Auth::user()->role->name == 'Super Admin')
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Sekolah yang Ditugaskan</strong></h5>
                                    <p>Semua Sekolah</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Hak Akses</strong></h5>
                                    <p>Akses penuh ke seluruh sistem</p>
                                </div>
                            </div>
                        @elseif(Auth::user()->role->name == 'Admin')
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Sekolah yang Ditugaskan</strong></h5>
                                    <p>Springfield Elementary</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Hak Akses</strong></h5>
                                    <p>Manajemen sekolah dan guru</p>
                                </div>
                            </div>
                        @elseif(Auth::user()->role->name == 'Coordinator')
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Ekstrakurikuler</strong></h5>
                                    <p>Basket</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Sekolah</strong></h5>
                                    <p>Springfield Elementary</p>
                                </div>
                            </div>
                        @elseif(Auth::user()->role == 'student')
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Kelas</strong></h5>
                                    <p>10-A</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Jurusan</strong></h5>
                                    <p>IPA</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Ekstrakurikuler</strong></h5>
                                    <p>Badminton</p>
                                </div>
                            </div>
                        @endif
                    </div>

  
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <!-- Edit Profile Card -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5>Edit Profile</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
        
                <!-- Update Password Card -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5>Update Password</h5>
                        </div>
                        <div class="card-body">
                            <form id="updatePasswordForm" method="POST" action="{{ route('profile.password.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script>
    function confirmRemoveProfilePhoto() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to remove your profile photo?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                removeProfilePhoto();
            }
        });
    }

    function removeProfilePhoto() {
        $.ajax({
            url: '{{ route('profile.deletePhoto') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error);
            }
        });
    }

        // AJAX Password Update
        document.addEventListener('DOMContentLoaded', function () {
    const updateProfileForm = document.getElementById('updateProfileForm');
    if (updateProfileForm) {
        updateProfileForm.onsubmit = function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to save the changes?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit the form if confirmed
                }
            });
        };
    }

    const updatePasswordForm = document.getElementById('updatePasswordForm');
    if (updatePasswordForm) {
        updatePasswordForm.onsubmit = function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update your password?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit the form if confirmed
                }
            });
        };
    }


    const passwordForm = document.querySelector('form[action="{{ route('profile.password.update') }}"]');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('{{ route('profile.password.update') }}', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: data.error,
                    });
                } else if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.success,
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    } else {
        console.error('Password form not found');
    }
});

</script>

<!-- Include the Modal Here -->
@include('modals.upload-photo-modal')
@endsection
